<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_employers_table extends CI_Migration {

    public function up()
    {
        // Skip if table already exists
        if ($this->db->table_exists('employers')) {
            return TRUE;
        }

        $sql = "CREATE TABLE IF NOT EXISTS `employers` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `company_name` varchar(150) NOT NULL,
            `first_name` varchar(100) NOT NULL,
            `last_name` varchar(100) NOT NULL,
            `email` varchar(255) NOT NULL UNIQUE,
            `password` varchar(255) NOT NULL,
            `phone` varchar(20) NOT NULL,
            `hear_about_us` varchar(255) DEFAULT NULL,
            `account_type` varchar(50) DEFAULT 'employer',
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            `is_active` tinyint(1) DEFAULT 0,
            `email_verified_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `unique_email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        if ($this->db->query($sql)) {
            return TRUE;
        }

        return FALSE;
    }

    public function down()
    {
        if ($this->db->table_exists('employers')) {
            $this->db->query('DROP TABLE `employers`');
        }

        return TRUE;
    }
}
