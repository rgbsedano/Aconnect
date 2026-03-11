<?php

class Jobs extends CI_Controller {

    function __construct() {
        parent::__construct();
    
        // SESSION CHECK
        if ($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy") {
            redirect(base_url("Login"));
        }

        $this->load->helper(['form', 'url', 'date', 'ai_helper']);
        $this->load->library(['session', 'upload']);
        $this->load->model('user/Job_model');
    }
 
    function index() {
        $this->load->view('__header');

        $alumni_id = $this->session->userdata('alumni_id');
        $alumni = $this->db->where('id', $alumni_id)->get('alumni')->row();

        if (!$alumni) {
            $alumni = (object)[
                'degree' => '',
                'technical_skills' => '',
                'soft_skills' => ''
            ];
        }

        $search   = trim($this->input->get('search',TRUE));
        

       
        $location = trim($this->input->get('location',TRUE));
        $jobs = $this->Job_model->get_all_jobs($search, $location);

        $data = [
            'jobs'   => $jobs,
            'alumni' => $alumni
        ];

        $this->load->view('user/jobs', $data);
        $this->load->view('__footer');
    }

    public function live_search() {
        // AJAX endpoint for live job search
        $this->output->set_content_type('application/json');

        $alumni_id = $this->session->userdata('alumni_id');
        $alumni = $this->db->where('id', $alumni_id)->get('alumni')->row();

        if (!$alumni) {
            $alumni = (object)[
                'degree' => '',
                'technical_skills' => '',
                'soft_skills' => ''
            ];
        }

        $search   = trim($this->input->post('search', TRUE));
        $location = trim($this->input->post('location', TRUE));
        
        $jobs = $this->Job_model->get_all_jobs($search, $location);

        $response = [];
        foreach ($jobs as $job) {
            $match = compute_ai_match($alumni, $job);
            $response[] = [
                'id' => $job->id,
                'job_title' => htmlspecialchars($job->job_title),
                'company' => htmlspecialchars($job->company),
                'location' => htmlspecialchars($job->location),
                'salary_range' => htmlspecialchars($job->salary_range),
                'match' => $match,
                'qualifications' => htmlspecialchars($job->qualifications),
                'description' => htmlspecialchars($job->description)
            ];
        }

        echo json_encode($response);
    }

    public function apply($job_id) {
        $alumni_id = $this->session->userdata('alumni_id');

        if (!$alumni_id) {
            redirect('login');
        }

        // Log activity
        $this->load->model('Activity_log_model');
        $this->Activity_log_model->log_activity($alumni_id, 'Applied for a job');

        // FILE UPLOAD
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['max_size'] = 7048;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('attachment')) {
            // Error: Set flashdata and redirect back
            $error = $this->upload->display_errors('', '');
            $this->session->set_flashdata('error', 'Upload failed: ' . $error);
            redirect('jobs');
        } else {
            $this->Job_model->apply_to_job($job_id, $alumni_id);
            // Success: Set success trigger and redirect back
            $this->session->set_flashdata('upload_success', true);
            redirect('jobs');
        }
    }
}