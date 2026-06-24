<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracer extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'text']);
        $this->load->model('user/Alumni_model');
        $this->load->model('Tracer_model');

        if ($this->session->userdata('login_status') != 'AezakmiHesoyamWhosyourdaddy') {
            redirect(base_url('Login'));
        }
    }

    private function require_alumni_login() {
        if (! $this->session->userdata('alumni_id')) {
            redirect('login');
        }
    }

    public function index() {
        $this->require_alumni_login();

        $alumni_id = $this->session->userdata('alumni_id');
        $alumni = $this->Alumni_model->get_alumni_by_id($alumni_id);
        $response = $this->Tracer_model->get_by_alumni($alumni_id);

        $data = [
            'alumni' => $alumni,
            'response' => $response,
        ];

        $this->load->view('__header', $data);
        $this->load->view('user/tracer', $data);
        $this->load->view('__footer');
    }

    public function submit() {
        $this->require_alumni_login();

        $alumni_id = $this->session->userdata('alumni_id');
        $alumni = $this->Alumni_model->get_alumni_by_id($alumni_id);
        $ratings = $this->input->post('ratings');
        $waiting_time = $this->input->post('waiting_time');
        $competencies = $this->input->post('competencies');
        $allowed_waiting_times = [
            'Less than a month',
            'Less than a year',
            '1 year to less than 2 years',
            'more than 2 years',
        ];

        $this->form_validation->set_rules('waiting_time', 'Waiting Time', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('tracer_error', validation_errors('<div>', '</div>'));
            redirect('tracer');
            return;
        }

        if (! is_array($ratings) || count($ratings) < 4) {
            $this->session->set_flashdata('tracer_error', 'Please answer all contribution ratings before submitting.');
            redirect('tracer');
            return;
        }

        foreach ($ratings as $rating) {
            if (! in_array((int) $rating, [1, 2, 3, 4, 5], true)) {
                $this->session->set_flashdata('tracer_error', 'Please provide valid rating values.');
                redirect('tracer');
                return;
            }
        }

        if (! in_array($waiting_time, $allowed_waiting_times, true)) {
            $this->session->set_flashdata('tracer_error', 'Please select a valid waiting time option.');
            redirect('tracer');
            return;
        }

        $ratings = is_array($ratings) ? array_values($ratings) : [];
        $competencies = is_array($competencies) ? array_values($competencies) : [];

        $data = [
            'year_graduated' => (int) ($alumni->graduation_year ?? 0),
            'rating_1' => (int) ($ratings[0] ?? 0),
            'rating_2' => (int) ($ratings[1] ?? 0),
            'rating_3' => (int) ($ratings[2] ?? 0),
            'rating_4' => (int) ($ratings[3] ?? 0),
            'waiting_time' => $waiting_time,
            'competencies' => json_encode($competencies),
        ];

        if ($this->Tracer_model->save_for_alumni($alumni_id, $data)) {
            $this->session->set_flashdata('tracer_success', 'Tracer survey saved successfully.');
        } else {
            $this->session->set_flashdata('tracer_error', 'Failed to save tracer survey.');
        }

        redirect('tracer');
    }
}