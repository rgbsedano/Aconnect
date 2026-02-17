<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="User Registration Page for AConnect">
    <title>AConnect | Register</title>

    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    /* (kept styling consistent with previous version) */
    html, body { height:100%; margin:0; padding:0; font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial; background-color:#f7f7f7; overflow-x:hidden; }
    .register-page { display:flex; min-height:100vh; width:100%; }
    .container-fluid { display:flex; width:100vw; min-height:100vh; margin:0 !important; padding:0 !important; }
    .row_container { display:flex !important; width:100%; margin:0 !important; }
    .image-container { flex:0 0 50%; max-width:50%; display:flex; align-items:center; justify-content:center; overflow:hidden; min-height:100vh; background-color:#920E0E; padding:0 !important; }
    .login-image { display:block; width:100%; height:100%; object-fit:cover; }
    .form-container { flex:0 0 50%; max-width:50%; display:flex; flex-direction:column; align-items:center; justify-content:flex-start; padding:20px 30px; background-color:#fff; min-height:100vh; box-sizing:border-box; overflow-y:auto; max-height:100vh; }
    .login-logo-container { text-align:center; margin-bottom:0.5rem; }
    .login-logo { max-width:150px; height:auto; }
    .register-form-wrapper { width:100%; max-width:450px; }
    .register-form-wrapper h1 { text-align:center; font-size:1.6rem; font-weight:700; color:#333; margin-bottom:1.5rem; }
    .form-group input, .form-control { border-radius:5px; height:40px; padding:8px 15px; margin-bottom:10px; width:100%; border:1px solid #ddd; box-sizing:border-box; }
    .form-group select { border-radius:5px; height:40px; padding:8px 15px; margin-bottom:10px; width:100%; border:1px solid #ddd; box-sizing:border-box; appearance:none; background-position:right 0.75rem center; background-size:14px 14px; }
    .form-group input:focus, .form-group select:focus { border-color:#700A0A; box-shadow:0 0 0 0.15rem rgba(112,10,10,0.2); outline:0; }
    .btn-register { width:100%; background-color:#700A0A !important; color:white; border:none; height:48px; font-size:1rem; text-transform:uppercase; font-weight:600; border-radius:5px; cursor:pointer; transition:background-color 0.2s ease; }
    .btn-register:hover { background-color:#550808 !important; }
    .login-link-container { margin-top:0.75rem; text-align:center; font-size:0.85rem; padding-top:10px; border-top:1px solid #eee; }
    .login-link-container a { color:#700A0A; text-decoration:none; font-weight:600; }
    .validation-error { width:100%; max-width:450px; margin-bottom:0.5rem; padding:0.75rem; color:#721c24; background-color:#f8d7da; border:1px solid #f5c6cb; border-radius:5px; font-size:0.85rem; text-align:left; }
    @media screen and (max-width:767.98px) { 
        html, body { overflow-y:auto; height: auto; } 
        .image-container { display:none !important; } 
        .form-container { flex:0 0 100vw; max-width:100vw; justify-content:flex-start; height: auto; max-height: none; padding: 40px 20px; } 
    }
    </style>
</head>
<body class="register-page">
    <div class="container-fluid">
        <div class="row row_container">
            <div class="col-md-6 image-container">
                <img src="<?php echo base_url('assets/images/circles.png'); ?>" class="login-image" alt="AConnect Platform Visual">
            </div>

            <div class="col-md-6 form-container">
                <div class="login-logo-container">
                    <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="AC Connect Logo" class="login-logo">
                </div>

                <div class="register-form-wrapper">
                    <h1>Create Your AConnect Profile</h1>

                    <!-- Flash success/error -->
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

                    <!-- Validation Errors -->
                    <?php if (validation_errors()): ?>
                        <div class="validation-error mb-3">
                            <?= validation_errors('<p class="mb-0">', '</p>'); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('register/submit') ?>" enctype="multipart/form-data">


                        <div class="form-group">
                            <input type="text" name="student_number" placeholder="Student Number (e.g., 2017-00001)" value="<?= set_value('student_number') ?>" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <input type="text" name="first_name" placeholder="First Name" value="<?= set_value('first_name') ?>" required autocomplete="given-name">
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" placeholder="Last Name" value="<?= set_value('last_name') ?>" required autocomplete="family-name">
                        </div>
                        
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email - (Use Personal Email)" value="<?= set_value('email') ?>" required autocomplete="email">
                        </div>
                        <div class="form-group">
                            <input type="email" name="alternative_email" placeholder="Alternate Email" 
                                value="<?= set_value('alternative_email') ?>" required autocomplete="email">
                        </div>
                        
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="Phone Number (e.g., 09xxxxxxxxx)" value="<?= set_value('phone') ?>" required autocomplete="tel">
                        </div>
                       

                        
                        <div class="form-group">
                            <select name="graduation_year" required>
                                <option value="" disabled <?= (set_value('graduation_year')=='')?'selected':'' ?> >Graduation Year</option>
                                <?php 
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
                            <label for="degree">Degree</label>
                            <select name="degree" id="degree" class="form-control" required onchange="toggleOtherDegree()">
                                <option value="">-- Select Degree --</option>
                                <optgroup label="School of Nursing and Allied Health Studies">
                                    <option <?= set_select('degree','BS in Nursing') ?>>BS in Nursing</option>
                                    <option <?= set_select('degree','BS in Radiologic Technology') ?>>BS in Radiologic Technology</option>
                                    <option <?= set_select('degree','BS in Physical Therapy') ?>>BS in Physical Therapy</option>
                                </optgroup>
                                <optgroup label="School of Medical Laboratory Science">
                                    <option <?= set_select('degree','BS in Medical Laboratory Science') ?>>BS in Medical Laboratory Science</option>
                                    <option <?= set_select('degree','BS in Pharmacy') ?>>BS in Pharmacy</option>
                                    <option <?= set_select('degree','BS in Biology') ?>>BS in Biology</option>
                                </optgroup>
                                <optgroup label="School of Accountancy, Science, and Education">
                                    <option <?= set_select('degree','BS in Accountancy') ?>>BS in Accountancy</option>
                                    <option <?= set_select('degree','BS in Accounting Technology / AIS') ?>>BS in Accounting Technology / AIS</option>
                                    <option <?= set_select('degree','BS in Psychology') ?>>BS in Psychology</option>
                                    <option <?= set_select('degree','BS in Elementary Education') ?>>BS in Elementary Education</option>
                                    <option <?= set_select('degree','BS in Secondary Education') ?>>BS in Secondary Education</option>
                                </optgroup>
                                <optgroup label="School of International, Hospitality, Tourism & Management">
                                    <option <?= set_select('degree','BS in Business Administration - Financial Management') ?>>BS in Business Administration - Financial Management</option>
                                    <option <?= set_select('degree','BS in Business Administration - Marketing Management') ?>>BS in Business Administration - Marketing Management</option>
                                    <option <?= set_select('degree','BS in Business Administration - HR Development') ?>>BS in Business Administration - HR Development</option>
                                    <option <?= set_select('degree','BS in Business Administration - Operations Management') ?>>BS in Business Administration - Operations Management</option>
                                    <option <?= set_select('degree','BS in Tourism Management') ?>>BS in Tourism Management</option>
                                    <option <?= set_select('degree','BS in Hospitality Management') ?>>BS in Hospitality Management</option>
                                    <option <?= set_select('degree','BS in Hospitality Management - Culinary Arts') ?>>BS in Hospitality Management - Culinary Arts</option>
                                    <option <?= set_select('degree','BS in Hospitality Management - Cruiseline Operations') ?>>BS in Hospitality Management - Cruiseline Operations</option>
                                </optgroup>
                                <optgroup label="School of Communication, Multimedia, and Computer Studies">
                                    <option <?= set_select('degree','BA in Communication') ?>>BA in Communication</option>
                                    <option <?= set_select('degree','Bachelor of Multimedia Arts') ?>>Bachelor of Multimedia Arts</option>
                                    <option <?= set_select('degree','BS in Information Technology') ?>>BS in Information Technology</option>
                                </optgroup>
                                <option value="Other" <?= set_select('degree','Other') ?>>Other (Not Listed)</option>
                            </select>
                        </div>

                        <div class="form-group" id="degree_other_wrapper" style="<?= (set_value('degree') == 'Other') ? 'display:block;' : 'display:none;' ?>">
                            <label>Please specify your degree</label>
                            <input type="text" name="degree_other" class="form-control" placeholder="Enter your degree" value="<?= set_value('degree_other') ?>">
                        </div>

                        <script>
                        function toggleOtherDegree() {
                            var degree = document.getElementById("degree").value;
                            var otherBox = document.getElementById("degree_other_wrapper");
                            if (degree === "Other") {
                                otherBox.style.display = "block";
                            } else {
                                otherBox.style.display = "none";
                            }
                        }
                        // ensure dropdown state on page load
                        document.addEventListener('DOMContentLoaded', function(){ toggleOtherDegree(); });
                        </script>

                        <div class="form-group">
                            <select name="gender" required>
                                <option value="" disabled <?= (set_value('gender')=='')?'selected':'' ?>>Gender</option>
                                <option value="Male" <?= set_select('gender','Male') ?>>Male</option>
                                <option value="Female" <?= set_select('gender','Female') ?>>Female</option>
                                <option value="Other" <?= set_select('gender','Other') ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                            <small class="text-muted">Optional. JPG, PNG, or GIF only.</small>
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

    <!-- JS: jQuery + Bootstrap Bundle -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- optional: show flash success in-page if controller passed one -->
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
</body>
</html>
