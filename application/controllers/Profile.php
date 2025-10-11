<?php 
 
class Profile extends CI_Controller{
 
	function __construct(){
		parent::__construct();
		$this->load->model('user/Alumni_model');
		if($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy"){
			redirect(base_url("Login"));
		}
	}
 
	function index(){
		$alumni_id = $this->session->userdata('alumni_id');
        if (!$alumni_id) {
            redirect('login');
        }

        $data['alumni'] = $this->Alumni_model->get_alumni_by_id($alumni_id);

        $this->load->view('__header', $data);
		$this->load->view('user/profile', $data);
		$this->load->view('__footer');
	}

public function update($id) {
    $this->load->model('user/Alumni_model');

    $alumni_number = $this->input->post('alumni_number');

    // Check for duplicate alumni_number (excluding current user)
    $this->db->where('alumni_number', $alumni_number);
    $this->db->where('id !=', $id);
    $query = $this->db->get('alumni');

    if ($query->num_rows() > 0) {
        // ERROR: duplicate alumni number
        $this->session->set_flashdata('edit_error', 'The Alumni Number you entered is already in use.');
        $this->session->set_flashdata('show_edit_modal', true);
        redirect('profile');
        return;
    } else {
        // Continue with update
        $data = array(
            'alumni_number' => $alumni_number,
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'phone' => $this->input->post('phone'),
            'graduation_year' => $this->input->post('graduation_year'),
            'degree' => $this->input->post('degree'),
        );

        // Handle file upload
        if (!empty($_FILES['profile_image']['name'])) {
            $config['upload_path'] = './assets/uploads/alumni/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = uniqid() . '_' . $_FILES['profile_image']['name'];

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('profile_image')) {
                $uploadData = $this->upload->data();
                $data['profile_image'] = $uploadData['file_name'];
            }
        }

        // Perform update
        $this->Alumni_model->update_alumni($id, $data);
        $this->load->model('Activity_log_model');
        $this->Activity_log_model->log_activity($id, 'Updated his/her Profile');

        // SUCCESS: set flash message and show modal
        $this->session->set_flashdata('edit_success', 'Profile updated successfully.');
        $this->session->set_flashdata('show_edit_modal', true);
        redirect('profile');
    }
}

public function update_job_info($id)
{
    $this->load->model('user/Alumni_model');
    $data = [
        'current_job' => $this->input->post('current_job'),
        'current_job_organization' => $this->input->post('current_job_organization'),
        'current_job_length' => $this->input->post('current_job_length')
    ];

    $this->Alumni_model->update_alumni($id, $data);

    $this->session->set_flashdata('success', 'Job information updated successfully.');
    redirect('profile'); // Adjust this as per your route
}
public function update_skill_info($id)
{
    $this->load->model('user/Alumni_model');
    $data = [
        'soft_skills' => $this->input->post('soft_skills'),
        'technical_skills' => $this->input->post('technical_skills'),
        
    ];

    $this->Alumni_model->update_alumni($id, $data);

    $this->session->set_flashdata('success', 'Job information updated successfully.');
    redirect('profile'); // Adjust this as per your route
}


}