<?php
class AdminManageAccounts extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
}

public function index() {
	$this->load->view('__header');
    $data['alumni_list'] = $this->db->get('alumni')->result();
    $this->load->view('admin/manage_accounts', $data);
	$this->load->view('__footer');
}

public function update($id) {
    $data = [
        'first_name' => $this->input->post('first_name'),
        'last_name' => $this->input->post('last_name'),
        'status' => $this->input->post('status'),
    ];
    $this->db->where('id', $id)->update('alumni', $data);
    redirect('AdminManageAccounts');
}

public function delete($id) {
    $this->db->where('id', $id)->delete('alumni');
    redirect('AdminManageAccounts');
}

}
