<?php 
class AdminJobPosting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        // Add session library if 'admin_id' is used in create()
        $this->load->library('session'); 
    }

    public function index() {
        
        $this->load->view('__header');
        // Get all jobs with applicants count
        $data['jobs'] = $this->db->get('jobs')->result();
        $this->load->view('admin/job_posting', $data);

        $this->load->view('__footer');
    }

    // ... (view_applicants function remains the same) ...

    public function update($id) {
        // --- 1. Initialize $data with form inputs FIRST ---
        $data = [
            'job_title'       => $this->input->post('job_title'),
            'company'         => $this->input->post('company'),
            'description'     => $this->input->post('description'),
            'location'        => $this->input->post('location'),
            'salary_range'    => $this->input->post('salary_range'),
            'qualifications'  => $this->input->post('qualifications'),
            'contact_details' => $this->input->post('contact_details'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ];
        
        // --- 2. Check for the existing image filename to maintain it if no new file is uploaded ---
        $data['image_filename'] = $this->input->post('current_image_filename'); // Assuming you pass the existing filename via a hidden field

        // --- 3. Handle file upload (Only overwrites image_filename if a new file is uploaded) ---
        if (!empty($_FILES['image_filename']['name'])) {
            $config['upload_path'] = './assets/uploads/jobs/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            // Use a unique name to prevent collisions
            $config['file_name'] = uniqid('job_') . '_' . $_FILES['image_filename']['name']; 
    
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('image_filename')) {
                $uploadData = $this->upload->data();
                // Set the image_filename in the $data array
                $data['image_filename'] = $uploadData['file_name'];
                
                // Optional: Delete old file if a new one was uploaded and a current one existed
                // (You'd need to fetch the old filename from the DB first for safe deletion)
            } else {
                // Handle upload error if necessary, maybe set a flashdata message
                // log_message('error', $this->upload->display_errors());
                // redirect('AdminJobPosting', 'refresh'); 
            }
        }
    
        // --- 4. Database update ---
        $this->db->where('id', $id)->update('jobs', $data);
        redirect('AdminJobPosting');
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('jobs');
        redirect('AdminJobPosting');
    }

    public function create() {
        $config['upload_path'] = 'assets/uploads/jobs';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 7048;
    
        $this->load->library('upload', $config);
        $image_filename = '';
    
        if ($this->upload->do_upload('image_filename')) {
            $upload_data = $this->upload->data();
            $image_filename = $upload_data['file_name'];
        }
    
        $data = [
            'job_title'      => $this->input->post('job_title'),
            'company'        => $this->input->post('company'),
            'description'    => $this->input->post('description'),
            'location'       => $this->input->post('location'),
            'salary_range'   => $this->input->post('salary_range'),
            'qualifications' => $this->input->post('qualifications'),
            'contact_details'=> $this->input->post('contact_details'),
            'image_filename' => $image_filename,
            // FIX: Corrected the redundant '$this->'
            'posted_by'      => $this->session->userdata('admin_id') 
        ];
    
        $this->db->insert('jobs', $data);
        redirect('AdminJobPosting');
    }
}