<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="User Registration Page for AConnect">
    <title>AConnect | Register</title>

    <!-- Assuming Bootstrap is loaded from your assets folder -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <style>
    /* Global/Layout Styles - Consistent with Login Page */
    html,
    body {
        height: 100%;
        margin: 0;
        /* Ensure no margin on body or html */
        padding: 0;
        /* Use a modern, clean font stack */
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        background-color: #f7f7f7; 
        overflow-x: hidden; /* Prevent horizontal scrollbar, which can expose white space */
        overflow-y: auto; 
    }

    .register-page {
        display: flex;
        min-height: 100vh;
        width: 100%;
    }

    /* FIX: Ensure the outer Bootstrap containers don't add unwanted padding/margin */
    .container-fluid {
        display: flex;
        width: 100vw; /* Explicitly set to 100% viewport width */
        min-height: 100vh;
        margin: 0 !important;
        padding: 0 !important;
    }

    .row_container {
        display: flex !important;
        width: 100%;
        margin: 0 !important; /* Crucial: Remove negative margin added by Bootstrap .row */
    }

    /* Left Side: Image Container (Maroon) - KEPT AS REQUESTED */
    .image-container {
        /* Set to 50% width and height based on viewport for perfect split */
        flex: 0 0 50%;
        max-width: 50%; 
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        min-height: 100vh; /* Takes full viewport height */
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
        /* Set to 50% width and height based on viewport for perfect split */
        flex: 0 0 50%;
        max-width: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start; /* Start content at the top */
        padding: 40px 30px;
        background-color: #fff; /* White background */
        min-height: 100vh;
        box-sizing: border-box;
    }

    .login-logo-container {
        text-align: center;
        margin-bottom: 1rem;
    }

    .login-logo {
        max-width: 180px;
        height: auto;
    }

    .register-form-wrapper {
        width: 100%;
        max-width: 450px; /* Slightly wider form for more fields */
    }

    .register-form-wrapper h1 {
        text-align: center;
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 2rem;
    }

    /* Input Fields (Text Boxes) - Consistent Styling */
    .form-group input, .form-control {
        border-radius: 5px; /* Smoother edges */
        height: 48px; /* Consistent height */
        padding: 10px 15px;
        margin-bottom: 15px;
        width: 100%; 
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        border: 1px solid #ddd; /* Lighter border */
        box-sizing: border-box; /* Include padding/border in element's total width/height */
    }
    
    /* Focus Styling */
    .form-group input:focus {
        border-color: #700A0A; /* Maroon border on focus */
        box-shadow: 0 0 0 0.15rem rgba(112, 10, 10, 0.2); /* Subtle maroon shadow */
    }

    /* Register Button - Consistent Styling */
    .btn-register {
        width: 100%;
        background-color: #700A0A !important; /* Maroon color */
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

    .btn-register:hover {
        background-color: #550808 !important; 
    }

    /* Login Link */
    .login-link-container {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.9rem;
        padding-top: 15px;
        border-top: 1px solid #eee; /* Separator line */
    }
    .login-link-container a {
        color: #700A0A;
        text-decoration: none;
        font-weight: 600;
        transition: text-decoration 0.2s ease;
    }
    .login-link-container a:hover {
        text-decoration: underline;
    }

    /* Error Styling (Bootstrap look for validation errors) */
    .validation-error {
        width: 100%;
        max-width: 450px;
        margin-bottom: 1rem;
        padding: 1rem;
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        font-size: 0.9rem;
        text-align: left;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 767.98px) {
        .image-container {
            display: none !important; /* Hide image on smaller screens */
            flex: none; /* Reset flex properties */
            max-width: none;
        }
        .form-container {
            flex: 0 0 100vw; /* Form takes full width */
            max-width: 100vw;
        }
    }
    </style>
</head>
<body class="register-page">
    <div class="container-fluid">
        <div class="row row_container">
            <!-- Left Half: Red Circles Background (Image remains as requested) -->
            <div class="col-md-6 image-container">
                <img src="<?php echo base_url('assets/images/circles.png'); ?>" class="login-image" alt="AConnect Platform Visual">
            </div>

            <!-- Right Half: Registration Form -->
            <div class="col-md-6 form-container">
                <div class="login-logo-container">
                    <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="AC Connect Logo" class="login-logo">
                </div>
                
                <div class="register-form-wrapper">
                    <h1>Create Your AConnect Profile</h1>

                    <!-- Validation Errors -->
                    <?php if (validation_errors()): ?>
                        <div class="validation-error mb-3">
                            <?= validation_errors('<p class="mb-0">', '</p>'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form Section -->
                    <form method="post" action="<?= base_url('register/submit') ?>">
                        <div class="form-group">
                            <input type="text" name="alumni_number" placeholder="Alumni ID (e.g., A12345)" value="<?= set_value('alumni_number') ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="first_name" placeholder="First Name" value="<?= set_value('first_name') ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" placeholder="Last Name" value="<?= set_value('last_name') ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" value="<?= set_value('email') ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" placeholder="Phone Number (e.g., 09xxxxxxxxx)" value="<?= set_value('phone') ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="graduation_year" placeholder="Graduation Year (e.g., 2021)" value="<?= set_value('graduation_year') ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="student_number" placeholder="Student Number (e.g., 2017-00001)" value="<?= set_value('student_number') ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="degree" placeholder="Degree (e.g., BS Information Technology)" value="<?= set_value('degree') ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="gender" placeholder="Gender (e.g., Male/Female)" value="<?= set_value('gender') ?>" required>
                        </div>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn-register">Register Account</button>
                        </div>
                    </form>

                    <div class="login-link-container">
                        <p>Already have an account? <a href="<?= base_url('login') ?>">Log in here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 
        NOTE: Removed the JavaScript alert() function as it blocks the user interface. 
        You should handle success messages by displaying a flash message inside the 
        form-container upon redirect or rendering.
    -->
</body>
</html>