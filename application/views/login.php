<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="User Login Page">
    <title>AConnect | Alumni Login</title>

    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- FontAwesome (icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    /* (your existing styles — kept identical) */
    html, body { min-height: 100%; margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; }
    .login-page { display: flex; min-height: 100vh; background-color: #f7f7f7; }
    .container-fluid { display: flex; width: 100%; max-width: none !important; height: 100vh; padding: 0 !important; margin: 0 !important; }
    .row_container { display: flex !important; width: 100%; margin: 0 !important; }
    .image-container {
        flex: 0 0 50vw;
        position: relative;
        overflow: hidden;
        height: 100vh;
        background-color: #920E0E;
        padding: 0 !important;
    }

    .login-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-container { 
    flex: 0 0 50vw; 
    display: flex; 
    flex-direction: column; 
    align-items: center;
    justify-content: center;
    padding: 30px;
    min-height: 100vh;
    background-color: #fff;

    /* 🔥 ADD THESE */
    text-align: center;
}

    .login-logo-container { text-align: center; margin-bottom: 0.5rem; }
    .login-logo { max-width: 200px; height: auto; }
    .branding-text { text-align: center; margin-bottom: 2rem; max-width: 350px; }
    .branding-text h1 { font-size: 1.8rem; font-weight: 700; color: #333; margin-bottom: 0.5rem; }
    .branding-text p { font-size: 0.95rem; color: #6c757d; }
    .form-signin {
    width: 100%;
    max-width: 380px;
    margin: 0 auto; /* 🔥 THIS CENTERS THE CARD */
}

    .form-control { border-radius: 5px; height: 48px; padding: 10px 15px; margin-bottom: 15px; width: 100%; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; border: 1px solid #ddd; }
    .form-control:focus { border-color: #700A0A; box-shadow: 0 0 0 0.15rem rgba(112, 10, 10, 0.2); }
    .form-label-group label { display: none; }
    .checkbox.mb-3 { margin-bottom: 1rem !important; display: flex; align-items: center; font-size: 0.9rem; }
    .checkbox.mb-3 input[type="checkbox"] { margin-right: 8px; width: 16px; height: 16px; }
    .btn-block { width: 100%; background-color: #700A0A !important; border: none; height: 48px; font-size: 1rem; text-transform: uppercase; font-weight: 600; border-radius: 5px; transition: background-color 0.2s ease; }
    .btn-block:hover { background-color: #550808 !important; }
    .register-link { margin-top: 2rem !important; padding-top: 15px; border-top: 1px solid #eee; }
    .register-link p { text-align: center; font-size: 0.9rem; margin-bottom: 5px; color: #6c757d; }
    .register-link a { color: #700A0A; text-decoration: none; font-weight: 600; transition: text-decoration 0.2s ease; }
    .register-link a:hover { text-decoration: underline; }
    .btn-outline-dark { color: #000; border: 1px solid #ccc; background-color: transparent; padding: 8px 15px; font-size: 0.9rem; line-height: 1.2; border-radius: 5px; transition: all 0.2s ease; }
    .btn-outline-dark:hover { background-color: #f0f0f0; border-color: #700A0A; color: #000; }
    @media screen and (max-width: 767.98px) {

    html, body {
        overflow: auto;
        height: auto;
    }
    body.login-page {
    overflow-y: auto;
    }
    .login-page {
        min-height: 100dvh; /* 🔥 modern mobile fix */
    }


    /* 🔥 IMAGE BECOMES FULL BACKGROUND */
    .image-container {
        display: block !important;
        position: fixed;
        inset: 0;
        width: 100vw;
        height: 100vh;
        z-index: 0;
    }

    .image-container::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.45); /* dark overlay for readability */
    }

    /* 🔥 FLOATING CENTER FORM */
    .form-container {
    position: relative;
    z-index: 2;
    flex: 0 0 100vw;

    /* 🔥 CRITICAL FIX */
    min-height: auto;
    height: auto;
    padding: 40px 20px;

    background: transparent;

    display: flex;
    align-items: flex-start; /* 🔥 WAS center */
    justify-content: center;

    overflow-y: auto; /* 🔥 ALLOW SCROLL */
}

       


    /* 🔥 GLASS LOGIN CARD EFFECT */
    .form-signin {
        width: 100%;
        max-width: 380px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    }

    /* 🔥 LOGIN HEADER (inside card) */
    .login-header {
        width: 100%;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }

    /* 🔥 RESPONSIVE CENTERED LOGO */
    .login-logo {
        display: block;
        margin: 0 auto 10px auto;
        max-width: 110px;
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    /* 🔥 BRANDING TEXT ALIGNMENT */
    .branding-text {
        text-align: center;
        margin: 0 auto;
        max-width: 280px;
    }

    .branding-text p {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0;
    }
    /* 📱 MOBILE LOGO TUNING */
    @media screen and (max-width: 767.98px) {

        .login-logo {
            max-width: 150px;
            margin-bottom: 8px;
        }

        .login-header {
            margin-bottom: 14px;
        }

        .branding-text {
            max-width: 260px;
        }
        
    }

        @media (min-width: 992px) {
            .login-logo {
                max-width: 130px;
            }
        }
    

    </style>
</head>
<body class="login-page">
    <div class="container-fluid">
        <div class="row row_container">
            <div class="col-md-6 image-container">
                <img src="<?php echo base_url('assets/images/welcome.png'); ?>" class="login-image" alt="AConnect Platform Visual">
            </div>

            <div class="col-md-6 form-container">
               

                <!-- Flash messages via SweetAlert2 -->
                <?php if ($this->session->flashdata('success_message')): ?>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ icon: 'success', title: 'Success', text: <?= json_encode($this->session->flashdata('success_message')) ?>, confirmButtonText: 'OK' });
                    });
                    </script>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error_message')): ?>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: <?= json_encode($this->session->flashdata('error_message')) ?>, confirmButtonText: 'OK' });
                    });
                    </script>
                <?php endif; ?>

                <!-- If controller passes $error_message variable, show it inline too (backup) -->
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger text-center" role="alert" style="width:100%;max-width:350px;margin-bottom:1rem;border-radius:5px;">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                    <form class="form-signin" method="post" action="<?php echo site_url('Login/user'); ?>">

                    <!-- 🔥 LOGO + BRANDING INSIDE CARD -->
                    <div class="login-header">
                        <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="AC Connect Logo" class="login-logo">

                        <div class="branding-text">
                            
                            <p>Connect with your fellow alumni and unlock exclusive career opportunities.</p>
                        </div>
                    </div>

                    <div class="form-label-group">
                        <input type="text" id="student_number" name="student_number" class="form-control" placeholder="Student Number" required autofocus value="<?= set_value('student_number') ?>">
                    </div>

                    <div class="form-label-group">
                        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                    </div>

                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Keep me signed in
                        </label>
                    </div>

                    <button class="btn btn-lg btn-primary btn-block" type="submit">Log in to AConnect</button>
                    <div class="register-link">
                        <p>New to AConnect? <a href="<?= base_url('register') ?>">Create an Account</a></p>
                    </div>

                    <div class="text-center mt-3">
                        <a href="<?= base_url('adminlogin'); ?>" class="btn btn-sm btn-outline-dark">
                            Admin Portal
                        </a>
                    </div>

                    <div class="text-center mt-3">
                        <a href="#" data-toggle="modal" data-target="#resendModal">Resend verification email</a>
                    </div>
                    
                </form>
                
            </div>
        </div>
    </div>

    <!-- Resend Verification Modal -->
    <div class="modal fade" id="resendModal" tabindex="-1" role="dialog" aria-labelledby="resendModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <form method="post" action="<?= base_url('register/resend_verification') ?>">
            <div class="modal-header">
              <h5 class="modal-title" id="resendModalLabel">Resend Verification</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="resend_email">Enter your registered email</label>
                    <input type="email" name="email" id="resend_email" class="form-control" required placeholder="name@domain.com" value="<?= set_value('email') ?>">
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" style="background:#700A0A;border:none">Resend</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php if($this->session->flashdata('email_debug')): ?>
  <pre><?php echo $this->session->flashdata('email_debug'); ?></pre>
<?php endif; ?>

    <!-- JS: jQuery + Bootstrap Bundle -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>
