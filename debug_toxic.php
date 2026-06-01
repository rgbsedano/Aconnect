<?php
/**
 * Direct database query to check post 33 content and toxic detection
 */

// Read CI config
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'aconnect_db';

// Connect
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($mysqli->connect_error) {
    die("DB Error: " . $mysqli->connect_error);
}

// Get post 33
$query = "SELECT id, alumni_id, title, content FROM forum_posts WHERE id = 33";
$result = $mysqli->query($query);

if (!$result || $result->num_rows == 0) {
    die("Post 33 not found");
}

$post = $result->fetch_assoc();

echo "POST 33 DETAILS:\n";
echo "================\n";
echo "ID: " . $post['id'] . "\n";
echo "Alumni ID: " . $post['alumni_id'] . "\n";
echo "Title: " . $post['title'] . "\n";
echo "\nContent Length: " . strlen($post['content']) . " bytes\n";
echo "Content MB Length: " . mb_strlen($post['content'], 'UTF-8') . " chars\n";
echo "\nFirst 200 chars:\n";
echo $post['content'] . "\n";
echo "\n\nFirst 200 bytes (hex):\n";
echo bin2hex(substr($post['content'], 0, 200)) . "\n";

// Test specific CJK terms
$profanity_list = [
    '肏', '肏你妈', '傻逼', '王八蛋', '混蛋', '屌丝', '贱人', '滚蛋', '支那', '死全家', '畜生',
    'cao', 'sha bi', 'wang ba dan', 'hun dan', 'diao si', 'jian ren'
];

echo "\n\nTOXIC DETECTION TEST:\n";
echo "======================\n";

$detected = [];
foreach ($profanity_list as $word) {
    $word_lower = mb_strtolower($word, 'UTF-8');
    $content_lower = mb_strtolower($post['content'], 'UTF-8');
    
    $has_cjk = preg_match('/[\x{4E00}-\x{9FFF}]/u', $word) === 1;
    $found = false;
    
    if ($has_cjk) {
        // CJK substring match
        if (mb_strpos($content_lower, $word_lower) !== false) {
            $found = true;
        }
    } else {
        // Latin word boundary
        $pattern = '/\b' . preg_quote($word_lower, '/') . '\b/ui';
        if (preg_match($pattern, $content_lower)) {
            $found = true;
        }
    }
    
    if ($found) {
        $detected[] = $word;
        echo "✅ FOUND: $word\n";
    }
}

echo "\nTotal Detected: " . count($detected) . "\n";
echo "Is Toxic: " . (count($detected) > 0 ? "YES" : "NO") . "\n";

$mysqli->close();
?>
