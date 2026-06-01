<?php
/**
 * Add role column to employers table
 * Visit: http://localhost/Aconnect_ci3/add_role_to_employers.php
 */

// Define paths FIRST before anything else
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('BASEPATH', FCPATH . 'system' . DIRECTORY_SEPARATOR);
define('APPPATH', FCPATH . 'application' . DIRECTORY_SEPARATOR);
define('VIEWPATH', APPPATH . 'views' . DIRECTORY_SEPARATOR);

// Set environment
define('ENVIRONMENT', 'development');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load the CodeIgniter core
require_once BASEPATH . 'core/CodeIgniter.php';

// Get CI instance
$CI = &get_instance();

echo "<html><head><title>Database Migration</title><style>body{font-family:Arial;margin:20px;}</style></head><body>";
echo "<h1>Adding role Column to employers Table</h1>";

// Check if employers table exists
if (!$CI->db->table_exists('employers')) {
    echo "<p style='color: red;'><strong>Error:</strong> employers table does not exist.</p>";
    echo "</body></html>";
    exit;
}

// Check if column already exists
if ($CI->db->field_exists('role', 'employers')) {
    echo "<p style='color: orange;'><strong>Notice:</strong> role column already exists in employers table.</p>";
    echo "<p>Setting all employers to 'employer' role by default...</p>";
    $CI->db->query("UPDATE employers SET role = 'employer' WHERE role IS NULL OR role = '';");
    echo "<p style='color: green;'><strong>✓ Updated:</strong> Set default role</p>";
    echo "</body></html>";
    exit;
}

// Run the migration
try {
    // Add role column
    $sql1 = "ALTER TABLE `employers` ADD COLUMN `role` VARCHAR(50) DEFAULT 'employer' AFTER `account_type`;";
    $CI->db->query($sql1);
    echo "<p style='color: green;'><strong>✓ Success:</strong> Added role column</p>";
    
    echo "<p style='color: green;'><strong>✓ Migration completed successfully!</strong></p>";
    echo "<p>Now you can set your account role in HeidiSQL:</p>";
    echo "<p><code>UPDATE employers SET role = 'admin' WHERE email = 'your_email@example.com';</code></p>";
    echo "<p><a href='" . base_url('employer_login') . "'>Go to Employer Login</a></p>";
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Error:</strong> " . $e->getMessage() . "</p>";
}

echo "</body></html>";
?>
