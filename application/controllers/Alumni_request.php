<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumni_request extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/Alumni_model');

        // Assuming you have alumni_id stored in session after login
        if (!$this->session->userdata('alumni_id')) {
            redirect('login');
        }
    }

    // View pending connection requests
    public function index() {

        $this->load->view('__header');
		$alumni_id = $this->session->userdata('alumni_id');
        $data['pending_requests'] = $this->Alumni_model->get_pending_requests($alumni_id);
        $this->load->view('user/pending_requests', $data);
		$this->load->view('__footer');

    }

    // Accept request
    public function accept_request($id) {
        $this->Alumni_model->accept_request($id);
        redirect('alumni_request');
    }

    // Decline request
    public function decline_request($id) {
        $this->Alumni_model->decline_request($id);
        redirect('alumni_request');
    }

}
