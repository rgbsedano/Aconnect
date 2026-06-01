<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForumAiTest extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('ai');
    }

    public function index() {
        // Display test interface
        ?>
<!DOCTYPE html>
<html>
<head>
    <title>Forum AI Generator Test</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f9f9f9; }
        .container { max-width: 900px; margin: 0 auto; }
        .test-section { background: white; border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .loading { color: #fd7e14; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto; max-height: 400px; font-size: 12px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 14px; }
        button:hover { background: #0056b3; }
        input, select { padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 3px; }
        .controls { margin: 15px 0; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        .result-box { margin-top: 15px; padding: 10px; background: #f9f9f9; border-radius: 3px; border-left: 4px solid #007bff; }
        h2 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Forum AI Content Generator Test</h1>
        
        <div class="test-section">
            <h2>Configuration Check</h2>
            <button onclick="checkConfig()">Check Ollama Configuration</button>
            <div id="config-result" class="result-box"></div>
        </div>

        <div class="test-section">
            <h2>Test Forum AI Endpoint</h2>
            <div class="controls">
                <div>
                    <label>Mode:</label>
                    <select id="mode" style="width: 100%;">
                        <option value="alumni">Alumni (Generate Random Topic)</option>
                        <option value="both">Both (Edit Title & Content)</option>
                        <option value="title_only">Title Only (Generate Content from Title)</option>
                        <option value="content_only">Content Only (Generate Title from Content)</option>
                    </select>
                </div>
                <div>
                    <label>Title:</label>
                    <input type="text" id="title" value="One Piece Latest" placeholder="Enter title (for both/content_only modes)" style="width: 100%;">
                </div>
                <div>
                    <label>Content:</label>
                    <input type="text" id="content" value="IMU tells the lore of the Four Gods" placeholder="Enter content (for both/title_only modes)" style="width: 100%;">
                </div>
                <button onclick="testForumAI()" style="width: 100%; font-size: 16px; padding: 12px;">🚀 Generate AI Content</button>
            </div>
            <div id="forum-result" class="result-box"></div>
        </div>

        <div class="test-section">
            <h2>Debug Logs</h2>
            <button onclick="loadLogs()">📋 Refresh Logs</button>
            <div id="logs-result" class="result-box"><div class="loading">Logs will appear here...</div></div>
        </div>
    </div>

    <script>
    function checkConfig() {
        document.getElementById('config-result').innerHTML = '<div class="loading">Checking...</div>';
        fetch('<?= base_url('forumaitest/get_config') ?>')
            .then(r => r.json())
            .then(data => {
                let html = '<div class="success"><strong>✓ Ollama Configuration:</strong></div><pre>' + JSON.stringify(data, null, 2) + '</pre>';
                document.getElementById('config-result').innerHTML = html;
            })
            .catch(e => {
                document.getElementById('config-result').innerHTML = '<div class="error"><strong>✗ Error:</strong> ' + e.message + '</div>';
            });
    }

    function testForumAI() {
        const mode = document.getElementById('mode').value;
        const title = encodeURIComponent(document.getElementById('title').value);
        const content = encodeURIComponent(document.getElementById('content').value);
        const url = '<?= base_url('forum/generate_ai_content') ?>?mode=' + mode + '&title=' + title + '&content=' + content;

        document.getElementById('forum-result').innerHTML = '<div class="loading">⏳ Calling Ollama API... This may take 30-60 seconds</div>';

        fetch(url)
            .then(r => r.text())
            .then(data => {
                try {
                    const json = JSON.parse(data);
                    if (json.error) {
                        document.getElementById('forum-result').innerHTML = '<div class="error"><strong>✗ Error:</strong> ' + json.error + '<br><small>' + (json.details || '') + '</small></div>';
                    } else {
                        document.getElementById('forum-result').innerHTML = '<div class="success"><strong>✓ Success:</strong></div><pre>' + JSON.stringify(json, null, 2) + '</pre>';
                    }
                } catch (e) {
                    document.getElementById('forum-result').innerHTML = '<div class="error"><strong>✗ Invalid Response:</strong><pre>' + data + '</pre></div>';
                }
                loadLogs();
            })
            .catch(e => {
                document.getElementById('forum-result').innerHTML = '<div class="error"><strong>✗ Error:</strong> ' + e.message + '</div>';
            });
    }

    function loadLogs() {
        fetch('<?= base_url('forumaitest/get_logs') ?>')
            .then(r => r.text())
            .then(data => {
                document.getElementById('logs-result').innerHTML = '<pre>' + escapeHtml(data) + '</pre>';
            })
            .catch(e => {
                document.getElementById('logs-result').innerHTML = '<div class="error">Could not load logs: ' + e.message + '</div>';
            });
    }

    function escapeHtml(text) {
        const map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // Load logs on page load
    window.onload = function() {
        loadLogs();
    };
    </script>
</body>
</html>
        <?php
    }

    public function get_config() {
        $this->output->set_content_type('application/json');
        
        $this->config->load('ollama', TRUE);
        
        $data = [
            'ollama_enabled' => $this->config->item('ollama_enabled', 'ollama'),
            'ollama_host' => $this->config->item('ollama_host', 'ollama'),
            'ollama_model' => $this->config->item('ollama_model', 'ollama'),
            'ollama_timeout' => $this->config->item('ollama_timeout', 'ollama'),
            'ollama_temperature' => $this->config->item('ollama_temperature', 'ollama'),
        ];
        
        $this->output->set_output(json_encode($data));
    }

    public function get_logs() {
        $this->output->set_content_type('text/plain');
        
        $logs = "";
        
        $forum_log = APPPATH . 'logs/forum_ai_debug.log';
        if (file_exists($forum_log)) {
            $logs .= "╔════════════════════════════════════════════╗\n";
            $logs .= "║       FORUM AI DEBUG LOG                   ║\n";
            $logs .= "╚════════════════════════════════════════════╝\n\n";
            $logs .= file_get_contents($forum_log);
            $logs .= "\n\n";
        }
        
        $ai_log = APPPATH . 'logs/ai_debug.log';
        if (file_exists($ai_log)) {
            $logs .= "╔════════════════════════════════════════════╗\n";
            $logs .= "║       AI HELPER DEBUG LOG                  ║\n";
            $logs .= "╚════════════════════════════════════════════╝\n\n";
            $logs .= file_get_contents($ai_log);
            $logs .= "\n\n";
        }
        
        $ci_log = APPPATH . 'logs/log-' . date('Y-m-d') . '.php';
        if (file_exists($ci_log)) {
            $logs .= "╔════════════════════════════════════════════╗\n";
            $logs .= "║       CODEIGNITER LOG (Last 1500 chars)    ║\n";
            $logs .= "╚════════════════════════════════════════════╝\n\n";
            $content = file_get_contents($ci_log);
            $content = str_replace('<?php  ?>' . "\n", '', $content);
            $logs .= substr($content, -1500);
        }
        
        if (empty($logs)) {
            $logs = "No debug logs found yet. Try generating content first.";
        }
        
        $this->output->set_output($logs);
    }
}
