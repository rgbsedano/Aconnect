<?php 
class AdminJobPosting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        

        $this->load->view('__header');
		// Get all jobs with applicants count
        $data['jobs'] = $this->db->get('jobs')->result();
        $this->load->view('admin/job_posting', $data);

		$this->load->view('__footer');
    }

    public function view_applicants($job_id) {
        $this->db->select('alumni.*');
        $this->db->from('job_applications');
        $this->db->join('alumni', 'alumni.id = job_applications.alumni_id');
        $this->db->where('job_applications.job_id', $job_id);
        $applicants = $this->db->get()->result();
        return $applicants;
    }

    public function update($id) {
        if (!empty($_FILES['image_filename']['name'])) {
            $config['upload_path'] = './assets/uploads/jobs/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = uniqid() . '_' . $_FILES['image_filename']['name'];
    
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image_filename')) {
                $uploadData = $this->upload->data();
                $data['image_filename'] = $uploadData['file_name'];
            }
        }
        $data = [
            'job_title' => $this->input->post('job_title'),
            'company' => $this->input->post('company'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location'),
            'salary_range' => $this->input->post('salary_range'),
            'qualifications' => $this->input->post('qualifications'),
            'contact_details' => $this->input->post('contact_details'),
            'image_filename' => $data['image_filename'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];

      
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
            'job_title'    => $this->input->post('job_title'),
            'company'      => $this->input->post('company'),
            'description'  => $this->input->post('description'),
            'location'     => $this->input->post('location'),
            'salary_range'     => $this->input->post('salary_range'),
            'qualifications'     => $this->input->post('qualifications'),
            'contact_details'     => $this->input->post('contact_details'),
            'image_filename' => $image_filename,
            'posted_by'    => $this-> $this->session->userdata('admin_id') // Replace with session admin ID if available
        ];
    
        $this->db->insert('jobs', $data);
        redirect('AdminJobPosting');
    }
    
}
