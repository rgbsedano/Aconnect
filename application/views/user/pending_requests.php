<style>
    .container-fluid {
        padding: 30px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    h2 {
        color: #d9534f; /* Red heading */
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .pending-requests-list {
        list-style: none;
        padding: 0;
    }

    .pending-request-item {
        background-color: #fff;
        padding: 15px 20px;
        margin-bottom: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .requester-name {
        font-weight: 500;
        color: #333;
    }

    .request-actions {
        display: flex;
        gap: 10px;
    }

    .accept-button,
    .decline-button {
        color: #fff;
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background-color 0.2s ease-in-out;
        border: none;
        cursor: pointer;
    }

    .accept-button {
        background-color: #28a745; /* Green for accept */
    }

    .accept-button:hover {
        background-color: #1e7e34;
    }

    .decline-button {
        background-color: #d9534f; /* Red for decline */
    }

    .decline-button:hover {
        background-color: #c9302c;
    }

    .no-requests {
        color: #777;
        font-size: 1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
        .pending-request-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .request-actions {
            margin-top: 10px;
        }
    }
</style>

<div class="container-fluid">
    <h2>Pending Connection Requests</h2>

    <?php if (empty($pending_requests)): ?>
        <p class="no-requests">No pending requests.</p>
    <?php else: ?>
        <ul class="pending-requests-list">
            <?php foreach ($pending_requests as $request): ?>
                <li class="pending-request-item">
                    <span class="requester-name"><?= $request->first_name . ' ' . $request->last_name ?></span>
                    <div class="request-actions">
                        <a href="<?= site_url('alumni_request/accept_request/' . $request->id) ?>" class="accept-button">Accept</a>
                        <a href="<?= site_url('alumni_request/decline_request/' . $request->id) ?>" class="decline-button">Decline</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>