<?php 
 
class Dashboard extends CI_Controller{
 
	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('role') == "alumni" OR "Alumni"){

			if($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy"){
				redirect(base_url("Login"));
			}
		}

		if($this->session->userdata('role') == "administrator" OR "Administrator"){

			if($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy"){
				redirect(base_url("adminlogin"));
			}
		}

		
	}
 
	function index(){
		$this->load->view('__header');
		if ($this->session->userdata('role') == "administrator") 
		
		{
			$this->load->view('dashboard_a');
		} else {
			$this->load->view('dashboard_u');
		}
		$this->load->view('__footer');
	}

	public function getPosts()
    {
        $graduationYear = $this->request->getGet('graduation_year');

        if (!$graduationYear) {
            return $this->respond(['error' => 'Graduation year is required'], 400);
        }

        $model = new PostModel();
        $posts = $model->where('recipient_batch', $graduationYear)->findAll();

        return $this->respond($posts);
    }



}