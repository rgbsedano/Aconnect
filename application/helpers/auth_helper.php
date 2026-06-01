<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Helper for Role-Based Access Control (RBAC)
 * 
 * Provides utility functions to check user permissions and roles.
 * PHP 7.4+ compatible for CodeIgniter 3
 */

// ============================================
// CORE PERMISSION CHECK
// ============================================

/**
 * Check if the current user has a specific permission
 *
 * @param string $permission_slug The permission slug to check (e.g., 'view_employers_page')
 * @return bool TRUE if user has permission, FALSE otherwise
 */
function has_permission($permission_slug = '')
{
    $CI = &get_instance();

    // Check if user is logged in
    if (!$CI->session->userdata('alumni_id') && !$CI->session->userdata('employer_id')) {
        return FALSE;
    }

    $user_id = $CI->session->userdata('alumni_id') ?? $CI->session->userdata('employer_id');
    $role_id = $CI->session->userdata('role_id');

    // If role_id is not in session, fetch from database
    if (!$role_id && $user_id) {
        $CI->db->select('role_id');
        $CI->db->from('users');
        $CI->db->where('id', $user_id);
        $query = $CI->db->get();

        if ($query->num_rows() > 0) {
            $role_id = $query->row()->role_id;
            $CI->session->set_userdata('role_id', $role_id);
        } else {
            return FALSE;
        }
    }

    // Empty permission slug means just check if logged in
    if (empty($permission_slug)) {
        return (bool) $role_id;
    }

    // Query the database to check permission
    $CI->db->select('rp.permission_id');
    $CI->db->from('role_permissions rp');
    $CI->db->join('permissions p', 'p.permission_id = rp.permission_id');
    $CI->db->where('rp.role_id', $role_id);
    $CI->db->where('p.permission_slug', $permission_slug);
    $query = $CI->db->get();

    return $query->num_rows() > 0;
}

// ============================================
// ROLE CHECKS
// ============================================

/**
 * Check if the current user has a specific role
 *
 * @param string $role_name The role name to check (e.g., 'admin', 'employer', 'alumni')
 * @return bool TRUE if user has the role, FALSE otherwise
 */
function has_role($role_name = '')
{
    $CI = &get_instance();

    $role_id = $CI->session->userdata('role_id');

    if (!$role_id) {
        return FALSE;
    }

    $CI->db->select('role_id');
    $CI->db->from('roles');
    $CI->db->where('role_id', $role_id);
    $CI->db->where('role_name', $role_name);
    $query = $CI->db->get();

    return $query->num_rows() > 0;
}

/**
 * Get the current user's role name
 *
 * @return string|NULL The role name or NULL if not found
 */
function current_role()
{
    $CI = &get_instance();
    
    $role_id = $CI->session->userdata('role_id');

    if (!$role_id) {
        return NULL;
    }

    $CI->db->select('role_name');
    $CI->db->from('roles');
    $CI->db->where('role_id', $role_id);
    $query = $CI->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->role_name;
    }

    return NULL;
}

// ============================================
// PAGE VISIBILITY CHECKS
// ============================================

/**
 * Check if a page should be visible to the current user
 * Used in conjunction with admin settings to hide pages from specific roles
 *
 * @param string $page_slug The page slug (e.g., 'employers_dashboard')
 * @return bool TRUE if page is visible, FALSE otherwise
 */
function is_page_visible($page_slug = '')
{
    $CI = &get_instance();

    $role_id = $CI->session->userdata('role_id');

    if (!$role_id || empty($page_slug)) {
        return FALSE;
    }

    // Query admin settings for page visibility
    $CI->db->select('is_visible');
    $CI->db->from('page_visibility_settings');
    $CI->db->where('page_slug', $page_slug);
    $CI->db->where('role_id', $role_id);
    $query = $CI->db->get();

    if ($query->num_rows() > 0) {
        return (bool) $query->row()->is_visible;
    }

    // Default to visible if not explicitly set
    return TRUE;
}

/**
 * Get the list of all permissions for a role
 *
 * @param int $role_id The role ID
 * @return array Array of permission slugs
 */
function get_role_permissions($role_id = NULL)
{
    $CI = &get_instance();

    if ($role_id === NULL) {
        $role_id = $CI->session->userdata('role_id');
    }

    if (!$role_id) {
        return [];
    }

    $CI->db->select('p.permission_slug');
    $CI->db->from('role_permissions rp');
    $CI->db->join('permissions p', 'p.permission_id = rp.permission_id');
    $CI->db->where('rp.role_id', $role_id);
    $query = $CI->db->get();

    $permissions = [];
    foreach ($query->result() as $row) {
        $permissions[] = $row->permission_slug;
    }

    return $permissions;
}

/**
 * Check if user has ANY of the provided permissions
 *
 * @param array $permissions Array of permission slugs
 * @return bool TRUE if user has at least one permission, FALSE otherwise
 */
function has_any_permission($permissions = [])
{
    if (!is_array($permissions) || count($permissions) === 0) {
        return FALSE;
    }

    foreach ($permissions as $permission) {
        if (has_permission($permission)) {
            return TRUE;
        }
    }

    return FALSE;
}

/**
 * Check if user has ALL of the provided permissions
 *
 * @param array $permissions Array of permission slugs
 * @return bool TRUE if user has all permissions, FALSE otherwise
 */
function has_all_permissions($permissions = [])
{
    if (!is_array($permissions) || count($permissions) === 0) {
        return FALSE;
    }

    foreach ($permissions as $permission) {
        if (!has_permission($permission)) {
            return FALSE;
        }
    }

    return TRUE;
}

// ============================================
// ADMIN CONTROLS
// ============================================

/**
 * Check if an admin has marked a page as invisible for a specific role
 * 
 * @param string $page_slug Page identifier
 * @param int $role_id Role to check
 * @return bool TRUE if admin has hidden this page from this role
 */
function is_hidden_by_admin($page_slug = '', $role_id = NULL)
{
    $CI = &get_instance();

    if (empty($page_slug)) {
        return FALSE;
    }

    if ($role_id === NULL) {
        $role_id = $CI->session->userdata('role_id');
    }

    $CI->db->select('id');
    $CI->db->from('page_visibility_settings');
    $CI->db->where('page_slug', $page_slug);
    $CI->db->where('role_id', $role_id);
    $CI->db->where('is_visible', 0);
    $query = $CI->db->get();

    return $query->num_rows() > 0;
}
