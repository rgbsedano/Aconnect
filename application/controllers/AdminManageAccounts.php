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


    public function details() {
        $alumni_id = $this->input->post('id');
        $this->db->where('id', $alumni_id);
        $alumni = $this->db->get('alumni')->row_array();

        if ($alumni) {
            $this->load->model('user/Alumni_model');
            $this->load->model('Employment_model');
            
            $employment = $this->Employment_model->get_by_alumni($alumni_id);
            $certifications = $this->Alumni_model->get_certifications($alumni_id);

            $details = '
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small text-uppercase font-weight-bold">Full Name</label>
                        <div class="bg-light p-3 rounded-lg border">' . htmlspecialchars($alumni['first_name'] . ' ' . $alumni['last_name']) . '</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small text-uppercase font-weight-bold">Student Number</label>
                        <div class="bg-light p-3 rounded-lg border">' . htmlspecialchars($alumni['student_number']) . '</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small text-uppercase font-weight-bold">Email</label>
                        <div class="bg-light p-3 rounded-lg border">' . htmlspecialchars($alumni['email']) . '</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small text-uppercase font-weight-bold">Phone</label>
                        <div class="bg-light p-3 rounded-lg border">' . htmlspecialchars($alumni['phone']) . '</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small text-uppercase font-weight-bold">Degree</label>
                        <div class="bg-light p-3 rounded-lg border">' . htmlspecialchars($alumni['degree']) . '</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small text-uppercase font-weight-bold">Batch</label>
                        <div class="bg-light p-3 rounded-lg border">' . htmlspecialchars($alumni['graduation_year']) . '</div>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3 font-weight-bold" style="color: #8B1538;"><i class="fas fa-shapes mr-2"></i> Areas of Expertise</h5>
                <div class="expertise-container mb-4">';
            
            $all_skills = array_merge(
                explode(',', $alumni['soft_skills'] ?? ""),
                explode(',', $alumni['technical_skills'] ?? "")
            );
            $all_skills = array_filter(array_unique(array_map('trim', $all_skills)));

            if (!empty($all_skills)) {
                foreach ($all_skills as $skill) {
                    $details .= '<span class="badge badge-light border p-2 mb-2 mr-2" style="font-size: 13px; font-weight: 500;">' . htmlspecialchars($skill) . '</span>';
                }
            } else {
                $details .= '<p class="text-muted italic small">No expertise areas listed.</p>';
            }

            $details .= '</div>

                <hr class="my-4">
                <h5 class="mb-3 font-weight-bold" style="color: #8B1538;"><i class="fas fa-briefcase mr-2"></i> Career Summary</h5>';

            if ($employment) {
                $details .= '
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small text-uppercase font-weight-bold">Status</label>
                            <div class="bg-light p-3 rounded-lg border">' . htmlspecialchars($employment['employment_status']) . '</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small text-uppercase font-weight-bold">Company</label>
                            <div class="bg-light p-3 rounded-lg border">' . htmlspecialchars($employment['company_name']) . '</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-muted small text-uppercase font-weight-bold">Job Title</label>
                            <div class="bg-light p-3 rounded-lg border font-weight-bold text-dark">' . htmlspecialchars($employment['job_title']) . '</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-muted small text-uppercase font-weight-bold">Professional Experience Summary</label>
                            <div class="bg-light p-3 rounded-lg border" style="line-height: 1.6;">' . nl2br(htmlspecialchars($employment['job_description'])) . '</div>
                        </div>
                    </div>';
            } else {
                $details .= '<div class="alert alert-info border-0 rounded-lg"><i class="fas fa-info-circle mr-2"></i> No active employment record found for this profile.</div>';
            }

            $details .= '
                <hr class="my-4">
                <h5 class="mb-3 font-weight-bold" style="color: #8B1538;"><i class="fas fa-certificate mr-2"></i> Professional Certifications</h5>';

            if (!empty($certifications)) {
                $details .= '<div class="row">';
                foreach ($certifications as $cert) {
                    $details .= '
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded-lg bg-white shadow-sm h-100">
                                <div class="font-weight-bold text-dark" style="font-size: 14px;">' . htmlspecialchars($cert->title) . '</div>
                                <div class="text-muted small">' . htmlspecialchars($cert->issuer) . '</div>
                                <div class="text-secondary small mt-1"><i class="fas fa-calendar-alt mr-1"></i> ' . htmlspecialchars($cert->date_issued) . '</div>
                            </div>
                        </div>';
                }
                $details .= '</div>';
            } else {
                $details .= '<p class="text-muted italic small">No professional certifications listed.</p>';
            }

            echo $details;
        }
    }
}
