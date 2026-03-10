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

		$this->load->driver('cache');
	}
 
    function index(){
		$this->load->view('__header');

		$alumni_id = $this->session->userdata('alumni_id');

		$name = 'my_cached_item_'.$alumni_id.'_'.date('Ymd'); // Cache key with alumni ID and date for daily caching
		$getprevevent = $this->cache->file->get($name);


		if ($getprevevent === FALSE) {
	
			$data['events'] = $this->Event_model->get_all_events($alumni_id);
			$this->cache->file->save($name, $data['events'], 300); // Cache for 5 minutes
		} else {
			// Cache hit, use cached data
			$data['events'] = $getprevevent;
		}

		// $data['events'] = $this->Event_model->get_all_events($alumni_id);
        $this->load->view('user/events_previous', $data);
		
		$this->load->view('__footer');
	}
}