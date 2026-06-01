<?php
/**
 * Seed Initial Roles and Permissions
 * Visit: http://localhost/Aconnect_ci3/seed_roles.php
 */

// Define paths
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('BASEPATH', FCPATH . 'system' . DIRECTORY_SEPARATOR);
define('APPPATH', FCPATH . 'application' . DIRECTORY_SEPARATOR);
define('VIEWPATH', APPPATH . 'views' . DIRECTORY_SEPARATOR);
define('ENVIRONMENT', 'development');

// Load CodeIgniter
require_once BASEPATH . 'core/CodeIgniter.php';

$CI = &get_instance();
$CI->load->model('Rbac_model');

// Define roles to seed
$roles = [
    ['role_name' => 'admin', 'description' => 'Administrator with full access'],
    ['role_name' => 'employer', 'description' => 'Employer account holder'],
    ['role_name' => 'alumni', 'description' => 'Alumni member'],
    ['role_name' => 'moderator', 'description' => 'Forum moderator'],
    ['role_name' => 'guest', 'description' => 'Guest user'],
];

echo "<h2>Seeding Roles...</h2>";
echo "<ul>";

foreach ($roles as $role) {
    // Check if role already exists
    $existing = $CI->db->where('role_name', $role['role_name'])->get('roles')->row();
    
    if ($existing) {
        echo "<li>✓ Role '{$role['role_name']}' already exists</li>";
    } else {
        $CI->db->insert('roles', $role);
        echo "<li>✓ Created role '{$role['role_name']}'</li>";
    }
}

echo "</ul>";
echo "<h2>✅ Seeding Complete!</h2>";
echo "<p><a href='http://localhost/Aconnect_ci3/AdminPageVisibility'>Go to Page Visibility Settings →</a></p>";
?>
