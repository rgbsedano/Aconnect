<?php
/**
 * Direct Ollama Test - Bypass CodeIgniter
 * Visit: http://localhost/Aconnect_ci3/test_ollama_direct.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Direct Ollama Test</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #1e1e1e; color: #d4d4d4; }
        .test { background: #252526; padding: 15px; margin: 10px 0; border-radius: 4px; }
        .pass { border-left: 4px solid #10b981; }
        .fail { border-left: 4px solid #ef4444; }
        pre { overflow-x: auto; max-height: 200px; }
        h2 { color: #4fc3f7; }
    </style>
</head>
<body>
<h1>🧪 Direct Ollama Test</h1>";

$ollama_host = 'http://127.0.0.1:11434';

// Test 1: Connection
echo "<h2>Test 1: Ollama Connection</h2>";
$ch = curl_init($ollama_host . '/api/tags');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<div class='test " . ($http_code === 200 ? "pass" : "fail") . "'>";
if ($http_code === 200) {
    $data = json_decode($response, true);
    echo "<pre>✅ Ollama Connected\n\nModels:\n";
    if (isset($data['models'])) {
        foreach ($data['models'] as $model) {
            echo "  • " . $model['name'] . "\n";
        }
    }
    echo "</pre>";
} else {
    echo "<pre>❌ Connection Failed (HTTP $http_code)\n$error</pre>";
}
echo "</div>";

// Test 2: Generate Forum Content (like the endpoint does)
echo "<h2>Test 2: Forum Content Generation</h2>";

$title = "One Piece Latest Chapter";
$content = "Imu tells the lore of the four gods";

$prompt = "You are an editor for an alumni network forum. Please refine and enhance the following forum post for better clarity and impact:\n\n" .
         "Current Title: \"" . $title . "\"\n" .
         "Current Content: \"" . $content . "\"\n\n" .
         "Improve the title to be more engaging (max 100 chars) and enhance the content to be more compelling and clear (max 500 chars).\n" .
         "Also provide concise reasons for each improvement (max 140 chars each).\n" .
         "Provide the refined 'title', 'content', 'reason_title', and 'reason_content'. Your response must be valid JSON only with these exact fields: {\"title\": \"...\", \"content\": \"...\", \"reason_title\": \"...\", \"reason_content\": \"...\"}";

$payload = [
    'model' => 'gemma:4b',
    'prompt' => $prompt,
    'stream' => false,
    'format' => 'json',
    'temperature' => 1.0,
    'options' => ['temperature' => 1.0],
    'system' => 'You are a helpful assistant that only outputs JSON. Do not include markdown code blocks. Return only the raw object with title, content, reason_title, and reason_content fields.'
];

echo "<div class='test'><pre>Request Payload:\n" . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "</pre></div>";

$ch = curl_init($ollama_host . '/api/generate');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

echo "<div class='test'>Waiting for Ollama response (this may take 10-30 seconds)...</div>";

$start = time();
$response = curl_exec($ch);
$elapsed = time() - $start;
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<div class='test " . ($http_code === 200 ? "pass" : "fail") . "'>";
echo "<pre>HTTP Code: $http_code\nTime: {$elapsed}s\n";

if ($error) {
    echo "Error: $error\n";
} else {
    $data = json_decode($response, true);
    if ($data) {
        echo "Response Keys: " . implode(", ", array_keys($data)) . "\n";
        if (isset($data['response'])) {
            echo "\nGenerated Content (first 300 chars):\n";
            echo substr($data['response'], 0, 300) . "...\n";
            
            // Try to parse as JSON
            $json_attempt = json_decode($data['response'], true);
            if ($json_attempt) {
                echo "\n✅ Valid JSON parsed!\n";
                echo json_encode($json_attempt, JSON_PRETTY_PRINT);
            } else {
                echo "\n⚠️ Response is not valid JSON\n";
            }
        }
    }
}
echo "</pre></div>";

echo "</body></html>";
?>
