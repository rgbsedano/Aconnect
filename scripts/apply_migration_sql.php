<?php
// Apply SQL migration using local DB config
define('BASEPATH', __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR);
require_once __DIR__ . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';

if (! isset($db) || ! isset($db['default'])) {
    echo "Database configuration not found in application/config/database.php\n";
    exit(1);
}

$cfg = $db['default'];
$host = $cfg['hostname'] ?? 'localhost';
$user = $cfg['username'] ?? 'root';
$pass = $cfg['password'] ?? '';
$name = $cfg['database'] ?? '';

echo "Connecting to database {$name}@{$host} as {$user}\n";

$mysqli = new mysqli($host, $user, $pass, $name);
if ($mysqli->connect_errno) {
    echo "DB connect failed: ({$mysqli->connect_errno}) {$mysqli->connect_error}\n";
    exit(1);
}

$sqlFile = __DIR__ . DIRECTORY_SEPARATOR . 'add_approval_status_to_employers.sql';
if (! file_exists($sqlFile)) {
    echo "SQL file not found: {$sqlFile}\n";
    exit(1);
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    echo "Failed to read SQL file\n";
    exit(1);
}

if ($mysqli->multi_query($sql)) {
    do {
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
    echo "SQL applied successfully.\n";
} else {
    echo "SQL error: ({$mysqli->errno}) {$mysqli->error}\n";
    exit(1);
}

$mysqli->close();
