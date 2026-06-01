<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Page Visibility Controller
 * Manage which pages are visible to which roles
 */
class AdminPageVisibility extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Check if user is logged in as admin or employer
        $user_type = $this->session->userdata('user_type');
        
        if ($user_type === 'employer') {
            // Employer can only access this page
            if ($this->session->userdata('login_status') !== TRUE) {
                redirect(base_url("employer_login"));
            }
        } else {
            // Admin authentication check
            if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
                redirect(base_url("adminlogin"));
            }
            
            if ($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy") {
                redirect(base_url("adminlogin"));
            }
        }

        $this->load->model('Rbac_model');
        $this->load->helper('auth');
        $this->load->helper(['url', 'admin_pagination']);
    }

    /**
     * List all page visibility settings
     */
    public function index()
    {
        $data = [];
        
        // Get all employers from database
        $results_per_page = 5;
        $page = (int) $this->input->get('page', TRUE);
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $results_per_page;

        $search = trim((string) $this->input->get('search', TRUE));

        // COUNT(*) query
        $this->db->from('employers');
        if ($search !== '') {
            $this->db->like('company_name', $search);
        }
        $total_records = (int) $this->db->count_all_results();
        $total_pages = (int) ceil($total_records / $results_per_page);
        if ($total_pages < 1) $total_pages = 1;
        if ($page > $total_pages) {
            $page = $total_pages;
            $offset = ($page - 1) * $results_per_page;
        }

        // Main fetch query with LIMIT/OFFSET
        $this->db->from('employers');
        if ($search !== '') {
            $this->db->like('company_name', $search);
        }
        $employers = $this->db
            ->order_by('company_name', 'ASC')
            ->limit($results_per_page, $offset)
            ->get()
            ->result();
        
        // Ensure all employer objects have status property
        foreach ($employers as $employer) {
            if (!isset($employer->status)) {
                $employer->status = 1; // Default to active
            }
        }
        
        $data['employers'] = !empty($employers) ? $employers : [];
        $data['pagination_links'] = admin_build_pagination_links(
            base_url('AdminPageVisibility'),
            $search !== '' ? ['search' => $search] : [],
            $page,
            $total_pages
        );
        
        // Define employer-accessible pages in the admin panel
        $data['pages'] = [
            ['slug' => 'job_posting', 'name' => 'Job Posting', 'description' => 'Manage job postings and listings'],
            ['slug' => 'user_accounts', 'name' => 'User Accounts', 'description' => 'Manage user account settings and profiles'],
            ['slug' => 'alumni_officers', 'name' => 'Alumni Officers', 'description' => 'Manage officer accounts and permissions'],
            ['slug' => 'events', 'name' => 'Events', 'description' => 'Create and manage events'],
            ['slug' => 'posting', 'name' => 'Posting', 'description' => 'Manage general postings and announcements'],
            ['slug' => 'support', 'name' => 'Support', 'description' => 'Handle support tickets and inquiries'],
            ['slug' => 'reports', 'name' => 'Reports', 'description' => 'View analytics and reports'],
        ];
        
        // Get current visibility settings for all employers
        $data['visibility_settings'] = [];
        
        foreach ($data['pages'] as $page) {
            if (!empty($data['employers'])) {
                foreach ($data['employers'] as $employer) {
                    $visibility_key = $page['slug'] . '_' . $employer->id;
                    $setting = $this->Rbac_model->get_employer_visibility_setting($page['slug'], $employer->id);
                    
                    if ($setting === NULL) {
                        // Create new setting with default value (visible=1)
                        $this->Rbac_model->set_employer_page_visibility($page['slug'], $employer->id, TRUE);
                        $data['visibility_settings'][$visibility_key] = 1;
                    } else {
                        $data['visibility_settings'][$visibility_key] = $setting->is_visible;
                    }
                }
            }
        }
        
        // Get employer group assignments
        if (!empty($data['employers'])) {
            foreach ($data['employers'] as $employer) {
                $group = $this->db->select('eg.group_name')
                    ->from('employer_group_assignments ega')
                    ->join('employer_groups eg', 'eg.id = ega.group_id')
                    ->where('ega.employer_id', $employer->id)
                    ->limit(1)
                    ->get()
                    ->row();
                
                if ($group) {
                    $data['visibility_settings']['employer_group_' . $employer->id] = $group->group_name;
                }
            }
        }
        
        // Load appropriate view based on user type
        $this->load->view('__header');
        $this->load->view('admin/manage_page_visibility', $data);
        $this->load->view('__footer');
    }

    /**
     * Toggle page visibility for a role via AJAX
     */
    public function toggle_visibility()
    {
        $this->load->library('form_validation');
        
        $page_slug = $this->input->post('page_slug');
        $role_id = $this->input->post('role_id');
        $is_visible = $this->input->post('is_visible');
        
        // Validate input
        if (empty($page_slug) || empty($role_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid input']));
        }
        
        // Update visibility setting
        // Convert string "1" or "0" to proper boolean
        $is_visible_bool = ($is_visible == "1" || $is_visible === 1 || $is_visible === true);
        $result = $this->Rbac_model->set_page_visibility($page_slug, $role_id, $is_visible_bool);
        
        if ($result) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => TRUE, 'message' => 'Updated successfully']));
        } else {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Failed to update']));
        }
    }

    /**
     * Toggle page visibility for an employer via AJAX
     */
    public function toggle_employer_visibility()
    {
        $this->load->library('form_validation');
        
        $page_slug = $this->input->post('page_slug');
        $employer_id = $this->input->post('employer_id');
        $is_visible = $this->input->post('is_visible');
        
        // Validate input
        if (empty($page_slug) || empty($employer_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid input']));
        }
        
        // Update visibility setting for employer
        // Convert string "1" or "0" to proper boolean
        $is_visible_bool = ($is_visible == "1" || $is_visible === 1 || $is_visible === true);
        $result = $this->Rbac_model->set_employer_page_visibility($page_slug, $employer_id, $is_visible_bool);
        
        if ($result) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => TRUE, 'message' => 'Updated successfully']));
        } else {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Failed to update']));
        }
    }

    /**
     * Hide a page from a specific role
     */
    public function hide_page($page_slug, $role_id)
    {
        $this->Rbac_model->hide_page_from_role($page_slug, $role_id);
        $this->session->set_flashdata('success', 'Page hidden from role');
        redirect('admin/page_visibility');
    }

    /**
     * Show a page to a specific role
     */
    public function show_page($page_slug, $role_id)
    {
        $this->Rbac_model->show_page_to_role($page_slug, $role_id);
        $this->session->set_flashdata('success', 'Page is now visible to this role');
        redirect('admin/page_visibility');
    }

    /**
     * Create employer_page_visibility table and initialize data
     */
    public function create_table()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            redirect(base_url("adminlogin"));
        }
        
        if ($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy") {
            redirect(base_url("adminlogin"));
        }

        $output = "<h1>Creating Employer Page Visibility Table</h1>";
        
        // Check if table already exists
        if ($this->db->table_exists('employer_page_visibility')) {
            $output .= "<p style='color: orange;'><strong>Notice:</strong> 'employer_page_visibility' table already exists.</p>";
            $output .= "<p>No changes needed.</p>";
        } else {
            // Create table using raw SQL
            $sql = "CREATE TABLE IF NOT EXISTS `employer_page_visibility` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `page_slug` varchar(100) NOT NULL,
                `employer_id` int(11) NOT NULL,
                `is_visible` tinyint(1) DEFAULT 1,
                `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `unique_page_employer` (`page_slug`, `employer_id`),
                FOREIGN KEY (`employer_id`) REFERENCES `employers`(`id`) ON DELETE CASCADE,
                INDEX `idx_page_slug` (`page_slug`),
                INDEX `idx_employer_id` (`employer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

            if ($this->db->query($sql)) {
                $output .= "<p style='color: green;'><strong>Success!</strong> 'employer_page_visibility' table has been created.</p>";
                
                // Initialize default visibility settings (all pages visible by default)
                $pages = [
                    'job_posting',
                    'user_accounts',
                    'alumni_officers',
                    'events',
                    'posting',
                    'support',
                    'reports',
                ];
                
                // Get all employers
                $employers = $this->db->get('employers')->result();
                
                if (!empty($employers)) {
                    $output .= "<p>Initializing visibility settings for " . count($employers) . " employer(s)...</p>";
                    
                    $inserted = 0;
                    foreach ($employers as $employer) {
                        foreach ($pages as $page_slug) {
                            $data = [
                                'page_slug' => $page_slug,
                                'employer_id' => $employer->id,
                                'is_visible' => 1,
                            ];
                            $this->db->insert('employer_page_visibility', $data);
                            $inserted++;
                        }
                    }
                    
                    $output .= "<p style='color: green;'>✓ Created {$inserted} visibility setting(s).</p>";
                } else {
                    $output .= "<p style='color: orange;'><strong>Notice:</strong> No employers found. Add employers first, then run this script again to initialize visibility settings.</p>";
                }
            } else {
                $output .= "<p style='color: red;'><strong>Error:</strong> Failed to create table.</p>";
                $error = $this->db->error();
                $output .= "<p>Database Error: " . $error['message'] . "</p>";
            }
        }
        
        $output .= "<p><a href='" . base_url('adminpagevisibility') . "'>Go to Page Visibility Settings</a></p>";
        
        $this->load->view('__header');
        echo $output;
        $this->load->view('__footer');
    }

    /**
     * Manage employer groups
     */
    public function manage_groups()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            redirect(base_url("adminlogin"));
        }
        
        if ($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy") {
            redirect(base_url("adminlogin"));
        }

        $data = [];

        $results_per_page = 5;
        $page = (int) $this->input->get('page', TRUE);
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $results_per_page;

        // COUNT(*) query
        $this->db->from('employer_groups');
        $total_records = (int) $this->db->count_all_results();
        $total_pages = (int) ceil($total_records / $results_per_page);
        if ($total_pages < 1) $total_pages = 1;
        if ($page > $total_pages) {
            $page = $total_pages;
            $offset = ($page - 1) * $results_per_page;
        }

        // Main fetch query with LIMIT/OFFSET
        $groups = $this->db
            ->order_by('group_name', 'ASC')
            ->limit($results_per_page, $offset)
            ->get('employer_groups')
            ->result();

        // Add member count (match existing model behavior)
        foreach ($groups as $group) {
            $group->member_count = $this->db->where('group_id', $group->id)
                ->get('employer_group_assignments')
                ->num_rows();
        }

        $data['groups'] = $groups;
        $data['pagination_links'] = admin_build_pagination_links(base_url('AdminPageVisibility/manage_groups'), [], $page, $total_pages);
        
        // Count employers in each group
        $data['group_counts'] = [];
        foreach ($data['groups'] as $group) {
            $employers = $this->Rbac_model->get_employers_in_group($group->id);
            $data['group_counts'][$group->id] = count($employers);
        }

        $this->load->view('__header');
        $this->load->view('admin/manage_employer_groups', $data);
        $this->load->view('__footer');
    }

    /**
     * Create new employer group
     */
    public function create_group()
    {
        error_log("=== CREATE_GROUP START ===");
        error_log("POST data: " . print_r($_POST, true));

        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            error_log("Unauthorized access attempt");
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $group_name = $this->input->post('group_name');
        $employer_ids_json = $this->input->post('employer_ids');

        error_log("Group name: " . $group_name);
        error_log("Employer IDs JSON: " . $employer_ids_json);

        if (empty($group_name)) {
            error_log("Group name is empty");
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Group name is required']));
        }

        if (empty($employer_ids_json)) {
            error_log("Employer IDs JSON is empty");
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Please select at least one employer']));
        }

        $employer_ids = json_decode($employer_ids_json, true);

        error_log("Decoded employer IDs: " . print_r($employer_ids, true));

        if (!is_array($employer_ids) || empty($employer_ids)) {
            error_log("Invalid employer selection - not array or empty");
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid employer selection']));
        }

        // Check if group name already exists
        $this->db->where('group_name', $group_name);
        $existing_group = $this->db->get('employer_groups')->row();
        if ($existing_group) {
            error_log("Group name already exists: " . $group_name);
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'A group with this name already exists']));
        }

        // Insert group into database
        $group_data = [
            'group_name' => $group_name
        ];

        error_log("Inserting group data: " . print_r($group_data, true));
        $this->db->insert('employer_groups', $group_data);
        $group_id = $this->db->insert_id();
        error_log("Group insert result - ID: " . $group_id . ", DB error: " . $this->db->error()['message']);

        if (!$group_id) {
            error_log("Failed to create group - no insert ID");
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Failed to create group']));
        }

        error_log("Group created with ID: " . $group_id);

        // Assign employers to group
        $inserted_count = 0;
        $failed_inserts = [];

        // Assign employers to group
        $inserted_count = 0;
        $failed_inserts = [];
        
        foreach ($employer_ids as $employer_id) {
            // Check if already assigned to prevent duplicates
            $this->db->where('group_id', $group_id);
            $this->db->where('employer_id', $employer_id);
            $existing = $this->db->get('employer_group_assignments')->num_rows();
            
            if ($existing > 0) {
                $failed_inserts[] = "Employer $employer_id already assigned";
                continue;
            }
            
            $assignment_data = [
                'group_id' => $group_id,
                'employer_id' => $employer_id,
                'assigned_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->db->insert('employer_group_assignments', $assignment_data)) {
                $inserted_count++;
            } else {
                $failed_inserts[] = "Failed to assign employer $employer_id";
            }
        }

        // Invalidate groups cache for all affected employers
        // TODO: Move this to a proper model/library method
        // $this->load->controller('EmployerProfile');
        // $this->employerprofile->invalidate_employers_groups_cache($employer_ids);

        $response = [
            'success' => TRUE, 
            'message' => "Group created successfully with $inserted_count employer(s) assigned",
            'group_id' => $group_id,
            'inserted_count' => $inserted_count,
            'total_requested' => count($employer_ids)
        ];
        
        if (!empty($failed_inserts)) {
            $response['warnings'] = $failed_inserts;
        }
        
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * Delete employer group
     */
    public function delete_group()
    {
        error_log("=== DELETE_GROUP START ===");
        error_log("POST data: " . print_r($_POST, true));

        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            error_log("Unauthorized access attempt");
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $group_id = $this->input->post('group_id');
        error_log("Group ID: " . $group_id);

        if (empty($group_id)) {
            error_log("Group ID is empty");
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Group ID is required']));
        }

        // Get employers in this group before deleting (for cache invalidation)
        $employers_in_group = $this->db->select('employer_id')
            ->from('employer_group_assignments')
            ->where('group_id', $group_id)
            ->get()
            ->result();
        
        $employer_ids = array_map(function($row) { return $row->employer_id; }, $employers_in_group);

        try {
            $result = $this->Rbac_model->delete_employer_group($group_id);
            error_log("Delete result: " . ($result ? 'true' : 'false'));
        } catch (Exception $e) {
            error_log("Exception in delete_employer_group: " . $e->getMessage());
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Database error: ' . $e->getMessage()]));
        }

        // Invalidate groups cache for all affected employers
        // TODO: Move this to a proper model/library method
        // if ($result && !empty($employer_ids)) {
        //     $this->load->controller('EmployerProfile');
        //     $this->employerprofile->invalidate_employers_groups_cache($employer_ids);
        // }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => $result, 'message' => $result ? 'Group deleted successfully' : 'Failed to delete group']));
    }

    /**
     * Update employer group name
     */
    public function update_group_name()
    {
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $group_id = (int) $this->input->post('group_id');
        $group_name = trim((string) $this->input->post('group_name'));

        if ($group_id <= 0) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid group ID']));
        }

        if ($group_name === '') {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Group name is required']));
        }

        $existing_group = $this->Rbac_model->get_employer_group($group_id);
        if (!$existing_group) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Group not found']));
        }

        $duplicate = $this->db
            ->where('id !=', $group_id)
            ->where('group_name', $group_name)
            ->get('employer_groups')
            ->row();

        if ($duplicate) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'A group with this name already exists']));
        }

        $result = $this->Rbac_model->update_employer_group($group_id, ['group_name' => $group_name]);

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => (bool) $result,
                'message' => $result ? 'Group name updated successfully' : 'Failed to update group name'
            ]));
    }

    /**
     * Update employer group description
     */
    public function update_group_description()
    {
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $group_id = (int) $this->input->post('group_id');
        $description = trim((string) $this->input->post('description'));

        if ($group_id <= 0) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid group ID']));
        }

        $existing_group = $this->Rbac_model->get_employer_group($group_id);
        if (!$existing_group) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Group not found']));
        }

        $result = $this->Rbac_model->update_employer_group($group_id, ['description' => $description]);

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => (bool) $result,
                'message' => $result ? 'Group description updated successfully' : 'Failed to update group description'
            ]));
    }

    /**
     * Get employers in a group
     */
    public function get_group_employers()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $group_id = $this->input->get('group_id');

        if (empty($group_id) || !is_numeric($group_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid group ID']));
        }

        $employers = $this->Rbac_model->get_employers_in_group($group_id);
        $available_employers = $this->Rbac_model->get_employers_not_in_group($group_id);

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => TRUE, 
                'employers' => $employers,
                'available_employers' => $available_employers
            ]));
    }

    /**
     * Add employer to group
     */
    public function add_employer_to_group()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $employer_id = $this->input->post('employer_id');
        $group_id = $this->input->post('group_id');

        if (empty($employer_id) || empty($group_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid parameters']));
        }

        $result = $this->Rbac_model->assign_employer_to_group($employer_id, $group_id);

        // Invalidate groups cache for the affected employer
        if ($result) {
            $this->load->controller('EmployerProfile');
            $this->employerprofile->invalidate_employers_groups_cache([$employer_id]);
        }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => $result, 'message' => 'Employer added to group']));
    }

    /**
     * Remove employer from group
     */
    public function remove_employer_from_group()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $employer_id = $this->input->post('employer_id');
        $group_id = $this->input->post('group_id');

        if (empty($employer_id) || empty($group_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid parameters']));
        }

        $result = $this->Rbac_model->remove_employer_from_group($employer_id, $group_id);

        // Invalidate groups cache for the affected employer
        if ($result) {
            $this->load->controller('EmployerProfile');
            $this->employerprofile->invalidate_employers_groups_cache([$employer_id]);
        }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => $result, 'message' => 'Employer removed from group']));
    }

    /**
     * Get employer groups data (all groups and current groups for an employer)
     */
    public function get_employer_groups_data()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $employer_id = $this->input->get('employer_id');

        if (empty($employer_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid employer ID']));
        }

        // Get all groups
        $all_groups = $this->Rbac_model->get_all_employer_groups();

        // Get current groups for this employer
        $current_groups = $this->Rbac_model->get_employer_groups_for_employer($employer_id);

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => TRUE,
                'all_groups' => $all_groups,
                'current_groups' => $current_groups
            ]));
    }

    /**
     * Get employer account details
     */
    public function get_employer_details()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $employer_id = $this->input->get('employer_id');

        if (empty($employer_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid employer ID']));
        }

        // Get employer details from database
        $employer = $this->db->where('id', $employer_id)->get('employers')->row();

        if (!$employer) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Employer not found']));
        }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => TRUE,
                'employer' => $employer
            ]));
    }

    /**
     * Get employer visibility settings for a specific employer
     */
    public function get_employer_visibility()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $employer_id = $this->input->get('employer_id');

        if (empty($employer_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid employer ID']));
        }

        // Define pages
        $pages = [
            ['slug' => 'job_posting', 'name' => 'Job Posting', 'description' => 'Manage job postings and listings'],
            ['slug' => 'user_accounts', 'name' => 'User Accounts', 'description' => 'Manage user account settings and profiles'],
            ['slug' => 'alumni_officers', 'name' => 'Alumni Officers', 'description' => 'Manage officer accounts and permissions'],
            ['slug' => 'events', 'name' => 'Events', 'description' => 'Create and manage events'],
            ['slug' => 'posting', 'name' => 'Posting', 'description' => 'Manage general postings and announcements'],
            ['slug' => 'support', 'name' => 'Support', 'description' => 'Handle support tickets and inquiries'],
            ['slug' => 'reports', 'name' => 'Reports', 'description' => 'View analytics and reports'],
        ];

        // Get current visibility settings for this employer
        $visibility = [];
        foreach ($pages as $page) {
            $visibility_key = $page['slug'] . '_' . $employer_id;
            $setting = $this->Rbac_model->get_employer_visibility_setting($page['slug'], $employer_id);
            
            if ($setting === NULL) {
                // Default to visible if no setting exists
                $visibility[$visibility_key] = 1;
            } else {
                $visibility[$visibility_key] = (int) $setting->is_visible;
            }
        }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => TRUE,
                'visibility' => $visibility
            ]));
    }

    /**
     * Delete an employer
     */
    public function delete_employer()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $employer_id = $this->input->post('employer_id');

        if (empty($employer_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid employer ID']));
        }

        // Delete employer visibility settings
        $this->db->where('employer_id', $employer_id)->delete('employer_page_visibility');

        // Delete employer group assignments
        $this->db->where('employer_id', $employer_id)->delete('employer_group_assignments');

        // Delete the employer
        $result = $this->db->where('id', $employer_id)->delete('employers');

        if ($result) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => TRUE, 'message' => 'Employer deleted successfully']));
        } else {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Failed to delete employer']));
        }
    }

    /**
     * Create a new employer
     */
    public function create_employer()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        // Get form data
        $company_name = $this->input->post('company_name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $contact_person = $this->input->post('contact_person');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $status = $this->input->post('status', 1);

        // Validation
        if (empty($company_name) || empty($email) || empty($password)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Company name, email, and password are required']));
        }

        // Check if email already exists
        $existing = $this->db->where('email', $email)->get('employers')->row();
        if ($existing) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Email already exists']));
        }

        // Prepare data for insertion
        $employer_data = [
            'company_name' => $company_name,
            'email' => $email,
            'password' => md5($password), // Hash password
            'contact_person' => $contact_person,
            'phone' => $phone,
            'address' => $address,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Insert employer
        $result = $this->db->insert('employers', $employer_data);

        if ($result) {
            $employer_id = $this->db->insert_id();
            
            // Create default page visibility settings for all pages
            $pages = [
                'job_posting', 'user_accounts', 'alumni_officers', 
                'events', 'posting', 'support', 'reports'
            ];
            
            foreach ($pages as $page_slug) {
                $this->Rbac_model->set_employer_page_visibility($page_slug, $employer_id, TRUE);
            }
            
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => TRUE, 'message' => 'Employer created successfully']));
        } else {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Failed to create employer']));
        }
    }

    /**
     * Update employer status (Active/Inactive/Suspended)
     */
    public function update_employer_status()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        try {
            $employer_id = (int) $this->input->post('employer_id');
            $status_input = $this->input->post('status');
            
            log_message('debug', 'update_employer_status - employer_id: ' . $employer_id . ', status_input: ' . $status_input);
            
            // Safely handle null/empty status
            if (!$employer_id || $status_input === NULL || $status_input === '') {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode(['success' => FALSE, 'message' => 'Missing required parameters']));
            }

            $status = strtolower(trim((string)$status_input));

            // Convert status text to numeric value for database storage (is_active column: 1 = active, 0 = inactive/suspended)
            $is_active = 1; // Default to active
            
            if ($status === 'inactive' || $status === 'suspended') {
                $is_active = 0;
            } elseif (is_numeric($status)) {
                $is_active = (int)$status;
            }

            log_message('debug', 'update_employer_status - About to update with is_active: ' . $is_active);

            // Update employer status in database using the correct column name 'is_active'
            $this->db->where('id', $employer_id);
            $result = $this->db->update('employers', array('is_active' => $is_active));
            
            log_message('debug', 'update_employer_status - DB update result: ' . ($result ? 'true' : 'false'));
            log_message('debug', 'update_employer_status - affected_rows: ' . $this->db->affected_rows());
            
            // Check for database errors
            $db_error = $this->db->error();
            if (!empty($db_error['message'])) {
                log_message('error', 'update_employer_status - DB Error: ' . $db_error['message']);
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode(['success' => FALSE, 'message' => 'Database error: ' . $db_error['message']]));
            }

            // Success - either rows were updated or no error occurred
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => TRUE, 'message' => 'Employer status updated successfully']));
            
        } catch (Exception $e) {
            log_message('error', 'update_employer_status - Exception: ' . $e->getMessage());
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Exception: ' . $e->getMessage()]));
        }
    }

    /**
     * Update group status (Active/Inactive/Suspended)
     */
    public function update_group_status()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $group_id = $this->input->post('group_id');
        $status = $this->input->post('status');

        if (empty($group_id) || empty($status)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Missing required parameters']));
        }

        // Map status text to database values
        $status_map = [
            'active' => 'active',
            'inactive' => 'inactive',
            'suspended' => 'suspended'
        ];

        $db_status = isset($status_map[$status]) ? $status_map[$status] : $status;

        // Update group status
        $result = $this->db->where('id', $group_id)
            ->update('employer_groups', ['status' => $db_status]);

        if ($result) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => TRUE, 'message' => 'Group status updated successfully']));
        } else {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Failed to update group status']));
        }
    }

    /**
     * Get members in a group and available employers to add
     */
    public function get_group_members()
    {
        // Admin authentication check
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $group_id = $this->input->get('group_id');

        if (empty($group_id) || !is_numeric($group_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Invalid group ID']));
        }

        // Get members in group
        $members = $this->Rbac_model->get_employers_in_group($group_id);

        // Get available employers not in group
        $available_employers = $this->Rbac_model->get_employers_not_in_group($group_id);

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => TRUE,
                'members' => $members,
                'available_employers' => $available_employers
            ]));
    }

    /**
     * Get employer registry for group creation/search.
     */
    public function get_employer_registry()
    {
        if ($this->session->userdata('role') != "administrator" && $this->session->userdata('role') != "Administrator") {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => FALSE, 'message' => 'Unauthorized']));
        }

        $search = trim((string) $this->input->get('search'));

        $this->db->select('id, company_name, first_name, last_name, email, is_active');
        $this->db->from('employers');
        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('company_name', $search);
            $this->db->or_like('first_name', $search);
            $this->db->or_like('last_name', $search);
            $this->db->group_end();
        }
        $this->db->order_by('first_name', 'ASC');
        $this->db->order_by('last_name', 'ASC');

        $employers = $this->db->get()->result();

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => TRUE,
                'employers' => $employers
            ]));
    }
}


