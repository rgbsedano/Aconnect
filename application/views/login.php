<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="User Login Page">
    <title>User Login</title>

    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <style>
    html,
    body {
      height: 100%;
      margin: 0;
      /* Remove default body margin */
      overflow: hidden;
      /* Prevent scrollbars if content overflows */
    }

    .login-page {
      display: flex;
      min-height: 100vh;
      /* Ensure it takes the full viewport height */
      background-color: #f8f9fa;
      /* Optional: Light background color for the whole page */
    }

    .container-fluid {
      display: flex;
      width: 100%;
      max-width: none !important;
      /* Override Bootstrap's max-width */
      height: 100vh;
      /* Make it full viewport height */
      box-shadow: none !important;
      /* Remove container shadow */
      border-radius: 0 !important;
      /* Remove container border-radius */
      overflow: hidden;
      /* Hide any image overflow */
      background-color: transparent;
      /* Make container background transparent */
      margin: 0 !important;
      /* Remove container margins */
      padding: 0 !important;
      /* Remove container padding */
    }

    .row_container{
        display: flex !important;

      }

    @media screen and (max-width: 676px) {
      .image-container {
        
        /* Take up 50% of the viewport width */
        display: none !important;
    
        /* Make the image container take the full viewport height */
      }

      .row_container{
        display: block !important;
        width: 100%;
      }
      .form-container {
        flex: 0 0 50vw;
        /* Take up 50% of the viewport width */
        display: flex;
        flex-direction: column;
        /* Arrange items vertically */
        align-items: center;
        justify-content: center;
        /* Center items vertically */
        padding: 30px;
        /* Add some padding around the form */
        min-height: 100vh;
        /* Make the form container also take full viewport height */
        background-color: #fff;
        /* Optional: Background color for the form container */

      }
    }

    .image-container {
      flex: 0 0 50vw;
      /* Take up 50% of the viewport width */
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      /* Ensure the image doesn't overflow */
      height: 100vh;
      /* Make the image container take the full viewport height */
    }

    .login-image {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
      /* Maintain aspect ratio and cover the container */
    }

    .form-container {
      flex: 0 0 50vw;
      /* Take up 50% of the viewport width */
      display: flex;
      flex-direction: column;
      /* Arrange items vertically */
      align-items: center;
      justify-content: center;
      /* Center items vertically */
      padding: 30px;
      /* Add some padding around the form */
      min-height: 100vh;
      /* Make the form container also take full viewport height */
      background-color: #fff;
      /* Optional: Background color for the form container */

    }

    .login-logo-container {
      text-align: center;
      /* Center the logo */
     

      /* Add some space below the logo */
    }

    .login-logo {
      max-width: 300px;
      /* Adjust the maximum width of the logo */
      height: auto;
      /* Maintain aspect ratio */
    }

    .form-signin {
      width: 100%;
      max-width: 400px;
      /* Adjust the maximum width of the form */
    }

    .form-signin .checkbox {
      font-weight: 400;
    }

    .form-signin .form-control {
      position: relative;
      box-sizing: border-box;
      height: auto;
      padding: 10px;
      font-size: 16px;
    }

    .form-signin .form-control:focus {
      z-index: 2;
    }

    .form-signin input[type="text"] {
      margin-bottom: -1px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

    .text-center.mb-4 {
      text-align: center !important;
      /* Center the heading */
      margin-bottom: 2rem !important;
      /* Add more space below the heading */
    }

    .text-center.mb-4 h1 {
      font-size: 2.5rem;
      /* Adjust as needed */
      margin-bottom: 0.5rem;
      /* Adjust spacing */
    }

    .btn-primary {
      background-color: rgb(255, 0, 0);
      /* Bootstrap primary color */
      border-color: rgb(83, 1, 1);
    }

    .btn-primary:hover {
      background-color: rgb(83, 1, 1);
      border-color: rgb(83, 1, 1);
    }

    .mt-5.mb-3.text-muted.text-center {
      font-size: 0.8rem;
      color: #6c757d;
    }
  </style>
    </style>
</head>
<body class="login-page">
    <div class="container-fluid">
        <div class="row row_container" style="margin: 0;">
            <div class="col-md-6 image-container" style="padding: 0 !important; margin: 0 !important;">
                <img src="<?php echo base_url('assets/images/circles.png'); ?>" class="login-image" alt="Circles Background">
            </div>
            <div class="col-md-6 form-container">
                <div class="login-logo-container">
                    <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Your Logo" class="login-logo">
                </div>
                <div class="text-center mb-4">
                    <p class="text-muted"></p>
                </div>

                <form class="form-signin" method="post" action="<?php echo site_url('Login/user'); ?>">
                    <div class="form-label-group">
                        <input type="text" id="student_number" name="student_number" class="form-control" placeholder="Student Number" required autofocus>
                        <label for="student_number"></label>
                    </div>

                    <div class="form-label-group">
                        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                        <label for="inputPassword"></label>
                    </div>

                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" style="background: #700A0A" type="submit">Sign in</button>

                    <div class="register-link mt-3">
                        <p>Don't have an account? <a href="<?= base_url('register') ?>">Register here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>