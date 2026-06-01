<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example RBAC Implementation in CodeIgniter 3 Controllers
 * 
 * This guide shows how to use the auth_helper.php to protect pages
 * based on roles and permissions.
 */

class EmployersController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load the auth helper
        $this->load->helper('auth');
        $this->load->library('session');

        // METHOD 1: Check permission and show 404 if user lacks access
        // This makes the page completely invisible to unauthorized users
        if (!has_permission('view_employers_page')) {
            show_404();
        }

        // METHOD 2: Alternative - Check if page is hidden by admin
        // (for more granular control per role)
        if (is_hidden_by_admin('employers_dashboard')) {
            show_404();
        }

        // METHOD 3: Check for specific role
        if (!has_role('admin') && !has_role('employer')) {
            show_404();
        }
    }

    /**
     * Display the employers dashboard
     * Only accessible if user has 'view_employers_page' permission
     */
    public function dashboard()
    {
        $this->load->model('user/Alumni_model');

        $data = [
            'page_title' => 'Employers Dashboard',
            'employers' => $this->Alumni_model->get_all_employers(),
        ];

        $this->load->view('__header', $data);
        $this->load->view('admin/employers_dashboard', $data);
        $this->load->view('__footer');
    }

    /**
     * View individual employer profile
     * Additional permission check for specific actions
     */
    public function view_employer($employer_id)
    {
        // Check if user has permission to manage employers
        if (!has_permission('manage_employers')) {
            show_404();
        }

        // Your controller logic here
    }

    /**
     * Method that checks multiple permissions
     */
    public function manage_employer_details($employer_id)
    {
        // Check if user has ANY of these permissions
        if (!has_any_permission(['manage_employers', 'edit_employer_profile'])) {
            show_404();
        }

        // Your controller logic here
    }

    /**
     * Create new employer (restricted action)
     */
    public function create_employer()
    {
        // Require ALL of these permissions
        if (!has_all_permissions(['create_employers', 'manage_employers'])) {
            $this->session->set_flashdata('error', 'You do not have permission to create employers.');
            redirect('dashboard');
        }

        // Your controller logic here
    }

    /**
     * Example: Check multiple conditions
     */
    public function export_employer_data()
    {
        // Must be logged in AND have permission to export
        if (!$this->session->userdata('alumni_id') || !has_permission('export_data')) {
            show_404();
        }

        // Generate and serve file
    }
}

// ================================================================
// ALTERNATIVE APPROACH: Using Models to Check Visibility
// ================================================================

/**
 * Example model method for checking access
     */
class Employer_Access_Model extends CI_Model {

    /**
     * Check if current user can access employers section
     *
     * @return bool
     */
    public function can_access()
    {
        $this->load->helper('auth');
        return has_permission('view_employers_page');
    }

    /**
     * Check if current user can perform admin actions on employers
     *
     * @return bool
     */
    public function can_manage()
    {
        $this->load->helper('auth');
        return has_permission('manage_employers') && has_role('admin');
    }

    /**
     * Get visible fields for current user
     *
     * @return array
     */
    public function get_allowed_fields()
    {
        $this->load->helper('auth');
        
        if (has_role('admin')) {
            return ['id', 'name', 'email', 'phone', 'salary_range', 'created_at', 'verified'];
        }

        if (has_role('employer')) {
            return ['id', 'name', 'email', 'phone', 'created_at'];
        }

        // Alumni or guest - minimal fields
        return ['id', 'name', 'created_at'];
    }
}
