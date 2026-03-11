<style>
    :root {
        --primary-color: #8B1538;
        --accent-red: #700a0a;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --card-bg: rgba(255, 255, 255, 0.95);
        --border-radius: 24px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .admin-wrapper { 
        max-width: 1400px; 
        margin: 0 auto; 
        padding: 20px 24px;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header Styling */
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
        color: white;
    }

    .header-section h1 span { color: #ff6b6b; }
    .header-section p { color: rgba(255, 255, 255, 0.85); font-size: 14px; margin: 0; }

    /* Action Buttons */
    .btn-header {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .btn-create { background: white; color: var(--primary-color); }
    .btn-create:hover { transform: translateY(-2px); background: #f8fafc; }

    .btn-notify { background: var(--accent-red); color: white; }
    .btn-notify:hover { transform: translateY(-2px); background: #ff5252; color: white; }

    /* Main Table Card */
    .main-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        backdrop-filter: blur(10px);
    }

    /* Custom Table */
    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .custom-table th { padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); border: none; }
    .custom-table tr.data-row { background: white; transition: var(--transition); }
    .custom-table tr.data-row:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .custom-table td { padding: 16px 20px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    .custom-table td:first-child { border-left: 1px solid #f1f5f9; border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
    .custom-table td:last-child { border-right: 1px solid #f1f5f9; border-top-right-radius: 14px; border-bottom-right-radius: 14px; }

    .job-title-cell { font-weight: 700; color: var(--text-main); font-size: 15px; cursor: pointer; transition: var(--transition); }
    .job-title-cell:hover { text-decoration: underline; color: var(--primary-color); }
    .company-label { display: block; font-size: 12px; color: var(--text-muted); font-weight: 500; }

    .applicant-badge { background: rgba(139, 21, 56, 0.1); color: var(--primary-color); padding: 6px 14px; border-radius: 10px; font-size: 12px; font-weight: 700; }

    .btn-action {
        width: 38px; height: 38px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid #f1f5f9; background: white; color: var(--text-muted); transition: var(--transition);
        margin-left: 5px; cursor: pointer;
    }

    .btn-action:hover { background: #f8fafc; color: var(--primary-color); border-color: var(--primary-color); transform: translateY(-2px); }
    .btn-action.delete:hover { background: #fff5f5; color: #ef4444; border-color: #ef4444; }

    /* Search Button Styling */
    .btn-search {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-red));
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-search:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }

    /* Search Input Styling */
    #jobSearch {
        transition: all 0.3s !important;
    }
    #jobSearch:focus {
        outline: none;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1) !important;
        background: white !important;
    }

    /* Modal Styling */
    .modal-content { border-radius: 24px; border: none; overflow: hidden; }
    .modal-header { background: var(--accent-red); color: white; padding: 25px; border: none; }
    .modal-body { padding: 30px; }
    .form-label { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; display: block; }
    .form-input { border-radius: 12px; padding: 12px; font-size: 14px; font-weight: 500; border: 1px solid #e2e8f0; }
    .form-input:focus { border-color: var(--accent-red); box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05); }

    .targeted-tag { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 14px; margin-top: 10px; }

    /* Modal Spacing for Header */
    .modal-dialog { margin-top: 100px !important; margin-bottom: 50px !important; }

    @media (min-width: 992px) {
        /* Desktop: Wide for profile/applicants, adaptive for others */
        .modal-wide { max-width: 1000px !important; }
        .modal-adaptive { max-width: 650px !important; }
    }

    @media (max-width: 768px) {
        /* Mobile Modal Adjustments */
        .modal-dialog { margin-top: 60px !important; margin-left: 12px; margin-right: 12px; margin-bottom: 30px !important; }
        .modal-content { border-radius: 20px; }
        .modal-body { padding: 20px; }
        .modal-header { padding: 20px; }
    }
</style>

<div class="admin-wrapper">
    <div class="header-section">
        <div class="header-title">
            <h1>Job <span>Management</span></h1>
            <p>Publish and manage career postings for the alumni network.</p>
        </div>
        <div class="d-flex gap-3">
            <button class="btn btn-danger" data-toggle="modal" data-target="#createJobModal" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">
                <i class="fas fa-plus mr-2"></i> Create Posting
            </button>
            <a href="<?= base_url('AdminJobPosting/run_worker') ?>" class="btn-header btn-notify" style="text-decoration:none;">
                <i class="fas fa-paper-plane"></i> NOTIFY ALUMNI
            </a>
        </div>
    </div>

    <div class="header-section" style="background: var(--card-bg); padding: 24px 30px; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 24px; display: block;">
        <div style="display: flex; gap: 12px; align-items: center;">
            <div style="flex: 1; position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 14px;"></i>
                <input type="text" id="jobSearch" placeholder="Search job title or company..." value="" style="width: 100%; padding: 12px 14px 12px 44px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; transition: all 0.3s;">
            </div>
            <button type="button" class="btn-search">
                <i class="fas fa-search"></i> Search
            </button>
        </div>
    </div>

    <div class="main-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="35%">POSITION DETAILS</th>
                        <th width="15%">ALUMNI APPLICANTS</th>
                        <th width="35%">META INFORMATION</th>
                        <th width="15%" class="text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="jobListBody">
                    <?php if (!empty($jobs)): ?>
                        <?php foreach($jobs as $job): 
                            $this->db->where('job_id', $job->id);
                            $applicant_count = $this->db->count_all_results('job_applications');
                        ?>
                            <tr class="data-row job-item">
                                <td>
                                    <div class="job-title-cell" data-toggle="modal" data-target="#applicantModal<?= $job->id ?>">
                                        <?= htmlspecialchars($job->job_title) ?>
                                    </div>
                                    <span class="company-label"><?= htmlspecialchars($job->company) ?></span>
                                </td>
                                <td>
                                    <span class="applicant-badge">
                                        <i class="fas fa-users mr-1"></i> <?= $applicant_count ?> candidates
                                    </span>
                                </td>
                                <td>
                                    <div class="meta-info" style="font-size: 13px; color: var(--text-muted); font-weight: 600; display: flex; align-items: center; gap: 15px;">
                                        <span><i class="fas fa-map-marker-alt text-danger mr-1"></i> <?= htmlspecialchars($job->location) ?></span>
                                        <span><i class="fas fa-wallet text-danger mr-1"></i> <?= htmlspecialchars($job->salary_range) ?></span>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <button class="btn-action" data-toggle="modal" data-target="#applicantModal<?= $job->id ?>" title="View Applicants">
                                        <i class="fas fa-users"></i>
                                    </button>
                                    <button class="btn-action" data-toggle="modal" data-target="#editModal<?= $job->id ?>" title="Edit Posting">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn-action delete" onclick="confirmDelete(<?= $job->id ?>, '<?= htmlspecialchars($job->job_title) ?>')" title="Delete Posting">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-briefcase fa-3x mb-3 d-block opacity-20"></i>
                                <p class="font-weight-bold">No active job opportunities found.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- CREATE JOB MODAL -->
<div class="modal fade" id="createJobModal" tabindex="-1">
    <div class="modal-dialog modal-adaptive">
        <div class="modal-content">
            <form action="<?= base_url('AdminJobPosting/create') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-2"></i> Publish New Opportunity</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">JOB TITLE</label>
                            <input type="text" name="job_title" class="form-control form-input" placeholder="e.g. Senior Medical Analyst" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">COMPANY NAME</label>
                            <input type="text" name="company" class="form-control form-input" placeholder="Organization" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">LOCATION</label>
                            <input type="text" name="location" class="form-control form-input" placeholder="City, Country" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">COMPENSATION RANGE</label>
                            <input type="text" name="salary_range" class="form-control form-input" placeholder="e.g. ₱40,000 - ₱60,000" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">DESCRIPTION & QUALIFICATIONS</label>
                            <textarea name="description" class="form-control form-input" rows="4" placeholder="Briefly describe the role..." required></textarea>
                        </div>
                        <div class="col-12">
                            <div class="targeted-tag">
                                <label class="font-weight-bold text-dark mb-2 d-block"><i class="fas fa-graduation-cap mr-2"></i> TARGETED ALUMNI GROUPS</label>
                                <select name="target_schools[]" multiple class="form-control" style="height: 120px; border-radius: 10px;">
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
                                <small class="text-muted d-block mt-2">Hold Ctrl (Cmd) to select multiple target degrees.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light px-4" style="border-radius: 12px; font-weight: 700;" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-danger px-5" style="background: var(--accent-red); border-radius: 12px; font-weight: 700;">PUBLISH NOW</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach($jobs as $job): ?>
    <!-- EDIT MODAL -->
    <div class="modal fade" id="editModal<?= $job->id ?>" tabindex="-1">
        <div class="modal-dialog modal-adaptive">
            <div class="modal-content">
                <form action="<?= base_url('AdminJobPosting/update/'.$job->id) ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold"><i class="fas fa-pen mr-2"></i> Update Posting</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-muted uppercase">JOB TITLE</label>
                                <input type="text" name="job_title" class="form-control form-input" value="<?= htmlspecialchars($job->job_title) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-muted uppercase">COMPANY</label>
                                <input type="text" name="company" class="form-control form-input" value="<?= htmlspecialchars($job->company) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-muted uppercase">LOCATION</label>
                                <input type="text" name="location" class="form-control form-input" value="<?= htmlspecialchars($job->location) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-muted uppercase">COMPENSATION</label>
                                <input type="text" name="salary_range" class="form-control form-input" value="<?= htmlspecialchars($job->salary_range) ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="small font-weight-bold text-muted uppercase">DESCRIPTION</label>
                                <textarea name="description" class="form-control form-input" rows="4" required><?= htmlspecialchars($job->description) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light px-4" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-danger px-5" style="background: var(--accent-red);">SAVE CHANGES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- APPLICANT LIST MODAL -->
    <div class="modal fade" id="applicantModal<?= $job->id ?>" tabindex="-1">
        <div class="modal-dialog modal-wide">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-users-viewfinder mr-2"></i> Candidates: <?= htmlspecialchars($job->job_title) ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-0">
                    <?php
                    $this->db->select('alumni.first_name, alumni.last_name, alumni.email, job_applications.applied_at, alumni.id as alumni_id');
                    $this->db->from('job_applications');
                    $this->db->join('alumni', 'alumni.id = job_applications.alumni_id');
                    $this->db->where('job_applications.job_id', $job->id);
                    $applicants = $this->db->get()->result();
                    ?>

                    <?php if (!empty($applicants)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="border: none;">
                                <thead class="bg-light">
                                    <tr class="small font-weight-bold text-muted uppercase">
                                        <th class="pl-4 py-3 border-0">FULL NAME</th>
                                        <th class="py-3 border-0">EMAIL ADDRESS</th>
                                        <th class="py-3 border-0">APPLIED ON</th>
                                        <th class="pr-4 py-3 border-0 text-right">PROFILE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($applicants as $app): ?>
                                        <tr>
                                            <td class="pl-4 py-3 font-weight-bold align-middle"><?= htmlspecialchars($app->first_name . ' ' . $app->last_name) ?></td>
                                            <td class="py-3 align-middle"><?= htmlspecialchars($app->email) ?></td>
                                            <td class="py-3 align-middle text-muted"><?= date('M d, Y', strtotime($app->applied_at)) ?></td>
                                            <td class="pr-4 py-3 text-right">
                                                <a href="<?= base_url('AdminAlumni/view_profile/'.$app->alumni_id) ?>" class="btn-action" title="View Profile">
                                                    <i class="fas fa-id-card"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-light mb-3"></i>
                            <h5 class="text-muted">No applications found for this role.</h5>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light px-4 font-weight-bold" data-dismiss="modal">CLOSE</button>
                    <?php if (!empty($applicants)): ?>
                        <a href="<?= base_url('AdminJobPosting/export/'.$job->id) ?>" class="btn btn-success px-4" style="border-radius: 12px; font-weight: 700;">
                            <i class="fas fa-file-csv mr-2"></i> EXPORT LIST
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Job Search Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('jobSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const jobRows = document.querySelectorAll('.job-item');
                
                // Only filter if search term has at least 3 characters
                if (searchTerm.length < 3) {
                    // Show all rows if less than 3 characters
                    jobRows.forEach(row => {
                        row.style.display = '';
                    });
                    return;
                }
                
                jobRows.forEach(row => {
                    const jobTitle = row.querySelector('.job-title-cell')?.textContent.toLowerCase() || '';
                    const company = row.querySelector('.company-label')?.textContent.toLowerCase() || '';
                    
                    if (jobTitle.includes(searchTerm) || company.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });

    function confirmDelete(id, title) {
        Swal.fire({
            title: 'Delete Posting?',
            text: "Are you sure you want to permanently remove '" + title + "'?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#8B1538',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'CONFIRM DELETE',
            padding: '2em',
            customClass: {
                popup: '',
                confirmButton: 'btn btn-danger px-4',
                cancelButton: 'btn btn-light px-4 mr-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('AdminJobPosting/delete/') ?>" + id;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        <?php if($this->session->flashdata('success')): ?>
            Toast.fire({
                icon: 'success',
                title: '<?= $this->session->flashdata('success') ?>'
            });
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            Toast.fire({
                icon: 'error',
                title: '<?= $this->session->flashdata('error') ?>'
            });
        <?php endif; ?>
    });
</script>
