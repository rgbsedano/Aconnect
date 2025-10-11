<?php 
 
class AdminDashboard extends CI_Controller{
 
	function __construct(){
		parent::__construct();
	

		if($this->session->userdata('role') == "administrator" OR "Administrator"){

			if($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy"){
				redirect(base_url("adminlogin"));
			}
		}

	}
 
	function index(){
		$data = [];

        $query = $this->db->query("SELECT COUNT(*) AS total FROM alumni");
        $data['total_users'] = $query->row()->total;

        $query = $this->db->query("SELECT COUNT(*) AS active FROM alumni WHERE status = 'active'");
        $data['active_users'] = $query->row()->active;

        $data['inactive_users'] = $data['total_users'] - $data['active_users'];

        $data['total_alumni'] = $this->db->query("SELECT COUNT(*) AS total_alumni FROM alumni")->row()->total_alumni;
        $data['total_accounts'] = $this->db->query("SELECT COUNT(*) AS total_active_users FROM alumni WHERE status = 'active'")->row()->total_active_users;
        $data['total_jobs'] = $this->db->query("SELECT COUNT(*) AS total_job_post FROM jobs")->row()->total_job_post;
        $data['total_events'] = $this->db->query("SELECT COUNT(*) AS total_events FROM events")->row()->total_events;
        $data['total_post'] = $this->db->query("SELECT COUNT(*) AS total_post FROM post")->row()->total_post;

		$this->load->view('__header');
		$this->load->view('dashboard_a', $data);

		$this->load->view('__footer');
	}


}