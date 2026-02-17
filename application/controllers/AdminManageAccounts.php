<?php
class AdminManageAccounts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('pagination');
    }

    public function index() {

        // PAGINATION CONFIG
        $config['base_url'] = base_url('AdminManageAccounts/index');
        $config['total_rows'] = $this->db->count_all('alumni');
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;

        // BOOTSTRAP STYLING
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        // CURRENT PAGE
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // FETCH LIMIT RESULTS
        $this->db->limit($config['per_page'], $page);
        $data['alumni_list'] = $this->db->get('alumni')->result();

        // SEND PAGINATION HTML TO VIEW
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('__header');
        $this->load->view('admin/manage_accounts', $data);
        $this->load->view('__footer');
    }

    public function update($id) {
    $data = [
        'first_name' => $this->input->post('first_name'),
        'last_name' => $this->input->post('last_name'),
        'phone' => $this->input->post('phone'),
        'graduation_year' => $this->input->post('graduation_year'),
        'student_number' => $this->input->post('student_number'),
        'status' => $this->input->post('status'),
    ];

    $this->db->where('id', $id)->update('alumni', $data);

    $this->session->set_flashdata('success', 'Account updated successfully!');
    redirect('AdminManageAccounts');
}


    public function delete($id) {

    // delete dependencies first (safe)
    $this->db->where('sender_id', $id)->delete('connection_requests');
    $this->db->where('receiver_id', $id)->delete('connection_requests');
    $this->db->where('alumni_id', $id)->delete('job_applications');
    $this->db->where('alumni_id', $id)->delete('event_registrations');

    $this->db->where('id', $id)->delete('alumni');

    $this->session->set_flashdata('success', 'Account deleted successfully!');
    redirect('AdminManageAccounts');
}


}
