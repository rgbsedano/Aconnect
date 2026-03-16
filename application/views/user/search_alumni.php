<?php
$display_full_name = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
$student_number = $this->session->userdata('student_number') ? $this->session->userdata('student_number') : 'N/A';
?>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        :root {
            --brand-red: #BE123C;
            --brand-gold: #D97706;
            --primary: #8B1538;
            --primary-dark: #6B0F2A;
            --accent: #D4A574;
            --bg-page: #F8FAFC;
            --white: #FFFFFF;
            --text-main: #1F2937;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        }

        body { 
            background-color: var(--bg-page);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
        }
        
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }

        /* Profile Tiles Styles */
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
            background: #F1F5F9;
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

        /* Remove Connection Button Styles - Matched to status-badge */
        .remove-connection-btn {
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
            border: none;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s ease;
        }

        .remove-connection-btn:hover {
            background: #FEF2F2;
            color: #991B1B;
            /* No border change to prevent layout shift, or minimal border */
            box-shadow: inset 0 0 0 1px #FECACA; 
        }

        .remove-connection-btn:hover span {
            display: none;
        }
        
        .remove-connection-btn:hover::after {
            content: 'Unlink';
        }
        
        .remove-connection-btn:hover i {
            display: none;
        }
        
        .remove-connection-btn:hover::before {
            content: '\f00d'; /* FontAwesome times icon */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            margin-right: 6px;
        }

        /* Filter Button Styles */
        .filter-btn {
            transition: all 0.3s ease;
        }

        .filter-btn.active {
            background-color: #a12124;
            color: white;
            box-shadow: 0 4px 6px rgba(161, 33, 36, 0.2);
        }

        .filter-btn.active:hover {
            background-color: #8b1b1e;
            box-shadow: 0 6px 10px rgba(161, 33, 36, 0.3);
        }

        /* Modal Info Styles */
        .info-section {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 16px;
            margin-top: 16px;
            text-align: left;
            border: 1px solid var(--border);
        }

        .info-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 2px;
            display: block;
        }

        .info-text {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 12px;
            display: block;
            color: var(--text-main);
        }
        /* Top-right notification for Connect action */
        #centered-notif { position: fixed; right: 20px; top: 20px; z-index: 99999; pointer-events: none; transition: all .22s ease; opacity: 1; display: flex; flex-direction: column; gap: 10px; align-items: flex-end; }
        .noti-box { background: #fff; padding: 12px 16px; border-radius: 10px; box-shadow: 0 12px 30px rgba(0,0,0,0.12); font-weight: 800; display: inline-flex; align-items: center; gap: 10px; pointer-events: auto; }
        .noti-box.success { border-left: 6px solid #10B981; color: #065F46; }
        .noti-box.error { border-left: 6px solid #EF4444; color: #7F1D1D; }
        .noti-box.info { border-left: 6px solid #3B82F6; color: #1E40AF; }

        /* Responsive modals: space for header, viewport-fit, body scrolls only */
        .modal { overflow-x: auto; align-items: flex-start; padding-top: 72px; padding-bottom: 1rem; }
        .modal.show .modal-dialog {
            margin-top: 0;
            margin-bottom: 0;
            max-height: calc(100vh - 72px - 2rem);
            margin-left: auto;
            margin-right: auto;
            display: flex;
            flex-direction: column;
        }
        .modal-dialog { max-height: calc(100vh - 72px - 2rem); }
        .modal-content {
            max-height: calc(100vh - 72px - 2rem);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .modal-body {
            overflow-y: auto;
            flex: 1 1 auto;
            min-height: 0;
            -webkit-overflow-scrolling: touch;
        }
        .modal-header { flex-shrink: 0; }
        .modal-footer { flex-shrink: 0; }

        @media (max-width: 768px) {
            .alumni-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .main-search-bar {
                flex-direction: column;
            }
            .filter-btns {
                overflow-x: auto;
                padding-bottom: 5px;
                width: 100%;
                justify-content: flex-start !important;
            }
            .max-w-6xl {
                padding-left: 15px;
                padding-right: 15px;
            }
            .card-footer {
                flex-direction: column;
            }
            .btn-tile {
                width: 100%;
            }
            .modal { padding-top: 72px; padding-bottom: 0.5rem; }
            .modal-dialog { margin: 0.5rem auto; max-width: calc(100vw - 1rem); width: auto; max-height: calc(100vh - 72px - 1rem); }
            .modal.show .modal-dialog { margin: 0.5rem auto; max-height: calc(100vh - 72px - 1rem); }
            .modal-content { max-height: calc(100vh - 72px - 1rem); }
            .modal-header { padding: 14px 16px; height: auto; min-height: 60px; }
            .modal-body { padding: 16px; }
        }

        @media (max-width: 480px) {
            .alumni-name {
                font-size: 1.1rem;
            }
            .profile-img-container {
                width: 80px;
                height: 80px;
                margin-top: -40px;
            }
            .modal { padding-top: 64px; padding-bottom: 0.25rem; }
            .modal-dialog { margin: 0.25rem auto; max-width: calc(100vw - 0.5rem); max-height: calc(100vh - 64px - 0.5rem); }
            .modal.show .modal-dialog { max-height: calc(100vh - 64px - 0.5rem); }
            .modal-content { max-height: calc(100vh - 64px - 0.5rem); }
            .modal-header { padding: 12px 14px; min-height: 56px; }
            .modal-body { padding: 12px 14px; }
        }
    </style>
  


    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Alumni <span class="text-rose-700">Network</span></h1>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">AConnect Community Hub</p>
                </div>
            </div>
            <div id="total-counter" class="bg-amber-50 text-amber-700 px-3 py-1 rounded-full text-xs font-bold border border-amber-200">
                <?= count($alumni_list) ?> Alumni
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-12">
        
        <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200 mb-12 flex flex-col md:flex-row gap-2">
            <div class="flex-grow flex items-center px-4 gap-3 border-r border-slate-100">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="searchInput" placeholder="Search by name, degree, or skills..." class="w-full py-3 bg-transparent outline-none text-sm font-medium">
            </div>
            <div class="flex flex-wrap md:flex-nowrap gap-2 p-1">
                <div class="flex gap-2">
                    <button class="filter-btn active text-xs font-bold px-4 py-2 rounded-xl" data-filter="all">All</button>
                    <button class="filter-btn bg-slate-50 text-slate-600 text-xs font-bold py-2 px-4 rounded-xl" data-filter="connectable">Discover</button>
                    <button class="filter-btn bg-slate-50 text-slate-600 text-xs font-bold py-2 px-4 rounded-xl" data-filter="pending">Pending</button>
                    <button class="filter-btn bg-slate-50 text-slate-600 text-xs font-bold py-2 px-4 rounded-xl" data-filter="accepted">Linked</button>

                </div>
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
                                <a href="<?= site_url('alumni/view/' . $alumnus->id) ?>" class="btn-tile btn-view">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>

                                <?php 
                                    $my_id = $this->session->userdata('alumni_id');
                                ?>

                                <?php if ($alumnus->connection_status == 'accepted'): ?>

                                    <!-- CONNECTED -->
                                    <form method="post" action="<?= site_url('alumni/remove_connection') ?>" class="remove-connection-form" style="flex:1; display:flex;">
                                        <input type="hidden" name="receiver_id" value="<?= $alumnus->id ?>">
                                        <button type="submit" class="remove-connection-btn">
                                            <i class="fas fa-check"></i> <span>Linked</span>
                                        </button>
                                    </form>

                                <?php elseif ($alumnus->connection_status == 'pending'): ?>

                                    <?php if ($alumnus->sender_id == $my_id): ?>

                                        <!-- I SENT THE REQUEST → SHOW CANCEL -->
                                        <form method="post" action="<?= site_url('alumni/cancel_request') ?>" class="cancel-form" style="flex:1; display:flex;">
                                            <input type="hidden" name="receiver_id" value="<?= $alumnus->id ?>">
                                            <button type="submit" class="status-badge" style="border:none; cursor:pointer; width:100%;">
                                                <i class="fas fa-clock"></i> Pending
                                            </button>
                                        </form>

                                    <?php else: ?>

                                        <!-- THEY SENT ME THE REQUEST → SHOW ACCEPT + DECLINE -->
                                        <!-- THEY SENT ME THE REQUEST → SHOW ACCEPT + DECLINE -->
                                        <form method="post" action="<?= site_url('alumni/accept_request') ?>" class="accept-form" style="flex:1; display:flex;">
                                            <input type="hidden" name="request_id" value="<?= $alumnus->request_id ?>">
                                            <input type="hidden" name="sender_id" value="<?= $alumnus->id ?>">
                                            <button type="submit" class="btn-tile btn-connect" style="background:#10B981;">
                                                <i class="fas fa-check"></i> Accept
                                            </button>
                                        </form>

                                        <form method="post" action="<?= site_url('alumni/decline_request') ?>" class="decline-form" style="flex:1; display:flex;">
                                            <input type="hidden" name="request_id" value="<?= $alumnus->request_id ?>">
                                            <input type="hidden" name="sender_id" value="<?= $alumnus->id ?>">
                                            <button type="submit" class="btn-tile btn-connect" style="background:#EF4444;">
                                                <i class="fas fa-times"></i> Decline
                                            </button>
                                        </form>

                                    <?php endif; ?>

                                <?php else: ?>

                                    <!-- NO CONNECTION YET -->
                                    <form method="post" action="<?= site_url('alumni/send_request') ?>" class="connect-form" style="flex:1; display:flex;">
                                        <input type="hidden" name="receiver_id" value="<?= $alumnus->id ?>">
                                        <button type="submit" class="btn-tile btn-connect">
                                            <i class="fas fa-user-plus mr-1"></i> Connect
                                        </button>
                                    </form>

                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                    <div class="modal fade" id="profileModal<?= $alumnus->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="border-radius: 24px; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                                <div class="modal-header" style="background: var(--primary); border: none; height: 80px;">
                                    <button type="button" class="close text-white" data-dismiss="modal" style="opacity: 1;">&times;</button>
                                </div>
                                <div class="modal-body text-center px-4 pb-5">
                                    <img src="<?= $img_path ?>" style="width:130px; height:130px; border-radius:50%; border:6px solid white; margin: -65px auto 0; box-shadow: 0 10px 15px rgba(0,0,0,0.1); object-fit: cover; background: white;">
                                    
                                    <h4 class="mt-3 font-extrabold text-slate-900"><?= ucwords(htmlspecialchars(strtolower($alumnus->first_name . ' ' . $alumnus->last_name))) ?></h4>
                                    <p class="text-rose-700 font-bold text-sm mb-4"><?= htmlspecialchars($alumnus->degree) ?></p>

                                    <div class="info-section">
                                        <span class="info-label">Current Occupation</span>
                                        <span class="info-text"><?= htmlspecialchars($alumnus->current_job ?: 'No record provided') ?></span>
                                        
                                        <span class="info-label">Contact Detail</span>
                                        <span class="info-text"><?= htmlspecialchars($alumnus->email ?: 'Information Restricted') ?></span>

                                        <span class="info-label">Professional Expertise</span>
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            <?php 
                                                $skills = explode(',', $alumnus->technical_skills ?? ''); 
                                                if (!empty($skills) && $skills[0] !== ''): 
                                                    foreach($skills as $s): 
                                                        if(!empty(trim($s))): 
                                            ?>
                                                <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-lg text-[11px] font-bold border border-amber-200"><?= htmlspecialchars(trim($s)) ?></span>
                                            <?php 
                                                        endif; 
                                                    endforeach; 
                                                else: 
                                            ?>
                                                <p class="text-slate-400 text-xs italic">No skills listed yet</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <button class="btn btn-block mt-4 rounded-xl font-bold py-3 text-sm transition hover:brightness-110 shadow-lg" style="background: var(--primary); color: white;" data-dismiss="modal">Close Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div id="noResultsMessage" class="hidden text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
            <h3 class="text-lg font-bold text-slate-900">No matching alumni found</h3>
            <p class="text-slate-500 text-sm mt-1">Try adjusting your filters or search terms.</p>
        </div>
    </main>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.alumni-card-container');
    const filters = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchInput');
    const noResultsMessage = document.getElementById('noResultsMessage');

    // Helper to get URL Query Params
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    function setActiveFilter(filterName) {
        filters.forEach(f => {
            f.classList.remove('active');
            f.classList.add('bg-slate-50', 'text-slate-600');
            if (f.getAttribute('data-filter') === filterName) {
                f.classList.add('active');
                f.classList.remove('bg-slate-50', 'text-slate-600');
            }
        });
    }

    function filterList() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const activeFilterBtn = document.querySelector('.filter-btn.active');
        const activeFilter = activeFilterBtn ? activeFilterBtn.getAttribute('data-filter') : 'all';
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

        const counter = document.getElementById('total-counter');
        if (counter) counter.textContent = `${visibleCount} Alumni Found`;
        if (noResultsMessage) noResultsMessage.classList.toggle('hidden', visibleCount > 0);
    }

    filters.forEach(btn => {
        btn.addEventListener('click', function() {
            filters.forEach(f => {
                f.classList.remove('active', 'bg-rose-700', 'text-white', 'shadow-md', 'shadow-rose-100');
                f.classList.add('bg-slate-50', 'text-slate-600');
            });
            this.classList.add('active', 'bg-rose-700', 'text-white', 'shadow-md', 'shadow-rose-100');
            this.classList.remove('bg-slate-50', 'text-slate-600');
            
            // Optional: Update URL without reload to make it shareable
            const newFilter = this.getAttribute('data-filter');
            const url = new URL(window.location);
            url.searchParams.set('filter', newFilter);
            window.history.pushState({}, '', url);
            
            filterList();
        });
    });

    if (searchInput) searchInput.addEventListener('input', filterList);

    // Initial Load Logic
    const urlFilter = getQueryParam('filter');
    if (urlFilter) {
        setActiveFilter(urlFilter);
    }
    // Run filter immediately
    filterList();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function showCenteredNotification(message, type = 'info') {
        if (window.toastr) {
            toastr.options = { 
                "positionClass": "toast-top-right",
                "timeOut": 3000,
                "closeButton": true 
            };
            toastr[type](message);
            return;
        }
        // Fallback for manual noti-box if toastr failed
        let container = document.getElementById('centered-notif');
        if (!container) {
            container = document.createElement('div');
            container.id = 'centered-notif';
            document.body.appendChild(container);
        }
        container.innerHTML = `<div class="noti-box ${type}">${message}</div>`;
        container.classList.add('show');
        setTimeout(() => container.classList.remove('show'), 3000);
    }



    // Handle Cancel Forms via Event Delegation (since they might be dynamic or existing)
    document.addEventListener('submit', async function(e) {
        if (e.target.matches('.cancel-form')) {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalHtml = submitBtn ? submitBtn.innerHTML : '';
             if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Canceling...'; }

            const fd = new FormData(form);
            try {
                const resp = await fetch(form.action, { method: 'POST', body: fd, credentials: 'same-origin' });
                if (resp.ok) {
                    showCenteredNotification('Request canceled', 'info');
                    const card = form.closest('.alumni-card-container');
                    if (card) {
                        card.setAttribute('data-status', 'connectable');
                        const footer = card.querySelector('.card-footer');
                        form.remove();
                        const connectForm = `
                             <form method="post" action="<?= site_url('alumni/send_request') ?>" class="connect-form" style="flex:1; display:flex;">
                                <input type="hidden" name="receiver_id" value="${fd.get('receiver_id')}">
                                <button type="submit" class="btn-tile btn-connect"><i class="fas fa-user-plus mr-1"></i> Connect</button>
                            </form>
                        `;
                        footer.insertAdjacentHTML('beforeend', connectForm);
                         // Re-attach listener to the new connect form? 
                         // Since we use document.querySelectorAll on load, new elements won't have it.
                         // Better to use delegation for connect-form too, or re-run attachment.
                         // For now, reload serves as fallback, but let's try to attach logic dynamically or just let user reload if they want to re-connect instantly.
                         // Actually, let's fix the delegation issue below.
                    }
                } else {
                    showCenteredNotification('Failed to cancel request', 'error');
                }
            } catch (err) {
                showCenteredNotification('Error canceling request', 'error');
            } finally {
               if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalHtml; }
            }
        }
    });

    // Handle Remove Connection Forms via Event Delegation
    document.addEventListener('submit', async function(e) {
        if (e.target.matches('.remove-connection-form')) {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalHtml = submitBtn ? submitBtn.innerHTML : '';
             if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Unlinking...'; }

            const fd = new FormData(form);
            try {
                const resp = await fetch(form.action, { method: 'POST', body: fd, credentials: 'same-origin' });
                if (resp.ok) {
                    showCenteredNotification('Unlinked successfully', 'info');
                    const card = form.closest('.alumni-card-container');
                    if (card) {
                        card.setAttribute('data-status', 'connectable');
                        const footer = card.querySelector('.card-footer');
                        form.remove();
                        const connectForm = `
                             <form method="post" action="<?= site_url('alumni/send_request') ?>" class="connect-form" style="flex:1; display:flex;">
                                <input type="hidden" name="receiver_id" value="${fd.get('receiver_id')}">
                                <button type="submit" class="btn-tile btn-connect"><i class="fas fa-user-plus mr-1"></i> Connect</button>
                            </form>
                        `;
                        footer.insertAdjacentHTML('beforeend', connectForm);
                        
                        // If we are currently filtering by 'Linked' (accepted), hide this card smoothly since it's no longer linked
                        const activeFilter = document.querySelector('.filter-btn.active')?.getAttribute('data-filter');
                        if (activeFilter === 'accepted') {
                            $(card).fadeOut(300, function() {
                                // Trigger filter recalculation to update counters
                                const searchInput = document.getElementById('searchInput'); // ensure we have reference to trigger or just call filterList if accessible
                                // Since filterList is scoped, we can't call it easily unless we move it or trigger event.
                                // Triggering input event on search works if it exists:
                                if(searchInput) searchInput.dispatchEvent(new Event('input'));
                            });
                        }
                    }
                } else {
                    showCenteredNotification('Failed to unlink', 'error');
                }
            } catch (err) {
                showCenteredNotification('Error unlinking', 'error');
            } finally {
               if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalHtml; }
            }
        }
    });

    // Re-do connect form listener to use delegation so rebuilt forms work
    document.addEventListener('submit', async function(e) {
        if (e.target.matches('.connect-form')) {
             e.preventDefault();
             // Logic duplicated from above for delegation
             const form = e.target;
             const submitBtn = form.querySelector('button[type="submit"]');
             const originalHtml = submitBtn ? submitBtn.innerHTML : '';
             if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...'; }
             const fd = new FormData(form);
            try {
                const resp = await fetch(form.action, { method: 'POST', body: fd, credentials: 'same-origin' });
                if (resp.ok) {
                     showCenteredNotification('Connection request sent', 'success');
                    const card = form.closest('.alumni-card-container');
                    if (card) {
                        card.setAttribute('data-status', 'pending');
                        const footer = card.querySelector('.card-footer');
                        form.remove();
                         const formRaw = `
                                <form method="post" action="<?= site_url('alumni/cancel_request') ?>" class="cancel-form" style="flex:1; display:flex;">
                                    <input type="hidden" name="receiver_id" value="${fd.get('receiver_id')}">
                                    <button type="submit" class="status-badge" style="border:none; cursor:pointer; width:100%;" title="Click to cancel request"><i class="fas fa-clock"></i> Pending</button>
                                </form>`;
                        footer.insertAdjacentHTML('beforeend', formRaw);
                    }
                } else { showCenteredNotification('Failed', 'error'); }
            } catch(e) { showCenteredNotification('Error', 'error'); } 
            finally { if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalHtml; } }
        }
    });

    // Handle Accept Request Form
    document.addEventListener('submit', async function(e) {
        if (e.target.matches('.accept-form')) {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalHtml = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Accepting...'; }
            
            const fd = new FormData(form);
            try {
                const resp = await fetch(form.action, { method: 'POST', body: fd, credentials: 'same-origin' });
                if (resp.ok) {
                    showCenteredNotification('Connection accepted', 'success');
                    const card = form.closest('.alumni-card-container');
                    if (card) {
                        card.setAttribute('data-status', 'accepted');
                        const footer = card.querySelector('.card-footer');
                        
                        // Remove both accept and decline forms (siblings)
                        const siblingDecline = footer.querySelector('.decline-form');
                        if(siblingDecline) siblingDecline.remove();
                        form.remove();

                        const formRaw = `
                             <form method="post" action="<?= site_url('alumni/remove_connection') ?>" class="remove-connection-form" style="flex:1; display:flex;">
                                <input type="hidden" name="receiver_id" value="${fd.get('sender_id')}">
                                <button type="submit" class="remove-connection-btn">
                                    <i class="fas fa-check"></i> <span>Linked</span>
                                </button>
                            </form>`;
                        footer.insertAdjacentHTML('beforeend', formRaw);
                        
                        // If we are currently filtering by 'Pending', hide this card
                        const activeFilter = document.querySelector('.filter-btn.active')?.getAttribute('data-filter');
                        if (activeFilter === 'pending') {
                            $(card).fadeOut(300, function() {
                                const searchInput = document.getElementById('searchInput');
                                if(searchInput) searchInput.dispatchEvent(new Event('input'));
                            });
                        }
                    }
                } else { showCenteredNotification('Failed to accept', 'error'); }
            } catch(e) { showCenteredNotification('Error accepting', 'error'); }
            finally { if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalHtml; } }
        }
    });

    // Handle Decline Request Form
    document.addEventListener('submit', async function(e) {
        if (e.target.matches('.decline-form')) {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalHtml = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Declining...'; }
            
            const fd = new FormData(form);
            try {
                const resp = await fetch(form.action, { method: 'POST', body: fd, credentials: 'same-origin' });
                if (resp.ok) {
                    showCenteredNotification('Request declined', 'info');
                    const card = form.closest('.alumni-card-container');
                    if (card) {
                        card.setAttribute('data-status', 'connectable');
                        const footer = card.querySelector('.card-footer');
                        
                        // Remove both accept and decline forms
                        const siblingAccept = footer.querySelector('.accept-form');
                        if(siblingAccept) siblingAccept.remove();
                        form.remove();

                        const formRaw = `
                             <form method="post" action="<?= site_url('alumni/send_request') ?>" class="connect-form" style="flex:1; display:flex;">
                                <input type="hidden" name="receiver_id" value="${fd.get('sender_id')}">
                                <button type="submit" class="btn-tile btn-connect"><i class="fas fa-user-plus mr-1"></i> Connect</button>
                            </form>`;
                        footer.insertAdjacentHTML('beforeend', formRaw);

                         // If 'Pending', hide this card
                        const activeFilter = document.querySelector('.filter-btn.active')?.getAttribute('data-filter');
                        if (activeFilter === 'pending') {
                            $(card).fadeOut(300, function() {
                                const searchInput = document.getElementById('searchInput');
                                if(searchInput) searchInput.dispatchEvent(new Event('input'));
                            });
                        }
                    }
                } else { showCenteredNotification('Failed to decline', 'error'); }
            } catch(e) { showCenteredNotification('Error declining', 'error'); }
            finally { if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalHtml; } }
        }
    });
});
</script>

</body>
</html>