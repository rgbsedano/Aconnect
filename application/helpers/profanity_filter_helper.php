<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profanity Filter Helper with Database Caching
 * Uses a local Ollama model to detect and censor profanities across multiple languages
 * Stores results in database cache to avoid redundant API calls
 */

/**
 * Simple multilingual profanity list for fallback filtering (when API fails)
 */
function _get_simple_profanity_list() {
    return [
        // Filipino profanities
        'gago', 'tangina', 'putang', 'puta', 'bobo', 'tanga', 'patos', 'gata', 
        'iyak', 'kingina', 'punyeta', 'pakshet', 'pakshit', 'bastos', 'layunin',
        'hudas', 'taksil', 'judas', 'mga putang ina', 'putang-ina', 'tangina mo',
        'gago ka', 'bobo ka', 'tanga ka', 'bastos na', 'mabastos', 'foulupinos',
        // English profanities
        'fuck', 'shit', 'ass', 'bitch', 'damn', 'crap', 'piss', 'hell',
        'bastard', 'slut', 'whore', 'dick', 'pussy', 'asshole', 'bloody',
        'bollocks', 'bugger', 'arse', 'twat', 'wanker', 'shag', 'sod',
        'cock', 'fuck', 'fucks', 'fucked', 'fucker', 'fucking',
        'shit', 'shits', 'shitty', 'shitting',
        'damn', 'damned', 'dammit', 'damnit',
        // Spanish
        'mierda', 'joder', 'cabron', 'cabrona', 'puta madre', 'gilipollas', 'cojones', 'hijo de puta',
        'pendejo', 'maricon', 'sudaca', 'prieto', 'veneco', 'malparido',
        // Chinese (simplified/traditional + pinyin slang) - EXPANDED
        '操', '草', '他妈', '你妈', '妈的', '傻逼', '傻b', '煞笔', '王八蛋', '去死', '干你娘',
        '肏', '肏你妈', '混蛋', '屌丝', '贱人', '滚蛋', '支那', '死全家', '畜生',
        'cao ni ma', 'cao', 'sha bi', 'wang ba dan', 'hun dan', 'diao si', 'jian ren', 'gun dan', 'zhi na',
        // Portuguese
        'porra', 'caralho', 'merda', 'cacete', 'fdp', 'filho da puta',
        // French
        'merde', 'putain', 'connard', 'connasse', 'salope',
        // German
        'scheisse', 'arschloch', 'miststuck', 'hurensohn',
        // Italian
        'cazzo', 'merda', 'stronzo', 'vaffanculo',
        // Indonesian / Malay
        'anjing', 'bangsat', 'kontol', 'memek', 'bajingan', 'sialan',
        // Turkish
        'amk', 'orospu', 'pic', 'siktir',
        // Russian (latin transliteration)
        'blyat', 'suka', 'pizdec', 'nahui',
        // Hindi / Urdu (latin transliteration)
        'madarchod', 'bhenchod', 'chutiya', 'harami',
        // Common internet shorthand variants
        'wtf', 'stfu', 'gtfo'
    ];
}

/**
 * Simple fallback profanity censoring (when API is unavailable)
 * Censors known profanities with asterisks
 */
function _simple_censor_profanities($text) {
    if (empty($text)) {
        return ['is_profane' => false, 'censored_text' => $text, 'detected_words' => []];
    }
    
    $profanities = _get_simple_profanity_list();
    $detected = [];
    $censored = $text;
    $text_lower = mb_strtolower($text, 'UTF-8');
    
    foreach ($profanities as $word) {
        if (empty($word)) continue;
        
        $word_lower = mb_strtolower($word, 'UTF-8');
        $pattern = null;
        
        // Check if word is CJK (Chinese, Japanese, Korean)
        $has_cjk = preg_match('/[\x{4E00}-\x{9FFF}]/u', $word) === 1;
        
        $found = false;
        if ($has_cjk) {
            // For CJK: use simple substring matching (no word boundaries)
            if (mb_strpos($text_lower, $word_lower) !== false) {
                $found = true;
                $pattern = '/' . preg_quote($word, '/') . '/u';
            }
        } else {
            // For Latin: use word boundary regex (case-insensitive)
            $pattern = '/\b' . preg_quote($word_lower, '/') . '\b/ui';
            if (preg_match($pattern, $text_lower)) {
                $found = true;
            }
        }
        
        if ($found) {
            $detected[] = $word;
            $replacement = str_repeat('*', mb_strlen($word, 'UTF-8'));
            if ($pattern !== null) {
                $censored = preg_replace($pattern, $replacement, $censored, -1, $count);
            }
        }
    }
    
    return [
        'is_profane' => !empty($detected),
        'censored_text' => $censored,
        'detected_words' => $detected
    ];
}

/**
 * Check and censor profanities using Ollama with database caching
 * 
 * IMPORTANT DATA FLOW:
 * - $text parameter = ORIGINAL UNCENSORED text from forum post
 * - Stored in cache:
 *   - original_text = NEVER censored (always the input $text)
 *   - censored_text = AI-filtered version with profanities replaced by asterisks
 *   - detected_profanities = array of detected profane words
 * 
 * This separation ensures we can audit/review original content while displaying safe filtered version.
 * 
 * @param string $text The ORIGINAL UNCENSORED text to filter
 * @param int $alumni_id Optional: Alumni ID for per-user tracking
 * @param int $post_id Optional: Post ID for per-post tracking
 * @param string $api_key Optional Ollama model override
 * @return array ['is_profane' => bool, 'censored_text' => string, 'detected_words' => array, 'cached' => bool]
 */
function censor_profanities($text, $alumni_id = null, $post_id = null, $api_key = null) {
    if (empty($text)) {
        return [
            'is_profane' => false,
            'censored_text' => $text,
            'detected_words' => [],
            'cached' => false
        ];
    }

    $CI = &get_instance();

    // Load cache model
    $CI->load->model('Profanity_filter_cache');

    // Step 1: Check database cache first
    $cached_result = $CI->Profanity_filter_cache->get_cached_result($text, $alumni_id);
    if ($cached_result) {
        $cached_result['from_cache'] = true;
        return $cached_result;
    }

    // Step 2: Call Ollama first (primary detection method)
    if (!$api_key) {
        $CI->load->config('ollama');
        $api_key = $CI->config->item('ollama_model');
    }

    $filter_result = _call_ollama_profanity_api($text, $api_key);
    
    // Step 3: If API failed or returned nothing, fall back to simple keyword filter
    if (!$filter_result || (!isset($filter_result['is_profane']) && !isset($filter_result['censored_text']))) {
        $simple_result = _simple_censor_profanities($text);
        $filter_result = [
            'is_profane' => $simple_result['is_profane'],
            'censored_text' => $simple_result['censored_text'],
            'detected_words' => $simple_result['detected_words'],
            'api_status' => 'fallback_used',
            'processing_time_ms' => 0
        ];
    }

    // Step 4: Store result in database cache for future use
    if ($filter_result) {
        $cache_entry = [
            'post_id' => $post_id,
            'alumni_id' => $alumni_id,
            'original_text' => $text,  // IMPORTANT: Store the ORIGINAL uncensored text
            'prompt_used' => $filter_result['prompt'] ?? '',
            'api_response' => $filter_result['raw_response'] ?? '',
            'censored_text' => $filter_result['censored_text'] ?? '',  // IMPORTANT: Store only the filtered version here
            'detected_profanities' => $filter_result['detected_words'] ?? [],
            'is_profane' => $filter_result['is_profane'] ?? false,
            'processing_time_ms' => $filter_result['processing_time_ms'] ?? 0,
            'api_status' => $filter_result['api_status'] ?? 'success',
            'text_hash' => md5($text),  // Hash of original for cache lookups
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            $CI->Profanity_filter_cache->store_cache($cache_entry);
        } catch (Exception $e) {
            log_message('error', 'Profanity Filter Cache Error: ' . $e->getMessage());
        }
    }

    return [
        'is_profane' => $filter_result['is_profane'] ?? false,
        'censored_text' => $filter_result['censored_text'] ?? $text,
        'detected_words' => is_array($filter_result['detected_words'] ?? null) ? $filter_result['detected_words'] : [],
        'cached' => false
    ];
}


/**
 * Internal: Call Ollama for multilingual profanity detection
 * 
 * @param string $text Text to filter
 * @param string $model_override Optional model override
 * @return array Filter result with API details
 */
function _call_ollama_profanity_api($text, $model_override = null) {
    $prompt = "Analyze this text for profanities across multiple languages (including but not limited to Filipino/Tagalog, English, Spanish, Chinese (Simplified/Traditional and common pinyin slang), Portuguese, French, German, Italian, Indonesian/Malay, Turkish, and romanized slang). 
Respond with ONLY a valid JSON object (no markdown, no code blocks) with this exact structure:
{
  \"is_profane\": true/false,
  \"detected_words\": [\"word1\", \"word2\"],
  \"censored_text\": \"text with profanities replaced by asterisks\"
}

For detected profanities, replace ALL characters with asterisks (*). Keep original spacing.
Example: 'GAGO' becomes '****', 'TANGINA MO' becomes '******* **'.

Text to analyze:
" . $text;

    $options = [
        'temperature' => 0.3,
        'format' => 'json',
        'max_tokens' => 300,
        'system' => 'You are a profanity filter. You detect and censor offensive words across multiple languages including Spanish and Chinese, plus common slang variants. Always respond with valid JSON only. No explanations, no markdown.'
    ];

    if (!empty($model_override)) {
        $options['model'] = $model_override;
    }

    $result = call_ollama_api($prompt, $options);
    $raw_text = ai_extract_candidate_text($result);

    if ($raw_text === '') {
        log_message('error', 'Profanity Filter: empty Ollama response');
        $simple_result = _simple_censor_profanities($text);
        return [
            'is_profane' => $simple_result['is_profane'],
            'censored_text' => $simple_result['censored_text'],
            'detected_words' => $simple_result['detected_words'],
            'raw_response' => 'Empty Ollama response',
            'api_status' => 'fallback_used',
            'processing_time_ms' => 0,
            'prompt' => $prompt
        ];
    }

    $clean_text = preg_replace('/```json\s*|```\s*/', '', $raw_text);
    $clean_text = trim($clean_text);

    $filter_result = json_decode($clean_text, true);

    if ($filter_result && is_array($filter_result)) {
        return [
            'is_profane' => (bool)($filter_result['is_profane'] ?? false),
            'censored_text' => $filter_result['censored_text'] ?? $text,
            'detected_words' => $filter_result['detected_words'] ?? [],
            'raw_response' => json_encode($result['_raw_response'] ?? $result),
            'api_status' => 'success',
            'processing_time_ms' => 0,
            'prompt' => $prompt
        ];
    }

    log_message('error', 'Profanity Filter Parse Error: invalid JSON from Ollama - Using simple fallback');
    $simple_result = _simple_censor_profanities($text);
    return [
        'is_profane' => $simple_result['is_profane'],
        'censored_text' => $simple_result['censored_text'],
        'detected_words' => $simple_result['detected_words'],
        'raw_response' => $raw_text,
        'api_status' => 'parse_error_fallback',
        'processing_time_ms' => 0,
        'prompt' => $prompt
    ];
}


/**
 * Censor forum posts with smart per-user and per-job caching
 * Processes each user's content once, then applies to all their posts
 * Significantly reduces API calls
 * 
 * @param array $posts Array of post objects with 'title', 'content', 'alumni_id', and optional 'job_id'
 * @param string $api_key Optional Gemini API key
 * @return array Posts with added censored fields and metadata
 */
function censor_forum_posts_optimized($posts, $api_key = null) {
    if (!is_array($posts) || empty($posts)) {
        return $posts;
    }

    // Group posts by alumni_id to cache per user
    $posts_by_alumni = [];
    foreach ($posts as $post) {
        $alumni_id = $post->alumni_id ?? null;
        if (!isset($posts_by_alumni[$alumni_id])) {
            $posts_by_alumni[$alumni_id] = [];
        }
        $posts_by_alumni[$alumni_id][] = $post;
    }

    // Cache for censored results per alumni_id
    $alumni_censoring_cache = [];
    $censored_posts = [];

    foreach ($posts_by_alumni as $alumni_id => $alumni_posts) {
        // Get first post from this alumni to use for censoring
        $sample_post = $alumni_posts[0];
        
        // Check if we already censored this alumni's content
        if (!isset($alumni_censoring_cache[$alumni_id])) {
            // Censor title and content for this alumni
            $title_filter = censor_profanities(
                $sample_post->title ?? '',
                $alumni_id,
                $sample_post->id ?? null,
                $api_key
            );
            
            $content_filter = censor_profanities(
                $sample_post->content ?? '',
                $alumni_id,
                $sample_post->id ?? null,
                $api_key
            );

            // Cache the result for this alumni
            $alumni_censoring_cache[$alumni_id] = [
                'title' => $title_filter,
                'content' => $content_filter
            ];
        }

        // Apply cached censoring to all posts from this alumni
        $cached_title = $alumni_censoring_cache[$alumni_id]['title'];
        $cached_content = $alumni_censoring_cache[$alumni_id]['content'];

        foreach ($alumni_posts as $post) {
            $post->censored_title = $cached_title['censored_text'];
            $post->censored_content = $cached_content['censored_text'];
            $post->has_profanity = $cached_title['is_profane'] || $cached_content['is_profane'];
            
            // Ensure detected_words are arrays before merging
            $title_words = is_array($cached_title['detected_words']) ? $cached_title['detected_words'] : [];
            $content_words = is_array($cached_content['detected_words']) ? $cached_content['detected_words'] : [];
            $post->flagged_words = array_merge($title_words, $content_words);
            
            $post->title_cached = $cached_title['cached'] ?? false;
            $post->content_cached = $cached_content['cached'] ?? false;

            $censored_posts[] = $post;
        }
    }

    return $censored_posts;
}


/**
 * Censor multiple forum posts (for batch processing)
 * 
 * @param array $posts Array of post objects with 'title' and 'content' keys
 * @param string $api_key Optional Gemini API key
 * @return array Posts with added censored fields and metadata
 */
function censor_forum_posts($posts, $api_key = null) {
    if (!is_array($posts) || empty($posts)) {
        return $posts;
    }

    $censored_posts = [];

    foreach ($posts as $post) {
        // Get alumni_id from post (assuming it exists)
        $alumni_id = $post->alumni_id ?? null;
        $post_id = $post->id ?? null;

        // Censor title
        $title_filter = censor_profanities(
            $post->title ?? '',
            $alumni_id,
            $post_id,
            $api_key
        );

        // Censor content
        $content_filter = censor_profanities(
            $post->content ?? '',
            $alumni_id,
            $post_id,
            $api_key
        );

        // Add censored fields to post
        $post->censored_title = $title_filter['censored_text'];
        $post->censored_content = $content_filter['censored_text'];
        $post->has_profanity = $title_filter['is_profane'] || $content_filter['is_profane'];
        
        // Ensure detected_words are arrays before merging
        $title_words = is_array($title_filter['detected_words']) ? $title_filter['detected_words'] : [];
        $content_words = is_array($content_filter['detected_words']) ? $content_filter['detected_words'] : [];
        $post->flagged_words = array_merge($title_words, $content_words);
        
        $post->title_cached = $title_filter['cached'] ?? false;
        $post->content_cached = $content_filter['cached'] ?? false;

        $censored_posts[] = $post;
    }

    return $censored_posts;
}


/**
 * Get profanity statistics for an alumni member
 * 
 * @param int $alumni_id Alumni ID
 * @return array Statistics about their posts
 */
function get_alumni_profanity_stats($alumni_id) {
    $CI = &get_instance();
    $CI->load->model('Profanity_filter_cache');

    return $CI->Profanity_filter_cache->get_stats($alumni_id);
}


/**
 * Get cache statistics for admin dashboard
 * 
 * @return object Cache statistics
 */
function get_cache_statistics() {
    $CI = &get_instance();
    $CI->load->model('Profanity_filter_cache');

    return $CI->Profanity_filter_cache->get_stats();
}
