<!--
    Alumni Profile Page (LinkedIn Style) - Optimized for non-scrolling, fixed layout.
    Maintains PHP variable usage ($alumni, base_url) and Bootstrap modals.
    Dependencies: Bootstrap 4.6 (CSS/JS) and Font Awesome 5 (Icons).
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Profile - <?= isset($alumni->first_name) ? ucwords(strtolower($alumni->first_name)) : 'Profile' ?></title>
    
    <!-- Load Bootstrap 4.6 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <!-- Load Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* 🎨 COMPACT LINKEDIN-INSPIRED STYLES */
        :root {
            --primary-maroon: #700A0A; /* Deep Red/Maroon for headers/buttons */
            --background-light: #f3f2ef; /* LinkedIn-like subtle grey background */
            --card-bg: #ffffff;
            --text-dark: #000000E6;
            --text-muted: #666666;
            --border-color: #e6e6e6;
            --border-radius-lg: 12px;
        }

        body {
            background-color: var(--background-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* EDITED: Changed fixed 30px padding top to 3vh (viewport height), equivalent to approx 3% space from the top. */
            padding: 3vh 0 10px 0; 
            height: 100vh; /* Attempt to fill viewport height */
            overflow-y: auto; /* Allow scrolling only if content exceeds viewport */
        }

        .container-fluid {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        /* 1. Profile Header Card (Cover Photo Area) */
        .profile-header-card {
            /* Cover Photo Area */
            background-image: linear-gradient(to right, #700A0A, #A62F2F); 
            height: 120px; /* Reduced height for compactness */
            border-top-left-radius: var(--border-radius-lg);
            border-top-right-radius: var(--border-radius-lg);
            position: relative;
            margin-bottom: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        /* 2. Profile Info Section (holds image, name, and details) */
        .profile-info-section {
            background-color: var(--card-bg);
            border-bottom-left-radius: var(--border-radius-lg);
            border-bottom-right-radius: var(--border-radius-lg);
            box-shadow: 0 0 0 1px rgba(0,0,0,.15), 0 2px 3px rgba(0,0,0,.2);
            padding: 24px;
            margin-bottom: 20px;
            margin-top: 0;
            position: relative; /* Context for absolute positioning of image container */
        }

        /* Profile Image Positioning - Fixed relative to the cover and info section */
        .profile-image-container {
            position: absolute;
            /* ADJUSTMENT: Moved the image down 20px for better alignment with name */
            top: 10px; 
            left: 30px;
            display: inline-block;
            border-radius: 50%;
            z-index: 10;
        }

        .profile-image {
            width: 130px; /* Adjusted size for better fit */
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            
            /* BORDER: Inner white border and maroon outer shadow */
            border: 3px solid #ffffff; 
            box-shadow: 0 0 0 3px var(--primary-maroon); 
        }
        
        /* Name and Degree Area */
        .name-and-degree-area {
            /* ADJUSTMENT: Increased margin-top on mobile view to push text below image */
            margin-top: 75px; 
            padding-left: 0;
            text-align: left;
        }

        /* Info Grid Styling */
        .info-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 30px;
            margin-top: 15px;
            padding: 10px 0;
            border-top: 1px solid var(--border-color);
        }

        .info-item {
            font-size: 0.95rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }

        .info-item strong {
            color: var(--text-dark);
            font-weight: 600;
            margin-right: 5px;
        }
        
        .info-item i {
            margin-right: 8px;
            color: var(--primary-maroon);
        }

        /* Section Cards */
        .section-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius-lg);
            box-shadow: 0 0 0 1px rgba(0,0,0,.15), 0 2px 3px rgba(0,0,0,.2);
            margin-bottom: 20px;
            padding: 24px;
        }

        .card-header-custom {
            padding: 0;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header-custom h6 {
            font-size: 1.25rem; /* Slightly smaller header for compactness */
            font-weight: 600;
        }

        /* Edit/Add Button Styling */
        .btn-edit-modern {
            border: 1px solid var(--primary-maroon) !important;
            color: var(--primary-maroon) !important;
            border-radius: 50px;
            padding: 5px 15px; /* Smaller button */
            font-size: 0.85rem;
        }
        
        .btn-link-icon {
            color: var(--primary-maroon);
            font-size: 1.25rem; /* Smaller icon */
        }
        
        .job-icon {
            font-size: 1.5rem;
            margin-top: 3px;
        }
        
        .job-details-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .skill-tag {
            display: inline-block;
            background-color: #E6E6FA; /* Light lavender/purple for tags */
            color: #333;
            padding: 4px 12px;
            border-radius: 20px;
            margin-right: 8px;
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Responsive Adjustments for Desktop (sm breakpoint and up) */
        @media (min-width: 576px) {
            .name-and-degree-area {
                 /* Push text next to the image */
                padding-left: 160px; 
                /* EDITED: Adjusted margin-top from 20px to 8px to align the center of the H2 name element with the center of the profile picture (which is at y=20px). */
                margin-top: 8px; 
            }
        }
        @media (max-width: 575px) {
            .profile-header-card { height: 90px; }
            .profile-image-container { top: -50px; left: 15px; }
            .profile-image { width: 100px; height: 100px; }
            /* ADJUSTMENT: Added padding to make space for the lowered image on mobile */
            .profile-info-section { padding-top: 90px; } 
            .info-grid { flex-direction: column; }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    
    <!-- 1. HEADER CARD (Cover Photo Area) -->
    <div class="profile-header-card">
    </div>
    
    <!-- 2. PROFILE INFO SECTION -->
    <div class="profile-info-section">
        
        <!-- Profile Image Container (Absolutely positioned to overlap the card above) -->
        <div class="profile-image-container">
            <?php 
                // PHP logic to determine image path
                $img_path = (isset($alumni->profile_image) && $alumni->profile_image) 
                    ? base_url('assets/uploads/alumni/' . $alumni->profile_image) 
                    : base_url('assets/images/person-male.png');
            ?>
            <!-- The .profile-image now includes the proper double border style -->
            <img class="profile-image" src="<?= $img_path ?>" alt="Profile Image">
        </div>

        <div class="d-flex justify-content-between align-items-start">
            <div class="name-and-degree-area">
                <h2 class="profile-name">
                    <?= isset($alumni->first_name) && isset($alumni->last_name) ? ucwords(strtolower($alumni->first_name . ' ' . $alumni->last_name)) : 'N/A' ?>
                </h2>
                <p class="profile-degree mb-0">
                    <?= isset($alumni->degree) ? $alumni->degree : 'Degree Not Set' ?>
                </p>
                <p class="text-muted small">
                    Graduated: <?= isset($alumni->graduation_year) ? $alumni->graduation_year : 'N/A' ?>
                </p>
            </div>

            <!-- Main Edit Button (Top Right) -->
            <div class="mt-2">
                 <a href="#" class="btn btn-edit-modern" data-toggle="modal" data-target="#editProfileModal">
                    <i class="fas fa-edit mr-1"></i>Edit Profile
                </a>
            </div>
        </div>

        <!-- Secondary Info (Below Name) -->
        <div class="info-grid">
            <span class="info-item"><i class="fas fa-id-badge"></i><strong>Alumni ID:</strong> <?= isset($alumni->alumni_number) ? $alumni->alumni_number : 'N/A' ?></span>
            <span class="info-item"><i class="fas fa-user-tag"></i><strong>Student No.:</strong> <?= isset($alumni->student_number) ? $alumni->student_number : 'N/A' ?></span>
            <span class="info-item"><i class="fas fa-envelope"></i><strong>Email:</strong> <?= isset($alumni->email) ? $alumni->email : 'N/A' ?></span>
            <span class="info-item"><i class="fas fa-phone"></i><strong>Phone:</strong> <?= isset($alumni->phone) ? $alumni->phone : 'N/A' ?></span>
        </div>
    </div>
    
    <!-- 3. EXPERIENCE CARD (Current Job) -->
    <div class="section-card">
        <div class="card-header-custom">
            <h6>Experience</h6>
            <!-- Icon Edit Button for cleaner look -->
            <a href="#" class="btn-link-icon" data-toggle="modal" data-target="#editJobModal">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        
        <div class="job-details-container">
            <i class="fas fa-briefcase job-icon text-muted"></i>
            <div>
                <p class="job-title mb-1 font-weight-bold">
                    <?= !empty($alumni->current_job) ? $alumni->current_job : 'Job Title/Position: (Not Set)' ?>
                </p>
                <p class="job-org mb-1 text-dark">
                    <?= !empty($alumni->current_job_organization) ? $alumni->current_job_organization : 'Organization: (Not Set)' ?>
                </p>
                <p class="job-length mb-0 text-muted small">
                    <i class="fas fa-clock mr-1"></i><?= !empty($alumni->current_job_length) ? $alumni->current_job_length : 'Example: 2019 - present' ?>
                </p>
            </div>
        </div>
    </div>

    <!-- 4. SKILLS CARD -->
    <div class="section-card">
        <div class="card-header-custom">
            <h6>Skills</h6>
            <!-- Icon Add Button -->
            <a href="#" class="btn-link-icon" data-toggle="modal" data-target="#editSkillModal">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        
        <div>
            <p class="mb-2 font-weight-bold text-dark">Soft Skills:</p>
            <div class="mb-4">
                <?php $soft_skills = !empty($alumni->soft_skills) ? explode(',', $alumni->soft_skills) : []; ?>
                <?php if (!empty($soft_skills)): ?>
                    <?php foreach ($soft_skills as $skill): ?>
                        <span class="skill-tag"><?= trim($skill) ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No soft skills added yet. Click the '+' to add some.</p>
                <?php endif; ?>
            </div>
            
            <p class="mb-2 font-weight-bold text-dark">Technical Skills:</p>
            <div>
                <?php $tech_skills = !empty($alumni->technical_skills) ? explode(',', $alumni->technical_skills) : []; ?>
                <?php if (!empty($tech_skills)): ?>
                    <?php foreach ($tech_skills as $skill): ?>
                        <span class="skill-tag"><?= trim($skill) ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No technical skills added yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- MODALS (Functionality Unchanged) -->

    <!-- Edit Profile Modal -->
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
                        <button type="submit" style="background: var(--primary-maroon); border-color: var(--primary-maroon);" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Job Modal -->
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
                        <button type="submit" style="background: var(--primary-maroon); border-color: var(--primary-maroon);" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Skills Modal -->
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
                        <button type="submit" style="background: var(--primary-maroon); border-color: var(--primary-maroon);" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript Dependencies (Must be at the end of the body) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /*
    The following PHP code is commented out to prevent JavaScript SyntaxError
    in the Canvas environment which does not execute PHP server-side code.
    This block is intended to show a modal after a successful form submission redirect.
    
    <?php if ($this->session->flashdata('show_edit_modal')): ?>
    $(document).ready(function () {
        // Ensure the modal shows if there was a redirect with a flash message
        $('#editProfileModal').modal('show');
    });
    <?php endif; ?>
    */
</script>

</body>
</html>