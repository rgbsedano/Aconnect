<?php
// Quick diagnostic to check what's in the database
define('BASEPATH', dirname(__FILE__) . '/system/');
define('APPPATH', dirname(__FILE__) . '/application/');

// Load CI
require BASEPATH . 'core/CodeIgniter.php';

// Query comments
$comments = $this->db->select('id, alumni_id, post_id, comment, created_at')
    ->from('forum_comments')
    ->order_by('id', 'DESC')
    ->limit(10)
    ->get()
    ->result();

echo "=== Latest Comments in Database ===\n";
foreach($comments as $comment) {
    echo "ID: {$comment->id} | Post: {$comment->post_id} | Alumni: {$comment->alumni_id}\n";
    echo "  Comment: " . substr($comment->comment, 0, 100) . "\n";
    echo "  Created: {$comment->created_at}\n\n";
}
?>
