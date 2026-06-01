<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Employer Login Page for AConnect">
    <title>AConnect | Employer Login</title>

    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <!-- FontAwesome (icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
    /* Global/Layout Styles - Enforce no scroll and full height */
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        background-color: #f7f7f7; 
        overflow-x: hidden; 
        overflow-y: hidden;
    }

    .login-page {
        display: flex;
        min-height: 100vh;
        width: 100%;
    }

    .container-fluid {
        display: flex;
        width: 100vw; 
        min-height: 100vh;
        margin: 0 !important;
        padding: 0 !important;
    }

    .row_container {
        display: flex !important;
        width: 100%;
        margin: 0 !important; 
    }

    /* Left Side: Image Container (Maroon) */
    .image-container {
        flex: 0 0 50%;
        max-width: 50%; 
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        min-height: 100vh;
        background-color: #920E0E; /* Deep Red/Maroon color */
        padding: 0 !important;
    }

    .login-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Right Side: Form Container (White) */
    .form-container {
        position: relative;
        flex: 0 0 50%;
        max-width: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px 30px; 
        background-color: #fff; 
        min-height: 100vh;
        box-sizing: border-box;
    }

    /* Back Button Container */
    .back-button-container {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 10;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f0f0f0;
        border: none;
        color: #333;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.2s ease;
        text-decoration: none;
    }

    .back-button:hover {
        background-color: #e0e0e0;
        transform: scale(1.05);
    }

    .login-logo-container {
        text-align: center;
        margin-bottom: 0.5rem;
    }

    .login-logo {
        max-width: 150px; 
        height: auto;
    }

    .login-form-wrapper {
        width: 100%;
        max-width: 400px;
    }

    .login-form-wrapper h1 {
        text-align: center;
        font-size: 1.6rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 2.5rem;
    }
    
    /* Input Fields Styling */
    .form-control {
        border-radius: 5px; 
        height: 44px;
        padding: 10px 15px;
        margin-bottom: 15px; 
        width: 100%; 
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        border: 1px solid #ddd; 
        box-sizing: border-box; 
    }
    
    .form-control:focus {
        border-color: #a12124;
        box-shadow: 0 0 0 0.15rem rgba(161, 33, 36, 0.2);
        outline: 0;
    }

    /* Checkbox styling */
    .form-check {
        margin-bottom: 1rem;
    }

    /* Sign In Button */
    .btn-login {
        width: 100%;
        background-color: #a12124 !important; 
        color: white;
        border: none;
        height: 48px;
        font-size: 1rem;
        text-transform: uppercase;
        font-weight: 600;
        border-radius: 5px; 
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-login:hover {
        background-color: #7d181b !important; 
    }

    .register-link {
        margin-top: 1rem;
        text-align: center;
    }

    /* Validation error */
    .validation-error {
        width: 100%;
        padding: 0.75rem;
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        font-size: 0.85rem;
        text-align: left;
        margin-bottom: 1rem;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 767.98px) {
        html, body {
            overflow-y: auto; 
        }
        .image-container {
            display: none !important;
        }
        .form-container {
            flex: 0 0 100vw;
            max-width: 100vw;
            justify-content: flex-start;
        }
    }
    </style>
</head>
<body class="login-page">
    <div class="container-fluid">
        <div class="row row_container">
            <!-- Left Half: Red Circles Background (Image) -->
            <div class="col-md-6 image-container">
                <img src="<?php echo base_url('assets/images/welcome.png'); ?>" class="login-image" alt="AConnect Platform Visual">
            </div>

            <!-- Right Half: Employer Login Form -->
            <div class="col-md-6 form-container">
                <div class="login-logo-container">
                    <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="AC Connect Logo" class="login-logo">
                </div>
                
                <div class="login-form-wrapper">
                    <h1>Employer Access</h1>
                    
                    <!-- Flash success/error messages -->
                    <?php if ($this->session->flashdata('success_message')): ?>
                    <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: <?= json_encode($this->session->flashdata('success_message')) ?>,
                            confirmButtonText: 'OK'
                        });
                      });
                    </script>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error_message')): ?>
                    <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: <?= json_encode($this->session->flashdata('error_message')) ?>,
                            confirmButtonText: 'OK'
                        });
                      });
                    </script>
                    <?php endif; ?>

                    <!-- Validation Errors -->
                    <?php if (validation_errors()): ?>
                        <div class="validation-error mb-3">
                            <?= validation_errors('<p class="mb-0">', '</p>'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form method="post" action="<?php echo base_url('employer_login/authenticate'); ?>">
                        
                        <div class="form-group">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Company Email" value="<?= set_value('email') ?>" required autofocus autocomplete="email">
                        </div>

                        <div class="form-group">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required autocomplete="current-password">
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="remember-me" id="rememberMe" name="remember_me">
                            <label class="form-check-label" for="rememberMe">
                                Remember me
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn-login" type="submit">Sign In</button>
                        </div>
                    </form>

                    <div class="register-link">
                        <p>New to AConnect? <a href="<?= base_url('employer_register'); ?>">Register here</a></p>
                    </div>

                    <div class="text-center mt-3">
                        <a href="<?= base_url('login'); ?>">Back to Alumni Login</a>
                    </div>
                                        <div class="text-center mt-2">
                                                <a href="#" data-toggle="modal" data-target="#resendModalEmployer">Resend verification email</a>
                                        </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Resend Verification Modal (Employer) -->
        <div class="modal fade" id="resendModalEmployer" tabindex="-1" role="dialog" aria-labelledby="resendModalEmployerLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form method="post" action="<?= base_url('employer_register/resend_verification') ?>">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resendModalEmployerLabel">Resend Verification</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body">
                                <div class="form-group">
                                        <label for="resend_email_employer">Enter your registered email</label>
                                        <input type="email" name="email" id="resend_email_employer" class="form-control" required placeholder="name@domain.com" value="<?= set_value('email') ?>">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" style="background:#007bff;border:none">Resend</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- jQuery + Bootstrap Bundle JS -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var resendModal = document.getElementById('resendModalEmployer');
        if (resendModal) {
            resendModal.addEventListener('shown.bs.modal', function () {
                var input = document.getElementById('resend_email_employer');
                if (input) input.focus();
            });
        }
    });
    </script>
</body>
</html>
