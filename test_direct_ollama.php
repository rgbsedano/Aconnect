<?php
// Direct test without full CodeIgniter bootstrap
$app_path = dirname(__FILE__) . '/application/';

// Manually define what we need
if (!defined('APPPATH')) {
    define('APPPATH', $app_path);
}
if (!defined('BASEPATH')) {
    define('BASEPATH', dirname(__FILE__) . '/system/');
}

// Load the config file
$config = [];
require_once($app_path . 'config/ollama.php');

// Create a mock CI instance
class MockCI {
    public $items = [];
    
    public function item($key) {
        return $this->items[$key] ?? null;
    }
    
    public function load_helper($name) {
        // helpers are loaded as functions, we'll just require the file
        require_once(APPPATH . 'helpers/' . $name . '_helper.php');
    }
}

// Set up config items
$CI = new MockCI();
$CI->items = [
    'ollama_host' => 'http://127.0.0.1:11434',
    'ollama_model' => 'gemma4:e4b',
    'ollama_timeout' => 60,
    'ollama_temperature' => 0.7,
    'ollama_enabled' => true
];

// Create a global reference
$GLOBALS['_ci_instance'] = $CI;

function &get_instance() {
    return $GLOBALS['_ci_instance'];
}

// Now manually include the ai_helper to test it
echo "=== Testing call_ollama_api directly ===\n\n";

// Test by calling cURL directly without the helper first
echo "1. Testing direct cURL to Ollama:\n";

$host = 'http://127.0.0.1:11434';
$url = $host . '/api/generate';

$payload = [
    'model' => 'gemma4:e4b',
    'prompt' => 'Say hello in one word.',
    'stream' => false,
    'format' => 'json'
];

echo "   URL: $url\n";
echo "   Payload: " . json_encode($payload) . "\n";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

echo "   Executing cURL...\n";
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

echo "   HTTP Code: $http_code\n";
echo "   cURL Error: " . ($curl_error ?: "none") . "\n";
echo "   Response length: " . strlen($response) . " bytes\n";
echo "   Response: " . (strlen($response) > 500 ? substr($response, 0, 500) . "..." : $response) . "\n";

// Now test the helper function
echo "\n2. Testing call_ollama_api helper function:\n";

// Load the helper
require_once(APPPATH . 'helpers/ai_helper.php');

// Create a mock config loader
$CI->load = new class {
    public function config($name) {
        // Config is already loaded
    }
};

// Test it
$result = call_ollama_api('Say hello in two words.', ['temperature' => 0.7]);
echo "   Result: " . ($result === false ? "FALSE" : json_encode($result)) . "\n";

// Show logs if they exist
echo "\n\n=== Logs ===\n";
if (file_exists(APPPATH . 'logs/ai_debug.log')) {
    echo "\nAI Debug Log:\n";
    echo file_get_contents(APPPATH . 'logs/ai_debug.log');
} else {
    echo "No AI debug log\n";
}

if (file_exists(APPPATH . 'logs/forum_ai_debug.log')) {
    echo "\nForum AI Debug Log:\n";
    echo file_get_contents(APPPATH . 'logs/forum_ai_debug.log');
} else {
    echo "No forum AI debug log\n";
}
?>
