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

// Precise active state logic
$is_home = (empty($current_uri_segment_1) || in_array($current_uri_segment_1, ['PostController', 'postcontroller']));
$is_network = in_array($current_uri_segment_1, ['alumni', 'alumni_request']);
$is_jobs = ($current_uri_segment_1 === 'jobs');
$is_messaging = ($current_uri_segment_1 === 'chat');
$is_events = in_array($current_uri_segment_1, ['events', 'eventsprevious']);
$admin_management_active = in_array($current_uri_segment_1, ['adminalumni', 'AdminJobPosting', 'AdminEvents', 'AdminPost']);
$admin_system_active = in_array($current_uri_segment_1, ['AdminManageAccounts', 'AdminActivityLog']);
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

    <style>
        :root {
            --primary-color: <?php echo $primary_color; ?>;
            --secondary-color: <?php echo $secondary_color; ?>;
            --nav-bg: #ffffff;
            --nav-text: #666666;
            --nav-height: 55px;
        }

        body { 
            background-color: #f3f2ef; 
            padding-top: 0 !important;
            font-size: 1.05rem;
        }

        #ac-main-header {
            position: sticky;
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
            transition: all 0.2s ease-in-out;
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
            transition: all 0.2s ease-in-out;
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 0 0 4px 4px;
            z-index: 2100;
            font-size: 0.95rem;
        }

        .dropdown-menu .dropdown-item {
            padding: 10px 18px;
            color: #333;
            transition: all 0.2s ease-in-out;
            border-left: 3px solid transparent;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
            border-left-color: var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
        }

        .user-logout-area {
            display: flex;
            align-items: center;
            border-left: 1px solid rgba(0,0,0,0.08);
            margin-left: 13px;
            padding-left: 13px;
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
            transform: rotate(-180deg);
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

        @media (max-width: 768px) {
            .nav-link-item span { display: none; }
            .nav-link-item { min-width: 53px; }
            .student-id-label { display: none; }
        }
    </style>
</head>
<body>

<header id="ac-main-header">
    <div class="ac-container">
        <div class="logo-area">
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
                    <li class="nav-item">
                        <a href="<?php echo base_url('alumni'); ?>" class="nav-link-item <?php echo $is_network ? 'active-link' : ''; ?>">
                            <i class="fas fa-user-friends"></i><span>Network</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('jobs'); ?>" class="nav-link-item <?php echo $is_jobs ? 'active-link' : ''; ?>">
                            <i class="fas fa-briefcase"></i><span>Jobs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('chat'); ?>" class="nav-link-item <?php echo $is_messaging ? 'active-link' : ''; ?>">
                            <i class="fas fa-comment-dots"></i><span>Messaging</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link-item dropdown-toggle <?php echo $is_events ? 'active-link' : ''; ?>" href="#" id="eventsDropdown" data-toggle="dropdown">
                            <i class="fas fa-calendar-alt"></i><span>Events</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="eventsDropdown">
                            <a class="dropdown-item" href="<?php echo base_url('events'); ?>">Upcoming</a>
                            <a class="dropdown-item" href="<?php echo base_url('eventsprevious'); ?>">Previous</a>
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
                            <a class="dropdown-item" href="<?php echo base_url('adminalumni'); ?>">Alumni List</a>
                            <a class="dropdown-item" href="<?php echo base_url('AdminJobPosting'); ?>">Job Posting</a>
                            <a class="dropdown-item" href="<?php echo base_url('AdminEvents'); ?>">Events</a>
                            <a class="dropdown-item" href="<?php echo base_url('AdminPost'); ?>">Posting</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link-item dropdown-toggle <?php echo $admin_system_active ? 'active-link' : ''; ?>" href="#" id="sysDropdown" data-toggle="dropdown">
                            <i class="fas fa-cogs"></i><span>System</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sysDropdown">
                            <a class="dropdown-item" href="<?php echo base_url('AdminManageAccounts'); ?>">User Accounts</a>
                            <a class="dropdown-item" href="<?php echo base_url('AdminActivityLog'); ?>">Activity Log</a>
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
                    <li class="nav-item">
                        <a href="<?php echo ($this->session->userdata('role') == 'administrator') ? '#' : base_url('profile'); ?>" class="account-info-display">
                            <span class="student-id-label"><?php echo ($this->session->userdata('role') == 'administrator') ? 'ADMIN' : $student_number; ?></span>
                            <span class="account-name-label"><?php echo $display_full_name; ?> <i class="fas fa-caret-down" style="font-size: 11px;"></i></span>
                        </a>
                    </li>
                    <a href="<?php echo base_url('login/logout'); ?>" class="logout-link" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
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