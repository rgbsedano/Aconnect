<?php
// Direct CLI test - bypass authentication
define('BASEPATH', dirname(__FILE__) . '/system/');
define('APPPATH', dirname(__FILE__) . '/application/');
define('FCPATH', dirname(__FILE__) . '/');

require_once(APPPATH . 'config/config.php');
require_once(APPPATH . 'config/database.php');
require_once(BASEPATH . 'core/CodeIgniter.php');

// Initialize CodeIgniter components
$CI = &get_instance();
$CI->load->config('ollama');
$CI->load->helper('ai');

echo "=== Direct Ollama API Test ===\n\n";

// Test 1: Check config
echo "1. Testing Ollama Config:\n";
$host = rtrim((string)$CI->config->item('ollama_host'), '/');
$model = $CI->config->item('ollama_model');
$temp = $CI->config->item('ollama_temperature');

echo "   Host: " . ($host ?: "NOT SET") . "\n";
echo "   Model: " . ($model ?: "NOT SET") . "\n";
echo "   Temperature: " . ($temp ?: "NOT SET") . "\n";

// Test 2: Call Ollama API directly
echo "\n2. Calling Ollama API with simple prompt...\n";

$prompt = "Say hello in one word.";
$result = call_ollama_api($prompt, [
    'temperature' => 0.7,
    'format' => 'json',
    'max_tokens' => 50
]);

if ($result === false) {
    echo "   ERROR: call_ollama_api returned false\n";
} else {
    echo "   SUCCESS: Got response\n";
    echo "   Response: " . json_encode($result) . "\n";
}

// Test 3: Try with the actual forum prompt
echo "\n3. Testing with forum AI prompt...\n";

$forum_prompt = "You are an editor for an alumni network forum. Please refine and enhance the following forum post for better clarity and impact:\n\n" .
                "Current Title: \"One Piece Latest\"\n" .
                "Current Content: \"IMU tells the lore of the Four Gods\"\n\n" .
                "Improve the title to be more engaging (max 100 chars) and enhance the content to be more compelling and clear (max 500 chars).\n" .
                "Also provide concise reasons for each improvement (max 140 chars each).\n" .
                "Provide the refined 'title', 'content', 'reason_title', and 'reason_content'. Your response must be valid JSON only with these exact fields: {\"title\": \"...\", \"content\": \"...\", \"reason_title\": \"...\", \"reason_content\": \"...\"}";

$forum_result = call_ollama_api($forum_prompt, [
    'temperature' => 1.0,
    'format' => 'json',
    'max_tokens' => 500,
    'system' => 'You are a helpful assistant that only outputs JSON. Do not include markdown code blocks. Return only the raw object with title, content, reason_title, and reason_content fields.'
]);

if ($forum_result === false) {
    echo "   ERROR: call_ollama_api returned false\n";
} else {
    echo "   SUCCESS: Got response\n";
    if (is_array($forum_result)) {
        $text = ai_extract_candidate_text($forum_result);
        echo "   Extracted text: " . $text . "\n";
    }
}

// Show debug logs
echo "\n\n=== Debug Logs ===\n";

if (file_exists(APPPATH . 'logs/ai_debug.log')) {
    echo "\nAI Debug Log:\n";
    $content = file_get_contents(APPPATH . 'logs/ai_debug.log');
    echo $content;
} else {
    echo "No AI debug log\n";
}

if (file_exists(APPPATH . 'logs/forum_ai_debug.log')) {
    echo "\nForum Debug Log:\n";
    $content = file_get_contents(APPPATH . 'logs/forum_ai_debug.log');
    echo $content;
} else {
    echo "No forum debug log\n";
}
?>
