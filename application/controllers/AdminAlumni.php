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
            $this->load->model('Employment_model');
            $employment = $this->Employment_model->get_by_alumni($alumni_id);

            $details = '
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>First Name:</strong> ' . htmlspecialchars($alumni['first_name']) . '</p>
                        <p><strong>Last Name:</strong> ' . htmlspecialchars($alumni['last_name']) . '</p>
                        <p><strong>Email:</strong> ' . htmlspecialchars($alumni['email']) . '</p>
                        <p><strong>Phone:</strong> ' . htmlspecialchars($alumni['phone']) . '</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Batch:</strong> ' . htmlspecialchars($alumni['graduation_year']) . '</p>
                        <p><strong>Degree:</strong> ' . htmlspecialchars($alumni['degree']) . '</p>
                        <p><strong>Status:</strong> ' . htmlspecialchars($alumni['status']) . '</p>
                        <p><strong>Student Number:</strong> ' . htmlspecialchars($alumni['student_number']) . '</p>
                    </div>
                </div>
                <hr>
                <h5>Employment Record</h5>';

            if ($employment) {
                $details .= '
                    <p><strong>Employment Status:</strong> ' . htmlspecialchars($employment['employment_status']) . '</p>
                    <p><strong>Company:</strong> ' . htmlspecialchars($employment['company_name']) . '</p>
                    <p><strong>Job Title:</strong> ' . htmlspecialchars($employment['job_title']) . '</p>
                    <p><strong>Job Description:</strong> ' . nl2br(htmlspecialchars($employment['job_description'])) . '</p>
                    <p><strong>Years of Service:</strong> ' . (int)$employment['year_of_service'] . '</p>
                    <p><strong>Promotions:</strong> ' . (int)$employment['promotion_count'] . '</p>';
            } else {
                $details .= '<p class="text-muted">No employment record found.</p>';
            }
            
            echo $details;
        }
    }
        public function list()
    {
        $data['alumni'] = $this->db->get('alumni')->result_array();
        $this->load->view('admin/alumni', $data);
    }


}
