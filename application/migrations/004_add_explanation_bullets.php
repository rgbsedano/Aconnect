<?php

class Migration_Add_explanation_bullets extends CI_Migration {

    public function up()
    {
        // Skip if column already exists
        if ($this->db->field_exists('explanation_bullets', 'ai_explanation_cache')) {
            return TRUE;
        }

        // Add a column for bulletted explanations combining strengths and gaps
        $this->dbforge->add_column('ai_explanation_cache', array(
            'explanation_bullets' => array(
                'type' => 'LONGTEXT',
                'null' => TRUE,
                'comment' => 'Formatted bullet points of strengths and gaps'
            )
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('ai_explanation_cache', 'explanation_bullets');
    }
}
