<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminLogin extends CI_Controller {
    
    function __construct() {
        parent::__construct();		
        $this->load->model('M_login');
        
    }

    public function index() {
        $this->load->view('admin/login');
    }


    public function Admin() {

        $this->load->view( 'admin/login');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Get user data based on student_number only
        $user = $this->M_login->get_admin_by_username($username);

        if ($user) {
            // Verify password hash
            if (password_verify($password, $user->password)) {

                $sess_data = array(
                    'admin_id'        => $user->id,
                    'username'         => $user->username,
                    'first_name'       => $user->first_name,
                    'last_name'        => $user->last_name,
                    'email'            => $user->email,
                    'login_status'     => "AezakmiHesoyamWhosyourdaddy", 
                    'role' => isset($user->role) ? $user->role : 'administrator'
                );
                $this->session->set_userdata($sess_data);
            
                redirect(base_url("AdminDashboard"));

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
		
			$this->session->sess_destroy();
             redirect(base_url('adminlogin'));
        
    }


}
