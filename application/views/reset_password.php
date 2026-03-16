<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>AConnect | Reset Password</title>

<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
/* ===== COPY OF LOGIN LAYOUT ===== */

html, body {
    min-height: 100%;
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

.login-page {
    display: flex;
    min-height: 100vh;
    background-color: #f7f7f7;
}

.container-fluid {
    display: flex;
    width: 100%;
    height: 100vh;
    padding: 0 !important;
    margin: 0 !important;
}

.row_container {
    display: flex !important;
    width: 100%;
    margin: 0 !important;
}

/* LEFT IMAGE */
.image-container {
    flex: 0 0 50vw;
    position: relative;
    overflow: hidden;
    height: 100vh;
    background-color: #920E0E;
}

.login-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* RIGHT FORM AREA */
.form-container {
    flex: 0 0 50vw;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
    background-color: #fff;
}

/* GLASS CARD */
.reset-card {
    width: 100%;
    max-width: 380px;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    padding: 28px;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    text-align: center;
}

/* HEADER */
.reset-header {
    margin-bottom: 18px;
}

.reset-icon {
    font-size: 42px;
    color: #a12124;
    margin-bottom: 10px;
}

.reset-header h3 {
    font-weight: 700;
    margin-bottom: 6px;
}

.reset-header p {
    font-size: 0.9rem;
    color: #6c757d;
}

/* INPUT */
.reset-card .form-control {
    border-radius: 8px;
    height: 48px;
    border: 1px solid #ddd;
}

.reset-card .form-control:focus {
    border-color: #a12124;
    box-shadow: 0 0 0 0.15rem rgba(112,10,10,0.15);
}

/* BUTTON */
.reset-card .btn-primary {
    width: 100%;
    background: linear-gradient(135deg, #a12124, #C90000);
    border: none;
    height: 48px;
    font-weight: 600;
    border-radius: 8px;
}

.reset-card .btn-primary:hover {
    background: linear-gradient(135deg, #7d181b, #a30000);
}

/* BACK LINK */
.back-login {
    margin-top: 15px;
}

.back-login a {
    color: #a12124;
    font-weight: 600;
    text-decoration: none;
}

.back-login a:hover {
    text-decoration: underline;
}

/* MOBILE */
@media (max-width: 767.98px) {
    .image-container {
        display: none;
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

    <!-- LEFT IMAGE (same as login) -->
    <div class="col-md-6 image-container">
        <img src="<?= base_url('assets/images/welcome.png'); ?>" class="login-image">
    </div>

    <!-- RIGHT FORM -->
    <div class="col-md-6 form-container">

        <form method="post"
              action="<?= base_url('login/update_password'); ?>"
              class="reset-card">

            <input type="hidden" name="token" value="<?= $token ?>">

            <div class="reset-header">
                <i class="fas fa-lock reset-icon"></i>
                <h3>Reset Password</h3>
                <p>Enter your new password below.</p>
            </div>

            <input type="password"
                id="password"
                name="password"
                class="form-control mb-3"
                required
                placeholder="New Password">

            <input type="password"
                id="confirm_password"
                name="confirm_password"
                class="form-control mb-3"
                required
                placeholder="Confirm Password">

            <small id="passwordMatchMsg" class="text-danger d-none">
                Passwords do not match
            </small>

            <button type="submit" class="btn btn-primary">
                Update Password
            </button>

            <div class="back-login">
                <a href="<?= base_url('login') ?>">← Back to Login</a>
            </div>

        </form>

    </div>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const msg = document.getElementById('passwordMatchMsg');
    const form = document.querySelector('.reset-card');

    function checkMatch() {
        if (!confirmPassword.value) {
            msg.classList.add('d-none');
            return;
        }

        if (password.value !== confirmPassword.value) {
            msg.classList.remove('d-none');
            confirmPassword.classList.add('is-invalid');
        } else {
            msg.classList.add('d-none');
            confirmPassword.classList.remove('is-invalid');
        }
    }

    password.addEventListener('keyup', checkMatch);
    confirmPassword.addEventListener('keyup', checkMatch);

    form.addEventListener('submit', function (e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault();
            msg.classList.remove('d-none');
            confirmPassword.classList.add('is-invalid');
            confirmPassword.focus();
        }
    });

});
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>