<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_rbac_tables extends CI_Migration {

    public function up()
    {
        // Skip if tables already exist
        if ($this->db->table_exists('roles') && 
            $this->db->table_exists('permissions') && 
            $this->db->table_exists('role_permissions')) {
            return TRUE;
        }

        // Create 'roles' table using raw SQL for proper TIMESTAMP handling
        if (!$this->db->table_exists('roles')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS roles (
                    role_id INT(11) NOT NULL AUTO_INCREMENT,
                    role_name VARCHAR(100) NOT NULL UNIQUE,
                    description TEXT NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (role_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
            ");
        }

        // Create 'permissions' table using raw SQL for proper TIMESTAMP handling
        if (!$this->db->table_exists('permissions')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS permissions (
                    permission_id INT(11) NOT NULL AUTO_INCREMENT,
                    permission_slug VARCHAR(100) NOT NULL UNIQUE,
                    permission_name VARCHAR(255) NOT NULL,
                    description TEXT NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (permission_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
            ");
        }

        // Create 'role_permissions' junction table
        if (!$this->db->table_exists('role_permissions')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS role_permissions (
                    role_id INT(11) NOT NULL,
                    permission_id INT(11) NOT NULL,
                    PRIMARY KEY (role_id, permission_id),
                    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE CASCADE ON UPDATE CASCADE,
                    FOREIGN KEY (permission_id) REFERENCES permissions(permission_id) ON DELETE CASCADE ON UPDATE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
            ");
        }

        // Add 'role_id' column to users table (if not exists)
        if (!$this->db->field_exists('role_id', 'users')) {
            $this->db->query('ALTER TABLE users ADD COLUMN role_id INT(11) AFTER id');
            $this->db->query('ALTER TABLE users ADD FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE SET NULL ON UPDATE CASCADE');
        }

        // Add 'is_visible' column for page visibility control
        if (!$this->db->field_exists('is_visible', 'users')) {
            $this->db->query('ALTER TABLE users ADD COLUMN is_visible TINYINT(1) DEFAULT 1');
        }
    }

    public function down()
    {
        // Drop foreign key from users table first
        $this->db->query('ALTER TABLE users DROP FOREIGN KEY users_ibfk_role_id');
        $this->db->query('ALTER TABLE users DROP COLUMN role_id');
        $this->db->query('ALTER TABLE users DROP COLUMN is_visible');

        // Drop tables in reverse order
        $this->dbforge->drop_table('role_permissions');
        $this->dbforge->drop_table('permissions');
        $this->dbforge->drop_table('roles');
    }
}
