<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration: Create Profanity Filter Cache Table
 * 
 * Creates a table to store profanity filter results per user/post
 * to avoid redundant API calls and improve performance
 */

class Migration_Create_profanity_filter_cache extends CI_Migration {

    public function up() {
        // Skip if table already exists
        if ($this->db->table_exists('profanity_filter_cache')) {
            return TRUE;
        }

        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'post_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE,
                'comment' => 'Forum post ID (nullable if not from forum)'
            ],
            'alumni_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE,
                'comment' => 'Alumni ID of the content creator'
            ],
            'original_text' => [
                'type' => 'LONGTEXT',
                'comment' => 'Original text before censoring'
            ],
            'prompt_used' => [
                'type' => 'LONGTEXT',
                'comment' => 'The AI prompt sent to Gemini'
            ],
            'api_response' => [
                'type' => 'LONGTEXT',
                'comment' => 'Raw JSON response from Gemini API'
            ],
            'censored_text' => [
                'type' => 'LONGTEXT',
                'comment' => 'Final censored text after processing'
            ],
            'detected_profanities' => [
                'type' => 'JSON',
                'comment' => 'Array of detected profanity words'
            ],
            'is_profane' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Boolean: 1 if profanities detected, 0 otherwise'
            ],
            'processing_time_ms' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE,
                'comment' => 'API response time in milliseconds'
            ],
            'api_status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'success',
                'comment' => 'API call status: success, failed, timeout'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'comment' => 'Timestamp when record created'
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
                'comment' => 'Timestamp when record last updated'
            ]
        ]);

        // Primary Key
        $this->dbforge->add_key('id', TRUE);
        
        // Foreign Keys & Indexes
        $this->dbforge->add_key('post_id');
        $this->dbforge->add_key('alumni_id');
        
        // Composite index for faster lookups
        $this->db->query('ALTER TABLE profanity_filter_cache ADD INDEX idx_alumni_post (alumni_id, post_id)');
        
        // Index for cache lookups by original text (32 chars of MD5 hash)
        $this->db->query('ALTER TABLE profanity_filter_cache 
            ADD COLUMN text_hash VARCHAR(32) GENERATED ALWAYS AS (MD5(original_text)) STORED, 
            ADD INDEX idx_text_hash (text_hash)');

        // Create the table
        $this->dbforge->create_table('profanity_filter_cache', TRUE);

        log_message('info', 'Created profanity_filter_cache table');
    }

    public function down() {
        $this->dbforge->drop_table('profanity_filter_cache');
        log_message('info', 'Dropped profanity_filter_cache table');
    }

}
