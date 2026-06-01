<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_approval_status_to_employers extends CI_Migration {

    public function up()
    {
        // Add column only if table exists and column missing
        if ($this->db->table_exists('employers') && ! $this->db->field_exists('approval_status', 'employers')) {
            $this->db->query("ALTER TABLE `employers` 
                ADD COLUMN `approval_status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending' AFTER `is_active`");
        }
    }

    public function down()
    {
        // Remove column only if exists
        if ($this->db->table_exists('employers') && $this->db->field_exists('approval_status', 'employers')) {
            $this->db->query("ALTER TABLE `employers` DROP COLUMN `approval_status`");
        }
    }
}
