<?php
// Set up environment
define('ENVIRONMENT', isset($_ENV['CI_ENV']) ? $_ENV['CI_ENV'] : 'development');

// Change to the project root (where index.php is)
$root = dirname(__FILE__);

// Define paths
define('BASEPATH', $root . '/system/');
define('APPPATH', $root . '/application/');
define('FCPATH', $root . '/');

// Composer autoload
require_once BASEPATH . '../vendor/autoload.php';

// CodeIgniter bootstrap
require_once BASEPATH . 'core/CodeIgniter.php';

// Now we have CodeIgniter running
// We can call the Forum controller directly

echo "╔════════════════════════════════════════════╗\n";
echo "║   Forum AI Content Generator CLI Test      ║\n";
echo "╚════════════════════════════════════════════╝\n\n";

// Load the Forum controller
$CI = &get_instance();
$CI->load->controller('Forum');
$forum = new Forum();

// Test different modes
$test_cases = [
    [
        'name' => 'Test 1: Both (Edit Title & Content)',
        'mode' => 'both',
        'title' => 'One Piece Latest Chapter',
        'content' => 'IMU tells the lore of the Four Gods'
    ],
    [
        'name' => 'Test 2: Alumni (Generate Random)',
        'mode' => 'alumni',
        'title' => '',
        'content' => ''
    ]
];

foreach ($test_cases as $test) {
    echo "\n" . str_repeat('=', 50) . "\n";
    echo $test['name'] . "\n";
    echo str_repeat('=', 50) . "\n\n";

    // Set up the request simulation
    $_GET['mode'] = $test['mode'];
    $_GET['title'] = $test['title'];
    $_GET['content'] = $test['content'];

    // Call the method
    ob_start();
    $forum->generate_ai_content();
    $output = ob_get_clean();

    // Parse and display result
    if ($output) {
        $json = json_decode($output, true);
        if ($json) {
            if (isset($json['error'])) {
                echo "❌ ERROR: " . $json['error'] . "\n";
                if (isset($json['details'])) {
                    echo "   Details: " . $json['details'] . "\n";
                }
            } else {
                echo "✅ SUCCESS:\n";
                echo json_encode($json, JSON_PRETTY_PRINT) . "\n";
            }
        } else {
            echo "Response:\n" . $output . "\n";
        }
    } else {
        echo "No output\n";
    }

    echo "\n";
}

// Show debug logs
echo "\n" . str_repeat('=', 50) . "\n";
echo "DEBUG LOGS\n";
echo str_repeat('=', 50) . "\n\n";

$forum_log = APPPATH . 'logs/forum_ai_debug.log';
if (file_exists($forum_log)) {
    echo "Forum Debug Log:\n";
    echo str_repeat('-', 50) . "\n";
    echo file_get_contents($forum_log);
    echo "\n";
} else {
    echo "No forum debug log\n\n";
}

$ai_log = APPPATH . 'logs/ai_debug.log';
if (file_exists($ai_log)) {
    echo "\nAI Helper Debug Log:\n";
    echo str_repeat('-', 50) . "\n";
    echo file_get_contents($ai_log);
    echo "\n";
} else {
    echo "No AI debug log\n";
}

echo "\n✅ Test completed\n";
?>
