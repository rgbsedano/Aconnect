<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Employer Profile Controller
 * Handles employer profile and settings management
 */
class EmployerProfile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->driver('cache', ['adapter' => 'memcached']);
        
        // Check if employer is logged in
        if (!$this->session->userdata('login_status') || $this->session->userdata('user_type') !== 'employer') {
            redirect('employer_login');
        }
    }

    /**
     * Fetch employer's groups from database or memcached cache
     */
    private function get_employer_groups($employer_id)
    {
        $cache_key = 'employer_groups_' . $employer_id;
        $cache_duration = 3600; // 1 hour cache duration
        
        // Check memcached first
        $cached_groups = $this->cache->get($cache_key);
        
        if ($cached_groups !== false) {
            return $cached_groups;
        }
        
        // Cache miss - fetch from database
        $groups = $this->db->select('eg.id, eg.group_name, eg.description, eg.created_at')
            ->from('employer_groups eg')
            ->join('employer_group_assignments ega', 'eg.id = ega.group_id')
            ->where('ega.employer_id', $employer_id)
            ->order_by('eg.created_at', 'DESC')
            ->get()
            ->result();
        
        // Store in memcached
        $this->cache->save($cache_key, $groups, $cache_duration);
        
        return $groups;
    }

    /**
     * Refresh employer groups cache
     */
    public function refresh_groups_cache()
    {
        $employer_id = $this->session->userdata('user_id');
        $cache_key = 'employer_groups_' . $employer_id;
        
        // Clear memcached
        $this->cache->delete($cache_key);
        
        // Fetch fresh data and cache it
        $this->get_employer_groups($employer_id);
    }

    /**
     * Invalidate groups cache for specific employers (called from admin)
     * @param array $employer_ids Array of employer IDs to invalidate cache for
     */
    public function invalidate_employers_groups_cache($employer_ids = [])
    {
        if (empty($employer_ids)) {
            return;
        }

        // Ensure it's an array
        if (!is_array($employer_ids)) {
            $employer_ids = [$employer_ids];
        }

        // Clear cache for each employer
        foreach ($employer_ids as $employer_id) {
            $cache_key = 'employer_groups_' . $employer_id;
            $this->cache->delete($cache_key);
        }
    }

    /**
     * Prepare common data for profile views
     */
    private function get_profile_data($page_title = 'Profile Settings', $active_section = 'account')
    {
        $employer_id = $this->session->userdata('user_id');
        $display_full_name = $this->session->userdata('company_name') ?? 'Employer';
        
        return [
            'page_title' => $page_title,
            'active_section' => $active_section,
            'employer_id' => $employer_id,
            'email' => $this->session->userdata('email'),
            'company_name' => $this->session->userdata('company_name'),
            'display_full_name' => $display_full_name,
            'groups' => $this->get_employer_groups($employer_id)
        ];
    }

    /**
     * Display employer profile/settings page
     */
    public function index()
    {
        $data = $this->get_profile_data('Profile Settings', 'account');
        $this->load->view('employer/profile', $data);
    }

    /**
     * Account settings view
     */
    public function account_settings()
    {
        $data = $this->get_profile_data('Account Settings', 'account');
        $this->load->view('employer/profile', $data);
    }

    /**
     * Security settings view
     */
    public function security_settings()
    {
        $data = $this->get_profile_data('Security Settings', 'security');
        $this->load->view('employer/profile', $data);
    }

    /**
     * Communications settings view
     */
    public function communications_settings()
    {
        $data = $this->get_profile_data('Communications Settings', 'communications');
        $this->load->view('employer/profile', $data);
    }

    /**
     * Device management view
     */
    public function device_management()
    {
        $data = $this->get_profile_data('Device Management', 'devices');
        $this->load->view('employer/profile', $data);
    }

    /**
     * Privacy settings view
     */
    public function privacy_settings()
    {
        $data = $this->get_profile_data('Privacy Settings', 'privacy');
        $this->load->view('employer/profile', $data);
    }

    /**
     * Update email
     */
    public function update_email()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('employer_profile');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error_message', validation_errors());
            redirect('employer_profile');
        }

        $new_email = $this->input->post('email');
        
        // Update email in database
        $employer_id = $this->session->userdata('user_id');
        $this->db->where('id', $employer_id);
        $this->db->update('employers', ['email' => $new_email]);

        // Update session
        $this->session->set_userdata('email', $new_email);
        
        $this->session->set_flashdata('success_message', 'Email updated successfully!');
        redirect('employer_profile');
    }

    /**
     * My groups view - shows groups the employer belongs to
     */
    public function my_groups()
    {
        $data = $this->get_profile_data('My Groups', 'groups');
        $this->load->view('employer/profile', $data);
    }

    /**
     * Initialize employer groups cache on login
     */
    public function init_groups_cache()
    {
        $employer_id = $this->session->userdata('user_id');
        if ($employer_id) {
            $this->get_employer_groups($employer_id);
        }
    }

    /**
     * Logout employer
     */
    public function logout()
    {
        $employer_id = $this->session->userdata('user_id');
        
        // Clear cache keys before destroying session
        if ($employer_id) {
            $this->session->unset_userdata([
                'employer_groups_' . $employer_id,
                'employer_groups_timestamp_' . $employer_id
            ]);
        }
        
        $this->session->sess_destroy();
        redirect('employer_login');
    }

    /**
     * Get group member count via AJAX
     */
    public function get_group_member_count()
    {
        $group_id = $this->input->get('group_id');
        
        if (empty($group_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid group ID', 'count' => 0]));
        }

        $count = $this->db->where('group_id', $group_id)
            ->from('employer_group_assignments')
            ->count_all_results();

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => TRUE, 'count' => $count]));
    }

    /**
     * Get members in a group (company names)
     */
    public function get_group_members()
    {
        $group_id = $this->input->get('group_id');
        
        if (empty($group_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid group ID', 'members' => []]));
        }

        $members = $this->db->select('e.id, e.company_name')
            ->from('employer_group_assignments ega')
            ->join('employers e', 'ega.employer_id = e.id')
            ->where('ega.group_id', $group_id)
            ->order_by('e.company_name', 'ASC')
            ->get()
            ->result();

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => TRUE, 'members' => $members]));
    }

    /**
     * Get jobs posted by a specific employer
     */
    public function get_employer_jobs()
    {
        $employer_id = $this->input->get('employer_id');
        
        if (empty($employer_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid employer ID', 'jobs' => []]));
        }

        $jobs = $this->db->select('id, job_title, company as job_category, salary_range, location, created_at')
            ->from('jobs')
            ->where('employer_id', $employer_id)
            ->order_by('created_at', 'DESC')
            ->get()
            ->result();

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => TRUE, 'jobs' => $jobs]));
    }
}
?>
