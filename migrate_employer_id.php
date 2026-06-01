<?php
/**
 * Database Migration Runner
 * Add employer_id column to jobs table
 * 
 * Visit: http://localhost/Aconnect_ci3/migrate_employer_id.php
 */

// Define paths FIRST before anything else
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
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

echo "<html><head><title>Database Migration</title></head><body>";
echo "<h1>Adding employer_id Column to jobs Table</h1>";

// Check if jobs table exists
if (!$CI->db->table_exists('jobs')) {
    echo "<p style='color: red;'><strong>Error:</strong> jobs table does not exist.</p>";
    echo "</body></html>";
    exit;
}

// Check if column already exists
if ($CI->db->field_exists('employer_id', 'jobs')) {
    echo "<p style='color: orange;'><strong>Notice:</strong> employer_id column already exists in jobs table.</p>";
    echo "</body></html>";
    exit;
}

// Run the migration
try {
    // Add employer_id column
    $sql1 = "ALTER TABLE `jobs` ADD COLUMN `employer_id` INT(11) NULL AFTER `id`;";
    $CI->db->query($sql1);
    echo "<p style='color: green;'><strong>✓ Success:</strong> Added employer_id column</p>";
    
    // Add index
    $sql2 = "ALTER TABLE `jobs` ADD INDEX `idx_employer_id` (`employer_id`);";
    $CI->db->query($sql2);
    echo "<p style='color: green;'><strong>✓ Success:</strong> Added index on employer_id</p>";
    
    echo "<p style='color: green;'><strong>Migration completed successfully!</strong></p>";
    echo "<p><a href='" . base_url('employer_login') . "'>Go to Employer Login</a></p>";
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Error:</strong> " . $e->getMessage() . "</p>";
}

echo "</body></html>";
?>
