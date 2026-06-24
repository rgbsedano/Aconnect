<?php
// Load CodeIgniter
define('BASEPATH', realpath(dirname(__FILE__)) . '/system/');
define('APPPATH', realpath(dirname(__FILE__)) . '/application/');
define('ENVIRONMENT', 'development');

require_once BASEPATH . 'core/CodeIgniter.php';

// Run migrations
$this->load->library('migration');
if (!$this->migration->current()) {
    echo "Migration failed: " . $this->migration->error_string();
} else {
    echo "Migration applied successfully!";
}
?>
