<?php
// Direct Ollama test without CodeIgniter loading

echo "╔════════════════════════════════════════════╗\n";
echo "║   Direct Ollama API Test (No CI)           ║\n";
echo "╚════════════════════════════════════════════╝\n\n";

// Hardcoded Ollama config (same as in config/ollama.php)
$host = getenv('OLLAMA_HOST') ?: 'http://127.0.0.1:11434';
$model = getenv('OLLAMA_MODEL') ?: 'gemma4:e4b';
$timeout = (int)(getenv('OLLAMA_TIMEOUT') ?: 60);
$temperature = (float)(getenv('OLLAMA_TEMPERATURE') ?: 0.3);

echo "1. Configuration:\n";
echo "   Host: $host\n";
echo "   Model: $model\n";
echo "   Timeout: $timeout sec\n";
echo "   Temperature: $temperature\n\n";

// Test 1: Simple test
echo "2. Simple test (5 word response):\n";

$url = rtrim($host, '/') . '/api/generate';
$payload = [
    'model' => $model,
    'prompt' => 'Say five words.',
    'stream' => false,
    'format' => 'json'
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200 && $response) {
    $json = json_decode($response, true);
    echo "   ✅ Response: " . $json['response'] . "\n\n";
} else {
    echo "   ❌ HTTP $http_code\n\n";
}

// Test 2: Forum AI test
echo "3. Forum AI Content Generation (may take 30-60 seconds):\n";
echo "   Mode: both (edit title & content)\n";

$forum_prompt = <<<'PROMPT'
You are an editor for an alumni network forum. Please refine and enhance the following forum post for better clarity and impact:

Current Title: "One Piece Latest Chapter"
Current Content: "IMU tells the lore of the Four Gods"

Improve the title to be more engaging (max 100 chars) and enhance the content to be more compelling and clear (max 500 chars).
Also provide concise reasons for each improvement (max 140 chars each).
Provide the refined 'title', 'content', 'reason_title', and 'reason_content'. Your response must be valid JSON only with these exact fields: {"title": "...", "content": "...", "reason_title": "...", "reason_content": "..."}
PROMPT;

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
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$start = time();
echo "   Sending request... ";
flush();

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$elapsed = time() - $start;
curl_close($ch);

echo "(" . $elapsed . "s)\n";

if ($http_code !== 200) {
    echo "   ❌ HTTP Error: $http_code\n";
    echo "   Response: " . substr($response, 0, 200) . "\n";
} else {
    $json = json_decode($response, true);
    if (!isset($json['response'])) {
        echo "   ❌ Invalid response structure\n";
    } else {
        $text = $json['response'];
        echo "   ✅ Got Ollama response (" . strlen($text) . " chars)\n\n";
        
        // Try to parse the JSON
        $extracted = json_decode($text, true);
        
        if ($extracted && isset($extracted['title'])) {
            echo "   ✅ Successfully extracted JSON!\n\n";
            echo "   Refined Title: " . $extracted['title'] . "\n";
            echo "   Refined Content: " . substr($extracted['content'], 0, 100) . (strlen($extracted['content']) > 100 ? "..." : "") . "\n";
            echo "   Why Title Better: " . $extracted['reason_title'] . "\n";
            echo "   Why Content Better: " . substr($extracted['reason_content'], 0, 80) . (strlen($extracted['reason_content']) > 80 ? "..." : "") . "\n";
        } else {
            echo "   ⚠️ Could not parse JSON from response\n";
            echo "   Raw response:\n";
            echo $text . "\n";
        }
    }
}

echo "\n✅ Test completed\n";
?>
