<?php
/**
 * Access Denied View
 * Displays when a user doesn't have permission to access a page
 */
?>

<div class="container" style="margin-top: 50px; text-align: center;">
    <div class="alert alert-danger" style="max-width: 600px; margin: 0 auto; padding: 30px;">
        <h2 style="color: #d32f2f; margin-top: 0;">Access Denied</h2>
        <p style="font-size: 16px; margin: 20px 0;">You do not have permission to access this page.</p>
        
        <p style="color: #666; font-size: 14px;">
            If you believe this is an error, please contact your administrator.
        </p>
        
        <div style="margin-top: 30px;">
            <a href="<?= base_url('AdminJobPosting'); ?>" class="btn btn-primary" style="
                display: inline-block;
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                cursor: pointer;
            ">Go Back to Dashboard</a>
        </div>
    </div>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    border-radius: 4px;
    color: #721c24;
}

.btn-primary {
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>
