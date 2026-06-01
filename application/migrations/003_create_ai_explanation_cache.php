<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_ai_explanation_cache extends CI_Migration {

    public function up()
    {
        // Skip if table already exists
        if ($this->db->table_exists('ai_explanation_cache')) {
            return TRUE;
        }

        // Create table using raw SQL for proper TIMESTAMP handling
        $this->db->query("
            CREATE TABLE IF NOT EXISTS ai_explanation_cache (
                id INT(11) NOT NULL AUTO_INCREMENT,
                alumni_id INT(11) NOT NULL,
                job_id INT(11) NOT NULL,
                prompt LONGTEXT NOT NULL COMMENT 'The AI prompt sent to Gemini API',
                api_response LONGTEXT NOT NULL COMMENT 'Complete JSON response from Gemini API',
                strengths JSON NULL COMMENT 'Extracted strengths array from API response',
                gaps JSON NULL COMMENT 'Extracted gaps array from API response',
                summary TEXT NULL COMMENT 'Extracted summary from API response',
                status VARCHAR(50) NULL COMMENT 'Match status (e.g., Excellent Match, Good Match)',
                match_percentage INT(3) NULL COMMENT 'The match percentage used for this explanation',
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When the explanation was generated',
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last time cache was accessed',
                PRIMARY KEY (id),
                UNIQUE KEY unique_alumni_job (alumni_id, job_id),
                KEY alumni_id (alumni_id),
                KEY job_id (job_id),
                KEY created_at (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
        ");
        
        log_message('info', 'Migration 003: Created ai_explanation_cache table');
    }

    public function down()
    {
        $this->dbforge->drop_table('ai_explanation_cache');
        log_message('info', 'Migration 003: Dropped ai_explanation_cache table');
    }
}
