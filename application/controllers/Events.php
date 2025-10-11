<?php 
 
class Events extends CI_Controller{
 
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

		$data['events'] = $this->Event_model->get_all_events();
        $this->load->view('user/events', $data);
		
		$this->load->view('__footer');
	}
	
	public function register($event_id) {
        if (!$this->session->userdata('student_number')) {
            redirect('login'); // redirect if not logged in
        }
		$this->load->model('Activity_log_model');
        $this->Activity_log_model->log_activity($this->session->userdata('alumni_id'), 'Register to an event');

        $alumni_id = $this->Event_model->get_alumni_id_by_student_number($this->session->userdata('student_number'));

        if ($alumni_id) {
            $this->Event_model->register_to_event($event_id, $alumni_id);
            $this->session->set_flashdata('success', 'Successfully registered for the event.');
        }
        redirect('events');
    }
    function previous(){
		$this->load->view('__header');

		$data['events'] = $this->Event_model->get_all_events();
        $this->load->view('user/events_previous', $data);
		
		$this->load->view('__footer');
	}
}