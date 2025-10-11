<?php

class AdminAlumni extends CI_Controller {

    public function index() {

        $this->load->view('__header');
        // Load necessary libraries and helpers
        $this->load->library('pagination');
        $this->load->model('user/Alumni_model');
    
        $search = $this->input->get('search');
        $limit = 10;
        $start = $this->input->get('per_page') ? $this->input->get('per_page') : 0;
    
        // Total alumni count
        $total_rows = $this->Alumni_model->get_alumni_count($search);
    
        // Pagination config
        $config['base_url'] = site_url('AdminAlumni') . ($search ? '?search=' . urlencode($search) : '');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'per_page';
    
        // Bootstrap 4 styling
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
    
        $this->pagination->initialize($config);
    
        // Fetch paginated results
        $data['alumni_list'] = $this->Alumni_model->get_alumni_paginated($limit, $start, $search);
        $data['pagination'] = $this->pagination->create_links();
    
        

        // Load the view
        $this->load->view('admin/alumni', $data);
        
        $this->load->view('__footer');
    }
    
    public function details() {
        $alumni_id = $this->input->post('id');
        $this->db->where('id', $alumni_id);
        $alumni = $this->db->get('alumni')->row_array();

        // Return full alumni details as HTML
        if ($alumni) {
            $details = '
                <p><strong>First Name:</strong> ' . $alumni['first_name'] . '</p>
                <p><strong>Last Name:</strong> ' . $alumni['last_name'] . '</p>
                <p><strong>Email:</strong> ' . $alumni['email'] . '</p>
                <p><strong>Phone:</strong> ' . $alumni['phone'] . '</p>
                <p><strong>Batch:</strong> ' . $alumni['graduation_year'] . '</p>
                <p><strong>Degree:</strong> ' . $alumni['degree'] . '</p>
                <p><strong>Status:</strong> ' . $alumni['status'] . '</p>
                <p><strong>Student Number:</strong> ' . $alumni['student_number'] . '</p>
            ';
            echo $details;
        }
    }
        public function list()
    {
        $data['alumni'] = $this->db->get('alumni')->result_array();
        $this->load->view('admin/alumni', $data);
    }


}
