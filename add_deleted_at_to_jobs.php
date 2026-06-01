<?php
/**
 * Add deleted_at column to jobs table
 * This script adds soft delete functionality to jobs
 */

// Load CodeIgniter
require_once('system/core/CodeIgniter.php');

try {
    // Get CI instance
    $CI = &get_instance();
    
    // Load database
    $CI->load->database();
    
    // Check if column already exists
    $columns = $CI->db->list_fields('jobs');
    
    if (in_array('deleted_at', $columns)) {
        echo "<div style='padding: 20px; background: #d4edda; color: #155724; border-radius: 8px; margin: 20px;'>";
        echo "<h3>✓ Column Already Exists</h3>";
        echo "<p>The 'deleted_at' column already exists in the jobs table.</p>";
        echo "</div>";
    } else {
        // Add the column
        $CI->db->query("ALTER TABLE `jobs` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`");
        
        echo "<div style='padding: 20px; background: #d4edda; color: #155724; border-radius: 8px; margin: 20px;'>";
        echo "<h3>✓ Migration Successful</h3>";
        echo "<p>The 'deleted_at' column has been successfully added to the jobs table.</p>";
        echo "<p><strong>Details:</strong></p>";
        echo "<ul>";
        echo "<li>Column Name: deleted_at</li>";
        echo "<li>Type: TIMESTAMP</li>";
        echo "<li>Default: NULL</li>";
        echo "<li>Position: After created_at</li>";
        echo "</ul>";
        echo "</div>";
    }
} catch (Exception $e) {
    echo "<div style='padding: 20px; background: #f8d7da; color: #721c24; border-radius: 8px; margin: 20px;'>";
    echo "<h3>✗ Error Occurred</h3>";
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}
?>
