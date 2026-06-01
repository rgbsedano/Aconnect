<?php
/**
 * Debug Ollama Connection
 * Visit: http://localhost/Aconnect_ci3/debug_ollama.php
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Ollama Debug</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #1e1e1e; color: #d4d4d4; }
        .test { background: #252526; padding: 15px; margin: 10px 0; border-left: 4px solid #007acc; border-radius: 4px; }
        .pass { border-left-color: #10b981; }
        .fail { border-left-color: #ef4444; }
        pre { overflow-x: auto; }
    </style>
</head>
<body>
<h1>🔍 Ollama Connection Debug</h1>";

// Test 1: Connection
echo "<div class='test'><strong>1. Basic Connection Test</strong></div>";
$ollama_host = 'http://127.0.0.1:11434';
$ch = curl_init($ollama_host . '/api/tags');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($http_code === 200) {
    echo "<div class='test pass'><pre>✅ Connected to Ollama\n" . json_encode(json_decode($response), JSON_PRETTY_PRINT) . "</pre></div>";
} else {
    echo "<div class='test fail'><pre>❌ Connection Failed\nHTTP Code: $http_code\nError: $error</pre></div>";
}

// Test 2: Generate with Ollama
echo "<div class='test'><strong>2. Test Simple Generation</strong></div>";

$test_prompt = "Write one sentence about the One Piece latest chapter. Keep it short.";
$request_data = [
    'model' => 'gemma:4b',
    'prompt' => $test_prompt,
    'stream' => false,
    'format' => 'json',
    'temperature' => 1.0
];

$ch = curl_init($ollama_host . '/api/generate');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($http_code === 200) {
    $data = json_decode($response, true);
    echo "<div class='test pass'><pre>✅ Generated Response\n\nStatus: " . ($data['done'] ? 'DONE' : 'STREAMING') . "\nResponse:\n" . (isset($data['response']) ? substr($data['response'], 0, 200) : 'N/A') . "</pre></div>";
} else {
    echo "<div class='test fail'><pre>❌ Generation Failed\nHTTP Code: $http_code\nError: $error\nResponse:\n" . substr($response, 0, 500) . "</pre></div>";
}

// Test 3: JSON Format Test
echo "<div class='test'><strong>3. Test JSON Output Format</strong></div>";

$json_prompt = 'Respond with ONLY valid JSON: {"test": "works"}';
$request_data = [
    'model' => 'gemma:4b',
    'prompt' => $json_prompt,
    'stream' => false,
    'temperature' => 0.1
];

$ch = curl_init($ollama_host . '/api/generate');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    $data = json_decode($response, true);
    $output = $data['response'] ?? '';
    echo "<div class='test pass'><pre>✅ JSON Test\n\nPrompt: $json_prompt\nOutput:\n$output</pre></div>";
} else {
    echo "<div class='test fail'><pre>❌ JSON Test Failed\nHTTP Code: $http_code</pre></div>";
}

echo "</body></html>";
?>
