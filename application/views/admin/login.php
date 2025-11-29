<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Login Page for AConnect">
    <title>AConnect | Admin Login</title>

    <!-- Assuming Bootstrap is loaded from your assets folder -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
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
        overflow-y: hidden; /* CRUCIAL: Hide vertical scrollbar */
    }

    .login-page {
        display: flex;
        min-height: 100vh;
        width: 100%;
    }

    /* FIX: Ensure the outer Bootstrap containers don't add unwanted padding/margin */
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
        flex: 0 0 50%;
        max-width: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center; /* Center content vertically */
        padding: 20px 30px; 
        background-color: #fff; 
        min-height: 100vh;
        box-sizing: border-box;
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
        max-width: 400px; /* Standardize form width */
    }

    .login-form-wrapper h1 {
        text-align: center;
        font-size: 1.6rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 2.5rem;
    }
    
    /* Input Fields Styling (Simplified for clean look) */
    .form-control {
        border-radius: 5px; 
        height: 44px; /* Standard height for inputs */
        padding: 10px 15px;
        margin-bottom: 15px; 
        width: 100%; 
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        border: 1px solid #ddd; 
        box-sizing: border-box; 
    }
    
    .form-control:focus {
        border-color: #700A0A; /* Maroon border on focus */
        box-shadow: 0 0 0 0.15rem rgba(112, 10, 10, 0.2); /* Subtle maroon shadow */
        outline: 0;
    }

    /* Checkbox styling adjustment */
    .form-check {
        margin-bottom: 1rem;
    }

    /* Sign In Button */
    .btn-login {
        width: 100%;
        background-color: #700A0A !important; 
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
        background-color: #550808 !important; 
    }

    /* Link to Alumni Login */
    .link-container {
        margin-top: 0.75rem; 
        text-align: center;
        font-size: 0.85rem;
        padding-top: 10px;
        border-top: 1px solid #eee; 
    }
    .link-container a {
        color: #700A0A;
        text-decoration: none;
        font-weight: 600;
        transition: text-decoration 0.2s ease;
    }
    .link-container a:hover {
        text-decoration: underline;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 767.98px) {
        /* Allow scrolling on mobile if content is too tall */
        html, body {
            overflow-y: auto; 
        }
        .image-container {
            display: none !important; /* Hide image on smaller screens */
        }
        .form-container {
            flex: 0 0 100vw; /* Form takes full width */
            max-width: 100vw;
            justify-content: flex-start; /* Revert to top alignment on mobile for better space */
        }
    }
    </style>
</head>
<body class="login-page">
    <div class="container-fluid">
        <div class="row row_container">
            <!-- Left Half: Red Circles Background (Image) -->
            <div class="col-md-6 image-container">
                <img src="<?php echo base_url('assets/images/circles.png'); ?>" class="login-image" alt="AConnect Platform Visual">
            </div>

            <!-- Right Half: Admin Login Form -->
            <div class="col-md-6 form-container">
                <div class="login-logo-container">
                    <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="AC Connect Logo" class="login-logo">
                </div>
                
                <div class="login-form-wrapper">
                    <h1>Administrator Access</h1>
                    
                    <!-- Placeholder for validation/error messages -->
                    <!-- You should replace this with actual PHP validation error display -->
                    <?php if (isset($error_message)): ?>
                        <div class="validation-error mb-3">
                            <?= $error_message ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form Section -->
                    <form method="post" action="<?php echo site_url('adminlogin/admin'); ?>">
                        
                        <div class="form-group">
                            <!-- Simplified input structure from the original "form-label-group" -->
                            <input type="text" id="username" name="username" class="form-control" placeholder="Admin Username" required autofocus autocomplete="username">
                        </div>

                        <div class="form-group">
                            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required autocomplete="current-password">
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="remember-me" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">
                                Remember me
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <!-- Using custom button class for consistent styling -->
                            <button class="btn-login" type="submit">Sign In</button>
                        </div>
                    </form>

                    <div class="link-container">
                        <a href="<?= base_url('login'); ?>">Go back to Alumni Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>