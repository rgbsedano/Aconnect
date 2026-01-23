<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumni_request extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/Alumni_model');

        if (!$this->session->userdata('alumni_id')) {
            redirect('login');
        }
    }

    public function index() {
        $alumni_id = $this->session->userdata('alumni_id');

        $data['alumni_id'] = $alumni_id;   // IMPORTANT
        $data['pending_requests'] = $this->Alumni_model->get_pending_requests($alumni_id);

        $this->load->view('__header');
        $this->load->view('user/pending_requests', $data);
        $this->load->view('__footer');
    }

    // Accept request (only receiver should use this)
    public function accept_request($id) {
        $this->Alumni_model->accept_request($id);
        redirect('alumni_request');
    }

    // Decline request (receiver rejects)
    public function decline_request($id) {
        $this->Alumni_model->decline_request($id);
        redirect('alumni_request');
    }

    // Cancel request (sender cancels his own pending request)
    public function cancel_request($id) {
        $this->db->where('id', $id);
        $this->db->where('status', 'pending');
        $this->db->delete('connection_requests');

        redirect('alumni_request');
    }
}

