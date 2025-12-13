<?php
// Function to compute AI match score
function compute_ai_match($alumni, $job) {
    if (!$alumni) return 0;

    $wTech  = 30;
    $wSoft  = 10;
    $wKey   = 5;
    $wTitle = 55;

    $score = 0;

    $titleMatch = 0;
    $jobTitle = strtolower($job->job_title);
    $deg = strtolower($alumni->degree);

    // Job title matches
    $titleMap = [
        'information technology' => ['it','developer','programmer','software','technical'],
        'nursing' => ['nurse','staff nurse'],
        'radiologic' => ['radtech','radiologic'],
        'business' => ['marketing','hr','finance','accountancy'],
        'multimedia' => ['graphic','designer'],
        'communication' => ['editor','writer']
    ];
    foreach($titleMap as $degKey => $keywords){
        if(strpos($deg,$degKey)!==false){
            foreach($keywords as $kw){
                if(strpos($jobTitle,$kw)!==false) $titleMatch = 1;
            }
        }
    }

    // Technical skills
    $alTech = array_filter(array_map('trim', explode(',', strtolower($alumni->technical_skills ?? ""))));
    $jobTech = array_filter(array_map('trim', explode(',', strtolower($job->qualifications ?? ""))));
    $techMatch = count($jobTech)>0 ? count(array_intersect($alTech,$jobTech))/count($jobTech) : 0;

    // Soft skills
    $alSoft = array_filter(array_map('trim', explode(',', strtolower($alumni->soft_skills ?? ""))));
    $desc = strtolower($job->description ?? "");
    $softCount = 0;
    foreach($alSoft as $soft){
        if(strpos($desc,$soft)!==false) $softCount++;
    }
    $softMatch = count($alSoft)>0 ? $softCount/count($alSoft) : 0;

    // Keyword match
    $searchSpace = strtolower($job->company . " " . $job->job_title . " " . $job->description);
    $keyMatch = 0;
    foreach($alTech as $skill){
        if(strpos($searchSpace,$skill)!==false){ $keyMatch = 1; break; }
    }

    $score = ($techMatch*$wTech)+($softMatch*$wSoft)+($keyMatch*$wKey)+($titleMatch*$wTitle);
    return round($score);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Job Opportunities</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
:root {
    --primary-maroon: #700A0A;
    --accent-green: #28a745;
    --background-light: #f0f2f5;
    --card-bg: #ffffff;
    --text-dark: #1c1e21;
    --text-muted: #606770;
    --border-color: #dddfe2;
    --border-radius-lg: 12px;
    --border-radius-sm: 8px;
    --light-maroon: #d0c0c0;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--background-light);
    margin:0; padding:0;
}

.main-content-wrapper {
    padding-top: 30px;
    min-height: 100vh;
    padding-bottom: 40px;
}

.job-section {
    max-width: 1200px;
    margin: 0 auto;
    background-color: var(--card-bg);
    padding: 20px;
    border-radius: var(--border-radius-lg);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.job-heading {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 25px;
    border-bottom: 2px solid var(--light-maroon);
    padding-bottom: 10px;
}

.search-form {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 30px;
    background-color: var(--background-light);
    padding: 15px;
    border-radius: var(--border-radius-sm);
}

.search-input-group {
    position: relative;
    flex-grow:1;
    min-width: 180px;
    display: flex;
    flex-direction: column;
}

.form-control-modern {
    padding: 10px 40px 10px 15px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius-sm);
    font-size: 1rem;
    height: 45px;
}

.form-control-modern:focus {
    border-color: var(--primary-maroon);
    outline: none;
    box-shadow: 0 0 0 3px rgba(112,10,10,0.2);
}

.clear-input {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.2rem;
    color: var(--text-muted);
    cursor: pointer;
    user-select: none;
    transition: color 0.2s;
}

.clear-input:hover { color: var(--primary-maroon); }

.btn-search-modern {
    width: 100%;
    background: var(--primary-maroon);
    color: white;
    border: none;
    height: 45px;
    border-radius: var(--border-radius-sm);
    font-weight: 600;
}

.job-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

.job-card-modern {
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius-lg);
    padding: 20px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    border-left: 5px solid var(--light-maroon);
    transition: 0.3s;
}

.job-card-modern:hover {
    box-shadow: 0 6px 15px rgba(0,0,0,0.12);
    transform: translateY(-3px);
    border-left: 5px solid var(--primary-maroon);
}

.job-title-modern { font-size: 1.4rem; font-weight:700; color: var(--primary-maroon); margin:0 0 5px 0;}
.job-company { font-weight:600; color: var(--text-dark); margin-bottom:8px; }
.job-location-salary { display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; font-size:0.9rem; color:var(--text-muted); border-top:1px dashed var(--border-color); padding-top:5px;}
.job-location-salary i { margin-right:5px; color:var(--primary-maroon);}
.job-salary { color:var(--accent-green); font-weight:700; }
.job-qualifications-summary { font-size:0.9rem; color:var(--text-muted); overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;}

.modal {
    display: none;
    position: fixed;
    z-index:1000;
    left:0; top:15px;
    width:100%; height:100%;
    overflow:auto;
    background-color: rgba(0,0,0,0.8);
    justify-content:flex-start;
    align-items:flex-start;
    padding-top:60px; padding-bottom:40px;
}

.modal-content {
    background-color: var(--card-bg);
    margin: auto;
    padding: 25px;
    width: 90%; max-width:900px;
    max-height:80vh;
    border-radius: var(--border-radius-lg);
    overflow-y:auto;
    position: relative;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.modal-header-custom {
    display:flex; justify-content:space-between; align-items:center;
    border-bottom:1px solid var(--border-color);
    margin-bottom:15px;
}

.modal-header-custom h3 { color:var(--primary-maroon); font-size:1.6rem; margin:0;}
.close { font-size:36px; cursor:pointer; color:var(--text-dark); opacity:0.8; transition:0.2s;}
.close:hover { opacity:1; transform:rotate(5deg);}

.btn-apply-modern {
    background-color: var(--accent-green);
    color:white;
    padding:12px 25px;
    border:none;
    border-radius: var(--border-radius-sm);
    cursor:pointer;
    font-weight:700;
    text-transform:uppercase;
}

.btn-apply-modern:hover {
    background-color:#1e7e34;
}

@media (max-width:767px){
    .search-form { flex-wrap:wrap; }
    .job-cards-grid { grid-template-columns:1fr; }
}
</style>

<script>
function openModal(id){ document.getElementById('job-modal-'+id).style.display='flex'; }
function closeModal(id){ document.getElementById('job-modal-'+id).style.display='none'; }
window.onclick = function(event){ if(event.target.classList.contains('modal')) event.target.style.display='none'; }

function clearInput(name){
    const input = document.querySelector(`input[name="${name}"]`);
    if(input) input.value='';
    input.form.submit(); // reset search results
}
</script>
</head>
<body>

<div class="main-content-wrapper">
<div class="job-section">
    <h2 class="job-heading">Job Opportunities</h2>

    <form method="get" action="<?= base_url('jobs') ?>" class="search-form">
        <div class="search-input-group">
            <input type="text" name="search" class="form-control-modern" placeholder="Keyword... job title or company" value="<?= $this->input->get('search',true) ?>" />
            <?php if($this->input->get('search',true)): ?>
                <span class="clear-input" onclick="clearInput('search')">&times;</span>
            <?php endif; ?>
        </div>
        <div class="search-input-group">
            <input type="text" name="location" class="form-control-modern" placeholder="Search locations..." value="<?= $this->input->get('location',true) ?>" />
            <?php if($this->input->get('location',true)): ?>
                <span class="clear-input" onclick="clearInput('location')">&times;</span>
            <?php endif; ?>
        </div>
        <div class="search-input-group" style="flex-grow:0;">
            <button type="submit" class="btn-search-modern">Search</button>
        </div>
    </form>

    <?php if(!empty($jobs)): ?>
        <div class="job-cards-grid">
        <?php foreach($jobs as $job): ?>
            <div class="job-card-modern" onclick="openModal(<?= $job->id ?>)">
                <h4 class="job-title-modern"><?= htmlspecialchars($job->job_title) ?></h4>
                <p class="job-company"><?= htmlspecialchars($job->company) ?></p>
                <div class="job-location-salary">
                    <span class="job-location"><i class='fas fa-map-marker-alt'></i> <?= htmlspecialchars($job->location) ?></span>
                    <span class="job-salary"><i class='fas fa-money-bill-wave'></i> <?= htmlspecialchars($job->salary_range) ?></span>
                </div>
                <?php $match=compute_ai_match($alumni,$job);
                    $badgeStyle=($match>=70)?"background:#28a745;color:white;":(($match>=40)?"background:#ffc107;color:black;":"background:#6c757d;color:white;"); ?>
                <div style="margin-bottom:10px;">
                    <span style="<?= $badgeStyle ?> padding:5px 10px; border-radius:6px; font-size:0.85rem;">AI Match: <?= $match ?>%</span>
                </div>
                <p class="job-qualifications-summary"><strong>Qualifications:</strong> <?= htmlspecialchars($job->qualifications) ?></p>
            </div>

            <div id="job-modal-<?= $job->id ?>" class="modal">
                <div class="modal-content">
                    <div class="modal-header-custom">
                        <h3><?= htmlspecialchars($job->job_title) ?></h3>
                        <span class="close" onclick="closeModal(<?= $job->id ?>)">&times;</span>
                    </div>
                    <?php if($job->image_filename): ?>
                        <img src="<?= base_url('./assets/uploads/jobs/'.$job->image_filename) ?>" style="width:100%; max-height:180px; object-fit:cover;" onerror="this.onerror=null;this.src='https://placehold.co/900x300/f0f2f5/606770?text=Company+Image+Unavailable';">
                    <?php endif; ?>
                    <p><strong>Company:</strong> <?= htmlspecialchars($job->company) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($job->location) ?></p>
                    <p><strong>Salary Range:</strong> <?= htmlspecialchars($job->salary_range) ?></p>
                    <p><strong>Contact Details:</strong> <?= htmlspecialchars($job->contact_details) ?></p>
                    <hr>
                    <div style="margin-bottom:10px;">
                        <span style="<?= $badgeStyle ?> padding:5px 10px; border-radius:6px; font-size:0.85rem;">AI Match: <?= $match ?>%</span>
                    </div>
                    <p><strong>Qualifications:</strong><br><?= htmlspecialchars($job->qualifications) ?></p>
                    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($job->description)) ?></p>
                    <hr>
                    <form method="post" enctype="multipart/form-data" action="<?= base_url('jobs/apply/'.$job->id) ?>">
                        <label for="attachment">Attach Resume (PDF/DOCX):</label>
                        <input type="file" name="attachment" accept=".pdf,.doc,.docx" class="form-control-modern" required style="width:100%; margin-bottom:15px;">
                        <button type="submit" class="btn-apply-modern">Apply Now</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center p-5" style="border:1px dashed var(--border-color); border-radius: var(--border-radius-lg);">
            <i class="fas fa-search-minus fa-3x" style="color:var(--text-muted); margin-bottom:15px;"></i>
            <p style="color: var(--text-dark); font-weight:600;">No job listings available matching your criteria.</p>
            <p style="color:var(--text-muted);">Try broadening your search keywords or location.</p>
        </div>
    <?php endif; ?>

</div>
</div>
</body>
</html>
