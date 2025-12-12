<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/Alumni_model');  // Load the Alumni model
        $this->load->library('form_validation');
        // Ensure database & session libraries are autoloaded (recommended)
    }

    public function index() {
        $this->load->view('user/register');
    }

    // Handle the registration form submission
    public function submit() {
        // Basic validation rules
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[alumni.email]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('student_number', 'Student Number', 'required|is_unique[alumni.student_number]|trim');
        $this->form_validation->set_rules('degree', 'Degree', 'required');
        $this->form_validation->set_rules('alumni_number', 'Alumni Number', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required');

        // Conditional rule: if degree == Other, require degree_other
        // We'll add a callback that checks degree_other when degree is Other
        $this->form_validation->set_rules('degree_other', 'Other Degree', 'callback_check_degree_other');

        if ($this->form_validation->run() == FALSE) {
            // validation failed — reload the register view
            // make sure your register view uses set_value() to repopulate fields
            $this->load->view('user/register');
            return;
        }

        // Use XSS filtering when pulling POST values (second param TRUE)
        $degree = $this->input->post('degree', TRUE);
        $degree_other = $this->input->post('degree_other', TRUE);

        if ($degree === "Other") {
            $degree_input = trim($degree_other);
        } else {
            $degree_input = trim($degree);
        }

        $data = [
            'first_name'       => $this->input->post('first_name', TRUE),
            'last_name'        => $this->input->post('last_name', TRUE),
            'email'            => $this->input->post('email', TRUE),
            'password'         => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'phone'            => $this->input->post('phone', TRUE),
            'graduation_year'  => $this->input->post('graduation_year', TRUE),
            'student_number'   => $this->input->post('student_number', TRUE),
            'degree'           => $degree_input,
            'gender'           => $this->input->post('gender', TRUE),
            'status'           => 'inactive'
        ];

        $this->Alumni_model->insert($data);
        $this->session->set_flashdata('success_message', 'Registration successful! You may now login.');
        
        // Redirect to login or to a success page
        redirect('login');
    }

    // Callback for form_validation to check the degree_other when needed
    public function check_degree_other($str) {
        $degree = $this->input->post('degree', TRUE);
        if ($degree === "Other") {
            if (empty(trim($str))) {
                $this->form_validation->set_message('check_degree_other', 'Please specify your degree when selecting Other.');
                return FALSE;
            }
        }
        return TRUE;
    }

    // Optional: separate success page if you prefer
    public function success() {
        $this->load->view('user/register_success'); // create a small success view or message
    }
}
