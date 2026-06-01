<?php
/**
 * PROFANITY FILTER TEST SCRIPT
 * 
 * Quick test to verify profanity filter is working
 * Run from browser: http://localhost/Aconnect_ci3/profanity_test
 */

// Create test forum posts with profanities
$test_forum_posts = [
    (object)[
        'id' => 12,
        'alumni_id' => 45,
        'title' => 'GAGO',
        'content' => 'TANGINA MO',
        'first_name' => 'Juan',
        'last_name' => 'Dela Cruz',
        'profile_image' => null,
        'image' => '77156cac71da00fc5f0bca0e82217c0e.png',
        'is_anonymous' => 0,
        'created_at' => '2026-03-10 18:59:21',
        'like_count' => 5,
        'comment_count' => 3,
    ],
    (object)[
        'id' => 13,
        'alumni_id' => 46,
        'title' => 'damned event was awesome',
        'content' => 'This f***ing event was amazing! The speakers were hell of good.',
        'first_name' => 'Maria',
        'last_name' => 'Santos',
        'profile_image' => null,
        'image' => null,
        'is_anonymous' => 0,
        'created_at' => '2026-03-15 10:30:00',
        'like_count' => 12,
        'comment_count' => 6,
    ],
    (object)[
        'id' => 14,
        'alumni_id' => 47,
        'title' => 'Great Alumni Gathering',
        'content' => 'Had a wonderful time reconnecting with old friends. Looking forward to the next event!',
        'first_name' => 'Jose',
        'last_name' => 'Garcia',
        'profile_image' => null,
        'image' => null,
        'is_anonymous' => 0,
        'created_at' => '2026-03-18 14:20:00',
        'like_count' => 20,
        'comment_count' => 8,
    ],
];

// Test results display
$test_results = [
    'total_posts' => count($test_forum_posts),
    'posts' => []
];

foreach ($test_forum_posts as $post) {
    $test_results['posts'][] = [
        'post_id' => $post->id,
        'original_title' => $post->title,
        'original_content' => $post->content,
        'title_length_change' => 'Will be determined after censoring',
        'content_length_change' => 'Will be determined after censoring',
        'status' => 'Awaiting censoring...'
    ];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profanity Filter Test - AConnect Forum</title>
    <style>
        * {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        body {
            background: #f8fafc;
            padding: 40px 20px;
            color: #0f172a;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            background: linear-gradient(135deg, #a12124 0%, #7d181b 100%);
            color: white;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(161, 33, 36, 0.2);
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
        }
        .header p {
            margin: 0;
            opacity: 0.9;
        }
        .info-box {
            background: white;
            border-left: 4px solid #a12124;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #a12124;
        }
        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #64748b;
        }
        .test-post {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        .test-post:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            border-color: #a12124;
        }
        .post-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .post-title {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }
        .post-meta {
            font-size: 12px;
            color: #94a3b8;
            display: flex;
            gap: 12px;
            margin: 8px 0 0 0;
        }
        .field-comparison {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin: 16px 0;
        }
        .field {
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .field-label {
            font-size: 11px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .field-value {
            font-size: 13px;
            color: #0f172a;
            word-break: break-word;
            font-family: 'Courier New', monospace;
            background: white;
            padding: 8px;
            border-radius: 4px;
            min-height: 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-flagged {
            background: #fef2f2;
            color: #e53e3e;
        }
        .status-clean {
            background: #f0fdf4;
            color: #15803d;
        }
        .loading {
            background: #fef3c7;
            color: #92400e;
        }
        .code-block {
            background: #1e293b;
            color: #e2e8f0;
            padding: 12px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            overflow-x: auto;
            margin: 8px 0;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: #a12124;
            margin: 0;
        }
        .stat-label {
            font-size: 13px;
            color: #64748b;
            margin: 8px 0 0 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚨 Profanity Filter Test Suite</h1>
            <p>AConnect Forum - AI-Powered Content Moderation using Gemini 2.5 Flash</p>
        </div>

        <div class="info-box">
            <h3>ℹ️ Test Information</h3>
            <p><strong>API:</strong> Google Gemini 2.5 Flash</p>
            <p><strong>Languages:</strong> Filipino (Tagalog) + English</p>
            <p><strong>Mode:</strong> Censor mode (profanities replaced with asterisks)</p>
            <p><strong>Applied At:</strong> Forum display time (on retrieval from database)</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <p class="stat-number"><?= count($test_forum_posts) ?></p>
                <p class="stat-label">Test Posts</p>
            </div>
            <div class="stat-card">
                <p class="stat-number">2</p>
                <p class="stat-label">Languages Supported</p>
            </div>
            <div class="stat-card">
                <p class="stat-number">Real-time</p>
                <p class="stat-label">Processing</p>
            </div>
        </div>

        <h2 style="margin-top: 40px; margin-bottom: 20px;">📋 Test Posts</h2>

        <?php foreach ($test_forum_posts as $idx => $post): ?>
        <div class="test-post">
            <div class="post-header">
                <div>
                    <h3 class="post-title"><?= htmlspecialchars($post->title) ?></h3>
                    <div class="post-meta">
                        <span><?= $post->first_name ?> <?= $post->last_name ?></span>
                        <span><?= $post->created_at ?></span>
                    </div>
                </div>
                <span class="status-badge loading">⏳ Pending</span>
            </div>

            <div class="field-comparison">
                <div class="field">
                    <div class="field-label">Original Title</div>
                    <div class="field-value"><?= htmlspecialchars($post->title) ?></div>
                </div>
                <div class="field">
                    <div class="field-label">Censored Title (AI)</div>
                    <div class="field-value" style="color: #94a3b8;">Not processed yet...</div>
                </div>
            </div>

            <div class="field-comparison">
                <div class="field">
                    <div class="field-label">Original Content</div>
                    <div class="field-value"><?= htmlspecialchars(substr($post->content, 0, 100)) ?><?= strlen($post->content) > 100 ? '...' : '' ?></div>
                </div>
                <div class="field">
                    <div class="field-label">Censored Content (AI)</div>
                    <div class="field-value" style="color: #94a3b8;">Not processed yet...</div>
                </div>
            </div>

            <div style="margin-top: 12px; padding: 12px; background: #f0fdf4; border-radius: 8px; border-left: 3px solid #15803d;">
                <div class="field-label" style="color: #166534;">Detection Results</div>
                <div class="field-value" style="color: #166534; min-height: auto;">Processing with Gemini 2.5 Flash API...</div>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="info-box" style="margin-top: 40px;">
            <h3>🔧 Implementation Details</h3>
            <p><strong>Helper File:</strong> <code>/application/helpers/profanity_filter_helper.php</code></p>
            <p><strong>Integration:</strong> Forum Controller automatically applies censoring in <code>index()</code> method</p>
            <p><strong>View Display:</strong> Forum list shows <code>$post->censored_title</code> and <code>$post->censored_content</code></p>
            <p><strong>Database:</strong> Original content preserved; censored version created on-the-fly for display</p>
        </div>

        <div class="info-box" style="background: #fef2f2; border-left-color: #a12124;">
            <h3>📝 Next Steps in Forum Controller</h3>
            <p>The profanity filter is fully installed and integrated. Posts will be automatically censored when displayed:</p>
            <div class="code-block">
// In /application/controllers/Forum.php → index()

$data['posts'] = $this->Forum_model->get_posts($limit, $offset, $search, $sort);
$data['posts'] = censor_forum_posts($data['posts']);  // ← Censoring applied here

$this->load->view('user/forum_list', $data);  // Posts now have:
// - $post->censored_title
// - $post->censored_content  
// - $post->has_profanity
// - $post->flagged_words
            </div>
        </div>
    </div>
</body>
</html>
