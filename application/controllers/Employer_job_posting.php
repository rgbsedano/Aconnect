<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Employer_Job_Posting Controller
 * Handles job posting management for employers
 */
class Employer_job_posting extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Job_model');
        
        // Check if employer is logged in with correct user_type
        if (!$this->session->userdata('login_status')) {
            redirect('employer_login');
        }
        
        if ($this->session->userdata('user_type') !== 'employer') {
            log_message('warning', 'Non-employer user attempted to access employer_job_posting. User type: ' . $this->session->userdata('user_type'));
            redirect('login');
        }
    }

    /**
     * Display job posting management page
     */
    public function index()
    {
        $employer_id = $this->session->userdata('user_id');
        
        // Get employer's posted jobs
        $data['jobs'] = $this->Job_model->get_employer_jobs($employer_id);
        $data['page_title'] = 'Post a Job';
        
        $this->load->view('employer/job_posting', $data);
    }

    /**
     * Create a new job posting
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('employer_job_posting');
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('job_title', 'Job Title', 'required|min_length[5]|max_length[150]');
        $this->form_validation->set_rules('job_description', 'Job Description', 'required|min_length[20]');
        $this->form_validation->set_rules('job_category', 'Job Category', 'required');
        $this->form_validation->set_rules('salary_range', 'Salary Range', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->index();
            return;
        }

        $job_data = [
            'employer_id' => $this->session->userdata('user_id'),
            'company_name' => $this->session->userdata('company_name'),
            'job_title' => $this->input->post('job_title'),
            'job_description' => $this->input->post('job_description'),
            'job_category' => $this->input->post('job_category'),
            'salary_range' => $this->input->post('salary_range'),
            'location' => $this->input->post('location'),
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 'active',
        ];

        if ($this->db->insert('jobs', $job_data)) {
            $this->session->set_flashdata('success_message', 'Job posted successfully!');
        } else {
            $this->session->set_flashdata('error_message', 'Error posting job. Please try again.');
        }

        redirect('employer_job_posting');
    }

    /**
     * Edit a job posting
     */
    public function edit($job_id = null)
    {
        if (!$job_id) {
            redirect('employer_job_posting');
        }

        $employer_id = $this->session->userdata('user_id');
        $job = $this->Job_model->get_job_by_id($job_id);

        // Verify employer owns this job
        if (!$job || $job->employer_id != $employer_id) {
            $this->session->set_flashdata('error_message', 'You do not have permission to edit this job.');
            redirect('employer_job_posting');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('job_title', 'Job Title', 'required|min_length[5]|max_length[150]');
            $this->form_validation->set_rules('job_description', 'Job Description', 'required|min_length[20]');

            if ($this->form_validation->run() === FALSE) {
                $data['job'] = $job;
                $this->load->view('employer/edit_job', $data);
                return;
            }

            $update_data = [
                'job_title' => $this->input->post('job_title'),
                'job_description' => $this->input->post('job_description'),
                'job_category' => $this->input->post('job_category'),
                'salary_range' => $this->input->post('salary_range'),
                'location' => $this->input->post('location'),
            ];

            $this->db->where('id', $job_id);
            if ($this->db->update('jobs', $update_data)) {
                $this->session->set_flashdata('success_message', 'Job updated successfully!');
                redirect('employer_job_posting');
            }
        }

        $data['job'] = $job;
        $this->load->view('employer/edit_job', $data);
    }

    /**
     * Delete a job posting
     */
    public function delete($job_id = null)
    {
        if (!$job_id) {
            redirect('employer_job_posting');
        }

        $employer_id = $this->session->userdata('user_id');
        $job = $this->Job_model->get_job_by_id($job_id);

        // Verify employer owns this job
        if (!$job || $job->employer_id != $employer_id) {
            $this->session->set_flashdata('error_message', 'You do not have permission to delete this job.');
            redirect('employer_job_posting');
        }

        $this->db->where('id', $job_id);
        if ($this->db->delete('jobs')) {
            $this->session->set_flashdata('success_message', 'Job deleted successfully!');
        } else {
            $this->session->set_flashdata('error_message', 'Error deleting job.');
        }

        redirect('employer_job_posting');
    }
}
