<?php
$mysqli = new mysqli('localhost', 'root', '', 'aconnect_db');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "<h2>All Employers</h2>";
$sql = "SELECT id, company_name, email FROM employers ORDER BY id";
$result = $mysqli->query($sql);

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Company Name</th><th>Email</th></tr>";

$count = 0;
while ($row = $result->fetch_assoc()) {
    $count++;
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['company_name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<p>Total employers: " . $count . "</p>";

$mysqli->close();
?>
