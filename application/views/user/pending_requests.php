<?php
$display_full_name = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
$student_number = $this->session->userdata('student_number') ? $this->session->userdata('student_number') : 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Requests - AConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        :root {
            --primary: #8B1538;
            --primary-dark: #6B0F2A;
            --accent: #D4A574;
            --bg-page: #FAFAF8;
            --white: #FFFFFF;
            --text-main: #1F2937;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
            --success: #10B981;
            --danger: #EF4444;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-page);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-main);
            line-height: 1.6;
        }

        .header-spacing {
            height: 70px;
        }

        .container {
            max-width: 900px;
            width: 100%;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-header {
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 2px solid var(--border);
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.5px;
        }

        .page-header h1 i {
            color: var(--primary);
            font-size: 2.2rem;
        }

        .page-header p {
            margin: 0;
            color: var(--text-muted);
            font-size: 1rem;
        }

        .requests-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .request-card {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--border);
            border-left: 5px solid var(--primary);
            padding: 24px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .request-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
            border-left-color: var(--accent);
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
            min-width: 0;
        }

        .profile-avatar {
            width: 70px;
            height: 70px;
            min-width: 70px;
            border-radius: 50%;
            border: 3px solid var(--accent);
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
            min-width: 0;
        }

        .profile-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 6px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-degree {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .profile-date {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .request-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            text-align: center;
        }

        .btn-view {
            background: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-view:hover {
            background: var(--primary);
            color: var(--white);
        }

        .btn-accept {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .btn-accept:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-decline {
            background: linear-gradient(135deg, var(--danger) 0%, #DC2626 100%);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .btn-decline:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: var(--white);
            border-radius: 12px;
            border: 2px dashed var(--border);
            box-shadow: var(--shadow-sm);
        }

        .empty-state i {
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 16px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 8px 0;
        }

        .empty-state p {
            color: var(--text-muted);
            margin: 0;
            font-size: 1rem;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            border-radius: 12px 12px 0 0;
        }

        .modal-header h5 {
            color: var(--white);
            font-weight: 700;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-body p {
            margin-bottom: 12px;
            font-size: 1rem;
        }

        .modal-body strong {
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .request-card {
                flex-direction: column;
                text-align: center;
            }

            .profile-section {
                width: 100%;
                justify-content: center;
            }

            .profile-info {
                width: 100%;
            }

            .request-actions {
                width: 100%;
                justify-content: center;
            }

            .btn {
                flex: 1;
                min-width: 120px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="header-spacing"></div>

<div class="container">
    <div class="page-header">
        <h1>
            <i class="fas fa-handshake"></i>
            Connection Requests
        </h1>
        <p>Manage your pending alumni network connection requests</p>
    </div>

    <?php if (empty($pending_requests)): ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>No Pending Requests</h3>
            <p>You have no pending connection requests at this time.</p>
        </div>
    <?php else: ?>
        <ul class="requests-list">
            <?php foreach ($pending_requests as $request): ?>
                <li class="request-card">
                    <div class="profile-section">
                        <div class="profile-avatar">
                            <?php 
                                $image_path = $request->profile_image ?? null;
                                $gender = strtolower($request->gender ?? 'male');
                                $default_img = ($gender === 'female') ? base_url('assets/images/person-female.png') : base_url('assets/images/person-male.png');
                                
                                if ($image_path && file_exists(FCPATH . 'assets/uploads/alumni/' . $image_path)): ?>
                                    <img src="<?= base_url('assets/uploads/alumni/' . $image_path) ?>" alt="<?= $request->first_name ?>">
                                <?php else: ?>
                                    <img src="<?= $default_img ?>" alt="Default Profile">
                                <?php endif; ?>
                            </div>
                        <div class="profile-info">
                            <h3 class="profile-name">
                                <?= htmlspecialchars($request->first_name . ' ' . $request->last_name) ?>
                            </h3>
                            <p class="profile-degree">
                                <i class="fas fa-graduation-cap"></i>
                                <?= htmlspecialchars($request->degree ?? 'N/A') ?>
                            </p>
                            <p class="profile-date">
                                <i class="fas fa-calendar-alt"></i>
                                Requested: <?= date('M j, Y', strtotime($request->request_date ?? 'now')) ?>
                            </p>
                        </div>
                    </div>

                    <div class="request-actions">
                        <button type="button" class="btn btn-view" data-toggle="modal" data-target="#viewProfileModal<?= $request->sender_id ?? '0' ?>">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <a href="<?= site_url('alumni_request/accept_request/' . ($request->id ?? 0)) ?>" class="btn btn-accept">
                            <i class="fas fa-check"></i> Accept
                        </a>
                        <a href="<?= site_url('alumni_request/decline_request/' . ($request->id ?? 0)) ?>" class="btn btn-decline">
                            <i class="fas fa-times"></i> Decline
                        </a>
                    </div>
                </li>

                <div class="modal fade" id="viewProfileModal<?= $request->sender_id ?? '0' ?>" tabindex="-1" role="dialog" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: var(--shadow-lg);">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewProfileModalLabel">
                                    <i class="fas fa-user-circle mr-2"></i> 
                                    <?= htmlspecialchars($request->first_name . ' ' . $request->last_name) ?>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div style="text-align: center; margin-bottom: 20px;">
                                    <div class="profile-avatar" style="width: 100px; height: 100px; margin: 0 auto;">
                                        <?php 
                                            $image_path = $request->profile_image ?? null;
                                            $gender = strtolower($request->gender ?? 'male');
                                            $default_img = ($gender === 'female') ? base_url('assets/images/person-female.png') : base_url('assets/images/person-male.png');
                                            
                                            if ($image_path && file_exists(FCPATH . 'assets/uploads/alumni/' . $image_path)): ?>
                                                <img src="<?= base_url('assets/uploads/alumni/' . $image_path) ?>" alt="<?= $request->first_name ?>">
                                            <?php else: ?>
                                                <img src="<?= $default_img ?>" alt="Default Profile">
                                            <?php endif; ?>
                                    </div>
                                </div>
                                <p><strong>Name:</strong> <?= htmlspecialchars($request->first_name . ' ' . $request->last_name) ?></p>
                                <p><strong>Degree:</strong> <?= htmlspecialchars($request->degree ?? 'N/A') ?></p>
                                <p><strong>Request Date:</strong> <?= date('M j, Y \a\t g:i A', strtotime($request->request_date ?? 'now')) ?></p>
                                <p><strong>Status:</strong> <span style="color: var(--primary); font-weight: 700;">Pending</span></p>
                            </div>
                            <div class="modal-footer" style="background: var(--bg-page); border-top: 1px solid var(--border);">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Configure toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "4000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "slideUp"
    };

    function showToast(message, type = 'success') {
        toastr[type](message);
    }

    $(document).ready(function() {
        // Add notifications to action buttons
        $('.btn-approve, .btn-reject, .btn-action').on('click', function() {
            const action = $(this).text().trim();
            showToast(action + ' submitted!', 'success');
        });
    });
</script>

</body>
</html>