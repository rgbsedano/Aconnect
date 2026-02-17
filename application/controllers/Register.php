<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/Alumni_model');
        $this->load->library('form_validation');
        $this->load->library('email'); 
    }

    public function index() {
        $this->load->view('user/register');
    }

    public function submit() {
        // Validation
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[alumni.email]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('student_number', 'Student Number', 'required|is_unique[alumni.student_number]|trim');
        $this->form_validation->set_rules('degree', 'Degree', 'required');
        $this->form_validation->set_rules('alternative_email', 'Alternate Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('degree_other', 'Other Degree', 'callback_check_degree_other');
        $this->form_validation->set_rules('graduation_year', 'Graduation Year', 'required|integer|trim');
        


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('user/register');
            return;
        }

        // Process degree
        $degree = $this->input->post('degree');
        $degree_value = ($degree === "Other") ? $this->input->post('degree_other') : $degree;

        // GENERATE VERIFICATION TOKEN
        $token = bin2hex(random_bytes(32));

        $data = [
            'first_name'       => $this->input->post('first_name'),
            'last_name'        => $this->input->post('last_name'),
            'email'            => $this->input->post('email'),
            'password'         => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'phone'            => $this->input->post('phone'),
            'telephone'       => $this->input->post('telephone'),
            'alternative_email' => $this->input->post('alternative_email'),
            'graduation_year'  => $this->input->post('graduation_year'),
            'student_number'   => $this->input->post('student_number'),
            'degree'           => $degree_value,
            'gender'           => $this->input->post('gender'),
            'status'           => 'inactive',
            'email_verified'   => 0,
            'verification_token' => $token
        ];

        // INSERT NEW USER
        $alumni_id = $this->Alumni_model->insert($data);

        // HANDLE PROFILE IMAGE UPLOAD
        if (!empty($_FILES['profile_image']['name'])) {
            $config['upload_path']   = './assets/uploads/alumni/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name']     = uniqid() . '_' . $_FILES['profile_image']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('profile_image')) {
                $uploadData = $this->upload->data();
                $data['profile_image'] = $uploadData['file_name'];
            }
        }

        // SEND VERIFICATION EMAIL
        $verify_link = base_url("register/verify_email?token=" . $token);

        $message = "
            <h2>Welcome to AConnect!</h2>
            <p>Click the link below to verify your email:</p>
            <a href='$verify_link' target='_blank'>$verify_link</a>
        ";

        $this->send_email($this->input->post('email'), "Verify Your AConnect Account", $message);

        $this->session->set_flashdata('success_message', 'Registration successful! Please verify your email before logging in.');
        redirect('login');
    }

    // VERIFY EMAIL FUNCTION
    public function verify_email() {
        $token = $this->input->get('token');

        $user = $this->db->get_where('alumni', ['verification_token' => $token])->row();

        if (!$user) {
            echo "Invalid or expired token.";
            return;
        }

        // Update user
        $this->db->where('id', $user->id)->update('alumni', [
            'email_verified' => 1,
            'status' => 'active',
            'verification_token' => NULL
        ]);

        $this->session->set_flashdata('success_message', 'Your email is now verified! You may now log in.');
        redirect('login');
    }

    // RESEND VERIFICATION EMAIL
    public function resend_verification() {
        $email = $this->input->post('email');

        $user = $this->db->get_where('alumni', ['email' => $email])->row();

        if (!$user) {
            $this->session->set_flashdata('error_message', "No account found with that email.");
            redirect('login');
            return;
        }

        if ($user->email_verified == 1) {
            $this->session->set_flashdata('success_message', "This account is already verified.");
            redirect('login');
            return;
        }

        // generate new token
        $token = bin2hex(random_bytes(32));
        $this->db->where('id', $user->id)->update('alumni', ['verification_token' => $token]);

        $verify_link = base_url("register/verify_email?token=" . $token);

        $message = "
            <h3>AConnect Email Verification</h3>
            <p>Click below to verify:</p>
            <a href='$verify_link'>$verify_link</a>
        ";

        $this->send_email($email, "AConnect Email Verification", $message);

        $this->session->set_flashdata('success_message', 'Verification email resent successfully!');
        redirect('login');
    }

    // SEND EMAIL FUNCTION
   private function send_email($to, $subject, $message) {
    // EDIT these with your SMTP provider (or use Mailtrap test credentials)
    $config = [
        'protocol'  => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 587,
        'smtp_user' => 'argiezxc@gmail.com',      // CHANGE
        'smtp_pass' => 'diaw dbve attk goka',        // CHANGE (use App Password for Gmail)
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'newline'   => "\r\n",
        'crlf'      => "\r\n",
        'smtp_crypto' => 'tls',
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

    // DEBUG: get detailed SMTP response & headers
    $debug = $this->email->print_debugger(array('headers'));

    // log the result and debugger to CodeIgniter log file (application/logs)
    log_message('info', 'Email send to: '.$to.' | result: '.($sent ? 'OK' : 'FAILED'));
    log_message('debug', $debug);

    // Also store last debug in session for quick viewing (optional)
    $this->session->set_flashdata('email_debug', $sent ? 'sent' : $debug);

    return $sent;
}


    public function check_degree_other($str) {
        if ($this->input->post('degree') === "Other" && empty(trim($str))) {
            $this->form_validation->set_message('check_degree_other', 'Please specify your degree.');
            return FALSE;
        }
        return TRUE;
    }
}
