<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Employer_Login Controller
 * Handles employer authentication and login
 */
class Employer_login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Employer_model');
    }

    /**
     * Display employer login form
     */
    public function index()
    {
        // Redirect if already logged in
        if ($this->session->userdata('login_status')) {
            redirect(base_url('dashboard'));
        }

        $this->load->view('employer/login');
    }

    /**
     * Process employer login
     */
    public function authenticate()
    {
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('employer_login');
        }

        // Set validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        // Validation failed
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('employer/login');
            return;
        }

        // Get form input
        $email = trim((string) $this->input->post('email', TRUE));
        $password = (string) $this->input->post('password');

        $employer = $this->Employer_model->get_employer_by_email($email);

        if ($employer) {
            $stored_password = (string) ($employer['password'] ?? '');

            if (!password_verify($password, $stored_password) && $password !== $stored_password) {
                $this->session->set_flashdata('error_message', 'Invalid email or password.');
                redirect('employer_login');
                return;
            }

            $approval_status = strtolower(trim((string) ($employer['approval_status'] ?? 'pending')));

            if ($approval_status === 'pending') {
                $this->session->set_flashdata('error_message', 'Your employer account is awaiting admin approval.');
                redirect('employer_login');
                return;
            }

            if ($approval_status === 'rejected') {
                $this->session->set_flashdata('error_message', 'Your employer account was rejected by the administrator.');
                redirect('employer_login');
                return;
            }

            if ((int) ($employer['is_active'] ?? 0) !== 1) {
                $this->session->set_flashdata('error_message', 'Your employer account is inactive. Please contact the administrator.');
                redirect('employer_login');
                return;
            }

            // Set session data
            $this->session->set_userdata([
                'login_status' => TRUE,
                'user_id' => $employer['id'],
                'email' => $employer['email'],
                'user_type' => 'employer',
                'role' => $employer['role'] ?? 'employer',
                'company_name' => $employer['company_name'] ?? '',
            ]);

            // Initialize employer groups cache
            $this->load->model('Rbac_model');
            $groups = $this->db->select('eg.id, eg.group_name, eg.description, eg.created_at')
                ->from('employer_groups eg')
                ->join('employer_group_assignments ega', 'eg.id = ega.group_id')
                ->where('ega.employer_id', $employer['id'])
                ->order_by('eg.created_at', 'DESC')
                ->get()
                ->result();
            
            $this->session->set_userdata([
                'employer_groups_' . $employer['id'] => $groups,
                'employer_groups_timestamp_' . $employer['id'] => time()
            ]);

            // Log session for debugging
            log_message('info', 'Employer logged in: ' . $employer['email'] . ' (ID: ' . $employer['id'] . ', Role: ' . ($employer['role'] ?? 'employer') . ')');

            // Set success message
            $this->session->set_flashdata('success_message', 'Welcome! You are now logged in.');
            
            // Redirect all employers to admin job posting page
            redirect(base_url('AdminJobPosting'), 'location');
            exit();
        } else {
            // Set error message
            $this->session->set_flashdata('error_message', 'Invalid email or password.');
            redirect('employer_login');
        }
    }

    /**
     * Logout employer
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
