<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
    :root {
        --accent-red: #a12124;
        --text-main: #333333;
        --text-muted: #666666;
        --border-radius: 16px;
        --transition: all 0.3s ease;
    }
    .groups-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .groups-header {
        margin-bottom: 30px;
        padding: 25px;
        background: linear-gradient(135deg, #a12124 0%, #7a191c 100%);
        color: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .groups-header-content h1 {
        margin: 0 0 8px 0;
        font-size: 32px;
        font-weight: 700;
    }

    .groups-header-content p {
        margin: 0;
        opacity: 0.95;
        font-size: 15px;
    }

    .btn-create-group {
        background-color: white;
        color: #a12124;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-create-group:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .groups-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .pagination-wrap {
        margin-top: 18px;
        display: flex;
        justify-content: center;
    }

    .pagination .page-link {
        border-radius: 10px !important;
        margin: 0 4px;
        border: 1px solid #e2e8f0;
        color: #a12124;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 14px;
        transition: var(--transition);
        background: #ffffff;
        text-decoration: none;
    }

    .pagination .page-item.active .page-link {
        background-color: #a12124;
        border-color: #a12124;
        color: #ffffff;
        box-shadow: 0 6px 16px rgba(161, 33, 36, 0.22);
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f8fafc;
    }

    .group-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        border-left: 4px solid #a12124;
        transition: all 0.3s ease;
    }

    .group-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }

    .group-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .group-card-title {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #333;
    }

    .group-card-actions {
        display: flex;
        gap: 8px;
    }

    .btn-small {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-manage {
        background-color: #a12124;
        color: white;
    }

    .btn-manage:hover {
        background-color: #8a1a1f;
    }

    .btn-delete {
        background-color: #ef4444;
        color: white;
    }

    .btn-delete:hover {
        background-color: #dc2626;
    }

    .group-card-description {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .group-stat {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-top: 1px solid #e0e0e0;
    }

    .group-stat:first-child {
        border-top: none;
    }

    .stat-label {
        color: #999;
        font-size: 13px;
    }

    .stat-value {
        font-weight: 700;
        color: #333;
        font-size: 14px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 40px;
        color: #999;
    }

    .empty-state i {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 15px;
    }

    .empty-state p {
        font-size: 15px;
        margin: 0;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.4);
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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
    }

    .modal-body {
        padding: 30px;
    }

    .modal-header .modal-title {
        font-weight: 700;
        font-size: 18px;
    }

    .modal-close {
        font-size: 24px;
        color: white;
        opacity: 0.7;
        transition: var(--transition);
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

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: border-color 0.2s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #a12124;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .btn-primary {
        background-color: #a12124;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #8a1a1f;
    }

    .btn-cancel {
        background-color: #e0e0e0;
        color: #333;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background-color: #d0d0d0;
    }

    .add-employer-section {
        margin-bottom: 30px;
    }

    .add-employer-section h4 {
        margin-top: 0;
        margin-bottom: 16px;
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }

    .add-employer-group {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
    }

    .add-employer-group select {
        flex: 1;
    }

    .add-employer-group .btn-primary {
        white-space: nowrap;
        padding: 12px 30px;
    }

    .current-members-section h4 {
        margin-top: 0;
        margin-bottom: 16px;
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }

    .members-list-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .member-item {
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #d1fae5;
        border-color: #10b981;
        transition: all 0.2s ease;
    }

    .member-item:hover {
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);
    }

    .member-item-name {
        font-weight: 600;
        color: #065f46;
        font-size: 14px;
    }

    .member-name {
        font-weight: 600;
        color: #111827;
    }

    .add-member-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .add-member-row select {
        flex: 1;
    }

    .btn-secondary {
        background-color: #f3f4f6;
        color: #111827;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background-color: #e5e7eb;
    }

    .employers-list {
        max-height: 400px;
        overflow-y: auto;
        margin-bottom: 20px;
    }

    .btn-xs {
        padding: 4px 10px;
        font-size: 11px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-add {
        background-color: #10b981;
        color: white;
    }

    .btn-add:hover {
        background-color: #059669;
    }

    .btn-remove {
        background-color: #ef4444;
        color: white;
    }

    .btn-remove:hover {
        background-color: #dc2626;
    }

    .alert {
        padding: 16px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border-left-color: #10b981;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border-left-color: #ef4444;
    }

    /* Status Badge Styles */
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-active:hover {
        background: #bbf7d0;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-inactive:hover {
        background: #fecaca;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);
    }

    .status-suspended {
        background: #fef3c7;
        color: #92400e;
    }

    .status-suspended:hover {
        background: #fde68a;
        box-shadow: 0 2px 8px rgba(180, 83, 9, 0.2);
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
        background: #8a1a1e;
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

    @media (max-width: 768px) {
        .groups-page {
            padding: 15px;
        }

        .groups-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .groups-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="groups-page">
    <!-- Header -->
    <div class="groups-header">
        <div class="groups-header-content">
            <h1><i class="fas fa-object-group"></i> Employer Groups</h1>
            <p>Organize employers into groups to manage job posting visibility</p>
        </div>
        <button class="btn-create-group" onclick="openCreateGroupModal()">
            <i class="fas fa-plus"></i> New Group
        </button>
    </div>

    <!-- Groups Grid -->
    <div class="groups-grid" id="groupsGrid">
        <?php if (empty($groups)): ?>
        <div style="grid-column: 1/-1;">
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p><strong>No groups yet</strong></p>
                <p style="margin-top: 8px; font-size: 13px;">Create your first employer group to organize visibility</p>
            </div>
        </div>
        <?php else: ?>
            <?php foreach ($groups as $group): ?>
            <div class="group-card">
                <div class="group-card-header">
                    <h3 class="group-card-title"><?php echo htmlspecialchars($group->group_name); ?></h3>
                    <div class="group-card-actions">
                        <button class="btn-small btn-manage" onclick="openManageGroupModal(<?php echo $group->id; ?>, '<?php echo htmlspecialchars($group->group_name); ?>')">
                            <i class="fas fa-cog"></i> Manage
                        </button>
                        <button class="btn-small btn-delete" onclick="deleteGroup(<?php echo $group->id; ?>, '<?php echo htmlspecialchars($group->group_name); ?>')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
                <?php if (!empty($group->description)): ?>
                <p class="group-card-description"><?php echo htmlspecialchars($group->description); ?></p>
                <?php endif; ?>
                <div class="group-stat">
                    <span class="stat-label">Employers in Group</span>
                    <span class="stat-value"><?php echo isset($group_counts[$group->id]) ? $group_counts[$group->id] : 0; ?></span>
                </div>
                <div class="group-stat">
                    <span class="stat-label">Status</span>
                    <span class="status-badge status-active" onclick="toggleGroupStatus(<?php echo $group->id; ?>, this)" data-status="active" title="Click to change status">
                        <i class="fas fa-check-circle" style="margin-right: 4px;"></i>Active
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($pagination_links)): ?>
        <div class="pagination-wrap">
            <?= $pagination_links ?>
        </div>
    <?php endif; ?>
</div>

<!-- Create Group Modal -->
<div id="createGroupModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="closeCreateGroupModal()">&times;</span>
            <h2>Create New Group</h2>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="groupName">Group Name *</label>
                <input type="text" id="groupName" placeholder="e.g., Tech Companies, Startups">
            </div>
            <div class="form-group">
                <label for="groupDescription">Description</label>
                <textarea id="groupDescription" placeholder="Optional description for this group..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeCreateGroupModal()">Cancel</button>
            <button class="btn-primary" onclick="createGroup()">Create Group</button>
        </div>
    </div>
</div>

<!-- Manage Group Modal -->
<div class="modal fade" id="manageGroupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageGroupTitle">Manage Group</h5>
                <button type="button" class="close" onclick="closeManageGroupModal()" aria-label="Close">
                    <span aria-hidden="true" class="modal-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="add-employer-section">
                    <h4>Add Member to Group</h4>
                    <div class="add-employer-group">
                        <select id="employerSelect" style="padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px;">
                            <option value="">Select an employer...</option>
                        </select>
                        <button class="btn-primary" onclick="addEmployerToGroup()">Add to Group</button>
                    </div>
                </div>

                <div class="current-members-section">
                    <h4>Current Members</h4>
                    <div class="members-list-container" id="employersList"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeManageGroupModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
const baseUrl = '<?php echo base_url(); ?>';
let currentGroupId = null;
let currentGroupName = null;

function toggleGroupStatus(groupId, element) {
    const currentStatus = element.dataset.status;
    let newStatus = 'active';
    
    // Cycle through statuses: active -> inactive -> suspended -> active
    if (currentStatus === 'active') {
        newStatus = 'inactive';
    } else if (currentStatus === 'inactive') {
        newStatus = 'suspended';
    } else if (currentStatus === 'suspended') {
        newStatus = 'active';
    }

    // Update UI immediately for better UX
    updateStatusBadge(element, newStatus);
    
    // Send to server
    fetch(baseUrl + 'adminpagevisibility/update_group_status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'group_id=' + encodeURIComponent(groupId) + 
              '&status=' + encodeURIComponent(newStatus)
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message || 'Failed to update group status');
            // Revert UI change on error
            updateStatusBadge(element, currentStatus);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
        // Revert UI change on error
        updateStatusBadge(element, currentStatus);
    });
}

function updateStatusBadge(element, status) {
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

function openCreateGroupModal() {
    document.getElementById('createGroupModal').style.display = 'block';
    document.getElementById('groupName').focus();
}

function closeCreateGroupModal() {
    document.getElementById('createGroupModal').style.display = 'none';
    document.getElementById('groupName').value = '';
    document.getElementById('groupDescription').value = '';
}

function openManageGroupModal(groupId, groupName) {
    currentGroupId = groupId;
    currentGroupName = groupName;
    document.getElementById('manageGroupTitle').textContent = 'Manage: ' + groupName;
    
    const modalElement = document.getElementById('manageGroupModal');
    if (typeof jQuery !== 'undefined') {
        jQuery(modalElement).modal('show');
    } else if (typeof $ !== 'undefined' && $.fn.modal) {
        $(modalElement).modal('show');
    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        new bootstrap.Modal(modalElement).show();
    }
    
    loadGroupEmployers(groupId);
}

function closeManageGroupModal() {
    const modalElement = document.getElementById('manageGroupModal');
    if (modalElement) {
        if (typeof jQuery !== 'undefined') {
            jQuery(modalElement).modal('hide');
        } else if (typeof $ !== 'undefined' && $.fn.modal) {
            $(modalElement).modal('hide');
        } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            bootstrap.Modal.getInstance(modalElement)?.hide();
        }
    }
    currentGroupId = null;
    currentGroupName = null;
}

function createGroup() {
    const groupName = document.getElementById('groupName').value;
    const description = document.getElementById('groupDescription').value;

    if (!groupName.trim()) {
        alert('Please enter a group name');
        return;
    }

    fetch(baseUrl + 'adminpagevisibility/create_group', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'group_name=' + encodeURIComponent(groupName) + 
              '&description=' + encodeURIComponent(description)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeCreateGroupModal();
            location.reload();
        } else {
            alert(data.message || 'Failed to create group');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function deleteGroup(groupId, groupName) {
    if (!confirm('Are you sure you want to delete the group "' + groupName + '"? All employer assignments will be removed.')) {
        return;
    }

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
            location.reload();
        } else {
            alert(data.message || 'Failed to delete group');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function loadGroupEmployers(groupId) {
    fetch(baseUrl + 'adminpagevisibility/get_group_employers?group_id=' + encodeURIComponent(groupId))
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update select dropdown
            const select = document.getElementById('employerSelect');
            select.innerHTML = '<option value="">Select an employer to add...</option>';
            data.available_employers.forEach(employer => {
                const option = document.createElement('option');
                option.value = employer.id;
                option.textContent = employer.company_name + ' (ID: ' + employer.id + ')';
                select.appendChild(option);
            });

            // Update employers list
            const list = document.getElementById('employersList');
            if (data.employers.length === 0) {
                list.innerHTML = '<p style="color: #999; text-align: center; padding: 30px 0;">No members in this group yet</p>';
            } else {
                list.innerHTML = '';
                data.employers.forEach(employer => {
                    const item = document.createElement('div');
                    item.className = 'member-item';
                    item.innerHTML = `
                        <span class="member-item-name">${employer.company_name}</span>
                        <button class="btn-xs btn-remove" onclick="removeEmployerFromGroup(${employer.id}, ${groupId})">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    `;
                    list.appendChild(item);
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to load group employers');
    });
}

function addEmployerToGroup() {
    const select = document.getElementById('employerSelect');
    const employerId = select.value;

    if (!employerId) {
        alert('Please select an employer');
        return;
    }

    fetch(baseUrl + 'adminpagevisibility/add_employer_to_group', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'employer_id=' + encodeURIComponent(employerId) + 
              '&group_id=' + encodeURIComponent(currentGroupId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadGroupEmployers(currentGroupId);
        } else {
            alert(data.message || 'Failed to add employer');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function removeEmployerFromGroup(employerId, groupId) {
    fetch(baseUrl + 'adminpagevisibility/remove_employer_from_group', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'employer_id=' + encodeURIComponent(employerId) + 
              '&group_id=' + encodeURIComponent(groupId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadGroupEmployers(groupId);
        } else {
            alert(data.message || 'Failed to remove employer');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

// Close modal when clicking outside
window.onclick = function(event) {
    const createModal = document.getElementById('createGroupModal');
    const manageModal = document.getElementById('manageGroupModal');
    
    if (event.target == createModal) {
        createModal.style.display = 'none';
    }
    if (event.target == manageModal) {
        manageModal.style.display = 'none';
    }
}
</script>
