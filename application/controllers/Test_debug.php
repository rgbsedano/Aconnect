<?php

class Test_debug extends CI_Controller {

    public function __construct(){
        parent::__construct();
        // No authentication required for debugging
    }

    /**
     * PUBLIC: Debug post 33 toxic content
     */
    public function post_33() {
        // Get post 33 directly from database
        $post = $this->db->where('id', 33)->get('forum_posts')->row();

        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Post 33 Debug</title>
            <style>
                body { font-family: monospace; margin: 20px; background: #f5f5f5; }
                .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
                h2 { color: #333; }
                .data { background: #f4f4f4; padding: 15px; margin: 10px 0; border-left: 4px solid #a12124; overflow-x: auto; max-height: 300px; overflow-y: auto; }
                .bytes { background: #ffe6e6; padding: 10px; font-size: 11px; }
                .success { color: green; font-weight: bold; }
                .fail { color: red; font-weight: bold; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                table, th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
                th { background: #a12124; color: white; }
            </style>
        </head>
        <body>
        <div class='container'>
            <h2>🔍 Post 33 Database Debug</h2>";

        if (!$post) {
            echo "<p class='fail'>❌ Post 33 NOT FOUND in database</p>";
            echo "</div></body></html>";
            return;
        }

        echo "<table>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        echo "<tr><td>ID</td><td>{$post->id}</td></tr>";
        echo "<tr><td>Alumni ID</td><td>{$post->alumni_id}</td></tr>";
        echo "<tr><td>Title</td><td>" . htmlspecialchars($post->title) . "</td></tr>";
        echo "<tr><td>Content Length (bytes)</td><td>" . strlen($post->content) . "</td></tr>";
        echo "<tr><td>Content Length (UTF-8 chars)</td><td>" . mb_strlen($post->content, 'UTF-8') . "</td></tr>";
        echo "</table>";

        // Load profanity helper
        $this->load->helper('profanity_filter');
        $profanity_list = _get_simple_profanity_list();

        echo "<h3>Content Preview (First 500 chars)</h3>";
        echo "<div class='data'>" . htmlspecialchars(mb_substr($post->content, 0, 500, 'UTF-8')) . "</div>";

        echo "<h3>Content Hex (First 200 bytes)</h3>";
        echo "<div class='bytes'>" . bin2hex(substr($post->content, 0, 200)) . "</div>";

        // Test detection
        echo "<h3>Toxic Detection Test</h3>";
        
        $test_terms = [
            '肏', '肏你妈', '傻逼', '王八蛋', '混蛋', '屌丝', '贱人', '滚蛋', '支那', '死全家', '畜生',
            'cao', 'sha bi', 'wang ba dan'
        ];
        
        $detected = [];
        $content_lower = mb_strtolower($post->content, 'UTF-8');

        foreach ($test_terms as $word) {
            $word_lower = mb_strtolower($word, 'UTF-8');
            $has_cjk = preg_match('/[\x{4E00}-\x{9FFF}]/u', $word) === 1;
            
            $found = false;
            if ($has_cjk) {
                if (mb_strpos($content_lower, $word_lower) !== false) {
                    $found = true;
                }
            } else {
                $pattern = '/\b' . preg_quote($word_lower, '/') . '\b/ui';
                if (preg_match($pattern, $content_lower)) {
                    $found = true;
                }
            }
            
            if ($found) {
                $detected[] = $word;
            }
        }

        echo "<table>";
        echo "<tr><th>Term</th><th>Type</th><th>Status</th></tr>";
        foreach ($test_terms as $word) {
            $is_cjk = preg_match('/[\x{4E00}-\x{9FFF}]/u', $word) === 1;
            $type = $is_cjk ? 'CJK' : 'Latin';
            $status = in_array($word, $detected) ? '<span class=\"success\">✅ FOUND</span>' : '<span class=\"fail\">❌ NOT FOUND</span>';
            echo "<tr>";
            echo "<td>$word</td>";
            echo "<td>$type</td>";
            echo "<td>$status</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<h3>Overall Result</h3>";
        if (count($detected) > 0) {
            echo "<p class='success'><strong>✅ TOXIC CONTENT DETECTED</strong></p>";
            echo "<p>Detected terms: " . implode(", ", $detected) . "</p>";
            echo "<p><strong>Points Impact: -50 pts</strong></p>";
        } else {
            echo "<p class='fail'><strong>❌ NO TOXIC CONTENT DETECTED</strong></p>";
            echo "<p>Content appears clean</p>";
            echo "<p><strong>Points Impact: +5 pts</strong></p>";
        }

        echo "</div></body></html>";
    }
}
?>
