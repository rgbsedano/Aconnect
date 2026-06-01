<?php
// Check available Ollama models
$url = 'http://127.0.0.1:11434/api/tags';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

echo "Available Ollama Models:\n";
echo "========================\n\n";

if ($curl_error) {
    echo "Error: " . $curl_error . "\n";
} elseif ($http_code !== 200) {
    echo "HTTP Error: " . $http_code . "\n";
    echo "Response: " . $response . "\n";
} else {
    $models = json_decode($response, true);
    if (isset($models['models'])) {
        foreach ($models['models'] as $model) {
            echo "Model: " . $model['name'] . "\n";
            echo "  Size: " . (isset($model['size']) ? ($model['size'] / 1024 / 1024 / 1024) . " GB" : "unknown") . "\n";
            echo "  Modified: " . (isset($model['modified_at']) ? $model['modified_at'] : "unknown") . "\n\n";
        }
    } else {
        echo "Response: " . $response . "\n";
    }
}
?>
