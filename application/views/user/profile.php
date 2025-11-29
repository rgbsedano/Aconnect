<style>
    /* 🎨 MODERN SOCIAL PROFILE STYLES */
    :root {
        --primary-maroon: #700A0A; /* Deep Red/Maroon for headers/buttons */
        --accent-color: #fca311; /* A gold/yellow accent */
        --background-light: #f0f2f5; /* Light background for the overall page */
        --card-bg: #ffffff;
        --text-dark: #1c1e21;
        --text-muted: #606770;
        --border-color: #dddfe2;
        --border-radius-lg: 12px;
        --border-radius-sm: 8px;
    }

    body {
        background-color: var(--background-light);
    }

    .container-fluid {
        padding: 0 15px;
        max-width: 900px; /* Constrain profile width for focus */
        margin: 0 auto;
    }
    
    /* Profile Header Area - Container for Image and Basic Info */
    .profile-header-card {
        background-color: var(--card-bg);
        border-radius: var(--border-radius-lg);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 30px;
        margin-bottom: 25px;
        text-align: center; /* Center content within header */
        position: relative;
    }

    /* Profile Image Styling */
    .profile-image-container {
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
        border: 4px solid var(--card-bg); /* White border around image */
        border-radius: 50%;
        box-shadow: 0 0 0 1px var(--border-color); /* Subtle outer ring */
    }

    .profile-image {
        width: 150px; /* Smaller, more modern profile image size */
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        display: block;
    }
    
    /* Main Name and Degree Info */
    .profile-name {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 2px;
    }

    .profile-degree {
        font-size: 1.1rem;
        color: var(--primary-maroon);
        margin-bottom: 15px;
        font-weight: 500;
    }

    /* Info Grid for Secondary Details (ID, Phone, Email) */
    .info-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px 20px;
        margin-top: 15px;
    }

    .info-item {
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    .info-item strong {
        color: var(--text-dark);
        font-weight: 600;
        margin-right: 5px;
    }

    /* Section Cards (Job, Skills) */
    .section-card {
        background-color: var(--card-bg);
        border-radius: var(--border-radius-lg);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        padding: 0;
    }

    .card-header-custom {
        background-color: var(--primary-maroon);
        padding: 15px 25px;
        border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header-custom h6 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
    }

    .card-body-custom {
        padding: 25px;
    }

    /* Edit/Add Button Styling */
    .btn-edit-modern {
        background-color: transparent !important;
        border: 1px solid var(--primary-maroon) !important;
        color: var(--primary-maroon) !important;
        border-radius: 50px;
        padding: 6px 15px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-edit-modern:hover {
        background-color: var(--primary-maroon) !important;
        color: white !important;
    }
    
    /* Current Job/Skills Content Styling */
    .job-details-container {
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 15px;
    }
    
    .job-details-container:last-child {
        border-bottom: none;
    }

    .job-icon {
        color: var(--primary-maroon);
        margin-right: 15px;
        font-size: 1.3rem;
    }

    .skill-tag {
        display: inline-block;
        background-color: #e3f2fd; /* Light blue tag background */
        color: #1a73e8; /* Blue text */
        padding: 5px 10px;
        border-radius: 5px;
        margin-right: 8px;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    /* Overwrite old modal styles if necessary, but keep the PHP code logic */
    .modal.fade .modal-dialog {
        transition: transform .3s ease-out;
        transform: translate(0, -50px);
    }
    .modal.show .modal-dialog {
        transform: translate(0, 0);
    }
</style>

<div class="container-fluid">
    <div class="profile-header-card">
        <div class="profile-image-container">
            <?php if ($alumni && isset($alumni->profile_image)): ?>
                <img class="profile-image" src="<?= base_url('assets/uploads/alumni/' . $alumni->profile_image) ?>" alt="Profile Image">
            <?php else: ?>
                <img class="profile-image" src="<?php echo base_url('assets/images/person-male.png'); ?>" alt="My Photo">
            <?php endif; ?>
        </div>

        <h2 class="profile-name">
            <?= isset($alumni->first_name) && isset($alumni->last_name) ? ucwords(strtolower($alumni->first_name . ' ' . $alumni->last_name)) : 'N/A' ?>
        </h2>
        <p class="profile-degree">
            <?= isset($alumni->degree) ? $alumni->degree : 'N/A' ?> (Graduated: <?= isset($alumni->graduation_year) ? $alumni->graduation_year : 'N/A' ?>)
        </p>

        <div class="info-grid">
            <span class="info-item"><strong>Alumni ID:</strong> <?= isset($alumni->alumni_number) ? $alumni->alumni_number : 'N/A' ?></span>
            <span class="info-item"><strong>Student No.:</strong> <?= isset($alumni->student_number) ? $alumni->student_number : 'N/A' ?></span>
            <span class="info-item"><strong>Email:</strong> <?= isset($alumni->email) ? $alumni->email : 'N/A' ?></span>
            <span class="info-item"><strong>Phone:</strong> <?= isset($alumni->phone) ? $alumni->phone : 'N/A' ?></span>
        </div>

        <div style="margin-top: 20px;">
            <a href="#" class="btn btn-edit-modern" data-toggle="modal" data-target="#editProfileModal">
                <i class="fas fa-edit mr-1"></i>Edit Profile
            </a>
        </div>
    </div>
    
    <div class="section-card">
        <div class="card-header-custom">
            <h6>Current Job</h6>
            <a href="#" class="btn btn-edit-modern" data-toggle="modal" data-target="#editJobModal"><i class="fas fa-edit mr-1"></i>Edit</a>
        </div>
        <div class="card-body-custom">
            <div class="d-flex align-items-start">
                <i class="fas fa-briefcase job-icon"></i>
                <div>
                    <h6 class="mb-0 font-weight-bold text-gray-800">
                        <?= !empty($alumni->current_job) ? $alumni->current_job : 'Job Title/Position: (Not Set)' ?>
                    </h6>
                    <p class="text-muted mb-0">
                        <?= !empty($alumni->current_job_organization) ? $alumni->current_job_organization : 'Organization: (Not Set)' ?>
                    </p>
                    <small class="text-muted">
                        <?= !empty($alumni->current_job_length) ? $alumni->current_job_length : 'Example: 2019 - present' ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="card-header-custom">
            <h6>Skills</h6>
            <a href="#" class="btn btn-edit-modern" data-toggle="modal" data-target="#editSkillModal">
                <i class="fas fa-plus mr-1"></i>Add Skills
            </a>
        </div>
        <div class="card-body-custom">
            <p class="mb-1 font-weight-bold text-gray-800">Soft skills:</p>
            <div class="mb-3">
                <?php $soft_skills = !empty($alumni->soft_skills) ? explode(',', $alumni->soft_skills) : []; ?>
                <?php if (!empty($soft_skills)): ?>
                    <?php foreach ($soft_skills as $skill): ?>
                        <span class="skill-tag"><?= trim($skill) ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No soft skills added yet.</p>
                <?php endif; ?>
            </div>
            
            <p class="mb-1 font-weight-bold text-gray-800">Technical skills:</p>
            <div>
                <?php $tech_skills = !empty($alumni->technical_skills) ? explode(',', $alumni->technical_skills) : []; ?>
                <?php if (!empty($tech_skills)): ?>
                    <?php foreach ($tech_skills as $skill): ?>
                        <span class="skill-tag"><?= trim($skill) ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">N/A</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php if ($this->session->flashdata('edit_error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('edit_error'); ?></div>
                <?php elseif ($this->session->flashdata('edit_success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('edit_success'); ?></div>
                <?php endif; ?>

                <form action="<?= base_url('profile/update/' . $alumni->id) ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Alumni ID</label>
                            <input type="text" name="alumni_number" class="form-control" value="<?= $alumni->alumni_number ?>">
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?= $alumni->first_name ?>">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?= $alumni->last_name ?>">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= $alumni->phone ?>">
                        </div>
                        <div class="form-group">
                            <label>Graduation Year</label>
                            <input type="number" name="graduation_year" class="form-control" value="<?= $alumni->graduation_year ?>">
                        </div>
                        <div class="form-group">
                            <label>Degree</label>
                            <input type="text" name="degree" class="form-control" value="<?= $alumni->degree ?>">
                        </div>
                        <div class="form-group">
                            <label>Profile Image</label>
                            <input type="file" name="profile_image" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" style="background: var(--primary-maroon); border-color: var(--primary-maroon);" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="editJobModal" tabindex="-1" role="dialog" aria-labelledby="editJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJobModalLabel">Edit Job Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form action="<?= base_url('profile/update_job_info/' . $alumni->id) ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Current Job Title/Position</label>
                            <input type="text" class="form-control" name="current_job" value="<?= $alumni->current_job ?>">
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" class="form-control" name="current_job_organization" value="<?= $alumni->current_job_organization ?>">
                        </div>

                        <div class="form-group">
                            <label>Employment Length (e.g., 2019 - Present)</label>
                            <input type="text" class="form-control" name="current_job_length" value="<?= $alumni->current_job_length ?>">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" style="background: var(--primary-maroon); border-color: var(--primary-maroon);" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="editSkillModal" tabindex="-1" role="dialog" aria-labelledby="editSkillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSkillModalLabel">Edit Skills Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form action="<?= base_url('profile/update_skill_info/' . $alumni->id) ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Soft Skills (Comma-separated)</label>
                            <input type="text" class="form-control" name="soft_skills" value="<?= $alumni->soft_skills ?>">
                        </div>

                        <div class="form-group">
                            <label>Technical Skills (Comma-separated)</label>
                            <input type="text" class="form-control" name="technical_skills" value="<?= $alumni->technical_skills ?>">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" style="background: var(--primary-maroon); border-color: var(--primary-maroon);" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<script>
    function openEditModal() {
        // Functions remain empty as we rely on Bootstrap's data- attributes
    }

    function closeEditModal() {
        // Functions remain empty as we rely on Bootstrap's data- attributes
    }

    // Original custom modal open logic preserved
    <?php if ($this->session->flashdata('show_edit_modal')): ?>
    $(document).ready(function () {
        $('#editProfileModal').modal('show');
    });
    <?php endif; ?>
</script>