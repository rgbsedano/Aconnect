<?php
// Simple direct test of ollama API without full CodeIgniter
define('APPPATH', dirname(__FILE__) . '/application/');

echo "╔════════════════════════════════════════════╗\n";
echo "║   Direct Ollama API Test                   ║\n";
echo "╚════════════════════════════════════════════╝\n\n";

// Load config
$config = [];
require_once(APPPATH . 'config/ollama.php');

// Test 1: Check config
echo "1. Configuration:\n";
echo "   Host: " . $config['ollama_host'] . "\n";
echo "   Model: " . $config['ollama_model'] . "\n";
echo "   Timeout: " . $config['ollama_timeout'] . " sec\n";
echo "   Temperature: " . $config['ollama_temperature'] . "\n";
echo "   Enabled: " . ($config['ollama_enabled'] ? 'yes' : 'no') . "\n\n";

// Test 2: Simple API call
echo "2. Testing simple cURL request:\n";

$host = rtrim($config['ollama_host'], '/');
$url = $host . '/api/generate';
$model = $config['ollama_model'];

$payload = [
    'model' => $model,
    'prompt' => 'Create an engaging forum post about recent tech innovations. Keep it to 50 words. Respond with JSON: {"title": "...", "content": "..."}',
    'stream' => false,
    'format' => 'json'
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, $config['ollama_timeout']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

echo "   Sending request to: $url\n";
echo "   Model: $model\n";
echo "   Waiting for response...\n\n";

$start = microtime(true);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
$time = microtime(true) - $start;
curl_close($ch);

echo "   HTTP Code: $http_code\n";
echo "   Time: " . number_format($time, 2) . " seconds\n";
echo "   Response length: " . strlen($response) . " bytes\n\n";

if ($curl_error) {
    echo "   ❌ Error: $curl_error\n";
} elseif ($http_code !== 200) {
    echo "   ❌ HTTP Error $http_code\n";
    echo "   Response: " . $response . "\n";
} else {
    $json = json_decode($response, true);
    echo "   ✅ Success!\n";
    
    if (isset($json['response'])) {
        echo "   Response field: " . $json['response'] . "\n\n";
        
        // Try to extract JSON from response
        $response_text = $json['response'];
        $extracted = json_decode($response_text, true);
        
        if ($extracted) {
            echo "3. Parsed JSON from Ollama response:\n";
            echo json_encode($extracted, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
        } else {
            echo "3. Ollama response (raw):\n";
            echo $response_text . "\n";
        }
    }
}

// Test 3: Try the forum generation prompt
echo "\n\n4. Testing forum post generation prompt:\n";
echo "   Mode: both (edit title & content)\n";

$forum_prompt = "You are an editor for an alumni network forum. Please refine and enhance the following forum post for better clarity and impact:\n\n" .
                "Current Title: \"One Piece Latest Chapter\"\n" .
                "Current Content: \"IMU tells the lore of the Four Gods\"\n\n" .
                "Improve the title to be more engaging (max 100 chars) and enhance the content to be more compelling and clear (max 500 chars).\n" .
                "Also provide concise reasons for each improvement (max 140 chars each).\n" .
                "Provide the refined 'title', 'content', 'reason_title', and 'reason_content'. Your response must be valid JSON only with these exact fields: {\"title\": \"...\", \"content\": \"...\", \"reason_title\": \"...\", \"reason_content\": \"...\"}";

$payload = [
    'model' => $model,
    'prompt' => $forum_prompt,
    'stream' => false,
    'format' => 'json',
    'system' => 'You are a helpful assistant that only outputs JSON. Do not include markdown code blocks. Return only the raw object with title, content, reason_title, and reason_content fields.',
    'options' => [
        'temperature' => 1.0,
        'num_predict' => 500
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

echo "   Waiting for response (this may take 30-60 seconds)...\n";

$start = microtime(true);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
$time = microtime(true) - $start;
curl_close($ch);

echo "   Time: " . number_format($time, 2) . " seconds\n";
echo "   HTTP Code: $http_code\n\n";

if (!$curl_error && $http_code === 200) {
    $json = json_decode($response, true);
    if (isset($json['response'])) {
        echo "   ✅ Ollama responded successfully!\n\n";
        echo "   Response:\n";
        echo "   " . substr($json['response'], 0, 200) . (strlen($json['response']) > 200 ? "..." : "") . "\n\n";
        
        // Try to parse it
        $extracted = json_decode($json['response'], true);
        if ($extracted && isset($extracted['title'], $extracted['content'])) {
            echo "   ✅ Successfully parsed forum AI response:\n";
            echo "   Title: " . $extracted['title'] . "\n";
            echo "   Content: " . $extracted['content'] . "\n";
            echo "   Reason (Title): " . $extracted['reason_title'] . "\n";
            echo "   Reason (Content): " . $extracted['reason_content'] . "\n";
        } else {
            echo "   Response text:\n";
            echo $json['response'] . "\n";
        }
    }
} else {
    echo "   ❌ Error: " . ($curl_error ?: "HTTP $http_code") . "\n";
}

echo "\n✅ Direct test completed\n";
?>
