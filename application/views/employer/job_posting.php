<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Post a Job - Employer Dashboard">
    <title>AConnect | Post a Job</title>

    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    body {
        background-color: #f7f7f7;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
    }

    .container-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .header {
        background-color: #920E0E;
        color: white;
        padding: 20px 0;
        margin-bottom: 30px;
    }

    .header h1 {
        margin: 0;
        font-weight: 700;
        font-size: 2rem;
    }

    .header p {
        margin: 5px 0 0 0;
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .content-area {
        flex: 1;
        padding: 0 20px 30px 20px;
    }

    .job-form-wrapper {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 900px;
        margin: 0 auto;
    }

    .form-section h3 {
        color: #333;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1.25rem;
        border-bottom: 2px solid #920E0E;
        padding-bottom: 10px;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px 12px;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        border-color: #920E0E;
        box-shadow: 0 0 0 0.15rem rgba(146, 14, 14, 0.25);
        outline: none;
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .btn-post-job {
        background-color: #920E0E;
        color: white;
        border: none;
        padding: 12px 40px;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        font-size: 1rem;
    }

    .btn-post-job:hover {
        background-color: #7d181b;
        color: white;
    }

    .btn-logout {
        background-color: #a12124;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.2s ease;
    }

    .btn-logout:hover {
        background-color: #7d181b;
        color: white;
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .jobs-list {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top: 30px;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }

    .job-item {
        border-left: 4px solid #920E0E;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
        border-radius: 5px;
    }

    .job-item h4 {
        color: #333;
        margin: 0 0 5px 0;
    }

    .job-item p {
        color: #666;
        margin: 3px 0;
        font-size: 0.9rem;
    }

    .job-actions {
        margin-top: 10px;
        display: flex;
        gap: 10px;
    }

    .btn-edit, .btn-delete {
        padding: 5px 15px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .btn-edit {
        background-color: #0052CC;
        color: white;
    }

    .btn-edit:hover {
        background-color: #003399;
        color: white;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c82333;
        color: white;
    }

    .validation-error {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .success-message {
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    </style>
</head>
<body>
    <div class="container-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="container">
                <div class="header-top">
                    <div>
                        <h1>Post a Job</h1>
                        <p>Reach qualified job seekers from our network</p>
                    </div>
                    <div>
                        <a href="<?= base_url('employer_login/logout'); ?>" class="btn-logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-area">
            <div class="container">
                <!-- Success/Error Messages -->
                <?php if ($this->session->flashdata('success_message')): ?>
                <div class="success-message">
                    <?= $this->session->flashdata('success_message') ?>
                </div>
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '<?= $this->session->flashdata('success_message') ?>',
                        confirmButtonText: 'OK'
                    });
                  });
                </script>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error_message')): ?>
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '<?= $this->session->flashdata('error_message') ?>',
                        confirmButtonText: 'OK'
                    });
                  });
                </script>
                <?php endif; ?>

                <!-- Validation Errors -->
                <?php if (validation_errors()): ?>
                <div class="validation-error">
                    <?= validation_errors('<p class="mb-0">', '</p>'); ?>
                </div>
                <?php endif; ?>

                <!-- Job Posting Form -->
                <div class="job-form-wrapper">
                    <form method="post" action="<?= base_url('employer_job_posting/create'); ?>">
                        
                        <div class="form-section">
                            <h3><i class="fas fa-briefcase"></i> Job Details</h3>

                            <div class="form-group">
                                <label for="job_title">Job Title *</label>
                                <input type="text" id="job_title" name="job_title" class="form-control" placeholder="e.g., Senior PHP Developer" value="<?= set_value('job_title') ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="job_description">Job Description *</label>
                                <textarea id="job_description" name="job_description" class="form-control" placeholder="Describe the job, responsibilities, and requirements..." required><?= set_value('job_description') ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_category">Category *</label>
                                        <select id="job_category" name="job_category" class="form-control" required>
                                            <option value="">Select Category</option>
                                            <option value="IT" <?= set_value('job_category') === 'IT' ? 'selected' : '' ?>>IT/Technology</option>
                                            <option value="Healthcare" <?= set_value('job_category') === 'Healthcare' ? 'selected' : '' ?>>Healthcare</option>
                                            <option value="Finance" <?= set_value('job_category') === 'Finance' ? 'selected' : '' ?>>Finance</option>
                                            <option value="Sales" <?= set_value('job_category') === 'Sales' ? 'selected' : '' ?>>Sales</option>
                                            <option value="Other" <?= set_value('job_category') === 'Other' ? 'selected' : '' ?>>Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary_range">Salary Range *</label>
                                        <input type="text" id="salary_range" name="salary_range" class="form-control" placeholder="e.g., $50,000 - $80,000" value="<?= set_value('salary_range') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="location">Location *</label>
                                <input type="text" id="location" name="location" class="form-control" placeholder="e.g., Manila, Philippines" value="<?= set_value('location') ?>" required>
                            </div>
                        </div>

                        <div style="margin-top: 30px;">
                            <button type="submit" class="btn-post-job">
                                <i class="fas fa-paper-plane"></i> Post Job
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Posted Jobs List -->
                <?php if (!empty($jobs)): ?>
                <div class="jobs-list">
                    <h3><i class="fas fa-list"></i> Your Posted Jobs</h3>
                    <?php foreach ($jobs as $job): ?>
                    <div class="job-item">
                        <h4><?= $job->job_title ?></h4>
                        <p><strong>Category:</strong> <?= $job->job_category ?></p>
                        <p><strong>Salary:</strong> <?= $job->salary_range ?></p>
                        <p><strong>Location:</strong> <?= $job->location ?></p>
                        <p><strong>Posted:</strong> <?= date('M d, Y', strtotime($job->created_at)) ?></p>
                        <div class="job-actions">
                            <a href="<?= base_url('employer_job_posting/edit/' . $job->id); ?>" class="btn-edit">Edit</a>
                            <a href="<?= base_url('employer_job_posting/delete/' . $job->id); ?>" class="btn-delete" onclick="return confirm('Are you sure?');">Delete</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div style="text-align: center; padding: 40px; background: white; border-radius: 10px; margin-top: 30px; max-width: 900px; margin-left: auto; margin-right: auto;">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 20px; display: block;"></i>
                    <p style="color: #999; font-size: 1.1rem;">You haven't posted any jobs yet. Create your first job posting above!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JS: jQuery + Bootstrap Bundle -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>
