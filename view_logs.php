<?php
/**
 * View Cache Insert Logs
 * Visit: http://localhost/Aconnect_ci3/view_logs.php
 */

$log_file = 'application/logs/cache_insert.log';

if (!file_exists($log_file)) {
    echo "<h2>❌ No logs yet</h2>";
    echo "<p>Click a match badge on the jobs page to generate logs.</p>";
    exit;
}

$logs = file_get_contents($log_file);
$lines = array_reverse(explode("\n", $logs));

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cache Insert Logs</title>
    <style>
        body { font-family: monospace; background: #1e1e1e; color: #d4d4d4; padding: 20px; }
        h1 { color: #4fc3f7; }
        .log-container { background: #252526; border: 1px solid #3e3e42; border-radius: 5px; padding: 15px; max-height: 600px; overflow-y: auto; }
        .log-line { padding: 8px; border-bottom: 1px solid #3e3e42; line-height: 1.6; }
        .log-line:hover { background: #2d2d30; }
        .success { color: #4ec9b0; }
        .error { color: #f48771; }
        .info { color: #9cdcfe; }
        button { background: #0e639c; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 3px; margin-top: 10px; }
        button:hover { background: #1177bb; }
    </style>
</head>
<body>
    <h1>📋 Cache Insert Logs</h1>
    <p>Last 50 entries (most recent first):</p>
    
    <div class="log-container">
        <?php
        $count = 0;
        foreach ($lines as $line) {
            if ($count >= 50 || trim($line) === '') continue;
            $count++;
            
            $class = 'info';
            if (strpos($line, 'SUCCESS') !== false) {
                $class = 'success';
            } elseif (strpos($line, 'ERROR') !== false || strpos($line, 'FAILED') !== false) {
                $class = 'error';
            }
            
            echo "<div class='log-line $class'>" . htmlspecialchars($line) . "</div>";
        }
        ?>
    </div>
    
    <button onclick="location.reload()">🔄 Refresh Logs</button>
    <button onclick="if(confirm('Clear logs?')) { fetch('clear_logs.php').then(() => location.reload()); }">🗑️ Clear Logs</button>
</body>
</html>
?>
