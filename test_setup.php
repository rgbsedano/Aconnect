<?php
/**
 * AConnect Setup Health Check
 * Visit: http://localhost/Aconnect_ci3/test_setup.php
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>AConnect Setup Check</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h1 { color: #a12124; border-bottom: 2px solid #a12124; padding-bottom: 10px; }
        .check { padding: 15px; margin: 10px 0; border-left: 4px solid #ddd; border-radius: 4px; }
        .check.pass { border-left-color: #10b981; background: #f0fdf4; }
        .check.fail { border-left-color: #ef4444; background: #fef2f2; }
        .check.warn { border-left-color: #f59e0b; background: #fffbeb; }
        .icon { font-weight: bold; margin-right: 8px; }
        code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
<div class='container'>
    <h1>🔍 AConnect Setup Health Check</h1>";

// 1. PHP Version
$php_version = phpversion();
echo "<div class='check pass'><span class='icon'>✅</span> <strong>PHP Version:</strong> $php_version</div>";

// 2. Database Connection
echo "<div class='check'><span class='icon'>";
try {
    $mysqli = new mysqli('localhost', 'root', '', 'aconnect_db');
    if ($mysqli->connect_error) {
        echo "❌</span> <strong>Database Connection:</strong> Failed - " . $mysqli->connect_error;
        echo "</div>";
    } else {
        // Check tables
        $result = $mysqli->query("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = 'aconnect_db'");
        $row = $result->fetch_assoc();
        $table_count = $row['count'];
        
        if ($table_count > 0) {
            echo "✅</span> <strong>Database Connection:</strong> Connected ✓ | Tables: $table_count";
            echo "</div>";
        } else {
            echo "⚠️</span> <strong>Database Connection:</strong> Connected but NO TABLES FOUND";
            echo "</div>";
        }
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "❌</span> <strong>Database Connection:</strong> Error - " . $e->getMessage();
    echo "</div>";
}

// 3. Ollama Connection
echo "<div class='check'>";
$ollama_host = 'http://127.0.0.1:11434';
$ch = curl_init($ollama_host . '/api/tags');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 2);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    $data = json_decode($response, true);
    $models = isset($data['models']) ? count($data['models']) : 0;
    echo "<span class='icon'>✅</span> <strong>Ollama:</strong> Running ✓ | Models: $models";
    if ($models > 0) {
        echo "<br><small style='margin-left: 26px;'>";
        foreach ($data['models'] as $model) {
            echo "• " . $model['name'] . "<br>";
        }
        echo "</small>";
    }
} else {
    echo "<span class='icon'>❌</span> <strong>Ollama:</strong> NOT RUNNING at $ollama_host";
}
echo "</div>";

// 4. CodeIgniter Config
echo "<div class='check'>";
if (file_exists('application/config/ollama.php')) {
    echo "<span class='icon'>✅</span> <strong>Ollama Config:</strong> Found <code>application/config/ollama.php</code>";
} else {
    echo "<span class='icon'>❌</span> <strong>Ollama Config:</strong> Missing";
}
echo "</div>";

// 5. Critical Helpers
$helpers = ['ai_helper.php', 'profanity_filter_helper.php'];
$all_exist = true;
foreach ($helpers as $helper) {
    if (!file_exists("application/helpers/$helper")) {
        $all_exist = false;
        break;
    }
}

echo "<div class='check " . ($all_exist ? "pass" : "fail") . "'>";
echo "<span class='icon'>" . ($all_exist ? "✅" : "❌") . "</span> <strong>AI Helpers:</strong> ";
if ($all_exist) {
    echo "All present ✓";
} else {
    echo "Some missing!";
}
echo "</div>";

// Summary
echo "<hr style='margin: 30px 0;'>";
echo "<h2 style='color: #10b981;'>✅ Setup Complete!</h2>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>If any checks are ❌, review the error above</li>";
echo "<li>Access the app: <a href='/Aconnect_ci3/'>http://localhost/Aconnect_ci3/</a></li>";
echo "<li><strong>Test Features:</strong>";
echo "  <ul>";
echo "    <li>Forum (AI Profanity Filter) - <a href='/Aconnect_ci3/forum'>/forum</a></li>";
echo "    <li>Jobs (AI Matching) - <a href='/Aconnect_ci3/jobs'>/jobs</a></li>";
echo "    <li>Employer Login - <a href='/Aconnect_ci3/employer_login'>/employer_login</a></li>";
echo "  </ul>";
echo "</li>";
echo "</ol>";
echo "</div></body></html>";
?>
