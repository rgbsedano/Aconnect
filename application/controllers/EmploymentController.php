<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmploymentController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Employment_model');
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url']);
           $this->load->helper('text');   // <-- ADD THIS LINE
        
        $alumni_id = $this->session->userdata('alumni_id');
        $employment = $this->Employment_model->get_by_alumni($alumni_id);
        $data['employment'] = $employment;
        $this->load->view('user/profile', $data);
    }

    private function require_alumni_login() {
        if (! $this->session->userdata('alumni_id')) {
            redirect('login');
        }
    }

public function submit() {
    $this->require_alumni_login();
    $alumni_id = $this->session->userdata('alumni_id');

    $this->form_validation->set_rules('employment_status', 'Employment Status', 'required');
    $this->form_validation->set_rules('job_description', 'Job Description', 'required');
    $this->form_validation->set_rules('year_of_service', 'Year of Service', 'required|integer');
    $this->form_validation->set_rules('promotion_count', 'Promotion Count', 'required|integer');

    if ($this->form_validation->run() === FALSE) {
        $this->session->set_flashdata('error', validation_errors('<div>','</div>'));
        // show modal again so user can fix errors
        $this->session->set_flashdata('show_employment_modal', true);
        redirect('profile');
        return;
    }

    $data = [
        'employment_status' => $this->input->post('employment_status', TRUE),
        'company_name'      => $this->input->post('company_name', TRUE),
        'job_title'         => $this->input->post('job_title', TRUE),
        'job_description'   => $this->input->post('job_description', TRUE),
        'year_of_service'   => (int)$this->input->post('year_of_service', TRUE),
        'promotion_count'   => (int)$this->input->post('promotion_count', TRUE),
    ];

    if ($this->Employment_model->save_for_alumni($alumni_id, $data)) {
        $this->session->set_flashdata('success', 'Employment information saved successfully.');
        // instruct profile view to auto-open modal (optional) — you wanted auto-show
        $this->session->set_flashdata('show_employment_modal', true);
    } else {
        $this->session->set_flashdata('error', 'Failed to save employment information.');
        $this->session->set_flashdata('show_employment_modal', true);
    }
    $this->session->set_flashdata('success', 'Employment information saved successfully.');
    $this->session->set_flashdata('show_employment_modal', true);

    redirect('profile');
}

    
}
