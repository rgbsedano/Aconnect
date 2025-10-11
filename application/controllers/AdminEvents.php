<?php

class AdminEvents extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
}

public function index() {
    

    $this->load->view('__header');
    $data['events'] = $this->db->get('events')->result();
    $this->load->view('admin/manage_events', $data);

	$this->load->view('__footer');
}

public function update($id) {

    if (!empty($_FILES['image']['name'])) {
        $config['upload_path'] = './assets/uploads/events/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = uniqid() . '_' . $_FILES['image']['name'];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image')) {
            $uploadData = $this->upload->data();
            $data['image'] = $uploadData['file_name'];
        }
    }

    $data = [
        'event_name' => $this->input->post('event_name'),
        'event_date' => $this->input->post('event_date'),
        'location' => $this->input->post('location'),
        'event_time_duration'  => $this->input->post('event_time_duration'),
        'contact_person'  => $this->input->post('contact_person'),
        'description' => $this->input->post('description'),
        'updated_at' => date('Y-m-d H:i:s'),
        'image'        => $data['image'],
        'updated_by' => $this->session->set_userdata('admin_id')
    ];

    $this->db->where('id', $id)->update('events', $data);
    redirect('AdminEvents');
}

public function delete($id) {
    $this->db->where('id', $id)->delete('events');
    redirect('AdminEvents');
}

public function create() {
    if (!empty($_FILES['image']['name'])) {
        $config['upload_path'] = './assets/uploads/events/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = uniqid() . '_' . $_FILES['image']['name'];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image')) {
            $uploadData = $this->upload->data();
            $data['image'] = $uploadData['file_name'];
        }
    }

    $data = [
        'event_name'   => $this->input->post('event_name'),
        'event_date'   => $this->input->post('event_date'),
        'location'     => $this->input->post('location'),
        'event_time_duration'  => $this->input->post('event_time_duration'),
        'contact_person'  => $this->input->post('contact_person'),
        'description'  => $this->input->post('description'),
        'image'        => $data['image'],
        'created_by'   => $this->session->set_userdata('admin_id'),
    ];

    $this->db->insert('events', $data);
    redirect('AdminEvents');
}


}
