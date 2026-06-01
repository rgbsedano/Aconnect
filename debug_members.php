<?php
// Load CodeIgniter
require_once('./application/config/database.php');

$config = array();
// Include database config (adjust as needed)
$mysqli = new mysqli('localhost', 'root', '', 'aconnect_db');

if ($mysqli->connect_error) {
    echo "Connection failed: " . $mysqli->connect_error;
    exit;
}

// Check all assignments
echo "=== ALL EMPLOYER GROUP ASSIGNMENTS ===\n";
$result = $mysqli->query("SELECT ega.id, ega.employer_id, ega.group_id, eg.group_name, e.company_name 
FROM employer_group_assignments ega 
LEFT JOIN employer_groups eg ON ega.group_id = eg.id 
LEFT JOIN employers e ON ega.employer_id = e.id 
ORDER BY ega.group_id");

while ($row = $result->fetch_assoc()) {
    echo json_encode($row) . "\n";
}

// Check count per group
echo "\n=== COUNT PER GROUP ===\n";
$result = $mysqli->query("SELECT group_id, COUNT(*) as count FROM employer_group_assignments GROUP BY group_id");
while ($row = $result->fetch_assoc()) {
    echo "Group ID: " . $row['group_id'] . " - Count: " . $row['count'] . "\n";
}

$mysqli->close();
?>
