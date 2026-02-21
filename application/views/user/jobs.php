<style>
        :root {
            --maroon: #8B1538;
            --maroon-dark: #6B0F2A;
            --gold: #D4A574;
            --bg: #FAFAF8;
            --card: #ffffff;
            --text: #1F2937;
            --muted: #6B7280;
            --border: #E5E7EB;
            --success: #059669;
            --error: #DC2626;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--bg); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: var(--text); line-height: 1.6; }
        .container { max-width: 1100px; margin: 20px auto 40px; padding: 0 20px; }

        /* Success Popup Notification (Tiles/Toasts) */
        .popup-toast {
            position: fixed;
            top: 25px;
            right: 25px;
            padding: 16px 24px;
            border-radius: 12px;
            background: white;
            color: var(--text);
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 9999;
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border-left: 6px solid var(--success);
        }
        .popup-toast.show { transform: translateX(0); }
        .popup-toast i { color: var(--success); font-size: 20px; }

        /* Error Banner */
        .error-banner {
            background: #FEE2E2;
            color: var(--error);
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #FECACA;
        }

        .header-section {
            background: var(--card);
            padding: 32px;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            margin-bottom: 32px;
        }

        .search-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 16px;
            margin-bottom: 24px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group i { position: absolute; left: 14px; color: var(--muted); font-size: 14px; }
        .input-group input {
            width: 100%;
            padding: 12px 14px 12px 44px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: #f9f9f9;
        }
        .input-group input:focus {
            outline: none;
            border-color: var(--maroon);
            box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
            background: var(--card);
        }

        .btn-search {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: var(--shadow-sm);
        }
        .btn-search:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }

        .filters { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 20px; }
        .f-pill {
            padding: 8px 18px;
            border-radius: 24px;
            border: 1.5px solid var(--border);
            background: var(--card);
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            transition: all 0.3s;
        }
        .f-pill.active { background: linear-gradient(135deg, var(--maroon), var(--maroon-dark)); color: white; border-color: var(--maroon); }
        .f-pill:hover:not(.active) { border-color: var(--maroon); color: var(--maroon); }

        .job-card {
            background: var(--card);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 18px;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }
        .job-card:hover {
            border-color: var(--gold);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .logo-box {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
            flex-shrink: 0;
        }

        .job-info { flex: 1; }
        .job-info h3 { margin: 0 0 4px 0; font-size: 16px; color: var(--text); font-weight: 700; }
        .job-info p { margin: 4px 0; color: var(--muted); font-size: 13px; display: flex; align-items: center; gap: 6px; }

        .badge-ai { text-align: right; flex-shrink: 0; }
        .percent {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
        }

        /* Modal: space for header, fixed in viewport, only inner content scrolls */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: flex-start;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            padding: 72px 1rem 1rem 1rem;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .modal-overlay.open { opacity: 1; visibility: visible; }

        .modal-box {
            background: var(--card);
            width: 90%;
            max-width: 580px;
            max-height: calc(100vh - 72px - 2rem);
            border-radius: 16px;
            padding: 0;
            position: relative;
            transform: scale(0.95) translateY(20px);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            margin: 0 auto;
        }
        .modal-overlay.open .modal-box { transform: scale(1) translateY(0); }

        .modal-header-custom {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-shrink: 0;
        }

        .modal-header-custom h2 { margin: 0 0 4px 0; font-size: 20px; }
        .modal-header-custom p { margin: 0; font-size: 13px; color: var(--gold); font-weight: 600; }

        .modal-box .modal-content {
            overflow-y: auto;
            flex: 1 1 auto;
            min-height: 0;
            -webkit-overflow-scrolling: touch;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: white;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content { padding: 24px; }
        .modal-content hr { border: none; border-top: 1px solid var(--border); margin: 16px 0; }
        .modal-content strong { color: var(--text); }
        .modal-content p { margin: 12px 0; font-size: 14px; color: var(--muted); }

        .job-details { max-height: 250px; overflow-y: auto; padding-right: 12px; }

        .modal-form {
            background: #f9f9f9;
            padding: 16px;
            border-radius: 10px;
            margin-top: 16px;
        }

        .file-input-wrapper {
            display: block;
            border: 2px dashed var(--border);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 16px;
            transition: all 0.3s;
            cursor: pointer;
        }
        .file-input-wrapper input[type="file"] { display: none; }
        .file-input-wrapper:hover { border-color: var(--maroon); background: rgba(139, 21, 56, 0.02); }

        .btn-submit {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }

        @media (max-width: 768px) {
            .search-grid { grid-template-columns: 1fr; }
            .job-card { flex-direction: column; text-align: center; }
            .job-info p { justify-content: center; }
            .badge-ai { margin-top: 12px; }
            .header-section { padding: 20px; }
            .f-pill { padding: 6px 14px; font-size: 12px; }
            .modal-overlay { padding: 72px 0.5rem 0.5rem; align-items: flex-start; }
            .modal-box { width: 100%; max-width: none; max-height: calc(100vh - 72px - 1rem); margin: 0 auto; }
        }

        @media (max-width: 576px) {
            .modal-header-custom { padding: 16px; }
            .modal-box .modal-content { padding: 16px; }
            .modal-overlay { padding: 64px 0.25rem 0.25rem; }
            .modal-box { max-height: calc(100vh - 64px - 0.5rem); margin: 0 auto; }
            .percent { padding: 6px 10px; font-size: 11px; }
            .job-info h3 { font-size: 15px; }
            .modal-header-custom h2 { font-size: 17px; }
        }
    </style>

<?php
// ... (compute_ai_match function remains exactly as you provided) ...

function compute_ai_match($alumni, $job) {
    if (!$alumni) return 0;
    $wTitle = 25;   // reduced
    $wTech  = 45;   // MOST IMPORTANT
    $wSoft  = 15;
    $wKey   = 15;
    $score = 0; 
    $titleMatch = 0;

    $titleGroups = [
        'information technology' => ['it','developer','programmer','software','technical','web'],
        'nursing' => ['nurse','staff nurse','clinical nurse'],
        'radiologic' => ['radtech','radiologic','xray'],
        'business' => ['marketing','hr','human resource','business'],
        'accountancy' => ['finance','accounting','bookkeeper'],
        'multimedia' => ['graphic','designer','multimedia','ui','ux'],
        'communication' => ['editor','writer','content']
    ];

    $deg = strtolower($alumni->degree);
    $jobTitle = strtolower($job->job_title);

    foreach ($titleGroups as $degreeKey => $keywords) {
        if (strpos($deg, $degreeKey) !== false) {
            foreach ($keywords as $kw) {
                if (strpos($jobTitle, $kw) !== false) {
                    $titleMatch = 1;
                    break 2;
                }
            }
        }
    }

    $alTech = array_map('normalize_skill',
    array_filter(array_map('trim', explode(',', strtolower($alumni->technical_skills ?? ""))))
    );

    $jobTech = array_map('normalize_skill',
        array_filter(array_map('trim', explode(',', strtolower($job->qualifications ?? ""))))
    );

    $techMatch = 0;
    if (count($jobTech) > 0) {
        $match = array_intersect($alTech, $jobTech);
        $techMatch = count($match) / count($jobTech);
    }
    $alSoft = array_filter(array_map('trim', explode(',', strtolower($alumni->soft_skills ?? ""))));
    $desc = strtolower($job->description ?? "");
    $softCount = 0;
    foreach ($alSoft as $soft) { if (strpos($desc, $soft) !== false) $softCount++; }
    $softMatch = (count($alSoft) > 0)
        ? min(1, $softCount / max(3, count($alSoft)))
        : 0;

    $searchSpace = strtolower($job->company . " " . $job->job_title . " " . $job->description);
    $keyHits = 0;
    foreach ($alTech as $skill) {
        if (strpos($searchSpace, $skill) !== false) {
            $keyHits++;
        }
    }

    $keyMatch = count($alTech) > 0 ? $keyHits / count($alTech) : 0;

    $score = ($techMatch * $wTech) + ($softMatch * $wSoft) + ($keyMatch * $wKey) + ($titleMatch * $wTitle);
    return round($score);
}
function normalize_skill($skill) {
    $skill = strtolower(trim($skill));
    $map = [
        'js' => 'javascript',
        'nodejs' => 'node.js',
        'node js' => 'node.js',
        'mysql' => 'sql',
        'postgresql' => 'sql',
        'html5' => 'html',
        'css3' => 'css',
    ];
    return $map[$skill] ?? $skill;
}

?>

<script src="https://cdn.tailwindcss.com"></script>



<div id="success-popup" class="popup-toast">
    <i class="fas fa-check-circle"></i>
    <div>
        <p style="font-weight: 700;">Success!</p>
        <p style="font-size: 13px; color: var(--muted);">Uploaded successfully</p>
    </div>
</div>

<div class="container">
    <?php if ($this->session->flashdata('error')): ?>
        <div class="error-banner">
            <i class="fas fa-times-circle"></i>
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="header-section">
        <form method="get" action="<?= base_url('jobs') ?>">
            <div class="search-grid">
                <div class="input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Job title or company..." value="<?= $this->input->get('search') ?>">
                </div>
                <div class="input-group">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" name="location" placeholder="City or Remote" value="<?= $this->input->get('location') ?>">
                </div>
                <button type="submit" class="btn-search"><i class="fas fa-search"></i> Search</button>
            </div>
        </form>

        <div class="filters">
            <button class="f-pill active" id="btn-all" onclick="updateFilter('all')">All Opportunities</button>
            <button class="f-pill" id="btn-70" onclick="updateFilter(70)"><i class="fas fa-star"></i> Best Matches (70%+)</button>
            <button class="f-pill" id="btn-40" onclick="updateFilter(40)"><i class="fas fa-check"></i> Good Fits (40%+)</button>
        </div>
    </div>

    <div id="job-container">
        <?php if (!empty($jobs)): foreach ($jobs as $job): 
            $match = compute_ai_match($alumni, $job);
        ?>
        <div class="job-card" data-score="<?= $match ?>" onclick="toggleModal(<?= $job->id ?>, true)">
            <div class="logo-box"><i class="fas fa-briefcase"></i></div>
            <div class="job-info">
                <h3><?= htmlspecialchars($job->job_title) ?></h3>
                <p><i class="fas fa-building"></i> <?= htmlspecialchars($job->company) ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($job->location) ?> <span style="color: var(--maroon); font-weight: 600;">•</span> <i class="fas fa-coins"></i> <?= htmlspecialchars($job->salary_range) ?></p>
            </div>
            <div class="badge-ai">
                <div class="percent">
                    <i class="fas fa-robot"></i> <?= $match ?>% Match
                </div>
            </div>
        </div>

        <div id="modal-<?= $job->id ?>" class="modal-overlay" onclick="closeOverlay(event, <?= $job->id ?>)">
            <div class="modal-box" onclick="event.stopPropagation()">
                <div class="modal-header-custom">
                    <div>
                        <h2><?= htmlspecialchars($job->job_title) ?></h2>
                        <p><?= htmlspecialchars($job->company) ?></p>
                    </div>
                    <button type="button" class="close-modal" onclick="toggleModal(<?= $job->id ?>, false)"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-content">
                    <div style="display: flex; gap: 16px; margin-bottom: 16px; align-items: center;">
                        <div style="flex: 1;">
                            <p><strong><i class="fas fa-map-marker-alt" style="color: var(--maroon); margin-right: 6px;"></i>Location:</strong> <?= htmlspecialchars($job->location) ?></p>
                            <p><strong><i class="fas fa-coins" style="color: var(--gold); margin-right: 6px;"></i>Salary:</strong> <?= htmlspecialchars($job->salary_range) ?></p>
                        </div>
                        <div style="background: linear-gradient(135deg, var(--maroon), var(--maroon-dark)); color: white; padding: 10px 18px; border-radius: 8px; font-weight: 700;">
                            <i class="fas fa-robot"></i> <?= $match ?>% AI Match
                        </div>
                    </div>
                    <hr>
                    
                    <div class="job-details">
                        <p><strong><i class="fas fa-list-check" style="color: var(--maroon); margin-right: 6px;"></i>Requirements:</strong></p>
                        <p><?= htmlspecialchars($job->qualifications) ?></p>
                        <p style="margin-top: 16px;"><strong><i class="fas fa-briefcase" style="color: var(--gold); margin-right: 6px;"></i>About the Role:</strong></p>
                        <p><?= nl2br(htmlspecialchars($job->description)) ?></p>
                    </div>

                    <div class="modal-form">
                        <form method="post" enctype="multipart/form-data" action="<?= base_url('jobs/apply/' . $job->id) ?>" class="job-apply-form" data-job-id="<?= $job->id ?>">
                            <p style="font-weight: 600; color: var(--text); margin-bottom: 12px;"><i class="fas fa-file-upload" style="color: var(--maroon); margin-right: 6px;"></i>Upload Your Resume</p>
                            
                            <label class="file-input-wrapper" for="file-<?= $job->id ?>">
                                <i class="fas fa-cloud-arrow-up" style="font-size: 28px; color: var(--gold); margin-bottom: 8px; display: block;"></i>
                                <p style="margin: 0; font-weight: 600; color: var(--text);" id="lbl-<?= $job->id ?>">Click to upload or drag & drop</p>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: var(--muted);">PDF ONLY</p>
                                <input type="file" name="attachment" id="file-<?= $job->id ?>" accept="application/pdf" required onchange="updateLabel(this, <?= $job->id ?>)">
                            </label>

                            <button type="submit" class="btn-submit" id="btn-submit-<?= $job->id ?>"><i class="fas fa-paper-plane"></i> Submit Application</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; else: ?>
        <div style="text-align: center; padding: 48px 20px; color: var(--muted);">
            <p>No Jobs Found</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Trigger Success Popup Tile specifically for upload success
    <?php if ($this->session->flashdata('upload_success')): ?>
        window.addEventListener('load', () => {
            const popup = document.getElementById('success-popup');
            popup.classList.add('show');
            setTimeout(() => popup.classList.remove('show'), 5000);
        });
    <?php endif; ?>

    function toggleModal(id, show) {
        const modal = document.getElementById('modal-' + id);
        if (!modal) return;
        if (show) modal.classList.add('open');
        else modal.classList.remove('open');
        document.body.style.overflow = show ? 'hidden' : 'auto';
    }

    function closeOverlay(e, id) {
        if (e.target.classList.contains('modal-overlay')) toggleModal(id, false);
    }

    function updateLabel(input, id) {
        const lbl = document.getElementById('lbl-' + id);
        if (input.files && input.files[0]) {
            lbl.innerText = input.files[0].name;
            lbl.style.color = "var(--maroon)";
        }
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Configure toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "4000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "slideUp"
    };

    function showToast(message, type = 'success') {
        toastr[type](message);
    }

    // Handle form submissions
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.job-apply-form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const jobId = this.getAttribute('data-job-id');
                const submitBtn = document.getElementById(`btn-submit-${jobId}`);
                const fileInput = form.querySelector('input[type="file"]');
                
                if (!fileInput.files || fileInput.files.length === 0) {
                    e.preventDefault();
                    showToast('Please select a PDF file', 'error');
                    return;
                }

                // Show uploading message
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading PDF...';
                showToast('📤 Uploading your PDF...', 'info');

                // Simulate upload delay for demo, then show success
                // In real scenario, the form submission will redirect after success
                setTimeout(() => {
                    showToast('✅ PDF uploaded successfully!', 'success');
                }, 1500);
            });
        });
    });

    function updateFilter(minScore) {
        document.querySelectorAll('.job-card').forEach(card => {
            const score = parseInt(card.dataset.score);
            card.style.display = (minScore === 'all' || score >= minScore) ? 'flex' : 'none';
        });
        document.querySelectorAll('.f-pill').forEach(p => p.classList.remove('active'));
        const btnId = minScore === 'all' ? 'btn-all' : 'btn-' + minScore;
        document.getElementById(btnId).classList.add('active');
    }
</script>

