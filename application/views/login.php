<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="User Login Page">
    <title>AConnect | Alumni Login</title>

    <!-- Assuming Bootstrap is loaded from your assets folder -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <style>
    /* Global/Layout Styles */
    html,
    body {
        height: 100%;
        margin: 0;
        /* Use a modern, clean font stack */
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        overflow: hidden; 
    }

    .login-page {
        display: flex;
        min-height: 100vh;
        background-color: #f7f7f7; /* Very light gray background */
    }

    .container-fluid {
        display: flex;
        width: 100%;
        max-width: none !important;
        height: 100vh;
        padding: 0 !important;
        margin: 0 !important;
    }

    .row_container {
        display: flex !important;
        width: 100%;
        margin: 0 !important;
    }

    /* Left Side: Image Container (Red Circles) - KEPT AS REQUESTED */
    .image-container {
        flex: 0 0 50vw;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        height: 100vh;
        background-color: #920E0E; /* Deep Red color for the side */
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
        flex: 0 0 50vw;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 30px;
        min-height: 100vh;
        background-color: #fff; /* White background */
    }

    .login-logo-container {
        text-align: center;
        margin-bottom: 0.5rem; /* Reduced space below logo */
    }

    .login-logo {
        max-width: 200px;
        height: auto;
    }

    /* New Branding Text */
    .branding-text {
        text-align: center;
        margin-bottom: 2rem;
        max-width: 350px;
    }
    .branding-text h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .branding-text p {
        font-size: 0.95rem;
        color: #6c757d;
    }


    .form-signin {
        width: 100%;
        max-width: 350px; /* Form width */
    }

    /* Input Fields (Text Boxes) */
    .form-control {
        border-radius: 5px; /* Smoother edges */
        height: 48px; /* Slightly taller for modern look */
        padding: 10px 15px;
        margin-bottom: 15px;
        width: 100%; 
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        border: 1px solid #ddd; /* Lighter border */
    }
    
    /* Focus Styling */
    .form-control:focus {
        border-color: #700A0A; /* Maroon border on focus */
        box-shadow: 0 0 0 0.15rem rgba(112, 10, 10, 0.2); /* Subtle maroon shadow */
    }

    .form-label-group label {
        display: none; 
    }

    /* Remember Me Checkbox */
    .checkbox.mb-3 {
        margin-bottom: 1rem !important;
        display: flex;
        align-items: center;
        font-size: 0.9rem;
    }
    .checkbox.mb-3 input[type="checkbox"] {
        margin-right: 8px; /* More space */
        width: 16px;
        height: 16px;
    }

    /* Sign In Button */
    .btn-block {
        width: 100%;
        background-color: #700A0A !important; /* Maroon color */
        border: none;
        height: 48px; /* Matches input height */
        font-size: 1rem;
        text-transform: uppercase;
        font-weight: 600; /* Bolder for CTA */
        border-radius: 5px; 
        transition: background-color 0.2s ease;
    }

    .btn-block:hover {
        background-color: #550808 !important; 
    }

    /* Register and Admin Links */
    .register-link {
        margin-top: 2rem !important; /* Increased space after login button */
        padding-top: 15px;
        border-top: 1px solid #eee; /* Separator line for visual clarity */
    }
    .register-link p {
        text-align: center;
        font-size: 0.9rem;
        margin-bottom: 5px;
        color: #6c757d;
    }

    .register-link a {
        color: #700A0A;
        text-decoration: none;
        font-weight: 600; /* Bolder registration link */
        transition: text-decoration 0.2s ease;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    .btn-outline-dark {
        color: #000;
        border: 1px solid #ccc; /* Lighter border for administrative link */
        background-color: transparent;
        padding: 8px 15px;
        font-size: 0.9rem;
        line-height: 1.2;
        border-radius: 5px;
        transition: all 0.2s ease;
    }

    .btn-outline-dark:hover {
        background-color: #f0f0f0;
        border-color: #700A0A;
        color: #000;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 767.98px) {
        .image-container {
            display: none !important; 
        }
        .form-container {
            flex: 0 0 100vw; 
        }
    }
    </style>
</head>
<body class="login-page">
    <div class="container-fluid">
        <div class="row row_container">
            <!-- Left Half: Red Circles Background (Image remains as requested) -->
            <div class="col-md-6 image-container">
                <img src="<?php echo base_url('assets/images/circles.png'); ?>" class="login-image" alt="AConnect Platform Visual">
            </div>

            <!-- Right Half: Login Form with Branding -->
            <div class="col-md-6 form-container">
                <div class="login-logo-container">
                    <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="AC Connect Logo" class="login-logo">
                </div>

                <!-- ADDED: Modern Branding and Value Proposition -->
                <div class="branding-text">
                    <h1>AConnect: Alumni & Career Platform</h1>
                    <p>Connect with your fellow alumni and unlock exclusive career opportunities. Sign in to continue your journey.</p>
                </div>

                <!-- ERROR MESSAGE AREA -->
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger text-center" role="alert" style="width: 100%; max-width: 350px; margin-bottom: 1rem; border-radius: 5px;">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <!-- END ERROR MESSAGE AREA -->

                <!-- Form Section -->
                <form class="form-signin" method="post" action="<?php echo site_url('Login/user'); ?>">
                    <div class="form-label-group">
                        <input type="text" id="student_number" name="student_number" class="form-control" placeholder="Student Number" required autofocus>
                    </div>

                    <div class="form-label-group">
                        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Keep me signed in
                        </label>
                    </div>
                    
                    <!-- Sign In Button -->
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Log in to AConnect</button>

                    <!-- Register Link -->
                    <div class="register-link">
                        <p>New to AConnect? <a href="<?= base_url('register') ?>">Create an Account</a></p>
                    </div>
                    
                    <!-- Admin Login Link -->
                    <div class="text-center mt-3">
                        <a href="<?= base_url('adminlogin'); ?>" class="btn btn-sm btn-outline-dark">
                            Admin Portal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>