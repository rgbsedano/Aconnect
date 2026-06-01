<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_comment_voting_tables extends CI_Migration {

    public function up()
    {
        // Skip if tables already exist
        if ($this->db->table_exists('forum_comment_likes') && $this->db->table_exists('forum_comment_dislikes')) {
            return TRUE;
        }

        // Create forum_comment_likes table using raw SQL
        if (!$this->db->table_exists('forum_comment_likes')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS forum_comment_likes (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    comment_id INT(11) NOT NULL,
                    alumni_id INT(11) NOT NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id),
                    UNIQUE KEY unique_comment_like (comment_id, alumni_id),
                    KEY alumni_id (alumni_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
            ");
        }

        // Create forum_comment_dislikes table using raw SQL
        if (!$this->db->table_exists('forum_comment_dislikes')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS forum_comment_dislikes (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    comment_id INT(11) NOT NULL,
                    alumni_id INT(11) NOT NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id),
                    UNIQUE KEY unique_comment_dislike (comment_id, alumni_id),
                    KEY alumni_id (alumni_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
            ");
        }
    }

    public function down()
    {
        $this->dbforge->drop_table('forum_comment_likes');
        $this->dbforge->drop_table('forum_comment_dislikes');
    }
}
