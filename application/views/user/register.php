<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: auto;
        }

        .register-page {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .container-fluid {
            display: flex;
            flex-direction: column;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        @media (min-width: 768px) {
            .container-fluid {
                flex-direction: row;
                min-height: 100vh;
            }
        }

        .image-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            max-height: 300px;
        }

        @media (min-width: 768px) {
            .image-container {
                max-height: none;
                display: flex;
            }
        }

        @media (max-width: 767px) {
            .image-container {
                display: none;
            }
        }

        .login-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 30px;
            background-color: #fff;
            height: auto;
            overflow-y: auto;
        }

        @media (min-width: 768px) {
            .form-container {
                height: 100vh;
            }
        }

        .login-logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            max-width: 200px;
            height: auto;
        }

        .register-form-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .register-form-wrapper h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #007bff;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            text-align: center;
        }

        .login-link-container {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="register-page">
    <div class="container-fluid">
        <div class="image-container">
            <img src="<?php echo base_url('assets/images/circles.png'); ?>" class="login-image" alt="Circles Background">
        </div>
        <div class="form-container">
            <div class="login-logo-container">
                <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Your Logo" class="login-logo">
            </div>
            <div class="register-form-wrapper">
                <h2>Register</h2>
                <?= validation_errors('<div class="error">', '</div>'); ?>
                <form method="post" action="<?= base_url('register/submit') ?>">
                    <div class="form-group">
                        <input type="text" name="alumni_number" placeholder="Alumni ID" value="<?= set_value('alumni_number') ?>" required>
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
                        <input type="text" name="phone" placeholder="Phone Number" value="<?= set_value('phone') ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="graduation_year" placeholder="Graduation Year" value="<?= set_value('graduation_year') ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="student_number" placeholder="Student Number" value="<?= set_value('student_number') ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="degree" placeholder="Degree" value="<?= set_value('degree') ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="gender" placeholder="Gender" value="<?= set_value('gender') ?>" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Register</button>
                    </div>
                </form>
                <div class="login-link-container">
                    <p>Already have an account? <a href="<?= base_url('login') ?>">Login here</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            var successMessage = '<?= $this->session->flashdata('success_message'); ?>';
            if (successMessage) {
                alert(successMessage);
                window.location.href = "<?= base_url('login') ?>";
            }
        }
    </script>
</body>
</html>
