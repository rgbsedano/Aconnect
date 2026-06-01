<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration: Add deleted_at column to jobs table for soft deletes
 * Version: 010
 * 
 * This migration adds the deleted_at column to support soft delete functionality
 * in the jobs table. Instead of permanently deleting records, they will be marked
 * as deleted by setting the deleted_at timestamp.
 */
class Migration_Add_deleted_at_to_jobs extends CI_Migration {

    public function up() {
        // Check if column already exists
        if (!$this->db->field_exists('deleted_at', 'jobs')) {
            $this->db->query("
                ALTER TABLE `jobs` 
                ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL 
                AFTER `created_at`
            ");
            
            log_message('info', 'Migration: Added deleted_at column to jobs table');
            return TRUE;
        }
        
        return TRUE;
    }

    public function down() {
        // Drop the column for rollback
        if ($this->db->field_exists('deleted_at', 'jobs')) {
            $this->db->query("
                ALTER TABLE `jobs` 
                DROP COLUMN `deleted_at`
            ");
            
            log_message('info', 'Migration: Dropped deleted_at column from jobs table');
            return TRUE;
        }
        
        return TRUE;
    }
}
