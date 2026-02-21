<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminManageAccounts extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('user/Alumni_model');
        $this->load->helper(['url','form','text']);
        $this->load->library(['session','pagination']);
    }

    // ===============================
    // LIST ALL ALUMNI (ADMIN VIEW)
    // ===============================
    public function index()
    {
        $config['base_url']   = base_url('AdminManageAccounts/index');
        $config['total_rows'] = $this->Alumni_model->get_alumni_count();
        $config['per_page']   = 10;
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ?? 0;

        $data['alumni_list'] = $this->Alumni_model->get_alumni_paginated(
            $config['per_page'],
            $page
        );

        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('__header');
        $this->load->view('admin/manage_accounts', $data);
        $this->load->view('__footer');
    }

    // ===============================
    // AJAX SEARCH (MATCH OFFICERS)
    // ===============================
    public function search()
    {
        $keyword = trim($this->input->get('keyword'));

        $config['base_url']   = site_url('AdminManageAccounts/search');
        $config['total_rows'] = $this->Alumni_model->get_alumni_count($keyword);
        $config['per_page']   = 10;

        // ⭐ SAME STYLE AS OFFICERS
        $config['page_query_string']    = TRUE;
        $config['query_string_segment'] = 'per_page';
        $config['reuse_query_string']   = TRUE;

        $this->pagination->initialize($config);

        $page = $this->input->get('per_page');
        $page = ($page) ? $page : 0;

        $data['alumni_list'] = $this->Alumni_model->get_alumni_paginated(
            $config['per_page'],
            $page,
            $keyword
        );

        $data['pagination'] = $this->pagination->create_links();

        // ✅ FIXED PATH (your real folder)
        $this->load->view('admin/partials/alumni_table', $data);
    }

    // ===============================
    // UPDATE ALUMNI
    // ===============================
    public function update($id)
    {
        $degree = $this->input->post('degree');
        $degree_value = ($degree === "Other")
            ? $this->input->post('degree_other')
            : $degree;

        $data = [
            'first_name'        => $this->input->post('first_name'),
            'last_name'         => $this->input->post('last_name'),
            'email'             => $this->input->post('email'),
            'alternative_email' => $this->input->post('alternative_email'),
            'phone'             => $this->input->post('phone'),
            'telephone'         => $this->input->post('telephone'),
            'graduation_year'   => $this->input->post('graduation_year'),
            'student_number'    => $this->input->post('student_number'),
            'degree'            => $degree_value,
            'gender'            => $this->input->post('gender'),
        ];

        // optional password update
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // upload photo
        if (!empty($_FILES['profile_image']['name'])) {

            $config['upload_path']   = FCPATH . 'assets/uploads/alumni/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['encrypt_name']  = TRUE;
            $config['max_size']      = 5120;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('profile_image')) {
                $file = $this->upload->data();
                $data['profile_image'] = $file['file_name'];
            }
        }

        $this->Alumni_model->update_alumni($id, $data);

        $this->session->set_flashdata('success', 'Account updated successfully!');
        redirect('AdminManageAccounts');
    }

    // ===============================
    // DELETE ALUMNI (SECURE POST)
    // ===============================
    public function delete($id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        // cleanup dependencies
        $this->db->where('sender_id', $id)->delete('messages');
        $this->db->where('receiver_id', $id)->delete('messages');
        $this->db->where('sender_id', $id)->delete('connection_requests');
        $this->db->where('receiver_id', $id)->delete('connection_requests');
        $this->db->where('alumni_id', $id)->delete('job_applications');
        $this->db->where('alumni_id', $id)->delete('event_registrations');

        $this->db->where('id', $id)->delete('alumni');

        $this->session->set_flashdata('success', 'Account deleted successfully!');
        redirect('AdminManageAccounts');
    }

    // ===============================
    // AJAX: GET SINGLE ALUMNI
    // ===============================
    public function get_edit_data()
    {
        $id = $this->input->post('id');
        $alumni = $this->db->get_where('alumni', ['id' => $id])->row_array();

        header('Content-Type: application/json');
        echo json_encode($alumni);
    }

    // ===============================
    // DETAILS (keep your existing)
    // ===============================
    public function details()
    {
        $id = $this->input->post('id');

        if (!$id) {
            echo '<div class="alert alert-danger">Invalid alumni ID.</div>';
            return;
        }

        $alumni = $this->db
            ->where('id', $id)
            ->get('alumni')
            ->row_array();

        if (!$alumni) {
            echo '<div class="alert alert-warning">Alumni not found.</div>';
            return;
        }

        // load a small partial view for the modal body
        $this->load->view('admin/partials/alumni_view_modal', [
            'alumni' => $alumni
        ]);
    }
}