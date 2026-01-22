<?php 
 
class EventsPrevious extends CI_Controller{
 
	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy"){
			redirect(base_url("Login"));
		}

		$this->load->model('user/Event_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'date', 'form'));
	}
 
    function index(){
		$this->load->view('__header');

		$alumni_id = $this->session->userdata('alumni_id');
		$data['events'] = $this->Event_model->get_all_events($alumni_id);
        $this->load->view('user/events_previous', $data);
		
		$this->load->view('__footer');
	}
}