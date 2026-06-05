<?php

class Jobs extends CI_Controller {

    function __construct() {
        parent::__construct();
    
        // SESSION CHECK
        if ($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy") {
            redirect(base_url("Login"));
        }

        $this->load->helper(['form', 'url', 'date', 'ai_helper']);
        $this->load->library(['session', 'upload']);
        $this->load->model('user/Job_model');
    }
 
    function index() {
        $this->load->view('__header');

        $alumni_id = $this->session->userdata('alumni_id');
        log_message('info', "Jobs Controller - Retrieved alumni_id from session: {$alumni_id}");
        
        $alumni = $this->db->where('id', $alumni_id)->get('alumni')->row();
        
        if (!$alumni) {
            log_message('info', "Jobs Controller - Alumni ID {$alumni_id} not found in database, using empty object");
            $alumni = (object)[
                'degree' => '',
                'technical_skills' => '',
                'soft_skills' => ''
            ];
        } else {
            log_message('info', "Jobs Controller - Alumni loaded: ID={$alumni->id}, Degree={$alumni->degree}, Degree={$alumni->degree}");
        }

        $search   = trim((string)$this->input->get('search',TRUE));
        

       
        $location = trim((string)$this->input->get('location',TRUE));
        $jobs = $this->Job_model->get_all_jobs($search, $location);
        
        log_message('info', "Jobs Controller - Found " . count($jobs) . " jobs to display");

        // Check which jobs the user has already applied to
        $applied_jobs = [];
        foreach ($jobs as $job) {
            if ($this->Job_model->has_applied($job->id, $alumni_id)) {
                $applied_jobs[] = $job->id;
            }
        }

        $data = [
            'jobs'   => $jobs,
            'alumni' => $alumni,
            'applied_jobs' => $applied_jobs
        ];

        $this->load->view('user/jobs', $data);
        $this->load->view('__footer');
    }

    /**
     * Display saved jobs (archive/wishlist page)
     */
    public function archived() {
        $this->load->view('__header');

        $alumni_id = $this->session->userdata('alumni_id');

        // Fetch all job collections for My Jobs tabs.
        $saved_jobs = $this->Job_model->get_saved_jobs($alumni_id);
        $applied_jobs = $this->Job_model->get_applied_jobs($alumni_id);
        $interview_jobs = $this->Job_model->get_interview_jobs($alumni_id);

        $data = [
            'saved_jobs' => $saved_jobs,
            'applied_jobs' => $applied_jobs,
            'interview_jobs' => $interview_jobs
        ];

        $this->load->view('user/jobs_archived', $data);
        $this->load->view('__footer');
    }

    /**
     * AJAX endpoint to hydrate job details by ids.
     * Used by archived page localStorage fallback.
     */
    public function get_jobs_by_ids() {
        $this->output->set_content_type('application/json');

        if (!$this->session->userdata('alumni_id')) {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Not logged in',
                'jobs' => []
            ]));
            return;
        }

        $payload = json_decode($this->input->raw_input_stream, true);
        $job_ids = isset($payload['job_ids']) && is_array($payload['job_ids']) ? $payload['job_ids'] : [];

        $normalized_ids = [];
        foreach ($job_ids as $id) {
            $normalized = (int) $id;
            if ($normalized > 0) {
                $normalized_ids[] = $normalized;
            }
        }
        $normalized_ids = array_values(array_unique($normalized_ids));

        $jobs = $this->Job_model->get_jobs_by_ids($normalized_ids);

        $this->output->set_output(json_encode([
            'status' => true,
            'jobs' => $jobs
        ]));
    }

    /**
     * AJAX endpoint to save a job
     * POST /jobs/save_job_action/{job_id}
     */
    public function save_job_action($job_id) {
        $this->output->set_content_type('application/json');
        $alumni_id = $this->session->userdata('alumni_id');

        if (!$alumni_id) {
            $this->output->set_output(json_encode(['error' => 'Not logged in', 'status' => false]));
            return;
        }

        // Only sync to database if table exists (localStorage fallback works without it)
        if ($this->db->table_exists('saved_jobs')) {
            $this->Job_model->save_job($job_id, $alumni_id);
            $this->output->set_output(json_encode(['status' => true, 'message' => 'Job saved']));
        } else {
            log_message('debug', 'saved_jobs table does not exist; using localStorage only');
            $this->output->set_output(json_encode(['status' => false, 'message' => 'Using local storage']));
        }
    }

    /**
     * AJAX endpoint to unsave a job
     * DELETE /jobs/unsave_job_action/{job_id}
     */
    public function unsave_job_action($job_id) {
        $this->output->set_content_type('application/json');
        $alumni_id = $this->session->userdata('alumni_id');

        if (!$alumni_id) {
            $this->output->set_output(json_encode(['error' => 'Not logged in', 'status' => false]));
            return;
        }

        // Only sync to database if table exists (localStorage fallback works without it)
        if ($this->db->table_exists('saved_jobs')) {
            $this->Job_model->unsave_job($job_id, $alumni_id);
            $this->output->set_output(json_encode(['status' => true, 'message' => 'Job unsaved']));
        } else {
            log_message('debug', 'saved_jobs table does not exist; using localStorage only');
            $this->output->set_output(json_encode(['status' => false, 'message' => 'Using local storage']));
        }
    }

    public function live_search() {
        // AJAX endpoint for live job search
        $this->output->set_content_type('application/json');

        $alumni_id = $this->session->userdata('alumni_id');
        log_message('info', "Jobs::live_search - Retrieved alumni_id from session: {$alumni_id}");
        
        $alumni = $this->db->where('id', $alumni_id)->get('alumni')->row();

        if (!$alumni) {
            log_message('info', "Jobs::live_search - Alumni ID {$alumni_id} not found, using empty object");
            $alumni = (object)[
                'degree' => '',
                'technical_skills' => '',
                'soft_skills' => ''
            ];
        } else {
            log_message('info', "Jobs::live_search - Alumni loaded: ID={$alumni->id}, Degree={$alumni->degree}");
        }

        $search   = trim($this->input->post('search', TRUE));
        $location = trim($this->input->post('location', TRUE));
        
        $jobs = $this->Job_model->get_all_jobs($search, $location);
        
        log_message('info', "Jobs::live_search - Found " . count($jobs) . " jobs to evaluate");

        $response = [];
        foreach ($jobs as $job) {
            $match = compute_ai_match($alumni, $job);
            $response[] = [
                'id' => $job->id,
                'job_title' => htmlspecialchars($job->job_title),
                'company' => htmlspecialchars($job->company),
                'location' => htmlspecialchars($job->location),
                'salary_range' => htmlspecialchars($job->salary_range),
                'match' => $match,
                'qualifications' => htmlspecialchars($job->qualifications),
                'description' => htmlspecialchars($job->description)
            ];
        }

        echo json_encode($response);
    }

    public function apply($job_id) {
        $alumni_id = $this->session->userdata('alumni_id');

        if (!$alumni_id) {
            redirect('login');
        }

        // Log activity
        $this->load->model('Activity_log_model');
        $this->Activity_log_model->log_activity($alumni_id, 'Applied for a job');

        // Apply using alumni's profile (no file upload required)
        $this->Job_model->apply_to_job($job_id, $alumni_id);
        
        // Success: Set success trigger and redirect back
        $this->session->set_flashdata('upload_success', true);
        $this->session->set_flashdata('success', 'Application submitted successfully!');
        redirect('jobs');
    }

    public function get_match_explanation($job_id) {
        // AJAX endpoint to get detailed match explanation
        $this->output->set_content_type('application/json');

        $debug_log = APPPATH . 'logs/cache_insert.log';
        
        try {
            $alumni_id = $this->session->userdata('alumni_id');
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: Alumni ID from session: $alumni_id\n", FILE_APPEND);
            
            $alumni = $this->db->where('id', $alumni_id)->get('alumni')->row();
            $job = $this->db->where('id', $job_id)->get('jobs')->row();

            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: Alumni loaded: " . ($alumni ? $alumni->id : 'NULL') . ", Job loaded: " . ($job ? $job->id : 'NULL') . "\n", FILE_APPEND);

            if (!$alumni || !$job) {
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: Missing alumni or job data\n", FILE_APPEND);
                $this->output->set_output(json_encode(['error' => 'Invalid data']));
                return;
            }

            $match = compute_ai_match($alumni, $job);
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: Match computed: $match%\n", FILE_APPEND);
            
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: About to call get_detailed_match_insight()\n", FILE_APPEND);
            $insight = get_detailed_match_insight($match, $alumni, $job);
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: Returned from get_detailed_match_insight()\n", FILE_APPEND);
            
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: Insight type: " . gettype($insight) . ", is_array: " . (is_array($insight) ? 'YES' : 'NO') . "\n", FILE_APPEND);
            
            if ($insight && is_array($insight)) {
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: Insight is valid array, preparing JSON response\n", FILE_APPEND);
                
                $json_output = json_encode($insight);
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: JSON encoded successfully (length: " . strlen($json_output) . ")\n", FILE_APPEND);
                
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: About to set output\n", FILE_APPEND);
                $this->output->set_output($json_output);
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: Output set successfully - response complete\n", FILE_APPEND);
            } else {
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: Insight is not valid array, returning fallback\n", FILE_APPEND);
                $response = [
                    'percentage' => $match,
                    'status' => 'Analysis',
                    'summary' => 'Match analysis generated.',
                    'strengths' => ['Strong technical foundation'],
                    'gaps' => [],
                    'ai_powered' => false,
                    'cached' => false
                ];
                $this->output->set_output(json_encode($response));
                file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER: Fallback response sent\n", FILE_APPEND);
            }
        } catch (Exception $e) {
            file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] CONTROLLER EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);
            $this->output->set_output(json_encode([
                'error' => 'Server error: ' . $e->getMessage(),
                'status' => 'Error'
            ]));
        }
    }

    public function test_json_response() {
        // Simple test endpoint to verify JSON response works
        $this->output->set_content_type('application/json');
        
        $test_response = [
            'status' => 'success',
            'message' => 'JSON response test working',
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        $this->output->set_output(json_encode($test_response));
    }
}