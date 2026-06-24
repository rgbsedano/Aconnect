<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracer_model extends CI_Model {
    private $table = 'tracer_survey_responses';

    public function get_by_alumni($alumni_id) {
        if (! $this->db->table_exists($this->table)) {
            return null;
        }

        return $this->db->where('alumni_id', $alumni_id)
                        ->order_by('created_at', 'DESC')
                        ->get($this->table)
                        ->row_array();
    }

    public function save_for_alumni($alumni_id, $data) {
        if (! $this->db->table_exists($this->table)) {
            return false;
        }

        $existing = $this->db->where('alumni_id', $alumni_id)->get($this->table)->row_array();
        $payload = array_merge($data, [
            'alumni_id' => $alumni_id,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($existing) {
            return $this->db->where('id', $existing['id'])->update($this->table, $payload);
        }

        $payload['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $payload);
    }
}