<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_employer_id_to_jobs extends CI_Migration {

    public function up()
    {
        // Skip if column already exists
        if ($this->db->field_exists('employer_id', 'jobs')) {
            return TRUE;
        }

        $sql = "ALTER TABLE `jobs` ADD COLUMN `employer_id` INT(11) NULL AFTER `id`;";

        if ($this->db->query($sql)) {
            // Add index for faster queries
            $this->db->query("ALTER TABLE `jobs` ADD INDEX `idx_employer_id` (`employer_id`);");
            return TRUE;
        }

        return FALSE;
    }

    public function down()
    {
        if ($this->db->field_exists('employer_id', 'jobs')) {
            $this->db->query("ALTER TABLE `jobs` DROP COLUMN `employer_id`;");
            $this->db->query("ALTER TABLE `jobs` DROP INDEX `idx_employer_id`;");
        }

        return TRUE;
    }
}
