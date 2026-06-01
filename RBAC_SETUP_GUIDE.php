<?php
/**
 * RBAC Setup & SQL Seed Guide
 * 
 * This file provides SQL commands to set up initial roles and permissions
 * Run these after running the migrations.
 */

// =====================================================================
// SEED DATA FOR ROLES
// =====================================================================

/*
INSERT INTO `roles` (`role_id`, `role_name`, `description`, `created_at`) VALUES
(1, 'admin', 'Administrator with full access', '2024-01-01 00:00:00'),
(2, 'employer', 'Employer account', '2024-01-01 00:00:00'),
(3, 'alumni', 'Alumni member account', '2024-01-01 00:00:00'),
(4, 'moderator', 'Forum and content moderator', '2024-01-01 00:00:00'),
(5, 'guest', 'Guest user with limited access', '2024-01-01 00:00:00');
*/

// =====================================================================
// SEED DATA FOR PERMISSIONS
// =====================================================================

/*
-- Admin Permissions
INSERT INTO `permissions` (`permission_slug`, `permission_name`, `description`) VALUES
('manage_users', 'Manage Users', 'Create, edit, delete user accounts'),
('manage_roles', 'Manage Roles', 'Create and modify user roles'),
('view_reports', 'View Reports', 'Access all system reports'),
('export_data', 'Export Data', 'Export system data to files'),
('manage_settings', 'Manage Settings', 'Access system settings and configuration'),
('view_activity_log', 'View Activity Log', 'View system activity and audit logs'),
('manage_employers', 'Manage Employers', 'Create, edit, delete employer accounts'),
('delete_employers', 'Delete Employers', 'Permanently delete employer accounts'),

-- Employer Permissions
('manage_job_postings', 'Manage Job Postings', 'Create and manage job postings'),
('view_applicants', 'View Applicants', 'View job applicants'),
('view_employers_page', 'View Employers Page', 'Can see employers section'),
('access_dashboard', 'Access Dashboard', 'Can access main dashboard'),

-- Alumni Permissions
('view_jobs', 'View Jobs', 'View available job postings'),
('apply_jobs', 'Apply for Jobs', 'Apply to job postings'),
('update_profile', 'Update Profile', 'Update personal profile'),
('access_network', 'Access Network', 'Access alumni network'),
('access_forum', 'Access Forum', 'Post and comment in forums'),

-- Moderator Permissions
('moderate_forum', 'Moderate Forum', 'Moderate forum posts and comments'),
('manage_comments', 'Manage Comments', 'Delete inappropriate comments'),
('ban_users', 'Ban Users', 'Temporarily or permanently ban users'),

-- Global Permissions
('account_settings', 'Account Settings', 'Access personal account settings'),
('contact_support', 'Contact Support', 'Submit support tickets');
*/

// =====================================================================
// SEED DATA FOR ROLE-PERMISSIONS (Mapping)
// =====================================================================

/*
-- Admin gets ALL permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),  -- manage_users
(1, 2),  -- manage_roles
(1, 3),  -- view_reports
(1, 4),  -- export_data
(1, 5),  -- manage_settings
(1, 6),  -- view_activity_log
(1, 7),  -- manage_employers
(1, 8),  -- delete_employers
(1, 9),  -- manage_job_postings
(1, 10), -- view_applicants
(1, 11), -- view_employers_page
(1, 12), -- access_dashboard
(1, 13), -- view_jobs
(1, 14), -- apply_jobs
(1, 15), -- update_profile
(1, 16), -- access_network
(1, 17), -- access_forum
(1, 18), -- moderate_forum
(1, 19), -- manage_comments
(1, 20), -- ban_users
(1, 21), -- account_settings
(1, 22), -- contact_support

-- Employer permissions
(2, 9),  -- manage_job_postings
(2, 10), -- view_applicants
(2, 11), -- view_employers_page
(2, 12), -- access_dashboard
(2, 13), -- view_jobs (can view but not apply)
(2, 21), -- account_settings
(2, 22), -- contact_support

-- Alumni permissions
(3, 12), -- access_dashboard
(3, 13), -- view_jobs
(3, 14), -- apply_jobs
(3, 15), -- update_profile
(3, 16), -- access_network
(3, 17), -- access_forum
(3, 21), -- account_settings
(3, 22), -- contact_support

-- Moderator permissions
(4, 3),  -- view_reports
(4, 17), -- access_forum
(4, 18), -- moderate_forum
(4, 19), -- manage_comments
(4, 20), -- ban_users
(4, 21), -- account_settings
(4, 22), -- contact_support

-- Guest permissions (minimal)
(5, 12), -- access_dashboard
(5, 13), -- view_jobs
(5, 21), -- account_settings
(5, 22), -- contact_support
*/

// =====================================================================
// SEED DATA FOR PAGE VISIBILITY (Admin Controls)
// =====================================================================

/*
-- By default, all pages are visible (is_visible = 1)
-- Only insert rows when you want to HIDE a page from a role

-- Example: Hide employers page from alumni
INSERT INTO `page_visibility_settings` (`page_slug`, `role_id`, `is_visible`) VALUES
('employers_management', 3, 0),  -- Hide from alumni (role_id 3)

-- Example: Hide events page from employers
('events_page', 2, 0),  -- Hide from employers (role_id 2)

-- Example: Hide advanced analytics from non-admin
('advanced_analytics', 2, 0), -- Hide from employers
('advanced_analytics', 3, 0); -- Hide from alumni
*/

// =====================================================================
// SQL QUERIES TO VERIFY SETUP
// =====================================================================

/*
-- Check roles
SELECT * FROM roles;

-- Check permissions
SELECT * FROM permissions;

-- Check role-permission mappings
SELECT r.role_name, p.permission_slug 
FROM role_permissions rp
JOIN roles r ON r.role_id = rp.role_id
JOIN permissions p ON p.permission_id = rp.permission_id
ORDER BY r.role_name, p.permission_slug;

-- Check page visibility
SELECT * FROM page_visibility_settings WHERE is_visible = 0;

-- Check user roles
SELECT users.id, users.email, roles.role_name 
FROM users
LEFT JOIN roles ON users.role_id = roles.role_id;
*/

// =====================================================================
// UPDATE EXISTING USERS WITH ROLES
// =====================================================================

/*
-- Set all existing users to 'alumni' role
UPDATE users SET role_id = 3 WHERE role_id IS NULL;

-- Set specific users to 'admin'
UPDATE users SET role_id = 1 WHERE email = 'admin@example.com';

-- Set specific users to 'employer'
UPDATE users SET role_id = 2 WHERE user_type = 'employer';
*/

?>
