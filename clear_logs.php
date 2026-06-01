<?php
/**
 * Clear Cache Insert Logs
 */
$log_file = 'application/logs/cache_insert.log';
if (file_exists($log_file)) {
    file_put_contents($log_file, "");
    echo "Logs cleared";
} else {
    echo "No logs file found";
}
?>
