<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$payload = json_encode([
    'model' => 'gemma4:e4b',
    'prompt' => 'Reply with exactly one word: hello',
    'stream' => false,
    'format' => 'json',
]);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => $payload,
        'timeout' => 60,
    ],
]);

$response = @file_get_contents('http://127.0.0.1:11434/api/generate', false, $context);
if ($response === false) {
    echo "request_failed\n";
    var_dump(error_get_last());
    exit(1);
}

echo "response_length=" . strlen($response) . "\n";
echo $response . "\n";
