<?php
/**
 * PROFANITY FILTER - USAGE GUIDE & EXAMPLES
 * 
 * For CodeIgniter 3 PHP 7
 * Uses Google Gemini 2.5 Flash API
 * 
 * API Key: AIzaSyCjoChF8STdKUFNxVtXROPEDUtFElNNYZM
 * Supports: Filipino (Tagalog) & English profanities
 */

// ============================================================================
// EXAMPLE 1: Single Post Censoring
// ============================================================================

$sample_post = [
    'id' => 12,
    'alumni_id' => 45,
    'title' => 'GAGO',
    'content' => 'TANGINA MO',
    'image' => '77156cac71da00fc5f0bca0e82217c0e.png',
    'is_anonymous' => 0,
    'created_at' => '2026-03-10 18:59:21',
];

// First: Load the helper in your controller
// $this->load->helper('profanity_filter');

// Then: Censor the content
// $result = censor_profanities($sample_post['title']);
// 
// Output: [
//     'is_profane' => true,
//     'censored_text' => '****',  (GAGO replaced with ****)
//     'detected_words' => ['GAGO']
// ]


// ============================================================================
// EXAMPLE 2: Batch Forum Posts Censoring (What's used in Forum Controller)
// ============================================================================

$forum_posts = [
    [
        'id' => 12,
        'alumni_id' => 45,
        'title' => 'GAGO',
        'content' => 'TANGINA MO',
        'image' => '77156cac71da00fc5f0bca0e82217c0e.png',
        'is_anonymous' => 0,
        'created_at' => '2026-03-10 18:59:21',
    ],
    [
        'id' => 13,
        'alumni_id' => 46,
        'title' => 'Great Alumni Event',
        'content' => 'Had a wonderful time at the alumni gathering!',
        'image' => null,
        'is_anonymous' => 0,
        'created_at' => '2026-03-15 10:30:00',
    ],
];

// Convert to objects (as they come from database)
$forum_posts = array_map(function($p) {
    return (object)$p;
}, $forum_posts);

// Censor all posts: $this->load->helper('profanity_filter');
// $censored = censor_forum_posts($forum_posts);
//
// Result adds these fields to each post:
// - censored_title: "****" 
// - censored_content: "******* **"
// - has_profanity: true
// - flagged_words: ['GAGO', 'TANGINA']


// ============================================================================
// EXAMPLE 3: Usage in Forum Controller
// ============================================================================

/*
// In /application/controllers/Forum.php

class Forum extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Forum_model');
        $this->load->helper('profanity_filter');  // Load here
    }
    
    public function index() {
        // ... pagination setup ...
        
        // Get posts from database
        $data['posts'] = $this->Forum_model->get_posts($limit, $offset, $search, $sort);
        
        // Apply censoring automatically
        $data['posts'] = censor_forum_posts($data['posts']);
        
        // Now display with:
        // - $post->censored_title
        // - $post->censored_content
        // - $post->has_profanity (boolean)
        // - $post->flagged_words (array)
        
        $this->load->view('user/forum_list', $data);
    }
}
*/


// ============================================================================
// EXAMPLE 4: Usage in Forum View/Blade
// ============================================================================

/*
// In /application/views/user/forum_list.php

// Display censored title
<h3 class="post-title"><?= htmlspecialchars($post->censored_title ?? $post->title) ?></h3>

// Display censored content snippet
<?php if (!empty($post->censored_content)): ?>
    <p class="post-preview"><?= htmlspecialchars(substr($post->censored_content, 0, 150)) ?></p>
<?php endif; ?>

// Show flag indicator
<?php if ($post->has_profanity && $post->has_profanity == true): ?>
    <span style="background:#fef2f2;color:#e53e3e;font-size:10px;...">⚠ Flagged</span>
<?php endif; ?>
*/


// ============================================================================
// EXAMPLE 5: Advanced - Caching to Reduce API Calls
// ============================================================================

/*
// In your controller:

// First load cache library
$this->load->driver('cache');

// Then use cached version (caches for 30 days)
$result = get_cached_profanity_check($text, 'censor_profanities');

// Or with custom key:
$cache_key = 'forum_' . $post_id;
$CI->cache->save($cache_key, $censored_content, 2592000); // 30 days
*/


// ============================================================================
// EXAMPLE 6: Manual API Call (Advanced)
// ============================================================================

/*
function check_profanity_manual($text) {
    $CI = &get_instance();
    $CI->load->config('gemini');
    $api_key = $CI->config->item('gemini_api_key');
    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $api_key;
    
    $payload = [
        "contents" => [[
            "parts" => [["text" => "Detect profanities in this text and respond with JSON: " . $text]]
        ]],
        "generationConfig" => ["response_mime_type" => "application/json"]
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    $response = json_decode($result, true);
    curl_close($ch);
    
    return $response['candidates'][0]['content']['parts'][0]['text'];
}
*/


// ============================================================================
// CONFIGURATION
// ============================================================================

/*
Location: /application/config/gemini.php

$config['gemini_api_key'] = 'AIzaSyCjoChF8STdKUFNxVtXROPEDUtFElNNYZM';
// (Can also be set via environment variable GEMINI_API_KEY)

The profanity filter uses the same API key configuration.
It auto-loads from gemini.php config.
*/


// ============================================================================
// SUPPORTED LANGUAGES & FEATURES
// ============================================================================

/*
✅ Filipino Profanities:
   - GAGO (idiot)
   - TANGINA
   - PUTANG INA
   - And many others (AI-detected)

✅ English Profanities:
   - All common English profanities
   - Slurs and offensive terms
   - AI-detected based on context

✅ Features:
   - Automatic censoring with asterisks (****)
   - Maintains original spacing
   - Returns detected words list
   - Flags posts with profanities
   - Optional caching for performance
   - Batch processing support
*/


// ============================================================================
// TROUBLESHOOTING
// ============================================================================

/*
❌ Issue: "API Connection Failed"
   ✅ Solution: Check if API key is valid and Gemini API is enabled in Google Cloud

❌ Issue: Posts not being censored
   ✅ Solution: Ensure profanity_filter helper is loaded in controller
   ✅ Check logs: /application/logs/

❌ Issue: Slow response times
   ✅ Solution: Enable caching with get_cached_profanity_check()
   ✅ Or batch process in background job

❌ Issue: Missing censored_title / censored_content
   ✅ Solution: Ensure censor_forum_posts() is called before passing to view
   ✅ Check that posts are in array/object format
*/


// ============================================================================
// IMPLEMENTATION CHECKLIST
// ============================================================================

/*
✅ 1. Created: /application/helpers/profanity_filter_helper.php
✅ 2. Updated: /application/controllers/Forum.php
   - Added: $this->load->helper('profanity_filter');
   - Added: $data['posts'] = censor_forum_posts($data['posts']);
✅ 3. Updated: /application/views/user/forum_list.php
   - Changed: $p->title to $p->censored_title
   - Added: Preview from $p->censored_content
   - Added: ⚠ Flagged badge when $p->has_profanity
✅ 4. Configuration already exists: /application/config/gemini.php
   - API key configured: AIzaSyCjoChF8STdKUFNxVtXROPEDUtFElNNYZM
   - Using Gemini 2.5 Flash model
*/
