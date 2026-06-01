<?php

class AdminEvents extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->helper(['url', 'admin_pagination']);
}

public function index() {
    $results_per_page = 5;
    $page = (int) $this->input->get('page', TRUE);
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $results_per_page;

    $search = trim((string) $this->input->get('search', TRUE));
    $events_has_deleted_at = $this->db->field_exists('deleted_at', 'events');

    // COUNT(*) query
    $this->db->from('events');
    if ($events_has_deleted_at) {
        $this->db->where('deleted_at IS NULL', null, false);
    }
    if ($search !== '') {
        $this->db->group_start()
            ->like('event_name', $search)
            ->or_like('location', $search)
        ->group_end();
    }
    $total_records = (int) $this->db->count_all_results();
    $total_pages = (int) ceil($total_records / $results_per_page);
    if ($total_pages < 1) $total_pages = 1;
    if ($page > $total_pages) {
        $page = $total_pages;
        $offset = ($page - 1) * $results_per_page;
    }

    // Main fetch query with LIMIT/OFFSET
    $this->db->from('events');
    if ($events_has_deleted_at) {
        $this->db->where('deleted_at IS NULL', null, false);
    }
    if ($search !== '') {
        $this->db->group_start()
            ->like('event_name', $search)
            ->or_like('location', $search)
        ->group_end();
    }
    $data['events'] = $this->db
        ->order_by('event_date', 'DESC')
        ->limit($results_per_page, $offset)
        ->get()
        ->result();

    $data['pagination_links'] = admin_build_pagination_links(
        base_url('AdminEvents'),
        $search !== '' ? ['search' => $search] : [],
        $page,
        $total_pages
    );

    // ✅ FIX UPCOMING COUNT
    $now = date('Y-m-d H:i:s');

    $this->db->where('event_date >=', $now);
    if ($events_has_deleted_at) {
        $this->db->where('deleted_at IS NULL', null, false);
    }
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
    $this->db->where('id', $id)->update('events', ['deleted_at' => date('Y-m-d H:i:s')]);
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
