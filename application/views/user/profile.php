<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Profile - <?= isset($alumni->first_name) ? ucwords(strtolower($alumni->first_name)) : 'Profile' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --maroon: #8B1538;
            --maroon-dark: #6B0F2A;
            --gold: #D4A574;
            --bg: #FAFAF8;
            --card: #ffffff;
            --text: #1F2937;
            --muted: #6B7280;
            --border: #E5E7EB;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--bg); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: var(--text); line-height: 1.6; padding-top: 70px; }
        .container-fluid { max-width: 900px; margin: 0 auto; padding: 0 20px 40px; }

        /* Profile Header with Cover */
        .profile-header {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            height: 180px;
            border-radius: 16px 16px 0 0;
            position: relative;
            margin-bottom: 0;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path d="M0,50 Q300,0 600,50 T1200,50 L1200,120 L0,120 Z" fill="rgba(255,255,255,0.05)"/></svg>');
            background-repeat: repeat-x;
            opacity: 0.5;
        }

        .profile-info {
            background: var(--card);
            padding: 40px 24px 24px;
            border-radius: 0 0 16px 16px;
            box-shadow: var(--shadow-md);
            position: relative;
            margin-bottom: 24px;
        }

        .profile-image-wrapper {
            position: absolute;
            top: -60px;
            left: 24px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 6px solid var(--card);
            box-shadow: 0 0 0 4px var(--maroon), var(--shadow-lg);
            overflow: hidden;
            background: var(--bg);
        }

        .profile-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }

        .profile-name-section {
            flex: 1;
            padding-left: 160px;
        }

        .profile-name { font-size: 28px; font-weight: 700; color: var(--text); margin: 0 0 4px; }
        .profile-degree { font-size: 16px; color: var(--muted); margin: 0 0 8px; font-weight: 500; }
        .profile-meta { font-size: 13px; color: var(--muted); display: flex; gap: 20px; margin-top: 12px; flex-wrap: wrap; }

        .btn-edit-primary {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-edit-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label { font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .info-value { font-size: 15px; color: var(--text); font-weight: 600; }

        /* Section Cards */
        .section-card {
            background: var(--card);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s;
        }

        .section-card:hover { box-shadow: var(--shadow-md); }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--gold);
        }

        .section-title { font-size: 18px; font-weight: 700; color: var(--text); margin: 0; display: flex; align-items: center; gap: 8px; }
        .section-title i { color: var(--maroon); }

        .btn-edit-section {
            background: white;
            border: 2px solid var(--maroon);
            color: var(--maroon);
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-edit-section:hover {
            background: var(--maroon);
            color: white;
        }

        /* Employment Card */
        .employment-container {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .employment-icon {
            font-size: 32px;
            color: var(--maroon);
            flex-shrink: 0;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(139, 21, 56, 0.1);
            border-radius: 10px;
        }

        .employment-info {
            flex: 1;
        }

        .job-title { font-size: 16px; font-weight: 700; color: var(--text); margin: 0 0 4px; }
        .job-company { font-size: 14px; color: var(--muted); margin: 0 0 8px; }
        .job-meta { font-size: 13px; color: var(--muted); display: flex; gap: 16px; flex-wrap: wrap; }
        .job-meta i { color: var(--gold); margin-right: 4px; }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 8px;
        }

        .badge-status.employed { background: #D1FAE5; color: #065F46; }
        .badge-status.self-employed { background: #DBEAFE; color: #0C4A6E; }
        .badge-status.unemployed { background: #FEE2E2; color: #7F1D1D; }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--muted);
        }

        .empty-state i { font-size: 48px; color: var(--border); margin-bottom: 16px; display: block; }
        .empty-state p { margin: 8px 0; font-size: 14px; }

        /* Skills Section */
        .skills-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .skills-group h6 { font-size: 14px; font-weight: 700; color: var(--text); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
        .skills-group i { color: var(--maroon); }

        .skill-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, rgba(139, 21, 56, 0.1), rgba(212, 165, 116, 0.1));
            border: 1px solid var(--border);
            color: var(--text);
            padding: 8px 14px;
            border-radius: 20px;
            margin-right: 8px;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .skill-tag:hover {
            border-color: var(--maroon);
            background: linear-gradient(135deg, rgba(139, 21, 56, 0.2), rgba(212, 165, 116, 0.1));
        }

        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            border: none;
            border-radius: 12px 12px 0 0;
            padding: 24px;
        }

        .modal-header .modal-title { font-weight: 700; font-size: 18px; }
        .modal-header .btn-close { filter: invert(1); }
        .modal-header button.close { color: white; opacity: 0.8; }

        .modal-body {
            padding: 24px;
        }

        .form-group label {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--maroon);
            box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
            outline: none;
        }

        .form-row { margin-left: -12px; margin-right: -12px; }
        .form-row .form-group { padding-left: 12px; padding-right: 12px; }

        .modal-footer {
            border-top: 1px solid var(--border);
            padding: 16px 24px;
            background: #f9f9f9;
            border-radius: 0 0 12px 12px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            border: none;
            padding: 10px 24px;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--maroon-dark), var(--maroon));
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            border: 1px solid var(--border);
            background: white;
            color: var(--text);
            padding: 10px 24px;
            border-radius: 8px;
        }

        .btn-secondary:hover {
            background: var(--bg);
        }

        @media (max-width: 768px) {
            .profile-name { font-size: 22px; }
            .profile-name-section { padding-left: 0; margin-top: 60px; }
            .profile-header-content { flex-direction: column; }
            .info-grid { grid-template-columns: 1fr; }
            .employment-container { flex-direction: column; }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <!-- Profile Header -->
    <div class="profile-header"></div>

    <!-- Profile Info Card -->
    <div class="profile-info">
        <div class="profile-image-wrapper">
            <?php 
                $img_path = (isset($alumni->profile_image) && $alumni->profile_image) 
                    ? base_url('assets/uploads/alumni/' . $alumni->profile_image) 
                    : base_url('assets/images/person-male.png');
            ?>
            <img src="<?= $img_path ?>" alt="Profile">
        </div>

        <div class="profile-header-content">
            <div class="profile-name-section">
                <h1 class="profile-name">
                    <?= isset($alumni->first_name) && isset($alumni->last_name) ? ucwords(strtolower($alumni->first_name . ' ' . $alumni->last_name)) : 'N/A' ?>
                </h1>
                <p class="profile-degree">
                    <?= isset($alumni->degree) ? $alumni->degree : 'Degree Not Set' ?>
                </p>
                <p class="profile-meta">
                    <span><i class="fas fa-graduation-cap"></i> Graduated <?= isset($alumni->graduation_year) ? $alumni->graduation_year : 'N/A' ?></span>
                    <span><i class="fas fa-id-badge"></i> ID: <?= isset($alumni->student_number) ? $alumni->student_number : 'N/A' ?></span>
                </p>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-envelope"></i> Email</span>
                        <span class="info-value"><?= isset($alumni->email) ? $alumni->email : 'Not Set' ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-envelope-open"></i> Alternate Email</span>
                        <span class="info-value"><?= isset($alumni->alternative_email) ? $alumni->alternative_email : 'Not Set' ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-phone"></i> Phone</span>
                        <span class="info-value"><?= isset($alumni->phone) ? $alumni->phone : 'Not Set' ?></span>
                    </div>

                </div>
            </div>

            <button class="btn-edit-primary" data-toggle="modal" data-target="#editProfileModal">
                <i class="fas fa-edit"></i> Edit Profile
            </button>
        </div>
    </div>
    
    <!-- Employment Section -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title"><i class="fas fa-briefcase"></i> Employment & Career</h3>
            <button class="btn-edit-section" data-toggle="modal" data-target="#employmentModal">
                <i class="fas fa-edit"></i> Edit
            </button>
        </div>

        <?php if (!empty($employment)): ?>
        <div class="employment-container">
            <div class="employment-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="employment-info">
                <h4 class="job-title"><?= htmlspecialchars($employment['job_title'] ?: '(Not Set)') ?></h4>
                <p class="job-company"><?= htmlspecialchars($employment['company_name'] ?: '(Not Set)') ?></p>
                <p class="job-meta">
                    <span><i class="fas fa-clock"></i> <?= (int)$employment['year_of_service'] ?> year(s)</span>
                    <span><i class="fas fa-arrow-up"></i> <?= (int)$employment['promotion_count'] ?> promotion(s)</span>
                </p>
                <div class="badge-status <?= strtolower(str_replace('-', '', $employment['employment_status'])) ?>">
                    <i class="fas fa-circle"></i> <?= htmlspecialchars($employment['employment_status']) ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-briefcase"></i>
            <p style="font-weight: 600; color: var(--text);">No Employment Info Yet</p>
            <p>Add your current job and career information</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Skills Section -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title"><i class="fas fa-star"></i> Skills</h3>
            <button class="btn-edit-section" data-toggle="modal" data-target="#editSkillModal">
                <i class="fas fa-edit"></i> Edit
            </button>
        </div>

        <div class="skills-container">
            <div class="skills-group">
                <h6><i class="fas fa-heart"></i> Soft Skills</h6>
                <?php $soft_skills = !empty($alumni->soft_skills) ? array_filter(explode(',', $alumni->soft_skills)) : []; ?>
                <?php if (!empty($soft_skills)): ?>
                    <div>
                        <?php foreach ($soft_skills as $skill): ?>
                            <span class="skill-tag">
                                <i class="fas fa-check-circle"></i> <?= trim($skill) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="color: var(--muted); font-size: 13px;">No soft skills added yet</p>
                <?php endif; ?>
            </div>

            <div class="skills-group">
                <h6><i class="fas fa-gear"></i> Technical Skills</h6>
                <?php $tech_skills = !empty($alumni->technical_skills) ? array_filter(explode(',', $alumni->technical_skills)) : []; ?>
                <?php if (!empty($tech_skills)): ?>
                    <div>
                        <?php foreach ($tech_skills as $skill): ?>
                            <span class="skill-tag">
                                <i class="fas fa-code"></i> <?= trim($skill) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="color: var(--muted); font-size: 13px;">No technical skills added yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- MODALS -->

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel"><i class="fas fa-user-circle"></i> Edit Profile Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php if ($this->session->flashdata('edit_error')): ?>
                    <div class="alert alert-danger m-3"><?= $this->session->flashdata('edit_error'); ?></div>
                <?php elseif ($this->session->flashdata('edit_success')): ?>
                    <div class="alert alert-success m-3"><?= $this->session->flashdata('edit_success'); ?></div>
                <?php endif; ?>

                <form action="<?= base_url('profile/update/' . $alumni->id) ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" value="<?= $alumni->first_name ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="<?= $alumni->last_name ?>" required>
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label>Student Number</label>
                                <input type="text" name="student_number" class="form-control" value="<?= isset($alumni->student_number) ? $alumni->student_number : '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Degree</label>
                                <input type="text" name="degree" class="form-control" value="<?= $alumni->degree ?>">
                            </div>
                        </div>

                        <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Year Admitted</label>
                                    <input type="number" name="year_admitted" class="form-control" value="<?= $alumni->year_admitted ?>" min="1990" max="2100">
                                </div>
                            <div class="form-group col-md-6">
                                <label>Graduation Year</label>
                                <input type="number" name="graduation_year" class="form-control" value="<?= $alumni->graduation_year ?>" min="1990" max="2100">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Phone Number</label>
                                <input type="tel" name="phone" class="form-control" value="<?= $alumni->phone ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Alternate Phone Number</label>
                                <input type="tel" name="alternative_phone" class="form-control" value="<?= $alumni->alternative_phone ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?= $alumni->email ?>" required>
                            </div>
                                <div class="form-group col-md-4">
                                <label>Alternate Email</label>
                                <input type="email" name="alternative_email" class="form-control" 
                                    value="<?= isset($alumni->alternative_email) ? $alumni->alternative_email : '' ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Profile Image</label>
                            <div style="position: relative;">
                                <input type="file" name="profile_image" class="form-control" accept="image/*">
                                <small class="text-muted d-block mt-2">Recommended: Square image, 200x200px or larger</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Employment Modal -->
    <div class="modal fade" id="employmentModal" tabindex="-1" role="dialog" aria-labelledby="employmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employmentModalLabel"><i class="fas fa-briefcase"></i> Employment Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="<?= base_url('EmploymentController/submit') ?>">
                    <div class="modal-body">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>

                        <?php $e = isset($employment) ? $employment : []; ?>

                        <div class="form-group">
                            <label>Employment Status</label>
                            <select name="employment_status" class="form-control" required>
                                <option value="">-- Select Status --</option>
                                <option value="Employed" <?= (isset($e['employment_status']) && $e['employment_status']=='Employed')? 'selected':'' ?>>Employed</option>
                                <option value="Unemployed" <?= (isset($e['employment_status']) && $e['employment_status']=='Unemployed')? 'selected':'' ?>>Unemployed</option>
                                <option value="Self-employed" <?= (isset($e['employment_status']) && $e['employment_status']=='Self-employed')? 'selected':'' ?>>Self-employed</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Job Title</label>
                                <input type="text" name="job_title" class="form-control" value="<?= isset($e['job_title']) ? htmlspecialchars($e['job_title']) : '' ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Company Name</label>
                                <input type="text" name="company_name" class="form-control" value="<?= isset($e['company_name']) ? htmlspecialchars($e['company_name']) : '' ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Job Description</label>
                            <textarea name="job_description" class="form-control" rows="4" required><?= isset($e['job_description']) ? htmlspecialchars($e['job_description']) : '' ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Years of Service</label>
                                <input type="number" min="0" name="year_of_service" class="form-control" value="<?= isset($e['year_of_service']) ? (int)$e['year_of_service'] : 0 ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Promotion Count</label>
                                <input type="number" min="0" name="promotion_count" class="form-control" value="<?= isset($e['promotion_count']) ? (int)$e['promotion_count'] : 0 ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Skills Modal -->
    <div class="modal fade" id="editSkillModal" tabindex="-1" role="dialog" aria-labelledby="editSkillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSkillModalLabel"><i class="fas fa-star"></i> Edit Skills</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?= base_url('profile/update_skill_info/' . $alumni->id) ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label><i class="fas fa-heart"></i> Soft Skills</label>
                            <select class="form-control soft-skills-select" name="soft_skills[]" multiple>
                                <?php 
                                    $soft_selected = explode(",", $alumni->soft_skills ?? "");
                                    $soft_list = ["Communication","Teamwork","Leadership","Problem Solving","Adaptability","Creativity","Time Management","Critical Thinking","Work Ethics","Decision Making","Collaboration","Attention to Detail"];
                                    foreach ($soft_list as $skill): 
                                ?>
                                    <option value="<?= $skill ?>" <?= in_array($skill, $soft_selected) ? 'selected' : '' ?>>
                                        <?= $skill ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-code"></i> Technical Skills</label>
                            <select class="form-control tech-skills-select" name="technical_skills[]" multiple>
                                <?php 
                                    $tech_selected = explode(",", $alumni->technical_skills ?? "");
                                    $skills_by_category = [
                                        "Information Technology & Programming" => ["HTML","CSS","JavaScript","React","Angular","Vue.js","Node.js","PHP","Laravel","CodeIgniter","Python","Java","C#","C++","SQL","MySQL","PostgreSQL","MongoDB","REST API","Git","Docker","Linux","Cloud Computing","AWS","Azure","Google Cloud Platform"],
                                        "Medical & Laboratory Skills" => ["Phlebotomy","Clinical Laboratory Testing","Hematology","Microbiology","Laboratory Safety","Specimen Processing","Radiographic Imaging","Patient Care","Medication Administration","ECG Interpretation","Medical Terminology"],
                                        "Hospitality & Tourism" => ["Event Planning","Food & Beverage Management","Culinary Arts","Customer Service","Front Office Operations","Tour Guiding","Housekeeping Management"],
                                        "Business & Accounting" => ["Financial Analysis","Bookkeeping","Payroll Processing","Tax Preparation","Auditing","MS Excel","Business Analytics","Marketing Strategy","HR Management"],
                                        "Multimedia & Communication" => ["Graphic Design","Adobe Photoshop","Adobe Illustrator","Video Editing","Animation","UI/UX Design","Social Media Management","Content Writing","Photography"]
                                    ];
                                    foreach ($skills_by_category as $category => $skills):
                                ?>
                                    <optgroup label="<?= $category ?>">
                                        <?php foreach ($skills as $skill): ?>
                                            <option value="<?= $skill ?>" <?= in_array($skill, $tech_selected) ? 'selected' : '' ?>>
                                                <?= $skill ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.soft-skills-select').select2({
        placeholder: "Select soft skills",
        width: '100%',
        tags: true,
        tokenSeparators: [',']
    });

    $('.tech-skills-select').select2({
        placeholder: "Select technical skills",
        width: '100%',
        tags: true,
        tokenSeparators: [',']
    });

    <?php if ($this->session->flashdata('show_employment_modal')): ?>
        $('#employmentModal').modal('show');
    <?php endif; ?>
});
</script>

</body>
</html>