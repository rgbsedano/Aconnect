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

        $this->load->model('Activity_log_model');
        $this->Activity_log_model->log_activity($this->session->userdata('alumni_id'), 'Logged out');
        if($this->session->userdata('role') == "alumni" OR "Alumni"){

			$this->session->sess_destroy();
             redirect(base_url('login'));
        }
		
        if ($this->session->userdata('role') == "administrator" OR "Administrator"){

			$this->session->sess_destroy();
             redirect(base_url('adminlogin'));
        }
    }
}
