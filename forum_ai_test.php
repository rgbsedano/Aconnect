<?php
/**
 * Forum AI Test - Can be accessed without login
 * Place in root directory and access as: /forum_ai_test.php
 */

// Start session
session_start();

// For testing purposes, we'll simulate being logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;  // Test user ID
    $_SESSION['username'] = 'test_user';
}

// Initialize CodeIgniter (simplified)
define('ENVIRONMENT', 'development');
define('BASEPATH', dirname(__FILE__) . '/system/');
define('APPPATH', dirname(__FILE__) . '/application/');
define('FCPATH', dirname(__FILE__) . '/');

// Include CodeIgniter's bootstrap
require_once(BASEPATH . 'core/CodeIgniter.php');

// Now we can use CodeIgniter
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forum AI Generator Test</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .test-section { border: 1px solid #ccc; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }
        .loading { color: orange; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto; max-height: 400px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #0056b3; }
        input { padding: 8px; width: 300px; margin: 5px 0; }
        .controls { margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Forum AI Content Generator Test</h1>
    
    <div class="test-section">
        <h2>Configuration Check</h2>
        <button onclick="checkConfig()">Check Ollama Config</button>
        <div id="config-result"></div>
    </div>

    <div class="test-section">
        <h2>Test Forum AI Endpoint</h2>
        <div class="controls">
            <div>
                <label>Mode:</label><br>
                <select id="mode">
                    <option value="alumni">Alumni (Generate Random)</option>
                    <option value="both">Both (Edit Title & Content)</option>
                    <option value="title_only">Title Only</option>
                    <option value="content_only">Content Only</option>
                </select>
            </div>
            <div>
                <label>Title:</label><br>
                <input type="text" id="title" value="One Piece Latest" placeholder="Enter title">
            </div>
            <div>
                <label>Content:</label><br>
                <input type="text" id="content" value="IMU tells the lore of the Four Gods" placeholder="Enter content">
            </div>
            <button onclick="testForumAI()">Generate AI Content</button>
        </div>
        <div id="forum-result"></div>
    </div>

    <div class="test-section">
        <h2>Debug Logs</h2>
        <button onclick="loadLogs()">Refresh Logs</button>
        <div id="logs-result"></div>
    </div>

    <script>
    function checkConfig() {
        fetch('<?= base_url('forum/generate_ai_content?mode=alumni') ?>')
            .then(r => r.text())
            .then(data => {
                document.getElementById('config-result').innerHTML = '<pre class="success">' + JSON.stringify(JSON.parse(data), null, 2) + '</pre>';
            })
            .catch(e => {
                document.getElementById('config-result').innerHTML = '<div class="error">Error: ' + e.message + '</div>';
            });
    }

    function testForumAI() {
        const mode = document.getElementById('mode').value;
        const title = encodeURIComponent(document.getElementById('title').value);
        const content = encodeURIComponent(document.getElementById('content').value);
        const url = '<?= base_url('forum/generate_ai_content') ?>?mode=' + mode + '&title=' + title + '&content=' + content;

        document.getElementById('forum-result').innerHTML = '<div class="loading">Loading...</div>';

        fetch(url)
            .then(r => r.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('forum-result').innerHTML = '<div class="error">Error: ' + data.error + '<br>' + (data.details || '') + '</div>';
                } else {
                    document.getElementById('forum-result').innerHTML = '<pre class="success">' + JSON.stringify(data, null, 2) + '</pre>';
                }
                loadLogs();
            })
            .catch(e => {
                document.getElementById('forum-result').innerHTML = '<div class="error">Error: ' + e.message + '</div>';
            });
    }

    function loadLogs() {
        fetch('<?= base_url('forum/get_debug_logs') ?>')
            .then(r => r.text())
            .then(data => {
                document.getElementById('logs-result').innerHTML = '<pre>' + data + '</pre>';
            })
            .catch(e => {
                console.log('Could not load logs:', e);
            });
    }
    </script>
</body>
</html>
