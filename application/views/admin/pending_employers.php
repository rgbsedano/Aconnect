#c<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$search = isset($search) ? (string) $search : '';
?>

<style>
.pending-employers-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 12px 24px 20px;
}

/* Ensure font consistency with the admin layout (uses Nunito from __header.php) */
.pending-employers-page,
.pending-employers-page * {
    font-family: "Nunito", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
}

/* Text tokens to match admin pages */
.pending-employers-page .user-name {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}
.pending-employers-page .student-id {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
}
.pending-employers-page .approval-table th {
    font-size: 12px;
    font-weight: 800;
    color: #334155;
}
.pending-employers-page .approval-table td {
    font-size: 14px;
    color: var(--text-main, #0f172a);
}

.pending-employers-page .page-card {
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
    border: 1px solid rgba(226,232,240,0.6);
    overflow: hidden;
}

.pending-employers-page .page-card {
    max-width: 1200px;
    margin: 0 0 0 0;
}

.pending-employers-page .page-intro {
    margin-bottom: 12px;
}

.pending-employers-page .page-intro {
    max-width: 1200px;
    margin: 0 0 12px;
    padding: 0 8px 0 0;
    box-sizing: border-box;
}

.pending-employers-page .page-intro h1 {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    color: #e5e7eb;
}

.pending-employers-page .page-intro h1 .accent {
    color: #ff6b6b;
}

.pending-employers-page .page-intro p {
    margin: 6px 0 0;
    color: #e5e7eb;
    font-size: 14px;
    line-height: 1.35;
}


.pending-employers-page .search-container {
    width: 100%;
    max-width: 1200px;
    margin-bottom: 8px;
}

.pending-employers-page .tabs-container {
    width: 100%;
    max-width: 1200px;
    margin-bottom: 18px;
    display: flex;
    justify-content: flex-start;
}

.pending-employers-page .header-section {
    width: 100%;
    max-width: 1200px;
    margin: 0 0 14px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    min-height: 128px;
    gap: 12px;
    padding: 34px 18px 24px; /* taller header section */
    background: #ffffff;
    border: 1px solid #eef2f7;
    border-radius: 12px;
}
.pending-employers-page .header-left { flex: 1; display:flex; flex-direction:column; }
.pending-employers-page .header-section .controls-tabs { margin-top: 12px; }

@media (max-width: 768px) {
    .pending-employers-page .header-section {
        flex-direction: column;
        align-items: flex-start;
    }
    .pending-employers-page .header-left { width: 100%; }
}

.pending-employers-page .search-form {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    max-width: none;
    margin: 0;
}

.pending-employers-page .search-field { position: relative; flex: 1; max-width: none; min-width: 0; }
.pending-employers-page .icon-search { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; width:18px; height:18px; }
.pending-employers-page .search-input.form-control.form-input {
    width: 100%;
    padding: 0 18px 0 48px;
    height: 48px;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 500;
    color: #0f172a;
    background: #ffffff;
    box-shadow: none;
    line-height: 48px;
}

.pending-employers-page .search-input.form-control.form-input:focus {
    border-color: #7f1d1d;
    box-shadow: 0 0 0 4px rgba(127,29,29,.08);
}

.pending-employers-page .btn-search {
    background: #a12124;
    color: #ffffff;
    border: none;
    padding: 0 20px;
    height: 48px;
    border-radius: 14px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    margin-left: auto;
}
.pending-employers-page .btn-search svg { width:14px; height:14px; }
.pending-employers-page .search-field { max-width: none; }

.pending-employers-page .search-row {
    width: 100%;
    max-width: 920px;
    padding: 0;
    margin: 0;
    background: transparent;
    border: none;
}
.pending-employers-page .controls-tabs { display:flex; gap:10px; align-items:center; justify-content:flex-start; width:100%; margin-top:6px; }

.pending-employers-page .page-body {
    padding: 40px 12px 60px;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.pending-employers-page .page-body { padding-bottom: 60px; }

.pending-employers-page .status-tab-btn:hover,
.pending-employers-page .status-tab-btn:focus {
    background: #f1f5f9;
    transform: translateY(-1px);
}

.pending-employers-page .status-tabs {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
    justify-content: center;
}

.pending-employers-page .status-tab-btn {
    background: #f8fafc; /* softer inactive surface */
    color: #475569;      /* muted slate */
    border: none;
    border-radius: 999px;
    padding: 9px 14px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all .12s ease;
}

.pending-employers-page .status-tab-btn.active {
    background: #8f151c;
    border-color: #8f151c;
    color: #ffffff;
}

.pending-employers-page .tab-content {
    display: none;
    width: 100%;
    max-width: 1200px;
}

.pending-employers-page .tab-content.active {
    display: block;
}

/* Officers-like adjustments */
.pending-employers-page .user-name {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}
.pending-employers-page .student-id {
    font-size: 12px;
    font-weight: 600;
    color: #64748b; /* neutral slate */
    background: #f8fafc; /* light surface */
    padding: 3px 8px;
    border-radius: 6px;
    display: inline-block;
    margin-top: 6px;
}

.pending-employers-page .approval-table td .avatar {
    width:44px;height:44px;border-radius:50%;object-fit:cover;margin-right:12px;flex-shrink:0;
}

.pending-employers-page .btn-action {
    width:36px;height:36px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;background:#f8fafc;color:#6b7280;border:1px solid #e2e8f0;padding:0;margin-left:6px;
}
.pending-employers-page .btn-action:hover{background:#a12124;color:#fff;border-color:#a12124}

.pending-employers-page .approval-table tbody tr { border-top: 1px solid #f1f5f9; }


.pending-employers-page .pagination-wrap {
    margin-top: 18px;
    display: flex;
    justify-content: center;
}

.pending-employers-page .pagination .page-link {
    border-radius: 10px !important;
    margin: 0 4px;
    border: 1px solid #e2e8f0;
    color: #a12124;
    font-weight: 700;
    font-size: 13px;
    padding: 8px 12px;
    background: #ffffff;
}

.pending-employers-page .pagination .page-item.active .page-link {
    background-color: #a12124;
    border-color: #a12124;
    color: #ffffff;
}


.pending-employers-page .section-title {
    margin: 0 0 12px;
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
}

.pending-employers-page .section-subtitle {
    margin: -4px 0 16px;
    color: #64748b;
    font-size: 13px;
}

.pending-employers-page .approval-table th {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: #64748b; /* darker header */
    font-weight: 800;
    border-top: none;
    padding: 14px 18px;
}

.pending-employers-page .approval-table td {
    vertical-align: middle;
}

/* Row hover effect */
.pending-employers-page .approval-table tbody tr {
    transition: box-shadow .18s ease, transform .12s ease, background .12s;
    background: #fff;
}
.pending-employers-page .approval-table tbody tr:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(15,23,42,0.06);
}

.pending-employers-page .badge-status {
    display: inline-flex;
    align-items: center;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}

.pending-employers-page .badge-pending {
    background: #fef3c7;
    color: #92400e;
}

.pending-employers-page .badge-approved {
    background: #dcfce7;
    color: #166534;
}

.pending-employers-page .badge-rejected {
    background: #fee2e2;
    color: #991b1b;
}

.pending-employers-page .action-group {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.pending-employers-page .btn-action {
    border: none;
    border-radius: 10px;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
}

.pending-employers-page .btn-approve {
    background: #15803d;
}

.pending-employers-page .btn-reject {
    background: #b91c1c;
}

.pending-employers-page .empty-state {
    padding: 42px 20px;
    text-align: center;
    color: #64748b;
}
</style>

<div class="pending-employers-page">
    <div class="page-intro">
        <h1>Employer <span class="accent">Approvals</span></h1>
        <p>Review new employer registrations and approve or reject them safely.</p>
    </div>

    <div class="header-section">
        <div class="header-left">
            <form method="get" action="<?php echo base_url('Admin/pending_employers'); ?>" class="search-form" autocomplete="off">
                <div class="search-field">
                    <!-- inline SVG search icon to avoid font icon issues -->
                    <svg class="icon-search" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <circle cx="11" cy="11" r="6" stroke="#94a3b8" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M21 21l-4.35-4.35" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <input type="text" name="search" class="form-control form-input search-input" placeholder="Search job title, company, or email" value="<?php echo html_escape($search); ?>">
                </div>
                <button type="submit" class="btn-search">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <circle cx="11" cy="11" r="6" stroke="#ffffff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M21 21l-4.35-4.35" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Search
                </button>
            </form>

            <div class="controls-tabs status-tabs">
                <button type="button" class="status-tab-btn active" data-tab="pending">Pending (<?php echo isset($pending_employers) && is_array($pending_employers) ? count($pending_employers) : 0; ?>)</button>
                <button type="button" class="status-tab-btn" data-tab="approved">Approved (<?php echo isset($approved_employers) && is_array($approved_employers) ? count($approved_employers) : 0; ?>)</button>
                <button type="button" class="status-tab-btn" data-tab="rejected">Rejected (<?php echo isset($rejected_employers) && is_array($rejected_employers) ? count($rejected_employers) : 0; ?>)</button>
            </div>
        </div>
    </div>

    <div class="page-card">

        <div class="page-body">
            <?php if ($this->session->flashdata('success_message')): ?>
                <div class="alert alert-success"><?php echo html_escape($this->session->flashdata('success_message')); ?></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error_message')): ?>
                <div class="alert alert-danger"><?php echo html_escape($this->session->flashdata('error_message')); ?></div>
            <?php endif; ?>

            <!-- header-section moved above page-card; page-body content continues here -->

            <div id="pending-tab" class="tab-content active">
                <h2 class="section-title">Pending Employers</h2>
                <p class="section-subtitle">These accounts are waiting for review before they can log in.</p>
                <div class="table-responsive">
                    <table class="table table-hover approval-table mb-0">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Contact Person</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pending_employers)): ?>
                                <?php foreach ($pending_employers as $employer): ?>
                                    <?php
                                    $status = strtolower(trim((string) ($employer['approval_status'] ?? 'pending')));
                                    $status_class = 'badge-pending';

                                    if ($status === 'approved') {
                                        $status_class = 'badge-approved';
                                    } elseif ($status === 'rejected') {
                                        $status_class = 'badge-rejected';
                                    }

                                    $company = html_escape($employer['company_name'] ?? '');
                                    $contact = html_escape(trim(($employer['first_name'] ?? '') . ' ' . ($employer['last_name'] ?? '')));
                                    $email = html_escape($employer['email'] ?? '');
                                    ?>
                                    <tr>
                                        <td>
                                            <div style="display:flex;align-items:center;">
                                                <img src="<?php echo base_url('assets/images/person-default.png'); ?>" alt="avatar" class="avatar">
                                                <div>
                                                    <div class="user-name"><?php echo $company; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <div class="student-id"><?php echo $email; ?></div>
                                        </td>
                                        <td class="text-center"><?php echo $contact; ?></td>
                                        <td class="text-center">
                                            <span class="badge-status <?php echo $status_class; ?>">
                                                <?php echo html_escape(ucfirst($status)); ?>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <?php echo form_open(site_url('Admin/verify_employer/' . (int) $employer['id'] . '/approve'), ['class' => 'd-inline']); ?>
                                                <button type="submit" class="btn-action" title="Approve"><i class="fas fa-check"></i></button>
                                            <?php echo form_close(); ?>

                                            <?php echo form_open(site_url('Admin/verify_employer/' . (int) $employer['id'] . '/reject'), ['class' => 'd-inline']); ?>
                                                <button type="submit" class="btn-action" title="Reject"><i class="fas fa-times"></i></button>
                                            <?php echo form_close(); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">No pending employer registrations found.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($pagination_pending_links)): ?>
                    <div class="pagination-wrap">
                        <?= $pagination_pending_links ?>
                    </div>
                <?php endif; ?>
            </div>

            <div id="approved-tab" class="tab-content">
                <h2 class="section-title">Approved Employers</h2>
                <p class="section-subtitle">These accounts have been approved and can sign in.</p>
                <div class="table-responsive">
                    <table class="table table-hover approval-table mb-0">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Contact Person</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($approved_employers)): ?>
                                <?php foreach ($approved_employers as $employer): ?>
                                    <?php
                                    $company = html_escape($employer['company_name'] ?? '');
                                    $contact = html_escape(trim(($employer['first_name'] ?? '') . ' ' . ($employer['last_name'] ?? '')));
                                    $email = html_escape($employer['email'] ?? '');
                                    ?>
                                    <tr>
                                        <td>
                                            <div style="display:flex;align-items:center;">
                                                <img src="<?php echo base_url('assets/images/person-default.png'); ?>" alt="avatar" class="avatar">
                                                <div>
                                                    <div class="user-name"><?php echo $company; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <div class="student-id"><?php echo $email; ?></div>
                                        </td>
                                        <td class="text-center"><?php echo $contact; ?></td>
                                        <td class="text-center">
                                            <span class="badge-status badge-approved">Approved</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">No approved employers found.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($pagination_approved_links)): ?>
                    <div class="pagination-wrap">
                        <?= $pagination_approved_links ?>
                    </div>
                <?php endif; ?>
            </div>
                <div id="rejected-tab" class="tab-content">
                    <h2 class="section-title">Rejected Employers</h2>
                    <p class="section-subtitle">These accounts were rejected during review.</p>
                    <div class="table-responsive">
                        <table class="table table-hover approval-table mb-0">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Contact Person</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($rejected_employers)): ?>
                                    <?php foreach ($rejected_employers as $employer): ?>
                                        <?php
                                        $company = html_escape($employer['company_name'] ?? '');
                                        $contact = html_escape(trim(($employer['first_name'] ?? '') . ' ' . ($employer['last_name'] ?? '')));
                                        $email = html_escape($employer['email'] ?? '');
                                        ?>
                                        <tr>
                                            <td>
                                                <div style="display:flex;align-items:center;">
                                                    <img src="<?php echo base_url('assets/images/person-default.png'); ?>" alt="avatar" class="avatar">
                                                    <div>
                                                        <div class="user-name"><?php echo $company; ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="student-id"><?php echo $email; ?></div>
                                            </td>
                                            <td class="text-center"><?php echo $contact; ?></td>
                                            <td class="text-center">
                                                <span class="badge-status badge-rejected">Rejected</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">No rejected employers found.</div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($pagination_rejected_links)): ?>
                        <div class="pagination-wrap">
                            <?= $pagination_rejected_links ?>
                        </div>
                    <?php endif; ?>
                </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var tabButtons = document.querySelectorAll('.status-tab-btn');
    var tabContents = document.querySelectorAll('.tab-content');

    // Activate tab based on URL params (supports pagination links)
    var params = new URLSearchParams(window.location.search);
    if (params.has('rejected_page')) {
        // activate rejected tab
        document.querySelectorAll('.status-tab-btn').forEach(function (b) { b.classList.remove('active'); });
        document.querySelectorAll('.tab-content').forEach(function (c) { c.classList.remove('active'); });
        var rejectedBtn = document.querySelector('.status-tab-btn[data-tab="rejected"]');
        var rejectedTab = document.getElementById('rejected-tab');
        if (rejectedBtn) rejectedBtn.classList.add('active');
        if (rejectedTab) rejectedTab.classList.add('active');
    } else if (params.has('approved_page')) {
        // activate approved tab
        document.querySelectorAll('.status-tab-btn').forEach(function (b) { b.classList.remove('active'); });
        document.querySelectorAll('.tab-content').forEach(function (c) { c.classList.remove('active'); });
        var approvedBtn = document.querySelector('.status-tab-btn[data-tab="approved"]');
        var approvedTab = document.getElementById('approved-tab');
        if (approvedBtn) approvedBtn.classList.add('active');
        if (approvedTab) approvedTab.classList.add('active');
    }

    tabButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var tabName = button.getAttribute('data-tab');

            tabButtons.forEach(function (item) {
                item.classList.remove('active');
            });

            tabContents.forEach(function (content) {
                content.classList.remove('active');
            });

            button.classList.add('active');
            var target = document.getElementById(tabName + '-tab');
            if (target) {
                target.classList.add('active');
            }
        });
    });

    // Live search: debounce input and fetch rendered rows from server
    function debounce(fn, delay) {
        var t;
        return function () {
            var args = arguments;
            clearTimeout(t);
            t = setTimeout(function () { fn.apply(null, args); }, delay);
        };
    }

    var searchInputEl = document.querySelector('.search-input');
    if (searchInputEl) {
        var doSearch = debounce(function (ev) {
            var q = (ev.target.value || '').trim();
            // only query when 3+ chars or when cleared
            if (q.length >= 3 || q.length === 0) {
                var activeBtn = document.querySelector('.status-tab-btn.active');
                var status = activeBtn ? activeBtn.getAttribute('data-tab') : 'pending';
                var url = '<?php echo site_url('Admin/ajax_search_employers'); ?>?search=' + encodeURIComponent(q) + '&status=' + encodeURIComponent(status);
                fetch(url, { credentials: 'same-origin' })
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        if (!data || !data.html) return;
                        var tab = document.getElementById(status + '-tab');
                        if (!tab) return;
                        var tbody = tab.querySelector('table.approval-table tbody');
                        if (tbody) tbody.innerHTML = data.html;
                    })
                    .catch(function (err) { /* fail silently */ });
            }
        }, 300);

        searchInputEl.addEventListener('input', doSearch);
    }
});
</script>