<?php
$primary_color = '#700A0A';
$secondary_color = '#C90000';
$accent_color = '#70ADBC';
$text_light = '#FFFFFF';

$user_profile_pic = base_url('assets/images/default_profile.jpg'); 
if ($this->session->userdata('profile_picture_path')) {
    $user_profile_pic = base_url($this->session->userdata('profile_picture_path'));
}

$current_uri_segment_1 = property_exists($this, 'uri') ? $this->uri->segment(1) : '';
$current_uri_segment_2 = property_exists($this, 'uri') ? $this->uri->segment(2) : '';

function is_active_segment($segment1, $segment2 = null) {
    global $current_uri_segment_1, $current_uri_segment_2;

    if ($segment1 === 'PostController') {
        return empty($current_uri_segment_1) || $current_uri_segment_1 === 'PostController';
    }

    if ($segment2 !== null) {
        return $current_uri_segment_1 === $segment1 && $current_uri_segment_2 === $segment2;
    }
    return $current_uri_segment_1 === $segment1;
}

$connect_active = in_array($current_uri_segment_1, ['alumni', 'alumni_request', 'chat']);
$events_active = in_array($current_uri_segment_1, ['events', 'eventsprevious']);

$admin_management_active = in_array($current_uri_segment_1, ['adminalumni', 'AdminJobPosting', 'AdminEvents', 'AdminPost']);
$admin_system_active = in_array($current_uri_segment_1, ['AdminManageAccounts', 'AdminActivityLog']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Alumni Connect Portal">
    <meta name="author" content="AConnect Team">

    <title>AConnect</title>
    <link href="<?php echo base_url('assets/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/user/post.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 

    <style>
        /* CSS Variables for easier maintenance */
        :root {
            --primary-color: <?php echo $primary_color; ?>;
            --secondary-color: <?php echo $secondary_color; ?>;
            --accent-color: <?php echo $accent_color; ?>;
            --text-light: <?php echo $text_light; ?>;
        }
        
        body {
            padding-top: 0 !important; 
        }

        #wrapper {
            display: block; 
        }

        #content-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #content {
            flex-grow: 1; 
        }

        .sidebar, .topbar {
            display: none !important;
        }
        
        /* Main Header/Navbar */
        #ac-main-header {
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1030; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .ac-container {
            width: 100%; 
            margin: 0 auto;
            display: flex;
            align-items: stretch; 
        }

        .logo-area {
            background-color: transparent; 
            width: 300px; 
            flex-shrink: 0; 
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px 15px;
            position: relative;
            border-right: 1px solid rgba(255, 255, 255, 0.1); 
        }
        
        .logo-area a {
            transition: transform 0.3s ease-out, filter 0.3s ease-out;
        }
        
        .logo-area a:hover {
            transform: scale(1.05);
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.7));
        }

        .ac-logo {
            height: 80px;
            width: auto;
        }

        .main-nav-bar {
            background-color: transparent; 
            width: 100%;
            min-height: 90px;
            display: flex;
            align-items: center;
            padding: 5px 20px; 
            flex-grow: 1;
        }

        .primary-nav {
            flex-grow: 1; 
        }
        
        .primary-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .primary-nav ul li {
            position: relative;
            margin: 0 5px;
        }

        .primary-nav a {
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 30px 15px; 
            display: block;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border-bottom: 4px solid transparent; 
        }
        
        .primary-nav a:hover {
            background-color: rgba(255, 255, 255, 0.15); 
            border-bottom-color: transparent; 
            transform: translateY(-4px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            color: var(--text-light); 
        }
        
        .primary-nav .active-link {
            background-color: rgba(255, 255, 255, 0.1); 
            transform: none;
            border-bottom-color: var(--text-light); 
            color: var(--text-light); 
            font-weight: 900; 
        }

        /* Pure CSS Dropdown Styling */
        
        /* 1. Hide the dropdown by default */
        .primary-nav .nav-item .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%; 
            left: 0;
            z-index: 1000;
            background-color: var(--primary-color); 
            border-top: 2px solid var(--text-light);
            border-radius: 0 0 5px 5px;
            padding: 0;
            margin-top: -1px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.5);
            min-width: 180px; 
        }

        /* 2. Show dropdown on hover of the parent list item (nav-item) */
        .primary-nav .nav-item:hover .dropdown-menu {
            display: block;
        }
        
        /* Dropdown toggle link adjustments */
        .primary-nav .nav-link.dropdown-toggle {
            padding-right: 35px; 
            position: relative;
        }
        /* Dropdown Caret Styling (CSS only) */
        .primary-nav .nav-link.dropdown-toggle::after {
            display: inline-block;
            margin-left: .255em;
            vertical-align: .255em;
            content: "";
            border-top: .3em solid;
            border-right: .3em solid transparent;
            border-bottom: 0;
            border-left: .3em solid transparent;
            position: absolute;
            right: 10px; 
            top: 50%;
            transform: translateY(-50%);
        }
        
        /* Dropdown Item Styling */
        .primary-nav .dropdown-item {
            color: var(--text-light);
            padding: 10px 20px;
            font-weight: 400;
            display: block; 
            width: 100%;
            clear: both;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: background-color 0.2s, color 0.2s; 
        }

        /* Dropdown item hover/active */
        .primary-nav .dropdown-item:hover,
        .primary-nav .dropdown-item.active {
            background-color: var(--secondary-color); 
            color: var(--text-light);
            text-decoration: none;
        }
        
        .primary-nav .dropdown-item:last-child {
            border-bottom: none;
        }

        .user-logout-area {
            display: flex;
            align-items: center; 
            flex-shrink: 0; 
            min-height: 90px;
            padding-left: 20px; 
            border-left: 1px solid rgba(255, 255, 255, 0.1); 
        }
        
        .profile-info-container {
            display: flex;
            align-items: center;
            margin-right: 15px; 
            text-decoration: none; 
            color: var(--text-light);
            transition: all 0.3s ease-out;
        }

        .profile-info-container,
        .profile-info-container:active,
        .profile-info-container:visited {
            color: var(--text-light) !important; 
        }
        
        .profile-info-container:hover {
            transform: scale(1.03);
            opacity: 1;
            text-decoration: none;
        }
        
        .profile-text-stack {
            display: flex;
            flex-direction: column;
            align-items: flex-end; 
        }

        #ac-main-header .profile-name {
            font-weight: 700;
            font-size: 1.1rem;
            line-height: 1.2;
            white-space: nowrap; 
            color: var(--text-light) !important; 
        }

        #ac-main-header .alumni-id-text {
            /* Increased brightness and size for better visibility */
            color: rgba(255, 255, 255, 0.9) !important; 
            font-size: 0.9rem;
            font-weight: 500;
            line-height: 1.2;
            white-space: nowrap; 
        }

        /* Styling for the Alumni ID/Email using the strong tag */
        #ac-main-header .alumni-id-text strong {
            font-weight: 700; /* Ensure the actual ID/Email is highly visible */
            color: var(--text-light) !important;
        }
        
        .logout-icon-simple {
            color: var(--text-light) !important; 
            font-size: 1.6rem; 
            padding: 5px 10px;
            transition: color 0.2s, transform 0.2s;
            cursor: pointer;
        }
        
        .logout-icon-simple:hover {
            color: var(--accent-color) !important; 
            transform: scale(1.2);
        }

        .d-flex.flex-column #content-wrapper {
            padding-left: 0 !important;
        }

        /* Mobile Menu */
        
        .menu-toggle {
            display: none; 
            font-size: 2rem;
            color: var(--text-light);
            cursor: pointer;
            padding: 0 15px;
            order: 1; 
        }
        
        #menu-checkbox,
        #menu-checkbox-admin {
            display: none; 
        }

        @media (max-width: 991.98px) {
            .logo-area {
                width: 150px;
                order: 2; 
                border-right: none;
            }
            .main-nav-bar {
                padding: 5px 10px;
                justify-content: space-between;
            }
            .ac-container {
                flex-wrap: wrap; 
            }
            .ac-logo {
                height: 50px;
            }
            
            .menu-toggle {
                display: block; 
            }

            .primary-nav {
                flex-basis: 100%; 
                order: 4; 
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.4s ease-out;
                background-color: rgba(0, 0, 0, 0.2); 
            }
            
            .primary-nav ul {
                flex-direction: column;
                align-items: flex-start;
            }

            .primary-nav ul li {
                width: 100%;
                margin: 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .primary-nav ul li:last-child {
                border-bottom: none;
            }

            .primary-nav a {
                padding: 15px 20px;
                border-bottom: none;
                transform: none;
                width: 100%;
            }
            
            .primary-nav a:hover {
                background-color: var(--secondary-color);
            }

            .primary-nav .active-link {
                border-bottom: none; 
                background-color: var(--secondary-color);
            }
            
            /* Pure CSS Mobile Dropdown */
            .primary-nav .nav-item .dropdown-menu {
                position: static; 
                display: block; 
                opacity: 1;
                visibility: visible;
                background-color: rgba(0, 0, 0, 0.2);
                border-top: none;
                border-radius: 0;
                min-width: 100%;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-in-out;
            }

            .primary-nav .nav-item.dropdown .dropdown-toggle:focus + .dropdown-menu,
            .primary-nav .nav-item.dropdown:hover .dropdown-menu {
                max-height: 300px; 
            }

            .primary-nav .dropdown-item {
                padding-left: 40px; 
                border-top: 1px solid rgba(255, 255, 255, 0.05);
            }
            
            .primary-nav .nav-link.dropdown-toggle::after {
                right: 20px;
            }

            /* Toggle the menu based on the hidden checkbox state */
            #menu-checkbox:checked ~ .main-nav-bar .primary-nav,
            #menu-checkbox-admin:checked ~ .main-nav-bar .primary-nav {
                max-height: 400px; 
            }

            .user-logout-area {
                order: 3; 
                min-height: auto;
                padding-left: 10px;
                border-left: none;
            }
            
            .profile-info-container {
                display: none; 
            }
        }
        
    </style>

</head>

<body id="page-top">
<?php 
if($this->session->userdata('role') == 'alumni'){ 
?>
    <div id="wrapper">
        
        <header id="ac-main-header">
            <div class="ac-container">
                <div class="logo-area">
                    <a href="<?php echo base_url('PostController'); ?>">
                        <img src="<?php echo base_url('assets/images/small_logo.png'); ?>" alt="AConnect Logo" class="ac-logo">
                    </a>
                </div>

                <input type="checkbox" id="menu-checkbox">

                <div class="main-nav-bar">
                    <label for="menu-checkbox" class="menu-toggle"><i class="fas fa-bars"></i></label>
                    <nav class="primary-nav">
                        <ul class="d-flex">
                            <li><a href="<?php echo base_url('postcontroller'); ?>" class="<?php echo is_active_segment('PostController') ? 'active-link' : ''; ?>">Homepage</a></li>
                            
                            <li><a href="<?php echo base_url('profile'); ?>" class="<?php echo is_active_segment('profile') ? 'active-link' : ''; ?>">My Profile</a></li>
                            
                            <li><a href="<?php echo base_url('jobs'); ?>" class="<?php echo is_active_segment('jobs') ? 'active-link' : ''; ?>">Jobs</a></li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?php echo $connect_active ? 'active-link' : ''; ?>" href="#" id="connectDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Connect</a> 
                                <div class="dropdown-menu" aria-labelledby="connectDropdown">
                                    <a class="dropdown-item <?php echo is_active_segment('alumni') ? 'active' : ''; ?>" href="<?php echo base_url('alumni'); ?>">Search Alumni</a>
                                    <a class="dropdown-item <?php echo is_active_segment('alumni_request') ? 'active' : ''; ?>" href="<?php echo base_url('alumni_request'); ?>">Connect Requests</a>
                                    <a class="dropdown-item <?php echo is_active_segment('chat') ? 'active' : ''; ?>" href="<?php echo base_url('chat'); ?>">Inbox/Chat</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?php echo $events_active ? 'active-link' : ''; ?>" href="#" id="eventsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Events</a>
                                <div class="dropdown-menu" aria-labelledby="eventsDropdown">
                                    <a class="dropdown-item <?php echo is_active_segment('events') ? 'active' : ''; ?>" href="<?php echo base_url('events'); ?>">Upcoming Events</a>
                                    <a class="dropdown-item <?php echo is_active_segment('eventsprevious') ? 'active' : ''; ?>" href="<?php echo base_url('eventsprevious'); ?>">Previous Events</a>
                                </div>
                            </li>

                            <li><a href="<?php echo base_url('dashboard'); ?>" class="<?php echo is_active_segment('dashboard') ? 'active-link' : ''; ?>">About Us</a></li>

                            <li><a href="<?php echo base_url('support'); ?>" class="<?php echo is_active_segment('support') ? 'active-link' : ''; ?>">Chat Support</a></li>

                        </ul>
                    </nav>

                    <div class="user-logout-area">
                        
                        <a href="<?php echo base_url('profile'); ?>" class="profile-info-container" title="View Profile">
                            <div class="profile-text-stack">
                                <span class="profile-name">
                                    <?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?>
                                </span>
                                
                            </div>
                        </a>

                        <a href="<?php echo base_url('login/logout'); ?>" class="logout-icon-simple" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

<?php 
} 
?>

<?php 
if($this->session->userdata('role') == 'administrator'){ 
?>
    <div id="wrapper">
        
        <header id="ac-main-header">
            <div class="ac-container">
                <div class="logo-area" style="width: 300px;">
                    <a href="<?php echo base_url('AdminDashboard'); ?>">
                        <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="AConnect Admin Logo" class="ac-logo">
                    </a>
                </div>

                <input type="checkbox" id="menu-checkbox-admin">

                <div class="main-nav-bar">
                    <label for="menu-checkbox-admin" class="menu-toggle"><i class="fas fa-bars"></i></label>
                    
                    <nav class="primary-nav">
                        <ul class="d-flex">
                            <li><a href="<?php echo base_url('AdminDashboard'); ?>" class="<?php echo is_active_segment('AdminDashboard') ? 'active-link' : ''; ?>">Dashboard</a></li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?php echo $admin_management_active ? 'active-link' : ''; ?>" href="#" id="adminManageDropdown" role="button" aria-haspopup="true" aria-expanded="false" tabindex="0">Management</a>
                                <div class="dropdown-menu" aria-labelledby="adminManageDropdown">
                                    <a class="dropdown-item <?php echo is_active_segment('adminalumni') ? 'active' : ''; ?>" href="<?php echo base_url('adminalumni'); ?>">Alumni List</a>
                                    <a class="dropdown-item <?php echo is_active_segment('AdminJobPosting') ? 'active' : ''; ?>" href="<?php echo base_url('AdminJobPosting'); ?>">Job Posting</a>
                                    <a class="dropdown-item <?php echo is_active_segment('AdminEvents') ? 'active' : ''; ?>" href="<?php echo base_url('AdminEvents'); ?>">Events</a>
                                    <a class="dropdown-item <?php echo is_active_segment('AdminPost') ? 'active' : ''; ?>" href="<?php echo base_url('AdminPost'); ?>">Posting</a>
                                </div>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?php echo $admin_system_active ? 'active-link' : ''; ?>" href="#" id="adminSystemDropdown" role="button" aria-haspopup="true" aria-expanded="false" tabindex="0">System</a>
                                <div class="dropdown-menu" aria-labelledby="adminSystemDropdown">
                                    <a class="dropdown-item <?php echo is_active_segment('AdminManageAccounts') ? 'active' : ''; ?>" href="<?php echo base_url('AdminManageAccounts'); ?>">User Accounts</a>
                                    <a class="dropdown-item <?php echo is_active_segment('AdminActivityLog') ? 'active' : ''; ?>" href="<?php echo base_url('AdminActivityLog'); ?>">Activity Log</a>
                                </div>
                            </li>

                            <li><a href="<?php echo base_url('support/admin_inbox'); ?>" class="<?php echo is_active_segment('support', 'admin_inbox') ? 'active-link' : ''; ?>">Chat Support</a></li>
                            <li><a href="<?php echo base_url('AdminReports'); ?>" class="<?php echo is_active_segment('AdminReports') ? 'active-link' : ''; ?>">Reports & Analytics</a></li>
                            
                        </ul>
                    </nav>

                    <div class="user-logout-area">
                        <a href="#" class="profile-info-container" title="Administrator">
                            <div class="profile-text-stack">
                                <span class="profile-name">
                                    Administrator
                                </span>
                                <span class="alumni-id-text">
                                    User: <strong><?php echo $this->session->userdata('email'); ?></strong>
                                </span>
                            </div>
                        </a>

                        <a href="<?php echo base_url('AdminLogin/logout'); ?>" class="logout-icon-simple" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

<?php 
}
?>