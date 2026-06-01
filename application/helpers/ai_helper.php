<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * AI Helper - Ollama Integration
 * Provides AI-based job matching using a local Ollama model
 */

/**
 * Compute AI Match Score between alumni profile and job using Ollama
 * Returns a percentage match (0-100)
 * 
 * @param object $alumni Alumni profile object
 * @param object $job Job posting object
 * @return int Match percentage (0-100)
 */
/**
 * Store match result in cache
 */
if (!function_exists('store_match_in_cache')) {
    function store_match_in_cache($alumni_id, $job_id, $prompt, $match_result, $score)
    {
        $debug_file = APPPATH . 'logs/ai_debug.log';
        try {
            $CI = &get_instance();
            $cache_data = [
                'alumni_id' => $alumni_id,
                'job_id' => $job_id,
                'prompt' => $prompt,
                'api_response' => json_encode($match_result),
                'match_percentage' => $score
            ];
            $CI->db->replace('ai_match_cache', $cache_data);
            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] SUCCESS: Cached result in ai_match_cache (Alumni=$alumni_id, Job=$job_id, Score=$score%)\n", FILE_APPEND);
            log_message('debug', "Cached result: Alumni=$alumni_id, Job=$job_id, Score=$score%");
        } catch (Exception $e) {
            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] CACHE ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
            log_message('error', "Cache insert error: " . $e->getMessage());
        }
    }
}

if (!function_exists('compute_ai_match')) {
    function compute_ai_match($alumni, $job)
    {
        // IMPORTANT: This function compares a SINGLE ALUMNI PROFILE to a SINGLE JOB
        // The $alumni parameter is the logged-in user's profile
        // The $job parameter is the job posting being evaluated

        // Validate inputs
        if (!$alumni || !$job) {
            log_message('error', 'compute_ai_match: Missing alumni or job object');
            return rand(30, 85);
        }

        // Log the comparison for debugging
        $alumni_id = isset($alumni->id) ? $alumni->id : 'unknown';
        $alumni_degree = isset($alumni->degree) ? $alumni->degree : 'unknown';
        $job_id = isset($job->id) ? $job->id : 'unknown';
        $job_title = isset($job->job_title) ? $job->job_title : 'unknown';

        log_message('debug', "Comparing Alumni ID={$alumni_id} (Degree: {$alumni_degree}) to Job ID={$job_id} (Title: {$job_title})");

        // Direct file logging for debugging
        $debug_file = APPPATH . 'logs/ai_debug.log';
        file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Starting compute_ai_match for Alumni={$alumni_id}, Job={$job_id}\n", FILE_APPEND);

        // ===== CHECK CACHE FIRST =====
        $CI = &get_instance();
        $cached = $CI->db->where('alumni_id', $alumni_id)
            ->where('job_id', $job_id)
            ->get('ai_match_cache')
            ->row();

        if ($cached) {
            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] CACHE HIT: Found cached result = " . $cached->match_percentage . "%\n", FILE_APPEND);
            log_message('debug', "Cache hit for Alumni={$alumni_id}, Job={$job_id}: {$cached->match_percentage}%");
            return (int)$cached->match_percentage;
        }

        // Use Ollama for AI job matching
        try {
            // Prepare alumni profile JSON
            $profile_data = [
                'alumni_id' => (isset($alumni->id) ? $alumni->id : ''),
                'full_name' => (isset($alumni->first_name) ? $alumni->first_name : '') . ' ' . (isset($alumni->last_name) ? $alumni->last_name : ''),
                'current_job' => isset($alumni->current_job) ? $alumni->current_job : '',
                'soft_skills' => isset($alumni->soft_skills) ? $alumni->soft_skills : '',
                'technical_skills' => isset($alumni->technical_skills) ? $alumni->technical_skills : '',
                'degree' => isset($alumni->degree) ? $alumni->degree : '',
                'graduation_year' => isset($alumni->graduation_year) ? $alumni->graduation_year : '',
                'location' => isset($alumni->location) ? $alumni->location : '',
                'experience_years' => isset($alumni->experience_years) ? $alumni->experience_years : 0
            ];
            
            // Prepare job posting JSON
            $job_data = [
                'job_id' => isset($job->id) ? $job->id : '',
                'job_title' => isset($job->job_title) ? $job->job_title : '',
                'company' => isset($job->company) ? $job->company : '',
                'description' => isset($job->description) ? $job->description : '',
                'requirements' => isset($job->qualifications) ? $job->qualifications : '',
                'location' => isset($job->location) ? $job->location : '',
                'salary_range' => isset($job->salary_range) ? $job->salary_range : ''
            ];
            
            log_message('debug', "Alumni Profile: " . json_encode($profile_data));
            log_message('debug', "Job Data: " . json_encode($job_data));
            $prompt = "You are a career matching engine. Return ONLY valid JSON, nothing else. No explanations, no markdown, just JSON.\n\n"
                    . "Alumni Profile: " . json_encode($profile_data) . " "
                    . "\n\nJob Posting: " . json_encode($job_data) . " "
                    . "\n\nReturn this exact JSON structure:"
                    . "\n{"
                    . "\n\"match_percentage\": <0-100 integer>,"
                    . "\n\"degree_aligned\": <true or false>,"
                    . "\n\"reason\": \"<explanation>\""
                    . "\n}"
                    . "\n\nRules:"
                    . "\n1. MOST IMPORTANT: Check if alumni's degree matches job field. Degree match is 60% of the final score."
                    . "\n2. For completely unrelated fields (e.g., IT degree + Nursing job): return 0-5%"
                    . "\n3. For different but somewhat related fields (e.g., IT + Marketing): return 15-35%"
                    . "\n4. For same field matches: return 50-100% based on skills and experience"
                    . "\n5. Examples:"
                    . "\n   - BS IT + Software Developer = 70-95%"
                    . "\n   - BS IT + Nursing = 0-5%"
                    . "\n   - BS IT + Marketing = 15-30%"
                    . "\n   - BS IT + Finance = 15-30%"
                    . "\nOutput ONLY the JSON object, nothing else.";
            
            // Call Ollama API
            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Calling Ollama API\n", FILE_APPEND);
            $match_result = call_ollama_api($prompt, [
                'temperature' => 0.3,
                'format' => 'json',
                'max_tokens' => 300,
                'system' => 'You are a career matching engine. Return only valid JSON.'
            ]);
            
            if ($match_result) {
                file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Ollama response: " . json_encode($match_result) . "\n", FILE_APPEND);
                log_message('debug', 'Ollama API response: ' . json_encode($match_result));

                $parsed_result = null;
                if (isset($match_result['_parsed_result']) && is_array($match_result['_parsed_result'])) {
                    $parsed_result = $match_result['_parsed_result'];
                } else {
                    $response_text = ai_extract_candidate_text($match_result);

                    if ($response_text !== '') {
                        $response_text = preg_replace('/```json\s*/i', '', $response_text);
                        $response_text = preg_replace('/```\s*/i', '', $response_text);
                        $response_text = trim($response_text);

                        $parsed_result = json_decode($response_text, true);

                        if (!is_array($parsed_result) && preg_match('/(\d+)%/', $response_text, $matches)) {
                            $parsed_result = [
                                'match_percentage' => (int)$matches[1],
                                'reason' => 'Extracted from Ollama analysis text'
                            ];
                        }
                    }
                }

                if (is_array($parsed_result)) {
                    $match_result = $parsed_result;
                }
                
                // Try to find the percentage in various field names
                if (isset($match_result['match_percentage'])) {
                    $score = (int)$match_result['match_percentage'];
                    file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] SUCCESS: Using Ollama AI score " . $score . "%\n", FILE_APPEND);
                    log_message('debug', 'Using Ollama AI score for job ' . $job->job_title . ': ' . $score . '%');
                    store_match_in_cache($alumni_id, $job_id, $prompt, $match_result, $score);
                    return max(0, min(100, $score));
                } elseif (isset($match_result['matchPercentage'])) {
                    $score = (int)$match_result['matchPercentage'];
                    file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] SUCCESS: Using Ollama AI score (camelCase) " . $score . "%\n", FILE_APPEND);
                    log_message('debug', 'Using Ollama AI score (camelCase) for job ' . $job->job_title . ': ' . $score . '%');
                    store_match_in_cache($alumni_id, $job_id, $prompt, $match_result, $score);
                    return max(0, min(100, $score));
                } elseif (isset($match_result['percentage'])) {
                    $score = (int)$match_result['percentage'];
                    file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] SUCCESS: Using Ollama AI score (alt) " . $score . "%\n", FILE_APPEND);
                    log_message('debug', 'Using Ollama AI score (alt field) for job ' . $job->job_title . ': ' . $score . '%');
                    store_match_in_cache($alumni_id, $job_id, $prompt, $match_result, $score);
                    return max(0, min(100, $score));
                } else {
                    file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] ERROR: No match_percentage field. Fields: " . implode(', ', array_keys($match_result)) . "\n", FILE_APPEND);
                    log_message('debug', 'Ollama API did not return match_percentage field. Available fields: ' . implode(', ', array_keys($match_result)));
                    // Fall back to algorithm if API response doesn't have expected structure
                    $score = compute_ai_match_fallback($alumni, $job);
                    $cache_result = ['match_percentage' => $score, 'algorithm' => 'fallback_backup', 'calculated_at' => date('Y-m-d H:i:s')];
                    store_match_in_cache($alumni_id, $job_id, 'ollama_fallback_backup', $cache_result, $score);
                    return $score;
                }
            } else {
                file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] ERROR: Ollama API returned empty result, using fallback\n", FILE_APPEND);
                log_message('debug', 'Ollama API returned empty result for job ' . $job->job_title . ', using fallback');
                $score = compute_ai_match_fallback($alumni, $job);
                $cache_result = ['match_percentage' => $score, 'algorithm' => 'fallback_backup', 'calculated_at' => date('Y-m-d H:i:s')];
                store_match_in_cache($alumni_id, $job_id, 'ollama_fallback_backup', $cache_result, $score);
                return $score;
            }
            
        } catch (Exception $e) {
            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] EXCEPTION: " . $e->getMessage() . " - using fallback\n", FILE_APPEND);
            log_message('error', 'Ollama API Error: ' . $e->getMessage() . ' - using fallback');
            $score = compute_ai_match_fallback($alumni, $job);
            $cache_result = ['match_percentage' => $score, 'algorithm' => 'fallback_backup', 'calculated_at' => date('Y-m-d H:i:s')];
            store_match_in_cache($alumni_id, $job_id, 'ollama_fallback_backup', $cache_result, $score);
            return $score;
        }
    }
}

/**
 * Call Ollama chat/generate API
 * 
 * @param string $prompt Prompt text
 * @return array|false API response as associative array or false on error  
 */
if (!function_exists('call_ollama_api')) {
    function call_ollama_api($prompt, $options = [])
    {
        log_message('debug', 'Calling Ollama API for job matching');

        $CI = &get_instance();
        $CI->load->config('ollama');

        $debug_file = APPPATH . 'logs/ai_debug.log';
        $host = rtrim((string)$CI->config->item('ollama_host'), '/');
        $model = isset($options['model']) && $options['model'] !== '' ? $options['model'] : $CI->config->item('ollama_model');
        $timeout = isset($options['timeout']) ? (int)$options['timeout'] : (int)$CI->config->item('ollama_timeout');

        $host_candidates = [];
        $configured_hosts = $CI->config->item('ollama_hosts');
        if (is_array($configured_hosts) && !empty($configured_hosts)) {
            foreach ($configured_hosts as $configured_host) {
                $configured_host = rtrim((string)$configured_host, '/');
                if ($configured_host !== '' && !in_array($configured_host, $host_candidates, true)) {
                    $host_candidates[] = $configured_host;
                }
            }
        }

        if (empty($host_candidates) && $host !== '') {
            $host_candidates[] = $host;
        }

        if ($host === 'http://127.0.0.1:11434' && !in_array('http://localhost:11434', $host_candidates, true)) {
            $host_candidates[] = 'http://localhost:11434';
        } elseif ($host === 'http://localhost:11434' && !in_array('http://127.0.0.1:11434', $host_candidates, true)) {
            $host_candidates[] = 'http://127.0.0.1:11434';
        }

        if (empty($host_candidates) || empty($model)) {
            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Ollama config missing host or model\n", FILE_APPEND);
            return false;
        }

        $forum_debug = APPPATH . 'logs/forum_ai_debug.log';
        file_put_contents($forum_debug, "[" . date('Y-m-d H:i:s') . "] call_ollama_api: Hosts=" . implode(', ', $host_candidates) . ", Model=$model, Timeout=$timeout\n", FILE_APPEND);

        $payload = [
            'model' => $model,
            'prompt' => $prompt,
            'stream' => false,
            'format' => isset($options['format']) ? $options['format'] : 'json',
            'options' => [
                'temperature' => isset($options['temperature']) ? (float)$options['temperature'] : (float)$CI->config->item('ollama_temperature')
            ],
        ];

        if (isset($options['system']) && $options['system'] !== '') {
            $payload['system'] = $options['system'];
        }

        if (isset($options['max_tokens'])) {
            $payload['options']['num_predict'] = (int)$options['max_tokens'];
        }

        if (isset($options['raw'])) {
            $payload['raw'] = (bool)$options['raw'];
        }

        $response = '';
        $http_code = 0;
        $curl_error = '';
        $used_host = '';

        foreach ($host_candidates as $candidate_host) {
            $candidate_host = rtrim((string)$candidate_host, '/');
            if ($candidate_host === '') {
                continue;
            }

            $url = $candidate_host . '/api/generate';
            $used_host = $candidate_host;

            file_put_contents($forum_debug, "[" . date('Y-m-d H:i:s') . "] Executing cURL request to $url\n", FILE_APPEND);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout > 0 ? $timeout : 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            curl_close($ch);

            file_put_contents($forum_debug, "[" . date('Y-m-d H:i:s') . "] HTTP=$http_code, cURL Error: $curl_error, Response length: " . strlen((string)$response) . "\n", FILE_APPEND);

            if ($curl_error) {
                file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] cURL Error for $candidate_host: " . $curl_error . "\n", FILE_APPEND);
                log_message('error', 'cURL Error in Ollama API for ' . $candidate_host . ': ' . $curl_error);
                $response = '';
                $http_code = 0;
                continue;
            }

            if ($http_code !== 200) {
                file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] HTTP Error from $candidate_host: " . $http_code . " - " . substr((string)$response, 0, 200) . "\n", FILE_APPEND);
                log_message('error', 'Ollama API HTTP Error from ' . $candidate_host . ': ' . $http_code . ' - ' . $response);
                continue;
            }

            break;
        }

        if ($curl_error || $http_code !== 200) {
            if ($used_host !== '') {
                file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] All Ollama hosts failed. Last host=$used_host\n", FILE_APPEND);
            }
            return false;
        }

        $api_response = json_decode($response, true);

        if (!$api_response) {
            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Invalid response structure: " . json_encode($api_response) . "\n", FILE_APPEND);
            log_message('error', 'Invalid Ollama API response structure');
            return false;
        }

        $response_text = '';
        if (isset($api_response['response']) && trim((string)$api_response['response']) !== '') {
            $response_text = (string)$api_response['response'];
        } elseif (isset($api_response['message']['content']) && trim((string)$api_response['message']['content']) !== '') {
            $response_text = (string)$api_response['message']['content'];
        } elseif (isset($api_response['choices'][0]['message']['content']) && trim((string)$api_response['choices'][0]['message']['content']) !== '') {
            $response_text = (string)$api_response['choices'][0]['message']['content'];
        }

        if ($response_text === '') {
            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Empty text in Ollama API response: " . json_encode($api_response) . "\n", FILE_APPEND);
            log_message('error', 'Empty Ollama API response text');
            return false;
        }

        file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Raw API text: " . $response_text . "\n", FILE_APPEND);

        // Log the raw response for debugging
        log_message('debug', 'Ollama API raw response: ' . $response_text);

        // Remove markdown code blocks if present
        $response_text = preg_replace('/```json\s*/i', '', $response_text);
        $response_text = preg_replace('/```\s*/i', '', $response_text);
        $response_text = trim($response_text);

        $result = json_decode($response_text, true);

        // If JSON parsing failed, try to extract percentage from text
        if (!is_array($result)) {
            $debug_file = APPPATH . 'logs/ai_debug.log';
            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] JSON parse failed, attempting text extraction\n", FILE_APPEND);
            log_message('debug', 'JSON parsing failed, attempting text extraction: ' . $response_text);

            // Try to extract a percentage number from the text
            if (preg_match('/(\d+)%/', $response_text, $matches)) {
                $extracted_percentage = (int)$matches[1];
                file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Extracted percentage: " . $extracted_percentage . "%\n", FILE_APPEND);
                log_message('debug', 'Extracted percentage from text: ' . $extracted_percentage . '%');
                $result = [
                    'match_percentage' => $extracted_percentage,
                    'reason' => 'Extracted from Ollama analysis text'
                ];
            } else {
                file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Could not extract percentage from: " . substr($response_text, 0, 200) . "\n", FILE_APPEND);
                log_message('error', 'Could not parse Ollama API JSON response or extract percentage: ' . substr($response_text, 0, 500));
                return false;
            }
        }

        // Log what we're returning
        file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Returning result: " . json_encode($result) . "\n", FILE_APPEND);
        log_message('debug', 'Ollama API parsed result: ' . json_encode($result));

        return [
            'candidates' => [
                [
                    'content' => [
                        'parts' => [
                            ['text' => $response_text]
                        ]
                    ]
                ]
            ],
            '_raw_response' => $api_response,
            '_parsed_result' => $result
        ];
    }
}


/**
 * Fallback AI Match (used when API is unavailable)
 * Simple algorithm-based matching
 * 
 * @param object $alumni Alumni profile object
 * @param object $job Job posting object
 * @return int Match percentage (0-100)
 */
if (!function_exists('compute_ai_match_fallback')) {
    function compute_ai_match_fallback($alumni, $job)
    {
        $score = 0;
        $weights = [];

        // Validate input objects with fallback defaults
        if (!$alumni) {
            $alumni = (object)[
                'id' => null,
                'degree' => 'Unknown Degree',
                'technical_skills' => '',
                'experience_years' => 0,
                'location' => ''
            ];
        }

        if (!$job) {
            $job = (object)[
                'id' => null,
                'job_title' => 'Unknown Position',
                'description' => '',
                'qualifications' => '',
                'location' => ''
            ];
        }

        // Log that we're using fallback
        $alumni_id = isset($alumni->id) ? $alumni->id : 'unknown';
        $job_id = isset($job->id) ? $job->id : 'unknown';
        log_message('info', "Using FALLBACK algorithm for Alumni ID={$alumni_id} vs Job ID={$job_id}");

        $alumni_degree = isset($alumni->degree) ? strtolower($alumni->degree) : 'unspecified degree';
        $alumni_skills = isset($alumni->technical_skills) ? strtolower($alumni->technical_skills) : '';
        $job_title = isset($job->job_title) ? strtolower($job->job_title) : 'unspecified position';
        $job_desc = isset($job->description) ? strtolower($job->description) : '';
        $job_quals = isset($job->qualifications) ? strtolower($job->qualifications) : '';
        $job_company = isset($job->company) ? strtolower($job->company) : '';
        $job_combined_text = trim($job_title . ' ' . $job_desc . ' ' . $job_quals . ' ' . $job_company);

        // Define field mappings - COMPREHENSIVE COVERAGE
        $it_degrees = [
            'bsit',
            'bs it',
            'bs information technology',
            'bs in information technology',
            'bs computer science',
            'bs in computer science',
            'bs information systems',
            'bs in information systems',
            'bs computer engineering',
            'bs in computer engineering',
            'bs in it',
            'bachelor of science in information technology',
            'bachelor of science information technology',
            'associate degree in it',
            'diploma in information technology',
            'bs software engineering',
            'bs in software engineering',
            'bs cybersecurity',
            'bs in cybersecurity',
            'bs data science',
            'bs in data science'
        ];
        // Avoid "analyst" - it conflicts with Finance. Use specific IT terms instead
        $it_jobs = ['software', 'developer', 'programmer', 'it', 'web developer', 'data scientist', 'engineer', 'devops', 'network', 'database', 'system admin', 'technical', 'frontend', 'backend', 'full-stack', 'cloud', 'infrastructure', 'it specialist', 'systems engineer', 'solutions architect', 'security engineer', 'infrastructure engineer', 'cloud engineer', 'platform engineer', 'site reliability engineer'];

        $marketing_degrees = ['bs marketing', 'bs business', 'ba marketing', 'bs advertising', 'bs communications', 'bs digital marketing', 'advanced diploma marketing', 'master in marketing'];
        $marketing_jobs = ['marketing', 'advertising', 'branding', 'promotions', 'social media', 'brand', 'digital marketing', 'content marketing', 'marketing manager', 'marketing director', 'campaign manager', 'social media manager', 'seo specialist', 'sem specialist'];

        $finance_degrees = ['bs finance', 'bs accounting', 'bsoa', 'bs accountancy', 'bs business', 'cfp', 'cfa', 'bs auditing', 'bs tax accounting'];
        // Finance uses "analyst" and other finance-specific terms
        $finance_jobs = ['finance', 'accounting', 'analyst', 'auditor', 'accountant', 'financial', 'cpa', 'treasurer', 'controller', 'financial analyst', 'accounting manager', 'audit manager', 'tax specialist', 'investment specialist'];

        // Healthcare jobs - completely unrelated to IT
        $healthcare_jobs = ['nurse', 'nursing', 'physician', 'doctor', 'medical', 'healthcare', 'rn', 'lpn', 'clinical', 'hospital', 'patient care', 'therapist', 'physical therapist', 'pt', 'occupational therapist', 'speech therapist', 'physiotherapy', 'radiology', 'laboratory', 'pharmacy'];

        // Engineering degrees (for cross-domain support)
        $engineering_degrees = ['bs civil engineering', 'bs electrical engineering', 'bs mechanical engineering', 'bs electronics engineering', 'bs chemical engineering', 'bs industrial engineering', 'bs petroleum engineering'];
        $engineering_jobs = ['engineer', 'engineering', 'civil', 'electrical', 'mechanical', 'electronics', 'chemical', 'industrial', 'petroleum', 'project manager'];

        // Business degrees
        $business_degrees = ['bs business administration', 'bs management', 'bs entrepreneurship', 'mba'];
        $business_jobs = ['manager', 'supervisor', 'coordinator', 'administrator', 'business analyst', 'operations'];

        // Arts/Humanities degrees
        $humanities_degrees = ['ba english', 'ba literature', 'ba history', 'ba philosophy', 'bs psychology', 'bs sociology'];
        $humanities_jobs = ['writer', 'content', 'educator', 'teacher', 'counselor', 'human resources'];
        
        // Initialize all keyword matching results for 100% coverage
        $result_mappings = [
            'it' => ['degree' => false, 'job' => false, 'match_score' => 0],
            'marketing' => ['degree' => false, 'job' => false, 'match_score' => 0],
            'finance' => ['degree' => false, 'job' => false, 'match_score' => 0],
            'engineering' => ['degree' => false, 'job' => false, 'match_score' => 0],
            'business' => ['degree' => false, 'job' => false, 'match_score' => 0],
            'humanities' => ['degree' => false, 'job' => false, 'match_score' => 0],
            'healthcare' => ['degree' => false, 'job' => false, 'match_score' => 0]
        ];

        // 1. DEGREE/FIELD MATCH (60% weight - MOST IMPORTANT)
        $it_degree_job_terms = ['bsit', 'bs it', 'information technology', 'computer science', 'computer engineering', 'software engineering', 'cybersecurity', 'data science'];
        $degree_match = 0;

        // Check all field alignments comprehensively
        // IT degree checks
        if (in_array($alumni_degree, array_map('strtolower', $it_degrees))) {
            $result_mappings['it']['degree'] = true;
            foreach ($it_jobs as $it_job) {
                if (ai_text_has_any($job_combined_text, [$it_job])) {
                    $result_mappings['it']['job'] = true;
                    $result_mappings['it']['match_score'] = 1.0;
                    break;
                }
            }
            if (ai_text_has_any($job_combined_text, $it_degree_job_terms)) {
                $result_mappings['it']['job'] = true;
                $result_mappings['it']['match_score'] = 1.0;
            } elseif ($result_mappings['it']['match_score'] < 0.5) {
                $result_mappings['it']['match_score'] = 0.35;
            }
        }

        // Marketing degree checks
        if (in_array($alumni_degree, array_map('strtolower', $marketing_degrees))) {
            $result_mappings['marketing']['degree'] = true;
            foreach ($marketing_jobs as $mkt_job) {
                if (ai_text_has_any($job_combined_text, [$mkt_job])) {
                    $result_mappings['marketing']['job'] = true;
                    $result_mappings['marketing']['match_score'] = 1.0;
                    break;
                }
            }
            if ($result_mappings['marketing']['match_score'] < 0.5) {
                $result_mappings['marketing']['match_score'] = 0.35;
            }
        }

        // Finance degree checks
        if (in_array($alumni_degree, array_map('strtolower', $finance_degrees))) {
            $result_mappings['finance']['degree'] = true;
            foreach ($finance_jobs as $fin_job) {
                if (ai_text_has_any($job_combined_text, [$fin_job])) {
                    $result_mappings['finance']['job'] = true;
                    $result_mappings['finance']['match_score'] = 1.0;
                    break;
                }
            }
            if ($result_mappings['finance']['match_score'] < 0.5) {
                $result_mappings['finance']['match_score'] = 0.35;
            }
        }

        // Engineering degree checks
        if (count(array_filter(array_map(function($eng_deg) use ($alumni_degree) {
            return strpos($alumni_degree, strtolower($eng_deg)) !== false;
        }, $engineering_degrees))) > 0) {
            $result_mappings['engineering']['degree'] = true;
            foreach ($engineering_jobs as $eng_job) {
                if (ai_text_has_any($job_combined_text, [$eng_job])) {
                    $result_mappings['engineering']['job'] = true;
                    $result_mappings['engineering']['match_score'] = 1.0;
                    break;
                }
            }
            if ($result_mappings['engineering']['match_score'] < 0.5) {
                $result_mappings['engineering']['match_score'] = 0.35;
            }
        }

        // Business degree checks
        if (in_array($alumni_degree, array_map('strtolower', $business_degrees))) {
            $result_mappings['business']['degree'] = true;
            foreach ($business_jobs as $bus_job) {
                if (ai_text_has_any($job_combined_text, [$bus_job])) {
                    $result_mappings['business']['job'] = true;
                    $result_mappings['business']['match_score'] = 1.0;
                    break;
                }
            }
            if ($result_mappings['business']['match_score'] < 0.5) {
                $result_mappings['business']['match_score'] = 0.35;
            }
        }

        // Humanities degree checks
        if (count(array_filter(array_map(function($hum_deg) use ($alumni_degree) {
            return strpos($alumni_degree, strtolower($hum_deg)) !== false;
        }, $humanities_degrees))) > 0) {
            $result_mappings['humanities']['degree'] = true;
            foreach ($humanities_jobs as $hum_job) {
                if (ai_text_has_any($job_combined_text, [$hum_job])) {
                    $result_mappings['humanities']['job'] = true;
                    $result_mappings['humanities']['match_score'] = 1.0;
                    break;
                }
            }
            if ($result_mappings['humanities']['match_score'] < 0.5) {
                $result_mappings['humanities']['match_score'] = 0.35;
            }
        }

        // Healthcare job detection (affects all degrees negatively)
        foreach ($healthcare_jobs as $health_job) {
            if (strpos($job_title, $health_job) !== false) {
                $result_mappings['healthcare']['job'] = true;
                break;
            }
        }

        // Determine degree match based on comprehensive mappings
        if ($result_mappings['it']['degree'] && $result_mappings['it']['job']) {
            $degree_match = 1.0;
            log_message('debug', "IT degree + IT job - setting degree_match to 1.0 (100%)");
        } elseif ($result_mappings['marketing']['degree'] && $result_mappings['marketing']['job']) {
            $degree_match = 1.0;
            log_message('debug', "Marketing degree + MARKETING job - setting degree_match to 1.0 (100%)");
        } elseif ($result_mappings['finance']['degree'] && $result_mappings['finance']['job']) {
            $degree_match = 1.0;
            log_message('debug', "Finance degree + FINANCE job - setting degree_match to 1.0 (100%)");
        } elseif ($result_mappings['engineering']['degree'] && $result_mappings['engineering']['job']) {
            $degree_match = 1.0;
            log_message('debug', "Engineering degree + ENGINEERING job - setting degree_match to 1.0 (100%)");
        } elseif ($result_mappings['business']['degree'] && $result_mappings['business']['job']) {
            $degree_match = 1.0;
            log_message('debug', "Business degree + BUSINESS job - setting degree_match to 1.0 (100%)");
        } elseif ($result_mappings['humanities']['degree'] && $result_mappings['humanities']['job']) {
            $degree_match = 1.0;
            log_message('debug', "Humanities degree + HUMANITIES job - setting degree_match to 1.0 (100%)");
        } elseif ($result_mappings['healthcare']['job']) {
            // Healthcare jobs for all degrees except medical/life sciences degrees
            $degree_match = 0.15;
            log_message('debug', "Job is HEALTHCARE - setting degree_match to 0.15 (15%). Allowing transferable skills to contribute.");
        } elseif (($result_mappings['it']['degree'] && $result_mappings['marketing']['job']) ||
                 ($result_mappings['it']['degree'] && $result_mappings['business']['job'])) {
            $degree_match = 0.40;
            log_message('debug', "IT degree + CROSS-FIELD job - setting degree_match to 0.40 (40%). Skills and experience can improve score.");
        } elseif ($result_mappings['it']['degree'] && ai_text_has_any($job_combined_text, $it_degree_job_terms)) {
            $degree_match = 0.95;
            log_message('debug', "IT degree + IT-related qualification terms - setting degree_match to 0.95 (95%).");
        } else {
            // Different field match = base score allowing transferable skills
            $degree_match = 0.30;
            log_message('debug', "DIFFERENT FIELD MATCH - setting degree_match to 0.30 (30%). Degree: {$alumni_degree}, Job Title: {$job_title}. Skills/experience can bridge the gap.");
        }

        log_message('debug', "Degree match factor: {$degree_match}, Weight contribution: " . ($degree_match * 0.60) * 100 . "%");
        $weights['degree'] = $degree_match * 0.60;

        // 2. Skills Match (25% weight)
        $skills_match = 0;
        if (!empty($alumni_skills) && !empty($job_combined_text)) {
            $skills_match = calculate_text_similarity($alumni_skills, $job_combined_text);
            $weights['skills'] = $skills_match * 0.25;
        } elseif (!empty($alumni_skills) || !empty($job_combined_text)) {
            $skills_match = 0.35;
            $weights['skills'] = $skills_match * 0.25;
        } else {
            $weights['skills'] = 0;
        }

        // 3. Experience Level Match (10% weight)
        $experience_match = calculate_experience_match($alumni, $job);
        // For healthcare jobs, don't give experience bonus
        $is_healthcare = $result_mappings['healthcare']['job'];
        $weights['experience'] = $is_healthcare ? 0.01 : ($experience_match * 0.10);

        // 4. Location Preference Match (5% weight)
        $location_match = calculate_location_match($alumni, $job);
        // For healthcare jobs, location shouldn't add any bonus since they're completely misaligned
        $weights['location'] = $is_healthcare ? 0 : ($location_match * 0.05);

        // Calculate total score
        $score = round(array_sum($weights) * 100);

        // For cross-field opportunities: allow meaningful score improvements through skills/experience
        // But don't completely match someone with zero field alignment
        // If degree match is very low AND skills match is also low, cap at 35% (cross-field learning opportunity)
        if ($degree_match < 0.3 && $skills_match < 0.3) {
            $score = min(35, $score);
            log_message('debug', "Cross-field opportunity with low skills match - capping at 35%");
        }

        // Ensure score is between 0 and 100
        $final_score = max(0, min(100, $score));

        // Log the complete result_mappings for audit trail
        log_message('debug', "RESULT MAPPINGS: " . json_encode($result_mappings));
        log_message('debug', "FALLBACK FINAL SCORE: {$final_score}% | Weights: Degree=" . ($weights['degree'] * 100) . "%, Skills=" . ($weights['skills'] * 100) . "%, Experience=" . ($weights['experience'] * 100) . "%, Location=" . ($weights['location'] * 100) . "%");

        return $final_score;
    }
}


/**
 * Calculate text similarity between two strings
 * Uses common word matching
 * 
 * @param string $text1 First text
 * @param string $text2 Second text
 * @return float Similarity score (0-1)
 */
if (!function_exists('calculate_text_similarity')) {
    function calculate_text_similarity($text1, $text2)
    {
        // Remove common words and clean text
        $common_words = array('the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'is', 'are', 'be', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should', 'must');

        $words1 = array_filter(preg_split('/\s+|[,;.-]+/', strtolower($text1)), function ($word) use ($common_words) {
            return !empty($word) && !in_array($word, $common_words) && strlen($word) > 2;
        });

        $words2 = array_filter(preg_split('/\s+|[,;.-]+/', strtolower($text2)), function ($word) use ($common_words) {
            return !empty($word) && !in_array($word, $common_words) && strlen($word) > 2;
        });

        if (empty($words1) || empty($words2)) {
            return 0.5;
        }

        // Count matching words
        $matches = count(array_intersect($words1, $words2));
        $total_unique = count(array_unique(array_merge($words1, $words2)));

        return $total_unique > 0 ? $matches / $total_unique : 0;
    }
}

/**
 * Calculate experience level match
 * 
 * @param object $alumni Alumni profile
 * @param object $job Job posting
 * @return float Match score (0-1)
 */
if (!function_exists('calculate_experience_match')) {
    function calculate_experience_match($alumni, $job)
    {
        $alumni_exp = isset($alumni->experience_years) ? (int)$alumni->experience_years : 0;

        // Extract required years from job description if available
        $req_years = 0;
        if (isset($job->qualifications)) {
            if (preg_match('/(\d+)\+?\s*years?/i', $job->qualifications, $matches)) {
                $req_years = (int)$matches[1];
            }
        }

        // If no requirement found, assume 0-5 years is acceptable range
        if ($req_years === 0) {
            $req_years = 3;
        }

        // Calculate match: full points if within acceptable range (±2 years)
        $diff = abs($alumni_exp - $req_years);

        if ($diff <= 2) {
            return 1.0;
        } elseif ($diff <= 5) {
            return 0.7;
        } elseif ($diff <= 10) {
            return 0.4;
        } else {
            return 0.2;
        }
    }
}

/**
 * Calculate location preference match
 * 
 * @param object $alumni Alumni profile
 * @param object $job Job posting
 * @return float Match score (0-1)
 */
if (!function_exists('calculate_location_match')) {
    function calculate_location_match($alumni, $job)
    {
        $alumni_location = isset($alumni->location) ? strtolower($alumni->location) : '';
        $job_location = isset($job->location) ? strtolower($job->location) : '';

        // Check if job is remote
        if (strpos($job_location, 'remote') !== false) {
            return 1.0; // Remote jobs match anyone
        }

        // Check exact match
        if (!empty($alumni_location) && !empty($job_location)) {
            if ($alumni_location === $job_location) {
                return 1.0;
            }

            // Check if locations are cities in same country
            if (calculate_text_similarity($alumni_location, $job_location) > 0.6) {
                return 0.85;
            }
        }

        // Partial match or no preference
        return 0.6;
    }
}

if (!function_exists('ai_text_has_any')) {
    function ai_text_has_any($haystack, array $needles)
    {
        $haystack = strtolower((string)$haystack);

        foreach ($needles as $needle) {
            $needle = strtolower(trim((string)$needle));
            if ($needle !== '' && strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}

/**
 * Calculate industry/field match
 * 
 * @param object $alumni Alumni profile
 * @param object $job Job posting
 * @return float Match score (0-1)
 */
if (!function_exists('calculate_industry_match')) {
    function calculate_industry_match($alumni, $job)
    {
        $alumni_field = isset($alumni->field_of_study) ? strtolower($alumni->field_of_study) : '';
        $job_title = isset($job->job_title) ? strtolower($job->job_title) : '';
        $job_desc = isset($job->description) ? strtolower($job->description) : '';

        // Combine job title and description for matching
        $job_combined = $job_title . ' ' . $job_desc;

        if (!empty($alumni_field) && !empty($job_combined)) {
            $similarity = calculate_text_similarity($alumni_field, $job_combined);

            if ($similarity > 0.7) {
                return 1.0;
            } elseif ($similarity > 0.4) {
                return 0.75;
            } elseif ($similarity > 0.2) {
                return 0.5;
            }
        }

        // Default moderate matching
        return 0.6;
    }
}

/**
 * Get detailed AI insights for a job match
 * 
 * @param int $score Match percentage
 * @param object $alumni Alumni profile
 * @param object $job Job posting
 * @return array Detailed insight with explanation
 */
if (!function_exists('ai_trim_sentence')) {
    function ai_trim_sentence($text, $maxLen = 180)
    {
        $clean = trim(preg_replace('/\s+/', ' ', (string)$text));
        if ($clean === '') {
            return '';
        }

        if (strlen($clean) <= $maxLen) {
            return $clean;
        }

        $slice = substr($clean, 0, $maxLen);
        $lastSpace = strrpos($slice, ' ');
        if ($lastSpace !== false) {
            $slice = substr($slice, 0, $lastSpace);
        }

        return rtrim($slice, " .,!?:;") . '...';
    }
}

if (!function_exists('ai_normalize_points')) {
    function ai_normalize_points($items, $fallback = [], $limit = 4)
    {
        $list = is_array($items) ? $items : [];
        $normalized = [];

        foreach ($list as $item) {
            $value = ai_trim_sentence($item, 140);
            if ($value === '') {
                continue;
            }

            $key = strtolower($value);
            if (!isset($normalized[$key])) {
                $normalized[$key] = $value;
            }

            if (count($normalized) >= $limit) {
                break;
            }
        }

        if (empty($normalized) && !empty($fallback)) {
            foreach ($fallback as $item) {
                $value = ai_trim_sentence($item, 140);
                if ($value !== '') {
                    $normalized[strtolower($value)] = $value;
                }
                if (count($normalized) >= $limit) {
                    break;
                }
            }
        }

        return array_values($normalized);
    }
}

if (!function_exists('ai_build_explanation_bullets')) {
    function ai_build_explanation_bullets($strengths, $gaps, $summary, $recommendation)
    {
        $lines = [];

        if (!empty($summary)) {
            $lines[] = 'SUMMARY';
            $lines[] = '- ' . ai_trim_sentence($summary, 220);
        }

        if (!empty($strengths)) {
            $lines[] = '';
            $lines[] = 'STRENGTHS';
            foreach ($strengths as $item) {
                $lines[] = '- ' . ai_trim_sentence($item, 160);
            }
        }

        if (!empty($gaps)) {
            $lines[] = '';
            $lines[] = 'GAPS';
            foreach ($gaps as $item) {
                $lines[] = '- ' . ai_trim_sentence($item, 160);
            }
        }

        if (!empty($recommendation)) {
            $lines[] = '';
            $lines[] = 'RECOMMENDATION';
            $lines[] = '- ' . ai_trim_sentence($recommendation, 180);
        }

        return implode("\n", $lines);
    }
}

if (!function_exists('ai_summary_looks_like_json')) {
    function ai_summary_looks_like_json($text)
    {
        $value = trim((string)$text);
        if ($value === '') {
            return false;
        }

        if (strpos($value, '```') !== false) {
            return true;
        }

        if (preg_match('/^\s*[\{\[]/', $value)) {
            return true;
        }

        if (stripos($value, '"strengths"') !== false || stripos($value, "'strengths'") !== false) {
            return true;
        }

        if (stripos($value, '"gaps"') !== false || stripos($value, '"summary"') !== false) {
            return true;
        }

        return false;
    }
}

if (!function_exists('ai_extract_candidate_text')) {
    function ai_extract_candidate_text($result)
    {
        if (!is_array($result)) {
            return '';
        }

        // Try Ollama format first (most common with our current setup)
        if (isset($result['response']) && trim((string)$result['response']) !== '') {
            return (string)$result['response'];
        }

        // Fall back to Gemini format for backward compatibility
        if (!isset($result['candidates']) || !is_array($result['candidates'])) {
            return '';
        }

        foreach ($result['candidates'] as $candidate) {
            if (isset($candidate['content']['parts']) && is_array($candidate['content']['parts'])) {
                foreach ($candidate['content']['parts'] as $part) {
                    if (isset($part['text']) && trim((string)$part['text']) !== '') {
                        return (string)$part['text'];
                    }
                }
            }

            if (isset($candidate['content']['text']) && trim((string)$candidate['content']['text']) !== '') {
                return (string)$candidate['content']['text'];
            }
        }

        return '';
    }
}

if (!function_exists('ai_build_insight_payload')) {
    function ai_build_insight_payload($score, $status, $summary, $strengths, $gaps, $aiPowered, $cached)
    {
        $normalizedStrengths = ai_normalize_points($strengths, ['Relevant educational background', 'Transferable technical foundation'], 4);
        $normalizedGaps = ai_normalize_points($gaps, [], 3);

        $normalizedSummary = ai_trim_sentence($summary, 240);
        if ($normalizedSummary === '') {
            $normalizedSummary = 'Profile evaluation completed based on available qualifications and role requirements.';
        }

        $recommendation = $score >= 70
            ? 'Proceed with application and tailor your resume to this role.'
            : ($score >= 50
                ? 'Apply if interested, and highlight relevant coursework/projects.'
                : 'Consider similar roles while building the listed skill gaps.');

        $fitNarrative = $score >= 75
            ? 'Your profile aligns strongly with the core role requirements.'
            : ($score >= 60
                ? 'Your profile has solid alignment with room to improve specific areas.'
                : ($score >= 45
                    ? 'Your profile shows partial alignment and a potential transition path.'
                    : 'Your profile has limited overlap with this role at the moment.'));

        if (ai_summary_looks_like_json($normalizedSummary)) {
            $normalizedSummary = $fitNarrative;
        }

        $actionSteps = [];
        $actionSteps[] = $recommendation;
        if (!empty($normalizedGaps)) {
            $actionSteps[] = 'Prioritize: ' . $normalizedGaps[0];
        } else {
            $actionSteps[] = 'Prepare role-specific examples for interviews.';
        }

        return [
            'percentage' => (int)$score,
            'status' => $status,
            'strengths' => $normalizedStrengths,
            'gaps' => $normalizedGaps,
            'summary' => $normalizedSummary,
            'explanation' => $normalizedSummary,
            'recommendation' => $recommendation,
            'explanation_bullets' => ai_build_explanation_bullets($normalizedStrengths, $normalizedGaps, $normalizedSummary, $recommendation),
            'narrative' => [
                'opening' => 'Match score evaluated at ' . (int)$score . '%.',
                'fit_story' => $fitNarrative,
                'action_steps' => $actionSteps
            ],
            'ai_powered' => (bool)$aiPowered,
            'cached' => (bool)$cached
        ];
    }
}

if (!function_exists('ai_store_explanation_cache')) {
    function ai_store_explanation_cache($CI, $alumni_id, $job_id, $score, $status, $summary, $strengths, $gaps, $explanationBullets, $debug_log, $prompt = '', $apiResponse = '')
    {
        if (empty($alumni_id) || empty($job_id)) {
            return false;
        }

        $strengths_json = json_encode(is_array($strengths) ? $strengths : [], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        if ($strengths_json === false) {
            $strengths_json = '[]';
        }

        $gaps_json = json_encode(is_array($gaps) ? $gaps : [], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        if ($gaps_json === false) {
            $gaps_json = '[]';
        }

        $cache_data = [
            'alumni_id' => (int)$alumni_id,
            'job_id' => (int)$job_id,
            'summary' => (string)$summary,
            'strengths' => $strengths_json,
            'gaps' => $gaps_json,
            'status' => (string)$status,
            'match_percentage' => (int)$score,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Adapt to table schema present in the current database.
        $table_fields = $CI->db->list_fields('ai_explanation_cache');
        $field_map = array_fill_keys($table_fields, true);

        if (isset($field_map['prompt'])) {
            $cache_data['prompt'] = trim((string)$prompt) !== '' ? (string)$prompt : 'Generated match explanation prompt';
        }

        if (isset($field_map['api_response'])) {
            $cache_data['api_response'] = trim((string)$apiResponse) !== '' ? (string)$apiResponse : '{"source":"ai_helper","note":"no_raw_api_response"}';
        }

        if (isset($field_map['explanation_bullets'])) {
            $cache_data['explanation_bullets'] = (string)$explanationBullets;
        }

        $prev_db_debug = $CI->db->db_debug;
        $CI->db->db_debug = false;

        $insert_ok = false;

        try {
            // Keep lock waits short so cache writes never block the modal response.
            $CI->db->query("SET SESSION innodb_lock_wait_timeout = 2");
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] Active DB: " . $CI->db->database . "\n", FILE_APPEND);
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] Cache table fields: " . implode(', ', $table_fields) . "\n", FILE_APPEND);

            $allowed = [];
            foreach ($cache_data as $key => $value) {
                if (isset($field_map[$key])) {
                    $allowed[$key] = $value;
                }
            }

            // Do not explicitly write auto-managed fields.
            if (isset($allowed['id'])) {
                unset($allowed['id']);
            }

            if (isset($allowed['updated_at'])) {
                unset($allowed['updated_at']);
            }

            if (empty($allowed)) {
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ⚠️ Cache write skipped: no matching fields\n", FILE_APPEND);
                $CI->db->db_debug = $prev_db_debug;
                return false;
            }

            $columns = array_keys($allowed);
            $escaped_columns = [];
            $placeholders = [];
            foreach ($columns as $column) {
                $escaped_columns[] = $CI->db->escape_identifiers($column);
                $placeholders[] = '?';
            }

            $updates = [];
            foreach ($columns as $column) {
                if ($column === 'alumni_id' || $column === 'job_id' || $column === 'created_at') {
                    continue;
                }
                $escaped = $CI->db->escape_identifiers($column);
                $updates[] = $escaped . ' = VALUES(' . $escaped . ')';
            }

            if (isset($field_map['updated_at'])) {
                $updates[] = $CI->db->escape_identifiers('updated_at') . ' = CURRENT_TIMESTAMP';
            }

            if (empty($updates)) {
                $updates[] = $CI->db->escape_identifiers('created_at') . ' = ' . $CI->db->escape_identifiers('created_at');
            }

            $sql = 'INSERT INTO ' . $CI->db->escape_identifiers('ai_explanation_cache')
                . ' (' . implode(', ', $escaped_columns) . ')'
                . ' VALUES (' . implode(', ', $placeholders) . ')'
                . ' ON DUPLICATE KEY UPDATE ' . implode(', ', $updates);

            $query_ok = $CI->db->query($sql, array_values($allowed));
            $insert_ok = (bool)$query_ok;

            if ($insert_ok) {
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ✅ Cache UPSERT success; affected_rows=" . $CI->db->affected_rows() . "\n", FILE_APPEND);
            } else {
                $db_error = $CI->db->error();
                $db_message = isset($db_error['message']) ? $db_error['message'] : 'Unknown DB error';
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ⚠️ Cache write failed: " . $db_message . "\n", FILE_APPEND);
            }
        } catch (Exception $e) {
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ⚠️ Cache exception: " . $e->getMessage() . "\n", FILE_APPEND);
        }

        $CI->db->db_debug = $prev_db_debug;

        return (bool)$insert_ok;
    }
}

if (!function_exists('get_detailed_match_insight')) {
    function get_detailed_match_insight($score, $alumni, $job)
    {
        $debug_log = APPPATH . 'logs/cache_insert.log';
        file_put_contents($debug_log, "\n[" . date('Y-m-d H:i:s') . "] ===== get_detailed_match_insight() CALLED =====\n", FILE_APPEND);

        $CI = &get_instance();
        
        $alumni_id = isset($alumni->id) ? $alumni->id : null;
        $job_id = isset($job->id) ? $job->id : null;
        
        file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] Extracted IDs: Alumni=$alumni_id, Job=$job_id, Score=$score\n", FILE_APPEND);
        file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] Alumni ID: " . ($alumni_id ? $alumni_id : 'NULL') . ", Job ID: " . ($job_id ? $job_id : 'NULL') . "\n", FILE_APPEND);
        
        $alumni_degree = isset($alumni->degree) ? $alumni->degree : 'unknown degree';
        $alumni_skills = isset($alumni->technical_skills) ? $alumni->technical_skills : '';
        $job_title = isset($job->job_title) ? $job->job_title : 'unknown position';
        $job_quals = isset($job->qualifications) ? $job->qualifications : '';
        $job_desc = isset($job->description) ? $job->description : '';

        // Check cache first if both IDs are available
        if ($alumni_id && $job_id) {
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] Checking cache for Alumni=$alumni_id, Job=$job_id\n", FILE_APPEND);
            
            $cached = $CI->db->where('alumni_id', $alumni_id)
                ->where('job_id', $job_id)
                ->get('ai_explanation_cache')
                ->row();
            
            if ($cached) {
                $cached_prompt = isset($cached->prompt) ? trim((string)$cached->prompt) : '';
                $cached_is_fallback = ($cached_prompt === 'fallback_explanation');

                if ($cached_is_fallback) {
                    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ⚠️ CACHE HIT is fallback_explanation - retrying AI generation\n", FILE_APPEND);
                } else {
                    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ✅ CACHE HIT! Returning cached data\n", FILE_APPEND);
                    log_message('info', "AI Explanation Cache HIT: Alumni=$alumni_id, Job=$job_id");
                    $cached_strengths = is_string($cached->strengths) ? json_decode($cached->strengths, true) ?: [] : $cached->strengths;
                    $cached_gaps = is_string($cached->gaps) ? json_decode($cached->gaps, true) ?: [] : $cached->gaps;
                    return ai_build_insight_payload($score, $cached->status, $cached->summary, $cached_strengths, $cached_gaps, true, true);
                }
            } else {
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ❌ NO CACHE - Will call API\n", FILE_APPEND);
            }
        } else {
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ⚠️ SKIPPING CACHE CHECK - Missing IDs: Alumni=$alumni_id, Job=$job_id\n", FILE_APPEND);
        }

        // Try to get AI explanation
        try {
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] Starting API call to Ollama...\n", FILE_APPEND);

            $prompt = "You are a job-match explanation engine. Produce concise, UI-ready analysis for one alumni profile and one job posting.

Objective:
- Explain why the match score is {$score}%.
- Provide practical bullets the user can act on.

Alumni Profile:
- Degree: {$alumni_degree}
- Technical Skills: {$alumni_skills}

Job Details:
- Title: {$job_title}
- Qualifications: {$job_quals}
- Description: {$job_desc}

Output rules (strict):
1. Return ONLY valid JSON. No markdown, no code fences, no extra text.
2. Use exactly these keys: strengths, gaps, summary.
3. strengths: 2-4 bullets, each 8-18 words, specific to profile vs role fit.
4. gaps: 0-3 bullets, each 8-18 words, skill/experience gaps only.
5. summary: 1-2 short sentences (max 40 words total), professional tone.
6. Keep language plain, concrete, and non-repetitive.
7. Do not include quotation marks inside text values unless escaped.

Required JSON schema:
{
    \"strengths\": [\"...\", \"...\"],
    \"gaps\": [\"...\"],
    \"summary\": \"...\"
}";

            $result = call_ollama_api($prompt, [
                'temperature' => 0.3,
                'format' => 'json',
                'max_tokens' => 500,
                'system' => 'You are a job-match explanation engine. Return only valid JSON.'
            ]);

            if ($result) {
                $raw_text = ai_extract_candidate_text($result);
                $response = json_encode($result['_raw_response'] ?? $result);

                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ✅ API Response received (length: " . strlen($raw_text) . " chars)\n", FILE_APPEND);

                if ($raw_text === '') {
                    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ⚠️ Empty candidate text on first call, retrying with compact prompt\n", FILE_APPEND);

                    $retry_prompt = "Return ONLY valid JSON with keys strengths, gaps, summary. No markdown. No code fences. Alumni degree: {$alumni_degree}. Skills: {$alumni_skills}. Job: {$job_title}. Qualifications: {$job_quals}. Description: {$job_desc}.";
                    $retry_result = call_ollama_api($retry_prompt, [
                        'temperature' => 0.2,
                        'format' => 'json',
                        'max_tokens' => 350,
                        'system' => 'You are a job-match explanation engine. Return only valid JSON.'
                    ]);

                    if ($retry_result) {
                        $retry_text = ai_extract_candidate_text($retry_result);
                        if ($retry_text !== '') {
                            $raw_text = $retry_text;
                            $response = json_encode($retry_result['_raw_response'] ?? $retry_result);
                            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ✅ Retry produced candidate text\n", FILE_APPEND);
                        }
                    }
                }

                if ($raw_text !== '') {
                    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] RAW API text received: " . substr($raw_text, 0, 500) . "\n", FILE_APPEND);
                    
                    // Try to parse JSON - simple approach
                    $analysis = null;
                    
                    // Clean up markdown formatting first
                    $clean_text = preg_replace('/```json\s*|```\s*/', '', $raw_text);
                    $clean_text = trim($clean_text);
                    
                    // Try parsing
                    $analysis = json_decode($clean_text, true);
                    
                    if (!$analysis) {
                        // If that fails, try regex extraction of JSON
                        if (preg_match('/\{[^{}]*(?:\[[^\]]*\])*[^{}]*\}/s', $clean_text, $matches)) {
                            $analysis = json_decode($matches[0], true);
                        }
                    }
                    
                    if (!$analysis) {
                        file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ❌ Could not parse JSON, extracting summary as plain text\n", FILE_APPEND);
                        // Extract summary using regex - look for summary key
                        if (preg_match('/"summary"\s*:\s*"([^"]+)"/', $clean_text, $matches)) {
                            $analysis = ['summary' => $matches[1], 'strengths' => [], 'gaps' => []];
                            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] Extracted summary: " . $matches[1] . "\n", FILE_APPEND);
                        } else {
                            // Do not surface raw JSON fragments in UI summary.
                            // Keep summary empty so ai_build_insight_payload() can apply a human-readable fallback.
                            $analysis = ['summary' => '', 'strengths' => [], 'gaps' => []];
                        }
                    }
                    
                    if (is_array($analysis) && (isset($analysis['strengths']) || isset($analysis['summary']))) {
                        file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ✅ Analysis extracted successfully\n", FILE_APPEND);
                        
                        // Determine status based on score
                        $status = $score >= 75 ? 'Great Match' : ($score >= 60 ? 'Good Match' : ($score >= 45 ? 'Fair Match' : 'Limited Match'));

                        file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ✅ About to return analysis array\n", FILE_APPEND);
                        $return_array = ai_build_insight_payload(
                            $score,
                            $status,
                            isset($analysis['summary']) ? $analysis['summary'] : 'AI-powered match analysis',
                            isset($analysis['strengths']) ? $analysis['strengths'] : [],
                            isset($analysis['gaps']) ? $analysis['gaps'] : [],
                            true,
                            false
                        );

                        if ($alumni_id && $job_id) {
                            $cache_saved = ai_store_explanation_cache(
                                $CI,
                                $alumni_id,
                                $job_id,
                                $score,
                                $status,
                                isset($return_array['summary']) ? $return_array['summary'] : '',
                                isset($return_array['strengths']) ? $return_array['strengths'] : [],
                                isset($return_array['gaps']) ? $return_array['gaps'] : [],
                                isset($return_array['explanation_bullets']) ? $return_array['explanation_bullets'] : '',
                                $debug_log,
                                $prompt,
                                $response
                            );

                            file_put_contents(
                                $debug_log,
                                "[" . date('Y-m-d H:i:s') . "] " . ($cache_saved ? "✅" : "⚠️") . " ai_explanation_cache " . ($cache_saved ? "saved" : "not saved") . "\n",
                                FILE_APPEND
                            );
                        }

                        file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ✅ Return array built, array keys: " . implode(', ', array_keys($return_array)) . "\n", FILE_APPEND);
                        return $return_array;
                    } else {
                        file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ❌ Failed to parse JSON from response\n", FILE_APPEND);
                    }
                } else {
                    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ❌ NO API RESPONSE\n", FILE_APPEND);
                }
            } else {
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ❌ NO API RESPONSE\n", FILE_APPEND);
            }
        } catch (Exception $e) {
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] ❌ EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);
            log_message('error', "Error getting AI match insight: " . $e->getMessage());
        }

        // Fallback to template-based explanation if AI fails.
        // Persist fallback too so ai_explanation_cache is consistently populated.
        $fallback = get_fallback_match_insight($score, $alumni_degree, $job_title);

        if ($alumni_id && $job_id && is_array($fallback)) {
            $fallback_saved = ai_store_explanation_cache(
                $CI,
                $alumni_id,
                $job_id,
                $score,
                isset($fallback['status']) ? $fallback['status'] : 'Analysis',
                isset($fallback['summary']) ? $fallback['summary'] : 'Fallback match explanation',
                isset($fallback['strengths']) ? $fallback['strengths'] : [],
                isset($fallback['gaps']) ? $fallback['gaps'] : [],
                isset($fallback['explanation_bullets']) ? $fallback['explanation_bullets'] : '',
                $debug_log,
                'fallback_explanation',
                json_encode($fallback)
            );

            file_put_contents(
                $debug_log,
                "[" . date('Y-m-d H:i:s') . "] " . ($fallback_saved ? "✅" : "⚠️") . " ai_explanation_cache " . ($fallback_saved ? "saved" : "not saved") . " (fallback)\n",
                FILE_APPEND
            );
        }

        return $fallback;
    }
}

if (!function_exists('get_fallback_match_insight')) {
    function get_fallback_match_insight($score, $alumni_degree, $job_title)
    {
        $status = '';
        $strengths = [];
        $gaps = [];
        $explanation = '';

        if ($score >= 90) {
            $status = "Excellent Match";
            $strengths = [
                "Your {$alumni_degree} degree directly aligns with this {$job_title} role",
                "Technical skills closely match job requirements",
                "Strong potential to excel from day one"
            ];
            $gaps = [];
            $explanation = "Outstanding fit - your profile exceeds the position requirements.";
        } elseif ($score >= 75) {
            $status = "Great Match";
            $strengths = [
                "Your {$alumni_degree} provides solid foundation for this {$job_title} role",
                "Most required qualifications are well-matched",
                "Strong candidate with clear career alignment"
            ];
            $gaps = [];
            $explanation = "You're a strong candidate - most qualifications align well.";
        } elseif ($score >= 60) {
            $status = "Good Match";
            $strengths = [
                "Your {$alumni_degree} background is relevant to this role",
                "Several key requirements are met",
                "Potential for success with some skill development"
            ];
            $gaps = ["Some specialized skills may need development"];
            $explanation = "You meet several key requirements for this {$job_title} position.";
        } elseif ($score >= 45) {
            $status = "Fair Match";
            $strengths = [
                "Transferable knowledge from {$alumni_degree}",
                "Growth opportunity if interested in this direction"
            ];
            $gaps = [
                "Position requires more specialized expertise",
                "Significant skills development would be needed"
            ];
            $explanation = "This is a cross-field opportunity requiring some skill building.";
        } else {
            $status = "Limited Match";
            $strengths = ["Open to career exploration"];
            $gaps = [
                "Your {$alumni_degree} differs from primary focus",
                "Would require developing new technical competencies"
            ];
            $explanation = "Your background differs from this {$job_title} position requirements.";
        }

        return ai_build_insight_payload($score, $status, $explanation, $strengths, $gaps, false, false);
    }
}
