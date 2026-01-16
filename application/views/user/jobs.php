<?php
// ... (compute_ai_match function remains exactly as you provided) ...
function compute_ai_match($alumni, $job) {
    if (!$alumni) return 0;
    $wTech  = 30; $wSoft  = 10; $wKey   = 5; $wTitle = 55; 
    $score = 0; $titleMatch = 0;
    $jobTitle = strtolower($job->job_title);
    $deg = strtolower($alumni->degree);
    if (strpos($jobTitle, "it") !== false && strpos($deg, "information technology") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "developer") !== false && strpos($deg, "information technology") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "programmer") !== false && strpos($deg, "information technology") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "software") !== false && strpos($deg, "information technology") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "technical") !== false && strpos($deg, "information technology") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "nurse") !== false && strpos($deg, "nursing") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "staff nurse") !== false && strpos($deg, "nursing") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "radtech") !== false && strpos($deg, "radiologic") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "radiologic") !== false && strpos($deg, "radiologic") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "marketing") !== false && strpos($deg, "business") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "hr") !== false && strpos($deg, "business") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "finance") !== false && strpos($deg, "accountancy") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "graphic") !== false && strpos($deg, "multimedia") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "designer") !== false && strpos($deg, "multimedia") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "editor") !== false && strpos($deg, "communication") !== false) $titleMatch = 1;
    if (strpos($jobTitle, "writer") !== false && strpos($deg, "communication") !== false) $titleMatch = 1;

    $alTech = array_filter(array_map('trim', explode(',', strtolower($alumni->technical_skills ?? ""))));
    $jobTech = array_filter(array_map('trim', explode(',', strtolower($job->qualifications ?? ""))));
    $techMatch = 0;
    if (count($jobTech) > 0) {
        $match = array_intersect($alTech, $jobTech);
        $techMatch = count($match) / count($jobTech);
    }
    $alSoft = array_filter(array_map('trim', explode(',', strtolower($alumni->soft_skills ?? ""))));
    $desc = strtolower($job->description ?? "");
    $softCount = 0;
    foreach ($alSoft as $soft) { if (strpos($desc, $soft) !== false) $softCount++; }
    $softMatch = (count($alSoft) > 0) ? $softCount / count($alSoft) : 0;
    $searchSpace = strtolower($job->company . " " . $job->job_title . " " . $job->description);
    $keyMatch = 0;
    foreach ($alTech as $skill) { if (strpos($searchSpace, $skill) !== false) { $keyMatch = 1; break; } }
    $score = ($techMatch * $wTech) + ($softMatch * $wSoft) + ($keyMatch * $wKey) + ($titleMatch * $wTitle);
    return round($score);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board | Premium Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --maroon: #700A0A;
            --maroon-light: #fbeaea;
            --blue: #0a66c2;
            --bg: #f8f9fb;
            --card: #ffffff;
            --text: #1a1a1a;
            --muted: #666666;
            --shadow: 0 8px 30px rgba(0,0,0,0.05);
        }

        body { background: var(--bg); font-family: 'Inter', system-ui, sans-serif; color: var(--text); margin: 0; line-height: 1.5; }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }

        /* Modern Search Header */
        .header-section {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .search-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 15px;
            margin-bottom: 20px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group i { position: absolute; left: 15px; color: var(--muted); }

        .input-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #e1e4e8;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #fdfdfd;
        }

        .input-group input:focus {
            border-color: var(--maroon);
            box-shadow: 0 0 0 4px var(--maroon-light);
            outline: none;
        }

        .btn-search {
            background: var(--maroon);
            color: white;
            border: none;
            padding: 0 30px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-search:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(112, 10, 10, 0.3); }

        /* Filter Pills */
        .filters { display: flex; gap: 10px; flex-wrap: wrap; }
        .f-pill {
            padding: 8px 20px;
            border-radius: 50px;
            border: 1px solid #e1e4e8;
            background: white;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            transition: 0.3s;
        }
        .f-pill.active { background: var(--maroon); color: white; border-color: var(--maroon); }
        .f-pill:hover:not(.active) { background: #f0f2f5; }

        /* Job Cards */
        .job-card {
            background: var(--card);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 20px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid transparent;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .job-card:hover {
            transform: scale(1.01) translateY(-5px);
            box-shadow: var(--shadow);
            border-color: var(--maroon-light);
        }

        .logo-box {
            width: 65px; height: 65px;
            background: var(--maroon-light);
            color: var(--maroon);
            display: flex; align-items: center; justify-content: center;
            border-radius: 14px; font-size: 24px;
        }

        .job-info h3 { margin: 0; font-size: 18px; color: var(--maroon); }
        .job-info p { margin: 5px 0; color: var(--muted); font-size: 14px; }

        .badge-ai {
            margin-left: auto;
            text-align: right;
        }

        .percent {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 14px;
        }

        /* Animated Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0; visibility: hidden;
            transition: 0.3s;
        }

        .modal-overlay.open { opacity: 1; visibility: visible; }

        .modal-box {
            background: white;
            width: 90%; max-width: 600px;
            border-radius: 24px;
            padding: 40px;
            position: relative;
            transform: translateY(50px) scale(0.9);
            transition: 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .modal-overlay.open .modal-box { transform: translateY(0) scale(1); }

        .close-modal {
            position: absolute; top: 20px; right: 25px;
            font-size: 28px; cursor: pointer; color: var(--muted);
        }

        .btn-submit {
            background: var(--blue);
            color: white; border: none; width: 100%;
            padding: 15px; border-radius: 12px;
            font-weight: 700; cursor: pointer; margin-top: 20px;
            transition: 0.3s;
        }
        .btn-submit:hover { background: #084d91; transform: translateY(-2px); }

        @media (max-width: 768px) {
            .search-grid { grid-template-columns: 1fr; }
            .job-card { flex-direction: column; text-align: center; }
            .badge-ai { margin: 10px auto 0; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-section">
        <form method="get" action="<?= base_url('jobs') ?>">
            <div class="search-grid">
                <div class="input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Job title or company..." value="<?= $this->input->get('search') ?>">
                </div>
                <div class="input-group">
                    <i class="fas fa-location-dot"></i>
                    <input type="text" name="location" placeholder="City or Remote" value="<?= $this->input->get('location') ?>">
                </div>
                <button type="submit" class="btn-search">Find Jobs</button>
            </div>
        </form>

        <div class="filters">
            <button class="f-pill active" id="btn-all" onclick="updateFilter('all', 0)">All Opportunities</button>
            <button class="f-pill" id="btn-70" onclick="updateFilter(70)">✨ Best Matches</button>
            <button class="f-pill" id="btn-40" onclick="updateFilter(40)">Good Fits</button>
        </div>
    </div>

    <div id="job-container">
        <?php if (!empty($jobs)): foreach ($jobs as $job): 
            $match = compute_ai_match($alumni, $job);
            $theme = ($match >= 70) ? ['#057642', '#e7f4ed'] : (($match >= 40) ? ['#915907', '#fdf3e1'] : ['#666', '#f3f2ef']);
        ?>
        <div class="job-card" data-score="<?= $match ?>" onclick="toggleModal(<?= $job->id ?>, true)">
            <div class="logo-box"><i class="fas fa-briefcase"></i></div>
            <div class="job-info">
                <h3><?= htmlspecialchars($job->job_title) ?></h3>
                <p><i class="fas fa-building"></i> <?= htmlspecialchars($job->company) ?> • <?= htmlspecialchars($job->location) ?></p>
                <p><i class="fas fa-coins"></i> <?= htmlspecialchars($job->salary_range) ?></p>
            </div>
            <div class="badge-ai">
                <div class="percent" style="color:<?= $theme[0] ?>; background:<?= $theme[1] ?>;">
                    <i class="fas fa-robot"></i> <?= $match ?>% Match
                </div>
            </div>
        </div>

        <div id="modal-<?= $job->id ?>" class="modal-overlay">
            <div class="modal-box">
                <span class="close-modal" onclick="toggleModal(<?= $job->id ?>, false)">&times;</span>
                <h2 style="color:var(--maroon); margin-bottom:5px;"><?= htmlspecialchars($job->job_title) ?></h2>
                <p style="font-weight:700; color:var(--blue);"><?= htmlspecialchars($job->company) ?></p>
                <hr style="border:0; border-top:1px solid #eee; margin:20px 0;">
                
                <div style="height:250px; overflow-y:auto; padding-right:10px; font-size:15px; color:#444;">
                    <p><strong>Requirements:</strong><br><?= htmlspecialchars($job->qualifications) ?></p>
                    <p><strong>About the Role:</strong><br><?= nl2br(htmlspecialchars($job->description)) ?></p>
                </div>

                <form method="post" enctype="multipart/form-data" action="<?= base_url('jobs/apply/' . $job->id) ?>">
                    <div style="background:#f8f9fb; padding:15px; border-radius:12px; border:2px dashed #e1e4e8; margin-top:20px;">
                        <input type="file" name="attachment" required>
                    </div>
                    <button type="submit" class="btn-submit">Submit My Application</button>
                </form>
            </div>
        </div>
        <?php endforeach; endif; ?>
    </div>
</div>

<script>
    function toggleModal(id, show) {
        const modal = document.getElementById('modal-' + id);
        if (show) modal.classList.add('open');
        else modal.classList.remove('open');
        document.body.style.overflow = show ? 'hidden' : 'auto';
    }

    function updateFilter(min) {
        document.querySelectorAll('.job-card').forEach(card => {
            const score = parseInt(card.dataset.score);
            card.style.display = (min === 'all' || score >= min) ? 'flex' : 'none';
        });

        document.querySelectorAll('.f-pill').forEach(p => p.classList.remove('active'));
        const activeBtn = (min === 'all') ? 'btn-all' : 'btn-' + min;
        document.getElementById(activeBtn).classList.add('active');
    }

    // Backdrop click close
    window.onclick = (e) => {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.classList.remove('open');
            document.body.style.overflow = 'auto';
        }
    }
</script>
</body>
</html>