<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Posting Admin | Alumni Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --maroon: #8B1538;
            --maroon-dark: #6B0F2A;
            --gold: #f5f5f5;
            --bg: #fcf9f2;
            --card: #ffffff;
            --text: #1F2937;
            --muted: #6B7280;
            --border: #E5E7EB;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.15);
        }

        body { 
            background: var(--bg); 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; 
            color: var(--text); 
            line-height: 1.6; 
        }

        /* Consistent Margin & Padding Patterns with Alumni Panel */
        .admin-wrapper { 
            max-width: 1400px; 
            margin: 40px auto; 
            padding: 0 20px; 
        }

        .alumni-card {
            background: var(--card);
            padding: 32px;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
        }

        .main-header h2 { 
            color: var(--maroon); 
            font-weight: 800; 
            font-size: 24px;
            letter-spacing: -0.5px;
        }

        /* Unified Action Buttons */
        .btn-modern-search {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-modern-search:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .btn-outline-custom {
            border: 1px solid var(--maroon);
            color: var(--maroon);
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 24px;
            transition: all 0.3s;
        }

        .btn-outline-custom:hover {
            background: rgba(139, 21, 56, 0.05);
            color: var(--maroon-dark);
        }

        /* Standardized Search Box Wrapper */
        .search-box-wrapper {
            background: #f9f9f9;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 8px 8px 8px 20px;
            transition: all 0.3s;
        }

        .search-box-wrapper:focus-within {
            border-color: var(--maroon);
            background: white;
            box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
        }

        .search-input-clean {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            font-size: 14px;
        }

        /* Refined Job Cards */
        .job-card-custom {
            border: 1px solid var(--border);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--card);
            overflow: hidden;
        }

        .job-card-custom:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--maroon);
        }

        .applicant-badge {
            background: rgba(139, 21, 56, 0.1);
            color: var(--maroon);
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        /* Modal Customization (Matching Alumni Profile) */
        .modal-modern .modal-content {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .modal-modern .modal-header {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: #fff;
            padding: 25px;
            border: none;
        }

        .form-group label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border);
            padding: 12px;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: var(--maroon);
            box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
        }

        .info-item {
            padding: 12px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        /* Guide Banner */
        .page-guide {
            background: #FFF5F7;
            border-left: 4px solid var(--maroon);
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 4px 12px 12px 4px;
            font-size: 0.9rem;
            color: var(--maroon-dark);
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <div class="alumni-card">
        <div class="main-header d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0"><i class="fas fa-briefcase mr-3"></i>Job Management</h2>
                <p class="text-muted mt-2 mb-0">Publish opportunities and track applicant engagement</p>
            </div>
            <div class="mt-3 mt-lg-0">
                <button class="btn btn-modern-search shadow-sm" data-toggle="modal" data-target="#createJobModal">
                    <i class="fas fa-plus-circle mr-2"></i> Create New Posting
                </button>
                <a href="<?= base_url('AdminJobPosting/run_worker') ?>" class="btn btn-outline-custom ml-2">
                    <i class="fas fa-paper-plane mr-2"></i> Notify Alumni
                </a>
            </div>
        </div>

        <div class="page-guide">
            <i class="fas fa-circle-info mr-2"></i>
            <strong>Admin Guide:</strong> Manage active job listings below. You can filter by title or company, view applicant lists, or export data for reporting.
        </div>

        <div class="row mb-5">
            <div class="col-md-5">
                <div class="search-box-wrapper d-flex align-items-center">
                    <i class="fas fa-magnifying-glass text-muted"></i>
                    <input type="text" class="form-control search-input-clean" placeholder="Filter jobs by title, company, or location..." id="jobSearchInput">
                </div>
            </div>
        </div>

        <div class="row" id="jobListContainer">
            <?php if (!empty($jobs)): ?>
                <?php foreach($jobs as $job): 
                    $this->db->where('job_id', $job->id);
                    $applicant_count = $this->db->count_all_results('job_applications');
                ?>
                    <div class="col-md-6 col-lg-4 mb-4 job-card-item">
                        <div class="card job-card-custom h-100 shadow-sm">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <small class="text-uppercase font-weight-bold" style="color: var(--gold); letter-spacing: 1px;"><?= htmlspecialchars($job->company) ?></small>
                                        <h5 class="card-title font-weight-bold mt-1 mb-0" style="font-size: 1.1rem;"><?= htmlspecialchars($job->job_title) ?></h5>
                                    </div>
                                    <span class="applicant-badge"><?= $applicant_count ?> Applicants</span>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="small text-muted mb-2"><i class="fas fa-location-dot mr-2 text-maroon"></i> <?= htmlspecialchars($job->location) ?></p>
                                    <p class="small text-muted mb-0"><i class="fas fa-wallet mr-2 text-maroon"></i> <?= htmlspecialchars($job->salary_range) ?></p>
                                </div>

                                <div class="mt-auto pt-3 border-top">
                                    <button class="btn btn-block btn-outline-custom btn-sm mb-3" data-toggle="modal" data-target="#applicantModal<?= $job->id ?>">
                                        <i class="fas fa-users-viewfinder mr-2"></i> Review Applicants
                                    </button>
                                    <div class="d-flex justify-content-between align-items-center px-1">
                                        <button class="btn btn-link text-muted btn-sm p-0 font-weight-bold" data-toggle="modal" data-target="#editModal<?= $job->id ?>" style="text-decoration:none;"><i class="fas fa-pen-to-square mr-1"></i> Edit</button>
                                        <button class="btn btn-link text-danger btn-sm p-0 font-weight-bold" data-toggle="modal" data-target="#deleteModal<?= $job->id ?>" style="text-decoration:none;"><i class="fas fa-trash-can mr-1"></i> Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade modal-modern" id="editModal<?= $job->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <form action="<?= base_url('AdminJobPosting/update/'.$job->id) ?>" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-pen-to-square mr-2"></i> Update Posting</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Position Title</label>
                                                    <input type="text" name="job_title" class="form-control" value="<?= htmlspecialchars($job->job_title) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Organization</label>
                                                    <input type="text" name="company" class="form-control" value="<?= htmlspecialchars($job->company) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Telephone Number</label>
                                                    <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($job->telephone ?? '') ?>" placeholder="02-8000-0000">
                                                </div>
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($job->phone ?? '') ?>" placeholder="0917-000-0000">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Work Location</label>
                                                    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($job->location) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Compensation Range</label>
                                                    <input type="text" name="salary_range" class="form-control" value="<?= htmlspecialchars($job->salary_range) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($job->description) ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="background: #f8fafc;">
                                        <button type="button" class="btn btn-light px-4" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-modern-search px-5">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade modal-modern" id="applicantModal<?= $job->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold"><i class="fas fa-clipboard-list mr-2"></i> Candidates: <?= htmlspecialchars($job->job_title) ?></h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <?php
                                    $this->db->select('alumni.first_name, alumni.last_name, alumni.email, job_applications.applied_at, alumni.id as alumni_id');
                                    $this->db->from('job_applications');
                                    $this->db->join('alumni', 'alumni.id = job_applications.alumni_id');
                                    $this->db->where('job_applications.job_id', $job->id);
                                    $applicants = $this->db->get()->result();
                                    ?>

                                    <?php if (!empty($applicants)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover border-0">
                                                <thead style="background: #f8fafc;">
                                                    <tr class="text-uppercase small font-weight-bold text-muted">
                                                        <th class="border-0">Full Name</th>
                                                        <th class="border-0">Email</th>
                                                        <th class="border-0">Applied On</th>
                                                        <th class="border-0 text-right">Profile</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($applicants as $app): ?>
                                                        <tr>
                                                            <td class="align-middle font-weight-bold"><?= htmlspecialchars($app->first_name . ' ' . $app->last_name) ?></td>
                                                            <td class="align-middle"><?= htmlspecialchars($app->email) ?></td>
                                                            <td class="align-middle text-muted"><?= date('M d, Y', strtotime($app->applied_at)) ?></td>
                                                            <td class="text-right">
                                                                <a href="<?= base_url('AdminJobPosting/view_profile/'.$app->alumni_id) ?>" class="btn btn-sm btn-light" style="border-radius: 8px; color: var(--maroon);">
                                                                    <i class="fas fa-user-circle"></i>
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
                                <div class="modal-footer" style="background: #f8fafc;">
                                    <button type="button" class="btn btn-light px-4" data-dismiss="modal">Close</button>
                                    <?php if (!empty($applicants)): ?>
                                        <a href="<?= base_url('AdminJobPosting/export/'.$job->id) ?>" class="btn btn-success px-4" style="border-radius: 10px;"><i class="fas fa-file-excel mr-2"></i>Export CSV</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal<?= $job->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 20px;">
                                <div class="modal-body text-center p-5">
                                    <div class="mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: #FFF5F5; border-radius: 50%;">
                                        <i class="fas fa-trash-can fa-2x text-danger"></i>
                                    </div>
                                    <h4 class="font-weight-bold">Remove Posting?</h4>
                                    <p class="text-muted mb-4">You are about to delete the <strong><?= htmlspecialchars($job->job_title) ?></strong> position. This action is permanent.</p>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-light px-4 mr-2" data-dismiss="modal" style="border-radius: 10px;">Keep Posting</button>
                                        <a href="<?= base_url('AdminJobPosting/delete/'.$job->id) ?>" class="btn btn-danger px-4" style="border-radius: 10px;">Confirm Delete</a>
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

<div class="modal fade modal-modern" id="createJobModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('AdminJobPosting/create') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-plus-circle mr-2"></i> Publish New Opportunity</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-id-badge mr-2"></i> Position Title</label>
                                <input type="text" name="job_title" class="form-control" placeholder="e.g. Senior Medical Analyst" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-building-ngo mr-2"></i> Organization</label>
                                <input type="text" name="company" class="form-control" placeholder="Company Name" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-phone mr-2"></i> Telephone Number</label>
                                <input type="text" name="telephone" class="form-control" placeholder="e.g. 02-8000-0000">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-mobile-screen mr-2"></i> Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="e.g. 0917-000-0000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-map-location-dot mr-2"></i> Work Location</label>
                                <input type="text" name="location" class="form-control" placeholder="City, Country" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-hand-holding-dollar mr-2"></i> Compensation Range</label>
                                <input type="text" name="salary_range" class="form-control" placeholder="e.g. ₱40,000 - ₱60,000" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-file-signature mr-2"></i> Detailed Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Briefly describe the role..." required></textarea>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="info-item">
                                <label class="text-maroon font-weight-bold"><i class="fas fa-graduation-cap mr-2"></i> Targeted Alumni Notification:</label>
                                <select name="target_schools[]" multiple class="form-control mt-2" style="height: 150px; border: none; background: transparent;">
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
                                <small class="text-muted d-block mt-2">Use Ctrl/Cmd click to select multiple target groups.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc;">
                    <button type="button" class="btn btn-light px-4" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-modern-search px-5">Publish Now</button>
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