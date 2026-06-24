<?php
// Direct database check - no CodeIgniter routing
$mysqli = new mysqli('localhost', 'root', '', 'aconnect_db');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "<h2>All Group Assignments</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Group ID</th><th>Group Name</th><th>Employer ID</th><th>Employer Name</th><th>Assigned At</th></tr>";

$sql = "SELECT ega.id, ega.group_id, eg.group_name, ega.employer_id, e.company_name, ega.assigned_at 
        FROM employer_group_assignments ega
        LEFT JOIN employer_groups eg ON ega.group_id = eg.id
        LEFT JOIN employers e ON ega.employer_id = e.id
        ORDER BY ega.group_id, ega.id";

$result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['group_id'] . "</td>";
    echo "<td>" . $row['group_name'] . "</td>";
    echo "<td>" . $row['employer_id'] . "</td>";
    echo "<td>" . $row['company_name'] . "</td>";
    echo "<td>" . $row['assigned_at'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h2>Count Per Group</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Group ID</th><th>Group Name</th><th>Member Count</th></tr>";

$sql2 = "SELECT eg.id, eg.group_name, COUNT(ega.id) as count 
         FROM employer_groups eg
         LEFT JOIN employer_group_assignments ega ON eg.id = ega.group_id
         GROUP BY eg.id, eg.group_name
         ORDER BY eg.id DESC";

$result2 = $mysqli->query($sql2);

while ($row = $result2->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['group_name'] . "</td>";
    echo "<td>" . $row['count'] . "</td>";
    echo "</tr>";
}
echo "</table>";

$mysqli->close();
?>
