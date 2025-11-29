<?php
// Define the maroon color variables based on the app's visual identity
$primary_color = '#700A0A'; // Deep Maroon
// $primary_hover = '#A91B1B'; // REMOVED: We will use a calculated hover effect
$text_light = '#FFFFFF';    // Stark white for high contrast text

// Helper for active link checking, assuming $this is available (CodeIgniter view context)
$current_uri_segment_1 = property_exists($this, 'uri') ? $this->uri->segment(1) : '';
$current_uri_segment_2 = property_exists($this, 'uri') ? $this->uri->segment(2) : '';

// Function to check if a navigation segment is currently active
function is_active_segment($segment1, $segment2 = null) {
    global $current_uri_segment_1, $current_uri_segment_2;

    if ($segment2 === null) {
        return $current_uri_segment_1 === $segment1;
    }
    return $current_uri_segment_1 === $segment1 && $current_uri_segment_2 === $segment2;
}

// Check for active parent links (for dropdowns)
$connect_active = in_array($current_uri_segment_1, ['alumni', 'alumni_request', 'chat']);
$events_active = in_array($current_uri_segment_1, ['events', 'eventsprevious']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>APP NAME</title>
    <!-- Keep existing external CSS links -->
    <link href="<?php echo base_url('assets/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/user/post.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Custom Modern Sidebar Styles (Social Media Look) -->
    <style>
        /* 1. Base Sidebar Style - Deep Maroon with Subtle Depth */
        .sidebar.bg-gradient-primary, 
        .sidebar.sidebar-dark.accordion {
            background-color: <?php echo $primary_color; ?> !important;
            background-image: linear-gradient(180deg, <?php echo $primary_color; ?> 10%, #4D0707 100%) !important; /* Slight gradient for depth */
            color: <?php echo $text_light; ?>;
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smoother transition */
            box-shadow: 5px 0 20px rgba(0, 0, 0, 0.4); /* Stronger, modern shadow */
        }

        /* 2. Profile Section - Focus on Clarity and Visual Pop */
        .sidebar .sidebar-brand {
            height: auto;
            padding: 30px 10px 20px 10px; 
            border-bottom: 2px solid rgba(255, 255, 255, 0.2); /* Thicker, defined divider */
            margin-bottom: 15px;
            font-family: 'Nunito', sans-serif;
            letter-spacing: 0.5px;
        }

        .sidebar .img-profile {
            box-shadow: 0 0 0 5px rgba(255, 255, 255, 0.5), 0 0 15px <?php echo $primary_color; ?>; /* White ring + Maroon glow */
            width: 4rem; 
            height: 4rem; 
            transition: transform 0.3s ease-out;
        }

        .sidebar .img-profile:hover {
            transform: scale(1.05) rotate(3deg);
        }

        /* 3. Nav Item Styles - Clean Lines and Animation Ready */
        .sidebar .nav-item .nav-link {
            color: <?php echo $text_light; ?>;
            padding: 14px 20px; 
            border-radius: 8px; /* Slightly more rounded */
            margin: 8px 15px;
            font-weight: 600; 
            font-size: 1rem;
            position: relative;
            overflow: hidden; /* For the slide-in effect */
            transition: all 0.3s ease-in-out;
            z-index: 1;
        }

        /* Pseudo-element for hover effect (Maroon slide) */
        .sidebar .nav-item .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.2) 100%);
            z-index: -1;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        /* Nav Item Hover/Active Styles (Parent Links) */
        .sidebar .nav-item .nav-link:hover {
            color: white;
            background-color: transparent; /* Rely on pseudo-element */
            transform: translateX(3px); /* Small translation for feedback */
        }

        .sidebar .nav-item .nav-link:hover::before {
            transform: translateX(0);
        }
        
        /* Active State - Bold and Distinct */
        .sidebar .nav-item.active .nav-link {
            color: <?php echo $primary_color; ?>; /* Dark text */
            background-color: white; /* White background */
            font-weight: 800;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3), 0 0 10px rgba(255, 255, 255, 0.7) inset; /* Double shadow for pop */
            border-left: 5px solid gold; /* Unique active border */
            transform: scale(1.01); /* Subtle 3D push */
            transition: all 0.2s ease;
        }

        .sidebar .nav-item.active .nav-link::before {
            display: none; /* Hide hover effect on active state */
        }

        /* Active link icon color */
        .sidebar .nav-item.active .nav-link i {
            color: <?php echo $primary_color; ?> !important; 
            filter: drop-shadow(0 0 2px #700A0A);
        }

        /* 4. Sidebar Heading */
        .sidebar-heading {
            color: rgba(255, 255, 255, 0.85); 
            padding: 15px 20px 8px 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 20px 0;
            border-style: dotted; /* Unique divider style */
        }

        /* 5. Collapsible Menu (Sub-menu) Styles - Contextual and Clear */
        .sidebar .collapse-inner {
            background-color: rgba(0, 0, 0, 0.35) !important; /* Darker, more prominent sub-menu background */
            padding: 10px 0;
            margin: 5px 15px 15px 15px;
            border-radius: 10px; /* More pronounced rounding */
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5); /* Inner shadow for depth */
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Sub-menu link items (Enforced White) */
        .sidebar .collapse-inner .collapse-item {
            color: #FFFFFF !important; 
            padding: 10px 20px 10px 35px; /* Deeper indentation */
            font-size: 0.9rem;
            border-left: 3px solid transparent;
            transition: all 0.2s ease-out;
        }

        .sidebar .collapse-inner .collapse-item:hover {
            color: #FFFFFF !important; 
            background-color: rgba(255, 255, 255, 0.2); /* Brighter hover overlay */
            border-left: 3px solid #ffcc00; /* Gold highlight on hover */
            transform: translateX(5px); /* Slide effect */
        }

        .sidebar .collapse-inner .collapse-item.active {
            color: #FFFFFF !important; 
            background-color: rgba(255, 255, 255, 0.3); /* Strong active background */
            border-left: 5px solid white; /* Stronger active border */
            font-weight: 700;
        }

        /* 6. Sidebar Toggle Button */
        #sidebarToggle {
            background-color: rgba(255, 255, 255, 0.3) !important;
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
            transition: transform 0.3s ease;
        }

        #sidebarToggle:hover {
            transform: rotate(90deg) scale(1.1);
            background-color: white !important;
        }
    </style>

</head>

<body id="page-top">
<?php if($this->session->userdata('role') == 'alumni'){ ?>
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            
            <!-- Profile/Logo Section (Simplified) -->
            <a class="sidebar-brand d-flex flex-column align-items-center" href="profile">
                <div class="sidebar-brand-icon rotate-n-0 text-center">
                    <?php 
                    $profile_img_src = $this->session->userdata('profile_image') 
                        ? base_url('assets/uploads/alumni/' . $this->session->userdata('profile_image'))
                        : base_url('assets/images/person-male.png');
                    ?>
                    <img class="img-profile rounded-circle" src="<?php echo $profile_img_src; ?>" alt="Profile Image" style="object-fit: cover;">
                </div>
                <div class="sidebar-brand-text mx-3 mt-2 text-center" style="font-size: 1rem; font-weight: 600; color: <?php echo $text_light; ?>;">
                    <?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?>
                </div>
                <div class="sidebar-brand-text mx-3 text-center" style="color: rgba(255, 255, 255, 0.7); font-size: 0.8rem;">
                    Alumni ID: <?php echo $this->session->userdata('alumni_number'); ?>
                </div>
            </a>
            
            <hr class="sidebar-divider my-0">

            <div class="sidebar-heading">
                Navigation
            </div>

            <!-- Homepage -->
            <li class="nav-item <?php echo is_active_segment('PostController') ? 'active' : ''; ?>">
                <a class="nav-link" href="PostController">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Homepage</span>
                </a>
            </li>

            <!-- My Profile -->
            <li class="nav-item <?php echo is_active_segment('profile') ? 'active' : ''; ?>">
                <a class="nav-link" href="profile">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>My Profile</span>
                </a>
            </li>

            <!-- Jobs -->
            <li class="nav-item <?php echo is_active_segment('jobs') ? 'active' : ''; ?>">
                <a class="nav-link" href="jobs">
                    <i class="fas fa-fw fa-briefcase"></i>
                    <span>Jobs</span>
                </a>
            </li>

            <!-- Connect (Collapsible) -->
            <li class="nav-item <?php echo $connect_active ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="<?php echo $connect_active ? 'true' : 'false'; ?>" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Connect</span>
                </a>
                <div id="collapseUtilities" class="collapse <?php echo $connect_active ? 'show' : ''; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="collapse-inner rounded">
                        <a class="collapse-item <?php echo is_active_segment('alumni') ? 'active' : ''; ?>" href="alumni">Search Alumni</a>
                        <a class="collapse-item <?php echo is_active_segment('alumni_request') ? 'active' : ''; ?>" href="alumni_request">Connect Requests</a>
                        <a class="collapse-item <?php echo is_active_segment('chat') ? 'active' : ''; ?>" href="chat">Inbox/Chat</a>
                    </div>
                </div>
            </li>

            <!-- Events (Collapsible) -->
            <li class="nav-item <?php echo $events_active ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="<?php echo $events_active ? 'true' : 'false'; ?>" aria-controls="collapseUtilities2">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span>Events</span>
                </a>
                <div id="collapseUtilities2" class="collapse <?php echo $events_active ? 'show' : ''; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="collapse-inner rounded">
                        <a class="collapse-item <?php echo is_active_segment('events') ? 'active' : ''; ?>" href="events">Upcoming Events</a>
                        <a class="collapse-item <?php echo is_active_segment('eventsprevious') ? 'active' : ''; ?>" href="eventsprevious">Previous Events</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <!-- About Us -->
            <li class="nav-item <?php echo is_active_segment('dashboard') ? 'active' : ''; ?>">
                <a class="nav-link" href="dashboard">
                    <i class="fas fa-fw fa-info-circle"></i>
                    <span>About Us</span>
                </a>
            </li>

            <!-- Chat Support -->
            <li class="nav-item <?php echo is_active_segment('support') ? 'active' : ''; ?>">
                <a class="nav-link" href="support">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Chat Support</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('login/logout'); ?>">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
            
            <!-- Sidebar Toggle -->
            <div class="text-center d-none d-md-inline pt-3">
                <button class="rounded-circle border-0" id="sidebarToggle" style="background-color: rgba(255, 255, 255, 0.2);"></button>
            </div>

        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Topbar (Kept light/white as per SB Admin 2 standard) -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                    </ul>
                </nav>
<?php }?>


<?php if($this->session->userdata('role') == 'administrator'){ ?>
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            
            <!-- Admin Profile Section -->
            <a class="sidebar-brand d-flex flex-column align-items-center" href="#">
                <div class="sidebar-brand-icon rotate-n-0 text-center">
                    <?php 
                    $profile_img_src_admin = $this->session->userdata('profile_image') 
                        ? base_url('uploads/alumni/' . $this->session->userdata('profile_image'))
                        : base_url('assets/images/person-male.png');
                    ?>
                    <img class="img-profile rounded-circle" src="<?php echo $profile_img_src_admin; ?>" alt="Profile Image" style="object-fit: cover;">
                </div>
                <div class="sidebar-brand-text mx-3 mt-2 text-center" style="font-size: 1rem; font-weight: 600; color: <?php echo $text_light; ?>;">
                    <?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?>
                </div>
                <div class="sidebar-brand-text mx-3 text-center" style="color: rgba(255, 255, 255, 0.7); font-size: 0.8rem;">
                    Admin Email: <?php echo $this->session->userdata('email'); ?>
                </div>
            </a>
            
            <hr class="sidebar-divider my-0">
            
            <div class="sidebar-heading">
                Main
            </div>

            <!-- Dashboard -->
            <li class="nav-item <?php echo is_active_segment('AdminDashboard') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('AdminDashboard'); ?>" >
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Management
            </div>

            <!-- Alumni List -->
            <li class="nav-item <?php echo is_active_segment('adminalumni') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('adminalumni'); ?>" >
                    <i class="fas fa-fw fa-database"></i>
                    <span>Alumni List</span>
                </a>
            </li>

            <!-- Job Posting -->
            <li class="nav-item <?php echo is_active_segment('AdminJobPosting') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('AdminJobPosting'); ?>" >
                    <i class="fas fa-fw fa-briefcase"></i>
                    <span>Job Posting</span>
                </a>
            </li>

            <!-- Events -->
            <li class="nav-item <?php echo is_active_segment('AdminEvents') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('AdminEvents'); ?>" >
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span>Events</span>
                </a>
            </li>

            <!-- Posting -->
            <li class="nav-item <?php echo is_active_segment('AdminPost') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('AdminPost'); ?>">
                    <i class="fas fa-fw fa-pen-square"></i>
                    <span>Posting</span>
                </a>
            </li>
            
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                System
            </div>

            <!-- User Management -->
            <li class="nav-item <?php echo is_active_segment('AdminManageAccounts') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('AdminManageAccounts'); ?>">
                    <i class="fas fa-fw fa-user-shield"></i>
                    <span>User Accounts</span>
                </a>
            </li>

            <!-- Activity Log -->
            <li class="nav-item <?php echo is_active_segment('AdminActivityLog') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('AdminActivityLog'); ?>">
                    <i class="fas fa-fw fa-history"></i>
                    <span>Activity Log</span>
                </a>
            </li>

            <!-- Chat Support -->
            <li class="nav-item <?php echo is_active_segment('support', 'admin_inbox') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('support/admin_inbox'); ?>">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Chat Support</span>
                </a>
            </li>

            <!-- Logout -->
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('AdminLogin/logout'); ?>">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
    
            <!-- Sidebar Toggle -->
            <div class="text-center d-none d-md-inline pt-3">
                <button class="rounded-circle border-0" id="sidebarToggle" style="background-color: rgba(255, 255, 255, 0.2);"></button>
            </div>

        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                    </ul>

                </nav>
<?php }?>