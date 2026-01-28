<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/Alumni_model');

        // Assuming you have alumni_id stored in session after login
        if (!$this->session->userdata('alumni_id')) {
            redirect('login');
        }
    }


    public function index() {

        $this->load->view('__header');
		$user_id = $this->session->userdata('alumni_id');
        $data['connections'] = $this->Alumni_model->get_connections($user_id);
        $this->load->view('user/chat_list', $data);
		$this->load->view('__footer');

    }
    public function chat_with($friend_id) {
        $current_user = $this->session->userdata('alumni_id');

        if (!$this->Alumni_model->is_connected($current_user, $friend_id)) {
            show_error("You're not connected with this user.");
            return;
        }

        $data['friend_id'] = $friend_id;
        $data['messages'] = $this->Alumni_model->get_messages($current_user, $friend_id);
        $this->load->view('user/chat_list', $data);
    }

    // 📤 Send message to a friend
    public function send() {
        $sender = $this->session->userdata('alumni_id');
        $receiver = $this->input->post('receiver_id');
        $message = $this->input->post('message');
    
        $this->Alumni_model->send_message($sender, $receiver, $message);
    
        $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'success']));
    }
    
    public function get_messages_ajax($friend_id) {
        $current_user = $this->session->userdata('alumni_id');

        if (!$this->Alumni_model->is_connected($current_user, $friend_id)) {
            echo json_encode(['error' => "You're not connected with this user."]);
            return;
        }

        $messages = $this->Alumni_model->get_messages($current_user, $friend_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($messages));
    }

    public function get_connections() {
        $user_id = $this->session->userdata('alumni_id');
        $connections = $this->Alumni_model->get_connections($user_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($connections));
    }
}
