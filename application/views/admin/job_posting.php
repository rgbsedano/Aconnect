<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Posting Admin | Alumni Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #700a0a;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 24px;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--primary-bg);
        color: var(--text-main);
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

    .header-section {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .header-section h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 4px;
        color: var(--text-main);
    }

    .header-section h1 span { color: var(--accent-red); }
    .header-section p { color: var(--text-muted); font-size: 14px; margin: 0; }

    /* Main Card */
    .main-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    /* Job Cards Grid */
    .job-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .job-card {
        background: var(--card-bg);
        border: 1px solid #f1f5f9;
        border-radius: 14px;
        padding: 20px;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
    }

    .job-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        border-color: var(--accent-red);
    }

    .job-card-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 12px;
    }

    .job-company {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--accent-red);
        letter-spacing: 0.5px;
    }

    .job-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
        margin-top: 6px;
    }

    .applicant-badge {
        background: #fef2f2;
        color: var(--accent-red);
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
    }

    .job-details {
        color: var(--text-muted);
        font-size: 13px;
        margin: 12px 0;
    }

    .job-details-item {
        margin: 8px 0;
    }

    .job-details-item i {
        color: var(--accent-red);
        margin-right: 8px;
        width: 16px;
    }

    .job-actions {
        display: flex;
        gap: 8px;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        color: var(--text-muted);
        border: 1px solid #e2e8f0;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-action:hover {
        background: var(--accent-red);
        color: white;
        border-color: var(--accent-red);
        transform: translateY(-2px);
    }

    .btn-modern {
        background: var(--accent-red);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-modern:hover {
        background: #5a0a0a;
        transform: translateY(-2px);
        color: white;
    }

    .btn-outline {
        border: 1px solid #e2e8f0;
        color: var(--text-main);
        background: white;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-outline:hover {
        border-color: var(--accent-red);
        color: var(--accent-red);
    }

    /* Search Box */
    .search-box-wrapper {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        transition: var(--transition);
    }

    .search-box-wrapper:focus-within {
        border-color: var(--accent-red);
        box-shadow: 0 0 0 3px rgba(112, 10, 10, 0.05);
    }

    .search-input {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        font-size: 14px;
        color: var(--text-main);
    }

    .search-input::placeholder {
        color: var(--text-muted);
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 24px;
        border: none;
        overflow: hidden;
    }

    .modal-header {
        background: var(--accent-red);
        color: white;
        padding: 25px;
        border: none;
    }

    .modal-header .modal-title {
        font-weight: 700;
    }

    .modal-header .close {
        color: white;
    }

    .modal-body {
        padding: 30px;
    }

    .form-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-bottom: 8px;
        display: block;
        letter-spacing: 0.5px;
    }

    .form-input {
        border-radius: 12px;
        padding: 12px;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid #e2e8f0;
        background: white;
    }

    .form-input:focus {
        border-color: var(--accent-red);
        box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05);
        outline: none;
    }

    .modal-footer {
        background: #f8fafc;
        padding: 16px 30px;
    }

    .info-item {
        padding: 12px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .info-item label {
        color: var(--accent-red);
        font-weight: 700;
        margin-bottom: 8px;
    }

    .page-guide {
        background: #fef2f2;
        border-left: 4px solid var(--accent-red);
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        color: var(--text-muted);
        font-size: 13px;
    }

    .page-guide i {
        color: var(--accent-red);
        margin-right: 8px;
    }

    @media (max-width: 768px) {
        .job-cards-grid {
            grid-template-columns: 1fr;
        }
        
        .header-section {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-section h1 {
            font-size: 24px;
        }
    }
</style>

<body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if($this->session->flashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'success',
        title: '<?= $this->session->flashdata('success') ?>'
    });
});
</script>
<?php endif; ?>

<div class="dashboard-wrapper">
    <div class="header-section">
        <div>
            <h1>Job <span>Posting</span></h1>
            <p>Publish opportunities and track applicant engagement with alumni network.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button class="btn-modern" data-toggle="modal" data-target="#createJobModal">
                <i class="fas fa-plus-circle mr-2"></i> Create New Posting
            </button>
            <a href="<?= base_url('AdminJobPosting/run_worker') ?>" class="btn-outline">
                <i class="fas fa-paper-plane mr-2"></i> Notify Alumni
            </a>
        </div>
    </div>

    <div class="main-card">
        <div class="page-guide">
            <i class="fas fa-circle-info mr-2"></i>
            <strong>Admin Guide:</strong> Manage active job listings below. You can filter by title or company, view applicant lists, or export data for reporting.
        </div>

        <div style="margin-bottom: 24px;">
            <div class="search-box-wrapper" style="max-width: 400px;">
                <i class="fas fa-magnifying-glass" style="color: var(--text-muted); margin-right: 8px;"></i>
                <input type="text" class="search-input" placeholder="Filter jobs by title, company, or location..." id="jobSearchInput">
            </div>
        </div>

        <div class="job-cards-grid">
            <?php if (!empty($jobs)): ?>
                <?php foreach($jobs as $job): 
                    $this->db->where('job_id', $job->id);
                    $applicant_count = $this->db->count_all_results('job_applications');
                ?>
                    <div class="job-card job-card-item">
                        <div class="job-card-header">
                            <div>
                                <div class="job-company"><?= htmlspecialchars($job->company) ?></div>
                                <div class="job-title"><?= htmlspecialchars($job->job_title) ?></div>
                            </div>
                            <span class="applicant-badge"><?= $applicant_count ?> <span style="font-size: 10px;">Applicants</span></span>
                        </div>
                        
                        <div class="job-details">
                            <div class="job-details-item"><i class="fas fa-location-dot"></i> <?= htmlspecialchars($job->location) ?></div>
                            <div class="job-details-item"><i class="fas fa-wallet"></i> <?= htmlspecialchars($job->salary_range) ?></div>
                        </div>

                        <div class="job-actions">
                            <button type="button" class="btn-action" data-toggle="modal" data-target="#applicantModal<?= $job->id ?>" title="Review Applicants">
                                <i class="fas fa-users"></i>
                            </button>
                            <button type="button" class="btn-action" data-toggle="modal" data-target="#editModal<?= $job->id ?>" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn-action" data-toggle="modal" data-target="#deleteModal<?= $job->id ?>" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="modal fade" id="editModal<?= $job->id ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <form action="<?= base_url('AdminJobPosting/update/'.$job->id) ?>" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fas fa-pen-to-square mr-2"></i> Update Posting</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Position Title</label>
                                                <input type="text" name="job_title" class="form-control form-input" value="<?= htmlspecialchars($job->job_title) ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Organization</label>
                                                <input type="text" name="company" class="form-control form-input" value="<?= htmlspecialchars($job->company) ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Telephone Number</label>
                                                <input type="text" name="telephone" class="form-control form-input" value="<?= htmlspecialchars($job->telephone ?? '') ?>" placeholder="02-8000-0000">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Phone Number</label>
                                                <input type="text" name="phone" class="form-control form-input" value="<?= htmlspecialchars($job->phone ?? '') ?>" placeholder="0917-000-0000">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Work Location</label>
                                                <input type="text" name="location" class="form-control form-input" value="<?= htmlspecialchars($job->location) ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Compensation Range</label>
                                                <input type="text" name="salary_range" class="form-control form-input" value="<?= htmlspecialchars($job->salary_range) ?>" required>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control form-input" rows="4" required><?= htmlspecialchars($job->description) ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline" data-dismiss="modal" style="border-radius: 12px;">Cancel</button>
                                        <button type="submit" class="btn-modern">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="applicantModal<?= $job->id ?>" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-clipboard-list mr-2"></i> Candidates: <?= htmlspecialchars($job->job_title) ?></h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $this->db->select('alumni.first_name, alumni.last_name, alumni.email, job_applications.applied_at, alumni.id as alumni_id');
                                    $this->db->from('job_applications');
                                    $this->db->join('alumni', 'alumni.id = job_applications.alumni_id');
                                    $this->db->where('job_applications.job_id', $job->id);
                                    $applicants = $this->db->get()->result();
                                    ?>

                                    <?php if (!empty($applicants)): ?>
                                        <div class="table-responsive">
                                            <table class="table" style="border-collapse: separate; border-spacing: 0 8px;">
                                                <thead style="background: #f8fafc;">
                                                    <tr style="text-uppercase; font-size: 11px; font-weight: 700; color: var(--text-muted);">
                                                        <th style="border: none; padding: 12px 16px;">Full Name</th>
                                                        <th style="border: none; padding: 12px 16px;">Email</th>
                                                        <th style="border: none; padding: 12px 16px;">Applied On</th>
                                                        <th style="border: none; padding: 12px 16px; text-align: right;">Profile</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($applicants as $app): ?>
                                                        <tr style="background: white;">
                                                            <td style="padding: 12px 16px; border: 1px solid #f1f5f9; font-weight: 600;"><?= htmlspecialchars($app->first_name . ' ' . $app->last_name) ?></td>
                                                            <td style="padding: 12px 16px; border: 1px solid #f1f5f9; color: var(--text-muted);"><?= htmlspecialchars($app->email) ?></td>
                                                            <td style="padding: 12px 16px; border: 1px solid #f1f5f9; color: var(--text-muted);"><?= date('M d, Y', strtotime($app->applied_at)) ?></td>
                                                            <td style="padding: 12px 16px; border: 1px solid #f1f5f9; text-align: right;">
                                                                <a href="<?= base_url('AdminJobPosting/view_profile/'.$app->alumni_id) ?>" class="btn-action">
                                                                    <i class="fas fa-user-circle"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div style="text-align: center; padding: 40px 20px;">
                                            <i class="fas fa-inbox" style="font-size: 48px; color: #f1f5f9; margin-bottom: 20px; display: block;"></i>
                                            <h5 style="color: var(--text-muted);">No applications found for this role.</h5>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline" data-dismiss="modal" style="border-radius: 12px;">Close</button>
                                    <?php if (!empty($applicants)): ?>
                                        <a href="<?= base_url('AdminJobPosting/export/'.$job->id) ?>" class="btn-modern" style="background: #10b981;">
                                            <i class="fas fa-file-excel mr-2"></i>Export CSV
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal<?= $job->id ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center p-5">
                                    <div style="width: 80px; height: 80px; background: #fff1f2; color: #e11d48; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 32px;">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <h3 style="font-weight: 700; color: var(--text-main);">Delete Posting?</h3>
                                    <p style="color: var(--text-muted);">Are you sure you want to delete <strong><?= htmlspecialchars($job->job_title) ?></strong>? This action cannot be undone.</p>
                                    <div style="display: flex; justify-content: center; gap: 12px; margin-top: 24px;">
                                        <button type="button" class="btn btn-outline" data-dismiss="modal" style="border-radius: 12px;">Cancel</button>
                                        <a href="<?= base_url('AdminJobPosting/delete/'.$job->id) ?>" class="btn-modern" style="background: #ef4444; text-decoration: none; color: white;">Confirm Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="createJobModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('AdminJobPosting/create') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i> Publish New Opportunity</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-id-badge mr-2"></i> Position Title</label>
                            <input type="text" name="job_title" class="form-control form-input" placeholder="e.g. Senior Medical Analyst" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-building-ngo mr-2"></i> Organization</label>
                            <input type="text" name="company" class="form-control form-input" placeholder="Company Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-phone mr-2"></i> Telephone Number</label>
                            <input type="text" name="telephone" class="form-control form-input" placeholder="e.g. 02-8000-0000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-mobile-screen mr-2"></i> Phone Number</label>
                            <input type="text" name="phone" class="form-control form-input" placeholder="e.g. 0917-000-0000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-map-location-dot mr-2"></i> Work Location</label>
                            <input type="text" name="location" class="form-control form-input" placeholder="City, Country" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-hand-holding-dollar mr-2"></i> Compensation Range</label>
                            <input type="text" name="salary_range" class="form-control form-input" placeholder="e.g. ₱40,000 - ₱60,000" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label"><i class="fas fa-file-signature mr-2"></i> Detailed Description</label>
                            <textarea name="description" class="form-control form-input" rows="4" placeholder="Briefly describe the role..." required></textarea>
                        </div>
                        <div class="col-12">
                            <div class="info-item">
                                <label style="color: var(--accent-red); font-weight: 700; margin-bottom: 8px;"><i class="fas fa-graduation-cap mr-2"></i> Targeted Alumni Notification:</label>
                                <select name="target_schools[]" multiple class="form-control form-input" style="height: 150px;">
                                    <optgroup label="Nursing & Allied Health">
                                        <option value="BS in Nursing">BS in Nursing</option>
                                        <option value="BS in Physical Therapy">BS in Physical Therapy</option>
                                    </optgroup>
                                    <optgroup label="Laboratory Sciences">
                                        <option value="BS in Medical Laboratory Science">BS in Medical Laboratory Science</option>
                                        <option value="BS in Pharmacy">BS in Pharmacy</option>
                                    </optgroup>
                                    <optgroup label="Computer Studies">
                                        <option value="BS in Information Technology">BS in Information Technology</option>
                                        <option value="Bachelor of Multimedia Arts">Bachelor of Multimedia Arts</option>
                                    </optgroup>
                                </select>
                                <small style="color: var(--text-muted); display: block; margin-top: 8px;">Use Ctrl/Cmd click to select multiple target groups.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal" style="border-radius: 12px;">Cancel</button>
                    <button type="submit" class="btn-modern">Publish Now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
    $("#jobSearchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".job-card-item").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
</body>
</html>