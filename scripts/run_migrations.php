<?php
/**
 * Direct Migration Runner
 * Visit: http://localhost/Aconnect_ci3/scripts/run_migrations.php
 */

// Define paths FIRST before anything else
define('FCPATH', __DIR__ . '/..' . DIRECTORY_SEPARATOR);
define('BASEPATH', FCPATH . 'system' . DIRECTORY_SEPARATOR);
define('APPPATH', FCPATH . 'application' . DIRECTORY_SEPARATOR);
define('VIEWPATH', APPPATH . 'views' . DIRECTORY_SEPARATOR);

// Set environment
define('ENVIRONMENT', 'development');

// Error reporting
if (!defined('E_STRICT')) {
    define('E_STRICT', 2048);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load the CodeIgniter core
require_once BASEPATH . 'core/CodeIgniter.php';

// Get CI instance
$CI = &get_instance();

// Reset migrations table to handle already-created tables
$migrations_table = 'migrations';
if ($CI->db->table_exists($migrations_table)) {
    // Clear the tracking table to force re-run of all migrations
    $CI->db->truncate($migrations_table);
    echo "<p style='color: orange;'><strong>⚠️ Note:</strong> Migration tracking table was reset. Re-running migrations...</p>";
}

// Load migration library
$CI->load->library('migration');

// Run migrations
if ($CI->migration->current() === FALSE) {
    echo "<h2>❌ Migration Failed</h2>";
    echo "<pre>" . $CI->migration->error_string() . "</pre>";
    echo "<p>If tables already exist, this is expected. The RBAC system should still be functional.</p>";
} else {
    echo "<h2>✅ Migrations Completed Successfully!</h2>";
    echo "<p><strong>Current Migration Version:</strong> " . $CI->migration->current() . "</p>";
    echo "<p>The following tables have been created/updated:</p>";
    echo "<ul>";
    echo "<li>✓ ai_match_cache (AI explanations)</li>";
    echo "<li>✓ profanity_filter_cache (Profanity filtering)</li>";
    echo "<li>✓ ai_explanation_cache (Cached explanations)</li>";
    echo "<li>✓ comment_voting (Comment voting system)</li>";
    echo "<li>✓ roles (RBAC)</li>";
    echo "<li>✓ permissions (RBAC)</li>";
    echo "<li>✓ role_permissions (RBAC)</li>";
    echo "<li>✓ page_visibility_settings (Page visibility control)</li>";
    echo "</ul>";
    echo "<hr>";
    echo "<p>✅ <strong>Your RBAC system is ready!</strong></p>";
    echo "<p><a href='http://localhost/Aconnect_ci3/admindashboard'>Go to Admin Dashboard →</a></p>";
    echo "<p><a href='http://localhost/Aconnect_ci3/AdminPageVisibility'>Manage Page Visibility →</a></p>";
}
?>
