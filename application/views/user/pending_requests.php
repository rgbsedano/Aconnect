<?php
// pending_requests_modern.php

// Note: This updated design maintains the original PHP logic and CodeIgniter functions 
// (site_url, $pending_requests, $request->id, etc.) exactly as requested.

// Placeholder for $pending_requests structure (Assuming it contains combined request and sender details)
/*
$pending_requests = [
    (object)[
        'id' => 1, // Connection ID
        'sender_id' => 5, 
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'degree' => 'BS in Business Management',
        'request_date' => '2025-12-01 09:00:00',
        'profile_image' => 'jane_smith.jpg',
        'gender' => 'female'
    ],
    // ... more objects
];
*/
?>

<style>
    /* Color Variables from previous Alumni Search page for consistency */
    :root {
        --maroon: #700A0A;
        --maroon-dark: #5a0707;
        --white: #FFFFFF;
        --light-gray: #f8f9fa;
        --card-bg: #fff;
        --text-dark: #333;
        --border-gray: #eee;
        --accent-blue: #007bff; /* Modern accent color for hover/focus */
        --success: #28a745;
        --danger: #dc3545;
    }

    /* Layout and Typography */
    .container-fluid {
        padding: 40px 20px;
        font-family: 'Poppins', sans-serif; /* Using a modern font */
        background-color: var(--light-gray);
        max-width: 800px;
        margin: auto;
    }

    h2 {
        color: var(--maroon);
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 30px;
        border-bottom: 3px solid var(--maroon);
        padding-bottom: 10px;
        display: flex;
        align-items: center;
    }

    /* List and Item Styling (Card Look) */
    .pending-requests-list {
        list-style: none;
        padding: 0;
    }

    .pending-request-item {
        background-color: var(--card-bg);
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Stronger, modern shadow */
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-left: 5px solid var(--maroon); /* Accent border */
    }
    
    .pending-request-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    /* Profile Info Styling */
    .requester-info {
        display: flex;
        align-items: center;
        flex-grow: 1;
    }

    .profile-avatar-wrapper {
        width: 50px;
        height: 50px;
        min-width: 50px;
        margin-right: 15px;
        border: 2px solid var(--maroon);
        border-radius: 50%;
        overflow: hidden;
    }

    .profile-avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .requester-details {
        line-height: 1.4;
    }

    .requester-name {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.1rem;
        margin: 0;
    }
    
    .request-meta {
        font-size: 0.85rem;
        color: #777;
    }
    .request-meta i {
        margin-right: 5px;
    }

    /* Actions Styling */
    .request-actions {
        display: flex;
        gap: 10px;
        min-width: 220px; /* Give buttons space */
    }

    .action-button {
        color: var(--white);
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
        border: none;
        cursor: pointer;
        text-align: center;
        flex-grow: 1;
    }

    .accept-button {
        background-color: var(--success);
    }

    .accept-button:hover {
        background-color: #1e7e34;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.4);
    }

    .decline-button {
        background-color: var(--danger);
    }

    .decline-button:hover {
        background-color: #bd2130;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.4);
    }
    
    .view-button {
        background-color: var(--maroon);
        color: var(--white);
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: background-color 0.2s;
    }
    .view-button:hover {
        background-color: var(--maroon-dark);
    }

    /* No Requests Message */
    .no-requests-container {
        text-align: center;
        padding: 50px;
        border: 1px dashed #ccc;
        border-radius: 12px;
        background-color: var(--card-bg);
        color: #777;
        margin-top: 20px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .pending-request-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
        }

        .requester-info {
            margin-bottom: 15px;
            width: 100%;
        }

        .request-actions {
            flex-direction: row; /* Keep actions in a row */
            width: 100%;
            min-width: auto;
        }
        
        .action-button, .view-button {
            padding: 8px 12px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="container-fluid">
    <h2><i class="fas fa-inbox mr-2"></i> Pending Connection Requests</h2>

    <?php if (empty($pending_requests)): ?>
        <div class="no-requests-container">
            <i class="far fa-smile-beam fa-3x mb-3"></i>
            <p class="lead">No pending connection requests at this time.</p>
        </div>
    <?php else: ?>
        <ul class="pending-requests-list">
            <?php foreach ($pending_requests as $request): ?>
                <li class="pending-request-item">
                    
                    <div class="requester-info">
                        <div class="profile-avatar-wrapper">
                            <?php 
                                // Assuming profile_image and gender are available in the $request object
                                $image_path = $request->profile_image ?? null;
                                $gender = strtolower($request->gender ?? 'male');
                                $default_img = ($gender === 'female') ? base_url('assets/images/person-female.png') : base_url('assets/images/person-male.png');
                                
                                if ($image_path): ?>
                                    <img src="<?= base_url('assets/uploads/alumni/' . $image_path) ?>" alt="Profile Image">
                                <?php else: ?>
                                    <img src="<?= $default_img ?>" alt="Default Photo">
                                <?php endif; 
                            ?>
                        </div>
                        <div class="requester-details">
                            <p class="requester-name"><?= $request->first_name . ' ' . $request->last_name ?></p>
                            <p class="request-meta mb-0">
                                <i class="fas fa-graduation-cap"></i> <?= $request->degree ?? 'N/A' ?> 
                                | <i class="far fa-clock"></i> Requested: <?= date('M j, Y', strtotime($request->request_date ?? 'now')) ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="request-actions">
                        <button type="button" class="view-button" data-toggle="modal" data-target="#viewProfileModal<?= $request->sender_id ?? '0' ?>">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <a href="<?= site_url('alumni_request/accept_request/' . $request->id) ?>" class="action-button accept-button">
                            <i class="fas fa-check"></i> Accept
                        </a>
                        <a href="<?= site_url('alumni_request/decline_request/' . $request->id) ?>" class="action-button decline-button">
                            <i class="fas fa-times"></i> Decline
                        </a>
                    </div>
                </li>

                <div class="modal fade" id="viewProfileModal<?= $request->sender_id ?? '0' ?>" tabindex="-1" role="dialog" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewProfileModalLabel">Profile of <?= $request->first_name . ' ' . $request->last_name ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Degree: <?= $request->degree ?? 'N/A' ?></p>
                                <p>Full profile details loaded here...</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>