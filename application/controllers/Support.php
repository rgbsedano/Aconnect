<?php
class Support extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->model('Support_model');
    $this->load->helper('url');
    $this->load->library('session');
}

public function index() {
    $user_id = $this->session->userdata('alumni_id');
    $data['messages'] = $this->Support_model->get_messages($user_id);
    
    $this->load->view('__header', $data);
    $this->load->view('user/chat_support', $data);
    $this->load->view('__footer');
}

public function send_message() {
    $sender_id = $this->session->userdata('alumni_id');
    $message = $this->input->post('message');

    $this->Support_model->send_message([
        'sender_id' => $sender_id,
        'receiver_id' => 1, // assuming 1 = admin
        'message' => $message,
        'is_admin' => 0
    ]);

    // Add auto-response from admin
    $this->Support_model->send_message([
        'sender_id' => 1,
        'receiver_id' => $sender_id,
        'message' => "Thanks for contacting support. We will get back to you shortly. If you want a faster reply email me instead in admin@gmail.com.",
        'is_admin' => 1
    ]);

    redirect('support');
}

// For admin to view and respond


public function admin_reply()
{
    $receiver_id = $this->input->post('receiver_id');
    $message = $this->input->post('message');

    $this->Support_model->send_message([
        'sender_id' => 1, // admin
        'receiver_id' => $receiver_id,
        'message' => $message,
        'is_admin' => 1
    ]);

    echo json_encode(['status' => 'success']);
}
public function admin_inbox() {
    $data['alumni_list'] = $this->Support_model->get_alumni_support_list();
   

    $this->load->view('__header', $data);
    $this->load->view('admin/support_inbox', $data);
    $this->load->view('__footer');
}
public function load_chat($user_id)
{
    $data['messages'] = $this->Support_model->get_messages($user_id);
    $data['user_id'] = $user_id;
    $this->load->view('admin/support_admin_view', $data); // only loads the inner chat
}
public function get_chat_json($user_id)
{
    $messages = $this->Support_model->get_messages($user_id);
    echo json_encode($messages);
}
public function get_chat_details($user_id)
{
    $this->load->model('Alumni_model');
    $alumni = $this->Alumni_model->get_by_id($user_id); // make sure this method exists

    $messages = $this->Support_model->get_chat_messages($user_id);

    $image = !empty($alumni->profile_image)
        ? base_url('assets/uploads/alumni/' . $alumni->profile_image)
        : base_url('assets/images/' . (strtolower($alumni->gender) === 'female' ? 'person-female.png' : 'person-male.png'));

    echo json_encode([
        'name' => ucwords($alumni->first_name . ' ' . $alumni->last_name),
        'image' => $image,
        'messages' => $messages
    ]);
}

}
