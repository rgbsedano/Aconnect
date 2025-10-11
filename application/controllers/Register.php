<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/Alumni_model');  // Load the Alumni model
        $this->load->library('form_validation');
    }

    // Show the registration form
    public function index() {
        $this->load->view('user/register');
    }

    // Handle the registration form submission
    public function submit() {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[alumni.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('student_number', 'Student Number', 'required|is_unique[alumni.student_number]');
        $this->form_validation->set_rules('degree', 'Degree', 'required');
        $this->form_validation->set_rules('alumni_number', 'Alumni_Number', 'required');

      

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('user/register');
        } else {
            $data = [
                'alumni_number' => $this->input->post('alumni_number'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'phone' => $this->input->post('phone'),
                'graduation_year' => $this->input->post('graduation_year'),
                'student_number' => $this->input->post('student_number'),
                'degree' => $this->input->post('degree'),
                'gender' => $this->input->post('gender'),
                'status' => 'inactive'
            ];

            $this->Alumni_model->insert($data);
            $this->session->set_flashdata('success_message', 'Registration successful! You will be redirected to login.');

            // Redirect to login page after 2 seconds
            redirect('register/success');
        }
    }

    // Show registration success page
    public function success() {
        // Load the registration page and show success modal
        $this->load->view('user/register');
    }
}
