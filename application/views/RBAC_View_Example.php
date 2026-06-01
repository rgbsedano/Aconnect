<?php
/**
 * Example RBAC Implementation in CodeIgniter 3 Views
 * 
 * This guide shows how to wrap sidebar and navigation items in PHP
 * conditionals so unauthorized users don't see them at all.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Load auth helper at the top of your view
$this->load->helper('auth');
?>

<!-- ===== EXAMPLE 1: SIDEBAR NAVIGATION WITH CONDITIONAL ITEMS ===== -->
<aside class="sidebar">
    <nav class="sidebar-nav">
        
        <!-- Item visible to all authenticated users -->
        <li class="sidebar-item">
            <a href="<?php echo base_url('dashboard'); ?>" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Item visible ONLY if user has specific permission -->
        <?php if (has_permission('view_employers_page')): ?>
        <li class="sidebar-item">
            <a href="<?php echo base_url('employers'); ?>" class="sidebar-link">
                <i class="fas fa-briefcase"></i>
                <span>Employers</span>
            </a>
        </li>
        <?php endif; ?>

        <!-- Item visible ONLY if user has specific role -->
        <?php if (has_role('admin')): ?>
        <li class="sidebar-item">
            <a href="<?php echo base_url('admin/dashboard'); ?>" class="sidebar-link">
                <i class="fas fa-shield-alt"></i>
                <span>Admin Panel</span>
            </a>
        </li>
        <?php endif; ?>

        <!-- Item visible to employers OR admins -->
        <?php if (has_any_permission(['manage_job_postings', 'view_employers_page'])): ?>
        <li class="sidebar-item">
            <a href="<?php echo base_url('jobs'); ?>" class="sidebar-link">
                <i class="fas fa-briefcase"></i>
                <span>Job Postings</span>
            </a>
        </li>
        <?php endif; ?>

        <!-- Item requiring ALL permissions -->
        <?php if (has_all_permissions(['manage_employers', 'view_reports'])): ?>
        <li class="sidebar-item">
            <a href="<?php echo base_url('admin/employer_reports'); ?>" class="sidebar-link">
                <i class="fas fa-chart-bar"></i>
                <span>Employer Reports</span>
            </a>
        </li>
        <?php endif; ?>

        <!-- Item hidden by admin settings -->
        <?php if (!is_hidden_by_admin('events_page')): ?>
        <li class="sidebar-item">
            <a href="<?php echo base_url('events'); ?>" class="sidebar-link">
                <i class="fas fa-calendar"></i>
                <span>Events</span>
            </a>
        </li>
        <?php endif; ?>

        <!-- Nested dropdown - show parent only if user has access to at least one child -->
        <?php if (has_any_permission(['view_reports', 'export_data', 'analytics'])): ?>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link dropdown-toggle">
                <i class="fas fa-chart-line"></i>
                <span>Reports</span>
            </a>
            <ul class="sidebar-submenu">
                
                <?php if (has_permission('view_reports')): ?>
                <li>
                    <a href="<?php echo base_url('admin/reports'); ?>">
                        <i class="fas fa-list"></i>
                        <span>View Reports</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (has_permission('export_data')): ?>
                <li>
                    <a href="<?php echo base_url('admin/export'); ?>">
                        <i class="fas fa-download"></i>
                        <span>Export Data</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (has_permission('analytics')): ?>
                <li>
                    <a href="<?php echo base_url('admin/analytics'); ?>">
                        <i class="fas fa-chart-pie"></i>
                        <span>Analytics</span>
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </li>
        <?php endif; ?>

    </nav>
</aside>

<!-- ===== EXAMPLE 2: ACTION BUTTONS AND MODALS ===== -->
<div class="content-area">
    <h1>Employer Management</h1>

    <!-- Edit button visible only to admins -->
    <?php if (has_permission('manage_employers')): ?>
    <button class="btn btn-primary" data-toggle="modal" data-target="#edit-employer-modal">
        <i class="fas fa-edit"></i> Edit Employer
    </button>
    <?php endif; ?>

    <!-- Delete button visible only to super admins -->
    <?php if (has_permission('delete_employers') && has_role('admin')): ?>
    <button class="btn btn-danger" onclick="confirm_delete_employer()">
        <i class="fas fa-trash"></i> Delete Employer
    </button>
    <?php endif; ?>

    <!-- Export button -->
    <?php if (has_permission('export_data')): ?>
    <button class="btn btn-secondary" onclick="export_employers()">
        <i class="fas fa-download"></i> Export
    </button>
    <?php endif; ?>
</div>

<!-- ===== EXAMPLE 3: ENTIRE SECTION VISIBILITY ===== -->
<div class="employers-section">
    
    <?php if (is_page_visible('employers_management')): ?>

        <section class="employer-list">
            <h2>Employer Directory</h2>
            
            <table class="employers-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        
                        <!-- Admin-only columns -->
                        <?php if (has_permission('manage_employers')): ?>
                        <th>Join Date</th>
                        <th>Verified</th>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employers as $employer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employer->company_name); ?></td>
                        <td><?php echo htmlspecialchars($employer->email); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $employer->is_verified ? 'success' : 'warning'; ?>">
                                <?php echo $employer->is_verified ? 'Verified' : 'Pending'; ?>
                            </span>
                        </td>

                        <?php if (has_permission('manage_employers')): ?>
                        <td><?php echo $employer->created_at; ?></td>
                        <td><?php echo $employer->verified_date ?? 'N/A'; ?></td>
                        <td>
                            <a href="<?php echo base_url('employers/edit/' . $employer->id); ?>" class="btn-sm btn-info">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            <?php if (has_permission('delete_employers')): ?>
                            <a href="#" onclick="delete_employer(<?php echo $employer->id; ?>)" class="btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

    <?php else: ?>
        <!-- Show message if section is hidden by admin -->
        <div class="alert alert-info">
            <p>This section is currently not available for your role.</p>
        </div>
    <?php endif; ?>

</div>

<!-- ===== EXAMPLE 4: ROLE-SPECIFIC CONTENT ===== -->
<div class="dashboard-cards">

    <!-- Admin dashboard -->
    <?php if (has_role('admin')): ?>
    <div class="card admin-stats">
        <h3>Admin Statistics</h3>
        <p>Total Users: <?php echo $total_users; ?></p>
        <p>Pending Approvals: <?php echo $pending_approvals; ?></p>
    </div>
    <?php endif; ?>

    <!-- Employer dashboard -->
    <?php if (has_role('employer')): ?>
    <div class="card employer-stats">
        <h3>Your Job Postings</h3>
        <p>Active: <?php echo $active_postings; ?></p>
        <p>Closed: <?php echo $closed_postings; ?></p>
        <a href="<?php echo base_url('jobs/create'); ?>" class="btn btn-primary">Post New Job</a>
    </div>
    <?php endif; ?>

    <!-- Alumni dashboard -->
    <?php if (has_role('alumni')): ?>
    <div class="card alumni-stats">
        <h3>My Profile</h3>
        <a href="<?php echo base_url('profile'); ?>" class="btn btn-primary">View My Profile</a>
        <a href="<?php echo base_url('jobs'); ?>" class="btn btn-secondary">Browse Jobs</a>
    </div>
    <?php endif; ?>

</div>

<!-- ===== EXAMPLE 5: TOP NAVIGATION BAR ===== -->
<nav class="topbar">
    <div class="topbar-menu">
        
        <!-- Always visible -->
        <a href="<?php echo base_url('dashboard'); ?>" class="topbar-item">Home</a>

        <!-- Conditional items -->
        <?php if (has_permission('view_employers_page')): ?>
        <a href="<?php echo base_url('employers'); ?>" class="topbar-item">Employers</a>
        <?php endif; ?>

        <?php if (has_role('admin')): ?>
        <a href="<?php echo base_url('admin/dashboard'); ?>" class="topbar-item">Admin</a>
        <?php endif; ?>

        <!-- User menu with conditional items -->
        <div class="user-menu dropdown">
            <button class="topbar-item dropdown-toggle">
                <?php echo $this->session->userdata('first_name'); ?>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?php echo base_url('profile'); ?>">My Profile</a></li>
                <?php if (has_permission('account_settings')): ?>
                <li><a href="<?php echo base_url('settings/account'); ?>">Settings</a></li>
                <?php endif; ?>
                <li><a href="<?php echo base_url('auth/logout'); ?>">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ===== EXAMPLE 6: CONDITIONAL JAVASCRIPT DATA ===== -->
<script>
    // Store user permissions in JavaScript (useful for client-side logic)
    const userPermissions = {
        viewEmployers: <?php echo json_encode(has_permission('view_employers_page')); ?>,
        manageEmployers: <?php echo json_encode(has_permission('manage_employers')); ?>,
        exportData: <?php echo json_encode(has_permission('export_data')); ?>,
        isAdmin: <?php echo json_encode(has_role('admin')); ?>,
        currentRole: '<?php echo htmlspecialchars(current_role()); ?>'
    };

    // Example: Show/hide UI elements based on permissions
    if (userPermissions.manageEmployers) {
        document.getElementById('admin-actions').style.display = 'block';
    }
</script>
