<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load CSS
$this->load->view('__header');
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #a12124;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 8px;
    }

    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px 24px;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-actions {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .header-actions-left {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .header-actions-right {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .selector-panel {
        background: white;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        border: 1px solid #f1f5f9;
    }

    .selector-label {
        display: block;
        font-weight: 800;
        margin-bottom: 12px;
        color: var(--text-main);
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .employer-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        background: white;
        color: var(--text-main);
        cursor: pointer;
        transition: var(--transition);
        font-weight: 500;
    }

    .employer-select:hover {
        border-color: var(--accent-red);
        box-shadow: 0 0 0 4px rgba(161, 33, 36, 0.1);
    }

    .employer-select:focus {
        outline: none;
        border-color: var(--accent-red);
        box-shadow: 0 0 0 4px rgba(161, 33, 36, 0.1);
    }

    .visibility-matrix {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        border: 1px solid #f1f5f9;
    }

    .employer-info {
        padding: 20px 25px;
        background: #f8f9fa;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .employer-info-details h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
    }

    .employer-info-details p {
        margin: 4px 0 0 0;
        color: var(--text-muted);
        font-size: 13px;
    }

    .employer-info-stats {
        display: flex;
        gap: 30px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 22px;
        font-weight: 700;
        color: var(--accent-red);
    }

    .stat-label {
        display: block;
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pages-list {
        padding: 0;
    }

    .page-item {
        padding: 18px 25px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition);
    }

    .page-item:last-child {
        border-bottom: none;
    }

    .page-item:hover {
        background-color: #f8f9fa;
    }

    .page-info {
        flex: 1;
    }

    .page-name {
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 4px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-name i {
        color: var(--accent-red);
        width: 18px;
    }

    .page-description {
        font-size: 13px;
        color: var(--text-muted);
        margin: 0;
    }

    .visibility-toggle {
        display: inline-block;
        position: relative;
        margin-left: 20px;
    }

    .visibility-toggle input {
        display: none;
    }

    .toggle-switch {
        display: inline-block;
        width: 54px;
        height: 28px;
        background-color: #ddd;
        border-radius: 14px;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
    }

    .toggle-switch::before {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: white;
        top: 2px;
        left: 2px;
        transition: var(--transition);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .visibility-toggle input:checked + .toggle-switch {
        background-color: #10b981;
    }

    .visibility-toggle input:checked + .toggle-switch::before {
        left: 28px;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: var(--transition);
    }

    .status-visible {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-hidden {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .status-active {
        display: inline-block;
        background: #dcfce7;
        color: #166534;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        user-select: none;
    }

    .status-active:hover {
        background: #bbf7d0;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
    }

    .status-inactive {
        display: inline-block;
        background: #fee2e2;
        color: #991b1b;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        user-select: none;
    }

    .status-inactive:hover {
        background: #fecaca;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);
    }

    .status-suspended {
        display: inline-block;
        background: #fef3c7;
        color: #92400e;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        user-select: none;
    }

    .status-suspended:hover {
        background: #fde68a;
        box-shadow: 0 2px 8px rgba(180, 83, 9, 0.2);
    }

    /* Status Dropdown Menu */
    .status-dropdown-menu {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        z-index: 1050;
        min-width: 200px;
        overflow: hidden;
    }

    .status-dropdown-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-main);
        font-size: 14px;
        font-weight: 500;
    }

    .status-dropdown-item:last-child {
        border-bottom: none;
    }

    .status-dropdown-item:hover {
        background: #f8f9fa;
    }

    .status-dropdown-item.active {
        background: rgba(161, 33, 36, 0.05);
        color: var(--accent-red);
        font-weight: 600;
    }

    .status-dropdown-item i {
        width: 16px;
        text-align: center;
        font-size: 14px;
    }

    .alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        border-left: 4px solid;
        font-size: 14px;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border-left-color: #10b981;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border-left-color: #ef4444;
    }

    .alert-info {
        background-color: #dbeafe;
        color: #0c2d6b;
        border-left-color: #3b82f6;
    }

    .alert strong {
        font-weight: 700;
    }

    .empty-state {
        padding: 60px 40px;
        text-align: center;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 48px;
        color: #e2e8f0;
        display: block;
        margin-bottom: 15px;
    }

    .empty-state p {
        font-size: 14px;
        margin: 0;
    }

    /* Table Styling (Alumni Style) */
    .table-container {
        margin-top: 25px;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .custom-table th {
        padding: 12px 20px;
        color: var(--text-muted);
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        background-color: #f8f9fa;
        border-bottom: 2px solid #e2e8f0;
    }

    .custom-table thead {
        background-color: #f8f9fa;
    }

    .custom-table thead tr {
        background-color: transparent;
        box-shadow: none;
    }

    .custom-table tr.data-row {
        background: white;
        transition: var(--transition);
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        cursor: pointer;
    }

    .custom-table tr.data-row:hover {
        transform: scale(1.005);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        background: #fffcfc;
    }

    .custom-table tr.data-row:focus-visible {
        outline: 2px solid var(--accent-red);
        outline-offset: 2px;
    }

    .custom-table td {
        padding: 20px;
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: var(--text-main);
    }

    .custom-table td:first-child {
        border-left: 1px solid #f1f5f9;
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
    }

    .custom-table td:last-child {
        border-right: 1px solid #f1f5f9;
        border-top-right-radius: 16px;
        border-bottom-right-radius: 16px;
    }

    .employer-name {
        font-weight: 700;
        color: var(--text-main);
    }

    .employer-group {
        display: inline-block;
        background: rgba(161, 33, 36, 0.1);
        color: var(--accent-red);
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
    }

    .no-group {
        color: var(--text-muted);
        font-size: 12px;
        font-style: italic;
    }

    .visibility-stat {
        display: flex;
        gap: 20px;
    }

    .visibility-stat-item {
        text-align: center;
    }

    .stat-count {
        display: block;
        font-size: 16px;
        font-weight: 700;
        color: var(--accent-red);
    }

    .stat-count-label {
        display: block;
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        color: var(--text-muted);
        transition: var(--transition);
        border: 1px solid #e2e8f0;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-action:hover {
        background: var(--accent-red);
        color: white;
        border-color: var(--accent-red);
        transform: translateY(-2px);
    }

    .btn-action-delete {
        background: #f8fafc;
        color: var(--text-muted);
        border-color: #e2e8f0;
        display: inline-flex;
    }

    .btn-action-delete:hover {
        background: var(--accent-red);
        color: white;
        border-color: var(--accent-red);
        transform: translateY(-2px);
    }

    .btn-employer-accounts {
        border-radius: 8px;
        font-weight: 700;
        padding: 10px 20px;
        border: 1px solid #a12124;
        color: #ffffff;
        background: #a12124;
        transition: var(--transition);
    }

    .btn-employer-accounts:hover {
        background: #8a1a1e;
        color: #ffffff;
        border-color: #8a1a1e;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    /* Search Box */
    .search-container {
        background: #f1f5f9;
        border-radius: 16px;
        padding: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: 500px;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .search-container:focus-within {
        background: white;
        border-color: var(--accent-red);
        box-shadow: 0 0 0 4px rgba(161, 33, 36, 0.1);
    }

    .search-input {
        background: transparent;
        border: none;
        padding: 8px 12px;
        font-size: 14px;
        font-weight: 500;
        outline: none;
        flex: 1;
    }

    .btn-search {
        background: var(--accent-red);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-search:hover {
        transform: scale(1.02);
        opacity: 0.9;
    }

    .search-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .row-count {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 500;
        white-space: nowrap;
        margin-left: 20px;
    }

    /* Search Input Styling */
    #employerSearch {
        border-radius: 12px;
        font-size: 13px;
        border: 1px solid #e2e8f0;
        padding: 8px 12px 8px 36px !important;
    }

    #employerSearch:focus {
        border-color: var(--accent-red);
        box-shadow: 0 0 0 3px rgba(161, 33, 36, 0.1);
    }

    /* Header Section */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header-section h1 {
        margin: 0 0 8px 0;
        font-size: 32px;
        font-weight: 700;
        color: #ffffff;
    }

    .header-section h1 span {
        color: #ff6b6b;
    }

    .header-section p {
        margin: 0;
        color: #ffffff;
        font-size: 14px;
    }

    /* Main Card */
    .main-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        border: 1px solid #f1f5f9;
        padding: 25px;
    }

    .modal-content {
        border-radius: var(--border-radius);
        border: none;
        overflow: hidden;
    }

    .modal-header {
        background: var(--accent-red);
        color: white;
        padding: 25px;
        border: none;
        display: flex;
        align-items: center;
    }

    .modal-body {
        padding: 30px;
    }

    .modal-header .modal-title {
        font-weight: 700;
        font-size: 18px;
        margin: 0;
        flex: 1;
    }

    .modal-header .close {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .modal-close {
        font-size: 24px;
        color: white;
        opacity: 0.7;
        transition: var(--transition);
        line-height: 1;
        display: inline-block;
    }

    .modal-close:hover {
        opacity: 1;
    }

    .modal-dialog {
        margin-top: 100px !important;
        margin-bottom: 50px !important;
    }

    @media (min-width: 992px) {
        .modal-dialog {
            max-width: 700px !important;
        }
    }

    #visibilityModal .modal-dialog {
        width: 94vw;
        max-width: 1120px !important;
    }

    #employerAccountsMatrixModal .modal-dialog {
        width: 97vw;
        max-width: 1600px !important;
    }

    @media (max-width: 768px) {
        .modal-dialog {
            margin-top: 60px !important;
            margin-left: 12px;
            margin-right: 12px;
            margin-bottom: 30px !important;
        }

        .modal-content {
            border-radius: 8px;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-header {
            padding: 20px;
        }

        .custom-table td {
            padding: 16px 12px;
        }

        .visibility-stat {
            gap: 10px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 15px 12px;
        }

        .header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .main-card {
            padding: 20px;
        }

        .employer-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .employer-info-stats {
            width: 100%;
            justify-content: flex-start;
            gap: 20px;
        }

        .page-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .visibility-toggle {
            margin-left: 0;
        }

        .dropdown-menu-custom {
            position: fixed;
            right: 12px;
            top: auto;
            left: auto;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
            justify-content: flex-start;
        }

        .header-actions-left,
        .header-actions-right {
            width: 100%;
            justify-content: flex-start;
        }
    }
</style>

<div class="dashboard-wrapper">
    
    <!-- Header -->
    <div class="header-section">
        <div>
            <h1>Manage <span>Accounts</span></h1>
            <p>Manage which pages each employer can access</p>
        </div>
        <div class="header-actions">
            <div class="header-actions-left">
                <button type="button" class="btn-create-group" onclick="openGroupCreationModal()">
                    <i class="fas fa-plus"></i> Create Group
                </button>
            </div>
            <div class="header-actions-right">
                <button type="button" class="btn btn-employer-accounts" onclick="openEmployerAccountsMatrixModal()" style="border: 1px solid var(--accent-red); text-decoration: none; display: inline-flex; align-items: center;">
                    <i class="fas fa-object-group mr-1"></i> Manage Accounts
                </button>
            </div>
        </div>
    </div>

    <div class="main-card">
        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <strong>✓ Success!</strong> <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <strong>✗ Error!</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>

        <?php if (empty($employers)): ?>
        
        <!-- Empty State -->
        <div class="visibility-matrix">
            <div class="empty-state">
                <i class="fas fa-building"></i>
                <p><strong>No employers found</strong></p>
                <p style="margin-top: 8px; font-size: 13px;">Add employers to your system to manage their page access.</p>
            </div>
        </div>

        <?php else: ?>

        <!-- TABLE CONTROLS -->
        <div class="table-controls d-flex justify-content-between align-items-center flex-wrap mb-3">
            <!-- LEFT: search -->
            <div style="position: relative; max-width: 260px;">
                <input type="text"
                       id="employerSearch"
                       class="form-control form-input"
                       placeholder="Search employers..."
                       style="padding-left:36px;">
                <i class="fas fa-search"
                   style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
            </div>

            <!-- RIGHT: rows info -->
            <div class="text-muted" style="font-size:13px; font-weight:600;">
                Showing <span id="rowCount"><?php echo count($employers); ?></span> employer<?php echo count($employers) !== 1 ? 's' : ''; ?>
            </div>
        </div>

        <!-- Employers Table -->
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Employer Name</th>
                        <th>Group</th>
                        <th>Visibility</th>
                        <th>Status</th>
                        <th style="text-align: right; padding-right: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employers as $employer): ?>
                    <?php
                        $employer_display_name = trim(($employer->first_name ?? '') . ' ' . ($employer->last_name ?? ''));
                        if ($employer_display_name === '') {
                            $employer_display_name = $employer->company_name;
                        }

                        $group_info = isset($visibility_settings['employer_group_' . $employer->id]) 
                            ? $visibility_settings['employer_group_' . $employer->id] 
                            : null;
                        
                        $visible_count = 0;
                        $total_pages = count($pages);
                        
                        foreach ($pages as $page) {
                            $visibility_key = $page['slug'] . '_' . $employer->id;
                            if (isset($visibility_settings[$visibility_key]) && $visibility_settings[$visibility_key]) {
                                $visible_count++;
                            }
                        }
                        $hidden_count = $total_pages - $visible_count;
                    ?>
                    <tr class="data-row"
                        data-employer-id="<?php echo $employer->id; ?>"
                        data-employer-name="<?php echo htmlspecialchars($employer_display_name, ENT_QUOTES, 'UTF-8'); ?>"
                        tabindex="0"
                        role="button"
                        aria-label="View details for <?php echo htmlspecialchars($employer_display_name, ENT_QUOTES, 'UTF-8'); ?>">
                        <td>
                            <span class="employer-name"><?php echo htmlspecialchars($employer_display_name, ENT_QUOTES, 'UTF-8'); ?></span>
                        </td>
                        <td>
                            <?php if ($group_info): ?>
                                <span class="employer-group"><?php echo htmlspecialchars($group_info); ?></span>
                            <?php else: ?>
                                <span class="no-group">Not assigned</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="visibility-stat">
                                <div class="visibility-stat-item">
                                    <span class="stat-count" style="color: #10b981;"><?php echo $visible_count; ?></span>
                                    <span class="stat-count-label">Visible</span>
                                </div>
                                <div class="visibility-stat-item">
                                    <span class="stat-count" style="color: #ef4444;"><?php echo $hidden_count; ?></span>
                                    <span class="stat-count-label">Hidden</span>
                                </div>
                            </div>
                        </td>
                        <td style="position: relative;">
                            <?php if (isset($employer->is_active) && $employer->is_active == 1): ?>
                                <span class="status-badge status-active" onclick="toggleEmployerStatus(<?php echo $employer->id; ?>, this, event)" data-status="active" title="Click to change status" style="cursor: pointer; display: inline-block;">
                                    <i class="fas fa-check-circle" style="margin-right: 4px;"></i>Active
                                </span>
                            <?php else: ?>
                                <span class="status-badge status-inactive" onclick="toggleEmployerStatus(<?php echo $employer->id; ?>, this, event)" data-status="inactive" title="Click to change status" style="cursor: pointer; display: inline-block;">
                                    <i class="fas fa-times-circle" style="margin-right: 4px;"></i>Inactive
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: right;">
                            <button class="btn-action" onclick="openVisibilityModal(<?php echo $employer->id; ?>, '<?php echo htmlspecialchars($employer_display_name, ENT_QUOTES, 'UTF-8'); ?>', 'groups', 'groups-only')" title="Manage groups">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action btn-action-delete" onclick="deleteEmployer(<?php echo $employer->id; ?>, '<?php echo htmlspecialchars($employer_display_name, ENT_QUOTES, 'UTF-8'); ?>')" title="Delete employer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($pagination_links)): ?>
            <div style="margin-top: 18px; display: flex; justify-content: center;">
                <?= $pagination_links ?>
            </div>
        <?php endif; ?>

        <?php endif; ?>
    </div>

</div>

<!-- Group Creation Modal -->
<div class="modal fade" id="groupCreationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Create New Group</h5>
                <button type="button" class="close" onclick="closeGroupCreationModal()" aria-label="Close">
                    <span aria-hidden="true" class="modal-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Group Name Input -->
                <div style="margin-bottom: 20px;">
                    <label class="selector-label">Group Name</label>
                    <input type="text" 
                           id="groupNameInput" 
                           class="form-control form-input" 
                           placeholder="Enter group name..."
                           style="padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="selector-label">Description (Optional)</label>
                    <textarea
                           id="groupDescriptionInput"
                           class="form-control form-input"
                           placeholder="Enter a short description for this group..."
                           rows="3"
                           style="padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;"></textarea>
                </div>

                <!-- Search Employers -->
                <div style="margin-bottom: 20px;">
                    <label class="selector-label">Search & Select Employers</label>
                    <div class="group-search-container">
                        <i class="fas fa-search"></i>
                        <input type="text" 
                               id="groupEmployerSearch" 
                               class="form-control" 
                               placeholder="To: type a name or group..."
                               style="padding: 12px 16px 12px 40px; border: 1px solid #e2e8f0; border-radius: 8px; width: 100%;">
                    </div>
                </div>

                <!-- Employers Selection List -->
                <div class="employers-selection-list" id="groupEmployersSelectList">
                    <!-- Dynamically populated with employers -->
                </div>

                <!-- Selected Employers Preview -->
                <div style="margin-top: 20px;">
                    <label class="selector-label">Selected Employers</label>
                    <div class="selected-employers" id="selectedEmployersContainer">
                        <span style="color: var(--text-muted); font-size: 13px;">No employers selected</span>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div style="display: flex; gap: 12px; padding: 20px 30px; border-top: 1px solid #f1f5f9; justify-content: flex-end;">
                <button type="button" class="btn-modal-cancel" onclick="closeGroupCreationModal()">
                    Cancel
                </button>
                <button type="button" class="btn-modal-save" id="createGroupBtn" onclick="createNewGroup()">
                    <i class="fas fa-check mr-2"></i>Create Group
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Employer Details Modal -->
<div class="modal fade" id="employerDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Account Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="modal-close">&times;</span>
                </button>
            </div>
            <div class="#">
                <div id="employer-details-content" style="padding: 10px;">
                    <!-- Loading content -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Visibility Edit Modal -->
<div class="modal fade" id="visibilityModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEmployerName"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="modal-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Employer Accounts Tab -->
                <div id="visibility-tab-content" class="modal-tab-content active">
                    <div style="padding-top: 10px;">
                        <?php foreach ($pages as $page): ?>
                        <div class="page-item" data-page="<?php echo $page['slug']; ?>">
                            <div class="page-info">
                                <div class="page-name">
                                    <i class="fas fa-file-alt"></i> <?php echo $page['name']; ?>
                                </div>
                                <p class="page-description"><?php echo $page['description']; ?></p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <label class="visibility-toggle">
                                    <input 
                                        type="checkbox" 
                                        class="visibility-checkbox"
                                        data-page="<?php echo $page['slug']; ?>"
                                    >
                                    <span class="toggle-switch"></span>
                                </label>
                                <span class="status-badge status-hidden">Hidden</span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Manage Groups Tab -->
                <div id="groups-tab-content" class="modal-tab-content" style="display: none;">
                    <div style="padding-top: 10px;">
                        <label class="selector-label">Groups</label>
                        <ul id="groups-list" class="list-group">
                            <!-- Group cards loaded dynamically -->
                        </ul>
                    </div>
                </div>

                <!-- Modal Footer with Actions -->
                <div style="display: flex; gap: 12px; padding-top: 24px; margin-top: 24px; border-top: 1px solid #f1f5f9; justify-content: space-between; align-items: center;">
                    <!-- Tab Toggle Button -->
                    <button type="button" id="visibilityModalTabToggle" class="modal-footer-tab-btn" onclick="toggleVisibilityModalTab()">
                        <i class="fas fa-object-group" style="margin-right: 8px;"></i>Manage Groups
                    </button>
                    
                    <div style="display: flex; gap: 12px;">
                        <button type="button" class="btn-modal-cancel" onclick="closeVisibilityModal()">
                            Cancel
                        </button>
                        <button type="button" id="visibilityModalSaveBtn" class="btn-modal-save" onclick="saveVisibilityChanges()">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Employer Accounts Matrix Modal -->
<div class="modal fade" id="employerAccountsMatrixModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl employer-matrix-modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-th mr-2"></i> Manage Roles</h5>
                <button type="button" class="close" onclick="closeEmployerAccountsMatrixModal()" aria-label="Close">
                    <span aria-hidden="true" class="modal-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="matrix-modal-subtitle">Use checkboxes to control each employer's access per page.</div>
                <div class="matrix-table-wrap">
                    <table class="matrix-table">
                        <thead>
                            <tr>
                                <th class="matrix-sticky-col matrix-company-head">Company</th>
                                <?php foreach ($pages as $page): ?>
                                    <th title="<?php echo htmlspecialchars($page['description']); ?>"><?php echo htmlspecialchars($page['name']); ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employers as $employer): ?>
                                <tr data-employer-id="<?php echo $employer->id; ?>">
                                    <td class="matrix-sticky-col matrix-company-cell">
                                        <?php echo htmlspecialchars($employer->company_name); ?>
                                    </td>
                                    <?php foreach ($pages as $page): ?>
                                        <?php $matrix_visibility_key = $page['slug'] . '_' . $employer->id; ?>
                                        <td>
                                            <label class="matrix-checkbox-wrap" data-toggle="tooltip" data-placement="top" title="Toggle <?php echo htmlspecialchars($page['name']); ?> for <?php echo htmlspecialchars($employer->company_name); ?>">
                                                <input
                                                    type="checkbox"
                                                    class="matrix-visibility-checkbox"
                                                    data-page="<?php echo htmlspecialchars($page['slug']); ?>"
                                                    data-employer-id="<?php echo $employer->id; ?>"
                                                    <?php echo (!empty($visibility_settings[$matrix_visibility_key])) ? 'checked' : ''; ?>
                                                >
                                            </label>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="matrix-pagination-wrap" id="matrixPaginationWrap"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeEmployerAccountsMatrixModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Group Edit Modal -->
<div class="modal fade group-edit-modal" id="groupEditModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-pen mr-2"></i>Edit Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="modal-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="group-edit-panel">
                    <div class="group-edit-preview">
                        <div class="group-edit-kicker">Group Details</div>
                        <h3 class="group-edit-title" id="groupEditPreviewName">Group Name</h3>
                        <p class="group-edit-copy">Update the group name to keep employer assignments organized and easy to scan.</p>

                        <div class="group-edit-summary">
                            <div class="group-edit-summary-card">
                                <span class="group-edit-summary-label">Group ID</span>
                                <div class="group-edit-summary-value" id="groupEditPreviewId">-</div>
                            </div>
                            <div class="group-edit-summary-card">
                                <span class="group-edit-summary-label">Members</span>
                                <div class="group-edit-summary-value" id="groupEditPreviewMembers">-</div>
                            </div>
                        </div>
                    </div>

                    <div class="group-edit-form">
                        <div class="group-edit-kicker">Rename Group</div>
                        <label class="selector-label" for="groupEditInput" style="margin-bottom: 8px;">Group Name</label>
                        <input type="text" id="groupEditInput" class="form-control form-input" placeholder="Enter group name..." style="padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <input type="hidden" id="groupEditId" value="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn-modal-save" onclick="saveGroupNameEdit()">
                    <i class="fas fa-check mr-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Employer Modal -->
<div class="modal fade" id="employerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add New Employer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="modal-close">&times;</span>
                </button>
            </div>
            <form id="employerForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div style="margin-bottom: 20px;">
                        <label class="selector-label">Company Name</label>
                        <input type="text" 
                               id="employer_company_name" 
                               name="company_name" 
                               class="form-control form-input" 
                               placeholder="Enter company name..."
                               required
                               style="padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="selector-label">Email</label>
                        <input type="email" 
                               id="employer_email" 
                               name="email" 
                               class="form-control form-input" 
                               placeholder="Enter email address..."
                               required
                               style="padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="selector-label">Password</label>
                        <input type="password" 
                               id="employer_password" 
                               name="password" 
                               class="form-control form-input" 
                               placeholder="Enter password..."
                               required
                               style="padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="selector-label">Contact Person</label>
                        <input type="text" 
                               id="employer_contact_person" 
                               name="contact_person" 
                               class="form-control form-input" 
                               placeholder="Enter contact person name..."
                               style="padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="selector-label">Phone Number</label>
                        <input type="tel" 
                               id="employer_phone" 
                               name="phone" 
                               class="form-control form-input" 
                               placeholder="Enter phone number..."
                               style="padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="selector-label">Address</label>
                        <textarea 
                               id="employer_address" 
                               name="address" 
                               class="form-control form-input" 
                               placeholder="Enter company address..."
                               rows="3"
                               style="padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;"></textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="selector-label">Status</label>
                        <select id="employer_status" 
                                name="status" 
                                class="form-control form-input"
                                style="padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; padding: 20px 30px; border-top: 1px solid #f1f5f9; justify-content: flex-end;">
                    <button type="button" class="btn-modal-cancel" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn-modal-save">
                        <i class="fas fa-check mr-2"></i>Add Employer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .modal-tab-btn {
        background: transparent;
        border: none;
        color: var(--text-muted);
        font-weight: 600;
        font-size: 14px;
        padding: 12px 16px;
        cursor: pointer;
        transition: var(--transition);
        border-bottom: 3px solid transparent;
        position: relative;
        bottom: -17px;
        display: none;
    }

    .modal-tab-btn:hover {
        color: var(--text-main);
    }

    .modal-tab-btn.active {
        color: var(--accent-red);
        border-bottom-color: var(--accent-red);
    }

    .modal-footer-tab-btn {
        background: rgba(161, 33, 36, 0.1);
        color: var(--accent-red);
        border: 1px solid #fecaca;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .modal-footer-tab-btn:hover {
        background: #fee2e2;
        border-color: var(--accent-red);
        box-shadow: 0 2px 8px rgba(161, 33, 36, 0.2);
    }

    /* Inline Editable Group Name */
    .group-name-editable {
        background: #dbeafe;
        color: #0c2d6b;
        padding: 6px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        outline: none;
    }

    .group-name-editable:hover {
        background: #bfdbfe;
        box-shadow: 0 2px 8px rgba(12, 45, 107, 0.15);
    }

    .group-name-editable:focus {
        outline: 2px solid #0c2d6b;
        outline-offset: 2px;
        background: #ffffff;
        color: #0c2d6b;
    }

    .group-edit-icon {
        margin-left: 8px;
        opacity: 0;
        transition: var(--transition);
        font-size: 12px;
    }

    .group-name-editable:hover .group-edit-icon {
        opacity: 1;
    }

    .group-members-clickable {
        background: #dbeafe;
        color: #0c2d6b;
        padding: 6px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        cursor: pointer;
        transition: var(--transition);
        user-select: none;
    }

    .group-members-clickable:hover {
        background: #bfdbfe;
        box-shadow: 0 2px 8px rgba(12, 45, 107, 0.15);
    }

    .modal-tab-content {
        animation: fadeIn 0.3s ease-out;
    }

    .modal-tab-content.active {
        display: block;
    }

    .group-badge {
        display: inline-block;
        background: #f0f2f5;
        border: 1px solid #e2e8f0;
        padding: 8px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-main);
        transition: var(--transition);
        cursor: pointer;
    }

    .group-badge:hover {
        background: #e8eaed;
        border-color: var(--accent-red);
    }

    .group-badge.active {
        background: rgba(161, 33, 36, 0.1);
        border-color: var(--accent-red);
        color: var(--accent-red);
    }

    .group-badge.assigned {
        background: #dcfce7;
        border-color: #10b981;
        color: #166534;
    }

    .group-badge.assigned::after {
        content: ' ✓';
    }

    .group-remove-btn {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
        transition: var(--transition);
        margin-left: 8px;
    }

    .group-remove-btn:hover {
        background: #fecaca;
        border-color: #ef4444;
    }

    .current-group-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #dcfce7;
        border: 1px solid #10b981;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        color: #166534;
    }

    .current-group-item .remove-btn {
        background: transparent;
        border: none;
        color: #166534;
        cursor: pointer;
        font-size: 16px;
        padding: 0;
        transition: var(--transition);
    }

    .current-group-item .remove-btn:hover {
        color: #991b1b;
    }

    .empty-groups-message {
        color: var(--text-muted);
        font-size: 13px;
        font-style: italic;
        padding: 12px;
        text-align: center;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .detail-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
        word-break: break-word;
    }

    .detail-value.accent {
        color: #64748b;
    }

    .details-section {
        padding: 16px;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 16px;
    }

    .details-section-title {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        display: block;
    }

    .btn-modal-save {
        background: var(--accent-red);
        color: white;
        border: none;
        padding: 10px 28px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(161, 33, 36, 0.25);
    }

    .btn-modal-save:hover {
        background: #7d1819;
        box-shadow: 0 4px 12px rgba(161, 33, 36, 0.35);
    }

    .btn-modal-save:active {
        box-shadow: 0 1px 4px rgba(161, 33, 36, 0.25);
    }

    .btn-modal-cancel {
        background: #f1f5f9;
        color: var(--text-main);
        border: 1px solid #e2e8f0;
        padding: 10px 28px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .btn-modal-cancel:hover {
        background: #e2e8f0;
        border-color: #cbd5e1;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .btn-modal-cancel:active {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .btn-create-group {
        border-radius: 8px;
        font-weight: 700;
        padding: 10px 20px;
        border: 1px solid #a12124;
        color: #ffffff;
        background: #a12124;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-create-group:hover {
        background: #8a1a1e;
        color: #ffffff;
        border-color: #8a1a1e;
        box-shadow: 0 2px 8px rgba(161, 33, 36, 0.2);
    }

    #groups-tab-content .btn-create-group {
        margin-bottom: 20px;
    }

    .btn-modal-outline {
        background: #ffffff;
        color: var(--accent-red);
        border: 1px solid #fecaca;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-modal-outline:hover {
        background: #fee2e2;
        border-color: var(--accent-red);
        box-shadow: 0 2px 8px rgba(161, 33, 36, 0.2);
    }

    /* Group Creation Modal */
    #groupCreationModal {
        z-index: 1100 !important;
    }
    
    #groupCreationModal .modal-backdrop {
        z-index: 1090 !important;
    }

    #groupCreationModal .selector-label {
        font-weight: 500;
    }

    .group-search-container {
        position: relative;
        margin-bottom: 20px;
    }

    .group-search-container input {
        width: 100%;
        padding: 12px 16px 12px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
    }

    .group-search-container input:focus {
        outline: none;
        border-color: var(--accent-red);
        box-shadow: 0 0 0 3px rgba(161, 33, 36, 0.1);
    }

    .group-search-container i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .employers-selection-list {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0;
    }

    .employer-checkbox-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: var(--transition);
    }

    .employer-checkbox-item:last-child {
        border-bottom: none;
    }

    .employer-checkbox-item:hover {
        background: #f8f9fa;
    }

    .employer-checkbox-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .employer-checkbox-label {
        flex: 1;
        cursor: pointer;
        font-size: 14px;
        color: var(--text-main);
        margin: 0;
    }

    .selected-employers {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 16px;
        padding: 16px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        border-radius: 8px;
        min-height: 50px;
        box-shadow: 0 1px 3px rgba(12, 45, 107, 0.08);
    }

    .selected-employer-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #dbeafe;
        color: #0c2d6b;
        border: 1px solid #bfdbfe;
        padding: 8px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .selected-employer-tag .remove-tag {
        background: none;
        border: none;
        color: #0c2d6b;
        cursor: pointer;
        padding: 0;
        font-size: 16px;
        line-height: 1;
    }

    .selected-employer-tag .remove-tag:hover {
        color: #991b1b;
    }

    /* Groups Table Styling */
    .groups-table {
        width: 100%;
    }

    .groups-table thead th {
        background: #f8fafc;
        font-weight: 700;
        font-size: 12px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .groups-table tbody tr.group-row {
        background: white;
        border-radius: 12px;
        margin-bottom: 8px;
        transition: var(--transition);
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .groups-table tbody tr.group-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        background: #fffcfc;
    }

    .groups-table tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: var(--text-main);
        font-size: 14px;
    }

    .groups-table tbody tr.group-row:first-child td {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .groups-table tbody tr.group-row:last-child td {
        border-bottom: none;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .groups-table tbody tr.group-row td {
        background: #ffffff;
    }

    .group-action-btn {
        margin-right: 8px;
    }

    .group-members-modal-content {
        padding: 0;
        background: transparent;
    }

    .group-details-card {
        margin-bottom: 20px;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
    }

    .group-name-edit-label,
    .group-description-edit-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #5a5c69;
        letter-spacing: 0.3px;
        margin-bottom: 8px;
        font-family: 'Nunito', sans-serif;
    }

    .group-name-edit-row {
        display: block;
        margin-bottom: 14px;
    }

    .group-name-edit-input,
    .group-description-edit-textarea {
        width: 100%;
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        background: #ffffff;
        color: #2e2f37;
        font-size: 14px;
        padding: 10px 12px;
    }

    .group-name-edit-input:focus,
    .group-description-edit-textarea:focus {
        outline: none;
        border-color: #be2626;
        box-shadow: 0 0 0 0.2rem rgba(190, 38, 38, 0.15);
    }

    .group-description-edit-textarea {
        min-height: 92px;
        resize: vertical;
    }

    .group-members-select {
        width: 100%;
        flex: 1;
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        margin-bottom: 0;
        background: #ffffff;
        color: var(--text-main);
        font-weight: 600;
    }

    .group-members-action-row {
        margin-bottom: 18px;
    }

    .group-members-input-group {
        margin-bottom: 20px;
    }

    .group-members-input-group .custom-select {
        border: 1px solid #d1d3e2;
        border-right: 0;
        border-radius: 8px 0 0 8px;
        height: 42px;
        font-size: 14px;
    }

    .group-members-input-group .custom-select:focus {
        border-color: #be2626;
        box-shadow: 0 0 0 0.2rem rgba(190, 38, 38, 0.15);
    }

    .group-members-input-group .input-group-append .btn {
        border-radius: 0 8px 8px 0;
        border: 1px solid #be2626;
        background: #be2626;
        color: #ffffff;
        font-weight: 700;
        font-family: 'Nunito', sans-serif;
        padding: 0 16px;
    }

    .group-members-input-group .input-group-append .btn:hover {
        background: #9f1f1f;
        border-color: #9f1f1f;
    }

    .group-members-select:focus {
        outline: none;
        border-color: var(--accent-red);
        box-shadow: 0 0 0 3px rgba(161, 33, 36, 0.12);
    }

    #groups-tab-content #groups-list .list-group-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        background: #ffffff;
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        margin-bottom: 12px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(58, 59, 69, 0.08);
        transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
    }

    #groups-tab-content #groups-list .list-group-item:hover {
        border-color: #be2626;
        box-shadow: 0 6px 18px rgba(58, 59, 69, 0.12);
        transform: translateY(-2px);
    }

    #groups-tab-content #groups-list .group-list-content {
        flex: 1 1 auto;
        min-width: 0;
    }

    #groups-tab-content #groups-list .group-list-title {
        margin: 0 0 4px;
        font-weight: 700;
        color: #2e2f37;
        line-height: 1.35;
    }

    #groups-tab-content #groups-list .group-description-preview {
        margin: 0 0 4px;
        color: #858796;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-all;
    }

    #groups-tab-content #groups-list .group-member-count-muted {
        color: #858796;
        font-size: 12px;
    }

    #groups-tab-content #groups-list .group-list-actions {
        flex: 0 0 154px;
        width: 154px;
        min-width: 154px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    #groups-tab-content #groups-list .group-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    #groups-tab-content #groups-list .group-status-pill.assigned {
        background: #d1fae5;
        color: #065f46;
        border-color: #a7f3d0;
    }

    #groups-tab-content #groups-list .group-status-pill.not-assigned {
        background: #f1f5f9;
        color: #475569;
        border-color: #dbe2ea;
    }

    #groups-tab-content #groups-list .group-list-delete-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #fecaca;
        background: #fff5f5;
        color: #b91c1c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    #groups-tab-content #groups-list .group-list-delete-btn:hover {
        background: #be2626;
        border-color: #be2626;
        color: #ffffff;
        transform: translateY(-1px);
    }



    .group-members-add-btn {
        min-width: 110px;
    }

    .group-members-list {
        max-height: 350px;
        overflow-y: auto;
        padding-right: 2px;
        background: transparent;
    }

    .group-members-list .list-group-item {
        border: 0 !important;
        margin-bottom: 10px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 1px 4px rgba(58, 59, 69, 0.08);
        padding: 10px 12px;
    }

    .group-member-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition);
    }

    .group-member-item:hover {
        background: #fff8f8;
        box-shadow: 0 2px 10px rgba(190, 38, 38, 0.12);
    }

    .group-member-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .group-member-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #e7ebf3;
        color: #4e73df;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        font-family: 'Nunito', sans-serif;
        text-transform: uppercase;
        flex-shrink: 0;
    }

    .group-member-name {
        font-weight: 700;
        color: #000000;
        font-size: 14px;
        font-family: 'Nunito', sans-serif;
    }

    #groups-tab-content .selector-label {
        font-size: 14px;
        font-family: 'Nunito', sans-serif;
    }

    .btn-member-remove {
        width: 34px;
        height: 34px;
        margin-left: auto;
        padding: 0;
        border-radius: 50%;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #f5c6cb;
        background: transparent;
        color: #b91c1c;
        transition: all 0.3s ease;
    }

    .btn-member-remove.btn-action-delete {
        background: transparent;
        color: #b91c1c;
        border-color: #f5c6cb;
    }

    .btn-member-remove.btn-action-delete:hover {
        background: #be2626;
        color: #ffffff;
        border-color: #be2626;
        transform: none;
        box-shadow: 0 0.125rem 0.25rem rgba(190, 38, 38, 0.25);
    }

    .group-members-modal-title {
        margin-bottom: 16px;
        font-weight: 700;
        color: var(--text-main);
        font-size: 16px;
        font-family: 'Nunito', sans-serif;
        text-transform: none;
        letter-spacing: 0;
    }

    .group-members-empty {
        color: var(--text-muted);
        text-align: center;
        margin: 16px 0 6px;
        font-size: 13px;
    }

    .group-members-modal-dialog {
        width: 94vw;
        max-width: 1120px !important;
    }

    .group-members-modal-dialog .btn-modal-save {
        background: #be2626;
        box-shadow: 0 2px 8px rgba(190, 38, 38, 0.25);
    }

    .group-members-modal-dialog .btn-modal-save:hover {
        background: #9f1f1f;
        box-shadow: 0 4px 12px rgba(190, 38, 38, 0.35);
    }

    .group-members-clickable {
        background: rgba(161, 33, 36, 0.1);
        color: var(--accent-red);
        border: 1px solid #fecaca;
    }

    .group-members-clickable:hover {
        background: #fee2e2;
        box-shadow: 0 2px 8px rgba(161, 33, 36, 0.18);
    }

    .employer-matrix-modal-dialog {
        max-width: 1600px !important;
    }

    .matrix-modal-subtitle {
        color: var(--text-muted);
        font-size: 13px;
        margin-bottom: 14px;
    }

    .matrix-table-wrap {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: auto;
        max-height: 78vh;
        background: #fff;
    }

    .matrix-table {
        width: 100%;
        min-width: 900px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .matrix-table th,
    .matrix-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #f8fafc;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        font-size: 13px;
    }

    .matrix-table thead th {
        position: sticky;
        top: 0;
        z-index: 3;
        background: #f1f5f9;
        color: var(--text-main);
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .matrix-table .matrix-sticky-col {
        position: sticky;
        left: 0;
        z-index: 2;
        background: #f8fafc;
        text-align: left;
    }

    .matrix-table thead .matrix-sticky-col {
        z-index: 4;
        background: #f1f5f9;
    }

    .matrix-company-head {
        min-width: 250px;
    }

    .matrix-company-cell {
        font-weight: 600;
        color: var(--text-main);
    }

    .matrix-pagination-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .matrix-pagination-wrap button {
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .matrix-pagination-wrap button:hover:not(:disabled) {
        background: #a12124;
        color: white;
        border-color: #a12124;
    }

    .matrix-pagination-wrap button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .matrix-pagination-wrap button.active {
        background: #a12124;
        color: white;
        border-color: #a12124;
    }

    .matrix-page-info {
        font-size: 13px;
        color: var(--text-muted);
        margin: 0 12px;
    }

    .matrix-checkbox-wrap {
        margin: 0;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .tooltip {
        z-index: 2000 !important;
    }

    .tooltip.show {
        z-index: 2000 !important;
    }

    @media (max-width: 768px) {
        .group-members-action-row {
            flex-direction: column;
            align-items: stretch;
        }

        .group-members-add-btn {
            width: 100%;
        }
    }

    .matrix-visibility-checkbox {
        width: 17px;
        height: 17px;
        accent-color: var(--accent-red);
        cursor: pointer;
    }

    .badge.bg-success {
        background-color: #d1fae5 !important;
        color: #065f46;
    }

</style>

<script>
const employerData = <?php echo json_encode($employers); ?>;
console.log('Employer data loaded:', employerData);
console.log('Employer data length:', employerData ? employerData.length : 0);

// Ensure a consistent display name for each employer: prefer first+last, fallback to company_name
try {
    if (Array.isArray(employerData)) {
        employerData.forEach(emp => {
            const first = (emp.first_name || '').trim();
            const last = (emp.last_name || '').trim();
            let disp = (first || last) ? (first + ' ' + last).trim() : '';
            if (!disp) disp = emp.company_name || '';
            emp.display_name = disp;
        });
    }
} catch (e) {
    console.warn('Failed to normalize employer display names', e);
}

function getPersonDisplayName(person) {
    if (!person) {
        return '';
    }

    const first = (person.first_name || '').trim();
    const last = (person.last_name || '').trim();
    const fullName = (first || last) ? (first + ' ' + last).trim() : '';

    if (fullName) {
        return fullName;
    }

    return person.display_name || person.company_name || '';
}

function getPersonInitials(person) {
    const name = getPersonDisplayName(person).trim();
    if (!name) {
        return 'NA';
    }

    const parts = name.split(/\s+/).filter(Boolean);
    const first = parts[0] ? parts[0].charAt(0) : '';
    const second = parts.length > 1 ? parts[parts.length - 1].charAt(0) : '';
    return (first + second).toUpperCase() || 'NA';
}

const visibilitySettings = <?php echo json_encode($visibility_settings); ?>;
const pageSlugs = <?php echo json_encode(array_column($pages, 'slug')); ?>;
const baseUrl = '<?php echo base_url(); ?>';
let currentEmployerId = null;
let availableGroups = [];
let openingGroupCreationModal = false;  // Flag to prevent page reload when opening group modal
let activeModalTab = 'visibility';  // Track which tab is currently active
let modalTabMode = 'visibility-only';
let suppressVisibilityModalReload = false;
let employerRegistryData = [];
let activeGroupModalContext = null;

// Prevent stacked modals by ensuring only one is open at a time.
if (typeof $ !== 'undefined' && $.fn && $.fn.modal) {
    $(document).on('show.bs.modal', '.modal', function() {
        const current = this;
        $('.modal.show, .modal.in').not(current).each(function() {
            $(this).modal('hide');
        });
    });

    $(document).on('hidden.bs.modal', '.modal', function() {
        if ($('.modal.show, .modal.in').length === 0) {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
        }
    });
}

function updateManageGroupsTabVisibility() {
    const tabToggleBtn = document.getElementById('visibilityModalTabToggle');
    const visibilityTab = document.getElementById('visibility-tab-content');
    const groupsTab = document.getElementById('groups-tab-content');
    
    if (!visibilityTab || !groupsTab) {
        console.error('Tab elements not found');
        return;
    }
    
    if (modalTabMode === 'groups-only') {
        // Show ONLY groups tab - hide visibility tab and toggle button
        visibilityTab.style.display = 'none';
        groupsTab.style.display = 'block';
        activeModalTab = 'groups';
        if (tabToggleBtn) {
            tabToggleBtn.style.display = 'none';  // Hide toggle button in groups-only mode
        }
        return;
    }

    if (modalTabMode === 'visibility-only') {
        // Show ONLY visibility tab - hide groups tab and toggle button
        visibilityTab.style.display = 'block';
        groupsTab.style.display = 'none';
        activeModalTab = 'visibility';
        if (tabToggleBtn) {
            tabToggleBtn.style.display = 'none';  // Hide toggle button in visibility-only mode
        }
        return;
    }

    if (modalTabMode === 'both-tabs') {
        // Show both tabs with toggle button visible
        visibilityTab.style.display = 'block';
        groupsTab.style.display = 'none';
        activeModalTab = 'visibility';
        if (tabToggleBtn) {
            tabToggleBtn.style.display = 'inline-flex';  // Show toggle button
            tabToggleBtn.innerHTML = '<i class="fas fa-object-group" style="margin-right: 8px;"></i>Manage Groups';
        }
        return;
    }
}

function toggleVisibilityModalTab() {
    const tabToggleBtn = document.getElementById('visibilityModalTabToggle');
    const visibilityTab = document.getElementById('visibility-tab-content');
    const groupsTab = document.getElementById('groups-tab-content');
    
    if (activeModalTab === 'visibility') {
        // Switch to groups
        activeModalTab = 'groups';
        visibilityTab.style.display = 'none';
        groupsTab.style.display = 'block';
        tabToggleBtn.innerHTML = '<i class="fas fa-shield-alt" style="margin-right: 8px;"></i>Manage Accounts';
        
        // Load groups if not already loaded
        if (currentEmployerId) {
            loadEmployerGroups(currentEmployerId);
        }
    } else {
        // Switch to visibility
        activeModalTab = 'visibility';
        visibilityTab.style.display = 'block';
        groupsTab.style.display = 'none';
        tabToggleBtn.innerHTML = '<i class="fas fa-object-group" style="margin-right: 8px;"></i>Manage Groups';
    }
}

function setModalTabButtonState(tab) {
    activeModalTab = tab === 'groups' ? 'groups' : 'visibility';
}

function switchModalTab(tab, buttonElement) {
    // Legacy function - now delegated to toggleVisibilityModalTab
    if (tab === 'groups' && activeModalTab === 'visibility') {
        toggleVisibilityModalTab();
    } else if (tab === 'visibility' && activeModalTab === 'groups') {
        toggleVisibilityModalTab();
    }
}

// Modal close functions
function closeVisibilityModal() {
    const modalElement = document.getElementById('visibilityModal');
    if (modalElement) {
        if (typeof $ !== 'undefined' && $.fn.modal) {
            $(modalElement).modal('hide');
        } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            bootstrap.Modal.getInstance(modalElement)?.hide();
        }
    }
}

function closeGroupCreationModal() {
    const modalElement = document.getElementById('groupCreationModal');
    if (modalElement) {
        if (typeof $ !== 'undefined' && $.fn.modal) {
            $(modalElement).modal('hide');
        } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            bootstrap.Modal.getInstance(modalElement)?.hide();
        }
    }
}

// Matrix Pagination - 5 employers per page
function initializeMatrixPagination() {
    const rows = document.querySelectorAll('.matrix-table tbody tr');
    const itemsPerPage = 5;
    let currentPage = 1;
    const totalPages = Math.ceil(rows.length / itemsPerPage);
    
    if (totalPages <= 1) return; // No pagination needed
    
    function showPage(page) {
        rows.forEach((row, index) => {
            const rowPage = Math.floor(index / itemsPerPage) + 1;
            row.style.display = rowPage === page ? '' : 'none';
        });
        updatePaginationButtons();
    }
    
    function updatePaginationButtons() {
        const paginationWrap = document.getElementById('matrixPaginationWrap');
        paginationWrap.innerHTML = '';
        
        // Previous button
        const prevBtn = document.createElement('button');
        prevBtn.textContent = '← Previous';
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        };
        paginationWrap.appendChild(prevBtn);
        
        // Page info
        const pageInfo = document.createElement('span');
        pageInfo.className = 'matrix-page-info';
        pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
        paginationWrap.appendChild(pageInfo);
        
        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.textContent = 'Next →';
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        };
        paginationWrap.appendChild(nextBtn);
    }
    
    showPage(1);
}

// Initialize pagination when the employer matrix modal opens
document.addEventListener('click', function(e) {
    if (e.target.textContent.includes('Manage Accounts')) {
        setTimeout(() => {
            initializeMatrixPagination();
        }, 100);
    }
});

// Also initialize on modal show
if (typeof $ !== 'undefined') {
    $(document).on('show.bs.modal', '#employerAccountsMatrixModal', function() {
        setTimeout(() => {
            initializeMatrixPagination();
        }, 100);
    });
}

function openVisibilityModal(employerId, employerName, initialTab, tabMode) {
    console.log('🟢 openVisibilityModal() called for employer:', employerId, employerName);
    
    currentEmployerId = employerId;
    // If tabMode not specified, default to allowing both tabs
    modalTabMode = (tabMode === 'groups-only') ? 'groups-only' : 
                   (tabMode === 'visibility-only') ? 'visibility-only' : 'both-tabs';
    updateManageGroupsTabVisibility();
    activeModalTab = (modalTabMode === 'groups-only') ? 'groups' : 'visibility';
    
    // Update modal title
    document.getElementById('modalEmployerName').textContent = 'Edit: ' + employerName;
    
    // Enforce explicit tab visibility state to avoid accidental fallback.
    const visibilityTab = document.getElementById('visibility-tab-content');
    const groupsTab = document.getElementById('groups-tab-content');
    const tabToggleBtn = document.getElementById('visibilityModalTabToggle');
    const saveBtn = document.getElementById('visibilityModalSaveBtn');
    
    if (modalTabMode === 'groups-only') {
        if (visibilityTab) visibilityTab.style.display = 'none';
        if (groupsTab) groupsTab.style.display = 'block';
        if (tabToggleBtn) tabToggleBtn.style.display = 'none';
        if (saveBtn) saveBtn.style.display = 'none';
    } else {
        if (saveBtn) saveBtn.style.display = '';
        setModalTabButtonState(activeModalTab);
    }
    
    // If groups-only mode, load groups directly
    if (modalTabMode === 'groups-only') {
        loadEmployerGroups(employerId);
        
        // Show modal
        const modalElement = document.getElementById('visibilityModal');
        if (typeof jQuery !== 'undefined') {
            jQuery(modalElement).modal('show');
        } else if (typeof $ !== 'undefined' && $.fn.modal) {
            $(modalElement).modal('show');
        } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            new bootstrap.Modal(modalElement).show();
        }
        return;
    }
    
    // Fetch fresh visibility settings from server to avoid stale data
    fetch(baseUrl + 'adminpagevisibility/get_employer_visibility?employer_id=' + employerId)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.visibility) {
                // Clear old keys for this employer to prevent stale data from affecting counts
                pageSlugs.forEach(slug => {
                    const key = slug + '_' + employerId;
                    delete visibilitySettings[key];
                });
                // Update local JavaScript object with fresh data
                Object.keys(data.visibility).forEach(key => {
                    visibilitySettings[key] = data.visibility[key];
                });
            }
            
            // Now update checkboxes with current visibility state
            document.querySelectorAll('.visibility-checkbox').forEach(checkbox => {
                const pageSlug = checkbox.dataset.page;
                const visibilityKey = pageSlug + '_' + employerId;
                const isVisible = visibilitySettings[visibilityKey] ? true : false;
                
                checkbox.checked = isVisible;
                
                const badge = checkbox.closest('.page-item').querySelector('.status-badge');
                if (isVisible) {
                    badge.textContent = '✓ Visible';
                    badge.className = 'status-badge status-visible';
                } else {
                    badge.textContent = 'Hidden';
                    badge.className = 'status-badge status-hidden';
                }
            });
            
            // Attach event listeners
            attachCheckboxListeners();
            
            // Show modal
            console.log('About to show modal - checking jQuery...');
            const modalElement = document.getElementById('visibilityModal');
            if (typeof jQuery !== 'undefined') {
                console.log('✅ jQuery is available');
                jQuery(modalElement).modal('show');
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
                console.log('✅ jQuery $ is available');
                $(modalElement).modal('show');
            } else {
                console.error('❌ jQuery not available, trying Bootstrap Modal API');
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    new bootstrap.Modal(modalElement).show();
                } else {
                    console.error('❌ Bootstrap Modal also not available');
                }
            }
            console.log('✅ Modal show method called');
        })
        .catch(error => {
            console.error('Error fetching visibility settings:', error);
            // Fallback: use existing visibilitySettings data
            document.querySelectorAll('.visibility-checkbox').forEach(checkbox => {
                const pageSlug = checkbox.dataset.page;
                const visibilityKey = pageSlug + '_' + employerId;
                const isVisible = visibilitySettings[visibilityKey] ? true : false;
                
                checkbox.checked = isVisible;
                
                const badge = checkbox.closest('.page-item').querySelector('.status-badge');
                if (isVisible) {
                    badge.textContent = '✓ Visible';
                    badge.className = 'status-badge status-visible';
                } else {
                    badge.textContent = 'Hidden';
                    badge.className = 'status-badge status-hidden';
                }
            });
            
            attachCheckboxListeners();
            const modalElement = document.getElementById('visibilityModal');
            if (typeof jQuery !== 'undefined') {
                jQuery(modalElement).modal('show');
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
                $(modalElement).modal('show');
            }
        });
}

function openManageGroupsModal() {
    if (Array.isArray(employerData) && employerData.length > 0) {
        const targetEmployer = employerData[0];
        openVisibilityModal(targetEmployer.id, targetEmployer.display_name, 'groups', 'groups-only');
        return;
    }

    // If current table page is empty due pagination/search, fallback to full registry.
    fetchEmployerRegistry('')
        .then(registry => {
            if (!Array.isArray(registry) || registry.length === 0) {
                showNotification('No employers available for group management', 'error');
                return;
            }
            const targetEmployer = registry[0];
            openVisibilityModal(targetEmployer.id, targetEmployer.display_name, 'groups', 'groups-only');
        })
        .catch(() => {
            showNotification('Failed to load employer registry', 'error');
        });
}

function initializeMatrixTooltips() {
    if (typeof $ === 'undefined' || !$.fn || !$.fn.tooltip) {
        return;
    }

    const tooltipSelector = '#employerAccountsMatrixModal .matrix-checkbox-wrap[data-toggle="tooltip"]';
    $(tooltipSelector).tooltip('dispose');
    $(tooltipSelector).tooltip({
        container: 'body',
        trigger: 'hover'
    });
}

function openEmployerAccountsMatrixModal() {
    const modalElement = document.getElementById('employerAccountsMatrixModal');
    if (!modalElement) {
        showNotification('Employer accounts modal not found', 'error');
        return;
    }

    attachMatrixCheckboxListeners();
    initializeMatrixTooltips();

    if (typeof jQuery !== 'undefined') {
        jQuery(modalElement).modal('show');
    } else if (typeof $ !== 'undefined' && $.fn.modal) {
        $(modalElement).modal('show');
    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        new bootstrap.Modal(modalElement).show();
    }
}

function closeEmployerAccountsMatrixModal() {
    const modalElement = document.getElementById('employerAccountsMatrixModal');
    if (!modalElement) return;

    if (typeof jQuery !== 'undefined') {
        jQuery(modalElement).modal('hide');
    } else if (typeof $ !== 'undefined' && $.fn.modal) {
        $(modalElement).modal('hide');
    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getInstance(modalElement)?.hide();
    }
}

function loadEmployerGroups(employerId) {
    fetch(baseUrl + 'adminpagevisibility/get_employer_groups_data?employer_id=' + employerId)
        .then(response => response.json())
        .then(data => {
            availableGroups = data.all_groups || [];
            const currentGroups = data.current_groups || [];

            const currentGroupIds = new Set(currentGroups.map(group => String(group.id)));

            // Build unified groups card list
            let groupsHtml = '';
            if (availableGroups.length === 0) {
                groupsHtml = '<div class="empty-groups-message"><i class="fas fa-inbox"></i> No groups available. Create groups in the "Manage Groups" section.</div>';
            } else {
                availableGroups.forEach(group => {
                    const isAssigned = currentGroupIds.has(String(group.id));
                    const memberCount = Number(group.member_count || 0);
                    const safeGroupName = escapeHtml(group.group_name || 'Untitled Group');
                    const descriptionText = String(group.description || '').trim();
                    const safeDescription = descriptionText
                        ? escapeHtml(descriptionText)
                        : 'No description provided';

                    groupsHtml += `
                        <li class="list-group-item" data-group-id="${group.id}" onclick="openGroupMembersModal(${group.id})">
                            <div class="group-list-content">
                                <h6 class="group-list-title mb-1" data-group-id="${group.id}">${safeGroupName}</h6>
                                <p class="mb-1 group-description-preview" data-group-id="${group.id}">${safeDescription}</p>
                                <small class="group-member-count-muted">${memberCount} ${memberCount === 1 ? 'member' : 'members'}</small>
                            </div>
                            <div class="group-list-actions">
                                <span class="group-status-pill ${isAssigned ? 'assigned' : 'not-assigned'}">
                                    <i class="fas ${isAssigned ? 'fa-check-circle' : 'fa-minus-circle'}"></i>
                                    ${isAssigned ? 'Assigned' : 'Not Assigned'}
                                </span>
                                <button type="button" class="group-list-delete-btn" onclick="event.stopPropagation(); deleteGroup(${group.id}, '${String(group.group_name || '').replace(/\\/g, '\\\\').replace(/'/g, "\\'")}');" title="Delete group" aria-label="Delete group">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </li>
                    `;
                });
            }
            document.getElementById('groups-list').innerHTML = groupsHtml;
        })
        .catch(error => {
            console.error('Error loading groups:', error);
            document.getElementById('groups-list').innerHTML = '<div class="empty-groups-message"><i class="fas fa-exclamation-circle"></i> Error loading groups</div>';
        });

}
function toggleEmployerGroup(employerId, groupId, button) {
    const isAssigned = button.classList.contains('assigned');
    
    if (isAssigned) {
        removeEmployerFromGroup(employerId, groupId, button);
    } else {
        addEmployerToGroup(employerId, groupId, button);
    }
}

function addEmployerToGroup(employerId, groupId, button) {
    fetch(baseUrl + 'adminpagevisibility/add_employer_to_group', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'employer_id=' + employerId + '&group_id=' + groupId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadEmployerGroups(employerId);
            showNotification('Added to group successfully!', 'success');
        } else {
            showNotification(data.message || 'Failed to add to group', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function removeEmployerFromGroup(employerId, groupId, element) {
    fetch(baseUrl + 'adminpagevisibility/remove_employer_from_group', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'employer_id=' + employerId + '&group_id=' + groupId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadEmployerGroups(employerId);
            showNotification('Removed from group successfully!', 'success');
        } else {
            showNotification(data.message || 'Failed to remove from group', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function attachGroupNameEditingListeners() {
    document.querySelectorAll('.group-name-editable').forEach(element => {
        const groupId = element.dataset.groupId;
        const originalName = element.dataset.original;
        
        // Handle blur (save changes when focus lost)
        element.addEventListener('blur', function() {
            const newName = this.textContent.trim();
            if (newName && newName !== originalName) {
                saveGroupNameInline(groupId, originalName, newName, this);
            } else {
                // Revert to original if no change or empty
                this.textContent = originalName + ' ';
                this.appendChild(document.createElement('i')).className = 'group-edit-icon fas fa-pencil-alt';
            }
        });
        
        // Handle Enter key (save and blur)
        element.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.blur();
            }
            // Escape key to cancel
            if (e.key === 'Escape') {
                e.preventDefault();
                this.textContent = originalName + ' ';
                this.appendChild(document.createElement('i')).className = 'group-edit-icon fas fa-pencil-alt';
                this.blur();
            }
        });
        
        // Focus styling
        element.addEventListener('focus', function() {
            this.style.background = '#ffffff';
            this.style.outlineOffset = '2px';
        });
    });
}

function saveGroupNameInline(groupId, originalName, newName, element) {
    // Show loading state
    const previousHtml = element.innerHTML;
    element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    element.contentEditable = false;
    
    fetch(baseUrl + 'adminpagevisibility/update_group_name', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'group_id=' + encodeURIComponent(groupId) + '&group_name=' + encodeURIComponent(newName)
    })
    .then(response => response.json())
    .then(data => {
            if (data.success) {
            // Update the element with the new name
            element.textContent = newName + ' ';
            element.appendChild(document.createElement('i')).className = 'group-edit-icon fas fa-pencil-alt';
            element.dataset.original = newName;
            element.contentEditable = true;
            showNotification('Group name updated successfully!', 'success');

            try {
                // Update in-memory groups array
                const groupObj = availableGroups.find(g => String(g.id) === String(groupId));
                if (groupObj) groupObj.group_name = newName;

                // Update title element in the list if present
                const titleEl = document.querySelector(`.group-list-title[data-group-id="${groupId}"]`);
                if (titleEl) {
                    titleEl.textContent = newName;
                    titleEl.title = newName;
                }
            } catch (e) {
                console.warn('Failed to update group title in DOM', e);
            }

            // Reload groups to update all references (kept as fallback)
            if (currentEmployerId) {
                loadEmployerGroups(currentEmployerId);
            }
        } else {
            // Revert on error
            element.innerHTML = previousHtml;
            element.contentEditable = true;
            showNotification(data.message || 'Failed to update group name', 'error');
        }
    })
    .catch(error => {
        console.error('Error updating group name:', error);
        element.innerHTML = previousHtml;
        element.contentEditable = true;
        showNotification('An error occurred while updating group name', 'error');
    });
}

function attachCheckboxListeners() {
    document.querySelectorAll('.visibility-checkbox').forEach(checkbox => {
        checkbox.onchange = function() {
            const pageSlug = this.dataset.page;
            const employerId = currentEmployerId;
            const isVisible = this.checked ? 1 : 0;

            this.disabled = true;

            fetch(baseUrl + 'adminpagevisibility/toggle_employer_visibility', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'page_slug=' + encodeURIComponent(pageSlug) + 
                      '&employer_id=' + encodeURIComponent(employerId) + 
                      '&is_visible=' + encodeURIComponent(isVisible)
            })
            .then(response => response.json())
            .then(data => {
                this.disabled = false;

                if (data.success) {
                    visibilitySettings[pageSlug + '_' + employerId] = isVisible;

                    const badge = this.closest('.page-item').querySelector('.status-badge');
                    if (isVisible) {
                        badge.textContent = '✓ Visible';
                        badge.className = 'status-badge status-visible';
                    } else {
                        badge.textContent = 'Hidden';
                        badge.className = 'status-badge status-hidden';
                    }

                    updateEmployerVisibilityCounts(employerId);

                    showNotification('Updated successfully!', 'success');
                } else {
                    this.checked = !this.checked;
                    showNotification(data.message || 'Failed to update', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.disabled = false;
                this.checked = !this.checked;
                showNotification('An error occurred', 'error');
            });
        };
    });
}

function updateEmployerVisibilityCounts(employerId) {
    try {
        const row = document.querySelector('tr[data-employer-id="' + employerId + '"]');
        if (!row) return;

        const statCountEls = row.querySelectorAll('.visibility-stat .visibility-stat-item .stat-count');
        const visibleCountEl = statCountEls[0];
        const hiddenCountEl = statCountEls[1];

        let newVisible = 0;
        let totalPages = 0;

        pageSlugs.forEach(slug => {
            const key = slug + '_' + employerId;
            totalPages++;
            if (visibilitySettings[key] === 1 || visibilitySettings[key] === true) {
                newVisible++;
            }
        });

        const newHidden = totalPages - newVisible;
        if (visibleCountEl) visibleCountEl.textContent = newVisible;
        if (hiddenCountEl) hiddenCountEl.textContent = newHidden;
    } catch (e) {
        console.error('Failed to update counts:', e);
    }
}

function attachMatrixCheckboxListeners() {
    document.querySelectorAll('.matrix-visibility-checkbox').forEach(checkbox => {
        checkbox.onchange = function() {
            const pageSlug = this.dataset.page;
            const employerId = this.dataset.employerId;
            const isVisible = this.checked ? 1 : 0;

            this.disabled = true;

            fetch(baseUrl + 'adminpagevisibility/toggle_employer_visibility', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'page_slug=' + encodeURIComponent(pageSlug) +
                      '&employer_id=' + encodeURIComponent(employerId) +
                      '&is_visible=' + encodeURIComponent(isVisible)
            })
            .then(response => response.json())
            .then(data => {
                this.disabled = false;

                if (data.success) {
                    visibilitySettings[pageSlug + '_' + employerId] = isVisible;
                    updateEmployerVisibilityCounts(employerId);
                    showNotification('Updated successfully!', 'success');
                } else {
                    this.checked = !this.checked;
                    showNotification(data.message || 'Failed to update', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.disabled = false;
                this.checked = !this.checked;
                showNotification('An error occurred', 'error');
            });
        };
    });
}

function showNotification(message, type) {
    // Log to console
    if (type === 'success') {
        console.log('✓ ' + message);
    } else {
        console.error('✗ ' + message);
    }
    
    // Show browser alert for critical messages
    if (type === 'error' && message.toLowerCase().includes('error')) {
        console.warn('User notification:', message);
    }
}

function toggleEmployerStatus(employerId, element, event) {
    if (event) {
        event.stopPropagation();
    }

    // Remove any existing dropdowns
    document.querySelectorAll('.status-dropdown-menu').forEach(menu => menu.remove());

    // Store reference to the badge element globally for use in selectEmployerStatus
    window.currentStatusBadgeElement = element;
    window.currentEmployerStatusId = employerId;

    // Create dropdown menu
    const currentStatus = element.dataset.status;
    const dropdown = document.createElement('div');
    dropdown.className = 'status-dropdown-menu';
    
    const options = [
        { value: 'active', label: 'Active', icon: 'fa-check-circle' },
        { value: 'inactive', label: 'Inactive', icon: 'fa-times-circle' },
        { value: 'suspended', label: 'Suspended', icon: 'fa-pause-circle' }
    ];

    const menuHtml = options
        .map(opt => `
            <div class="status-dropdown-item ${opt.value === currentStatus ? 'active' : ''}" 
                 onclick="selectEmployerStatus('${opt.value}', event)">
                <i class="fas ${opt.icon}"></i>
                <span>${opt.label}</span>
                ${opt.value === currentStatus ? '<i class="fas fa-check" style="margin-left: auto;"></i>' : ''}
            </div>
        `)
        .join('');

    dropdown.innerHTML = menuHtml;
    
    // Append to body to avoid overflow clipping
    document.body.appendChild(dropdown);
    
    // Position dropdown relative to viewport
    const rect = element.getBoundingClientRect();
    dropdown.style.position = 'fixed';
    dropdown.style.top = (rect.bottom + 8) + 'px';
    dropdown.style.left = rect.left + 'px';
    dropdown.style.zIndex = '9999';

    // Close dropdown when clicking outside
    const closeDropdown = (e) => {
        if (!dropdown.contains(e.target) && !element.contains(e.target)) {
            dropdown.remove();
            document.removeEventListener('click', closeDropdown);
        }
    };
    setTimeout(() => {
        document.addEventListener('click', closeDropdown);
    }, 10);
}

function selectEmployerStatus(newStatus, event) {
    if (event) {
        event.stopPropagation();
    }

    // Get stored references
    const badgeElement = window.currentStatusBadgeElement;
    const employerId = window.currentEmployerStatusId;
    
    if (!badgeElement || !employerId) {
        console.error('Badge element or employer ID not found');
        return;
    }

    const currentStatus = badgeElement.dataset.status;

    // Remove dropdown
    document.querySelectorAll('.status-dropdown-menu').forEach(menu => menu.remove());

    // Update UI immediately for better UX
    updateEmployerStatusBadge(badgeElement, newStatus);

    // Log the request for debugging
    const requestBody = 'employer_id=' + encodeURIComponent(employerId) + '&status=' + encodeURIComponent(newStatus);
    console.log('Sending request:', {
        url: baseUrl + 'adminpagevisibility/update_employer_status',
        body: requestBody,
        employerId: employerId,
        newStatus: newStatus
    });

    // Send to server
    fetch(baseUrl + 'adminpagevisibility/update_employer_status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: requestBody
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        try {
            const data = JSON.parse(text);
            console.log('Parsed data:', data);
            if (data.success) {
                showNotification('Employer status updated', 'success');
            } else {
                showNotification(data.message || 'Failed to update employer status', 'error');
                // Revert UI change on error
                updateEmployerStatusBadge(badgeElement, currentStatus);
            }
        } catch (e) {
            console.error('JSON parse error:', e, 'Text:', text);
            showNotification('Server error: Invalid response', 'error');
            updateEmployerStatusBadge(badgeElement, currentStatus);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showNotification('An error occurred: ' + error.message, 'error');
        // Revert UI change on error
        updateEmployerStatusBadge(badgeElement, currentStatus);
    });
}

function updateEmployerStatusBadge(element, status) {
    const statusIcons = {
        'active': '<i class="fas fa-check-circle" style="margin-right: 4px;"></i>Active',
        'inactive': '<i class="fas fa-times-circle" style="margin-right: 4px;"></i>Inactive',
        'suspended': '<i class="fas fa-pause-circle" style="margin-right: 4px;"></i>Suspended'
    };

    // Update classes
    element.classList.remove('status-active', 'status-inactive', 'status-suspended');
    element.classList.add('status-' + status);
    
    // Update content
    element.innerHTML = statusIcons[status];
    element.dataset.status = status;
    element.title = 'Click to change status';
}

function viewEmployerDetails(employerId, employerName) {
    fetch(baseUrl + 'adminpagevisibility/get_employer_details?employer_id=' + employerId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const employer = data.employer;
                const firstName = employer.first_name || '';
                const lastName = employer.last_name || '';
                const fullName = [firstName, lastName].filter(Boolean).join(' ').trim() || 'N/A';
                const statusValue = String(employer.is_active !== undefined && employer.is_active !== null ? employer.is_active : employer.status || '').toLowerCase();
                const isActive = statusValue === '1' || statusValue === 'active';
                const statusBadgeClass = isActive ? 'status-active' : 'status-inactive';
                const statusBadgeLabel = isActive ? 'Active' : 'Inactive';
                let html = `
                    <div class="details-grid">
                        <div class="detail-item">
                            <span class="detail-label">First Name</span>
                            <span class="detail-value accent">${escapeHtml(firstName || 'N/A')}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Last Name</span>
                            <span class="detail-value accent">${escapeHtml(lastName || 'N/A')}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Full Name</span>
                            <span class="detail-value">${escapeHtml(fullName)}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Company Name</span>
                            <span class="detail-value accent">${escapeHtml(employer.company_name || 'N/A')}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Email</span>
                            <span class="detail-value">${escapeHtml(employer.email)}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Contact Person</span>
                            <span class="detail-value">${escapeHtml(employer.contact_person || 'N/A')}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Phone</span>
                            <span class="detail-value">${escapeHtml(employer.phone || 'N/A')}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Industry</span>
                            <span class="detail-value">${escapeHtml(employer.industry || 'N/A')}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Location</span>
                            <span class="detail-value">${escapeHtml(employer.location || 'N/A')}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Account Status</span>
                            <span class="status-badge ${statusBadgeClass}" style="margin-left: 0; display: inline-flex; width: fit-content; align-items: center;">${statusBadgeLabel}</span>
                        </div>
                    </div>

                    <div class="details-section">
                        <span class="details-section-title">Account Status</span>
                        <div class="details-grid">
                            <div class="detail-item">
                                <span class="detail-label">Status</span>
                                <span class="status-badge ${statusBadgeClass}" style="margin-left: 0; display: inline-flex; width: fit-content; align-items: center;">${statusBadgeLabel}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Registered Date</span>
                                <span class="detail-value">${formatDate(employer.created_at)}</span>
                            </div>
                        </div>
                    </div>

                    <div class="details-section">
                        <span class="details-section-title">Website & Social</span>
                        <div class="details-grid">
                            <div class="detail-item">
                                <span class="detail-label">Website</span>
                                <span class="detail-value">${employer.website ? '<a href="' + employer.website + '" target="_blank">' + escapeHtml(employer.website) + '</a>' : 'N/A'}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">About</span>
                                <span class="detail-value">${escapeHtml(employer.about || 'N/A')}</span>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('employer-details-content').innerHTML = html;
                $('#employerDetailsModal').modal('show');
            } else {
                showNotification('Failed to load employer details', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
}

function escapeHtml(text) {
    if (!text) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

function openEmployerRowDetails(row) {
    if (!row) return;

    const employerId = row.dataset.employerId;
    const employerName = row.dataset.employerName || '';

    if (!employerId) return;

    viewEmployerDetails(employerId, employerName);
}

function attachEmployerRowListeners() {
    document.querySelectorAll('tr.data-row').forEach(row => {
        if (row.dataset.rowListenerAttached === '1') {
            return;
        }

        row.dataset.rowListenerAttached = '1';

        row.addEventListener('click', function(event) {
            if (event.target.closest('button, a, input, label, .status-badge')) {
                return;
            }

            openEmployerRowDetails(this);
        });

        row.addEventListener('keydown', function(event) {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }

            if (event.target.closest('button, a, input, label, .status-badge')) {
                return;
            }

            event.preventDefault();
            openEmployerRowDetails(this);
        });
    });
}

// Reload page when modal closes to refresh table stats
$('#visibilityModal').on('hidden.bs.modal', function() {
    if (!openingGroupCreationModal && !suppressVisibilityModalReload) {
        console.log('Visibility modal closed - reloading page');
        location.reload();
    } else {
        console.log('Group creation modal is opening - skipping page reload');
    }
});

function saveVisibilityChanges() {
    // Changes are saved automatically as checkboxes are toggled
    // Close the modal which will trigger a page reload
    $('#visibilityModal').modal('hide');
}

function deleteEmployer(employerId, employerName) {
    if (!confirm('Are you sure you want to delete ' + employerName + '? This action cannot be undone.')) {
        return;
    }

    fetch(baseUrl + 'adminpagevisibility/delete_employer', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'employer_id=' + encodeURIComponent(employerId)
    })
    .then(response => {
        const ct = response.headers.get('content-type') || '';
        if (ct.includes('application/json')) {
            return response.json();
        }
        // If server returned HTML (error page) or plain text, capture it for debugging
        return response.text().then(text => { throw new Error('NON_JSON_RESPONSE:\n' + text); });
    })
    .then(data => {
        if (data.success) {
            showNotification('Employer deleted successfully!', 'success');
            setTimeout(() => { location.reload(); }, 1000);
        } else {
            showNotification(data.message || 'Failed to delete employer', 'error');
        }
    })
    .catch(error => {
        console.error('Error deleting employer:', error);
        // If server returned HTML, log it separately to help debugging
        if (error.message && error.message.startsWith('NON_JSON_RESPONSE:')) {
            console.error('Server response (non-JSON):', error.message.replace('NON_JSON_RESPONSE:\n', ''));
            showNotification('Server error while deleting employer. Check console for details.', 'error');
        } else {
            showNotification('An error occurred while deleting employer', 'error');
        }
    });
}

function deleteGroup(groupId, groupName) {
    if (confirm('Are you sure you want to delete the group "' + groupName + '"? This action cannot be undone. The employers in this group will not be deleted, only the group itself.')) {
        fetch(baseUrl + 'adminpagevisibility/delete_group', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'group_id=' + encodeURIComponent(groupId)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Group deleted successfully!', 'success');
                if (currentEmployerId) {
                    loadEmployerGroups(currentEmployerId);
                } else {
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            } else {
                showNotification(data.message || 'Failed to delete group', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while deleting group', 'error');
        });
    }
}

function openGroupMembersModal(groupId) {
    // Get the group's members from availableGroups
    const group = availableGroups.find(g => g.id == groupId);
    if (!group) {
        showNotification('Group not found', 'error');
        return;
    }

    activeGroupModalContext = {
        groupId: groupId,
        groupName: group.group_name || 'Group',
        description: group.description || ''
    };

    // Fetch group members and employers data
    fetch(baseUrl + 'adminpagevisibility/get_group_members?group_id=' + groupId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const members = data.members || [];
                const availableEmployers = data.available_employers || [];

                // Build modal content for managing members
                let membersHtml = '<div class="group-members-modal-content">';

                const descriptionText = String(group.description || '').trim();

                // Group details card (SB Admin style)
                membersHtml += `
                    <div class="card bg-light group-details-card">
                        <div class="card-body p-3">
                            <div class="group-name-edit-section">
                                <label for="modalGroupNameInput" class="group-name-edit-label">Group Name <i class="fas fa-pencil-alt ml-1 text-muted" style="font-size:11px;"></i></label>
                                <div class="group-name-edit-row">
                                    <input type="text" id="modalGroupNameInput" class="group-name-edit-input" value="${escapeHtml(group.group_name || '')}" placeholder="Enter group name">
                                </div>
                            </div>
                            <div class="group-description-edit-section mb-0">
                                <label for="modalGroupDescriptionInput" class="group-description-edit-label">Description</label>
                                <div class="group-description-edit-row mb-0">
                                    <textarea id="modalGroupDescriptionInput" class="group-description-edit-textarea" placeholder="Enter group description">${escapeHtml(descriptionText)}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Add member section
                membersHtml += '<h5 class="group-members-modal-title">Add Member to Group</h5>';
                membersHtml += '<div class="group-members-action-row">';
                membersHtml += '<div class="input-group group-members-input-group">';
                membersHtml += '<select id="groupMemberSelect" class="custom-select group-members-select">';
                membersHtml += '<option value="">Select an employer...</option>';
                availableEmployers.forEach(emp => {
                    membersHtml += `<option value="${emp.id}">${emp.display_name}</option>`;
                });
                membersHtml += '</select>';
                membersHtml += '<div class="input-group-append">';
                membersHtml += `<button onclick="addMemberToGroup(${groupId})" class="btn group-members-add-btn" type="button"><i class="fas fa-plus mr-1"></i>Add</button>`;
                membersHtml += '</div>';
                membersHtml += '</div>';
                membersHtml += '</div>';

                // Members list section
                membersHtml += '<h5 class="group-members-modal-title">Current Members (' + members.length + ')</h5>';
                if (members.length === 0) {
                    membersHtml += '<p class="group-members-empty">No members in this group yet</p>';
                } else {
                    membersHtml += '<div class="group-members-list list-group">';
                    members.forEach(member => {
                        membersHtml += `
                            <div class="list-group-item group-member-item">
                                <div class="group-member-meta">
                                    <div class="group-member-avatar">${escapeHtml(getPersonInitials(member))}</div>
                                    <span class="group-member-name">${escapeHtml(getPersonDisplayName(member))}</span>
                                </div>
                                <button type="button" onclick="removeMemberFromGroup(${groupId}, ${member.id})" class="btn-member-remove btn-action-delete" title="Remove member">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                    });
                    membersHtml += '</div>';
                }
                
                membersHtml += '</div>';

                // Show custom modal
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.id = 'groupMembersModal';
                modal.tabIndex = -1;
                modal.innerHTML = `
                    <div class="modal-dialog group-members-modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Manage Members: ${escapeHtml(group.group_name || 'Group')}</h5>
                                <button type="button" class="close" onclick="closeGroupMembersModal()" aria-label="Close">
                                    <span aria-hidden="true" class="modal-close">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ${membersHtml}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn-modal-cancel" onclick="closeGroupMembersModal()">Close</button>
                                <button type="button" class="btn-modal-save" onclick="saveGroupDescriptionFromModal(${groupId})">
                                    <i class="fas fa-save mr-2"></i>Save Description
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                // Remove existing modal if present
                const existing = document.getElementById('groupMembersModal');
                if (existing) existing.remove();
                
                document.body.appendChild(modal);

                // Add live-update for the group name input so changes show immediately in the list
                const appendedModal = document.getElementById('groupMembersModal');
                if (appendedModal) {
                    const nameInputEl = appendedModal.querySelector('#modalGroupNameInput');
                    if (nameInputEl) {
                        nameInputEl.addEventListener('input', function() {
                            try {
                                const titleEl = document.querySelector(`.group-list-title[data-group-id="${groupId}"]`);
                                if (titleEl) {
                                    titleEl.textContent = this.value || (group.group_name || 'Untitled Group');
                                    titleEl.title = this.value || (group.group_name || 'Untitled Group');
                                }
                            } catch (e) {
                                console.warn('Failed live-updating group title from modal input', e);
                            }
                        });
                    }
                }
                
                // Avoid stacked modals: hide visibility modal first (and suppress its reload-on-close).
                suppressVisibilityModalReload = true;
                if ($('#visibilityModal').hasClass('show') || $('#visibilityModal').hasClass('in')) {
                    $('#visibilityModal').modal('hide');
                }
                
                $(modal).modal('show');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load group members', 'error');
        });
}

function closeGroupMembersModal() {
    const modal = document.getElementById('groupMembersModal');
    if (modal) {
        $(modal).modal('hide');
        setTimeout(() => modal.remove(), 300);
    }
    
    // Restore the Manage Groups modal without triggering the auto-reload hook.
    if (typeof $ !== 'undefined' && $.fn && $.fn.modal) {
        const visibilityModalEl = document.getElementById('visibilityModal');
        if (visibilityModalEl && currentEmployerId) {
            setTimeout(() => {
                $('#visibilityModal').modal('show');
                suppressVisibilityModalReload = false;
            }, 320);
        } else {
            suppressVisibilityModalReload = false;
        }
    } else {
        suppressVisibilityModalReload = false;
    }

    activeGroupModalContext = null;
}

function saveGroupNameFromModal(groupId) {
    const newGroupName = document.getElementById('modalGroupNameInput').value.trim();
    
    if (!newGroupName) {
        showNotification('Group name cannot be empty', 'error');
        return;
    }

    const formData = new FormData();
    formData.append('group_id', groupId);
    formData.append('group_name', newGroupName);

    fetch(baseUrl + 'adminpagevisibility/update_group_name', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Group name updated successfully', 'success');

            // Update the modal title
            document.querySelector('.group-members-modal-dialog .modal-title').textContent = 'Manage Members: ' + newGroupName;

            try {
                // Update in-memory groups array
                const groupObj = availableGroups.find(g => String(g.id) === String(groupId));
                if (groupObj) groupObj.group_name = newGroupName;

                // Update title element in the list if present
                const titleEl = document.querySelector(`.group-list-title[data-group-id="${groupId}"]`);
                if (titleEl) {
                    titleEl.textContent = newGroupName;
                    titleEl.title = newGroupName;
                }
            } catch (e) {
                console.warn('Failed to update group title in DOM after modal save', e);
            }

            // Refresh the groups list (fallback)
            if (currentEmployerId) {
                loadEmployerGroups(currentEmployerId);
            }
        } else {
            showNotification(data.message || 'Failed to update group name', 'error');
        }
    })
    .catch(error => {
        console.error('Error updating group name:', error);
        showNotification('Error updating group name', 'error');
    });
}

function saveGroupDescriptionFromModal(groupId) {
    const newDescription = document.getElementById('modalGroupDescriptionInput').value.trim();
    const newName = (document.getElementById('modalGroupNameInput') || {}).value?.trim();

    const formData = new FormData();
    formData.append('group_id', groupId);
    formData.append('description', newDescription);

    fetch(baseUrl + 'adminpagevisibility/update_group_description', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(body => {
                throw new Error(`HTTP ${response.status}: ${body.slice(0, 120)}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification('Description updated successfully', 'success');

            const group = availableGroups.find(g => String(g.id) === String(groupId));
            if (group) {
                group.description = newDescription;
            }

            const previewEl = document.querySelector(`.group-description-preview[data-group-id="${groupId}"]`);
            if (previewEl) {
                previewEl.textContent = newDescription || 'No description provided';
                previewEl.title = newDescription || 'No description provided';
            }
            
            // If the modal name input changed, persist and update title in-place
            try {
                const titleEl = document.querySelector(`.group-list-title[data-group-id="${groupId}"]`);
                if (newName && group && String(group.group_name || '') !== String(newName)) {
                    // Persist name change
                    const nameForm = new FormData();
                    nameForm.append('group_id', groupId);
                    nameForm.append('group_name', newName);

                    fetch(baseUrl + 'adminpagevisibility/update_group_name', {
                        method: 'POST',
                        body: nameForm
                    })
                    .then(r => r.json())
                    .then(nameResp => {
                        if (nameResp && nameResp.success) {
                            if (group) group.group_name = newName;
                            if (titleEl) {
                                titleEl.textContent = newName;
                                titleEl.title = newName;
                            }
                            // Update modal title if present
                            const modalTitle = document.querySelector('.group-members-modal-dialog .modal-title');
                            if (modalTitle) modalTitle.textContent = 'Manage Members: ' + newName;
                            showNotification('Group name updated successfully', 'success');
                        } else {
                            showNotification(nameResp.message || 'Failed to update group name', 'error');
                        }
                    })
                    .catch(err => {
                        console.error('Error updating group name:', err);
                        showNotification('Error updating group name', 'error');
                    });
                } else if (titleEl && newName) {
                    // Just update title element if name matches
                    titleEl.textContent = newName;
                    titleEl.title = newName;
                }
            } catch (e) {
                console.warn('Failed to persist/update group name after description save', e);
            }

            // Refresh the groups list (fallback)
            if (currentEmployerId) {
                loadEmployerGroups(currentEmployerId);
            }
        } else {
            showNotification(data.message || 'Failed to update description', 'error');
        }
    })
    .catch(error => {
        console.error('Error updating description:', error);
        showNotification('Error updating description', 'error');
    });
}

function addMemberToGroup(groupId) {
    const select = document.getElementById('groupMemberSelect');
    const employerId = select.value;
    
    if (!employerId) {
        showNotification('Please select an employer', 'warning');
        return;
    }

    fetch(baseUrl + 'adminpagevisibility/add_employer_to_group', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'employer_id=' + encodeURIComponent(employerId) + '&group_id=' + encodeURIComponent(groupId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Member added to group', 'success');
            loadEmployerGroups(currentEmployerId);
            closeGroupMembersModal();
            setTimeout(() => {
                openGroupMembersModal(groupId);
            }, 340);
        } else {
            showNotification(data.message || 'Failed to add member', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function removeMemberFromGroup(groupId, employerId) {
    if (!confirm('Are you sure you want to remove this member from the group?')) {
        return;
    }

    fetch(baseUrl + 'adminpagevisibility/remove_employer_from_group', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'employer_id=' + encodeURIComponent(employerId) + '&group_id=' + encodeURIComponent(groupId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Member removed from group', 'success');
            loadEmployerGroups(currentEmployerId);
            closeGroupMembersModal();
            setTimeout(() => {
                openGroupMembersModal(groupId);
            }, 340);
        } else {
            showNotification(data.message || 'Failed to remove member', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function openGroupNameEditor(groupId, currentGroupName, memberCount) {
    document.getElementById('groupEditId').value = String(groupId);
    document.getElementById('groupEditInput').value = currentGroupName || '';
    document.getElementById('groupEditPreviewName').textContent = currentGroupName || 'Group Name';
    document.getElementById('groupEditPreviewId').textContent = String(groupId);
    document.getElementById('groupEditPreviewMembers').textContent = String(memberCount || 0);

    const modalElement = document.getElementById('groupEditModal');
    if (typeof $ !== 'undefined' && $.fn.modal) {
        $(modalElement).modal('show');
        setTimeout(() => {
            const input = document.getElementById('groupEditInput');
            if (input) input.focus();
        }, 200);
    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        new bootstrap.Modal(modalElement).show();
    }
}

function saveGroupNameEdit() {
    const groupId = document.getElementById('groupEditId').value;
    const groupNameInput = document.getElementById('groupEditInput');
    const newGroupName = (groupNameInput?.value || '').trim();
    const existingName = (document.getElementById('groupEditPreviewName')?.textContent || '').trim();

    if (!groupId) {
        showNotification('Invalid group ID', 'error');
        return;
    }

    if (!newGroupName) {
        showNotification('Group name is required', 'error');
        return;
    }

    if (newGroupName === existingName) {
        $('#groupEditModal').modal('hide');
        return;
    }

    fetch(baseUrl + 'adminpagevisibility/update_group_name', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'group_id=' + encodeURIComponent(groupId) + '&group_name=' + encodeURIComponent(newGroupName)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Group name updated successfully!', 'success');
            $('#groupEditModal').modal('hide');
            if (currentEmployerId) {
                loadEmployerGroups(currentEmployerId);
            }
        } else {
            showNotification(data.message || 'Failed to update group name', 'error');
        }
    })
    .catch(error => {
        console.error('Error updating group name:', error);
        showNotification('An error occurred while updating group name', 'error');
    });
}

function openAddEmployer() {
    // Reset form
    const employerForm = document.getElementById('employerForm');
    if (employerForm) {
        employerForm.reset();
    }
    
    // Clear any previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.remove());
    
    // Show modal
    const modalElement = document.getElementById('employerModal');
    if (typeof $ !== 'undefined' && $.fn.modal) {
        $(modalElement).modal('show');
    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        new bootstrap.Modal(modalElement).show();
    }
}

// Handle employer form submission
document.addEventListener('DOMContentLoaded', function() {
    const employerForm = document.getElementById('employerForm');
    if (employerForm) {
        employerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            
            // Submit to server
            fetch(baseUrl + 'adminpagevisibility/create_employer', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Employer created successfully!', 'success');
                    // Close modal
                    const modalElement = document.getElementById('employerModal');
                    if (typeof $ !== 'undefined' && $.fn.modal) {
                        $(modalElement).modal('hide');
                    }
                    // Reload page after short delay
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || 'Failed to create employer', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while creating employer', 'error');
            });
        });
    }

    attachEmployerRowListeners();
});

// Group Creation Functionality
let selectedGroupEmployers = [];

function fetchEmployerRegistry(searchTerm) {
    const query = encodeURIComponent(searchTerm || '');
    return fetch(baseUrl + 'adminpagevisibility/get_employer_registry?search=' + query)
        .then(response => response.json())
        .then(data => {
            if (data && data.success && Array.isArray(data.employers)) {
                employerRegistryData = data.employers;
                // Normalize display names from first_name + last_name
                employerRegistryData.forEach(emp => {
                    const first = (emp.first_name || '').trim();
                    const last = (emp.last_name || '').trim();
                    let disp = (first || last) ? (first + ' ' + last).trim() : '';
                    if (!disp) disp = emp.company_name || '';
                    emp.display_name = disp;
                });
                return employerRegistryData;
            }
            employerRegistryData = [];
            return employerRegistryData;
        })
        .catch(error => {
            console.error('Error fetching employer registry:', error);
            employerRegistryData = [];
            return employerRegistryData;
        });
}

function openGroupCreationModal() {
    try {
        console.log('🟢 openGroupCreationModal() called');
        openingGroupCreationModal = true;  // Set flag to prevent page reload
        selectedGroupEmployers = [];
        const nameInput = document.getElementById('groupNameInput');
        const descriptionInput = document.getElementById('groupDescriptionInput');
        const searchInput = document.getElementById('groupEmployerSearch');
        const modalElement = document.getElementById('groupCreationModal');
        const visibilityModalElement = document.getElementById('visibilityModal');
        
        console.log('Modal element:', modalElement);
        console.log('Name input:', nameInput);
        console.log('Search input:', searchInput);
        
        if (!nameInput || !searchInput) {
            console.error('❌ Group creation modal elements not found');
            openingGroupCreationModal = false;
            showNotification('Error: Modal elements not found', 'error');
            return;
        }
        
        if (!modalElement) {
            console.error('❌ Modal HTML element not found in DOM');
            openingGroupCreationModal = false;
            showNotification('Error: Modal not found in page', 'error');
            return;
        }
        
        nameInput.value = '';
        if (descriptionInput) {
            descriptionInput.value = '';
        }
        searchInput.value = '';
        
        // Remove old event listeners and attach fresh one
        const newSearchInput = searchInput.cloneNode(true);
        searchInput.parentNode.replaceChild(newSearchInput, searchInput);
        
        // Attach search event listener to fresh input
        newSearchInput.addEventListener('input', function() {
            console.log('🔍 Search triggered with:', this.value);
            console.log('Current selectedGroupEmployers:', selectedGroupEmployers);
            populateGroupEmployersList(this.value);
        });
        
        fetchEmployerRegistry('').then(() => {
            populateGroupEmployersList('');
        });
        updateSelectedEmployersPreview();
        
        console.log('Closing visibility modal temporarily...');
        // Close visibility modal to bring group creation modal to front
        if (typeof $ !== 'undefined' && $.fn.modal && visibilityModalElement) {
            $(visibilityModalElement).modal('hide');
        }
        
        console.log('Showing modal: #groupCreationModal');
        
        // Try Bootstrap 4 modal API
        if (typeof $ !== 'undefined' && $.fn.modal) {
            console.log('Using jQuery Bootstrap modal');
            $(modalElement).modal('show');
        } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            console.log('Using Bootstrap 5 modal API');
            new bootstrap.Modal(modalElement).show();
        } else {
            console.error('❌ Bootstrap Modal not available');
            openingGroupCreationModal = false;
            showNotification('Error: Bootstrap Modal not available', 'error');
            return;
        }
        
        // Reset flag after modal is shown
        setTimeout(() => {
            openingGroupCreationModal = false;
        }, 500);
        
        console.log('✅ Modal shown successfully');
    } catch (error) {
        console.error('❌ Error opening group creation modal:', error);
        console.error('Stack:', error.stack);
        openingGroupCreationModal = false;
        showNotification('Error: ' + error.message, 'error');
    }
}

function populateGroupEmployersList(searchTerm) {
    const listContainer = document.getElementById('groupEmployersSelectList');
    if (!listContainer) {
        console.error('❌ groupEmployersSelectList container not found!');
        return;
    }
    
    const searchLower = (searchTerm || '').toLowerCase().trim();
    
    console.log('===== populateGroupEmployersList =====');
    console.log('Search term:', `"${searchTerm}"`);
    console.log('Search lower:', `"${searchLower}"`);
    console.log('selectedGroupEmployers BEFORE render:', selectedGroupEmployers);
    console.log('employerRegistryData length:', employerRegistryData ? employerRegistryData.length : 0);
    
    let html = '';
    let matchCount = 0;
    let renderedCount = 0;
    
    if (!employerRegistryData || employerRegistryData.length === 0) {
        console.error('❌ employerRegistryData is empty or undefined');
        listContainer.innerHTML = '<div style="padding: 20px; text-align: center; color: var(--text-muted);">No employer data available</div>';
        return;
    }
    
    employerRegistryData.forEach(employer => {
        const companyNameLower = (employer.display_name || '').toLowerCase();
        const matchesSearch = !searchLower || companyNameLower.includes(searchLower);
        const isSelected = selectedGroupEmployers.some(e => {
            const strictMatch = e.id === employer.id;
            const looseMatch = e.id == employer.id && strictMatch === false;
            if (looseMatch) {
                console.warn(`⚠️ Type mismatch: employer.id=${employer.id} (${typeof employer.id}) vs e.id=${e.id} (${typeof e.id})`);
            }
            return strictMatch || looseMatch;
        });
        
        if (matchesSearch) {
            matchCount++;
            const checked = isSelected ? 'checked="checked"' : '';
            // Build display name from first_name + last_name
            const firstName = (employer.first_name || '').trim();
            const lastName = (employer.last_name || '').trim();
            const employerDisplayName = (firstName || lastName) 
                ? (firstName + ' ' + lastName).trim() 
                : (employer.company_name || '');
            
            console.log(`✓ ID=${employer.id}, Name="${employerDisplayName}", Selected=${isSelected}, Matches=${matchesSearch}, HTML_checked="${checked}"`);
            
            html += `
                <div class="employer-checkbox-item">
                    <input type="checkbox" 
                           id="emp-check-${employer.id}"
                           ${checked}
                           onchange="toggleGroupEmployer(${employer.id}, '${employerDisplayName.replace(/'/g, "\\'")}', this)">
                    <label class="employer-checkbox-label" for="emp-check-${employer.id}">
                        ${employerDisplayName}
                    </label>
                </div>
            `;
            renderedCount++;
        }
    });
    
    if (html === '') {
        html = '<div style="padding: 20px; text-align: center; color: var(--text-muted);">No employers found</div>';
    }
    
    console.log(`📊 Rendered ${renderedCount} of ${matchCount} matched employers`);
    console.log(`📊 Total selected: ${selectedGroupEmployers.length}`);
    console.log('===== END populateGroupEmployersList =====');
    
    listContainer.innerHTML = html;
}

function toggleGroupEmployer(employerId, employerName, checkbox) {
    console.log(`toggleGroupEmployer called: ID=${employerId}, Name="${employerName}", Checked=${checkbox.checked}`);
    
    if (checkbox.checked) {
        if (!selectedGroupEmployers.some(e => e.id === employerId)) {
            selectedGroupEmployers.push({ id: employerId, name: employerName });
            console.log(`✓ Added employer ${employerId} to selection`);
        } else {
            console.log(`⚠ Employer ${employerId} already in selection`);
        }
    } else {
        const before = selectedGroupEmployers.length;
        selectedGroupEmployers = selectedGroupEmployers.filter(e => e.id !== employerId);
        const after = selectedGroupEmployers.length;
        if (before > after) {
            console.log(`✓ Removed employer ${employerId} from selection`);
        } else {
            console.log(`⚠ Employer ${employerId} was not in selection`);
        }
    }
    
    console.log('Current selection:', selectedGroupEmployers);
    updateSelectedEmployersPreview();
}

function updateSelectedEmployersPreview() {
    const container = document.getElementById('selectedEmployersContainer');
    
    // Update badge on Create Group button
    if (selectedGroupEmployers.length === 0) {
        container.innerHTML = '<span style="color: var(--text-muted); font-size: 13px;">No employers selected</span>';
        return;
    }
    
    let html = '';
    selectedGroupEmployers.forEach(employer => {
        html += `
            <div class="selected-employer-tag">
                <span>${employer.name}</span>
                <button class="remove-tag" type="button" onclick="removeGroupEmployer(${employer.id})" title="Remove">×</button>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function removeGroupEmployer(employerId) {
    selectedGroupEmployers = selectedGroupEmployers.filter(e => e.id !== employerId);
    document.getElementById(`emp-check-${employerId}`).checked = false;
    updateSelectedEmployersPreview();
}

function createNewGroup() {
    console.log('🔵 createNewGroup() called');
    console.log('Selected employers:', selectedGroupEmployers);
    console.log('Selected employers length:', selectedGroupEmployers.length);
    try {
        const groupName = document.getElementById('groupNameInput').value.trim();
        const groupDescription = (document.getElementById('groupDescriptionInput')?.value || '').trim();
        
        if (!groupName) {
            showNotification('Please enter a group name', 'error');
            return;
        }
        
        if (selectedGroupEmployers.length === 0) {
            showNotification('Please select at least one employer', 'error');
            return;
        }
        
        // Build confirmation message
        const employerList = selectedGroupEmployers.map(e => e.name).join('\n• ');
        const descriptionLine = groupDescription ? `\nDescription: ${groupDescription}` : '';
        const confirmMessage = `Create group "${groupName}" with:\n\n• ${employerList}\n\nTotal: ${selectedGroupEmployers.length} employer(s)${descriptionLine}`;
        
        if (!confirm(confirmMessage)) {
            console.log('Group creation cancelled by user');
            return;
        }
        
        // Log what's being created
        console.log('=== GROUP CREATION DEBUG ===');
        console.log('Group Name:', groupName);
        console.log('Group Description:', groupDescription);
        console.log('Selected Employers:', selectedGroupEmployers);
        console.log('Number of employers:', selectedGroupEmployers.length);
        console.log('=== END DEBUG ===');
        
        const employerIds = selectedGroupEmployers.map(e => e.id);
        
        const requestBody = `group_name=${encodeURIComponent(groupName)}&description=${encodeURIComponent(groupDescription)}&employer_ids=${encodeURIComponent(JSON.stringify(employerIds))}`;
        
        const requestUrl = baseUrl + 'adminpagevisibility/create_group';
        console.log('Request URL:', requestUrl);
        console.log('Request body:', requestBody);
        
        fetch(requestUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: requestBody
        })
        .then(response => {
            console.log('Response received:', response.status);
            console.log('Response headers:', response.headers);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.text().then(text => {
                console.log('Raw response:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error('Invalid JSON response: ' + text);
                }
            });
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Show detailed message with count
                const message = `Group created! Added ${data.inserted_count} of ${data.total_requested} employer(s)${data.warnings && data.warnings.length > 0 ? ' (check console for warnings)' : ''}`;
                console.log('✅ Group creation result:', {
                    group_id: data.group_id,
                    inserted_count: data.inserted_count,
                    total_requested: data.total_requested,
                    warnings: data.warnings || []
                });
                showNotification(message, 'success');
                
                // Reset form and close modal
                selectedGroupEmployers = [];
                document.getElementById('groupNameInput').value = '';
                const descriptionInput = document.getElementById('groupDescriptionInput');
                if (descriptionInput) {
                    descriptionInput.value = '';
                }
                updateSelectedEmployersPreview();
                closeGroupCreationModal();
                
                // Reload groups list
                if (currentEmployerId) {
                    loadEmployerGroups(currentEmployerId);
                }
            } else {
                    showNotification(data.message || 'Failed to create group', 'error');
            }
        })
        .catch(error => {
            console.error('Error creating group:', error);
            showNotification('An error occurred while creating the group', 'error');
        });
    } catch (error) {
        console.error('Error in createNewGroup:', error);
        showNotification('An error occurred', 'error');
    }
}

// Reload page when modal closes to refresh table stats
$('#visibilityModal').on('hidden.bs.modal', function() {
    if (!openingGroupCreationModal && !suppressVisibilityModalReload) {
        console.log('Visibility modal closed - reloading page');
        location.reload();
    } else {
        console.log('Group creation modal is opening - skipping page reload');
    }
});

console.log('Page initialization complete');
</script>
