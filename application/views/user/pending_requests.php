<style>
    /* 🎨 MODERN PENDING REQUESTS STYLES */
    :root {
        --primary-maroon: #700A0A; /* SDCA Primary Color */
        --success-green: #28a745; 
        --danger-red: #dc3545;
        --light-bg: #f0f2f5; /* Social media background */
        --card-bg: #ffffff;
        --text-dark: #1c1e21;
        --text-muted: #606770;
        --border-color: #dddfe2;
        --border-radius-lg: 10px;
    }
    
    .container-fluid {
        padding: 30px;
        background-color: var(--light-bg);
    }

    /* Heading */
    .section-heading {
        color: var(--primary-maroon);
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 25px;
        border-bottom: 2px solid var(--primary-maroon);
        padding-bottom: 5px;
    }

    .pending-requests-list {
        list-style: none;
        padding: 0;
        max-width: 800px; /* Constrain list width for focus */
        margin: 0 auto;
    }

    /* Individual Request Card */
    .pending-request-item {
        background-color: var(--card-bg);
        padding: 15px 20px;
        margin-bottom: 12px;
        border-radius: var(--border-radius-lg);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .requester-info {
        display: flex;
        align-items: center;
    }

    .requester-icon {
        font-size: 1.5rem;
        color: var(--primary-maroon);
        margin-right: 15px;
    }

    .requester-name {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.1rem;
    }

    .request-actions {
        display: flex;
        gap: 10px;
    }

    /* Modern Buttons */
    .action-button {
        color: #fff;
        padding: 8px 15px;
        border-radius: 50px; /* Pill-shaped buttons */
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: opacity 0.2s ease-in-out;
        border: none;
        cursor: pointer;
    }

    .action-button:hover {
        opacity: 0.9;
    }

    .accept-button {
        background-color: var(--success-green); 
    }

    .decline-button {
        background-color: var(--danger-red); 
    }

    .no-requests {
        color: var(--text-muted);
        font-size: 1rem;
        padding: 15px 20px;
        background-color: #fff;
        border-radius: var(--border-radius-lg);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        max-width: 800px;
        margin: 0 auto;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
        .pending-request-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
        }

        .requester-info {
            margin-bottom: 10px;
        }

        .request-actions {
            margin-top: 5px;
            width: 100%;
            justify-content: space-around;
        }
        
        .action-button {
            flex-grow: 1; /* Make buttons fill space on small screens */
            text-align: center;
        }
    }
</style>

<div class="container-fluid">
    <h2 class="section-heading"><i class="fas fa-user-friends mr-2"></i> Pending Connection Requests</h2>

    <?php if (empty($pending_requests)): ?>
        <p class="no-requests">No pending connection requests at the moment.</p>
    <?php else: ?>
        <ul class="pending-requests-list">
            <?php foreach ($pending_requests as $request): ?>
                <li class="pending-request-item">
                    <div class="requester-info">
                        <i class="fas fa-user-circle requester-icon"></i>
                        <span class="requester-name"><?= $request->first_name . ' ' . $request->last_name ?></span>
                    </div>
                    <div class="request-actions">
                        <a href="<?= site_url('alumni_request/accept_request/' . $request->id) ?>" class="action-button accept-button">
                            <i class="fas fa-check mr-1"></i> Accept
                        </a>
                        <a href="<?= site_url('alumni_request/decline_request/' . $request->id) ?>" class="action-button decline-button">
                            <i class="fas fa-times mr-1"></i> Decline
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>