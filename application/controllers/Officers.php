<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Officers extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Officer_model');
        $this->load->helper(['url', 'text']);
    }

    // ===============================
    // ALUMNI VIEW — ACTIVE OFFICERS
    // ===============================
    public function index()
    {
        $data['officers'] = $this->Officer_model->get_active();

        $this->load->view('__header');
        $this->load->view('user/officers', $data);
        $this->load->view('__footer');
    }
}