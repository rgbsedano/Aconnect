<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_model extends CI_Model {

    public function get_all_jobs($search = null, $location = null) {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('job_title', $search);
            $this->db->or_like('company', $search);
            $this->db->group_end();
        }
    
        if (!empty($location)) {
            $this->db->like('location', $location);
        }
        $query = $this->db->get('jobs');
        return $query->result();
    }

    public function apply_to_job($job_id, $alumni_id) {
        $data = [
            'job_id' => $job_id,
            'alumni_id' => $alumni_id,
        ];
        $this->db->insert('job_applications', $data);
    }
    public function update_job($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('jobs', $data);
    }
}
