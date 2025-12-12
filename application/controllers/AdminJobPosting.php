<?php
class AdminJobPosting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {

        $this->load->view('__header');

        // Get all jobs
        $data['jobs'] = $this->db->get('jobs')->result();

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

    /** UPDATE JOB POST */
    public function update($id) {

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

        $this->db->where('id', $id)->update('jobs', $data);

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


    /** DELETE JOB */
    public function delete($id) {
        $this->db->where('id', $id)->delete('jobs');
        redirect('AdminJobPosting');
    }

    /** CREATE NEW JOB */
    public function create() 
    {
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

        // Insert job
        $this->db->insert('jobs', $job_data);
        $job_id = $this->db->insert_id();

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
        // AUTO RUN EMAIL WORKER IN BACKGROUND
        $cmd = 'php ' . FCPATH . 'index.php Email_worker send > /dev/null 2>&1 &';
        exec($cmd);

        redirect('AdminJobPosting');
    }

}
