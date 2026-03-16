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

/* ================= GLOBAL ================= */
html, body {
    min-height: 100%;
    margin: 0;
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;
}

.login-page {
    min-height: 100vh;
    background: #f7f7f7;
}

.container-fluid,
.row_container {
    width: 100%;
    margin: 0 !important;
    padding: 0 !important;
}


/* ================= DESKTOP ================= */
/* Default = SPLIT SCREEN */

.image-container {
    position: relative;
    height: 100vh;
    overflow: hidden;
    background: #920E0E;
}

.login-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.form-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background: #fff;
    padding: 30px;
}


/* ================= CARD ================= */
.form-signin {
    width: 100%;
    max-width: 380px;
    background: #fff;
    padding: 28px;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}

.login-header {
    text-align: center;
    margin-bottom: 18px;
}

.login-logo {
    max-width: 120px;
    margin-bottom: 10px;
}

.branding-text p {
    font-size: .9rem;
    color: #6c757d;
}


/* ================= FORM ================= */
.form-control {
    border-radius: 8px;
    height: 48px;
    border: 1px solid #ddd;
    margin-bottom: 15px;
}

.form-control:focus {
    border-color: #a12124;
    box-shadow: 0 0 0 .15rem rgba(112,10,10,.2);
}

.btn-block {
    width: 100%;
    background: #a12124 !important;
    border: none;
    height: 48px;
    font-weight: 600;
    border-radius: 8px;
}

.btn-block:hover {
    background: #7d181b !important;
}


/* ================= LOGIN OPTIONS ================= */
.login-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 6px;
    margin-bottom: 18px;
    gap: 12px;
}

.remember-me {
    display: flex;
    gap: 7px;
    font-size: 0.9rem;
    color: #555;
}

.remember-me input {
    accent-color: #a12124;
}

.forgot-link {
    font-size: .9rem;
    font-weight: 600;
    color: #a12124;
    text-decoration: none;
}


/* ================= MOBILE ================= */
/* Switch to BACKGROUND MODE */

@media (max-width: 767px) {

    .login-page {
        position: relative;
        overflow: hidden;
    }

    /* image becomes background */
    .image-container {
        position: fixed;
        inset: 0;
        z-index: 0;
    }

    .image-container::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.45);
    }

    /* form floats */
    .form-container {
        position: relative;
        z-index: 2;
        background: transparent;
        min-height: 100vh;
        align-items: flex-start;
        padding: 40px 20px;
    }

    /* glass effect on mobile */
    .form-signin {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 25px 60px rgba(0,0,0,0.25);
    }

    .login-options {
        flex-direction: column;
        align-items: flex-start;
    }

}

.image-container,
.form-container {
    padding-left: 0 !important;
    padding-right: 0 !important;
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
                        <input type="text" id="student_number" name="student_number" class="form-control" placeholder="Student Number" required  value="<?= set_value('student_number') ?>">
                    </div>

                    <div class="form-label-group">
                        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="login-options">
                        <label class="remember-me">
                            <input type="checkbox" value="remember-me">
                            <span>Keep me signed in</span>
                        </label>

                        <a href="#" class="forgot-link" data-toggle="modal" data-target="#forgotModal">
                            Forgot password?
                        </a>
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

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">

        <form method="post" action="<?= base_url('login/send_reset_link') ?>">

            <div class="modal-header">
            <h5 class="modal-title">Forgot Password</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
            <div class="form-group">
                <label>Enter your registered email</label>
                <input type="email"
                    name="email"
                    class="form-control"
                    required
                    placeholder="name@domain.com">
            </div>
            </div>

            <div class="modal-footer">
            <button type="submit"
                    class="btn btn-primary"
                    style="background:#a12124;border:none">
                Send Reset Link
            </button>
            <button type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal">
                Cancel
            </button>
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
              <button type="submit" class="btn btn-primary" style="background:#a12124;border:none">Resend</button>
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


    <script>
document.addEventListener('DOMContentLoaded', function () {
    // focus login field on page load
    const loginInput = document.getElementById('student_number');
    if (loginInput) loginInput.focus();

    // focus email when forgot modal opens
    $('#forgotModal').on('shown.bs.modal', function () {
        $(this).find('input[name="email"]').trigger('focus');
    });
});
</script>
</body>
</html>
