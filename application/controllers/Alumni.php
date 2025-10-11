<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumni extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/Alumni_model');

      
        // Assuming you have alumni_id stored in session after login
        if (!$this->session->userdata('alumni_id')) {
            redirect('login');
        }
    }


    public function index() {

        $this->load->view('__header');
		$current_user_id = $this->session->userdata('alumni_id');
        $search = $this->input->get('search');

        $data['alumni_list'] = $this->Alumni_model->search_alumni($current_user_id, $search);
        $this->load->view('user/search_alumni', $data);
		$this->load->view('__footer');

    }

    public function send_request() {
        $sender_id = $this->session->userdata('alumni_id');
        $receiver_id = $this->input->post('receiver_id');

        if (!$this->Alumni_model->connection_exists($sender_id, $receiver_id)) {
            $this->Alumni_model->send_connection_request($sender_id, $receiver_id);
        }

        redirect('alumni');
    }
    // View pending connection requests
    public function admin_alumni() {
        $data['alumni'] = $this->Alumni_model->get_all_alumni();
  
        $this->load->view('__header');
        $this->load->view('admin/alumni', $data);
		$this->load->view('__footer');
    }



}
