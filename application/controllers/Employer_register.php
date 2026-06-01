<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Employer_Register Controller
 * Handles employer registration and account creation
 */
class Employer_register extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
    }

    /**
     * Display employer registration form
     */
    public function index()
    {
        // Redirect if already logged in
        if ($this->session->userdata('login_status')) {
            redirect(base_url('dashboard'));
        }

        $this->load->view('user/employer_register');
    }

    /**
     * Process employer registration form submission
     */
    public function submit()
    {
        // Redirect if not POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('employer_register');
        }

        // Set validation rules
        $this->form_validation->set_rules('company_name', 'Company Name', 'required|min_length[2]|max_length[150]');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[employers.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('hear_about_us', 'How did you hear about us', 'required');
        $this->form_validation->set_rules('country_code', 'Country Code', 'required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required|regex_match[/^[0-9\-\s\+\(\)\.]+$/]|min_length[7]|max_length[20]');

        // Validation failed
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('user/employer_register');
            return;
        }

        // Validation passed - prepare employer registration data
        $employer_data = [
            'company_name' => $this->input->post('company_name'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'phone' => $this->input->post('country_code') . ' ' . $this->input->post('phone_number'),
            'hear_about_us' => $this->input->post('hear_about_us'),
            'account_type' => 'employer',
            'created_at' => date('Y-m-d H:i:s'),
            'is_active' => 1, // Set to active for now
        ];

        // Save employer registration to database
        $result = $this->db->insert('employers', $employer_data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Registration successful! You can now login with your email and password.');
            redirect('employer_login');
        } else {
            $this->session->set_flashdata('error_message', 'An error occurred during registration. Please try again.');
            $this->load->view('user/employer_register');
        }
    }

    /**
     * Resend verification email for employer accounts
     */
    public function resend_verification()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('employer_login');
        }

        $email = $this->input->post('email');

        $employer = $this->db->get_where('employers', ['email' => $email])->row();

        if (!$employer) {
            $this->session->set_flashdata('error_message', 'No employer account found with that email.');
            redirect('employer_login');
            return;
        }

        // If already verified
        if (!empty($employer->email_verified_at)) {
            $this->session->set_flashdata('success_message', 'This account is already verified.');
            redirect('employer_login');
            return;
        }

        // Ensure verification_token column exists
        if (! $this->db->field_exists('verification_token', 'employers')) {
            $this->db->query("ALTER TABLE employers ADD COLUMN verification_token varchar(128) DEFAULT NULL");
        }

        if (! $this->db->field_exists('verification_sent_at', 'employers')) {
            $this->db->query("ALTER TABLE employers ADD COLUMN verification_sent_at datetime DEFAULT NULL");
        }

        $token = bin2hex(random_bytes(32));
        $this->db->where('id', $employer->id)->update('employers', [
            'verification_token' => $token,
            'verification_sent_at' => date('Y-m-d H:i:s')
        ]);

        $verify_link = base_url("employer_register/verify_email?token=" . $token);

        $message = "
            <h3>AConnect - Employer Email Verification</h3>
            <p>Click the link below to verify your employer account:</p>
            <a href='$verify_link' target='_blank'>$verify_link</a>
        ";

        $this->send_email($email, 'AConnect Employer Email Verification', $message);

        $this->session->set_flashdata('success_message', 'Verification email resent successfully!');
        redirect('employer_login');
    }

    /**
     * Verify employer email by token
     */
    public function verify_email()
    {
        $token = $this->input->get('token');

        if (empty($token)) {
            echo 'Invalid or missing token.';
            return;
        }

        $employer = $this->db->get_where('employers', ['verification_token' => $token])->row();

        if (! $employer) {
            echo 'Invalid or expired token.';
            return;
        }

        $this->db->where('id', $employer->id)->update('employers', [
            'email_verified_at' => date('Y-m-d H:i:s'),
            'is_active' => 1,
            'verification_token' => NULL,
            'verification_sent_at' => NULL
        ]);

        $this->session->set_flashdata('success_message', 'Your email is now verified! You may now log in.');
        redirect('employer_login');
    }

    /**
     * Internal helper to send email (simple SMTP setup)
     */
    private function send_email($to, $subject, $message)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => env_value('ACONNECT_SMTP_HOST', 'smtp.hostinger.com'),
            'smtp_port' => (int) env_value('ACONNECT_SMTP_PORT', 465),
            'smtp_user' => env_value('ACONNECT_SMTP_USER', 'aconnect_admin@sdcaconnect.online'),
            'smtp_pass' => env_value('ACONNECT_SMTP_PASS', ''),
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
            'crlf'      => "\r\n",
            'smtp_crypto' => env_value('ACONNECT_SMTP_CRYPTO', 'ssl'),
            'smtp_timeout' => 30,
            'wordwrap' => TRUE
        ];

        $this->email->clear(true);
        $this->email->initialize($config);
        $this->email->from($config['smtp_user'], 'AConnect Verification');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        $sent = $this->email->send();

        // store last debug in session (optional)
        $debug = $this->email->print_debugger(array('headers'));
        $this->session->set_flashdata('email_debug', $sent ? 'sent' : $debug);

        return $sent;
    }
}

