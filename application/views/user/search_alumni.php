<style>
    /* 🎨 SOCIAL MEDIA FEED STYLE */
    :root {
        --primary-maroon: #700A0A; /* SDCA Primary Color */
        --success-green: #28a745; 
        --warning-orange: #ffc107;
        --light-bg: #f0f2f5; /* Facebook/LinkedIn-like light background */
        --card-bg: #ffffff;
        --text-dark: #1c1e21; /* Darker text for readability */
        --text-muted: #606770;
        --border-color: #dddfe2;
        --border-radius-lg: 12px; /* Smoother, larger radius for cards */
        --border-radius-sm: 8px;
        --shadow-subtle: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container-fluid {
        padding: 20px 10px; 
        background-color: var(--light-bg);
    }

    /* --- Header & Search Area --- */
    .header-area {
        max-width: 800px;
        margin: 0 auto 20px;
    }

    .section-heading {
        color: var(--text-dark);
        font-size: 1.8rem; 
        font-weight: 700;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .user-guidance {
        color: var(--text-muted);
        font-size: 0.9rem; 
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }

    /* Filters (as 'Chips') */
    .filter-buttons {
        display: flex;
        gap: 8px; 
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .btn-filter {
        background: var(--card-bg);
        color: var(--text-dark);
        border: 1px solid var(--border-color);
        padding: 8px 15px; /* Comfortable padding */
        border-radius: 50px; /* Pill/Chip shape */
        font-size: 0.9rem; 
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-filter.active {
        background: var(--primary-maroon);
        color: white;
        border-color: var(--primary-maroon);
        font-weight: 600;
    }
    
    .btn-filter:hover:not(.active) {
        background: #e9e9e9;
    }

    /* Search Input & Button */
    .search-input-group {
        position: relative;
    }
    
    .form-control-compact {
        padding: 10px 15px; 
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        font-size: 1rem; 
        height: 45px; 
        width: 100%;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    
    .btn-search-compact {
        background: var(--primary-maroon) !important;
        color: white;
        border: none;
        height: 45px; 
        border-radius: var(--border-radius-sm);
        font-weight: 600;
        font-size: 1rem;
        transition: background-color 0.2s;
        width: 100%;
    }

    .clear-search-btn {
        right: 15px; 
        color: var(--text-muted);
        opacity: 0.8;
        font-size: 1.5rem;
    }

    /* --- Alumni Feed (Grid) --- */
    .alumni-grid {
        max-width: 800px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 15px; /* Vertical stacking like a feed */
    }

    /* Individual Card Style (Post-like) */
    .alumni-card {
        background-color: var(--card-bg);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-subtle);
        padding: 15px;
        transition: box-shadow 0.2s;
    }

    /* Card Header (Profile & Status) */
    .profile-info-compact {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0; /* Subtle separator */
    }

    .profile-details {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .profile-image-thumb {
        width: 55px; /* Slightly larger image */
        height: 55px;
        min-width: 55px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid var(--primary-maroon); /* Stronger border */
        flex-shrink: 0; 
    }
    
    .alumni-details-text h5 {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1.1rem; 
        margin-bottom: 0;
        line-height: 1.3;
    }
    
    .alumni-details-text small {
        color: var(--text-muted);
        font-size: 0.85rem; 
        display: block;
    }

    /* Condensed Info Block */
    .alumni-summary {
        padding: 5px 0 15px;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 15px;
    }
    
    .alumni-summary p {
        margin-bottom: 3px;
        font-size: 0.9rem;
        color: var(--text-dark);
    }
    
    .alumni-summary strong {
        color: var(--primary-maroon);
        font-weight: 600;
        margin-right: 5px;
    }

    /* Card Actions (Footer) */
    .card-actions-compact {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-card-action {
        padding: 8px 15px; 
        border-radius: var(--border-radius-sm);
        font-size: 0.9rem; 
        font-weight: 600;
        transition: background-color 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        flex-grow: 1; /* Make buttons fill space */
        justify-content: center;
        margin: 0 5px;
    }

    .btn-view-profile-compact {
        background-color: #6c757d; 
        color: white;
        border: none;
    }

    .btn-connect-alumni-compact {
        background-color: var(--success-green);
        color: white;
        border: none;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 10px; 
        font-size: 0.8rem; 
        font-weight: 600;
        border-radius: 50px; /* Pill shape */
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-connected {
        background-color: var(--success-green);
        color: white;
    }

    .badge-pending {
        background-color: var(--warning-orange);
        color: var(--text-dark);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 10px;
        }
        .section-heading {
            font-size: 1.6rem;
        }
        .filter-buttons {
            gap: 5px;
        }
        .btn-filter {
            padding: 6px 10px;
            font-size: 0.85rem;
        }
        .search-row .col-md-10, .search-row .col-md-2 {
             /* Ensure they stack properly on mobile */
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 10px;
        }
        .card-actions-compact {
            flex-direction: column;
            gap: 10px;
        }
        .btn-card-action {
            width: 100%;
            margin: 0;
        }
        .profile-image-thumb {
            width: 50px;
            height: 50px;
            min-width: 50px;
        }
        .alumni-details-text h5 {
            font-size: 1rem;
        }
        .alumni-details-text small {
            font-size: 0.8rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearch');
        const filterButtons = document.querySelectorAll('.btn-filter');
        const hiddenFilterInput = document.getElementById('filter_status');
        
        // --- Search Functionality ---
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                hiddenFilterInput.value = ''; 
                searchForm.submit();
            });
        }
        
        // --- Filter Functionality ---
        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const filterValue = this.getAttribute('data-filter');
                
                // Toggle logic
                if (this.classList.contains('active')) {
                    hiddenFilterInput.value = '';
                } else {
                    hiddenFilterInput.value = filterValue;
                }
                
                searchInput.value = ''; 
                searchForm.submit();
            });
        });
        
        // --- Active Filter Class Persistence ---
        const currentFilter = hiddenFilterInput.value;
        if (currentFilter !== null && currentFilter !== '') {
            filterButtons.forEach(button => {
                if (button.getAttribute('data-filter') === currentFilter) {
                    button.classList.add('active');
                } else {
                    button.classList.remove('active');
                }
            });
        } else {
            // Default: 'All Alumni' is active
            const allAlumniBtn = document.querySelector('.btn-filter[data-filter=""]');
            if (allAlumniBtn) {
                allAlumniBtn.classList.add('active');
            }
        }
    });
</script>

<div class="container-fluid">
    <div class="header-area">
        <h2 class="section-heading"><i class="fas fa-users-class"></i> Alumni Feed</h2>
        <p class="user-guidance">
            Connect with peers! Find alumni by name, degree, or ID below. Use the filters to view specific connection statuses.
        </p>

        <div class="search-filter-controls">
            <div class="filter-buttons">
                <button class="btn-filter" data-filter=""><i class="fas fa-globe"></i> All Alumni</button>
                <button class="btn-filter" data-filter="connected"><i class="fas fa-user-check"></i> Connected</button>
                <button class="btn-filter" data-filter="pending"><i class="fas fa-history"></i> Requests Sent</button>
            </div>
            
            <form method="get" class="row align-items-center g-3" id="searchForm">
                <input type="hidden" name="filter_status" id="filter_status" value="<?= $this->input->get('filter_status') ?>">
                
                <div class="col-md-10 position-relative search-input-group">
                    <input type="text" name="search" id="searchInput" class="form-control-compact" placeholder="Search alumni (e.g., Jane Doe, BSIT, 12345)..." value="<?= $this->input->get('search') ?>">
                    <?php if ($this->input->get('search')): ?>
                        <button type="button" id="clearSearch" class="btn btn-sm btn-light position-absolute clear-search-btn">
                            &times;
                        </button>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn-search-compact btn-block"><i class="fas fa-magnifying-glass"></i> Find</button>
                </div>
            </form>
        </div>
    </div>

    <div class="alumni-grid">
        <?php if (!empty($alumni_list)): ?>
            <?php foreach ($alumni_list as $alumnus): ?>
                <?php 
                    $current_filter = $this->input->get('filter_status');
                    $display_alumnus = true;
                    
                    if (!empty($current_filter)) {
                        if ($current_filter === 'connected' && $alumnus->connection_status !== 'accepted') {
                            $display_alumnus = false;
                        } elseif ($current_filter === 'pending' && $alumnus->connection_status !== 'pending') {
                            $display_alumnus = false;
                        }
                    }

                    // --- Image Logic (Repeated for display) ---
                    $profileImage = base_url('assets/images/placeholder.png'); // Default generic placeholder
                    if ($alumnus && isset($alumnus->profile_image)) {
                        $profileImage = base_url('assets/uploads/alumni/' . $alumnus->profile_image);
                    } elseif (strtolower($alumnus->gender) === 'male') {
                        $profileImage = base_url('assets/images/person-male.png');
                    } elseif (strtolower($alumnus->gender) === 'female') {
                        $profileImage = base_url('assets/images/person-female.png');
                    }
                ?>
                
                <?php if ($display_alumnus): ?>
                    <div class="alumni-card">
                        <div class="profile-info-compact">
                            <div class="profile-details">
                                <div class="profile-image-thumb">
                                    <img src="<?= $profileImage ?>" alt="Profile Image">
                                </div>
                                <div class="alumni-details-text">
                                    <h5><?= ucwords(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?></h5>
                                    <small><?= $alumnus->degree ?: 'No Degree Listed' ?></small>
                                </div>
                            </div>

                            <div>
                                <?php if ($alumnus->connection_status == 'accepted'): ?>
                                    <span class="status-badge badge-connected"><i class="fas fa-check-circle"></i> Connected</span>
                                <?php elseif ($alumnus->connection_status == 'pending'): ?>
                                    <span class="status-badge badge-pending"><i class="fas fa-clock"></i> Pending</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="alumni-summary">
                            <p><strong>Job:</strong> <?= !empty($alumnus->current_job) ? $alumnus->current_job : 'N/A' ?> @ <?= !empty($alumnus->current_job_organization) ? $alumnus->current_job_organization : 'N/A' ?></p>
                            <p><strong>Graduation Year:</strong> <?= $alumnus->graduation_year ?: 'N/A' ?></p>
                            <p><strong>Skills:</strong> <?= !empty($alumnus->technical_skills) ? substr($alumnus->technical_skills, 0, 50) . '...' : 'N/A' ?></p>
                        </div>

                        <div class="card-actions-compact">
                            <button type="button" class="btn btn-card-action btn-view-profile-compact" data-toggle="modal" data-target="#viewProfileModal<?= $alumnus->id ?>">
                                <i class="fas fa-id-card-clip"></i> View Profile
                            </button>

                            <?php if ($alumnus->connection_status !== 'accepted' && $alumnus->connection_status !== 'pending'): ?>
                                <form method="post" action="<?= site_url('alumni/send_request') ?>" class="d-inline" style="flex-grow: 1;">
                                    <input type="hidden" name="receiver_id" value="<?= $alumnus->id ?>">
                                    <button type="submit" class="btn btn-card-action btn-connect-alumni-compact">
                                        <i class="fas fa-link"></i> Connect
                                    </button>
                                </form>
                            <?php elseif ($alumnus->connection_status == 'accepted'): ?>
                                <button type="button" class="btn btn-card-action" style="background-color: #007bff; color: white; flex-grow: 1;"><i class="fas fa-comment"></i> Message</button>
                            <?php else: ?>
                                <button type="button" class="btn btn-card-action" style="background-color: #ccc; color: #333; flex-grow: 1;" disabled><i class="fas fa-reply-all"></i> Request Sent</button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="modal fade" id="viewProfileModal<?= $alumnus->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header modal-header-custom">
                                    <h5 class="modal-title modal-title-custom" id="viewProfileModalLabel">
                                        <?= ucwords(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body modal-body-custom">
                                    <div class="row">
                                        <div class="col-md-4 text-center mb-3">
                                            <div class="profile-image-container">
                                                <img src="<?= $profileImage ?>" alt="Profile Image" style="border-radius: 50%; width: 100px; height: 100px; object-fit: cover;">
                                            </div>
                                            <p class="mb-0"><strong><?= $alumnus->degree ?: 'N/A' ?></strong></p>
                                            <p class="text-muted">Graduated: <?= $alumnus->graduation_year ?: 'N/A' ?></p>
                                        </div>
                                        <div class="col-md-8">
                                            <h6>Contact & ID</h6>
                                            <p><strong>Alumni ID:</strong> <?= !empty($alumnus->alumni_number) ? $alumnus->alumni_number : 'N/A' ?></p>
                                            <p><strong>Email:</strong> <?= !empty($alumnus->email) ? $alumnus->email : 'N/A' ?></p>
                                            <p><strong>Phone:</strong> <?= !empty($alumnus->phone) ? $alumnus->phone : 'N/A' ?></p>

                                            <h6>Employment</h6>
                                            <p><strong>Job Title:</strong> <?= !empty($alumnus->current_job) ? $alumnus->current_job : 'N/A' ?></p>
                                            <p><strong>Organization:</strong> <?= !empty($alumnus->current_job_organization) ? $alumnus->current_job_organization : 'N/A' ?></p>
                                            <p><strong>Job Duration:</strong> <?= !empty($alumnus->current_job_length) ? $alumnus->current_job_length : 'N/A' ?></p>

                                            <h6>Skills & Location</h6>
                                            <p><strong>Technical Skills:</strong> <?= !empty($alumnus->technical_skills) ? $alumnus->technical_skills : 'N/A' ?></p>
                                            <p><strong>Location:</strong> <?= !empty($alumnus->current_address) ? $alumnus->current_address : 'N/A' ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alumni-card">
                <div class="alert alert-info text-center" role="alert" style="margin-bottom: 0;">
                    <i class="fas fa-info-circle"></i> No alumni found matching your criteria. Try adjusting your search or filters.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>