<?php
$primary_color = '#700A0A';
$secondary_color = '#C90000';
$accent_color = '#70ADBC';
$text_light = '#FFFFFF';

// Getting account details from session
$display_full_name = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
$student_number = $this->session->userdata('student_number') ? $this->session->userdata('student_number') : 'N/A';

$current_uri_segment_1 = property_exists($this, 'uri') ? $this->uri->segment(1) : '';
$current_uri_segment_2 = property_exists($this, 'uri') ? $this->uri->segment(2) : '';

// Helper function for active states
function is_active_segment($segment1, $segment2 = null) {
    global $current_uri_segment_1, $current_uri_segment_2;
    if ($segment2 !== null) {
        return $current_uri_segment_1 === $segment1 && $current_uri_segment_2 === $segment2;
    }
    return $current_uri_segment_1 === $segment1;
}

// Fetch full alumni details for profile picture
$alumni_id = $this->session->userdata('alumni_id');
$profile_image_url = base_url('assets/images/person-male.png');
if ($alumni_id) {
    $CI =& get_instance();
    $CI->load->model('user/Alumni_model');
    $user_data = $CI->Alumni_model->get_alumni_by_id($alumni_id);
    if ($user_data && $user_data->profile_image) {
        $profile_image_url = base_url('assets/uploads/alumni/' . $user_data->profile_image);
    }
}


// Precise active state logic
$is_events_group = in_array($current_uri_segment_1, ['events', 'Events', 'eventsprevious', 'EventsPrevious']);
$is_events_upcoming = in_array($current_uri_segment_1, ['events', 'Events']);
$is_events_previous = in_array($current_uri_segment_1, ['eventsprevious', 'EventsPrevious']);
$is_home = (empty($current_uri_segment_1) || in_array($current_uri_segment_1, ['PostController', 'postcontroller']));
$is_network = in_array($current_uri_segment_1, ['alumni', 'alumni_request']);
$is_jobs = ($current_uri_segment_1 === 'jobs');
$is_officers = ($current_uri_segment_1 === 'Officers');
$is_messaging = ($current_uri_segment_1 === 'chat');
$is_forum = ($current_uri_segment_1 === 'forum');
$is_events = in_array($current_uri_segment_1, ['events', 'eventsprevious']);
$admin_management_active = in_array($current_uri_segment_1, ['adminalumni', 'AdminJobPosting', 'AdminEvents', 'AdminPost', 'AdminManageAccounts', 'AdminActivityLog']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AConnect</title>
    <link href="<?php echo base_url('assets/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,400,600,700,800" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: <?php echo $primary_color; ?>;
            --secondary-color: <?php echo $secondary_color; ?>;
            --nav-bg: #ffffff;
            --nav-text: #666666;
            --nav-height: 55px;
        }

        html, body { 
            overflow-x: hidden;
            width: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            background-color: #f3f2ef; 
            padding-top: var(--nav-height) !important;
            font-size: 1.05rem;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?php echo base_url('assets/images/background.png'); ?>');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(8px);
            z-index: -1;
        }

        #ac-main-header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 2000;
            background-color: var(--nav-bg);
            border-bottom: 1px solid rgba(0,0,0,0.08);
            height: var(--nav-height);
        }

        .ac-container {
            max-width: 1185px;
            margin: 0 auto;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 0 25px;
            height: 100%;
            box-sizing: border-box;
        }

        .primary-nav, .primary-nav ul {
            height: 100%;
            display: flex;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .primary-nav { margin-left: auto; }

        .nav-item {
            height: 100%;
            display: flex;
            align-items: center;
        }

        .nav-link-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--nav-text);
            text-decoration: none !important;
            min-width: 84px;
            height: 100%;
            font-size: 13px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            padding-top: 4px;
            border-bottom: 2px solid transparent;
        }

        .nav-link-item i {
            font-size: 20px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            min-width: 20px;
            min-height: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link-item span {
            font-weight: 500;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link-item:hover {
            color: #000000;
        }

        /* Only apply translateY on non-dropdown nav links */
        .nav-item:not(.dropdown) .nav-link-item:hover {
            transform: translateY(-2px);
        }
        .nav-item:not(.dropdown) .nav-link-item:hover i {
            transform: scale(1.15);
            color: #8B1538;
        }

        .nav-link-item.active-link {
            color: #000000;
            border-bottom: 2px solid #000000;
        }

        .nav-item.dropdown .nav-link-item span::after {
            content: '';
            margin-left: 6px;
            display: inline-block;
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 4px solid currentColor;
            transition: transform 0.2s ease-in-out;
        }

        .nav-item.dropdown .nav-link-item:hover span::after,
        .nav-item.dropdown .nav-link-item.active-link span::after {
            transform: rotate(-180deg);
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .dropdown-menu {
            margin-top: 0 !important;
            border: none;
            box-shadow: 0 12px 28px rgba(0,0,0,0.15), 0 8px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            z-index: 2100;
            font-size: 0.95rem;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-menu .dropdown-item {
            padding: 10px 18px;
            color: #333;
            transition: all 0.2s ease-in-out;
            border-left: 3px solid transparent;
            align-items: center;
            display: flex;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
            border-left-color: var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
            align-items: center;
            display: flex;
        }

        .user-logout-area {
            display: flex;
            align-items: center;
            border-left: 1px solid rgba(0,0,0,0.08);
            margin-left: 15px;
            padding-left: 15px;
            height: 100%;
        }

        .account-info-display {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            height: 100%;
            padding: 0 11px;
            color: var(--nav-text);
            text-decoration: none !important;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .account-info-display:hover {
            color: var(--primary-color);
        }

        .student-id-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .account-name-label {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            line-height: 1;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .account-name-label i {
            font-size: 10px;
            transition: transform 0.2s ease-in-out;
        }

        .account-info-display:hover .account-name-label i {
            /* animation removed */
        }

        .logout-link {
            padding-left: 11px;
            color: var(--nav-text);
            font-size: 19px;
            display: flex;
            align-items: center;
            text-decoration: none !important;
            transition: all 0.2s ease-in-out;
            position: relative;
        }

        .logout-link i {
            transition: all 0.2s ease-in-out;
        }

        .logout-link:hover {
            color: var(--secondary-color);
        }

        .logout-link:hover i {
            transform: scale(1.2);
        }

        /* Updated Dropdown Styling */
        .dropdown-menu {
            margin-top: 10px !important;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 8px;
            min-width: 240px;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        /* Messaging Dropdown Specifics */
        #messaging-dropdown-menu {
            width: 360px;
            padding: 0;
            overflow: hidden;
        }

        .msg-dropdown-header {
            padding: 16px;
            border-bottom: 1px solid #eee;
        }

        .msg-dropdown-search {
            padding: 8px 16px;
        }

        .msg-dropdown-search input {
            background: #f0f2f5;
            border: none;
            border-radius: 20px;
            padding: 8px 12px;
            width: 100%;
            font-size: 14px;
        }

        .msg-dropdown-filters {
            display: flex;
            padding: 8px 16px;
            gap: 8px;
            border-bottom: 1px solid #eee;
            overflow-x: auto;
        }

        .msg-filter-btn {
            background: #f0f2f5;
            border: none;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 600;
            color: #65676b;
            cursor: pointer;
            white-space: nowrap;
        }

        .msg-filter-btn.active {
            background: #fde8e8;
            color: var(--primary-color);
        }

        .msg-dropdown-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .msg-item {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .msg-item:hover { background: #f2f2f2; }

        .msg-item img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .msg-item-info { flex: 1; min-width: 0; }
        .msg-item-name { font-weight: 600; color: #050505; font-size: 15px; }
        .msg-item-text { font-size: 13px; color: #65676b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        /* Profile Dropdown Specifics */
        .profile-user-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .dropdown-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
             align-items: center;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .nav-link-item span { display: none; }
            .nav-link-item { min-width: 50px; }
            .ac-container { padding: 0 10px; }
            .logo-area img { height: 52px !important; }
            .user-logout-area { margin-left: 10px; padding-left: 10px; border: none; }
            #messaging-dropdown-menu, #menu-dropdown-menu { 
                width: 90vw; 
                max-width: 360px;
                position: fixed !important; 
                left: 50% !important; 
                transform: translateX(-50%) !important; 
                top: 55px !important; 
            }
            .desktop-only { display: none !important; }
        }

        @media (min-width: 769px) {
            .mobile-only { display: none !important; }
        }

        @media (max-width: 576px) {
            .nav-link-item { min-width: 42px; }
            .primary-nav { margin-left: 0; flex: 1; }
            .primary-nav ul { width: 100%; justify-content: flex-end; }
            .logo-area { display: flex; }
            .logo-area img { height: 46px !important; }
            .user-logout-area { margin-left: 8px; padding-left: 8px; }
        }

                /* ================= MOBILE MENU CLEAN STYLE ================= */

        .mobile-menu-item {
            padding: 12px !important;
            gap: 14px !important;
            border-radius: 10px;
            transition: all .25s ease;
        }

        .mobile-menu-item:hover {
            background: #f8fafc;
            transform: translateX(4px);
        }

        /* icon container */
        .mobile-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 15px;
            flex-shrink: 0;
        }

        /* icon colors */
        .bg-network { background: #8B1538; }
        .bg-jobs { background: #8B1538; }
        .bg-events { background: #8B1538; }
        .bg-history { background: #8B1538; }
        .bg-officers { background: #8B1538; }

        /* text */
        .mobile-title {
            font-weight: 600;
            font-size: 14px;
        }

        .mobile-sub {
            font-size: 11px;
            color: #6b7280;
            font-weight: 400;
        }

        /* ================= MOBILE MENU INTERACTION ================= */

        .mobile-menu-item {
            padding: 12px !important;
            gap: 14px !important;
            border-radius: 10px;
            transition: all .25s ease;
            position: relative;
        }

        /* 🖱 DESKTOP hover */
        .mobile-menu-item:hover {
            background: #f1f5f9;
            transform: translateX(4px);
        }

        /* 👆 MOBILE press */
        .mobile-menu-item:active {
            background: #e2e8f0;
            transform: scale(.98);
        }

        /* ⭐ ACTIVE PAGE (current route) */
        .mobile-menu-item.active-mobile {
            background: #fef2f2;
            border-left: 4px solid var(--primary-color);
        }

        /* icon color when active */
        .mobile-menu-item.active-mobile .mobile-icon {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(139,21,56,.25);
        }

        /* text color when active */
        .mobile-menu-item.active-mobile .mobile-title {
            color: var(--primary-color);
            font-weight: 700;
        }

        
        
    </style>
</head>
<body>

<header id="ac-main-header">
    <div class="ac-container">
        <div class="logo-area d-flex align-items-center">
            <?php if($this->session->userdata('role') == 'administrator'): ?>
                <img src="<?php echo base_url('assets/images/schoollogo.jpg'); ?>" alt="School Logo" class="mr-2" style="height:52px; border-radius: 4px;">
            <?php else: ?>
                <a href="<?php echo base_url('dashboard'); ?>">
                    <img src="<?php echo base_url('assets/images/schoollogo.jpg'); ?>" alt="School Logo" class="mr-2" style="height:52px; border-radius: 4px;">
                </a>
            <?php endif; ?>
            <?php if($this->session->userdata('role') == 'administrator'): ?>
                <a href="<?php echo base_url('AdminDashboard'); ?>">
                    <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Admin Logo" style="height:52px;">
                </a>
            <?php else: ?>
                <a href="<?php echo base_url('PostController'); ?>">
                    <img src="<?php echo base_url('assets/images/small_logo.png'); ?>" alt="Logo" style="height:52px;">
                </a>
            <?php endif; ?>
        </div>

        <nav class="primary-nav">
            <ul>
                <?php if($this->session->userdata('role') == 'alumni'): ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('postcontroller'); ?>" class="nav-link-item <?php echo $is_home ? 'active-link' : ''; ?>">
                            <i class="fas fa-house-user"></i><span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item desktop-only">
                        <a href="<?php echo base_url('alumni'); ?>" class="nav-link-item <?php echo $is_network ? 'active-link' : ''; ?>">
                            <i class="fas fa-user-friends"></i><span>Network</span>
                        </a>
                    </li>
                    <li class="nav-item desktop-only">
                        <a href="<?php echo base_url('Officers'); ?>" class="nav-link-item <?php echo $is_officers ? 'active-link' : ''; ?>">
                            <i class="fas fa-user-tie"></i><span>Officers</span>
                        </a>
                    </li>
                    <li class="nav-item desktop-only">
                        <a href="<?php echo base_url('jobs'); ?>" class="nav-link-item <?php echo $is_jobs ? 'active-link' : ''; ?>">
                            <i class="fas fa-briefcase"></i><span>Jobs</span>
                        </a>
                    </li>
                    <li class="nav-item desktop-only">
                        <a href="<?php echo base_url('forum'); ?>" class="nav-link-item <?php echo $is_forum ? 'active-link' : ''; ?>">
                            <i class="fas fa-comments"></i><span>Forum</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown desktop-only">
                        <a href="#" class="nav-link-item dropdown-toggle <?php echo $is_events ? 'active-link' : ''; ?>" data-toggle="dropdown">
                            <i class="fas fa-calendar-check"></i><span>Events</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow border-0" style="min-width: 220px; padding: 8px;">
                            <a class="dropdown-item" href="<?php echo base_url('events'); ?>">
                                <div style="background: #8B1538; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600;">Current Events</div>
                                    <div style="font-size: 11px; color: #65676b; font-weight: 400;">Upcoming activities</div>
                                </div>
                            </a>
                            <a class="dropdown-item" href="<?php echo base_url('EventsPrevious'); ?>">
                                <div style="background: #e4e6eb; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #050505;">
                                    <i class="fas fa-history"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600;">Past Events</div>
                                    <div style="font-size: 11px; color: #65676b; font-weight: 400;">Previous activities</div>
                                </div>
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown mobile-only">
                        <a href="#" class="nav-link-item dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-th"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow border-0" id="menu-dropdown-menu" style="min-width: 280px; padding: 16px;">
                            
                            <div class="mb-2 font-weight-bold text-muted small uppercase">Social</div>
                            <a class="dropdown-item mobile-menu-item <?= $is_network ? 'active-mobile' : '' ?>" href="<?= base_url('alumni'); ?>">
                                <div class="mobile-icon bg-network">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <div>
                                    <div class="mobile-title">Network</div>
                                    <div class="mobile-sub">Connect with alumni</div>
                                </div>
                            </a>
                            
                            <a class="dropdown-item mobile-menu-item <?= $is_officers ? 'active-mobile' : '' ?>" href="<?= base_url('Officers'); ?>">
                                <div class="mobile-icon bg-officers">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <div class="mobile-title">Officers</div>
                                    <div class="mobile-sub">Meet alumni leaders</div>
                                </div>
                            </a>
                            <a class="dropdown-item mobile-menu-item <?= $is_forum ? 'active-mobile' : '' ?>" href="<?= base_url('forum'); ?>">
                                <div class="mobile-icon bg-network">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div>
                                    <div class="mobile-title">Forum</div>
                                    <div class="mobile-sub">Discuss with alumni</div>
                                </div>
                            </a>
                            <div class="mb-2 font-weight-bold text-muted small uppercase">Careers</div>
                           <a class="dropdown-item mobile-menu-item <?= $is_jobs ? 'active-mobile' : '' ?>" href="<?= base_url('jobs'); ?>">
                                <div class="mobile-icon bg-jobs">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div>
                                    <div class="mobile-title">Jobs</div>
                                    <div class="mobile-sub">Find opportunities</div>
                                </div>
                            </a>
                            <div class="mb-2 font-weight-bold text-muted small uppercase">Events</div>
                            <a class="dropdown-item mobile-menu-item <?= $is_events_upcoming ? 'active-mobile' : '' ?>" href="<?= base_url('events'); ?>">
                                <div class="mobile-icon bg-events">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <div class="mobile-title">Current Events</div>
                                    <div class="mobile-sub">Stay updated</div>
                                </div>
                            </a>
                            <a class="dropdown-item mobile-menu-item <?= $is_events_previous ? 'active-mobile' : '' ?>" href="<?= base_url('EventsPrevious'); ?>">
                                <div class="mobile-icon bg-history">
                                    <i class="fas fa-history"></i>
                                </div>
                                <div>
                                    <div class="mobile-title">Past Events</div>
                                    <div class="mobile-sub">Past activities</div>
                                </div>
                            </a>
                        </div>
                    </li>
                     <li class="nav-item dropdown">
                        <a href="#" class="nav-link-item <?php echo $is_messaging ? 'active-link' : ''; ?> dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-comment-dots"></i><span>Messaging</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" id="messaging-dropdown-menu">
                            <div class="msg-dropdown-search">
                                <input type="text" placeholder="Search Messenger" id="msg-search-input">
                            </div>
                            <div class="msg-dropdown-filters">
                                <button class="msg-filter-btn active" data-filter="all">All</button>
                                <button class="msg-filter-btn" data-filter="unread">Unread</button>
                            </div>
                            <div class="msg-dropdown-list" id="msg-dropdown-list">
                                <!-- Populated via JS -->
                                <div class="p-4 text-center text-muted">Loading chats...</div>
                            </div>
                        </div>
                    </li>



                <?php elseif($this->session->userdata('role') == 'administrator'): ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('AdminDashboard'); ?>" class="nav-link-item <?php echo is_active_segment('AdminDashboard') ? 'active-link' : ''; ?>">
                            <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link-item dropdown-toggle <?php echo $admin_management_active ? 'active-link' : ''; ?>" href="#" id="mgmtDropdown" data-toggle="dropdown">
                            <i class="fas fa-tasks"></i><span>Management</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="mgmtDropdown">
                            <a class="dropdown-item" href="<?php echo base_url('AdminManageAccounts'); ?>">User Accounts</a>
                            <a class="dropdown-item" href="<?php echo base_url('AdminOfficers'); ?>">Alumni Officers</a>
                            <div class="dropdown-divider"></div>
                            <!-- <a class="dropdown-item" href="<?php echo base_url('adminalumni'); ?>">Alumni List</a> -->
                            <a class="dropdown-item" href="<?php echo base_url('AdminJobPosting'); ?>">Job Posting</a>
                            <a class="dropdown-item" href="<?php echo base_url('AdminEvents'); ?>">Events</a>
                            <a class="dropdown-item" href="<?php echo base_url('AdminPost'); ?>">Posting</a>
                            <!-- <a class="dropdown-item" href="<?php echo base_url('AdminActivityLog'); ?>">Activity Log</a> -->
                        </div>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?php echo base_url('support/admin_inbox'); ?>" class="nav-link-item <?php echo is_active_segment('support', 'admin_inbox') ? 'active-link' : ''; ?>">
                            <i class="fas fa-headset"></i><span>Support</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('AdminReports'); ?>" class="nav-link-item <?php echo is_active_segment('AdminReports') ? 'active-link' : ''; ?>">
                            <i class="fas fa-chart-bar"></i><span>Analytics</span>
                        </a>
                    </li>
                <?php endif; ?>

                <div class="user-logout-area">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link-item dropdown-toggle" data-toggle="dropdown" style="min-width: 50px; padding: 0;">
                            <img src="<?php echo $profile_image_url; ?>" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow border-0" style="min-width: 280px; padding: 12px;">

                            <a class="dropdown-item" href="<?php echo ($this->session->userdata('role') == 'administrator') ? '#' : base_url('profile'); ?>">
                                <img src="<?php echo $profile_image_url; ?>" alt="Profile">
                                <div>
                                    <div style="font-weight: 700; font-size: 16px;"><?php echo $display_full_name; ?></div>
                                    <div style="font-size: 12px; color: #65676b;"><?php echo ($this->session->userdata('role') == 'administrator') ? 'Administrator' : $student_number; ?></div>
                                </div>
                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url('login/logout'); ?>">
                                <div style="background: #e4e6eb; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-sign-out-alt"></i>
                                </div>
                                <span>Log Out</span>
                            </a>
                        </div>
                    </li>
                </div>

            </ul>
        </nav>
    </div>
</header>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
    });
</script>

</body>
</html>