<?php
// Direct Database Check - No CodeIgniter needed
// Place this in /check_standing_direct.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Load database config
$config = require 'application/config/database.php';
$db_config = $config['default'];

// Connect to database
$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get alumni_id from session or from GET parameter
$alumni_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_SESSION['alumni_id']) ? $_SESSION['alumni_id'] : 1);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Standing Score Check</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        h2 { color: #a12124; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #a12124; color: white; }
        .total { font-size: 20px; color: #a12124; font-weight: bold; background: #fffbeb; padding: 15px; margin-top: 20px; }
        .info { background: #d1ecf1; padding: 10px; border-radius: 4px; margin: 10px 0; }
    </style>
</head>
<body>
<div class='container'>
    <h2>Standing Points Check</h2>
    <div class='info'>
        <strong>Alumni ID:</strong> $alumni_id
        (Change with ?id=NUMBER in URL)
    </div>";

// 1. Get posts count
$result = $conn->query("SELECT COUNT(*) as count FROM forum_posts WHERE alumni_id = $alumni_id");
$post_row = $result->fetch_assoc();
$post_count = $post_row['count'];
$post_points = $post_count * 5;

echo "<p><strong>Posts Created:</strong> $post_count posts × 5 points = $post_points points</p>";

if ($post_count == 0) {
    echo "<p style='color: red;'><strong>No posts found! Create posts to earn points.</strong></p>";
    echo "</div></body></html>";
    $conn->close();
    exit;
}

// 2. Get likes
$result = $conn->query("
    SELECT COUNT(*) as count 
    FROM forum_likes fl 
    INNER JOIN forum_posts fp ON fl.post_id = fp.id 
    WHERE fp.alumni_id = $alumni_id
");
$like_row = $result->fetch_assoc();
$like_count = $like_row['count'];
$like_points = $like_count * 2;

// 3. Get dislikes
$result = $conn->query("
    SELECT COUNT(*) as count 
    FROM forum_dislike fd 
    INNER JOIN forum_posts fp ON fd.post_id = fp.id 
    WHERE fp.alumni_id = $alumni_id
");
$dislike_row = $result->fetch_assoc();
$dislike_count = $dislike_row['count'];
$dislike_points = $dislike_count * 1;

// 4. Get reports
$result = $conn->query("
    SELECT COUNT(*) as count 
    FROM forum_reports fr 
    INNER JOIN forum_posts fp ON fr.post_id = fp.id 
    WHERE fp.alumni_id = $alumni_id
");
$report_row = $result->fetch_assoc();
$report_count = $report_row['count'];
$report_points = $report_count * 10;

// Calculate total
$total = $post_points + $like_points - $dislike_points - $report_points;

echo "<table>";
echo "<tr><th>Category</th><th>Count</th><th>Points</th><th>Total</th></tr>";
echo "<tr><td>Posts Created</td><td>$post_count</td><td>× 5</td><td>+$post_points</td></tr>";
echo "<tr><td>Likes Received</td><td>$like_count</td><td>× 2</td><td>+$like_points</td></tr>";
echo "<tr><td>Dislikes Received</td><td>$dislike_count</td><td>× 1</td><td>-$dislike_points</td></tr>";
echo "<tr><td>Reports</td><td>$report_count</td><td>× 10</td><td>-$report_points</td></tr>";
echo "</table>";

echo "<div class='total'>Total Standing: <strong>$total points</strong></div>";

echo "</div></body></html>";

$conn->close();
?>
