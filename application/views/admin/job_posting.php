<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Posting Admin | Enhanced</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #700A0A; /* Deep Red/Maroon */
            --primary-light: #A83A3A; /* Lighter shade for hover/focus */
            --primary-dark: #4A0707; /* Darker shade */
            --info-color: #17A2B8;
            --success-color: #28A745;
            --danger-color: #DC3545;
            --text-dark: #212529;
            --text-muted: #6C757D;
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
              height: 100%;
            min-height: 100%;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch; /* smoother on mobile */
        }

        /* Main Container Styling */
        .job-management-container {
            padding: 30px;
            background: var(--light-bg);
            border-radius: 16px; /* Slightly larger border radius */
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08); /* Stronger, softer shadow */
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        /* Heading */
        .management-header {
            color: var(--text-dark);
            font-weight: 700;
            border-bottom: 2px solid var(--primary-light);
            padding-bottom: 15px;
        }

        /* Job Card Styling */
        .job-card-custom {
            border: 1px solid #E9ECEF;
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-left: 6px solid var(--primary-color); /* Stronger left border */
        }
        .job-card-custom:hover {
            transform: translateY(-5px); /* More noticeable lift */
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            color: var(--primary-color);
            font-weight: 700; /* Bolder title */
            font-size: 1.3rem;
        }
        .card-subtitle {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-bottom: 15px;
            font-weight: 500;
        }
        .card-text {
            font-size: 0.9rem;
        }
        .card-text strong {
            color: var(--text-dark);
            font-weight: 600;
        }
        .job-details-icon {
            width: 20px;
            text-align: center;
        }
        
        /* Applicants Button */
        .btn-applicants {
            background-color: var(--info-color);
            border-color: var(--info-color);
            color: white;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .btn-applicants:hover {
            background-color: #117A8B;
            border-color: #117A8B;
            color: white;
        }
        .applicant-count {
            color: #FFFFFF; /* White for count inside info button */
            font-weight: 700;
            background-color: rgba(0,0,0,0.1);
            padding: 2px 6px;
            border-radius: 5px;
            margin-left: 5px;
        }

        /* Primary Action Buttons (Edit/Delete) */
        .btn-card-action {
            font-weight: 600;
            transition: opacity 0.3s, transform 0.2s;
            border-radius: 8px; /* Slightly rounded buttons */
        }
        .btn-card-action:hover {
            transform: translateY(-1px);
        }
        
        /* Main Button Styling */
        .btn-create-job {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .btn-create-job:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            box-shadow: 0 4px 10px rgba(112, 10, 10, 0.3);
        }
        
        /* Search Input */
        .input-group .form-control {
            border-right: none;
            border-radius: 8px 0 0 8px;
        }
        .input-group-text {
            background-color: var(--light-bg);
            border-left: none;
            color: var(--primary-color);
            border-radius: 0 8px 8px 0;
        }

        /* Modal Enhancements */
        .modal-header-custom, .modal-header.bg-primary, .modal-header.bg-danger, .modal-header.bg-info {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom: none;
            padding: 15px 25px;
        }
        .modal-header-custom {
            background-color: var(--primary-color) !important;
        }
        .modal-header.bg-primary {
            background-color: var(--primary-color) !important;
        }
        .modal-header.bg-danger {
            background-color: var(--danger-color) !important;
        }
        .modal-header.bg-info {
            background-color: var(--info-color) !important;
        }
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .modal-footer button {
            font-weight: 500;
            border-radius: 6px;
        }

        /* Image Preview in Modal */
        .card-img-top-preview {
            max-width: 120px; /* Smaller, cleaner logo preview */
            max-height: 120px;
            object-fit: contain;
            border: 1px dashed #CCC;
            padding: 5px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        /* Table Styling for Applicants Modal */
        .table-responsive {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow-x: auto;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.03);
        }
        .table thead th {
            background-color: #E9ECEF;
            color: var(--text-light);
            font-weight: 600;
        }
        .modal-dialog {
        max-height: calc(100vh - 3.5rem); /* ensure dialog fits viewport */
        }
        .modal-body {
        overflow-y: auto;
        max-height: calc(100vh - 12rem); /* tweak to taste */
        }
        .modal-lg {
    max-width: 95% !important;  /* was ~900px, now much wider */
    margin: 10px !important;
}
    .modal-extra-wide {
    max-width: 95% !important;
    margin: 10px !important;

}


    </style>
</head>
<body>

<div class="container-fluid py-4">
    <div class="container job-management-container">
        <h2 class="management-header mb-4"><i class="fas fa-briefcase mr-2"></i> Posted Jobs Management</h2>
        
        <div class="d-flex justify-content-between align-items-center mb-5 flex-column flex-md-row">
            <button class="btn btn-primary mb-3 mb-md-0 btn-create-job" data-toggle="modal" data-target="#createJobModal">
                <i class="fas fa-plus-circle mr-1"></i> Create New Job
            </button>
            <a href="<?= base_url('AdminJobPosting/run_worker') ?>" class="btn btn-warning">
                <i class="fas fa-bell"></i> Send Email Notification Now
            </a>
            <div class="input-group" style="max-width: 350px;">
                <input type="text" class="form-control" placeholder="Search job title or company..." id="jobSearchInput">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>

        <div class="row" id="jobListContainer">
            <?php if (empty($jobs)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center py-4" role="alert" style="border-radius: 10px;">
                        <i class="fas fa-info-circle mr-1"></i> No jobs are currently posted. Click "Create New Job" to get started.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach($jobs as $job): 
                    // Calculate applicant count for display
                    // NOTE: This PHP logic is for demonstration only, actual counting should be efficient
                    $this->db->where('job_id', $job->id);
                    $applicant_count = $this->db->count_all_results('job_applications');
                ?>
                    <div class="col-md-6 col-lg-4 mb-4 job-card-item">
                        <div class="card job-card-custom h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($job->job_title) ?></h5>
                                <h6 class="card-subtitle mb-3"><i class="far fa-building mr-1"></i> <?= htmlspecialchars($job->company) ?></h6>
                                
                                <p class="card-text mb-2"><i class="fas fa-map-marker-alt mr-2 job-details-icon text-muted"></i> Location: <?= htmlspecialchars($job->location) ?></p>
                                <p class="card-text mb-3"><i class="fas fa-money-bill-wave mr-2 job-details-icon text-muted"></i> Salary: <?= htmlspecialchars($job->salary_range) ?></p>

                                <div class="mt-auto pt-3 border-top"> 
                                    <button class="btn btn-applicants btn-sm mb-3 w-100" data-toggle="modal" data-target="#applicantModal<?= $job->id ?>">
                                        <i class="fas fa-users mr-1"></i> View Applicants <span class="applicant-count"><?= $applicant_count ?></span>
                                    </button>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-primary btn-sm flex-fill mr-2 btn-card-action" data-toggle="modal" data-target="#editModal<?= $job->id ?>"><i class="fas fa-edit"></i> Edit</button>
                                        <button class="btn btn-danger btn-sm flex-fill ml-2 btn-card-action" data-toggle="modal" data-target="#deleteModal<?= $job->id ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal<?= $job->id ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <form action="<?= base_url('AdminJobPosting/delete/'.$job->id) ?>" method="post">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2"></i> Confirm Deletion</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete the job "<?= htmlspecialchars($job->job_title) ?>"?</p>
                                        <small class="text-danger font-weight-bold">This action cannot be undone.</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt mr-1"></i> Delete Job</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                    <div class="modal fade" id="editModal<?= $job->id ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form action="<?= base_url('AdminJobPosting/update/'.$job->id) ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title"><i class="fas fa-edit mr-2"></i> Edit Job: <?= htmlspecialchars($job->job_title) ?></h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 mb-3 text-center">
                                                <?php if ($job->image_filename): ?>
                                                    <label class="d-block font-weight-bold">Current Company Logo/Image</label>
                                                    <img src="<?= base_url('./assets/uploads/jobs/' . $job->image_filename) ?>" class="card-img-top-preview img-fluid" alt="Job Image">
                                                    <input type="hidden" name="current_image_filename" value="<?= htmlspecialchars($job->image_filename) ?>">
                                                <?php else: ?>
                                                    <div class="alert alert-light border text-muted">No Logo Attached</div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><i class="fas fa-tag mr-1"></i> Job Title</label>
                                                    <input type="text" name="job_title" class="form-control" value="<?= htmlspecialchars($job->job_title) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="far fa-building mr-1"></i> Company</label>
                                                    <input type="text" name="company" class="form-control" value="<?= htmlspecialchars($job->company) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="fas fa-map-marker-alt mr-1"></i> Location</label>
                                                    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($job->location) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="fas fa-money-bill-wave mr-1"></i> Salary Range</label>
                                                    <input type="text" name="salary_range" class="form-control" value="<?= htmlspecialchars($job->salary_range) ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><i class="fas fa-phone mr-1"></i> Contact Details</label>
                                                    <input type="text" name="contact_details" class="form-control" value="<?= htmlspecialchars($job->contact_details) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="fas fa-file-alt mr-1"></i> Qualifications</label>
                                                    <textarea name="qualifications" class="form-control" rows="3" required><?= htmlspecialchars($job->qualifications) ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="fas fa-align-left mr-1"></i> Description</label>
                                                    <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($job->description) ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="far fa-image mr-1"></i> Replace Image (Optional)</label>
                                                    <input type="file" name="image_filename" class="form-control-file" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                    <div class="modal fade" id="applicantModal<?= $job->id ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title"><i class="fas fa-user-check mr-2"></i> Applicants for "<?= htmlspecialchars($job->job_title) ?>"</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    // Fetching applicants (using original logic for demonstration)
                                    $this->db->select('alumni.*, job_applications.applied_at'); // Added applied_at
                                    $this->db->from('job_applications');
                                    $this->db->join('alumni', 'alumni.id = job_applications.alumni_id');
                                    $this->db->where('job_applications.job_id', $job->id);
                                    $applicants = $this->db->get()->result();
                                    ?>
                                    
                                    <?php if (count($applicants) > 0): ?>
                                        <div class="d-flex justify-content-end mb-3">
                                            <a href="<?= base_url('AdminJobPosting/export_applicants/'.$job->id) ?>" class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-file-excel mr-1"></i> Export All Applicants (<?= count($applicants) ?>)
                                            </a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Alumni No.</th>
                                                        <th>Grad Year</th>
                                                        <th>Applied On</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($applicants as $applicant): ?>
                                                        <tr>
                                                            <td><i class="fas fa-user-graduate text-primary mr-1"></i> <?= htmlspecialchars($applicant->first_name . ' ' . $applicant->last_name) ?></td>
                                                            <td><a href="mailto:<?= htmlspecialchars($applicant->email) ?>"><?= htmlspecialchars($applicant->email) ?></a></td>
                                                            <td><?= htmlspecialchars($applicant->alumni_number) ?></td>
                                                            <td><?= htmlspecialchars($applicant->graduation_year) ?></td>
                                                            <td><?= date('M d, Y h:i A', strtotime($applicant->applied_at)) ?></td>
                                                            <td>
                                                                <a href="<?= base_url('AdminJobPosting/download_resume/'.$applicant->id) ?>" class="btn btn-sm btn-outline-primary" title="Download Resume">
                                                                    <i class="fas fa-download"></i> Resume
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning text-center py-3" role="alert" style="border-radius: 8px;">
                                            <i class="fas fa-exclamation-circle mr-1"></i> No alumni have applied for this job yet.
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="createJobModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-extra-wide" role="document">
        <div class="modal-content">
            <form action="<?= base_url('AdminJobPosting/create') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i> Create New Job Posting</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-tag mr-1"></i> Job Title</label>
                                <input type="text" name="job_title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label><i class="far fa-building mr-1"></i> Company</label>
                                <input type="text" name="company" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-map-marker-alt mr-1"></i> Location</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-money-bill-wave mr-1"></i> Salary Range</label>
                                <input type="text" name="salary_range" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-phone mr-1"></i> Contact Details</label>
                                <input type="text" name="contact_details" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label><i class="fas fa-file-alt mr-1"></i> Qualifications</label>
                                <textarea name="qualifications" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-align-left mr-1"></i> Description</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>

                            

                            <div class="form-group">
                                <label><i class="far fa-image mr-1"></i> Attach Company Logo / Image (Optional)</label>
                                <input type="file" name="image_filename" class="form-control-file" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="target_schools">Target Schools / Courses (notify these alumni):</label>
                            <select id="target_schools" name="target_schools[]" multiple class="form-control">
                                
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
                                    <option value="BS in Accounting Technology / AIS">BS in Accounting Technology / AIS</option>
                                    <option value="BS in Psychology">BS in Psychology</option>
                                    <option value="BS in Elementary Education">BS in Elementary Education</option>
                                    <option value="BS in Secondary Education">BS in Secondary Education</option>
                                </optgroup>

                                <optgroup label="School of International, Hospitality, Tourism & Management">
                                    <option value="BS in Business Administration - Financial Management">BS in Business Administration - Financial Management</option>
                                    <option value="BS in Business Administration - Marketing Management">BS in Business Administration - Marketing Management</option>
                                    <option value="BS in Business Administration - HR Development">BS in Business Administration - HR Development</option>
                                    <option value="BS in Business Administration - Operations Management">BS in Business Administration - Operations Management</option>
                                    <option value="BS in Tourism Management">BS in Tourism Management</option>
                                    <option value="BS in Hospitality Management">BS in Hospitality Management</option>
                                    <option value="BS in Hospitality Management - Culinary Arts">BS in Hospitality Management - Culinary Arts</option>
                                    <option value="BS in Hospitality Management - Cruiseline Operations">BS in Hospitality Management - Cruiseline Operations</option>
                                </optgroup>

                                <optgroup label="School of Communication, Multimedia, and Computer Studies">
                                    <option value="BA in Communication">BA in Communication</option>
                                    <option value="Bachelor of Multimedia Arts">Bachelor of Multimedia Arts</option>
                                    <option value="BS in Information Technology">BS in Information Technology</option>
                                </optgroup>
                            </select>
                            <small class="form-text text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple. If left empty, notification will go to all alumni (or admins based on current implementation).</small>
                            </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-create-job"><i class="fas fa-upload mr-1"></i> Post Job</button>
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
    // Live Search Functionality
    $("#jobSearchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".job-card-item").filter(function() {
            // Search across the entire visible text of the card
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
        
        // Show "No jobs" alert if no cards are visible after filter
        var visibleCards = $('.job-card-item:visible').length;
        if (visibleCards === 0 && value.length > 0) {
            if ($('#noResultsAlert').length === 0) {
                $('#jobListContainer').append('<div class="col-12" id="noResultsAlert"><div class="alert alert-warning text-center py-3" style="border-radius: 10px;"><i class="fas fa-exclamation-circle mr-1"></i> No results found for "'+value+'".</div></div>');
            } else {
                $('#noResultsAlert').find('div').html('<i class="fas fa-exclamation-circle mr-1"></i> No results found for "'+value+'".');
            }
        } else {
             $('#noResultsAlert').remove();
        }
    });
});
</script>

<!-- Add this just before </body> (after bootstrap/js) -->
<style>
/* Highest-priority overrides for modal width */
#createJobModal .modal-dialog,
.modal-dialog.modal-extra-wide,
.modal-dialog.modal-lg,
div[id^="editModal"] .modal-dialog,
div[id^="applicantModal"] .modal-dialog {
  max-width: 95% !important;
  width: 95% !important;
  margin: 10px auto !important;
}

/* ensure modal content is scrollable vertically if it's tall */
#createJobModal .modal-content,
div[id^="editModal"] .modal-content,
div[id^="applicantModal"] .modal-content {
  max-height: calc(100vh - 60px) !important;
}

#createJobModal .modal-body,
div[id^="editModal"] .modal-body,
div[id^="applicantModal"] .modal-body {
  overflow-y: auto !important;
  max-height: calc(100vh - 180px) !important;
}
</style>

<script>
/* On show, force inline style as a fallback (useful if some other CSS injects later) */
(function($){
  $(document).on('show.bs.modal', function(e){
    var dlg = $(e.target).find('.modal-dialog');
    if (dlg.length) {
      dlg.css({
        'max-width': '95%',
        'width': '95%',
        'margin': '10px auto'
      });
      // ensure modal-body scroll if content too tall
      $(e.target).find('.modal-body').css({
        'overflow-y': 'auto',
        'max-height': 'calc(100vh - 180px)'
      });
    }
  });

  // Also apply immediately for any already-open modals (debug)
  $(function(){
    $('#createJobModal').find('.modal-dialog').css({'max-width':'95%','width':'95%','margin':'10px auto'});
  });
})(jQuery);
</script>

</body>
</html>