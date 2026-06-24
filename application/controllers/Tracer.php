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
        $subjects = $this->input->post('subjects');
        $satisfaction = $this->input->post('satisfaction');
        $intent = $this->input->post('intent');
        $other_intent = $this->input->post('other_intent');
        $performance_ratings = $this->input->post('performance_ratings');
        $enrollment_year = $this->input->post('enrollment_year');
        $program = $this->input->post('program');
        $level = $this->input->post('level');
        $campus = $this->input->post('campus');
        $allowed_waiting_times = [
            'Less than a month',
            'Less than a year',
            '1 year to less than 2 years',
            'more than 2 years',
        ];

        $this->form_validation->set_rules('waiting_time', 'Waiting Time', 'required');
        $this->form_validation->set_rules('satisfaction', 'Satisfaction', 'required');
        $this->form_validation->set_rules('intent', 'Intent', 'required');

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

        // Validate performance ratings: expect one per statement
        $expected_perf = count([
            'I am able to complete my tasks in a professional manner.',
            'I am committed and dedicated to my work at all times.',
            'I use company resources to their maximum level with initiative & resourcefulness.',
            'I work harmoniously with my peers, co-employees and superiors.',
            'I report to work promptly and regularly.',
            'I join all company activities with enthusiasm.',
        ]);

        if (! is_array($performance_ratings) || count($performance_ratings) < $expected_perf) {
            $this->session->set_flashdata('tracer_error', 'Please complete all performance rating items.');
            redirect('tracer');
            return;
        }

        $ratings = is_array($ratings) ? array_values($ratings) : [];
        $competencies = is_array($competencies) ? array_values($competencies) : [];
        $subjects = is_array($subjects) ? array_values($subjects) : [];
        $performance_ratings = is_array($performance_ratings) ? array_values($performance_ratings) : [];

        $further_study = [
            'enrollment_year' => $enrollment_year,
            'program' => $program,
            'level' => $level,
            'campus' => $campus,
        ];

        $data = [
            'year_graduated' => (int) ($alumni->graduation_year ?? 0),
            'rating_1' => (int) ($ratings[0] ?? 0),
            'rating_2' => (int) ($ratings[1] ?? 0),
            'rating_3' => (int) ($ratings[2] ?? 0),
            'rating_4' => (int) ($ratings[3] ?? 0),
            'waiting_time' => $waiting_time,
            'competencies' => json_encode($competencies),
            'subjects' => json_encode($subjects),
            'satisfaction' => $satisfaction,
            'intent' => $intent,
            'other_intent' => $other_intent,
            'performance_ratings' => json_encode($performance_ratings),
            'further_study' => json_encode($further_study),
        ];

        if ($this->Tracer_model->save_for_alumni($alumni_id, $data)) {
            $this->session->set_flashdata('tracer_success', 'Tracer survey saved successfully.');
        } else {
            $this->session->set_flashdata('tracer_error', 'Failed to save tracer survey.');
        }

        redirect('tracer');
    }
}