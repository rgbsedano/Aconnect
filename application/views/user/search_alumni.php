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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
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
    </style>
</head>
<body class="bg-pattern text-slate-900 antialiased">

    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-rose-700 rounded-xl flex items-center justify-center shadow-lg shadow-rose-200">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
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
                    <button class="filter-btn active bg-rose-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-md shadow-rose-100" data-filter="all">All</button>
                    <button class="filter-btn bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none hover:bg-slate-100" data-filter="connectable">Discover</button>
                    <button class="filter-btn bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none hover:bg-slate-100" data-filter="pending">Pending</button>
                    <button class="filter-btn bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none hover:bg-slate-100" data-filter="accepted">Linked</button>
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
                                <button type="button" class="btn-tile btn-view" data-toggle="modal" data-target="#profileModal<?= $alumnus->id ?>"><i class="fas fa-eye mr-1"></i> View</button>
                                
                                <?php if ($alumnus->connection_status == 'accepted'): ?>
                                    <div class="status-badge"><i class="fas fa-check"></i> Linked</div>
                                <?php elseif ($alumnus->connection_status == 'pending'): ?>
                                    <div class="status-badge"><i class="fas fa-clock"></i> Pending</div>
                                <?php else: ?>
                                    <form method="post" action="<?= site_url('alumni/send_request') ?>" class="connect-form" style="flex:1; display:flex;">
                                        <input type="hidden" name="receiver_id" value="<?= $alumnus->id ?>">
                                        <button type="submit" class="btn-tile btn-connect"><i class="fas fa-user-plus mr-1"></i> Connect</button>
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.alumni-card-container');
    const filters = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchInput');
    const noResultsMessage = document.getElementById('noResultsMessage');

    function filterList() {
        const query = searchInput.value.toLowerCase().trim();
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

        document.getElementById('total-counter').textContent = `${visibleCount} Alumni Found`;
        noResultsMessage.classList.toggle('hidden', visibleCount > 0);
    }

    filters.forEach(btn => {
        btn.addEventListener('click', function() {
            filters.forEach(f => {
                f.classList.remove('active', 'bg-rose-700', 'text-white', 'shadow-md', 'shadow-rose-100');
                f.classList.add('bg-slate-50', 'text-slate-600');
            });
            this.classList.add('active', 'bg-rose-700', 'text-white', 'shadow-md', 'shadow-rose-100');
            this.classList.remove('bg-slate-50', 'text-slate-600');
            filterList();
        });
    });

    searchInput.addEventListener('input', filterList);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function showCenteredNotification(message, type = 'info') {
        if (window.toastr) {
            toastr.options = toastr.options || {};
            toastr.options.positionClass = 'toast-top-right';
            toastr[type](message);
            return;
        }
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

    // Attach to connect forms and submit via fetch to show centered notification
    document.querySelectorAll('.connect-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalHtml = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...'; }

            const fd = new FormData(this);
            try {
                const resp = await fetch(this.action, { method: 'POST', body: fd, credentials: 'same-origin' });
                if (resp.ok) {
                    // server may redirect; show success and update UI
                    showCenteredNotification('Connection request sent', 'success');
                    // mark the card status to pending (best-effort UI update)
                    const card = this.closest('.alumni-card-container');
                    if (card) {
                        card.setAttribute('data-status', 'pending');
                        const footer = card.querySelector('.card-footer');
                        if (footer) {
                            footer.querySelectorAll('*').forEach(n => n.remove());
                            const badge = document.createElement('div');
                            badge.className = 'status-badge';
                            badge.innerHTML = '<i class="fas fa-clock"></i> Pending';
                            footer.appendChild(badge);
                        }
                    }
                } else {
                    showCenteredNotification('Failed to send request', 'error');
                }
            } catch (err) {
                showCenteredNotification('Error sending request', 'error');
            } finally {
                if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalHtml; }
            }
        });
    });
});
</script>

</body>
</html>