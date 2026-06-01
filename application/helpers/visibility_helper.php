<?php
/**
 * Visibility Helper
 * Functions for checking page visibility and controlling access
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Check if a page is visible for the current user's role
 *
 * @param string $page_slug - The page slug to check
 * @return bool - TRUE if visible, FALSE if hidden
 */
function is_page_visible($page_slug = '')
{
    $CI = &get_instance();
    
    if (empty($page_slug)) {
        return FALSE;
    }
    
    // Get current user info
    $user_type = $CI->session->userdata('user_type');
    
    // Admins always see all pages
    if ($user_type !== 'employer') {
        return TRUE;
    }
    
    // For employers, check visibility settings
    $CI->load->model('Rbac_model');

    $employer_id = (int) $CI->session->userdata('user_id');
    if ($employer_id > 0) {
        $setting = $CI->Rbac_model->get_employer_visibility_setting($page_slug, $employer_id);
        // Keep default behavior: visible unless explicitly hidden.
        return $setting === NULL ? TRUE : ((int) $setting->is_visible === 1);
    }

    // Fallback for legacy sessions that don't have employer user_id set.
    $employer_role = $CI->Rbac_model->get_role_by_name('employer');
    return $employer_role ? $CI->Rbac_model->is_page_visible($page_slug, $employer_role->role_id) : FALSE;
}

/**
 * Get all visible pages for the current user's role
 *
 * @return array - Array of visible page slugs
 */
function get_visible_pages()
{
    $CI = &get_instance();
    
    $user_type = $CI->session->userdata('user_type');
    
    // Admins can see all pages
    if ($user_type !== 'employer') {
        return [
            'job_posting',
            'user_accounts',
            'alumni_officers',
            'events',
            'posting',
            'support',
            'reports',
            'profanity_monitor',
        ];
    }
    
    // For employers, get from database
    $CI->load->model('Rbac_model');

    $employer_id = (int) $CI->session->userdata('user_id');
    if ($employer_id > 0) {
        return $CI->Rbac_model->get_visible_pages_for_employer($employer_id);
    }

    // Fallback for legacy sessions that don't have employer user_id set.
    $employer_role = $CI->Rbac_model->get_role_by_name('employer');
    return $employer_role ? $CI->Rbac_model->get_visible_pages_for_role($employer_role->role_id) : [];
}

/**
 * Display a page link only if it's visible to current user
 *
 * @param string $page_slug - The page slug
 * @param string $label - The display label
 * @param string $url - The URL to link to
 * @param array $attributes - Additional HTML attributes
 * @return string - HTML anchor tag or empty string
 */
function visibility_link($page_slug = '', $label = '', $url = '', $attributes = [])
{
    if (!is_page_visible($page_slug)) {
        return '';
    }
    
    $attr_string = '';
    foreach ($attributes as $key => $value) {
        $attr_string .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
    }
    
    return '<a href="' . htmlspecialchars($url) . '"' . $attr_string . '>' . htmlspecialchars($label) . '</a>';
}

/**
 * Display navigation menu for employer admin panel
 *
 * @return void - Echoes the navigation HTML
 */
function render_employer_nav()
{
    $CI = &get_instance();
    $user_type = $CI->session->userdata('user_type');
    
    // Only render for employers
    if ($user_type !== 'employer') {
        return;
    }
    
    $visible_pages = get_visible_pages();
    $base_url = base_url();
    
    $nav = '<nav class="employer-nav">';
    
    // Job Posting
    if (in_array('job_posting', $visible_pages)) {
        $nav .= '<li><a href="' . $base_url . 'AdminJobPosting">Job Posting</a></li>';
    }
    
    // User Accounts
    if (in_array('user_accounts', $visible_pages)) {
        $nav .= '<li><a href="' . $base_url . 'AdminManageAccounts">User Accounts</a></li>';
    }
    
    // Alumni Officers
    if (in_array('alumni_officers', $visible_pages)) {
        $nav .= '<li><a href="' . $base_url . 'Officers">Alumni Officers</a></li>';
    }
    
    // Events
    if (in_array('events', $visible_pages)) {
        $nav .= '<li><a href="' . $base_url . 'Events">Events</a></li>';
    }
    
    // Posting
    if (in_array('posting', $visible_pages)) {
        $nav .= '<li><a href="' . $base_url . 'AdminPost">Posting</a></li>';
    }
    
    // Support
    if (in_array('support', $visible_pages)) {
        $nav .= '<li><a href="' . $base_url . 'AdminSupport">Support</a></li>';
    }
    
    // Reports
    if (in_array('reports', $visible_pages)) {
        $nav .= '<li><a href="' . $base_url . 'AdminReports">Reports</a></li>';
    }
    
    // Profanity Monitor
    if (in_array('profanity_monitor', $visible_pages)) {
        $nav .= '<li><a href="' . $base_url . 'Admin_profanity_monitor">Profanity Monitor</a></li>';
    }
    
    $nav .= '</nav>';
    
    echo $nav;
}
