<?php
$display_full_name = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
$student_number = $this->session->userdata('student_number') ? $this->session->userdata('student_number') : 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Network - AConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        :root {
            --primary: #8B1538;
            --primary-dark: #6B0F2A;
            --accent: #D4A574;
            --bg-page: #FAFAF8;
            --white: #FFFFFF;
            --text-main: #1F2937;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-page);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-main);
            line-height: 1.6;
        }

        .header-spacing {
            height: 70px;
        }

        .network-container {
            max-width: 1200px;
            margin: -40px auto 0 auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .page-title i {
            color: var(--primary);
            font-size: 2.2rem;
        }

        .header-card {
            background: var(--white);
            padding: 28px;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            margin-bottom: 32px;
            border: 1px solid var(--border);
        }

        .search-group {
            display: flex;
            background: var(--bg-page);
            border-radius: 30px;
            padding: 8px;
            border: 2px solid var(--border);
            transition: all 0.3s ease;
        }

        .search-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
        }

        .search-input {
            background: transparent;
            border: none;
            padding: 12px 20px;
            flex: 1;
            outline: none;
            font-size: 1rem;
            color: var(--text-main);
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        .btn-search {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 10px 28px;
            border-radius: 25px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
            font-size: 0.95rem;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .filter-bar {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            border-top: 1px solid var(--border);
            padding-top: 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            border: 2px solid var(--border);
            background: var(--white);
            color: var(--text-main);
            text-decoration: none !important;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border-color: var(--primary);
        }

        .alumni-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .alumni-card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .alumni-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
        }

        .card-banner {
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .profile-img-container {
            width: 90px;
            height: 90px;
            margin: -45px auto 12px;
            border-radius: 50%;
            border: 5px solid var(--white);
            overflow: hidden;
            background: var(--white);
            box-shadow: var(--shadow-lg);
        }

        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-body {
            padding: 0 20px 20px;
            text-align: center;
            flex-grow: 1;
        }

        .alumni-degree {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .alumni-name {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 0 12px 0;
            color: var(--text-main);
        }

        .batch-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            background: var(--bg-page);
            padding: 4px 12px;
            border-radius: 6px;
            display: inline-block;
        }

        .card-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
        }

        .btn-tile {
            flex: 1;
            padding: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            text-align: center;
            text-decoration: none !important;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-view {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: var(--white);
        }

        .btn-view:hover {
            background: var(--primary);
            color: var(--white);
        }

        .btn-connect {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .btn-connect:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .status-badge {
            background: var(--accent);
            color: var(--primary);
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .modal-content {
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            border-radius: 12px 12px 0 0;
        }

        .modal-header .close {
            color: var(--white);
        }

        .modal-profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid var(--white);
            margin-top: -60px;
            background: var(--white);
            object-fit: cover;
            box-shadow: var(--shadow-lg);
        }

        .info-section {
            background: var(--bg-page);
            border-radius: 10px;
            padding: 16px;
            margin-top: 16px;
            text-align: left;
            border: 1px solid var(--border);
        }

        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            display: block;
        }

        .info-text {
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 12px;
            display: block;
            color: var(--text-main);
        }

        .no-results {
            background: var(--white);
            border-radius: 12px;
            padding: 60px 20px;
            text-align: center;
            box-shadow: var(--shadow-md);
            border: 2px dashed var(--border);
        }

        .no-results i {
            font-size: 4rem;
            color: var(--primary);
            opacity: 0.2;
            margin-bottom: 16px;
        }

        .no-results h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 8px 0;
        }

        .no-results p {
            font-size: 1rem;
            color: var(--text-muted);
            margin: 0;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }

            .alumni-grid {
                grid-template-columns: 1fr;
            }

            .filter-bar {
                gap: 8px;
            }

            .filter-btn {
                padding: 6px 16px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<div class="header-spacing"></div>

<div class="network-container">
    <h2 class="page-title"><i class="fas fa-network-wired"></i> Alumni Network</h2>

    <div class="header-card">
        <form method="get" id="searchForm">
            <div class="search-group">
                <input type="text" id="searchInput" class="search-input" placeholder="Search by name, degree, or skills...">
                <button type="button" class="btn-search"><i class="fas fa-search mr-2"></i> Search</button>
            </div>
        </form>

        <div class="filter-bar">
            <div class="filter-btn active" data-filter="all"><i class="fas fa-users mr-2"></i> All Alumni</div>
            <div class="filter-btn" data-filter="connectable"><i class="fas fa-user-plus mr-2"></i> Connect</div>
            <div class="filter-btn" data-filter="pending"><i class="fas fa-hourglass-half mr-2"></i> Pending</div>
            <div class="filter-btn" data-filter="accepted"><i class="fas fa-check-circle mr-2"></i> Connections</div>
        </div>
    </div>

    <div class="alumni-grid" id="alumniListContainer">
        <?php if (!empty($alumni_list)): ?>
            <?php foreach ($alumni_list as $alumnus): ?>
                <?php 
                    $img_path = (isset($alumnus->profile_image) && !empty($alumnus->profile_image)) 
                                ? base_url('assets/uploads/alumni/' . $alumnus->profile_image) 
                                : base_url('assets/images/person-' . (strtolower($alumnus->gender ?? 'male') == 'female' ? 'female' : 'male') . '.png');
                ?>
                <div class="alumni-card-container" 
                     data-status="<?= htmlspecialchars($alumnus->connection_status ?: 'connectable') ?>" 
                     data-name="<?= htmlspecialchars(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?>" 
                     data-degree="<?= htmlspecialchars(strtolower($alumnus->degree)) ?>">
                    
                    <div class="alumni-card">
                        <div class="card-banner"></div>
                        <div class="profile-img-container">
                            <img src="<?= $img_path ?>" alt="<?= htmlspecialchars($alumnus->first_name) ?>">
                        </div>
                        
                        <div class="card-body">
                            <div class="alumni-degree"><?= htmlspecialchars($alumnus->degree ?: 'SDCA Alumni') ?></div>
                            <h5 class="alumni-name"><?= ucwords(htmlspecialchars(strtolower($alumnus->first_name . ' ' . $alumnus->last_name))) ?></h5>
                            <span class="batch-label">Class of <?= htmlspecialchars($alumnus->graduation_year) ?></span>
                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn-tile btn-view" data-toggle="modal" data-target="#profileModal<?= $alumnus->id ?>"><i class="fas fa-eye mr-1"></i> View</button>
                            
                            <?php if ($alumnus->connection_status == 'accepted'): ?>
                                <div class="status-badge"><i class="fas fa-check"></i> Linked</div>
                            <?php elseif ($alumnus->connection_status == 'pending'): ?>
                                <div class="status-badge"><i class="fas fa-clock"></i> Pending</div>
                            <?php else: ?>
                                <form method="post" action="<?= site_url('alumni/send_request') ?>" style="flex:1; display:flex;">
                                    <input type="hidden" name="receiver_id" value="<?= $alumnus->id ?>">
                                    <button type="submit" class="btn-tile btn-connect"><i class="fas fa-user-plus mr-1"></i> Connect</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="profileModal<?= $alumnus->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center" style="padding: 0 25px 25px 25px;">
                                <img src="<?= $img_path ?>" class="modal-profile-img" alt="<?= htmlspecialchars($alumnus->first_name) ?>">
                                <h4 class="mt-3 mb-0" style="font-weight: 700; color: var(--text-main);"><?= ucwords(htmlspecialchars(strtolower($alumnus->first_name . ' ' . $alumnus->last_name))) ?></h4>
                                <p class="text-primary font-weight-bold" style="color: var(--primary) !important; margin-top: 6px;"><?= htmlspecialchars($alumnus->degree) ?></p>

                                <div class="info-section">
                                    <span class="info-label">Current Role</span>
                                    <span class="info-text"><?= htmlspecialchars($alumnus->current_job ?: 'Not Provided') ?></span>
                                    
                                    <span class="info-label">Contact Email</span>
                                    <span class="info-text"><?= htmlspecialchars($alumnus->email ?: 'Private') ?></span>

                                    <span class="info-label">Skills</span>
                                    <div style="margin-top: 8px;">
                                        <?php 
                                            $skills = explode(',', $alumnus->technical_skills ?? ''); 
                                            if (!empty($skills) && $skills[0] !== ''): 
                                                foreach($skills as $s): 
                                                    if(!empty(trim($s))): 
                                        ?>
                                            <span class="badge badge-light border mr-1 mb-1" style="background: var(--accent); color: var(--primary); border: 1px solid var(--accent) !important;"><?= htmlspecialchars(trim($s)) ?></span>
                                        <?php 
                                                    endif; 
                                                endforeach; 
                                            else: 
                                        ?>
                                            <p style="color: var(--text-muted); font-size: 0.9rem;">No skills added</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <button class="btn btn-block mt-3" style="background: var(--primary); color: white; font-weight: 600;" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-results" style="grid-column: 1 / -1;">
                <i class="fas fa-user-slash"></i>
                <h3>No Alumni Found</h3>
                <p>No alumni members match your search criteria. Try adjusting your filters or search terms.</p>
            </div>
        <?php endif; ?>
    </div>

    <div id="noResultsMessage" class="no-results" style="display: none; grid-column: 1 / -1;">
        <i class="fas fa-search"></i>
        <h3>No Results Found</h3>
        <p>No alumni match your current search filters. Try adjusting your criteria.</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.alumni-card-container');
    const filters = document.querySelectorAll('.filter-btn');
    const search = document.getElementById('searchInput');
    const noResultsMessage = document.getElementById('noResultsMessage');

    function filterList() {
        const query = search.value.toLowerCase().trim();
        const activeFilter = document.querySelector('.filter-btn.active').getAttribute('data-filter');
        let visibleCount = 0;

        cards.forEach(card => {
            const status = card.getAttribute('data-status');
            const name = card.getAttribute('data-name');
            const degree = card.getAttribute('data-degree');
            
            const matchStatus = (activeFilter === 'all' || status === activeFilter);
            const matchSearch = query === '' || name.includes(query) || degree.includes(query);
            
            const shouldShow = matchStatus && matchSearch;
            card.style.display = shouldShow ? 'block' : 'none';
            
            if (shouldShow) visibleCount++;
        });

        if (visibleCount === 0) {
            noResultsMessage.style.display = 'grid';
        } else {
            noResultsMessage.style.display = 'none';
        }
    }

    filters.forEach(btn => {
        btn.addEventListener('click', function() {
            filters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');
            filterList();
        });
    });

    search.addEventListener('input', filterList);
});
</script>

</body>
</html>