<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
    function __construct() {
        parent::__construct();		
        $this->load->model('M_login');
        
    }

    public function index() {
        $this->load->view('login');
    }

public function user() {
    $student_number = $this->input->post('student_number');
    $password = $this->input->post('password');

    $user = $this->M_login->get_user_by_student_number($student_number);

    if (!$user) {
        $this->session->set_flashdata('error_message', 'Unregistered Student Number');
        redirect('login');
        return;
    }

    // check password
    if (!password_verify($password, $user->password)) {
        $this->session->set_flashdata('error_message', 'Invalid Password');
        redirect('login');
        return;
    }

    // check email verification
    if ($user->email_verified == 0) {
        $this->session->set_flashdata('error_message', 'Your email is not verified. Please check your inbox or resend verification.');
        redirect('login');
        return;
    }

    // login success
    $sess_data = [
        'alumni_id' => $user->id,
        'student_number' => $user->student_number,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'email' => $user->email,
        'login_status' => "AezakmiHesoyamWhosyourdaddy",
        'role' => 'alumni'
    ];

    $this->session->set_userdata($sess_data);

    redirect('dashboard');
}




public function logout() {

        // get alumni_id BEFORE destroying session
        $alumni_id = $this->session->userdata('alumni_id');
        $role      = $this->session->userdata('role');

        // Log activity ONLY if alumni_id exists
        if ($alumni_id) {
            $this->load->model('Activity_log_model');
            $this->Activity_log_model->log_activity($alumni_id, 'Logged out');
        }

        // Destroy session
        $this->session->sess_destroy();

        // Redirect based on role
        if ($role == "alumni" || $role == "Alumni") {
            redirect(base_url('login'));
        } 
        else if ($role == "administrator" || $role == "Administrator") {
            redirect(base_url('adminlogin'));
        } 
        else {
            // fallback (just in case)
            redirect(base_url('login'));
        }
    }

    public function forgot_password()
    {
        $this->load->view('forgot_password');
    }

    public function send_reset_link()
    {
        $email = $this->input->post('email');

        $user = $this->M_login->get_user_by_email($email);

        if (!$user) {
            $this->session->set_flashdata('error_message', 'Email not found.');
            redirect('login');
            return;
        }

        // generate secure token
        $token = bin2hex(random_bytes(32));

        // save token
        $this->M_login->save_reset_token($email, $token);

        // create reset link
        $reset_link = base_url('login/reset_password/'.$token);

        // send email
        $this->_send_reset_email($email, $reset_link);

        $this->session->set_flashdata('success_message', 'Password reset link sent to your email.');
        redirect('login');
    }

    private function _send_reset_email($email, $link)
    {
        $this->load->library('email');

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

        $this->email->initialize($config);
        $this->email->from('aconnect_admin@sdcaconnect.online', 'AConnect');
        $this->email->to($email);
        $this->email->subject('Reset Your Password');

        $message = "
            <p>Click the link below to reset your password:</p>
            <a href='$link'>$link</a>
        ";

        $this->email->message($message);
        $this->email->send();
    }

   public function reset_password($token)
    {
        $user = $this->M_login->get_user_by_token($token);

        if (!$user) {
            show_error('Invalid or expired reset link.');
        }

        // 🔥 token expiry (1 hour)
        if (strtotime($user->token_created_at) < time() - 3600) {
            show_error('Reset link has expired.');
        }

        $data['token'] = $token;
        $this->load->view('reset_password', $data);
    }
    public function update_password()
    {
        $token = $this->input->post('token');
        $password = $this->input->post('password');
        $confirm  = $this->input->post('confirm_password');

        // ✅ server-side check
        if ($password !== $confirm) {
            $this->session->set_flashdata('error_message', 'Passwords do not match.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $this->M_login->update_password_by_token($token, $hashed);

        $this->session->set_flashdata('success_message', 'Password updated successfully.');
        redirect('login');
    }

}
