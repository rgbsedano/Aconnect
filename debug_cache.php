<?php
/**
 * Debug Cache Table - Check if table exists and show stored data
 * Visit: http://localhost/Aconnect_ci3/debug_cache.php
 */

// Create connection to aconnect_db
$mysqli = new mysqli(
    'localhost',
    'root', 
    '',
    'aconnect_db'
);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cache Debug</title>
    <meta http-equiv="refresh" content="3">
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        h1, h3 { color: #333; }
        table { border-collapse: collapse; width: 100%; background: white; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #2c3e50; color: white; }
        tr:hover { background: #f9f9f9; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        .container { max-width: 1000px; margin: 0 auto; }
        .buttons { margin: 20px 0; }
        button { background: #3498db; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 3px; margin-right: 10px; }
        button:hover { background: #2980b9; }
    </style>
</head>
<body>
<div class="container">

<h1>🔍 Cache Table Debug</h1>
<p>Auto-refreshing every 3 seconds...</p>

<?php
// Check if table exists
$result = $mysqli->query("SHOW TABLES LIKE 'ai_explanation_cache'");
if ($result->num_rows > 0) {
    echo "<p class='success'>✅ Table EXISTS</p>";
    
    // Show stored data
    $data = $mysqli->query("SELECT * FROM ai_explanation_cache ORDER BY created_at DESC LIMIT 10");
    echo "<h3>Stored Records (" . $data->num_rows . " records):</h3>";
    
    if ($data->num_rows > 0) {
        echo "<table>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>Alumni ID</th><th>Job ID</th><th>Match %</th><th>Status</th><th>Strengths</th><th>Gaps</th><th>Created</th>";
        echo "</tr>";
        while ($row = $data->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['alumni_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['job_id']) . "</td>";
            echo "<td><strong>" . htmlspecialchars($row['match_percentage']) . "%</strong></td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "<td>" . (strlen($row['strengths']) > 50 ? substr($row['strengths'], 0, 50) . "..." : $row['strengths']) . "</td>";
            echo "<td>" . (strlen($row['gaps']) > 50 ? substr($row['gaps'], 0, 50) . "..." : $row['gaps']) . "</td>";
            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='warning'>⚠️ No data stored yet</p>";
        echo "<p><strong>Next steps:</strong></p>";
        echo "<ol>";
        echo "<li>Go to jobs page</li>";
        echo "<li>Click a match % badge</li>";
        echo "<li>Check <a href='view_logs.php' target='_blank'>view_logs.php</a> to see debug output</li>";
        echo "</ol>";
    }
} else {
    echo "<p class='error'>❌ Table DOES NOT EXIST</p>";
}

?>

<div class="buttons">
    <button onclick="location.reload()">🔄 Refresh Now</button>
    <button onclick="window.open('view_logs.php', '_blank')">📋 View Logs</button>
</div>

</div>
</body>
</html>

<?php $mysqli->close(); ?>

