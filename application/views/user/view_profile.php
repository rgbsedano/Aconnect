<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucwords(strtolower($alumni->first_name . ' ' . $alumni->last_name)) ?> | AConnect Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        :root {
            --maroon: #800020;
            --maroon-light: #A52A2A;
            --gold: #D4A574;
            --bg: #F3F2F0;
            --card: #ffffff;
            --text-main: #191919;
            --text-sub: #666666;
            --border: #EBEBEB;
        }

        body { 
            background-color: var(--bg); 
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", "Fira Sans", Ubuntu, Oxygen, "Oxygen Sans", Cantarell, "Droid Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Lucida Grande", Helvetica, Arial, sans-serif;
            color: var(--text-main);
            padding-top: 20px;
        }

        .profile-container {
            max-width: 1128px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--text-sub);
            text-decoration: none !important;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            transition: color 0.2s;
        }

        .back-link:hover { color: var(--maroon); }
        .back-link i { margin-right: 8px; }

        /* Cover and Header */
        .profile-card {
            background: var(--card);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
            margin-bottom: 12px;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.08);
        }

        .cover-photo {
            height: 200px;
            background: var(--maroon);
            background: linear-gradient(135deg, var(--maroon), var(--maroon-light));
            position: relative;
        }

        .cover-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-header-main {
            padding: 0 24px 24px;
            position: relative;
        }

        .profile-avatar-container {
            position: absolute;
            top: -110px;
            left: 24px;
        }

        .profile-avatar {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 4px solid var(--card);
            background: white;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .header-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .btn-connect {
            background-color: var(--maroon);
            color: white !important;
            border-radius: 20px;
            padding: 6px 20px;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        
        .btn-connect:hover {
            background-color: var(--maroon-light);
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-pending {
            background-color: #EBEBEB;
            color: #666 !important;
            border-radius: 20px;
            padding: 6px 20px;
            font-weight: 600;
            border: 1px solid #CCC;
        }

        .profile-intro {
            margin-top: 60px;
        }

        .profile-intro h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            color: #000;
        }

        .profile-intro .headline {
            font-size: 16px;
            color: var(--text-main);
            margin-top: 4px;
        }

        .profile-intro .sub-meta {
            font-size: 14px;
            color: var(--text-sub);
            margin-top: 8px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .profile-intro .sub-meta i { color: #888; }

        /* Section Cards */
        .content-card {
            background: var(--card);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid var(--border);
            margin-bottom: 12px;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.08);
        }

        .content-card h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .content-card h2 i {
            color: var(--maroon);
            font-size: 18px;
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin: -4px 0 20px;
        }

        .empty-text {
            color: var(--text-sub);
            font-style: italic;
            text-align: center;
            padding: 20px 0;
        }

        /* Skills/Expertise */
        .expertise-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .expertise-tag {
            background: #F2F2F2;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            color: #444;
            border: 1px solid #DDD;
        }

        /* Certifications */
        .cert-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        .cert-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: 12px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .cert-item:hover { 
            background: #F9F9F9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-color: var(--maroon);
        }

        .cert-img {
            width: 60px;
            height: 60px;
            background: #F0F0F0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            object-fit: cover;
            flex-shrink: 0;
        }

        .cert-details h4 {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .cert-details p {
            font-size: 13px;
            color: var(--text-sub);
            margin: 0;
        }

        @media (max-width: 768px) {
            .profile-avatar { width: 120px; height: 120px; top: -80px; }
            .profile-intro { margin-top: 50px; }
        }
    </style>
</head>
<body>

<div class="profile-container">
    <a href="<?= site_url('alumni') ?>" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Network
    </a>

    <!-- Header Card -->
    <div class="profile-card">
        <div class="cover-photo">
            <?php if (!empty($alumni->cover_photo)): ?>
                <img src="<?= base_url('assets/uploads/alumni/' . $alumni->cover_photo) ?>" alt="Cover">
            <?php endif; ?>
        </div>
        
        <div class="profile-header-main">
            <div class="profile-avatar-container">
                <?php 
                    $profile_img = (!empty($alumni->profile_image)) 
                        ? base_url('assets/uploads/alumni/' . $alumni->profile_image) 
                        : base_url('assets/images/person-male.png');
                ?>
                <img src="<?= $profile_img ?>" class="profile-avatar" alt="Avatar">
            </div>

            <div class="header-actions">
                <?php if ($alumni->id != $this->session->userdata('alumni_id')): ?>
                    <?php if ($connection_status == 'accepted'): ?>
                        <div class="dropdown">
                            <button class="btn btn-pending dropdown-toggle" type="button" id="connectionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-check-double"></i> Connected
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="connectionDropdown">
                                <a class="dropdown-item text-danger unlink-btn" href="javascript:void(0)" data-id="<?= $alumni->id ?>">
                                    <i class="fas fa-user-slash mr-2"></i> Disconnect
                                </a>
                            </div>
                        </div>
                    <?php elseif ($connection_status == 'pending'): ?>
                        <button class="btn btn-pending disabled"><i class="fas fa-clock"></i> Pending</button>
                    <?php else: ?>
                        <button class="btn btn-connect connect-btn" data-id="<?= $alumni->id ?>">
                            <i class="fas fa-user-plus"></i> Connect
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="profile-intro">
                <h1><?= ucwords(strtolower($alumni->first_name . ' ' . $alumni->last_name)) ?></h1>
                <div class="headline"><?= !empty($alumni->degree) ? $alumni->degree : 'Alumni' ?></div>
                
                <div class="sub-meta">
                    <?php if (!empty($alumni->graduation_year)): ?>
                        <span><i class="fas fa-graduation-cap"></i> Graduated <?= $alumni->graduation_year ?></span>
                    <?php endif; ?>
                    <span><i class="fas fa-id-badge"></i> Class of <?= $alumni->graduation_year ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Career Summary -->
    <div class="content-card">
        <h2><i class="fas fa-briefcase"></i> Career Summary</h2>
        <div class="divider"></div>
        <?php if (!empty($employment)): ?>
            <div class="job-entry">
                <h4 style="font-size: 17px; font-weight: 700;"><?= htmlspecialchars($employment['job_title']) ?></h4>
                <p style="color: var(--text-sub); margin-bottom: 8px;"><?= htmlspecialchars($employment['company_name']) ?></p>
                <p style="font-size: 14px; color: #555;"><?= nl2br(htmlspecialchars($employment['job_description'])) ?></p>
            </div>
        <?php else: ?>
            <p class="empty-text">No professional experience listed</p>
        <?php endif; ?>
    </div>

    <!-- Certifications -->
    <div class="content-card">
        <h2><i class="fas fa-certificate"></i> Professional Certifications</h2>
        <div class="divider"></div>
        <?php if (!empty($certifications)): ?>
            <div class="cert-list">
                <?php foreach ($certifications as $cert): ?>
                    <div class="cert-item view-cert-details"
                         data-title="<?= htmlspecialchars($cert->title) ?>"
                         data-issuer="<?= htmlspecialchars($cert->issuer) ?>"
                         data-date="<?= $cert->date_issued ?>"
                         data-image="<?= $cert->certificate_image ? base_url('assets/uploads/alumni/' . $cert->certificate_image) : '' ?>">
                        <?php if (!empty($cert->certificate_image)): ?>
                            <img src="<?= base_url('assets/uploads/alumni/' . $cert->certificate_image) ?>" class="cert-img" alt="Cert">
                        <?php else: ?>
                            <div class="cert-img"><i class="fas fa-award fa-2x" style="color: #DDD;"></i></div>
                        <?php endif; ?>
                        <div class="cert-details">
                            <h4><?= htmlspecialchars($cert->title) ?></h4>
                            <p><?= htmlspecialchars($cert->issuer) ?></p>
                            <?php if (!empty($cert->date_issued)): ?>
                                <p style="font-size: 11px;">Issued <?= date('M Y', strtotime($cert->date_issued)) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="empty-text">No certifications listed</p>
        <?php endif; ?>
    </div>

    <!-- Areas of Expertise -->
    <div class="content-card">
        <h2><i class="fas fa-shapes"></i> Areas of Expertise</h2>
        <div class="divider"></div>
        <div class="expertise-tags">
            <?php 
                $all_skills = array_merge(
                    explode(',', $alumni->soft_skills ?? ""),
                    explode(',', $alumni->technical_skills ?? "")
                );
                $all_skills = array_filter(array_unique(array_map('trim', $all_skills)));
            ?>
            <?php if (!empty($all_skills)): ?>
                <?php foreach ($all_skills as $skill): ?>
                    <span class="expertise-tag"><?= htmlspecialchars($skill) ?></span>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-text w-100">No expertise listed</p>
            <?php endif; ?>
        </div>
    <!-- Certification Detail Modal -->
    <div class="modal fade" id="certDetailModal" tabindex="-1" role="dialog" aria-labelledby="certDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                <div class="modal-header" style="background: linear-gradient(135deg, #d4a574, #b08d5c); color: white; border: none; padding: 20px 24px;">
                    <h5 class="modal-title" id="certDetailModalLabel" style="font-weight: 700; letter-spacing: 0.5px;">
                        <i class="fas fa-medal mr-2"></i> Professional Credential
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="row no-gutters">
                        <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4" style="min-height: 320px; background-color: #f8fafc !important;">
                            <img id="certDetailImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 280px; width: auto; display: none; border: 1px solid #e2e8f0;">
                            <div id="certDetailIcon" class="text-muted" style="opacity: 0.3;"><i class="fas fa-award fa-6x"></i></div>
                        </div>
                        <div class="col-md-7 p-4 btn-light" style="background: white;">
                            <div class="mb-4">
                                <span class="badge badge-pill badge-warning mb-2" style="background-color: #fef3c7; color: #92400e; font-weight: 700; padding: 6px 12px;">OFFICIAL RECORD</span>
                                <h3 id="certDetailTitle" class="mb-1" style="font-weight: 800; color: #1e293b; line-height: 1.2;"></h3>
                                <p id="certDetailIssuer" class="text-muted" style="font-size: 18px; font-weight: 500;"></p>
                            </div>
                            
                            <div style="height: 1px; background: #f1f5f9; margin-bottom: 24px;"></div>
                            
                            <div class="d-flex align-items-center mb-4 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <div class="mr-3 text-warning"><i class="fas fa-calendar-check fa-lg"></i></div>
                                <div>
                                    <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: 1px; font-size: 10px;">Date Issued</small>
                                    <div id="certDetailDate" class="font-weight-bold" style="color: #334155; font-size: 15px;"></div>
                                </div>
                            </div>
                            
                            <div class="mt-4 p-3 rounded-lg" style="border-left: 4px solid #d4a574; background: #fffcf5;">
                                <p class="mb-0" style="color: #78350f; font-size: 13px; line-height: 1.5;">
                                    Certificate is verified by AConnect
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px;">
                    <button type="button" class="btn btn-secondary px-4 font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Close Details</button>
                    <?php if ($connection_status == 'accepted'): ?>
                    <button type="button" class="btn btn-primary px-4 font-weight-bold" style="border-radius: 8px; background: var(--maroon); border: none;">Congratulate</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    $('.connect-btn').on('click', function() {
        var btn = $(this);
        var id = btn.data('id');
        
        $.post('<?= site_url("alumni/send_request") ?>', { receiver_id: id }, function(res) {
            if(res.status === 'success') {
                btn.removeClass('btn-connect').addClass('btn-pending disabled').html('<i class="fas fa-clock"></i> Pending');
            }
        });
    });

    $(document).on('click', '.unlink-btn', function() {
        if (!confirm('Are you sure you want to disconnect?')) return;
        var id = $(this).data('id');
        $.post('<?= site_url("alumni/remove_connection") ?>', { receiver_id: id }, function(res) {
            location.reload();
        });
    });

    $('.view-cert-details').on('click', function() {
        const title = $(this).data('title');
        const issuer = $(this).data('issuer');
        const date = $(this).data('date');
        const image = $(this).data('image');

        $('#certDetailTitle').text(title);
        $('#certDetailIssuer').text(issuer);
        $('#certDetailDate').text(date ? date : 'Date not specified');
        
        if (image) {
            $('#certDetailImage').attr('src', image).show();
            $('#certDetailIcon').hide();
        } else {
            $('#certDetailImage').hide();
            $('#certDetailIcon').show();
        }

        $('#certDetailModal').modal('show');
    });
});
</script>

</body>
</html>
