<?php
// Clear old logs
$forum_log = 'application/logs/forum_ai_debug.log';
$ai_log = 'application/logs/ai_debug.log';

if (file_exists($forum_log)) {
    unlink($forum_log);
}
if (file_exists($ai_log)) {
    unlink($ai_log);
}

// Call the forum endpoint
$url = 'http://localhost/aconnect_ci3/forum/generate_ai_content?mode=both&title=test+topic&content=test+content';
$response = @file_get_contents($url);

echo "<h2>API Response:</h2>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";

// Display logs
echo "<h2>Forum Debug Log:</h2>";
if (file_exists($forum_log)) {
    echo "<pre>" . htmlspecialchars(file_get_contents($forum_log)) . "</pre>";
} else {
    echo "No forum debug log found";
}

echo "<h2>AI Debug Log:</h2>";
if (file_exists($ai_log)) {
    echo "<pre>" . htmlspecialchars(file_get_contents($ai_log)) . "</pre>";
} else {
    echo "No AI debug log found";
}

// Also show CodeIgniter logs
$ci_log = 'application/logs/log-' . date('Y-m-d') . '.php';
echo "<h2>CodeIgniter Log:</h2>";
if (file_exists($ci_log)) {
    $content = file_get_contents($ci_log);
    $content = str_replace('<?php  ?>' . "\n", '', $content);
    echo "<pre>" . htmlspecialchars(substr($content, -2000)) . "</pre>";
} else {
    echo "No CodeIgniter log found for today";
}
?>
