<?php
/**
 * Migration Runner Script
 * Run this file in a browser: http://localhost/Aconnect_ci3/migrate.php
 */

// Load CodeIgniter
require_once 'index.php';

// Initialize CodeIgniter
$CI = &get_instance();

// Load migration library
$CI->load->library('migration');

// Run all pending migrations
if ($CI->migration->current() === FALSE) {
    echo "Migration FAILED!<br>";
    echo "Error: " . $CI->migration->error_string();
} else {
    echo "Migration(s) completed successfully!<br>";
    echo "Current version: " . $CI->migration->current();
}
?>
