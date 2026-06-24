<?php
/**
 * View Forum AI Debug Logs
 * Visit: http://localhost/Aconnect_ci3/scripts/view_forum_debug.php
 */

$log_file = 'd:\xamp1\htdocs\Aconnect_ci3\application\logs\forum_ai_debug.log';

if (!file_exists($log_file)) {
    echo "No debug log file yet. Try generating content first.";
    exit;
}

$logs = file_get_contents($log_file);
$lines = array_reverse(explode("\n", $logs));

?>
<!DOCTYPE html>
<html>
<head>
    <title>Forum AI Debug Log</title>
    <style>
        body { font-family: monospace; background: #1e1e1e; color: #d4d4d4; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { color: #4fc3f7; }
        .log { background: #252526; padding: 20px; border-radius: 4px; max-height: 600px; overflow-y: auto; border-left: 4px solid #007acc; }
        .line { padding: 4px 0; line-height: 1.6; }
        .error { color: #f48771; }
        .success { color: #4ec9b0; }
        .info { color: #9cdcfe; }
        button { background: #0e639c; color: white; border: none; padding: 10px 20px; cursor: pointer; margin-top: 10px; border-radius: 3px; }
        button:hover { background: #1177bb; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔍 Forum AI Debug Log</h1>
    <p>Last 100 lines (most recent first):</p>
    <div class="log">
        <?php
        $count = 0;
        foreach ($lines as $line) {
            if ($count >= 100 || trim($line) === '') continue;
            $count++;
            
            $class = 'info';
            if (strpos($line, 'ERROR') !== false || strpos($line, 'error') !== false) {
                $class = 'error';
            } elseif (strpos($line, 'SUCCESS') !== false || strpos($line, 'success') !== false) {
                $class = 'success';
            }
            
            echo "<div class='line $class'>" . htmlspecialchars($line) . "</div>";
        }
        ?>
    </div>
    <button onclick="location.reload()">🔄 Refresh</button>
    <button onclick="fetch('d:\\xamp1\\htdocs\\Aconnect_ci3\\application\\logs\\forum_ai_debug.log').then(r => r.text()).then(t => {const e = document.createElement('a'); e.href = URL.createObjectURL(new Blob([t], {type: 'text/plain'})); e.download = 'forum_ai_debug.log'; e.click();})">📥 Download Log</button>
</div>
</body>
</html>
