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

    public function has_applied($job_id, $alumni_id) {
        $query = $this->db->where('job_id', $job_id)
            ->where('alumni_id', $alumni_id)
            ->get('job_applications');
        return $query->num_rows() > 0;
    }

    public function update_job($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('jobs', $data);
    }

    /**
     * Save a job for an alumni (persistent storage in database)
     * Note: Requires saved_jobs table. Uses localStorage on client as fallback.
     */
    public function save_job($job_id, $alumni_id) {
        $data = [
            'job_id' => $job_id,
            'alumni_id' => $alumni_id,
            'saved_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('saved_jobs', $data);
    }

    /**
     * Unsave a job for an alumni
     */
    public function unsave_job($job_id, $alumni_id) {
        return $this->db->where('job_id', $job_id)
            ->where('alumni_id', $alumni_id)
            ->delete('saved_jobs');
    }

    /**
     * Get all saved jobs for an alumni, ordered by most recent
     */
    public function get_saved_jobs($alumni_id) {
        // Check if saved_jobs table exists before querying
        if (!$this->db->table_exists('saved_jobs')) {
            log_message('debug', 'saved_jobs table does not exist yet');
            return [];
        }
        
        return $this->db->select('j.*')
            ->from('saved_jobs sj')
            ->join('jobs j', 'sj.job_id = j.id', 'inner')
            ->where('sj.alumni_id', $alumni_id)
            ->order_by('sj.saved_at', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Check if a specific job is saved by an alumni
     */
    public function is_job_saved($job_id, $alumni_id) {
        $query = $this->db->where('job_id', $job_id)
            ->where('alumni_id', $alumni_id)
            ->get('saved_jobs');
        return $query->num_rows() > 0;
    }

    /**
     * Get applied jobs for an alumni.
     */
    public function get_applied_jobs($alumni_id) {
        return $this->db->select('j.*, MAX(ja.id) AS application_sort_id', false)
            ->from('job_applications ja')
            ->join('jobs j', 'ja.job_id = j.id', 'inner')
            ->where('ja.alumni_id', $alumni_id)
            ->group_by('j.id')
            ->order_by('application_sort_id', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Get interview jobs for an alumni when interview table exists.
     */
    public function get_interview_jobs($alumni_id) {
        if (!$this->db->table_exists('job_interviews')) {
            return [];
        }

        return $this->db->select('j.*')
            ->from('job_interviews ji')
            ->join('jobs j', 'ji.job_id = j.id', 'inner')
            ->where('ji.alumni_id', $alumni_id)
            ->order_by('ji.id', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Hydrate jobs by a list of job IDs.
     */
    public function get_jobs_by_ids($job_ids) {
        if (empty($job_ids)) {
            return [];
        }

        return $this->db->select('*')
            ->from('jobs')
            ->where_in('id', $job_ids)
            ->get()
            ->result();
    }
}
