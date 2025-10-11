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
        $this->load->view('login');
        $student_number = $this->input->post('student_number');
        $password = $this->input->post('password');

        // Get user data based on student_number only
        $user = $this->M_login->get_user_by_student_number($student_number);

        if ($user) {
            // Verify password hash
            if (password_verify($password, $user->password)) {

                $sess_data = array(
                    'alumni_id'        => $user->id,
                    'student_number'   => $user->student_number,
                    'first_name'       => $user->first_name,
                    'last_name'        => $user->last_name,
                    'email'            => $user->email,
                    'phone'            => $user->phone,
                    'graduation_year'  => $user->graduation_year,
                    'degree'           => $user->degree,
                    'profile_image'    => $user->profile_image,
                    'status'           => $user->status,
                    'alumni_number'    => $user->alumni_number,
                    'login_status'     => "AezakmiHesoyamWhosyourdaddy", 
                    'role' => isset($user->role) ? $user->role : 'alumni'
                );
                $this->session->set_userdata($sess_data);

                // Update last login timestamp
                $this->db->where('id', $user->id);
                $this->db->update('alumni', ['last_login' => date('Y-m-d H:i:s')]);

                $this->load->model('Activity_log_model');
                $this->Activity_log_model->log_activity($user->id, 'Logged in');

                redirect(base_url("dashboard"));

            } else {
                // Wrong password
                echo "<script type='text/javascript'>alert('Invalid password');window.location = './';</script>";
            }
        } else {
            // Student number not found
            echo "<script type='text/javascript'>alert('Unregistered Student Number');window.location = './';</script>";
        }
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
