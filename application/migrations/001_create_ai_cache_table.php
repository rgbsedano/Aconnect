<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_ai_cache_table extends CI_Migration {

    public function up()
    {
        // Skip if table already exists
        if ($this->db->table_exists('ai_match_cache')) {
            return TRUE;
        }

        // Create table using raw SQL for proper TIMESTAMP handling
        $this->db->query("
            CREATE TABLE IF NOT EXISTS ai_match_cache (
                alumni_id INT(11) NOT NULL,
                job_id INT(11) NOT NULL,
                prompt LONGTEXT NOT NULL,
                api_response LONGTEXT NOT NULL,
                match_percentage INT(3) NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (alumni_id, job_id),
                KEY created_at (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
        ");
    }

    public function down()
    {
        $this->dbforge->drop_table('ai_match_cache');
    }
}
