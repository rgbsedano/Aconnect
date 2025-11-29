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
        overflow-y: hidden; /* CRUCIAL FIX: Hide vertical scrollbar */
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
        /* MODIFIED: Center content vertically to better utilize space */
        justify-content: center; 
        /* MODIFIED: Reduced vertical padding to save space */
        padding: 20px 30px; 
        background-color: #fff; /* White background */
        min-height: 100vh;
        box-sizing: border-box;
    }

    .login-logo-container {
        text-align: center;
        /* MODIFIED: Reduced margin */
        margin-bottom: 0.5rem;
    }

    .login-logo {
        /* MODIFIED: Reduced logo size slightly */
        max-width: 150px; 
        height: auto;
    }

    .register-form-wrapper {
        width: 100%;
        max-width: 450px; 
    }

    .register-form-wrapper h1 {
        text-align: center;
        /* MODIFIED: Reduced title size slightly */
        font-size: 1.6rem;
        font-weight: 700;
        color: #333;
        /* MODIFIED: Reduced margin */
        margin-bottom: 1.5rem;
    }

    /* Input Fields (Text Boxes) - Consistent Styling */
    .form-group input, .form-control {
        border-radius: 5px; 
        /* MODIFIED: Reduced height slightly to save vertical space */
        height: 40px; 
        padding: 8px 15px;
        /* MODIFIED: Reduced margin-bottom */
        margin-bottom: 10px; 
        width: 100%; 
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        border: 1px solid #ddd; 
        box-sizing: border-box; 
    }
    
    /* Select Dropdown specific styling to match inputs */
    .form-group select {
        /* Inherit the input styling */
        border-radius: 5px; 
        height: 40px; 
        padding: 8px 15px;
        margin-bottom: 10px; 
        width: 100%; 
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        border: 1px solid #ddd; 
        box-sizing: border-box;
        appearance: none; /* Remove default browser styling for a cleaner look */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 14px 14px;
    }
    
    .form-group input:focus, .form-group select:focus {
        border-color: #700A0A; /* Maroon border on focus */
        box-shadow: 0 0 0 0.15rem rgba(112, 10, 10, 0.2); /* Subtle maroon shadow */
        outline: 0;
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
        /* MODIFIED: Reduced margin */
        margin-top: 0.75rem; 
        text-align: center;
        font-size: 0.85rem; /* Slightly smaller font */
        padding-top: 10px;
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
        margin-bottom: 0.5rem; /* Reduced margin */
        padding: 0.75rem; /* Reduced padding */
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        font-size: 0.85rem;
        text-align: left;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 767.98px) {
        /* On mobile, allow scrolling because content still won't fit vertically */
        html, body {
            overflow-y: auto; 
        }
        .image-container {
            display: none !important; /* Hide image on smaller screens */
            flex: none; /* Reset flex properties */
            max-width: none;
        }
        .form-container {
            flex: 0 0 100vw; /* Form takes full width */
            max-width: 100vw;
            justify-content: flex-start; /* Revert to top alignment on mobile */
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
                            <!-- Use 'text' type as Alumni IDs can contain letters -->
                            <input type="text" name="alumni_number" placeholder="Alumni ID (e.g., A12345)" value="<?= set_value('alumni_number') ?>" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <!-- Added autocomplete -->
                            <input type="text" name="first_name" placeholder="First Name" value="<?= set_value('first_name') ?>" required autocomplete="given-name">
                        </div>
                        <div class="form-group">
                            <!-- Added autocomplete -->
                            <input type="text" name="last_name" placeholder="Last Name" value="<?= set_value('last_name') ?>" required autocomplete="family-name">
                        </div>
                        <div class="form-group">
                            <!-- Changed type to 'email' and added autocomplete -->
                            <input type="email" name="email" placeholder="Email" value="<?= set_value('email') ?>" required autocomplete="email">
                        </div>
                        <div class="form-group">
                            <!-- Changed type to 'password' and added autocomplete -->
                            <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <!-- Changed type to 'tel' and added autocomplete -->
                            <input type="tel" name="phone" placeholder="Phone Number (e.g., 09xxxxxxxxx)" value="<?= set_value('phone') ?>" required autocomplete="tel">
                        </div>

                        <!-- OPTIMIZATION: Use Select for Graduation Year -->
                        <div class="form-group">
                            <select name="graduation_year" required>
                                <option value="" disabled selected>Graduation Year</option>
                                <?php 
                                // Generate options for a reasonable range of years (e.g., last 10 years to next 5 years)
                                $current_year = date('Y');
                                $start_year = $current_year - 10;
                                $end_year = $current_year + 5;
                                for ($year = $end_year; $year >= $start_year; $year--): ?>
                                    <option value="<?= $year ?>" <?= (set_value('graduation_year') == $year) ? 'selected' : '' ?>>
                                        <?= $year ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" name="student_number" placeholder="Student Number (e.g., 2017-00001)" value="<?= set_value('student_number') ?>" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input type="text" name="degree" placeholder="Degree (e.g., BS Information Technology)" value="<?= set_value('degree') ?>" required autocomplete="off">
                        </div>

                        <!-- OPTIMIZATION: Use Select for Gender -->
                        <div class="form-group">
                            <select name="gender" required>
                                <option value="" disabled selected>Gender</option>
                                <option value="Male" <?= (set_value('gender') == 'Male') ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= (set_value('gender') == 'Female') ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= (set_value('gender') == 'Other') ? 'selected' : '' ?>>Other</option>
                            </select>
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