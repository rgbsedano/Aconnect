<?php
/**
 * Alumni Networking Page
 * Features: LinkedIn-style grid, centered modals, and persistent filter system.
 */
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    :root {
        --maroon: #700A0A;
        --maroon-dark: #5a0707;
        --maroon-light: #fdf2f2;
        --white: #FFFFFF;
        --bg-gray: #F3F2EF;
        --text-main: #191919;
        --text-sub: #666666;
        --border-color: #E0E0E0;
        --radius: 10px;
        --shadow: 0 0 0 1px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.08);
    }

    body {
        background-color: var(--bg-gray);
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
    }

    .network-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
    }

    /* Page Heading */
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title i { color: var(--maroon); }

    /* Search & Filter Header */
    .header-card {
        background: var(--white);
        padding: 24px;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 24px;
    }

    .search-group {
        display: flex;
        background: #f0f2f5;
        border-radius: 30px;
        padding: 5px;
        border: 1px solid transparent;
        transition: 0.2s;
    }

    .search-group:focus-within {
        background: var(--white);
        border-color: var(--maroon);
        box-shadow: 0 0 0 1px var(--maroon);
    }

    .search-input {
        background: transparent;
        border: none;
        padding: 10px 20px;
        flex: 1;
        outline: none;
        font-size: 0.95rem;
    }

    .btn-search {
        background: var(--maroon);
        color: white;
        border: none;
        padding: 8px 25px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
    }

    .filter-bar {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        border-top: 1px solid var(--border-color);
        padding-top: 15px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid var(--text-sub);
        background: var(--white);
        color: var(--text-sub);
        text-decoration: none !important;
        transition: 0.2s;
    }

    .filter-btn:hover { background: #f3f3f3; }

    .filter-btn.active {
        background: var(--maroon-light);
        color: var(--maroon);
        border-color: var(--maroon);
    }

    /* Alumni Grid */
    .alumni-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .alumni-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }

    .alumni-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .card-banner {
        height: 60px;
        background: linear-gradient(135deg, var(--maroon) 0%, #a31a1a 100%);
        border-radius: var(--radius) var(--radius) 0 0;
    }

    .profile-img-container {
        width: 85px;
        height: 85px;
        margin: -45px auto 10px;
        border-radius: 50%;
        border: 4px solid white;
        overflow: hidden;
        background: white;
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

    .alumni-name {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
    }

    .alumni-degree {
        font-size: 0.85rem;
        color: var(--maroon);
        font-weight: 600;
        margin-bottom: 5px;
    }

    .batch-label {
        font-size: 0.75rem;
        color: var(--text-sub);
        background: #f0f2f5;
        padding: 2px 10px;
        border-radius: 4px;
    }

    .card-footer {
        padding: 15px 20px;
        border-top: 1px solid #f0f2f5;
        display: flex;
        gap: 10px;
    }

    .btn-tile {
        flex: 1;
        padding: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 6px;
        text-align: center;
        text-decoration: none !important;
        cursor: pointer;
    }

    .btn-view { border: 1px solid #ccc; color: var(--text-main); }
    .btn-connect { background: var(--maroon); color: white !important; border: 1px solid var(--maroon); }
    .status-badge { background: #eee; color: #777; flex: 1; padding: 8px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; }

    /* Centered Modal Styles */
    .modal {
        text-align: center;
        padding: 0 !important;
    }

    .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
        width: 100%;
        max-width: 450px;
    }

    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .modal-header {
        background: var(--maroon);
        color: white;
        border: none;
        height: 80px;
        border-radius: 15px 15px 0 0;
    }

    .modal-close {
        color: white;
        background: transparent;
        border: none;
        font-size: 1.5rem;
        position: absolute;
        right: 15px;
        top: 10px;
    }

    .modal-profile-img {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        border: 5px solid white;
        margin-top: -55px;
        background: white;
        object-fit: cover;
    }

    .info-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-top: 15px;
        text-align: left;
    }

    .info-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #999;
        font-weight: 700;
        margin-bottom: 2px;
        display: block;
    }

    .info-text {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 10px;
        display: block;
    }
</style>

<div class="network-container">
    <h2 class="page-title"><i class="fas fa-network-wired"></i> Alumni Network</h2>

    <div class="header-card">
        <form method="get" id="searchForm">
            <div class="search-group">
                <input type="text" id="searchInput" class="search-input" placeholder="Search by name, degree, or skills...">
                <button type="button" class="btn-search">Search</button>
            </div>
        </form>

        <div class="filter-bar">
            <div class="filter-btn active" data-filter="all">All Alumni</div>
            <div class="filter-btn" data-filter="connectable">Connect</div>
            <div class="filter-btn" data-filter="pending">Pending</div>
            <div class="filter-btn" data-filter="accepted">Connections</div>
        </div>
    </div>

    <div class="alumni-grid" id="alumniListContainer">
        <?php foreach ($alumni_list as $alumnus): ?>
            <?php 
                $img_path = (isset($alumnus->profile_image) && !empty($alumnus->profile_image)) 
                            ? base_url('assets/uploads/alumni/' . $alumnus->profile_image) 
                            : base_url('assets/images/person-' . (strtolower($alumnus->gender ?? 'male') == 'female' ? 'female' : 'male') . '.png');
            ?>
            <div class="alumni-card-container" 
                 data-status="<?= $alumnus->connection_status ?: 'connectable' ?>" 
                 data-name="<?= strtolower($alumnus->first_name . ' ' . $alumnus->last_name) ?>" 
                 data-degree="<?= strtolower($alumnus->degree) ?>">
                
                <div class="alumni-card">
                    <div class="card-banner"></div>
                    <div class="profile-img-container">
                        <img src="<?= $img_path ?>" alt="Profile">
                    </div>
                    
                    <div class="card-body">
                        <div class="alumni-degree"><?= $alumnus->degree ?: 'SDCA Alumni' ?></div>
                        <h5 class="alumni-name"><?= ucwords(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?></h5>
                        <span class="batch-label">Class of <?= $alumnus->graduation_year ?></span>
                    </div>

                    <div class="card-footer">
                        <div class="btn-tile btn-view" data-toggle="modal" data-target="#profileModal<?= $alumnus->id ?>">View</div>
                        
                        <?php if ($alumnus->connection_status == 'accepted'): ?>
                            <div class="status-badge"><i class="fas fa-check"></i> Linked</div>
                        <?php elseif ($alumnus->connection_status == 'pending'): ?>
                            <div class="status-badge">Pending</div>
                        <?php else: ?>
                            <form method="post" action="<?= site_url('alumni/send_request') ?>" style="flex:1; display:flex;">
                                <input type="hidden" name="receiver_id" value="<?= $alumnus->id ?>">
                                <button type="submit" class="btn-tile btn-connect">Connect</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="profileModal<?= $alumnus->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body text-center" style="padding: 0 25px 25px 25px;">
                            <img src="<?= $img_path ?>" class="modal-profile-img" alt="User">
                            <h4 class="mt-2 mb-0" style="font-weight: 700;"><?= ucwords(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?></h4>
                            <p class="text-maroon font-weight-bold"><?= $alumnus->degree ?></p>

                            <div class="info-section">
                                <span class="info-label">Current Role</span>
                                <span class="info-text"><?= $alumnus->current_job ?: 'Not Provided' ?></span>
                                
                                <span class="info-label">Contact Email</span>
                                <span class="info-text"><?= $alumnus->email ?: 'Private' ?></span>

                                <span class="info-label">Skills</span>
                                <div style="margin-top: 5px;">
                                    <?php $skills = explode(',', $alumnus->technical_skills); 
                                    foreach($skills as $s): if(!empty($s)): ?>
                                        <span class="badge badge-light border mr-1"><?= trim($s) ?></span>
                                    <?php endif; endforeach; ?>
                                </div>
                            </div>
                            <button class="btn btn-block btn-outline-secondary mt-3" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.alumni-card-container');
    const filters = document.querySelectorAll('.filter-btn');
    const search = document.getElementById('searchInput');

    function filterList() {
        const query = search.value.toLowerCase();
        const activeFilter = document.querySelector('.filter-btn.active').getAttribute('data-filter');

        cards.forEach(card => {
            const status = card.getAttribute('data-status');
            const name = card.getAttribute('data-name');
            const degree = card.getAttribute('data-degree');
            
            const matchStatus = (activeFilter === 'all' || status === activeFilter);
            const matchSearch = name.includes(query) || degree.includes(query);
            
            card.style.display = (matchStatus && matchSearch) ? 'block' : 'none';
        });
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