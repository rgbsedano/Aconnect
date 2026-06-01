<?php
// Direct SQL to add the column
require_once 'application/config/database.php';

$config = $db['default'];

$mysqli = new mysqli(
    $config['hostname'],
    $config['username'],
    $config['password'],
    $config['database']
);

if ($mysqli->connect_error) {
    die('❌ Connection failed: ' . $mysqli->connect_error);
}

// Check if column already exists
$result = $mysqli->query("SHOW COLUMNS FROM ai_explanation_cache LIKE 'explanation_bullets'");
if ($result->num_rows == 0) {
    $sql = "ALTER TABLE ai_explanation_cache ADD COLUMN explanation_bullets LONGTEXT NULL COMMENT 'Formatted bullet points of strengths and gaps'";
    if ($mysqli->query($sql)) {
        echo "✅ Column 'explanation_bullets' added successfully!\n";
    } else {
        echo "❌ Error: " . $mysqli->error . "\n";
    }
} else {
    echo "ℹ️ Column already exists\n";
}

echo "\n📋 Columns:\n";
$result = $mysqli->query("SHOW COLUMNS FROM ai_explanation_cache");
while($row = $result->fetch_assoc()) {
    echo "  • " . str_pad($row['Field'], 25) . " " . $row['Type'] . "\n";
}

$mysqli->close();
?>
