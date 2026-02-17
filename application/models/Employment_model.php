<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employment_model extends CI_Model {
    public function get_by_alumni($alumni_id) {
        return $this->db->where('alumni_id', $alumni_id)
                        ->order_by('created_at', 'DESC')
                        ->get('employment')
                        ->row_array();
    }

    public function save_for_alumni($alumni_id, $data) {
        $existing = $this->db->where('alumni_id', $alumni_id)->get('employment')->row_array();
        if ($existing) {
            return $this->db->where('id', $existing['id'])->update('employment', $data);
        } else {
            $data['alumni_id'] = $alumni_id;
            return $this->db->insert('employment', $data);
        }
    }

    public function get_all_for_admin() {
        return $this->db->select('e.*, a.first_name, a.last_name, a.email, a.graduation_year')
                        ->from('employment e')
                        ->join('alumni a', 'a.id = e.alumni_id', 'left')
                        ->order_by('a.graduation_year','DESC')
                        ->get()
                        ->result_array();
    }
}
