<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Employer Registration - AConnect">
    <title>AConnect | Employer Registration</title>

    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    html, body { 
        height: auto; 
        margin: 0; 
        padding: 0; 
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        background-color: #f7f7f7; 
        overflow-x: hidden;
    }

    .register-page {
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

    .image-container {
        flex: 0 0 50%;
        max-width: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        min-height: 100vh;
        background-color: #920E0E;
        padding: 0 !important;
    }

    .login-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-container {
        position: relative;
        flex: 0 0 50%;
        max-width: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: 60px 50px;
        background-color: #fff;
        min-height: 100vh;
        box-sizing: border-box;
        overflow-y: auto;
        max-height: 100vh;
    }

    /* Back Button Container */
    .back-button-container {
        position: absolute;
        top: 20px;
        right: 20px;
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

    .register-form-wrapper {
        width: 100%;
        max-width: 550px;
    }

    .register-form-wrapper h1 {
        text-align: left;
        font-size: 2rem;
        font-weight: 700;
        color: #000;
        margin-bottom: 2rem;
        line-height: 1.2;
    }

    .login-logo-container {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-logo {
        max-width: 150px;
        height: auto;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        color: #000;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-group-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        border-radius: 8px;
        height: 50px;
        padding: 12px 16px;
        border: 1.5px solid #ccc;
        box-sizing: border-box;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.2s ease;
        background-color: #fff;
    }

    .form-group input::placeholder,
    .form-group select {
        color: #666;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #0052CC;
        box-shadow: 0 0 0 3px rgba(0, 82, 204, 0.1);
        outline: none;
    }

    .form-group input.required::after {
        content: ' *';
        color: red;
    }

    .phone-input-group {
        display: grid;
        grid-template-columns: 110px 1fr;
        gap: 1rem;
        align-items: flex-end;
    }

    .country-code-select {
        border-radius: 8px;
        height: 50px;
        padding: 12px 12px;
        border: 1.5px solid #ccc;
        box-sizing: border-box;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.2s ease;
        background: #fff url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><polyline points="5,7 10,12 15,7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>') no-repeat right 8px center;
        background-size: 14px;
        padding-right: 30px;
        appearance: none;
    }

    .country-code-select:focus {
        border-color: #0052CC;
        box-shadow: 0 0 0 3px rgba(0, 82, 204, 0.1);
        outline: none;
    }

    .phone-number-input {
        border-radius: 8px;
        height: 50px;
        padding: 12px 16px;
        border: 1.5px solid #ccc;
        box-sizing: border-box;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.2s ease;
        width: 100%;
    }

    .phone-number-input:focus {
        border-color: #0052CC;
        box-shadow: 0 0 0 3px rgba(0, 82, 204, 0.1);
        outline: none;
    }

    .helper-text {
        font-size: 0.8rem;
        color: #666;
        margin-top: 0.5rem;
        font-weight: 400;
    }

    .btn-continue {
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

    .btn-continue:hover {
        background-color: #7d181b !important;
    }

    .validation-error {
        width: 100%;
        margin-bottom: 1rem;
        padding: 0.75rem;
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        font-size: 0.85rem;
        text-align: left;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        width: 100%;
        margin-top: 1rem;
    }

    @media screen and (max-width: 1199.98px) {
        .form-container {
            padding: 40px 40px;
        }

        .register-form-wrapper h1 {
            font-size: 1.75rem;
        }
    }

    @media screen and (max-width: 991.98px) {
        .image-container {
            display: none !important;
        }

        .form-container {
            flex: 0 0 100vw;
            max-width: 100vw;
            justify-content: flex-start;
            height: auto;
            max-height: none;
            padding: 40px 30px;
        }

        .register-form-wrapper {
            max-width: 100%;
        }
    }

    @media screen and (max-width: 576px) {
        .form-container {
            padding: 30px 20px;
        }

        .register-form-wrapper h1 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group-row {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .phone-input-group {
            grid-template-columns: 1fr;
        }

        .country-code-select {
            width: 100%;
        }

        .btn-continue {
            width: 100%;
        }
    }
    </style>
</head>
<body class="register-page">
    <div class="container-fluid">
        <div class="row row_container">
            <div class="col-lg-6 image-container">
                <img src="<?php echo base_url('assets/images/circles.png'); ?>" class="login-image" alt="AConnect Platform Visual">
            </div>

            <div class="col-lg-6 form-container">
                <div class="back-button-container">
                    <button class="back-button" onclick="window.history.back()" title="Go Back">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </div>
                <div class="register-form-wrapper">
                    <div class="login-logo-container">
                        <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="AC Connect Logo" class="login-logo">
                    </div>

                    <h1>Create an employer account</h1>

                    <!-- Flash success/error -->
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

                    <form method="post" action="<?= base_url('employer_register/submit') ?>" enctype="multipart/form-data">

                        <!-- Company Name -->
                        <div class="form-group">
                            <label for="company_name">Company name<span style="color: red;">*</span></label>
                            <input type="text" id="company_name" name="company_name" placeholder="Enter your company name" value="<?= set_value('company_name') ?>" required autocomplete="organization">
                        </div>

                        <!-- First Name & Last Name (Two Columns) -->
                        <div class="form-group-row">
                            <div class="form-group">
                                <label for="first_name">First name<span style="color: red;">*</span></label>
                                <input type="text" id="first_name" name="first_name" placeholder="First Name" value="<?= set_value('first_name') ?>" required autocomplete="given-name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last name<span style="color: red;">*</span></label>
                                <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="<?= set_value('last_name') ?>" required autocomplete="family-name">
                            </div>
                        </div>

                        <!-- How did you hear about us -->
                        <div class="form-group">
                            <label for="hear_about_us">How did you hear about us?<span style="color: red;">*</span></label>
                            <select id="hear_about_us" name="hear_about_us" required>
                                <option value="">Select an option</option>
                                <option value="social_media" <?= set_value('hear_about_us') === 'social_media' ? 'selected' : '' ?>>Social Media</option>
                                <option value="search_engine" <?= set_value('hear_about_us') === 'search_engine' ? 'selected' : '' ?>>Search Engine</option>
                                <option value="university" <?= set_value('hear_about_us') === 'university' ? 'selected' : '' ?>>University Referral</option>
                                <option value="friend" <?= set_value('hear_about_us') === 'friend' ? 'selected' : '' ?>>Friend/Colleague</option>
                                <option value="other" <?= set_value('hear_about_us') === 'other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <!-- Phone Number with Country Code -->
                        <div class="form-group">
                            <label>Phone number<span style="color: transparent;">*</span></label>
                            <div class="helper-text" style="margin-bottom: 0.75rem;">
                                For account management communication. Not visible to job seekers.
                            </div>
                            <div class="phone-input-group">
                                <select id="country_code" name="country_code" class="country-code-select" required>
                                    <option value="+63" selected>🇵🇭 +63</option>
                                    <option value="+1">🇺🇸 +1</option>
                                    <option value="+44">🇬🇧 +44</option>
                                    <option value="+81">🇯🇵 +81</option>
                                    <option value="+65">🇸🇬 +65</option>
                                    <option value="+60">🇲🇾 +60</option>
                                    <option value="+66">🇹🇭 +66</option>
                                    <option value="+84">🇻🇳 +84</option>
                                    <option value="+62">🇮🇩 +62</option>
                                    <option value="+886">🇹🇼 +886</option>
                                </select>
                                <input 
                                    type="tel" 
                                    id="phone_number" 
                                    name="phone_number" 
                                    placeholder="909-605-9630" 
                                    class="phone-number-input"
                                    value="<?= set_value('phone_number') ?>" 
                                    required 
                                    autocomplete="tel"
                                >
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email<span style="color: red;">*</span></label>
                            <input type="email" id="email" name="email" placeholder="company@email.com" value="<?= set_value('email') ?>" required autocomplete="email">
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password<span style="color: red;">*</span></label>
                            <input type="password" id="password" name="password" placeholder="Enter password (min. 6 characters)" required autocomplete="new-password">
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirm">Confirm Password<span style="color: red;">*</span></label>
                            <input type="password" id="password_confirm" name="password_confirm" placeholder="Confirm password" required autocomplete="new-password">
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="submit" class="btn-continue">
                                Continue
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS: jQuery + Bootstrap Bundle -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>
