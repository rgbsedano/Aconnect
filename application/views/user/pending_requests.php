<?php
$display_full_name = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
$student_number = $this->session->userdata('student_number') ? $this->session->userdata('student_number') : 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection Requests - AConnect</title>
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
        .requests-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .request-card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        .request-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
        }

        .request-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
        }

        .card-body {
            padding: 24px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .profile-img-container {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--border);
            flex-shrink: 0;
        }

        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info-col {
            flex-grow: 1;
        }

        .request-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 4px 0;
            line-height: 1.2;
        }

        .request-degree {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-weight: 500;
        }

        .request-date {
            font-size: 0.75rem;
            color: var(--primary);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .card-actions {
            padding: 16px 24px;
            background: #F8FAFC;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 8px;
        }

        .btn-action {
            flex: 1;
            padding: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            border-radius: 8px;
            text-align: center;
            text-decoration: none !important;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: none;
            outline: none;
        }

        .btn-view {
            background: white;
            border: 1px solid var(--border);
            color: var(--text-main);
        }
        .btn-view:hover { background: #f1f5f9; }

        .btn-accept {
            background: #10B981;
            color: white;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }
        .btn-accept:hover { background: #059669; transform: translateY(-1px); }

        .btn-decline {
            background: #EF4444;
            color: white;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
        }
        .btn-decline:hover { background: #DC2626; transform: translateY(-1px); }

        /* Top-right notification for actions */
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
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Connection <span class="text-rose-700">Requests</span></h1>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">Manage Your Network</p>
                </div>
            </div>
            <div id="total-counter" class="bg-rose-50 text-rose-700 px-3 py-1 rounded-full text-xs font-bold border border-rose-200">
                <?= isset($pending_requests) ? count($pending_requests) : 0 ?> Pending
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-12">
        
        <!-- Search and Filter Bar (Standardized) -->
        <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200 mb-12 flex flex-col md:flex-row gap-2">
            <div class="flex-grow flex items-center px-4 gap-3 border-r border-slate-100">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="searchInput" placeholder="Search requests by name or degree..." class="w-full py-3 bg-transparent outline-none text-sm font-medium">
            </div>
            <div class="flex flex-wrap md:flex-nowrap gap-2 p-1">
                <div class="flex gap-2">
                    <a href="<?= base_url('alumni') ?>?filter=all" class="filter-btn bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none hover:bg-slate-100 flex items-center" style="text-decoration: none;">All</a>
                    <a href="<?= base_url('alumni') ?>?filter=connectable" class="filter-btn bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none hover:bg-slate-100 flex items-center" style="text-decoration: none;">Discover</a>
                    <a href="<?= base_url('alumni') ?>?filter=pending" class="filter-btn bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none hover:bg-slate-100 flex items-center" style="text-decoration: none;">Pending</a>
                    <a href="<?= base_url('alumni') ?>?filter=accepted" class="filter-btn bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none hover:bg-slate-100 flex items-center" style="text-decoration: none;">Linked</a>
                    <button class="filter-btn active bg-rose-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-md shadow-rose-100 cursor-default">Requests</button>
                </div>
            </div>
        </div>

        <div class="requests-grid" id="requestsListContainer">
            <?php if (!empty($pending_requests)): ?>
                <?php foreach ($pending_requests as $request): ?>
                    <?php 
                        $img_path = (isset($request->profile_image) && !empty($request->profile_image) && file_exists(FCPATH . 'assets/uploads/alumni/' . $request->profile_image)) 
                                    ? base_url('assets/uploads/alumni/' . $request->profile_image) 
                                    : base_url('assets/images/person-' . (strtolower($request->gender ?? 'male') == 'female' ? 'female' : 'male') . '.png');
                    ?>
                    <div class="request-card-container" 
                         data-name="<?= htmlspecialchars(strtolower($request->first_name . ' ' . $request->last_name)) ?>" 
                         data-degree="<?= htmlspecialchars(strtolower($request->degree ?? '')) ?>">
                        
                        <div class="request-card">
                            <div class="card-body">
                                <div class="profile-img-container">
                                    <img src="<?= $img_path ?>" alt="<?= htmlspecialchars($request->first_name) ?>">
                                </div>
                                <div class="info-col">
                                    <h5 class="request-name"><?= ucwords(htmlspecialchars(strtolower($request->first_name . ' ' . $request->last_name))) ?></h5>
                                    <div class="request-degree"><?= htmlspecialchars($request->degree ?: 'N/A') ?></div>
                                    <div class="request-date">
                                        <i class="fas fa-clock text-xs"></i>
                                        <span><?= date('M j, Y', strtotime($request->request_date ?? 'now')) ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-actions">
                                <button type="button" class="btn-action btn-view" data-toggle="modal" data-target="#viewProfileModal<?= $request->sender_id ?>"><i class="fas fa-eye"></i> View</button>
                                <a href="<?= site_url('alumni_request/accept_request/' . ($request->id ?? 0)) ?>" class="btn-action btn-accept req-action-btn"><i class="fas fa-check"></i> Accept</a>
                                <a href="<?= site_url('alumni_request/decline_request/' . ($request->id ?? 0)) ?>" class="btn-action btn-decline req-action-btn"><i class="fas fa-times"></i> Decline</a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Modal (Same standard design) -->
                    <div class="modal fade" id="viewProfileModal<?= $request->sender_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="border-radius: 24px; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                                <div class="modal-header" style="background: var(--primary); border: none; height: 80px;">
                                    <button type="button" class="close text-white" data-dismiss="modal" style="opacity: 1;">&times;</button>
                                </div>
                                <div class="modal-body text-center px-4 pb-5">
                                    <img src="<?= $img_path ?>" style="width:130px; height:130px; border-radius:50%; border:6px solid white; margin: -65px auto 0; box-shadow: 0 10px 15px rgba(0,0,0,0.1); object-fit: cover; background: white;">
                                    
                                    <h4 class="mt-3 font-extrabold text-slate-900"><?= ucwords(htmlspecialchars(strtolower($request->first_name . ' ' . $request->last_name))) ?></h4>
                                    <p class="text-rose-700 font-bold text-sm mb-4"><?= htmlspecialchars($request->degree) ?></p>

                                    <div style="background: #F8FAFC; border-radius: 12px; padding: 16px; margin-top: 16px; text-align: left; border: 1px solid var(--border);">
                                        <span style="font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); font-weight: 800; letter-spacing: 1px; display: block; margin-bottom: 2px;">Request Date</span>
                                        <span style="font-size: 0.95rem; font-weight: 600; margin-bottom: 12px; display: block; color: var(--text-main);"><?= date('F j, Y \a\t g:i A', strtotime($request->request_date)) ?></span>
                                    </div>

                                    <button class="btn btn-block mt-4 rounded-xl font-bold py-3 text-sm transition hover:brightness-110 shadow-lg" style="background: var(--primary); color: white;" data-dismiss="modal">Close Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div id="noResultsMessage" class="<?= empty($pending_requests) ? '' : 'hidden' ?> text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-inbox text-2xl text-slate-300"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900">No pending requests</h3>
            <p class="text-slate-500 text-sm mt-1">You're all caught up! Check back later.</p>
        </div>
    </main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.request-card-container');
    const searchInput = document.getElementById('searchInput');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const totalCounter = document.getElementById('total-counter');

    function filterList() {
        const query = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const degree = card.getAttribute('data-degree');
            
            const matchSearch = query === '' || name.includes(query) || degree.includes(query);
            
            card.style.display = matchSearch ? 'block' : 'none';
            if (matchSearch) visibleCount++;
        });

        if(totalCounter) totalCounter.textContent = `${visibleCount} Pending`;
        
        // Only show no results if there were cards to begin with but filtered out, OR if empty initially
        if (cards.length > 0) {
            noResultsMessage.classList.toggle('hidden', visibleCount > 0);
            if (visibleCount === 0) {
                noResultsMessage.querySelector('h3').textContent = "No matching requests found";
                noResultsMessage.querySelector('p').textContent = "Try adjusting your search terms.";
            } else {
                 // Reset text just in case
                noResultsMessage.querySelector('h3').textContent = "No pending requests";
                noResultsMessage.querySelector('p').textContent = "You're all caught up! Check back later.";
            }
        }
    }

    if(searchInput) {
        searchInput.addEventListener('input', filterList);
    }

    // Handle standard toast notifications for actions
    function showCenteredNotification(message, type = 'success') {
        if (window.toastr) {
            toastr.options = { positionClass: 'toast-top-right', timeOut: 3000 };
            toastr[type](message);
        }
    }

    // Ajax handling for accept/decline links to avoid page reload if possible, or just standard follow
    $('.req-action-btn').on('click', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const href = $btn.attr('href');
        const $cardContainer = $btn.closest('.request-card-container');

        if (!href) return;

        // Visual feedback
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        $btn.addClass('pointer-events-none opacity-75');

        fetch(href, { method: 'GET', credentials: 'same-origin' })
            .then(resp => {
                if (!resp.ok) throw new Error('Request failed');
                return resp.text();
            })
            .then(() => {
                const action = $btn.hasClass('btn-accept') ? 'accepted' : 'declined';
                showCenteredNotification(`Connection request ${action}`, action === 'accepted' ? 'success' : 'info');
                
                $cardContainer.fadeOut(300, function() { 
                    $(this).remove();
                    // Update counter
                    const remaining = document.querySelectorAll('.request-card-container').length;
                    if(totalCounter) totalCounter.textContent = `${remaining} Pending`;
                    
                    if (remaining === 0) {
                        noResultsMessage.classList.remove('hidden');
                        noResultsMessage.querySelector('h3').textContent = "No pending requests";
                        noResultsMessage.querySelector('p').textContent = "You're all caught up! Check back later.";
                    }
                });
            })
            .catch(() => {
                showCenteredNotification('Action failed. Please try again.', 'error');
                $btn.html($btn.hasClass('btn-accept') ? '<i class="fas fa-check"></i> Accept' : '<i class="fas fa-times"></i> Decline');
                $btn.removeClass('pointer-events-none opacity-75');
            });
    });
});
</script>

</body>
</html>