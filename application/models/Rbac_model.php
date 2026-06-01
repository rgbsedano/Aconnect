<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RBAC Model
 * 
 * Handles all database operations for Role-Based Access Control
 * Used in admin panels and backend logic
 */
class Rbac_model extends CI_Model {

    // ================================================================
    // ROLE MANAGEMENT
    // ================================================================

    /**
     * Get all roles
     *
     * @return array Array of role objects
     */
    public function get_all_roles()
    {
        $this->db->order_by('role_id', 'ASC');
        return $this->db->get('roles')->result();
    }

    /**
     * Get role by ID
     *
     * @param int $role_id
     * @return object|NULL
     */
    public function get_role($role_id)
    {
        $this->db->where('role_id', $role_id);
        $query = $this->db->get('roles');
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Get role by name
     *
     * @param string $role_name
     * @return object|NULL
     */
    public function get_role_by_name($role_name)
    {
        $this->db->where('role_name', $role_name);
        $query = $this->db->get('roles');
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Create a new role
     *
     * @param string $role_name
     * @param string $description
     * @return int Role ID
     */
    public function create_role($role_name, $description = '')
    {
        $data = [
            'role_name' => $role_name,
            'description' => $description,
        ];

        $this->db->insert('roles', $data);
        return $this->db->insert_id();
    }

    /**
     * Update a role
     *
     * @param int $role_id
     * @param array $data
     * @return bool
     */
    public function update_role($role_id, $data)
    {
        $this->db->where('role_id', $role_id);
        return $this->db->update('roles', $data);
    }

    /**
     * Delete a role (WARNING: This deletes permissions mappings too)
     *
     * @param int $role_id
     * @return bool
     */
    public function delete_role($role_id)
    {
        // Delete role_permissions first due to foreign key
        $this->db->where('role_id', $role_id);
        $this->db->delete('role_permissions');

        // Then delete the role
        $this->db->where('role_id', $role_id);
        return $this->db->delete('roles');
    }

    // ================================================================
    // PERMISSION MANAGEMENT
    // ================================================================

    /**
     * Get all permissions
     *
     * @return array Array of permission objects
     */
    public function get_all_permissions()
    {
        $this->db->order_by('permission_slug', 'ASC');
        return $this->db->get('permissions')->result();
    }

    /**
     * Get permission by ID
     *
     * @param int $permission_id
     * @return object|NULL
     */
    public function get_permission($permission_id)
    {
        $this->db->where('permission_id', $permission_id);
        $query = $this->db->get('permissions');
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Get permission by slug
     *
     * @param string $permission_slug
     * @return object|NULL
     */
    public function get_permission_by_slug($permission_slug)
    {
        $this->db->where('permission_slug', $permission_slug);
        $query = $this->db->get('permissions');
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Create a new permission
     *
     * @param string $permission_slug
     * @param string $permission_name
     * @param string $description
     * @return int Permission ID
     */
    public function create_permission($permission_slug, $permission_name, $description = '')
    {
        $data = [
            'permission_slug' => $permission_slug,
            'permission_name' => $permission_name,
            'description' => $description,
        ];

        $this->db->insert('permissions', $data);
        return $this->db->insert_id();
    }

    /**
     * Update a permission
     *
     * @param int $permission_id
     * @param array $data
     * @return bool
     */
    public function update_permission($permission_id, $data)
    {
        $this->db->where('permission_id', $permission_id);
        return $this->db->update('permissions', $data);
    }

    /**
     * Delete a permission (WARNING: This removes from all roles)
     *
     * @param int $permission_id
     * @return bool
     */
    public function delete_permission($permission_id)
    {
        // Delete from role_permissions first
        $this->db->where('permission_id', $permission_id);
        $this->db->delete('role_permissions');

        // Then delete the permission
        $this->db->where('permission_id', $permission_id);
        return $this->db->delete('permissions');
    }

    // ================================================================
    // ROLE-PERMISSION MAPPING
    // ================================================================

    /**
     * Get all permissions for a role
     *
     * @param int $role_id
     * @return array Array of permission objects
     */
    public function get_role_permissions($role_id)
    {
        $this->db->select('p.*');
        $this->db->from('role_permissions rp');
        $this->db->join('permissions p', 'p.permission_id = rp.permission_id');
        $this->db->where('rp.role_id', $role_id);
        $this->db->order_by('p.permission_slug', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get permission IDs for a role
     *
     * @param int $role_id
     * @return array Array of permission IDs
     */
    public function get_role_permission_ids($role_id)
    {
        $this->db->select('permission_id');
        $this->db->from('role_permissions');
        $this->db->where('role_id', $role_id);
        $query = $this->db->get();

        $ids = [];
        foreach ($query->result() as $row) {
            $ids[] = $row->permission_id;
        }

        return $ids;
    }

    /**
     * Assign a permission to a role
     *
     * @param int $role_id
     * @param int $permission_id
     * @return bool
     */
    public function assign_permission($role_id, $permission_id)
    {
        // Check if already assigned
        $this->db->where('role_id', $role_id);
        $this->db->where('permission_id', $permission_id);
        $query = $this->db->get('role_permissions');

        if ($query->num_rows() > 0) {
            return TRUE;  // Already exists
        }

        $data = [
            'role_id' => $role_id,
            'permission_id' => $permission_id,
        ];

        return $this->db->insert('role_permissions', $data);
    }

    /**
     * Revoke a permission from a role
     *
     * @param int $role_id
     * @param int $permission_id
     * @return bool
     */
    public function revoke_permission($role_id, $permission_id)
    {
        $this->db->where('role_id', $role_id);
        $this->db->where('permission_id', $permission_id);
        return $this->db->delete('role_permissions');
    }

    /**
     * Assign multiple permissions to a role (clears existing)
     *
     * @param int $role_id
     * @param array $permission_ids Array of permission IDs
     * @return bool
     */
    public function assign_multiple_permissions($role_id, $permission_ids = [])
    {
        // Clear existing permissions
        $this->db->where('role_id', $role_id);
        $this->db->delete('role_permissions');

        // Assign new permissions
        if (count($permission_ids) > 0) {
            foreach ($permission_ids as $permission_id) {
                $this->assign_permission($role_id, $permission_id);
            }
        }

        return TRUE;
    }

    // ================================================================
    // PAGE VISIBILITY SETTINGS
    // ================================================================

    /**
     * Get all visibility settings
     *
     * @return array Array of visibility setting objects
     */
    public function get_all_visibility_settings()
    {
        $this->db->order_by('page_slug', 'ASC');
        $this->db->order_by('role_id', 'ASC');
        return $this->db->get('page_visibility_settings')->result();
    }

    /**
     * Get visibility settings for a specific page and role
     *
     * @param string $page_slug
     * @param int $role_id
     * @return object|NULL
     */
    public function get_visibility_setting($page_slug, $role_id)
    {
        $this->db->where('page_slug', $page_slug);
        $this->db->where('role_id', $role_id);
        $query = $this->db->get('page_visibility_settings');
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Get all roles' visibility for a page
     *
     * @param string $page_slug
     * @return array
     */
    public function get_page_visibility_by_role($page_slug)
    {
        $this->db->where('page_slug', $page_slug);
        $this->db->order_by('role_id', 'ASC');
        return $this->db->get('page_visibility_settings')->result();
    }

    /**
     * Set page visibility for a role
     *
     * @param string $page_slug
     * @param int $role_id
     * @param bool $is_visible
     * @return bool
     */
    public function set_page_visibility($page_slug, $role_id, $is_visible = TRUE)
    {
        $setting = $this->get_visibility_setting($page_slug, $role_id);

        if ($setting === NULL) {
            // Create new setting
            $data = [
                'page_slug' => $page_slug,
                'role_id' => $role_id,
                'is_visible' => (int) $is_visible,
            ];
            return $this->db->insert('page_visibility_settings', $data);
        } else {
            // Update existing setting
            $this->db->where('page_slug', $page_slug);
            $this->db->where('role_id', $role_id);
            return $this->db->update('page_visibility_settings', ['is_visible' => (int) $is_visible]);
        }
    }

    /**
     * Hide a page from a specific role
     *
     * @param string $page_slug
     * @param int $role_id
     * @return bool
     */
    public function hide_page_from_role($page_slug, $role_id)
    {
        return $this->set_page_visibility($page_slug, $role_id, FALSE);
    }

    /**
     * Show a page to a specific role
     *
     * @param string $page_slug
     * @param int $role_id
     * @return bool
     */
    public function show_page_to_role($page_slug, $role_id)
    {
        return $this->set_page_visibility($page_slug, $role_id, TRUE);
    }

    // ================================================================
    // USER & ROLE ASSIGNMENT
    // ================================================================

    /**
     * Assign a role to a user
     *
     * @param int $user_id
     * @param int $role_id
     * @return bool
     */
    public function assign_user_role($user_id, $role_id)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', ['role_id' => $role_id]);
    }

    /**
     * Get users by role
     *
     * @param int $role_id
     * @return array Array of user objects
     */
    public function get_users_by_role($role_id)
    {
        $this->db->where('role_id', $role_id);
        $this->db->order_by('first_name', 'ASC');
        return $this->db->get('users')->result();
    }

    /**
     * Get user count by role
     *
     * @param int $role_id
     * @return int
     */
    public function get_users_count_by_role($role_id)
    {
        $this->db->where('role_id', $role_id);
        return $this->db->count_all_results('users');
    }

    /**
     * Get user's role information
     *
     * @param int $user_id
     * @return object|NULL
     */
    public function get_user_role($user_id)
    {
        $this->db->select('r.*');
        $this->db->from('users u');
        $this->db->join('roles r', 'u.role_id = r.role_id', 'left');
        $this->db->where('u.id', $user_id);
        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Check if a page is visible for a specific role
     *
     * @param string $page_slug
     * @param int $role_id
     * @return bool TRUE if visible, FALSE if hidden or not found
     */
    public function is_page_visible($page_slug, $role_id)
    {
        $setting = $this->get_visibility_setting($page_slug, $role_id);
        
        // If no setting exists, check defaults
        if ($setting === NULL) {
            // Get the role to check if it's employer role
            $role = $this->get_role($role_id);
            
            if ($role && strtolower($role->role_name) === 'employer') {
                // For employers: show job_posting by default, hide others
                if ($page_slug === 'job_posting') {
                    return TRUE;
                }
                return FALSE;
            }
            
            // For admins: show everything by default
            $admin_role = $this->get_role_by_name('administrator');
            if ($admin_role && $admin_role->role_id === $role_id) {
                return TRUE;
            }
            
            return FALSE;
        }
        
        return (bool) $setting->is_visible;
    }

    /**
     * Get visible pages for a role
     *
     * @param int $role_id
     * @return array Array of visible page slugs
     */
    public function get_visible_pages_for_role($role_id)
    {
        $this->db->select('page_slug');
        $this->db->where('role_id', $role_id);
        $this->db->where('is_visible', 1);
        $query = $this->db->get('page_visibility_settings');
        
        $pages = [];
        foreach ($query->result() as $row) {
            $pages[] = $row->page_slug;
        }
        
        return $pages;
    }

    // ================================================================
    // EMPLOYER PAGE VISIBILITY SETTINGS
    // ================================================================

    /**
     * Get visibility settings for a specific page and employer
     *
     * @param string $page_slug
     * @param int $employer_id
     * @return object|NULL
     */
    public function get_employer_visibility_setting($page_slug, $employer_id)
    {
        $this->db->where('page_slug', $page_slug);
        $this->db->where('employer_id', $employer_id);
        $query = $this->db->get('employer_page_visibility');
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Set page visibility for an employer
     *
     * @param string $page_slug
     * @param int $employer_id
     * @param bool $is_visible
     * @return bool
     */
    public function set_employer_page_visibility($page_slug, $employer_id, $is_visible = TRUE)
    {
        $setting = $this->get_employer_visibility_setting($page_slug, $employer_id);

        if ($setting === NULL) {
            // Create new setting
            $data = [
                'page_slug' => $page_slug,
                'employer_id' => $employer_id,
                'is_visible' => (int) $is_visible,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            return $this->db->insert('employer_page_visibility', $data);
        } else {
            // Update existing setting
            $this->db->where('page_slug', $page_slug);
            $this->db->where('employer_id', $employer_id);
            return $this->db->update('employer_page_visibility', [
                'is_visible' => (int) $is_visible,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Get visible pages for a specific employer
     *
     * @param int $employer_id
     * @return array Array of visible page slugs
     */
    public function get_visible_pages_for_employer($employer_id)
    {
        $this->db->select('page_slug');
        $this->db->where('employer_id', (int) $employer_id);
        $this->db->where('is_visible', 1);
        $query = $this->db->get('employer_page_visibility');

        $pages = [];
        foreach ($query->result() as $row) {
            $pages[] = $row->page_slug;
        }

        return $pages;
    }

    // ================================================================
    // STATISTICS & REPORTING
    // ================================================================

    /**
     * Get RBAC statistics
     *
     * @return array
     */
    public function get_statistics()
    {
        $total_roles = $this->db->count_all('roles');
        $total_permissions = $this->db->count_all('permissions');
        
        $this->db->select('role_id, COUNT(*) as user_count');
        $this->db->from('users');
        $this->db->group_by('role_id');
        $users_by_role = $this->db->get()->result_array();

        return [
            'total_roles' => $total_roles,
            'total_permissions' => $total_permissions,
            'users_by_role' => $users_by_role,
        ];
    }

    // ================================================================
    // EMPLOYER GROUP MANAGEMENT
    // ================================================================

    /**
     * Get all employer groups
     *
     * @return array Array of group objects
     */
    public function get_all_employer_groups()
    {
        $this->db->order_by('group_name', 'ASC');
        $groups = $this->db->get('employer_groups')->result();

        // Add member count to each group
        foreach ($groups as $group) {
            $member_count = $this->db->where('group_id', $group->id)
                ->get('employer_group_assignments')
                ->num_rows();
            $group->member_count = $member_count;
        }

        return $groups;
    }

    /**
     * Get employer group by ID
     *
     * @param int $group_id
     * @return object|NULL
     */
    public function get_employer_group($group_id)
    {
        $this->db->where('id', $group_id);
        $query = $this->db->get('employer_groups');
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Create a new employer group
     *
     * @param string $group_name
     * @param string $description
     * @return int Group ID
     */
    public function create_employer_group($group_name, $description = '')
    {
        $data = [
            'group_name' => $group_name,
            'description' => $description,
        ];
        $this->db->insert('employer_groups', $data);
        return $this->db->insert_id();
    }

    /**
     * Update employer group
     *
     * @param int $group_id
     * @param array $data
     * @return bool
     */
    public function update_employer_group($group_id, $data)
    {
        $this->db->where('id', $group_id);
        return $this->db->update('employer_groups', $data);
    }

    /**
     * Delete employer group
     *
     * @param int $group_id
     * @return bool
     */
    public function delete_employer_group($group_id)
    {
        // Delete assignments first
        $this->db->where('group_id', $group_id);
        $this->db->delete('employer_group_assignments');

        // Delete the group
        $this->db->where('id', $group_id);
        return $this->db->delete('employer_groups');
    }

    /**
     * Get employers in a group
     *
     * @param int $group_id
     * @return array Array of employer objects
     */
    public function get_employers_in_group($group_id)
    {
        $this->db->select('e.*');
        $this->db->from('employers e');
        $this->db->join('employer_group_assignments ega', 'e.id = ega.employer_id');
        $this->db->where('ega.group_id', $group_id);
        $this->db->order_by('e.company_name', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get groups for an employer
     *
     * @param int $employer_id
     * @return array Array of group objects
     */
    public function get_employer_groups_for_employer($employer_id)
    {
        $this->db->select('eg.*');
        $this->db->from('employer_groups eg');
        $this->db->join('employer_group_assignments ega', 'eg.id = ega.group_id');
        $this->db->where('ega.employer_id', $employer_id);
        $this->db->order_by('eg.group_name', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Assign employer to a group
     *
     * @param int $employer_id
     * @param int $group_id
     * @return bool
     */
    public function assign_employer_to_group($employer_id, $group_id)
    {
        // Check if already assigned
        $this->db->where('employer_id', $employer_id);
        $this->db->where('group_id', $group_id);
        $query = $this->db->get('employer_group_assignments');

        if ($query->num_rows() > 0) {
            return TRUE;
        }

        $data = [
            'employer_id' => $employer_id,
            'group_id' => $group_id,
        ];
        return $this->db->insert('employer_group_assignments', $data);
    }

    /**
     * Remove employer from a group
     *
     * @param int $employer_id
     * @param int $group_id
     * @return bool
     */
    public function remove_employer_from_group($employer_id, $group_id)
    {
        $this->db->where('employer_id', $employer_id);
        $this->db->where('group_id', $group_id);
        return $this->db->delete('employer_group_assignments');
    }

    /**
     * Check if employer is in a group
     *
     * @param int $employer_id
     * @param int $group_id
     * @return bool
     */
    public function is_employer_in_group($employer_id, $group_id)
    {
        $this->db->where('employer_id', $employer_id);
        $this->db->where('group_id', $group_id);
        $query = $this->db->get('employer_group_assignments');
        return $query->num_rows() > 0 ? TRUE : FALSE;
    }

    /**
     * Get all employers NOT in a group (for assignment)
     *
     * @param int $group_id
     * @return array Array of employer objects
     */
    public function get_employers_not_in_group($group_id)
    {
        $this->db->select('e.*');
        $this->db->from('employers e');
        $this->db->where('e.id NOT IN (
            SELECT employer_id FROM employer_group_assignments WHERE group_id = ' . $this->db->escape($group_id) . '
        )', NULL, FALSE);
        $this->db->order_by('e.company_name', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get employers visible to another employer (based on group membership)
     * Returns: Own ID + IDs of all employers in the same group(s)
     *
     * @param int $employer_id
     * @return array Array of visible employer IDs
     */
    public function get_visible_employer_ids($employer_id)
    {
        // Get all groups this employer is in
        $employer_groups = $this->db->select('group_id')
                                    ->from('employer_group_assignments')
                                    ->where('employer_id', $employer_id)
                                    ->get()
                                    ->result();

        $group_ids = [];
        foreach ($employer_groups as $group) {
            $group_ids[] = $group->group_id;
        }

        // If no groups, only return own ID
        if (empty($group_ids)) {
            return [$employer_id];
        }

        // Get all employers in those groups
        $this->db->select('DISTINCT employer_id');
        $this->db->from('employer_group_assignments');
        $this->db->where_in('group_id', $group_ids);
        $employers = $this->db->get()->result();

        $visible_ids = [$employer_id];
        foreach ($employers as $emp) {
            $visible_ids[] = $emp->employer_id;
        }

        return array_unique($visible_ids);
    }
}
