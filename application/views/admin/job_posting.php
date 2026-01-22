<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Posting Admin | Professional</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-maroon: #800000;
            --primary-hover: #600000;
            --charcoal-text: #2C3E50;
            --muted-blue: #546E7A;
            --bg-soft-grey: #F4F7F6;
            --card-white: #FFFFFF;
            --border-light: #E0E4E8;
            --danger-red: #C0392B;
        }

        body {
            background-color: var(--bg-soft-grey);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--charcoal-text);
        }

        .job-management-container {
            padding: 40px;
            background: var(--card-white);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            margin-top: 40px;
            margin-bottom: 40px;
            border: 1px solid var(--border-light);
        }
        
        .management-header {
            color: var(--primary-maroon);
            font-weight: 800;
            border-bottom: 3px solid var(--primary-maroon);
            display: inline-block;
            padding-bottom: 10px;
        }

        .job-card-custom {
            border: 1px solid var(--border-light);
            border-radius: 12px;
            transition: all 0.3s ease;
            background: var(--card-white);
        }
        .job-card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-maroon);
        }

        .btn-maroon {
            background-color: var(--primary-maroon);
            color: white;
            font-weight: 600;
            border: none;
        }
        .btn-maroon:hover {
            background-color: var(--primary-hover);
            color: white;
        }

        .btn-outline-maroon {
            border: 1px solid var(--primary-maroon);
            color: var(--primary-maroon);
        }
        .btn-outline-maroon:hover {
            background: var(--primary-maroon);
            color: #fff;
        }

        .applicant-badge {
            background: #f8d7da;
            color: var(--primary-maroon);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .modal-header { 
            background-color: var(--primary-maroon); 
            color: white; 
            border-radius: 12px 12px 0 0; 
            padding: 1rem 1.5rem;
        }
        .modal-content { 
            border-radius: 12px; 
            border: none;
            box-shadow: 0 15px 50px rgba(0,0,0,0.2);
        }
        
        .form-group label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--muted-blue);
            display: flex;
            align-items: center;
        }
        .form-group label i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }
        
        .text-maroon { color: var(--primary-maroon); }

        select[multiple] {
            border: 1px solid var(--border-light);
            border-radius: 8px;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container-fluid py-5">
    <div class="container job-management-container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <h2 class="management-header"><i class="fas fa-briefcase mr-2"></i> Job Management</h2>
            </div>
            <div class="col-lg-6 text-lg-right">
                <button class="btn btn-maroon shadow-sm" data-toggle="modal" data-target="#createJobModal">
                    <i class="fas fa-plus-circle mr-2"></i> Create New Posting
                </button>
                <a href="<?= base_url('AdminJobPosting/run_worker') ?>" class="btn btn-outline-maroon ml-2 shadow-sm" title="Notify Alumni">
                    <i class="fas fa-bell mr-2"></i> Notify Alumni
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" class="form-control border-left-0" placeholder="Filter jobs..." id="jobSearchInput">
                </div>
            </div>
        </div>

        <div class="row" id="jobListContainer">
            <?php if (!empty($jobs)): ?>
                <?php foreach($jobs as $job): 
                    // Count applicants for this specific job
                    $this->db->where('job_id', $job->id);
                    $applicant_count = $this->db->count_all_results('job_applications');
                ?>
                    <div class="col-md-6 col-lg-4 mb-4 job-card-item">
                        <div class="card job-card-custom h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-uppercase font-weight-bold text-muted"><?= htmlspecialchars($job->company) ?></small>
                                    <span class="applicant-badge"><?= $applicant_count ?> Applicants</span>
                                </div>
                                <h5 class="card-title font-weight-bold"><?= htmlspecialchars($job->job_title) ?></h5>
                                <p class="small mb-1"><i class="fas fa-map-marker-alt mr-2 text-maroon"></i> <?= htmlspecialchars($job->location) ?></p>
                                <p class="small mb-3"><i class="fas fa-money-bill-wave mr-2 text-maroon"></i> <?= htmlspecialchars($job->salary_range) ?></p>

                                <div class="mt-auto border-top pt-3">
                                    <button class="btn btn-block btn-outline-maroon btn-sm mb-2" data-toggle="modal" data-target="#applicantModal<?= $job->id ?>">
                                        <i class="fas fa-users mr-1"></i> View Applicants
                                    </button>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button class="btn btn-link text-dark btn-sm p-0" data-toggle="modal" data-target="#editModal<?= $job->id ?>"><i class="fas fa-edit"></i> Edit</button>
                                        <button class="btn btn-link text-danger btn-sm p-0" data-toggle="modal" data-target="#deleteModal<?= $job->id ?>"><i class="fas fa-trash"></i> Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="applicantModal<?= $job->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-user-tie mr-2"></i> Applicants for <?= htmlspecialchars($job->job_title) ?></h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <?php
                                    // Fetch detailed applicant data
                                    $this->db->select('alumni.first_name, alumni.last_name, alumni.email, job_applications.applied_at, alumni.id as alumni_id');
                                    $this->db->from('job_applications');
                                    $this->db->join('alumni', 'alumni.id = job_applications.alumni_id');
                                    $this->db->where('job_applications.job_id', $job->id);
                                    $this->db->order_by('job_applications.applied_at', 'DESC');
                                    $applicants = $this->db->get()->result();
                                    ?>

                                    <?php if (!empty($applicants)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover border">
                                                <thead class="bg-light text-maroon">
                                                    <tr>
                                                        <th>Applicant Name</th>
                                                        <th>Email Address</th>
                                                        <th>Date Applied</th>
                                                        <th class="text-center">Profile</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($applicants as $app): ?>
                                                        <tr>
                                                            <td class="align-middle font-weight-bold"><?= htmlspecialchars($app->first_name . ' ' . $app->last_name) ?></td>
                                                            <td class="align-middle"><?= htmlspecialchars($app->email) ?></td>
                                                            <td class="align-middle text-muted"><?= date('M d, Y', strtotime($app->applied_at)) ?></td>
                                                            <td class="text-center">
                                                                <a href="<?= base_url('AdminJobPosting/view_profile/'.$app->alumni_id) ?>" class="btn btn-outline-info btn-sm rounded-pill px-3">
                                                                    View Profile
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-5">
                                            <i class="fas fa-folder-open fa-3x text-light mb-3"></i>
                                            <h5 class="text-muted">No applications received yet.</h5>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Close</button>
                                    <?php if (!empty($applicants)): ?>
                                        <a href="<?= base_url('AdminJobPosting/export/'.$job->id) ?>" class="btn btn-success"><i class="fas fa-download mr-1"></i> Export List</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal<?= $job->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center p-5">
                                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-4"></i>
                                    <h4>Delete Posting?</h4>
                                    <p class="text-muted">Are you sure you want to remove the posting for <strong><?= htmlspecialchars($job->job_title) ?></strong>? This action cannot be undone.</p>
                                    <div class="mt-4">
                                        <button class="btn btn-secondary px-4 mr-2" data-dismiss="modal">Cancel</button>
                                        <a href="<?= base_url('AdminJobPosting/delete/'.$job->id) ?>" class="btn btn-danger px-4">Delete Now</a>
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

<div class="modal fade" id="createJobModal" tabindex="-1" role="dialog" aria-labelledby="createJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="<?= base_url('AdminJobPosting/create') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="createJobModalLabel text-white">
                        <i class="fas fa-plus-circle mr-2"></i> New Job Posting
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <div class="form-group">
                                <label><i class="fas fa-tag"></i> Job Title</label>
                                <input type="text" name="job_title" class="form-control" placeholder="e.g. Registered Nurse" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-building"></i> Company</label>
                                <input type="text" name="company" class="form-control" placeholder="Company Name" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-map-marker-alt"></i> Location</label>
                                <input type="text" name="location" class="form-control" placeholder="City, Region" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-money-bill-wave"></i> Salary Range</label>
                                <input type="text" name="salary_range" class="form-control" placeholder="e.g. ₱25,000 - ₱35,000" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-phone-alt"></i> Telephone</label>
                                        <input type="tel" name="telephone_number" class="form-control" placeholder="Landline">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-mobile-alt"></i> Phone Number</label>
                                        <input type="tel" name="contact_details" class="form-control" placeholder="Mobile" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-align-left"></i> Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Job duties..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-list-ul"></i> Qualifications</label>
                                <textarea name="qualifications" class="form-control" rows="3" placeholder="Requirements..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-image"></i> Company Image / Logo</label>
                                <input type="file" name="image_filename" class="form-control-file">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text-maroon font-weight-bold"><i class="fas fa-graduation-cap"></i> Target Schools / Courses (Notify Alumni):</label>
                                <select name="target_schools[]" multiple class="form-control" style="height: 180px;">
                                    <optgroup label="School of Nursing and Allied Health Studies">
                                        <option value="BS in Nursing">BS in Nursing</option>
                                        <option value="BS in Radiologic Technology">BS in Radiologic Technology</option>
                                        <option value="BS in Physical Therapy">BS in Physical Therapy</option>
                                    </optgroup>
                                    <optgroup label="School of Medical Laboratory Science">
                                        <option value="BS in Medical Laboratory Science">BS in Medical Laboratory Science</option>
                                        <option value="BS in Pharmacy">BS in Pharmacy</option>
                                        <option value="BS in Biology">BS in Biology</option>
                                    </optgroup>
                                    <optgroup label="School of Accountancy, Science, and Education">
                                        <option value="BS in Accountancy">BS in Accountancy</option>
                                        <option value="BS in Psychology">BS in Psychology</option>
                                    </optgroup>
                                    <optgroup label="School of Communication, Multimedia, and Computer Studies">
                                        <option value="BA in Communication">BA in Communication</option>
                                        <option value="Bachelor of Multimedia Arts">Bachelor of Multimedia Arts</option>
                                        <option value="BS in Information Technology">BS in Information Technology</option>
                                    </optgroup>
                                </select>
                                <small class="text-muted mt-2 d-block">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-maroon px-5">Post Job</button>
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
    // Job search filter logic
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