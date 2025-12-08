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
        --info-blue: #007bff;
        --bulk-action-bg: #f7f7f7; /* New style for action bar */
    }
    
    .container-fluid {
        padding: 30px;
        background-color: var(--light-bg);
    }

    /* --- Alert/Flash Message Styles --- */
    .alert-message {
        padding: 12px 20px;
        margin-bottom: 20px;
        border-radius: var(--border-radius-lg);
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        font-weight: 500;
        border: 1px solid transparent;
        opacity: 1; /* For fade out animation */
        transition: opacity 0.5s ease;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }
    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }
    
    /* Heading */
    .section-heading {
        color: var(--primary-maroon);
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 25px;
        border-bottom: 2px solid var(--primary-maroon);
        padding-bottom: 5px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    /* New: Bulk Action Bar Style */
    .bulk-actions-bar {
        max-width: 800px;
        margin: -15px auto 20px auto; 
        padding: 10px 20px;
        background-color: var(--bulk-action-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-lg);
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .bulk-action-button {
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s, opacity 0.2s;
        border: 1px solid transparent;
    }
    .bulk-action-button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .bulk-accept {
        background-color: var(--success-green);
        color: white;
    }
    .bulk-decline {
        background-color: var(--danger-red);
        color: white;
    }

    .pending-requests-list {
        list-style: none;
        padding: 0;
        max-width: 800px; 
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
        transition: all 0.5s ease-in-out; /* For smooth removal */
    }

    .requester-info {
        display: flex;
        align-items: center;
        flex-grow: 1; /* Allows info to take available space */
    }

    /* Profile Image/Icon Styling */
    .profile-image-request {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        margin-right: 15px;
        object-fit: cover;
        border: 2px solid var(--border-color);
        background-color: #eee;
        color: var(--text-muted); /* Used for default icon */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .requester-name {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.1rem;
    }
    .requester-details {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .request-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
        margin-left: 15px;
    }

    /* Modern Buttons */
    .action-button {
        color: #fff;
        padding: 8px 15px;
        border-radius: 50px; 
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: background-color 0.2s, box-shadow 0.2s;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .action-button:hover {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .accept-button {
        background-color: var(--success-green); 
    }
    .decline-button {
        background-color: var(--danger-red); 
    }
    /* New: View Profile Button */
    .view-profile-button {
        background-color: var(--info-blue);
        color: white;
    }

    .no-requests {
        color: var(--text-muted);
        font-size: 1rem;
        padding: 25px 20px;
        background-color: #fff;
        border-radius: var(--border-radius-lg);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        border: 1px dashed var(--border-color); 
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }

    /* New: Simple Modal Overlay/Content */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.3s, visibility 0.3s;
    }
    .modal-overlay.active {
        visibility: visible;
        opacity: 1;
    }
    .modal-content {
        background: var(--card-bg);
        padding: 30px;
        border-radius: var(--border-radius-lg);
        max-width: 450px;
        width: 90%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        transform: translateY(-50px);
        transition: transform 0.3s;
    }
    .modal-overlay.active .modal-content {
        transform: translateY(0);
    }
    .modal-header {
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 10px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header h3 {
        margin: 0;
        color: var(--primary-maroon);
    }
    .modal-body p {
        margin-bottom: 10px;
        color: var(--text-dark);
    }
    .modal-body strong {
        color: var(--text-dark);
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
            width: 100%;
        }

        .request-actions {
            margin-top: 5px;
            width: 100%;
            justify-content: space-between;
            min-width: auto;
            margin-left: 0;
        }
        
        .action-button {
            flex-grow: 1; 
            justify-content: center;
            font-size: 0.85rem;
            padding: 7px 10px;
        }
        .bulk-actions-bar {
            justify-content: space-between;
            padding: 8px 15px;
        }
        .bulk-action-button {
            flex-grow: 1;
            text-align: center;
        }
    }
</style>

<div class="container-fluid">
    <h2 class="section-heading"><i class="fas fa-user-friends mr-2"></i> Pending Connection Requests</h2>

    <div id="flashMessageContainer">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert-message alert-success">
                <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert-message alert-error">
                <i class="fas fa-exclamation-triangle mr-2"></i> <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div id="bulkActionsBar" class="bulk-actions-bar" style="display: <?= empty($pending_requests) ? 'none' : 'flex' ?>;">
        <span class="text-muted" style="margin-right: auto; align-self: center; font-size: 0.9rem;">
            Total Pending: <strong id="requestCount"><?= count($pending_requests ?? []) ?></strong>
        </span>
        <button type="button" class="bulk-action-button bulk-accept js-bulk-accept" disabled>
            <i class="fas fa-users-up"></i> Accept All
        </button>
        <button type="button" class="bulk-action-button bulk-decline js-bulk-decline" disabled>
            <i class="fas fa-users-slash"></i> Decline All
        </button>
    </div>

    <?php if (empty($pending_requests)): ?>
        <p id="noRequestsMessage" class="no-requests">No pending connection requests at the moment.</p>
    <?php else: ?>
        <ul id="requestsList" class="pending-requests-list">
            <?php foreach ($pending_requests as $request): ?>
                <?php
                    // --- Profile Image Logic ---
                    $profileImage = base_url('assets/images/default-profile.png'); // Default fallback
                    $faIcon = '';
                    if (!empty($request->profile_image)) {
                        $profileImage = base_url('assets/uploads/alumni/' . $request->profile_image);
                    } else {
                        // Use Font Awesome Icon fallback inside the element if no image
                        $faIcon = '<i class="fas fa-user-circle"></i>';
                    }
                    // Additional mock data for modal to enrich details
                    $request->course = $request->course ?? 'BS Computer Science';
                    $request->batch_year = $request->batch_year ?? '2018';
                    $request->current_job = $request->current_job ?? 'Software Engineer at Google';
                ?>
                <li class="pending-request-item" 
                    id="request-<?= $request->id ?>"
                    data-id="<?= $request->id ?>"
                    data-name="<?= htmlspecialchars($request->first_name) ?>"
                    data-course="<?= htmlspecialchars($request->course) ?>"
                    data-batch="<?= htmlspecialchars($request->batch_year) ?>"
                    data-job="<?= htmlspecialchars($request->current_job) ?>"
                    data-img="<?= htmlspecialchars($profileImage) ?>"
                    >
                    <div class="requester-info">
                        <?php if (!empty($faIcon)): ?>
                            <div class="profile-image-request">
                                <?= $faIcon ?>
                            </div>
                        <?php else: ?>
                            <img src="<?= $profileImage ?>" alt="<?= htmlspecialchars($request->first_name) ?>'s profile" class="profile-image-request">
                        <?php endif; ?>
                        
                        <div>
                            <span class="requester-name"><?= $request->first_name . ' ' . $request->last_name ?></span>
                            <div class="requester-details">
                                <?= $request->course . ', Class of ' . $request->batch_year ?>
                            </div>
                        </div>
                    </div>
                    <div class="request-actions">
                        <button type="button" class="action-button view-profile-button js-view-profile">
                            <i class="fas fa-eye"></i> View
                        </button>
                        
                        <button type="button" 
                                data-id="<?= $request->id ?>" 
                                data-name="<?= htmlspecialchars($request->first_name) ?>"
                                class="action-button accept-button js-accept-request">
                            <i class="fas fa-check"></i> Accept
                        </button>
                        
                        <button type="button" 
                                data-id="<?= $request->id ?>" 
                                data-name="<?= htmlspecialchars($request->first_name) ?>"
                                class="action-button decline-button js-decline-request">
                            <i class="fas fa-times"></i> Decline
                        </button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<div id="profileModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalName">Requester's Profile</h3>
            <button class="action-button decline-button" onclick="closeModal()">
                <i class="fas fa-times"></i> Close
            </button>
        </div>
        <div class="modal-body">
            <div style="text-align: center; margin-bottom: 20px;">
                <img id="modalImage" src="" alt="Profile Image" class="profile-image-request" style="width: 80px; height: 80px; margin: 0 auto;">
            </div>
            <p><strong>Course:</strong> <span id="modalCourse"></span></p>
            <p><strong>Batch:</strong> <span id="modalBatch"></span></p>
            <p><strong>Current Job:</strong> <span id="modalJob"></span></p>
            <div style="margin-top: 20px; text-align: right;">
                <button id="modalAcceptBtn" class="action-button accept-button">
                    <i class="fas fa-check"></i> Accept Connection
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // --- ADDITIONAL FUNCTIONS & AJAX IMPLEMENTATION ---
    document.addEventListener('DOMContentLoaded', function() {
        const list = document.getElementById('requestsList');
        const noRequestsMsg = document.getElementById('noRequestsMessage');
        const flashContainer = document.getElementById('flashMessageContainer');
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        const requestCountSpan = document.getElementById('requestCount');

        const bulkAcceptBtn = document.querySelector('.js-bulk-accept');
        const bulkDeclineBtn = document.querySelector('.js-bulk-decline');

        const modal = document.getElementById('profileModal');
        const modalAcceptBtn = document.getElementById('modalAcceptBtn');
        
        // Initial setup for bulk buttons
        updateBulkButtons();

        // Function to display an ephemeral flash message
        function displayFlash(type, message) {
            const alertClass = (type === 'success') ? 'alert-success' : 'alert-error';
            const icon = (type === 'success') ? '<i class="fas fa-check-circle mr-2"></i>' : '<i class="fas fa-exclamation-triangle mr-2"></i>';
            const alertHtml = `<div class="alert-message ${alertClass}">${icon} ${message}</div>`;
            
            // Remove previous alert if any
            flashContainer.innerHTML = ''; 

            flashContainer.insertAdjacentHTML('afterbegin', alertHtml);
            const newAlert = flashContainer.querySelector('.alert-message');

            setTimeout(() => {
                if (newAlert) newAlert.style.opacity = '0';
                setTimeout(() => { if (newAlert) newAlert.remove(); }, 500);
            }, 5000);
        }

        // Function to update the visibility and state of the bulk action buttons
        function updateBulkButtons() {
            const count = list ? list.childElementCount : 0;
            requestCountSpan.textContent = count;
            
            if (count > 0) {
                bulkActionsBar.style.display = 'flex';
                bulkAcceptBtn.disabled = false;
                bulkDeclineBtn.disabled = false;
                noRequestsMsg.style.display = 'none';
            } else {
                bulkActionsBar.style.display = 'none';
                if (noRequestsMsg) noRequestsMsg.style.display = 'block';
            }
        }

        // Function to remove request item from DOM with animation
        function removeRequestItem(requestId, duration = 500) {
            const item = document.getElementById(`request-${requestId}`);
            if (!item) return;

            item.style.height = item.offsetHeight + 'px'; // Fix height before reducing
            requestAnimationFrame(() => {
                item.style.opacity = '0';
                item.style.padding = '0';
                item.style.margin = '0';
                item.style.height = '0';
            });

            setTimeout(() => {
                item.remove();
                updateBulkButtons(); // Re-check list after removal
            }, duration);
        }

        // Handles the SINGLE AJAX request
        function handleRequest(requestId, name, action) {
            const url = "<?= site_url('alumni_request/') ?>" + action + '/' + requestId;
            const confirmation = (action === 'accept_request') 
                ? `Are you sure you want to accept the connection request from ${name}?`
                : `Are you sure you want to decline the connection request from ${name}?`;

            if (!confirm(confirmation)) {
                return;
            }

            fetch(url, { method: 'POST' })
            .then(response => response.json()) 
            .then(data => {
                if (data.status === 'success') {
                    displayFlash('success', data.message || `Request from ${name} ${action.replace('_request', 'ed')}.`);
                    removeRequestItem(requestId);
                } else {
                    displayFlash('error', data.message || `Failed to process request from ${name}.`);
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                displayFlash('error', `An unexpected error occurred while processing the request.`);
            });
        }
        
        // --- NEW FUNCTION: Bulk Action Handler ---
        function handleBulkAction(action) {
            const items = list.querySelectorAll('.pending-request-item');
            const requestIds = Array.from(items).map(item => item.getAttribute('data-id'));
            
            if (requestIds.length === 0) {
                displayFlash('error', 'No pending requests to process.');
                return;
            }

            const actionName = action === 'accept_request' ? 'Accept' : 'Decline';
            const confirmation = `Are you sure you want to ${actionName} ALL ${requestIds.length} pending requests? This cannot be undone.`;

            if (!confirm(confirmation)) {
                return;
            }

            // Endpoint for bulk action (assuming a new CI controller method 'bulk_action')
            const url = "<?= site_url('alumni_request/bulk_action') ?>"; 

            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: action, ids: requestIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    displayFlash('success', data.message || `${actionName}ed ${data.processed_count || requestIds.length} requests successfully.`);
                    
                    // Smoothly remove all items
                    items.forEach((item, index) => {
                        // Stagger the removal slightly for visual effect
                        setTimeout(() => removeRequestItem(item.id.replace('request-', ''), 300), index * 50); 
                    });

                } else {
                    displayFlash('error', data.message || `Bulk ${actionName} failed. Please try again.`);
                }
            })
            .catch(error => {
                console.error('Bulk AJAX Error:', error);
                displayFlash('error', `An unexpected error occurred during the bulk action.`);
            });
        }


        // --- NEW FUNCTION: Modal Handlers (View Profile) ---
        
        let currentRequestId = null; // Store ID for modal accept button

        function openModal(requestData) {
            currentRequestId = requestData.id;
            document.getElementById('modalName').textContent = requestData.name;
            document.getElementById('modalCourse').textContent = requestData.course;
            document.getElementById('modalBatch').textContent = requestData.batch;
            document.getElementById('modalJob').textContent = requestData.job;
            document.getElementById('modalImage').src = requestData.img;
            
            modalAcceptBtn.setAttribute('data-id', requestData.id);
            modalAcceptBtn.setAttribute('data-name', requestData.name);
            modalAcceptBtn.onclick = function() {
                // Trigger the main accept handler and then close the modal
                closeModal();
                handleRequest(requestData.id, requestData.name, 'accept_request');
            };
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        window.closeModal = function() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
            currentRequestId = null;
        }

        // --- Event Delegation ---

        // Listen for clicks on the request list
        if (list) {
            list.addEventListener('click', function(e) {
                const viewTarget = e.target.closest('.js-view-profile');
                const actionTarget = e.target.closest('.js-accept-request, .js-decline-request');

                if (viewTarget) {
                    e.preventDefault();
                    const item = viewTarget.closest('.pending-request-item');
                    const requestData = {
                        id: item.getAttribute('data-id'),
                        name: item.getAttribute('data-name'),
                        course: item.getAttribute('data-course'),
                        batch: item.getAttribute('data-batch'),
                        job: item.getAttribute('data-job'),
                        img: item.getAttribute('data-img')
                    };
                    openModal(requestData);
                } else if (actionTarget) {
                    e.preventDefault();
                    
                    const requestId = actionTarget.getAttribute('data-id');
                    const name = actionTarget.getAttribute('data-name');
                    let action = actionTarget.classList.contains('js-accept-request') ? 'accept_request' : 'decline_request';

                    if (requestId && action) {
                        handleRequest(requestId, name, action);
                    }
                }
            });
        }

        // Bulk Action Listeners
        bulkAcceptBtn.addEventListener('click', () => handleBulkAction('accept_request'));
        bulkDeclineBtn.addEventListener('click', () => handleBulkAction('decline_request'));

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    });
</script>