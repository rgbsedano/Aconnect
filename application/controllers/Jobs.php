<?php 
 
class Jobs extends CI_Controller{
 
	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy"){
			redirect(base_url("Login"));

            
		}
		$this->load->helper(['form', 'url', 'date']);
        $this->load->library('session');
        $this->load->library('upload');
		$this->load->model('user/Job_model');
	}
 
	function index(){
		$this->load->view('__header');


		$search = $this->input->get('search');
        $location= $this->input->get('location');
        $data['jobs'] = $this->Job_model->get_all_jobs($search,$location);

        $this->load->view('user/jobs', $data);


		
		$this->load->view('__footer');
	}

	public function apply($job_id) {
        $alumni_id = $this->session->userdata('alumni_id');
        $this->load->model('Activity_log_model');
        $this->Activity_log_model->log_activity($alumni_id, 'Applied for a job');
        if (!$alumni_id) {
            redirect('login');
        }

        // File Upload
        $config['upload_path'] = './assets/uploads/';
        
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['max_size'] = 7048;
       
        
        $this->load->library('upload', $config);

        // Initialize the Upload library with curront $config
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('attachment')) {
            echo "Error: " . $this->upload->display_errors();
        } else {
            $this->Job_model->apply_to_job($job_id, $alumni_id);
            redirect('jobs');
        }
    }
    

}