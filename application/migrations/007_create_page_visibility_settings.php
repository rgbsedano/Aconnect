<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_page_visibility_settings extends CI_Migration {

    public function up()
    {
        // Skip if table already exists
        if ($this->db->table_exists('page_visibility_settings')) {
            return TRUE;
        }

        // Create 'page_visibility_settings' table using raw SQL for proper TIMESTAMP handling
        $this->db->query("
            CREATE TABLE IF NOT EXISTS page_visibility_settings (
                id INT(11) NOT NULL AUTO_INCREMENT,
                page_slug VARCHAR(100) NOT NULL,
                role_id INT(11) NOT NULL,
                is_visible TINYINT(1) NOT NULL DEFAULT 1,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                KEY page_slug (page_slug),
                KEY role_id (role_id),
                FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
        ");
    }

    public function down()
    {
        $this->dbforge->drop_table('page_visibility_settings');
    }
}
