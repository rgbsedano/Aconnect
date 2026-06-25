<?php
class AdminJobPosting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Rbac_model');
        $this->load->model('user/Alumni_model');
        $this->load->model('Standing_model');
        $this->load->helper(['url', 'admin_pagination', 'standing']);
        
        // Authentication: Check if user is logged in as admin or employer
        $user_type = $this->session->userdata('user_type');
        
        if ($user_type === 'employer') {
            // Employer authentication
            if ($this->session->userdata('login_status') !== TRUE) {
                redirect(base_url('employer_login'));
            }
        } else {
            // Admin authentication
            if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
                redirect(base_url("adminlogin"));
            }
            
            if ($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy") {
                redirect(base_url("adminlogin"));
            }
        }
    }

    /**
     * Check if employer can view a page
     * Returns TRUE if visible, FALSE if restricted
     */
    private function check_page_access($page_slug)
    {
        $user_type = $this->session->userdata('user_type');
        
        // Admins always have access
        if ($user_type !== 'employer') {
            return TRUE;
        }
        
        // Get employer role ID
        $employer_role = $this->Rbac_model->get_role_by_name('employer');
        if (!$employer_role) {
            return FALSE;
        }
        
        // Check if page is visible for employer role
        $is_visible = $this->Rbac_model->is_page_visible($page_slug, $employer_role->role_id);
        
        if (!$is_visible) {
            log_message('warning', 'Employer ' . $this->session->userdata('email') . ' attempted to access restricted page: ' . $page_slug);
            return FALSE;  // Return FALSE instead of redirecting (prevents redirect loop)
        }
        
        return TRUE;
    }
    
    /**
     * Show access denied page
     */
    private function show_access_denied()
    {
        $this->load->view('__header');
        $data['error'] = 'You do not have access to this page.';
        $this->load->view('admin/access_denied', $data);
        $this->load->view('__footer');
    }

    public function index() {
        // Check if employer has access to job posting page
        if ($this->session->userdata('user_type') === 'employer') {
            if (!$this->check_page_access('job_posting')) {
                $this->show_access_denied();
                return;
            }
        }

        $this->load->view('__header');

        $results_per_page = 5;
        $page = (int) $this->input->get('page', TRUE);
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $results_per_page;

        $search = trim((string) $this->input->get('search', TRUE));
        $jobs_has_deleted_at = $this->db->field_exists('deleted_at', 'jobs');

        // COUNT(*) query
        $this->db->from('jobs');
        if ($this->session->userdata('user_type') === 'employer') {
            $employer_id = (int) $this->session->userdata('user_id');
            $this->db->where('employer_id', $employer_id);
        }
        if ($jobs_has_deleted_at) {
            $this->db->where('deleted_at IS NULL', null, false);
        }
        if ($search !== '') {
            $this->db->group_start()
                ->like('job_title', $search)
                ->or_like('company', $search)
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
        $this->db->from('jobs');
        if ($this->session->userdata('user_type') === 'employer') {
            $employer_id = (int) $this->session->userdata('user_id');
            $this->db->where('employer_id', $employer_id);
        }
        if ($jobs_has_deleted_at) {
            $this->db->where('deleted_at IS NULL', null, false);
        }
        if ($search !== '') {
            $this->db->group_start()
                ->like('job_title', $search)
                ->or_like('company', $search)
            ->group_end();
        }

        $data['jobs'] = $this->db
            ->order_by('id', 'DESC')
            ->limit($results_per_page, $offset)
            ->get()
            ->result();

        $params = [];
        if ($search !== '') $params['search'] = $search;
        $data['pagination_links'] = admin_build_pagination_links(base_url('AdminJobPosting'), $params, $page, $total_pages);
        $data['is_employer'] = $this->session->userdata('user_type') === 'employer';

        // Get employer company name if logged in as employer
        $data['employer_company_name'] = '';
        if ($this->session->userdata('user_type') === 'employer') {
            $employer_id = $this->session->userdata('user_id');
            $employer = $this->db->select('company_name')
                ->from('employers')
                ->where('id', $employer_id)
                ->get()
                ->row();
            $data['employer_company_name'] = $employer ? $employer->company_name : '';
        }

        $this->load->view('admin/job_posting', $data);
        $this->load->view('__footer');
    }

    /** VIEW APPLICANTS */
    public function view_applicants($job_id) {
        $this->db->select('alumni.*');
        $this->db->from('job_applications');
        $this->db->join('alumni', 'alumni.id = job_applications.alumni_id');
        $this->db->where('job_applications.job_id', $job_id);
        return $this->db->get()->result();
    }

    /** GET APPLICANT MATCH BREAKDOWN */
    public function applicant_match_breakdown($job_id, $alumni_id)
    {
        $this->output->set_content_type('application/json');

        $job_id = (int) $job_id;
        $alumni_id = (int) $alumni_id;

        if ($job_id < 1 || $alumni_id < 1) {
            $this->output->set_output(json_encode([
                'error' => 'Invalid applicant or job identifier.'
            ]));
            return;
        }

        $this->db->from('job_applications');
        $this->db->where('job_id', $job_id);
        $this->db->where('alumni_id', $alumni_id);
        $application = $this->db->get()->row();

        if (!$application) {
            $this->output->set_output(json_encode([
                'error' => 'No application record exists for this applicant and job.'
            ]));
            return;
        }

        $job_query = $this->db->where('id', $job_id);
        if ($this->session->userdata('user_type') === 'employer') {
            $job_query->where('employer_id', $this->session->userdata('user_id'));
        }
        $job = $job_query->get('jobs')->row();

        $alumni = $this->db->where('id', $alumni_id)->get('alumni')->row();

        if (!$job || !$alumni) {
            $this->output->set_output(json_encode([
                'error' => 'Applicant profile or job posting not found.'
            ]));
            return;
        }

        $employment = null;
        if ($this->db->table_exists('employment')) {
            $this->load->model('Employment_model');
            $employment = $this->Employment_model->get_by_alumni($alumni_id);
        }

        $certifications = [];
        if ($this->db->table_exists('certifications')) {
            $certifications = $this->Alumni_model->get_certifications($alumni_id);
        }

        $standing_result = $this->Standing_model->get_standing_score_debug($alumni_id);
        $standing_score = isset($standing_result['score']) ? (int) $standing_result['score'] : 0;
        $standing_badge = get_standing_badge($standing_score);

        $match = compute_ai_match($alumni, $job);
        $insight = get_detailed_match_insight($match, $alumni, $job);

        if (!is_array($insight)) {
            $insight = [];
        }

        $gender = strtolower(trim((string) ($alumni->gender ?? '')));
        $profile_image = !empty($alumni->profile_image)
            ? base_url('assets/uploads/alumni/' . $alumni->profile_image)
            : base_url('assets/images/' . ($gender === 'female' ? 'person-female.png' : 'person-male.png'));

        $payload = [
            'applicant' => [
                'id' => (int) $alumni->id,
                'full_name' => trim((string) ($alumni->first_name . ' ' . $alumni->last_name)),
                'email' => (string) ($alumni->email ?? ''),
                'alternative_email' => (string) ($alumni->alternative_email ?? ''),
                'phone' => (string) ($alumni->phone ?? ''),
                'graduation_year' => (string) ($alumni->graduation_year ?? ''),
                'degree' => (string) ($alumni->degree ?? ''),
                'school' => (string) ($alumni->school ?? ''),
                'student_number' => (string) ($alumni->student_number ?? ''),
                'current_job' => (string) ($alumni->current_job ?? ''),
                'current_job_organization' => (string) ($alumni->current_job_organization ?? ''),
                'current_job_length' => (string) ($alumni->current_job_length ?? ''),
                'technical_skills' => (string) ($alumni->technical_skills ?? ''),
                'soft_skills' => (string) ($alumni->soft_skills ?? ''),
                'status' => (string) ($alumni->status ?? ''),
                'cover_photo' => !empty($alumni->cover_photo) ? base_url('assets/uploads/alumni/' . $alumni->cover_photo) : '',
                'profile_image' => $profile_image,
                'standing_score' => $standing_score,
                'standing_badge' => $standing_badge,
                'applied_at' => isset($application->applied_at) ? date('M d, Y', strtotime($application->applied_at)) : 'Unknown',
                'certifications' => array_map(function ($cert) {
                    return [
                        'title' => (string) ($cert->title ?? ''),
                        'issuer' => (string) ($cert->issuer ?? ''),
                        'date_issued' => (string) ($cert->date_issued ?? ''),
                        'certificate_image' => !empty($cert->certificate_image) ? base_url('assets/uploads/alumni/' . $cert->certificate_image) : ''
                    ];
                }, is_array($certifications) ? $certifications : []),
                'employment' => $employment ? [
                    'employment_status' => (string) ($employment['employment_status'] ?? ''),
                    'company_name' => (string) ($employment['company_name'] ?? ''),
                    'job_title' => (string) ($employment['job_title'] ?? ''),
                    'year_of_service' => (int) ($employment['year_of_service'] ?? 0),
                    'promotion_count' => (int) ($employment['promotion_count'] ?? 0)
                ] : null,
            ],
            'job' => [
                'id' => (int) $job->id,
                'job_title' => (string) ($job->job_title ?? ''),
                'company' => (string) ($job->company ?? ''),
                'location' => (string) ($job->location ?? ''),
                'salary_range' => (string) ($job->salary_range ?? ''),
                'qualifications' => (string) ($job->qualifications ?? ''),
                'description' => (string) ($job->description ?? '')
            ],
            'match' => [
                'percentage' => (int) $match,
                'status' => isset($insight['status']) ? $insight['status'] : 'Analysis',
                'summary' => isset($insight['summary']) ? $insight['summary'] : '',
                'strengths' => isset($insight['strengths']) && is_array($insight['strengths']) ? $insight['strengths'] : [],
                'gaps' => isset($insight['gaps']) && is_array($insight['gaps']) ? $insight['gaps'] : [],
                'explanation_bullets' => isset($insight['explanation_bullets']) ? $insight['explanation_bullets'] : '',
                'ai_powered' => isset($insight['ai_powered']) ? (bool) $insight['ai_powered'] : true,
                'cached' => isset($insight['cached']) ? (bool) $insight['cached'] : false
            ]
        ];

        $this->output->set_output(json_encode($payload));
    }

    /** SEND APPLICANT EMAIL */
    public function send_applicant_email()
    {
        $this->output->set_content_type('application/json');

        if ($this->input->method(TRUE) !== 'POST') {
            $this->output->set_status_header(405);
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Invalid request method.'
            ]));
            return;
        }

        $applicant_id = (int) $this->input->post('applicant_id');
        $job_id = (int) $this->input->post('job_id');
        $status = strtolower(trim((string) $this->input->post('status')));

        if ($applicant_id < 1 || !in_array($status, ['accepted', 'rejected'], true)) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Invalid applicant or status.'
            ]));
            return;
        }

        $alumni = $this->db->select('id, first_name, last_name, email')
            ->from('alumni')
            ->where('id', $applicant_id)
            ->get()
            ->row();

        if (!$alumni || empty($alumni->email)) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Applicant email not found.'
            ]));
            return;
        }

        $job = null;
        if ($job_id > 0) {
            $job_query = $this->db->select('id, job_title, company')
                ->from('jobs')
                ->where('id', $job_id);

            if ($this->session->userdata('user_type') === 'employer') {
                $job_query->where('employer_id', $this->session->userdata('user_id'));
            }

            $job = $job_query->get()->row();
        }

        $full_name = trim((string) ($alumni->first_name . ' ' . $alumni->last_name));
        $job_title = $job ? (string) $job->job_title : 'the position you applied for';
        $company = $job ? (string) $job->company : 'Aconnect';

        $greeting = '<p style="margin:0 0 16px 0; font-size:16px;">Hi <strong>' . htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8') . '</strong>,</p>';

        if ($status === 'accepted') {
            $subject = 'Congratulations - Your Application Was Accepted';
            $body = '<div style="font-family:Arial,sans-serif; color:#333; line-height:1.6; font-size:15px;">'
                . $greeting
                . '<p style="margin:0 0 16px 0;">Thank you for applying for the <strong>' . htmlspecialchars($job_title, ENT_QUOTES, 'UTF-8') . '</strong> position at <strong>' . htmlspecialchars($company, ENT_QUOTES, 'UTF-8') . '</strong>.</p>'
                . '<p style="margin:0 0 16px 0;">We are pleased to inform you that your application has been reviewed positively. Our team will contact you soon with the next steps.</p>'
                . '<p style="margin:0 0 24px 0;">Thank you again for your interest in Aconnect Job Find.</p>'
                . '<p style="margin:0 0 4px 0;">Best regards,</p>'
                . '<p style="margin:0;">Aconnect Job Find Team</p>'
                . '<p style="margin:24px 0 0 0; font-size:13px; color:#666;">You are receiving this message because you applied for this job.</p>'
                . '</div>';
        } else {
            $subject = 'Update on Your Application';
            $body = '<div style="font-family:Arial,sans-serif; color:#333; line-height:1.6; font-size:15px;">'
                . $greeting
                . '<p style="margin:0 0 16px 0;">Thank you for applying for the <strong>' . htmlspecialchars($job_title, ENT_QUOTES, 'UTF-8') . '</strong> position at <strong>' . htmlspecialchars($company, ENT_QUOTES, 'UTF-8') . '</strong>.</p>'
                . '<p style="margin:0 0 16px 0;">After careful review, we will not be moving forward with your application at this time. We appreciate the time and effort you put into your application.</p>'
                . '<p style="margin:0 0 16px 0;">We would like to keep your profile on file for future opportunities. If you prefer not to be contacted, please let us know.</p>'
                . '<p style="margin:0 0 4px 0;">Best regards,</p>'
                . '<p style="margin:0;">Aconnect Job Find Team</p>'
                . '<p style="margin:24px 0 0 0; font-size:13px; color:#666;">You are receiving this message because you applied for this job.</p>'
                . '</div>';
        }

        $this->load->config('email');
        $email_config = $this->config->item('email');

        if (!is_array($email_config) || empty($email_config['smtp_user'])) {
            $this->output->set_status_header(500);
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'SMTP configuration is missing.'
            ]));
            return;
        }

        $this->load->library('email');
        $from_email = $email_config['smtp_user'];
        $from_name = 'Aconnect Job Find';
        $cc_email = $this->input->post('cc_email') ? trim($this->input->post('cc_email')) : $from_email;

        $attempts = [
            $email_config,
            array_merge($email_config, [
                'smtp_port' => 587,
                'smtp_crypto' => 'tls',
            ]),
        ];

        $last_debug = '';

        foreach ($attempts as $attempt_index => $attempt_config) {
            $this->email->clear(true);
            $this->email->initialize($attempt_config);
            $this->email->from($from_email, $from_name);
            $this->email->to($alumni->email);
            if ($cc_email && $cc_email !== '') {
                $this->email->cc($cc_email);
            }
            $this->email->subject($subject);
            $this->email->message($body);

            if ($this->email->send()) {
                $this->output->set_output(json_encode([
                    'success' => true,
                    'message' => 'Email sent successfully.'
                ]));
                return;
            }

            $last_debug = trim(strip_tags($this->email->print_debugger()));
            log_message('error', 'AdminJobPosting send_applicant_email attempt ' . ($attempt_index + 1) . ' failed: ' . $last_debug);
        }

        $this->output->set_status_header(200);
        $this->output->set_output(json_encode([
            'success' => false,
            'message' => 'Failed to send email. Please check SMTP settings.'
            , 'debug' => $last_debug
        ]));
    }

    /** UPDATE JOB POST */
    public function update($id) {
        // Check page access
        if ($this->session->userdata('user_type') === 'employer') {
            if (!$this->check_page_access('job_posting')) {
                $this->show_access_denied();
                return;
            }
            
            // Verify employer owns this job
            $this->db->where('id', $id);
            $this->db->where('employer_id', $this->session->userdata('user_id'));
            $job = $this->db->get('jobs')->row();
            
            if (!$job) {
                $this->session->set_flashdata('error', 'You do not have permission to edit this job.');
                redirect('AdminJobPosting');
                return;
            }
        }

        $image_filename = $this->input->post('current_image_filename');

        // Image upload
        if (!empty($_FILES['image_filename']['name'])) {
            $config['upload_path'] = './assets/uploads/jobs/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = uniqid() . '_' . $_FILES['image_filename']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image_filename')) {
                $uploadData = $this->upload->data();
                $image_filename = $uploadData['file_name'];
            }
        }

        // Get selected courses (can be null)
        $selected_courses = $this->input->post('target_schools');
        $target_courses_json = json_encode($selected_courses);

        $data = [
            'job_title'       => $this->input->post('job_title'),
            'company'         => $this->input->post('company'),
            'description'     => $this->input->post('description'),
            'location'        => $this->input->post('location'),
            'salary_range'    => $this->input->post('salary_range'),
            'qualifications'  => $this->input->post('qualifications'),
            'contact_details' => $this->input->post('contact_details'),
            'image_filename'  => $image_filename,
            'target_courses'  => $target_courses_json,
            'updated_at'      => date('Y-m-d H:i:s'),
        ];

        if ($this->db->where('id', $id)->update('jobs', $data)) {
            $this->session->set_flashdata('success', 'Job posting updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update job posting.');
        }

        redirect('AdminJobPosting');
    }

public function run_worker()
{
    $this->load->model('Email_queue_model');
    $processed = $this->Email_queue_model->process_queue(50);

    // Output a small HTML + SweetAlert popup
    echo '
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: "success",
                title: "Email Notification Sent!",
                html: "Processed ' . $processed . ' email(s).",
                timer: 2000,
                showConfirmButton: false
            });

            setTimeout(function() {
                window.location.href = "' . base_url('AdminJobPosting') . '";
            }, 2000);
        </script>
    </body>
    </html>';
}


    public function delete($id) {
        // Check page access
        if ($this->session->userdata('user_type') === 'employer') {
            if (!$this->check_page_access('job_posting')) {
                $this->show_access_denied();
                return;
            }
            
            // Verify employer owns this job
            $this->db->where('id', $id);
            $this->db->where('employer_id', $this->session->userdata('user_id'));
            $job = $this->db->get('jobs')->row();
            
            if (!$job) {
                $this->session->set_flashdata('error', 'You do not have permission to delete this job.');
                redirect('AdminJobPosting');
                return;
            }
        }
        
        if ($this->db->field_exists('deleted_at', 'jobs')) {
            $result = $this->db->where('id', $id)->update('jobs', ['deleted_at' => date('Y-m-d H:i:s')]);
        } else {
            $result = $this->db->where('id', $id)->delete('jobs');
        }
        if ($result) {
            $this->session->set_flashdata('success', 'Job posting deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete job posting.');
        }
        redirect('AdminJobPosting');
    }

    /** CREATE NEW JOB */
    public function create() 
    {
        // Check page access
        if ($this->session->userdata('user_type') === 'employer') {
            if (!$this->check_page_access('job_posting')) {
                $this->show_access_denied();
                return;
            }
        }
        
        // Image upload
        $config['upload_path'] = 'assets/uploads/jobs';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 7048;

        $this->load->library('upload', $config);
        $image_filename = '';

        if ($this->upload->do_upload('image_filename')) {
            $upload_data = $this->upload->data();
            $image_filename = $upload_data['file_name'];
        }

        // Get selected courses (array or null)
        $selected_courses = $this->input->post('target_schools');
        $target_courses_json = json_encode($selected_courses);

        // Save job basic data
        $job_data = [
            'job_title'        => $this->input->post('job_title'),
            'company'          => $this->input->post('company'),
            'description'      => $this->input->post('description'),
            'location'         => $this->input->post('location'),
            'salary_range'     => $this->input->post('salary_range'),
            'qualifications'   => $this->input->post('qualifications'),
            'contact_details'  => $this->input->post('contact_details'),
            'image_filename'   => $image_filename,
            'posted_by'        => $this->session->userdata('admin_id'),
            'target_courses'   => $target_courses_json,
            'created_at'       => date('Y-m-d H:i:s'),
        ];
        
        // Add employer_id if it's an employer
        if ($this->session->userdata('user_type') === 'employer') {
            $job_data['employer_id'] = $this->session->userdata('user_id');
        }

        // Insert job
        if ($this->db->insert('jobs', $job_data)) {
            $job_id = $this->db->insert_id();
            $this->session->set_flashdata('success', 'New job opportunity published successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to publish job opportunity.');
            redirect('AdminJobPosting');
            return;
        }

        /** ===============================
         *  TARGET SPECIFIC ALUMNI EMAIL
         *  =============================== */

        // Apply filtering
        if (!empty($selected_courses)) {
            $this->db->where_in('degree', $selected_courses);
        }

        $alumni_list = $this->db->get('alumni')->result();

        // Insert each email into queue
        foreach ($alumni_list as $alumni) 
        {
            $body = "
                <p>Hello <strong>{$alumni->first_name}</strong>,</p>
                <p>A new job opportunity is now available:</p>
                <p><strong>{$job_data['job_title']}</strong> at <strong>{$job_data['company']}</strong></p>
                <p>Location: {$job_data['location']}</p>
                <p>Login to the alumni portal to view more details.</p>
                <br>
                <p>– Aconnect Alumni System</p>
            ";

            $this->db->insert('email_queue', [
                'recipient'  => $alumni->email,
                'subject'    => 'New Job Opportunity: '.$job_data['job_title'],
                'body'       => $body,
                'status'     => 'pending',
                'attempts'   => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'send_after' => NULL
            ]);
        }
        // Email worker must be run via cron job on shared hosting (exec() is disabled)
        // Emails are queued in email_queue table and will be sent by the cron job

        redirect('AdminJobPosting');
    }

}