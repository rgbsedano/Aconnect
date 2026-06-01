<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_model extends CI_Model {

    /**
     * Get all jobs
     */
    public function get_all_jobs()
    {
        return $this->db->get('jobs')->result();
    }

    /**
     * Get jobs visible to an employer (own jobs + jobs from same group)
     * 
     * @param int $employer_id - The employer viewing the jobs
     * @return array Jobs from own employer and employers in same group(s)
     */
    public function get_jobs_for_employer($employer_id)
    {
        // Load Rbac_model to get visible employer IDs
        $this->load->model('Rbac_model');
        $visible_employer_ids = $this->Rbac_model->get_visible_employer_ids($employer_id);
        
        // Get jobs from visible employers
        return $this->db->where_in('employer_id', $visible_employer_ids)
                        ->get('jobs')
                        ->result();
    }

    /**
     * Get jobs by employer ID
     */
    public function get_employer_jobs($employer_id)
    {
        return $this->db->where('employer_id', $employer_id)
                        ->get('jobs')
                        ->result();
    }

    /**
     * Get job by ID
     */
    public function get_job_by_id($job_id)
    {
        return $this->db->where('id', $job_id)
                        ->get('jobs')
                        ->row();
    }

    /**
     * Create a new job
     */
    public function create_job($data)
    {
        return $this->db->insert('jobs', $data);
    }

    /**
     * Update job
     */
    public function update_job($job_id, $data)
    {
        return $this->db->where('id', $job_id)
                        ->update('jobs', $data);
    }

    /**
     * Delete job
     */
    public function delete_job($job_id)
    {
        return $this->db->where('id', $job_id)
                        ->delete('jobs');
    }

    /**
     * Get applicants by job
     */
    public function get_applicants_by_job($job_id)
    {
        return $this->db->select('a.student_number, a.first_name, a.last_name, a.email, a.graduation_year, a.degree')
                        ->from('job_applications ja')
                        ->join('alumni a', 'ja.alumni_id = a.id')
                        ->where('ja.job_id', $job_id)
                        ->get()
                        ->result();
    }
}
