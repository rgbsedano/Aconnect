<?php

class AdminEvents extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
}

public function index() {
    
    $data['events'] = $this->db->get('events')->result();

    // ✅ FIX UPCOMING COUNT
    $now = date('Y-m-d H:i:s');

    $this->db->where('event_date >=', $now);
    $data['upcoming_count'] = $this->db->count_all_results('events');

    // optional reach fallback
    $data['total_participants_all'] = 0;

    $this->load->view('__header');
    $this->load->view('admin/manage_events', $data);
    $this->load->view('__footer');
}

public function update($id) {

    $data = [
        'event_name' => $this->input->post('event_name'),
        'event_date' => $this->input->post('event_date'),
        'location' => $this->input->post('location'),
        'event_time_duration'  => $this->input->post('event_time_duration'),
        'contact_person'  => $this->input->post('contact_person'),
        'description' => $this->input->post('description'),
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $this->session->userdata('admin_id')
    ];

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

    $this->db->where('id', $id)->update('events', $data);
    $this->session->set_flashdata('success', 'Event updated successfully.');
    redirect('AdminEvents');
}

public function delete($id) {
    $this->db->where('id', $id)->delete('events');
    $this->session->set_flashdata('success', 'Event deleted successfully.');
    redirect('AdminEvents');
}

public function create() {
    $data = [
        'event_name'   => $this->input->post('event_name'),
        'event_date'   => $this->input->post('event_date'),
        'location'     => $this->input->post('location'),
        'event_time_duration'  => $this->input->post('event_time_duration'),
        'contact_person'  => $this->input->post('contact_person'),
        'description'  => $this->input->post('description'),
        'created_by'   => $this->session->userdata('admin_id'),
        'created_at'   => date('Y-m-d H:i:s')
    ];

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

    $this->db->insert('events', $data);

    $this->session->set_flashdata('success', 'Event created successfully.');

    redirect('AdminEvents');
}


}
