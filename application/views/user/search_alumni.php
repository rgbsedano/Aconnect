<style>
    :root {
        --maroon: #700A0A;
        --maroon-dark: #5a0707;
        --white: #FFFFFF;
        --light-gray: #f8f9fa;
        --card-bg: #fff;
        --text-dark: #333;
        --border-gray: #eee;
    }

    .container-fluid {
        padding: 40px 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--light-gray);
        max-width: 900px;
        margin: auto;
    }

    h2 {
        color: var(--maroon);
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 25px;
        border-bottom: 2px solid var(--maroon);
        padding-bottom: 10px;
    }

    .search-input {
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 25px 0 0 25px;
        font-size: 1rem;
        outline: none;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .search-button {
        background-color: var(--maroon);
        color: var(--white);
        border: none;
        padding: 12px 20px;
        border-radius: 0 25px 25px 0;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.2s ease-in-out;
    }

    .search-button:hover {
        background-color: var(--maroon-dark);
    }
    
    .search-clear-btn {
        right: 45px !important;
        color: #999;
        transition: color 0.2s;
    }
    .search-clear-btn:hover {
        color: var(--maroon);
    }

    .filter-bar {
        background-color: var(--white);
        padding: 15px 20px;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }
    .filter-button {
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid var(--maroon);
        background-color: var(--white);
        color: var(--maroon);
        text-decoration: none;
    }
    .filter-button:hover:not(.active) {
        background-color: #f0f0f0;
    }
    .filter-button.active {
        background-color: var(--maroon);
        color: var(--white);
        border-color: var(--maroon);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .alumni-card-container {
        width: 100%;
        margin-bottom: 20px;
    }

    .alumni-card {
        background-color: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-gray);
        transition: transform 0.2s;
    }
    .alumni-card:hover {
        transform: translateY(-2px);
    }

    .profile-image-wrapper {
        width: 60px;
        height: 60px;
        min-width: 60px;
        margin-right: 15px;
        border: 3px solid var(--maroon);
        border-radius: 50%;
        overflow: hidden;
    }
    .profile-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .alumni-name h5 {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1.15rem;
    }
    .alumni-name small {
        color: #777;
        font-size: 0.9rem;
    }
    
    .alumni-info p {
        margin-bottom: 5px;
        font-size: 0.95rem;
    }
    .alumni-info strong {
        color: var(--maroon-dark);
        font-weight: 600;
    }

    .btn-view-profile {
        background-color: var(--maroon) !important;
        color: var(--white) !important;
        border: 1px solid var(--maroon);
        padding: 8px 18px;
        border-radius: 6px;
        transition: background-color 0.2s;
    }
    .btn-view-profile:hover {
        background-color: var(--maroon-dark) !important;
    }

    .btn-outline-primary {
        color: var(--maroon);
        border-color: var(--maroon);
        transition: all 0.2s;
        padding: 8px 18px;
        border-radius: 6px;
    }
    .btn-outline-primary:hover {
        background-color: var(--maroon);
        color: var(--white);
    }

    .badge-success { background-color: #28a745; }
    .badge-warning { background-color: #ffc107; }

    .card-footer {
        background-color: var(--light-gray);
        border-top: 1px solid #f0f0f0;
        border-radius: 0 0 12px 12px;
    }

    .modal-content {
        border-radius: 12px;
    }
    .modal-title b {
        color: var(--maroon);
    }
    .modal-body h6 {
        color: var(--maroon) !important;
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
        margin-top: 15px;
        font-weight: 600;
    }

    @media (max-width: 767.98px) {
        .search-input {
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .search-button {
            border-radius: 8px;
            margin-left: 0;
            width: 100%;
        }
        .search-clear-btn {
            right: 15px !important;
        }
    }
</style>

<div class="container-fluid">
    <h2>Search and Connect Alumni</h2>

    <form method="get" class="mb-4" id="searchForm">
        <div class="row">
            <div class="col-md-10 position-relative">
                <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search alumni by name or degree..." value="<?= $this->input->get('search') ?>">
                <input type="hidden" name="filter" id="currentFilter" value="<?= $this->input->get('filter') ?: 'all' ?>">

                <?php if ($this->input->get('search')): ?>
                    <button type="button" id="clearSearch" class="btn btn-sm btn-light position-absolute search-clear-btn">
                        &times;
                    </button>
                <?php endif; ?>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn search-button btn-block">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </div>
    </form>

    <div class="filter-bar">
        <a href="#" class="filter-button" data-filter="all">
            <i class="fas fa-users mr-1"></i> All Alumni
        </a>
        
        <a href="#" class="filter-button" data-filter="connectable">
            <i class="fas fa-user-plus mr-1"></i> Connect
        </a>
        
        <a href="#" class="filter-button" data-filter="pending">
            <i class="fas fa-clock mr-1"></i> Pending
        </a>
        
        <a href="#" class="filter-button" data-filter="connected">
            <i class="fas fa-check-circle mr-1"></i> Connected
        </a>
    </div>

    <div class="container mt-4 p-0">
        <div class="row" id="alumniListContainer">
            <?php foreach ($alumni_list as $alumnus): ?>
                <div class="col-md-12 alumni-card-container" data-status="<?= $alumnus->connection_status ?: 'connectable' ?>" data-name="<?= strtolower($alumnus->first_name . ' ' . $alumnus->last_name) ?>" data-degree="<?= strtolower($alumnus->degree) ?>">
                    <div class="card alumni-card">
                        <div class="card-body">
                            
                            <div class="d-flex align-items-center mb-3 border-bottom pb-3">
                                <div class="profile-image-wrapper">
                                    <?php if ($alumnus && isset($alumnus->profile_image)): ?>
                                        <img src="<?= base_url('assets/uploads/alumni/' . $alumnus->profile_image) ?>" alt="Profile Image">
                                    <?php elseif (strtolower($alumnus->gender) === 'male'): ?>
                                        <img src="<?php echo base_url('assets/images/person-male.png'); ?>" alt="My Photo">
                                    <?php else: ?>
                                        <img src="<?php echo base_url('assets/images/person-female.png'); ?>" alt="My Photo">
                                    <?php endif; ?>
                                </div>
                                <div class="alumni-name flex-grow-1">
                                    <h5 class="mb-0"><?= ucwords(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?></h5>
                                    <small><i class="fas fa-graduation-cap mr-1"></i> <?= $alumnus->degree ?: 'No Degree Listed' ?></small>
                                </div>
                            </div>

                            <div class="alumni-info mb-3">
                                <?php if (!empty($alumnus->current_job) || !empty($alumnus->current_job_organization)): ?>
                                <p class="mb-1">
                                    <i class="fas fa-briefcase text-muted mr-2"></i> 
                                    Job: <?= $alumnus->current_job ?: 'N/A' ?>
                                    <small class="text-secondary ml-2">@ <?= $alumnus->current_job_organization ?: 'N/A' ?></small>
                                </p>
                                <?php endif; ?>

                                <?php if (!empty($alumnus->phone) || !empty($alumnus->email)): ?>
                                <p class="mb-1">
                                    <i class="fas fa-phone-alt text-muted mr-2"></i> 
                                    Contact: <?= $alumnus->phone ?: 'N/A' ?>
                                    <i class="fas fa-envelope text-muted ml-3 mr-2"></i> 
                                    Email: <?= $alumnus->email ?: 'N/A' ?>
                                </p>
                                <?php endif; ?>
                                
                                <?php if (!empty($alumnus->soft_skills) || !empty($alumnus->technical_skills)): ?>
                                <p class="mb-1">
                                    <i class="fas fa-code text-muted mr-2"></i> 
                                    Skills: <?= !empty($alumnus->soft_skills) ? substr($alumnus->soft_skills, 0, 30) . '...' : '' ?>
                                </p>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                
                                <button type="button" class="btn btn-sm btn-view-profile" data-toggle="modal" data-target="#viewProfileModal<?= $alumnus->id ?>">
                                    <i class="fas fa-eye mr-1"></i> View Profile
                                </button>

                                <div>
                                    <?php if ($alumnus->connection_status == 'accepted'): ?>
                                        <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Connected</span>
                                    <?php elseif ($alumnus->connection_status == 'pending'): ?>
                                        <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Pending Request</span>
                                    <?php else: ?>
                                        <form method="post" action="<?= site_url('alumni/send_request') ?>" class="connect-form d-inline">
                                            <input type="hidden" name="receiver_id" value="<?= $alumnus->id ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-user-plus mr-1"></i> Connect
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <small class="text-muted">Graduated: <?= $alumnus->graduation_year ?></small>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="viewProfileModal<?= $alumnus->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewProfileModalLabel" style="color: var(--maroon);"><b><i class="fas fa-user-circle mr-2"></i> <?= ucwords(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?></b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <div class="profile-image-wrapper mx-auto mb-3" style="width: 100px; height: 100px; border-width: 4px;">
                                            <?php if ($alumnus && isset($alumnus->profile_image)): ?>
                                                <img src="<?= base_url('assets/uploads/alumni/' . $alumnus->profile_image) ?>" alt="Profile Image">
                                            <?php elseif (strtolower($alumnus->gender) === 'male'): ?>
                                                <img src="<?php echo base_url('assets/images/person-male.png'); ?>" alt="My Photo">
                                            <?php else: ?>
                                                <img src="<?php echo base_url('assets/images/person-female.png'); ?>" alt="My Photo">
                                            <?php endif; ?>
                                        </div>
                                        <p class="text-muted"><?= $alumnus->degree ?: 'N/A' ?></p>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-4">
                                            <h6><i class="fas fa-info-circle mr-2"></i> Profile Details</h6>
                                            <p><strong>Alumni ID:</strong> <?= !empty($alumnus->alumni_number) ? $alumnus->alumni_number : 'N/A' ?></p>
                                            <p><strong>Student Number:</strong> <?= !empty($alumnus->student_number) ? $alumnus->student_number : 'N/A' ?></p>
                                            <p><strong>Email:</strong> <?= !empty($alumnus->email) ? $alumnus->email : 'N/A' ?></p>
                                            <p><strong>Phone:</strong> <?= !empty($alumnus->phone) ? $alumnus->phone : 'N/A' ?></p>
                                            <p><strong>Graduation Year:</strong> <?= !empty($alumnus->graduation_year) ? $alumnus->graduation_year : 'N/A' ?></p>
                                            <p><strong>Degree:</strong> <?= !empty($alumnus->degree) ? $alumnus->degree : 'N/A' ?></p>
                                        </div>

                                        <div class="mb-4">
                                            <h6><i class="fas fa-briefcase mr-2"></i> Current Job</h6>
                                            <p><strong>Job Title:</strong> <?= !empty($alumnus->current_job) ? $alumnus->current_job : 'N/A' ?></p>
                                            <p><strong>Organization:</strong> <?= !empty($alumnus->current_job_organization) ? $alumnus->current_job_organization : 'N/A' ?></p>
                                            <p><strong>Job Duration:</strong> <?= !empty($alumnus->current_job_length) ? $alumnus->current_job_length : 'N/A' ?></p>
                                        </div>

                                        <div>
                                            <h6><i class="fas fa-code mr-2"></i> Skills</h6>
                                            <p><strong>Soft Skills:</strong> <span class="badge badge-secondary"><?= !empty($alumnus->soft_skills) ? str_replace(',', '</span> <span class="badge badge-secondary">', $alumnus->soft_skills) : 'N/A' ?></span></p>
                                            <p><strong>Technical Skills:</strong> <span class="badge badge-secondary"><?= !empty($alumnus->technical_skills) ? str_replace(',', '</span> <span class="badge badge-secondary">', $alumnus->technical_skills) : 'N/A' ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const alumniCards = document.querySelectorAll('.alumni-card-container');
        const filterButtons = document.querySelectorAll('.filter-button');
        const searchInput = document.getElementById('searchInput');
        const currentFilterInput = document.getElementById('currentFilter');
        const clearSearchBtn = document.getElementById('clearSearch');
        let activeFilter = currentFilterInput.value || 'all';

        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            
            alumniCards.forEach(card => {
                const status = card.getAttribute('data-status');
                const name = card.getAttribute('data-name');
                const degree = card.getAttribute('data-degree');
                
                let statusMatch;
                if (activeFilter === 'all') {
                    statusMatch = true;
                } else if (activeFilter === 'connectable') {
                    statusMatch = (status === 'connectable');
                } else {
                    statusMatch = (status === activeFilter);
                }

                const searchMatch = name.includes(searchTerm) || degree.includes(searchTerm);
                
                if (statusMatch && searchMatch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function setActiveButton(filter) {
            filterButtons.forEach(btn => {
                if (btn.getAttribute('data-filter') === filter) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
            activeFilter = filter;
            currentFilterInput.value = filter;
        }

        setActiveButton(activeFilter);
        applyFilters();

        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const filter = this.getAttribute('data-filter');
                setActiveButton(filter);
                applyFilters();
            });
        });

        searchInput.addEventListener('input', applyFilters);

        clearSearchBtn?.addEventListener('click', function () {
            searchInput.value = '';
            applyFilters();
        });
        
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            applyFilters();
        });
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</div>