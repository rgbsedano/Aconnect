<?php 
 
class Profile extends CI_Controller{
 
	function __construct(){
		parent::__construct();
		$this->load->model('user/Alumni_model');
        $this->load->model('Employment_model');
        $this->load->helper('text');   // <-- ADD THIS LINE

		if($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy"){
			redirect(base_url("Login"));
		}
	}
 
	function index(){
		$alumni_id = $this->session->userdata('alumni_id');
        if (!$alumni_id) {
            redirect('login');
        }
            $this->load->helper('text');  // <-- ADD THIS LINE

        $alumni = $this->Alumni_model->get_alumni_by_id($alumni_id);
        $employment = $this->Employment_model->get_by_alumni($alumni_id);

          $data = [
            'alumni'     => $alumni,
            'employment' => $employment
        ];

        $this->load->view('__header', $data);
		$this->load->view('user/profile', $data);
		$this->load->view('__footer');
	}

public function update($id) {
    $this->load->model('user/Alumni_model');

    // Basic validation (optional but recommended)
    $graduation_year = $this->input->post('graduation_year');
    $email           = $this->input->post('email');
    $alt_email       = $this->input->post('alternative_email');
    $phone           = $this->input->post('phone');
    $alt_phone       = $this->input->post('alternative_phone');


    /* // Check: Year admitted must be earlier than graduation year
    if ($year_admitted >= $graduation_year) {
        $this->session->set_flashdata('edit_error', 'Year admitted must be earlier than graduation year.');
        $this->session->set_flashdata('show_edit_modal', true);
        redirect('profile');
        return;
    } */

    // Check: Primary email and alternate email should not be the same
    if ($email === $alt_email) {
        $this->session->set_flashdata('edit_error', 'Alternate email must be different from your primary email.');
        $this->session->set_flashdata('show_edit_modal', true);
        redirect('profile');
        return;
    }

     if ($phone === $alt_phone) {
        $this->session->set_flashdata('edit_error', 'Alternate phone must be different from your primary phone.');
        $this->session->set_flashdata('show_edit_modal', true);
        redirect('profile');
        return;
    }

    // Prepare update data (NO alumni_number, NO student_number)
    $data = array(
        'first_name'        => $this->input->post('first_name'),
        'last_name'         => $this->input->post('last_name'),
        'phone'             => $phone,
        'alternative_phone' => $alt_phone,
        'email'             => $email,
        'alternative_email' => $alt_email,
        'graduation_year'   => $graduation_year,
        'degree'            => $this->input->post('degree'),
    );

    // Handle profile image upload
    if (!empty($_FILES['profile_image']['name'])) {
        $config['upload_path']   = './assets/uploads/alumni/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name']     = uniqid() . '_' . $_FILES['profile_image']['name'];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_image')) {
            $uploadData = $this->upload->data();
            $data['profile_image'] = $uploadData['file_name'];
        }
    }

    // Perform update
    $this->Alumni_model->update_alumni($id, $data);

    // Log activity
    $this->load->model('Activity_log_model');
    $this->Activity_log_model->log_activity($id, 'Updated his/her Profile');

    // Success message
    $this->session->set_flashdata('edit_success', 'Profile updated successfully.');
    $this->session->set_flashdata('show_edit_modal', true);
    redirect('profile');
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

    // Retrieve multi-select inputs (arrays or strings)
    $soft = $this->input->post('soft_skills');
    $tech = $this->input->post('technical_skills');

    // Convert arrays to comma-separated strings
    if (is_array($soft)) {
        $soft = implode(", ", $soft);
    }

    if (is_array($tech)) {
        $tech = implode(", ", $tech);
    }

    $data = [
        'soft_skills'      => $soft,
        'technical_skills' => $tech
    ];

    // Update database
    $this->Alumni_model->update_alumni($id, $data);

    // Success message
    $this->session->set_flashdata('success', 'Skills updated successfully.');
    redirect('profile');
}



}