<?php

class Jobs extends CI_Controller {

    function __construct() {
        parent::__construct();
    
        // SESSION CHECK
        if ($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy") {
            redirect(base_url("Login"));
        }

        $this->load->helper(['form', 'url', 'date']);
        $this->load->library(['session', 'upload']);
        $this->load->model('user/Job_model');
    }
 
    function index() {

        $this->load->view('__header');

        // Logged in alumni details (AI Match uses this)
        $alumni_id = $this->session->userdata('alumni_id');
        $alumni = $this->db->where('id', $alumni_id)->get('alumni')->row();

        // If null, create dummy object to avoid "undefined" errors
        if (!$alumni) {
            $alumni = (object)[
                'degree' => '',
                'technical_skills' => '',
                'soft_skills' => ''
            ];
        }

        // SEARCH FILTERS
        $search   = $this->input->get('search');
        $location = $this->input->get('location');

        // FETCH JOBS
        $jobs = $this->Job_model->get_all_jobs($search, $location);

        $data = [
            'jobs'   => $jobs,
            'alumni' => $alumni
        ];

        $this->load->view('user/jobs', $data);
        $this->load->view('__footer');
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
            echo "Error: " . $this->upload->display_errors();
        } else {
            $this->Job_model->apply_to_job($job_id, $alumni_id);
            redirect('jobs');
        }
    }
}
