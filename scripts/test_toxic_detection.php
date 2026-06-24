<?php
/**
 * Standalone test for toxic content detection
 * No authentication required
 */

// Load CodeIgniter config
$config['base_url'] = 'http://localhost/Aconnect_ci3/';
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'aconnect_db';

// Connect to database
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Load profanity filter helper
require_once 'application/helpers/profanity_filter_helper.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Toxic Detection Test</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        h2 { color: #333; border-bottom: 2px solid #a12124; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid #ddd; padding: 12px; }
        th { background: #a12124; color: white; }
        .toxic { background: #fff3cd; font-weight: bold; }
        .clean { background: #d4edda; }
        .summary { background: #f0f0f0; padding: 15px; margin: 20px 0; border-left: 4px solid #a12124; }
    </style>
</head>
<body>
<div class='container'>
    <h2>🔍 Toxic Content Detection Test</h2>
    <p><strong>Testing Post ID:</strong> 33 from Alumni ID 50</p>";

// Get post from database
$query = "SELECT id, alumni_id, title, content FROM forum_posts WHERE alumni_id = 50 AND id = 33 LIMIT 1";
$result = $mysqli->query($query);

if (!$result || $result->num_rows == 0) {
    echo "<p style='color:red'><strong>❌ Post 33 not found in database for alumni 50</strong></p>";
    echo "<p>Checking all posts from alumni 50...</p>";
    
    $query_all = "SELECT id, title, content FROM forum_posts WHERE alumni_id = 50";
    $result_all = $mysqli->query($query_all);
    
    if ($result_all->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Post ID</th><th>Title</th><th>Content (First 100 chars)</th></tr>";
        while ($row = $result_all->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['title']}</td>";
            echo "<td>" . substr($row['content'], 0, 100) . "...</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color:red'><strong>No posts found for alumni 50</strong></p>";
    }
    
    echo "</div></body></html>";
    exit;
}

// Get profanity list
$profanity_list = _get_simple_profanity_list();
echo "<p><strong>Profanity list loaded:</strong> " . count($profanity_list) . " terms</p>";

// Test each post
echo "<table>";
echo "<tr>
        <th>Post ID</th>
        <th>Title</th>
        <th>Toxic Detection</th>
        <th>Matched Words</th>
        <th>Action</th>
      </tr>";

while ($post = $result->fetch_assoc()) {
    $post_id = $post['id'];
    $post_content = $post['content'];
    
    // Test detection
    $detected_words = [];
    $content_lower = mb_strtolower($post_content, 'UTF-8');
    
    foreach ($profanity_list as $word) {
        if (empty($word)) continue;
        
        $word_lower = mb_strtolower($word, 'UTF-8');
        
        // Check if word is CJK
        $has_cjk = preg_match('/[\x{4E00}-\x{9FFF}]/u', $word) === 1;
        
        if ($has_cjk) {
            // CJK: substring match
            if (mb_strpos($content_lower, $word_lower) !== false) {
                $detected_words[] = $word;
            }
        } else {
            // Latin: word boundary
            $pattern = '/\b' . preg_quote($word_lower, '/') . '\b/ui';
            if (preg_match($pattern, $content_lower)) {
                $detected_words[] = $word;
            }
        }
    }
    
    $is_toxic = !empty($detected_words);
    $row_class = $is_toxic ? 'toxic' : 'clean';
    $status = $is_toxic ? '⚠️ TOXIC' : '✅ CLEAN';
    $penalty = $is_toxic ? '-50 pts' : '+5 pts';
    
    echo "<tr class='{$row_class}'>";
    echo "<td>{$post_id}</td>";
    echo "<td>" . substr($post['title'], 0, 30) . "</td>";
    echo "<td><strong>{$status}</strong></td>";
    echo "<td>";
    if ($is_toxic) {
        echo implode(', ', array_slice($detected_words, 0, 5));
        if (count($detected_words) > 5) {
            echo " (" . (count($detected_words) - 5) . " more)";
        }
    } else {
        echo "None";
    }
    echo "</td>";
    echo "<td>{$penalty}</td>";
    echo "</tr>";
}
echo "</table>";

// Summary
echo "<div class='summary'>";
echo "<h3>📊 Summary</h3>";
echo "<p><strong>Profanity list contains these CJK terms:</strong></p>";
$cjk_terms = [];
foreach ($profanity_list as $term) {
    if (preg_match('/[\x{4E00}-\x{9FFF}]/u', $term) === 1) {
        $cjk_terms[] = $term;
    }
}
echo "<p>" . implode(", ", $cjk_terms) . "</p>";
echo "</div>";

echo "</div></body></html>";

$mysqli->close();
?>
