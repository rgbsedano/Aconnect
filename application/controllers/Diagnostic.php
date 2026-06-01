<?php

class Diagnostic extends CI_Controller {

    function __construct(){
        parent::__construct();
        if($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy"){
            redirect(base_url("Login"));
        }
    }

    /**
     * All-in-one diagnostic page
     */
    public function index() {
        $alumni_id = $this->session->userdata('alumni_id');
        
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Standing Points Diagnostic</title>
            <style>
                body { font-family: Arial; margin: 20px; background: #f5f5f5; }
                .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
                h2 { color: #333; border-bottom: 2px solid #a12124; padding-bottom: 10px; }
                h3 { color: #666; margin-top: 20px; }
                .alert { padding: 15px; margin: 10px 0; border-radius: 4px; }
                .alert-danger { background: #f8d7da; color: #721c24; }
                .alert-success { background: #d4edda; color: #155724; }
                .alert-info { background: #d1ecf1; color: #0c5460; }
                table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                table, th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
                th { background: #a12124; color: white; }
                pre { background: #f4f4f4; padding: 10px; border-radius: 4px; overflow-x: auto; }
                .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0; }
                .card { background: #f9f9f9; padding: 15px; border-left: 4px solid #a12124; border-radius: 4px; }
                .card-title { font-weight: bold; margin-bottom: 10px; }
                strong { color: #a12124; }
            </style>
        </head>
        <body>
        <div class='container'>
            <h2>🔍 Alumni Standing Points - Full Diagnostic</h2>";
        
        if (!$alumni_id) {
            echo "<div class='alert alert-danger'><strong>ERROR:</strong> Alumni ID not found in session!</div>";
            echo "</div></body></html>";
            return;
        }

        echo "<p><strong>Your Alumni ID:</strong> $alumni_id</p>";
        echo "<p><strong>Session Status:</strong> <span style='color:green'>✓ Logged In</span></p>";

        // 1. Check posts
        $this->db->reset_query();
        $posts = $this->db->where('alumni_id', $alumni_id)->get('forum_posts')->result();
        $post_count = count($posts);

        echo "<h3>1️⃣ Forum Posts</h3>";
        echo "<div class='card'>";
        echo "<div class='card-title'>Total Posts: <strong>$post_count</strong></div>";
        
        if ($post_count == 0) {
            echo "<div class='alert alert-danger'>No posts found! Create a post first.</div>";
        } else {
            echo "<div class='alert alert-success'>✓ Found $post_count post(s)</div>";
            echo "<table>";
            echo "<tr><th>Post ID</th><th>Title</th><th>Created</th></tr>";
            foreach ($posts as $post) {
                echo "<tr><td>#{$post->id}</td><td>" . htmlspecialchars($post->title) . "</td><td>{$post->created_at}</td></tr>";
            }
            echo "</table>";
        }
        echo "</div>";

        // 2. Check likes/dislikes
        $this->db->reset_query();
        $this->db->select('COUNT(forum_likes.id) as like_count');
        $this->db->from('forum_likes');
        $this->db->join('forum_posts', 'forum_likes.post_id = forum_posts.id');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $like_result = $this->db->get()->row();
        $likes = $like_result ? $like_result->like_count : 0;

        $this->db->reset_query();
        $this->db->select('COUNT(forum_dislike.id) as dislike_count');
        $this->db->from('forum_dislike');
        $this->db->join('forum_posts', 'forum_dislike.post_id = forum_posts.id');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $dislike_result = $this->db->get()->row();
        $dislikes = $dislike_result ? $dislike_result->dislike_count : 0;

        echo "<h3>2️⃣ Reactions</h3>";
        echo "<div class='grid'>";
        echo "<div class='card'><div class='card-title'>👍 Likes Received: <strong>$likes</strong></div></div>";
        echo "<div class='card'><div class='card-title'>👎 Dislikes Received: <strong>$dislikes</strong></div></div>";
        echo "</div>";

        // 3. Check reports
        $this->db->reset_query();
        $this->db->select('COUNT(forum_reports.id) as report_count');
        $this->db->from('forum_reports');
        $this->db->join('forum_posts', 'forum_reports.post_id = forum_posts.id');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $report_result = $this->db->get()->row();
        $reports = $report_result ? $report_result->report_count : 0;

        echo "<h3>3️⃣ Reports</h3>";
        echo "<div class='card'><div class='card-title'>🚨 Post Reports: <strong>$reports</strong></div></div>";

        // 4. Calculate standing
        $this->load->model('Standing_model');
        $result = $this->Standing_model->get_standing_score_debug($alumni_id);
        $score = $result['score'];
        $breakdown = $result['breakdown'];

        echo "<h3>4️⃣ Points Calculation</h3>";
        echo "<table>";
        echo "<tr><th>Category</th><th>Count</th><th>Points Per</th><th>Total</th></tr>";
        foreach ($breakdown as $key => $data) {
            $label = ucfirst(str_replace('_', ' ', $key));
            echo "<tr>";
            echo "<td>$label</td>";
            echo "<td>" . $data['count'] . "</td>";
            echo "<td>" . (isset($data['points_per']) ? $data['points_per'] : (isset($data['penalty_per']) ? $data['penalty_per'] : 'N/A')) . "</td>";
            echo "<td><strong>" . $data['total'] . "</strong></td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<h3 style='color: #a12124; font-size: 24px;'>Total Standing: <strong>$score points</strong></h3>";

        if ($score == 0 && $post_count == 0) {
            echo "<div class='alert alert-info'><strong>💡 Tip:</strong> Create a post in the forum to start earning points! (+5 points per post)</div>";
        } elseif ($score == 0 && $post_count > 0) {
            echo "<div class='alert alert-danger'><strong>⚠️ Issue:</strong> Posts found but score is 0. There might be a calculation error. Contact admin.</div>";
        }

        echo "</div></body></html>";
    }

    /**
     * Detailed points breakdown - shows exactly where points come from
     */
    public function points_breakdown() {
        $alumni_id = $this->session->userdata('alumni_id');
        
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Points Breakdown</title>
            <style>
                body { font-family: Arial; margin: 20px; background: #f5f5f5; }
                .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
                h2 { color: #333; border-bottom: 2px solid #a12124; padding-bottom: 10px; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                table, th, td { border: 1px solid #ddd; padding: 12px; }
                th { background: #a12124; color: white; text-align: left; }
                .positive { color: green; font-weight: bold; }
                .negative { color: red; font-weight: bold; }
                .total-row { background: #f0f0f0; font-weight: bold; font-size: 16px; }
                .card { background: #f9f9f9; padding: 15px; border-left: 4px solid #a12124; margin: 10px 0; }
            </style>
        </head>
        <body>
        <div class='container'>
            <h2>📊 Your Points Breakdown</h2>";
        
        if (!$alumni_id) {
            echo "<p style='color:red'><strong>ERROR:</strong> Not logged in!</p>";
            echo "</div></body></html>";
            return;
        }

        // Load models and helpers
        $this->load->model('Standing_model');
        $this->load->helper('profanity_filter');
        
        // Get detailed breakdown
        $result = $this->Standing_model->get_standing_score_debug($alumni_id);
        $total_score = $result['score'];
        $breakdown = $result['breakdown'];

        echo "<div class='card'>";
        echo "<strong>Alumni ID:</strong> $alumni_id<br>";
        echo "<strong>Total Standing Points:</strong> <span style='font-size: 24px; color: #a12124;'>$total_score pts</span>";
        echo "</div>";

        echo "<table>";
        echo "<tr>";
        echo "<th>Point Category</th>";
        echo "<th>Count</th>";
        echo "<th>Points Per</th>";
        echo "<th>Total Points</th>";
        echo "</tr>";

        foreach ($breakdown as $key => $data) {
            $label = str_replace('_', ' ', ucfirst($key));
            $count = $data['count'];
            $per = isset($data['points_per']) ? '+' . $data['points_per'] : (isset($data['penalty_per']) ? $data['penalty_per'] : '0');
            $total = $data['total'];
            $total_class = $total >= 0 ? 'positive' : 'negative';

            echo "<tr>";
            echo "<td>$label</td>";
            echo "<td>$count</td>";
            echo "<td>$per</td>";
            echo "<td><span class='{$total_class}'>" . ($total >= 0 ? '+' : '') . "$total</span></td>";
            echo "</tr>";
        }

        echo "<tr class='total-row'>";
        echo "<td colspan='3'>TOTAL STANDING POINTS</td>";
        echo "<td><span class='positive'>$total_score pts</span></td>";
        echo "</tr>";
        echo "</table>";

        // Show calculation formula
        echo "<h3>Calculation Formula</h3>";
        $formula_parts = [];
        foreach ($breakdown as $key => $data) {
            $total = $data['total'];
            if ($total > 0) {
                $formula_parts[] = "+$total";
            } elseif ($total < 0) {
                $formula_parts[] = "$total";
            }
        }
        $formula = implode(" ", $formula_parts);
        echo "<div class='card'><code>$formula = <strong>$total_score pts</strong></code></div>";

        // Explain each category
        echo "<h3>Point Breakdown Explained</h3>";
        
        if (isset($breakdown['posts_created'])) {
            $posts = $breakdown['posts_created'];
            echo "<div class='card'>";
            echo "<strong>📝 Posts Created:</strong> {$posts['count']} posts × {$posts['points_per']} pts each = <span class='positive'>+{$posts['total']} pts</span>";
            echo "</div>";
        }

        if (isset($breakdown['likes_received'])) {
            $likes = $breakdown['likes_received'];
            echo "<div class='card'>";
            echo "<strong>👍 Likes Received:</strong> {$likes['count']} likes × {$likes['points_per']} pts each = <span class='positive'>+{$likes['total']} pts</span>";
            echo "</div>";
        }

        if (isset($breakdown['dislikes_received'])) {
            $dislikes = $breakdown['dislikes_received'];
            echo "<div class='card'>";
            echo "<strong>👎 Dislikes Received:</strong> {$dislikes['count']} dislikes × {$dislikes['penalty_per']} pt each = <span class='negative'>{$dislikes['total']} pts</span>";
            echo "</div>";
        }

        if (isset($breakdown['reports'])) {
            $reports = $breakdown['reports'];
            echo "<div class='card'>";
            echo "<strong>🚨 Posts Reported:</strong> {$reports['count']} reports × {$reports['penalty_per']} pts each = <span class='negative'>{$reports['total']} pts</span>";
            echo "</div>";
        }

        if (isset($breakdown['toxic_content'])) {
            $toxic = $breakdown['toxic_content'];
            echo "<div class='card'>";
            echo "<strong>☠️ Toxic Content:</strong> {$toxic['count']} toxic posts × {$toxic['penalty_per']} pts each = <span class='negative'>{$toxic['total']} pts</span>";
            echo "</div>";
        }

        echo "</div></body></html>";
    }

    /**
     * Check user's forum posts for toxic content (profanity/slurs)
     */
    public function check_toxic_posts() {
        $alumni_id = $this->session->userdata('alumni_id');
        
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Toxic Posts Check</title>
            <style>
                body { font-family: Arial; margin: 20px; background: #f5f5f5; }
                .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
                h2 { color: #333; border-bottom: 2px solid #a12124; padding-bottom: 10px; }
                h3 { color: #666; margin-top: 20px; }
                table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                table, th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                th { background: #a12124; color: white; }
                .toxic { background: #fff3cd; color: #721c24; font-weight: bold; }
                .clean { background: #d4edda; color: #155724; }
                .alert { padding: 15px; margin: 10px 0; border-radius: 4px; }
                .alert-danger { background: #f8d7da; color: #721c24; }
                .alert-success { background: #d4edda; color: #155724; }
                .alert-info { background: #d1ecf1; color: #0c5460; }
                pre { background: #f4f4f4; padding: 10px; border-radius: 4px; overflow-x: auto; max-height: 200px; }
            </style>
        </head>
        <body>
        <div class='container'>
            <h2>🔍 Toxic Content Detector</h2>";
        
        if (!$alumni_id) {
            echo "<div class='alert alert-danger'><strong>ERROR:</strong> Alumni ID not found in session!</div>";
            echo "</div></body></html>";
            return;
        }

        // Load profanity helper and get profanity list
        $this->load->helper('profanity_filter');
        $profanity_list = _get_simple_profanity_list();

        // Get all posts by this user
        $posts = $this->db->where('alumni_id', $alumni_id)->get('forum_posts')->result();

        echo "<p><strong>Scanning " . count($posts) . " post(s) for toxic content...</strong></p>";
        echo "<table>";
        echo "<tr>
                <th>Post ID</th>
                <th>Title</th>
                <th>Content Preview</th>
                <th>Toxic Words Found</th>
                <th>Status</th>
                <th>Penalty</th>
              </tr>";

        $total_toxic_penalty = 0;
        $toxic_post_count = 0;

        if (empty($posts)) {
            echo "<tr><td colspan='6' style='text-align: center; color: #666;'><em>No posts found</em></td></tr>";
        } else {
            foreach ($posts as $post) {
                // Check both title and content for toxicity
                $toxic_words = [];
                $content_to_check = strtolower($post->title . ' ' . $post->content);

                foreach ($profanity_list as $word) {
                    $has_cjk = preg_match('/[\x{4E00}-\x{9FFF}]/u', $word) === 1;
                    $pattern = $has_cjk
                        ? '/' . preg_quote($word, '/') . '/u'
                        : '/\b' . preg_quote($word, '/') . '\b/i';
                    
                    if (preg_match($pattern, $content_to_check)) {
                        $toxic_words[] = $word;
                    }
                }

                $is_toxic = !empty($toxic_words);
                $row_class = $is_toxic ? 'toxic' : 'clean';
                $status = $is_toxic ? '⚠️ TOXIC' : '✅ CLEAN';
                $penalty = $is_toxic ? '-50 pts' : '+5 pts';

                if ($is_toxic) {
                    $total_toxic_penalty += 50;
                    $toxic_post_count++;
                }

                echo "<tr class='{$row_class}'>";
                echo "<td>{$post->id}</td>";
                echo "<td>{$post->title}</td>";
                echo "<td>" . substr($post->content, 0, 60) . "...</td>";
                echo "<td>";
                if ($is_toxic) {
                    echo implode(', ', array_slice($toxic_words, 0, 5));
                    if (count($toxic_words) > 5) {
                        echo " (+". (count($toxic_words) - 5) ." more)";
                    }
                } else {
                    echo "None";
                }
                echo "</td>";
                echo "<td>{$status}</td>";
                echo "<td>{$penalty}</td>";
                echo "</tr>";
            }
        }

        echo "</table>";

        echo "<h3>📊 Toxicity Report</h3>";
        echo "<table>";
        echo "<tr><th>Metric</th><th>Value</th></tr>";
        echo "<tr><td>Total Posts</td><td>" . count($posts) . "</td></tr>";
        echo "<tr><td>Toxic Posts</td><td class='toxic'>" . $toxic_post_count . "</td></tr>";
        echo "<tr><td>Clean Posts</td><td class='clean'>" . (count($posts) - $toxic_post_count) . "</td></tr>";
        echo "<tr><td>Toxic Content Penalty</td><td class='toxic'>-" . $total_toxic_penalty . " pts</td></tr>";
        echo "</table>";

        if ($toxic_post_count > 0) {
            echo "<div class='alert alert-danger'>
                    <strong>⚠️ Warning:</strong> You have <strong>" . $toxic_post_count . "</strong> post(s) with toxic content. 
                    Each costs you <strong>-50 points</strong> on your standing score.
                  </div>";
        } else {
            echo "<div class='alert alert-success'>
                    <strong>✅ Great:</strong> None of your posts contain toxic/profane content!
                  </div>";
        }

        echo "</div></body></html>";
    }

    /**
     * PUBLIC: Test toxic detection on a specific post (no login required)
     * Usage: /diagnostic/test_post_toxic/[post_id]
     */
    public function test_post_toxic($post_id = 33) {
        // This is public - no login check
        
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Toxic Detection Test</title>
            <style>
                body { font-family: Arial; margin: 20px; background: #f5f5f5; }
                .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
                h2 { color: #333; border-bottom: 2px solid #a12124; }
                h3 { color: #666; margin-top: 20px; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 13px; }
                table, th, td { border: 1px solid #ddd; padding: 10px; }
                th { background: #a12124; color: white; }
                .toxic { background: #fff3cd; font-weight: bold; }
                .clean { background: #d4edda; }
                .code { background: #f4f4f4; padding: 10px; border-radius: 4px; overflow-x: auto; font-size: 11px; font-family: monospace; max-height: 300px; overflow-y: auto; }
                .info { background: #d1ecf1; padding: 15px; margin: 10px 0; border-left: 4px solid #0c5460; }
                .warning { background: #f8d7da; padding: 15px; margin: 10px 0; border-left: 4px solid #721c24; }
                .success { background: #d4edda; padding: 15px; margin: 10px 0; border-left: 4px solid #155724; }
            </style>
        </head>
        <body>
        <div class='container'>
            <h2>🔍 Toxic Detection Test - Post #$post_id</h2>";

        // Get post from database
        $post = $this->db->where('id', $post_id)->get('forum_posts')->row();

        if (!$post) {
            echo "<div class='warning'><strong>❌ Post #$post_id not found in database</strong></div>";
            echo "</div></body></html>";
            return;
        }

        echo "<div class='info'>";
        echo "<strong>Post ID:</strong> {$post->id} | ";
        echo "<strong>Alumni ID:</strong> {$post->alumni_id} | ";
        echo "<strong>Title:</strong> {$post->title}";
        echo "</div>";

        // Load profanity helper
        $this->load->helper('profanity_filter');
        $profanity_list = _get_simple_profanity_list();
        
        // Count CJK terms
        $cjk_terms = [];
        foreach ($profanity_list as $term) {
            if (preg_match('/[\x{4E00}-\x{9FFF}]/u', $term) === 1) {
                $cjk_terms[] = $term;
            }
        }
        
        echo "<p><strong>Profanity list loaded:</strong> " . count($profanity_list) . " total terms | " . count($cjk_terms) . " CJK terms</p>";
        echo "<p><strong>CJK Terms:</strong> " . implode(", ", array_slice($cjk_terms, 0, 10)) . (count($cjk_terms) > 10 ? " ... and " . (count($cjk_terms) - 10) . " more" : "") . "</p>";

        // Test detection
        $detected_words = [];
        $content_lower = mb_strtolower($post->content, 'UTF-8');
        
        echo "<h3>Detection Results</h3>";
        
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
        $status = $is_toxic ? '⚠️ TOXIC' : '✅ CLEAN';
        $penalty = $is_toxic ? '-50 pts' : '+5 pts';
        
        echo "<table>";
        echo "<tr>";
        echo "<th>Status</th>";
        echo "<th>Toxic Terms Found</th>";
        echo "<th>Points Impact</th>";
        echo "</tr>";
        echo "<tr" . ($is_toxic ? " class='toxic'" : " class='clean'") . ">";
        echo "<td><strong>$status</strong></td>";
        echo "<td>" . count($detected_words) . " term(s)</td>";
        echo "<td><strong>$penalty</strong></td>";
        echo "</tr>";
        echo "</table>";

        if ($is_toxic) {
            echo "<h3>Matched Profanity/Slurs (" . count($detected_words) . " total)</h3>";
            echo "<table>";
            echo "<tr><th>Term</th><th>Unicode</th><th>Type</th></tr>";
            foreach (array_slice($detected_words, 0, 30) as $term) {
                $is_cjk = preg_match('/[\x{4E00}-\x{9FFF}]/u', $term) === 1;
                $type = $is_cjk ? 'CJK' : 'Latin';
                $unicode = bin2hex(mb_convert_encoding($term, 'UTF-8', 'UTF-8'));
                echo "<tr>";
                echo "<td><code>$term</code></td>";
                echo "<td style='font-size: 11px;'>0x" . substr($unicode, 0, 20) . "...</td>";
                echo "<td>$type</td>";
                echo "</tr>";
            }
            if (count($detected_words) > 30) {
                echo "<tr><td colspan='3' style='text-align: center; color: #666;'>... and " . (count($detected_words) - 30) . " more ...</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='success'><strong>✅ No profanity detected</strong></div>";
        }

        // Show content preview
        echo "<h3>Post Content</h3>";
        echo "<div class='code'>" . htmlspecialchars(mb_substr($post->content, 0, 1000, 'UTF-8')) . "</div>";

        // Debug info
        echo "<h3>Debug Info</h3>";
        echo "<table>";
        echo "<tr><th>Item</th><th>Value</th></tr>";
        echo "<tr><td>Content Length</td><td>" . mb_strlen($post->content, 'UTF-8') . " chars</td></tr>";
        echo "<tr><td>Content (bytes)</td><td>" . strlen($post->content) . " bytes</td></tr>";
        echo "<tr><td>Encoding</td><td>UTF-8</td></tr>";
        echo "<tr><td>First 20 bytes (hex)</td><td><code>" . bin2hex(substr($post->content, 0, 20)) . "</code></td></tr>";
        echo "</table>";

        echo "</div></body></html>";
    }

    /**
     * PUBLIC: Direct database debug - shows exactly what's stored in post 33
     */
    public function debug_post_33() {
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
                .data { background: #f4f4f4; padding: 15px; margin: 10px 0; border-left: 4px solid #a12124; overflow-x: auto; }
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
        echo "<tr><td>Title</td><td>{$post->title}</td></tr>";
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
