<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>APP NAME</title>
    <link href="<?php echo base_url('assets/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/user/post.css'); ?>" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body id="page-top">
<?php if($this->session->userdata('role') == 'alumni'){ ?>
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" style="padding-top: 50px; padding-bottom: 40px;" href="profile">
                <div class="sidebar-brand-icon rotate-n-0">

                    <?php if ($this->session->userdata('profile_image')): ?>
                        <img class="img-profile rounded-circle" src="<?php echo base_url('assets/uploads/alumni/' . $this->session->userdata('profile_image')); ?>" style="width: 4rem; height: 4rem; object-fit: cover;">
                    <?php else: ?>
                        <img  style="border-radius: 50%;" src="<?php echo base_url('assets/images/person-male.png'); ?>" alt="My Photo">
                    <?php endif; ?>
                </div>
                <div class="sidebar-brand-text mx-3 " style="color: #fff;">
                    <?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?>
                </div>
            </a>
            <div class="sidebar-brand-text mx-3" style="width:100%; color: #fff;">
                    Alumni ID: <?php echo $this->session->userdata('alumni_number'); ?><br>

                </div>
            <hr class="sidebar-divider my-0">


           

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'PostController') ? 'active' : ''; ?>">
                <a class="nav-link collapsed " href="PostController" >
                    <i class="fas fa-fw fas fa-chalkboard "></i>
                    <span>Homepage</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Menu
            </div>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'profile') ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="profile" >
                    <i class="fas fa-fw fas fa-address-card"></i>
                    <span>My Profile</span>
                </a>
            </li>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'jobs') ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="jobs" >
                    <i class="fas fa-fw fas fa-suitcase "></i>
                    <span>Jobs</span>
                </a>
            </li>

            <?php
            $seg1 = $this->uri->segment(1); // e.g. "user"
            $seg2 = $this->uri->segment(2); // e.g. "profile"
            $seg3 = $this->uri->segment(3); // e.g. "profile"
            ?>

            <li class="nav-item <?php echo ($seg1 == 'alumni' && $seg2 == 'alumni_request') ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fas fa-users "></i>
                    <span>Connect</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?php echo ($this->uri->segment(1) == 'alumni') ? 'active' : ''; ?>" href="alumni">Search</a>
                        <a class="collapse-item <?php echo ($this->uri->segment(1) == 'alumni_request') ? 'active' : ''; ?>" href="alumni_request">Connect Request</a>
                        <a class="collapse-item <?php echo ($this->uri->segment(1) == 'chat') ? 'active' : ''; ?>" href="chat">Inbox</a>
                    </div>
                </div>
            </li>

            <li class="nav-item <?php echo ($seg1 == 'alumni' && $seg2 == 'alumni_request') ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities2">
                    <i class="fas fa-fw fas fa-calendar-alt "></i>
                    <span>Events</span>
                </a>
                <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?php echo ($this->uri->segment(1) == 'events') ? 'active' : ''; ?>" href="events">Upcoming Events</a>
                        <a class="collapse-item <?php echo ($this->uri->segment(1) == 'alumni_request') ? 'active' : ''; ?>" href="eventsprevious">Previous Events</a>
                        
                    </div>
                </div>
            </li>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'dashboard') ? 'active' : ''; ?>">
                <a class="nav-link" href="dashboard">
                    <i class="fas fa-fw fas fa-info-circle"></i>
                    <span>About Us</span></a>
            </li>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'support') ? 'active' : ''; ?>">
                <a class="nav-link" href="support">
                    <i class="fas fa-fw fas fa-comment"></i>
                    <span>Chat Support</span></a>
            </li>

    
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('login/logout'); ?>">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    <span>Logout</span>
                </a>
            </li>
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
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


<?php if($this->session->userdata('role') == 'administrator'){ ?>
                <div id="wrapper">
                    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                        <a class="sidebar-brand d-flex align-items-center justify-content-center" style="padding-top: 80px; padding-bottom: 50px;" href="#">
                            <div class="sidebar-brand-icon rotate-n-0">

                                <?php if ($this->session->userdata('profile_image')): ?>
                                    <img class="img-profile rounded-circle" src="<?php echo base_url('uploads/alumni/' . $this->session->userdata('profile_image')); ?>" style="width: 2rem; height: 2rem; object-fit: cover;">
                                <?php else: ?>
                                    <img  style="border-radius: 50%;" src="<?php echo base_url('assets/images/person-male.png'); ?>" alt="My Photo">
                                <?php endif; ?>
                            </div>
                            <div class="sidebar-brand-text mx-3">
                                <?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?>
                            </div>
                        </a>
                        <div class="sidebar-brand-text mx-3" style="width:100%; color: #fff;">
                         Email: <?php echo $this->session->userdata('email'); ?><br>
                            </div>
                        <hr class="sidebar-divider my-0">


            <li class="nav-item <?php echo ($this->uri->segment(1) == 'AdminDashboard') ? 'active' : ''; ?>">
                <a class="nav-link collapsed " href="<?php echo base_url('AdminDashboard'); ?>" >
                    <i class="fas fa-fw fa-tachometer-alt "></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Menu
            </div>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'adminalumni') ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="<?php echo base_url('adminalumni'); ?>" >
                    <i class="fas fa-fw fa-database "></i>
                    <span>Alumni List</span>
                </a>
            </li>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'AdminJobPosting') ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="<?php echo base_url('AdminJobPosting'); ?>" >
                    <i class="fas fa-fw fa-suitcase "></i>
                    <span>Job Posting</span>
                </a>
            </li>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'AdminEvents') ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="<?php echo base_url('AdminEvents'); ?>" >
                    <i class="fas fa-fw fa-calendar-alt "></i>
                    <span>Events</span>
                </a>
            </li>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'AdminPost') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('AdminPost'); ?>">
                    <i class="fas fa-fw fas fa-pen-square"></i>
                    <span>Posting</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Options
            </div>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'AdminManageAccounts') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('AdminManageAccounts'); ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>User Management</span></a>
            </li>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'AdminActivityLog') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('AdminActivityLog'); ?>">
                    <i class="fas fa-fw fas fa-eye"></i>
                    <span>Activity Log</span></a>
            </li>

            <li class="nav-item <?php echo ($this->uri->segment(1) == 'support/admin_inbox') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('support/admin_inbox'); ?>">
                    <i class="fas fa-fw fas fa-comment"></i>
                    <span>Chat Support</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

       
        <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('AdminLogin/logout'); ?>">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    <span>Logout</span>
                </a>
            </li>
   


            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
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