<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RG Opportunities</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        :root {
            --primary-maroon: #700A0A; 
            --accent-color: #fca311; 
            --background-light: #f0f2f5; 
            --card-bg: #ffffff;
            --text-dark: #1c1e21;
            --text-muted: #606770;
            --accent-green: #28a745;
            --border-color: #dddfe2; 
            --border-radius-lg: 12px; 
            --border-radius-sm: 8px; 
            --light-maroon: #d0c0c0;
        }

        body {
            background-color: var(--background-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-content-wrapper {
            padding-top: 20px; 
            background-color: var(--background-light); 
            min-height: 100vh;
            padding-bottom: 40px; 
        }

        .job-section {
            padding: 20px;
            max-width: 1200px; 
            width: 95%; 
            margin: 0 auto; 
            background-color: var(--card-bg);
            border-radius: var(--border-radius-lg);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); 
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
            padding: 0;
            background-color: var(--background-light);
            padding: 15px;
            border-radius: var(--border-radius-sm);
        }

        .search-input-group {
            flex-grow: 1;
            min-width: 180px;
            display: flex;
            flex-direction: column;
        }
        
        .search-input-group:nth-child(1),
        .search-input-group:nth-child(2) {
             min-width: 100%;
        }

        .form-control-modern {
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            font-size: 1rem;
            height: 45px;
            transition: border-color 0.2s;
        }
        .form-control-modern:focus {
            border-color: var(--primary-maroon);
            outline: none;
            box-shadow: 0 0 0 3px rgba(112, 10, 10, 0.2);
        }

        .btn-search-modern {
            width: 100%;
            background: var(--primary-maroon) !important;
            color: white;
            border: none;
            height: 45px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-search-modern:hover {
            background: #5a0808 !important;
            transform: translateY(-1px);
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
            transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 200px; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-left: 5px solid var(--light-maroon);
        }

        .job-card-modern:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12); 
            transform: translateY(-3px); 
            border-left: 5px solid var(--primary-maroon); 
        }

        .job-title-modern {
            font-size: 1.4rem; 
            font-weight: 700;
            color: var(--primary-maroon);
            margin-top: 0;
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .job-company {
            font-size: 1.05rem;
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .job-location-salary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: var(--text-muted);
            padding-top: 5px;
            border-top: 1px dashed var(--border-color);
        }
        
        .job-location-salary i {
            color: var(--primary-maroon); 
            margin-right: 5px;
        }

        .job-salary {
            color: var(--accent-green);
            font-weight: 700;
        }

        .job-qualifications-summary {
            font-size: 0.9rem;
            color: var(--text-muted);
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8); 
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: var(--card-bg);
            margin: auto;
            padding: 30px;
            border: none;
            width: 95%; 
            max-width: 900px; 
            max-height: 95vh; 
            border-radius: var(--border-radius-lg);
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow-y: auto; 
        }
        
        .modal-header-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        
        .modal-content h3 {
            color: var(--primary-maroon);
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
        }

        .close {
            color: var(--text-dark);
            font-size: 36px;
            font-weight: normal;
            line-height: 1;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .close:hover {
            opacity: 1;
            transform: rotate(5deg);
        }

        .modal-content strong {
            color: var(--text-dark);
            font-weight: 600;
        }
        
        .modal-content p {
            margin-bottom: 12px;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .modal-content img {
            margin-bottom: 20px;
            border-radius: var(--border-radius-sm);
        }
        
        .btn-apply-modern {
            background-color: var(--accent-green);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            font-size: 1.05rem;
            font-weight: 700; 
            transition: background-color 0.2s, box-shadow 0.2s;
            text-transform: uppercase;
        }
        
        .btn-apply-modern:hover {
            background-color: #1e7e34;
            box-shadow: 0 5px 10px rgba(40, 167, 69, 0.4);
        }
        
        @media (min-width: 768px) {
            .search-form {
                flex-wrap: nowrap;
            }
            .search-input-group {
                min-width: 0; 
            }
            .search-input-group:nth-child(1),
            .search-input-group:nth-child(2) {
                 min-width: 250px;
            }
            .btn-search-group {
                width: 150px;
                display: flex;
                flex-direction: column; 
                gap: 10px;
                align-self: flex-end; 
            }
        }
        
        @media (max-width: 767px) {
            .job-cards-grid {
                grid-template-columns: 1fr; 
            }
            .btn-search-group {
                width: 100%;
                display: flex;
                flex-direction: column; 
                gap: 10px;
            }
        }
    </style>
</head>
<body>

<script>
    function openModal(id) {
        document.getElementById('job-modal-' + id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById('job-modal-' + id).style.display = 'none';
    }
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>

<div class="main-content-wrapper">
    <div class="job-section">
        <h2 class="job-heading">Job Opportunities</h2>

        <form method="get" action="<?= base_url('jobs') ?>" class="search-form">
            <div class="search-input-group">
                <input type="text" name="search" class="form-control-modern" placeholder="Keyword... job title or company" value="<?= $this->input->get('search',true) ?>" />
            </div>
            <div class="search-input-group">
                <input type="text" name="location" class="form-control-modern" placeholder="Search locations..." value="<?= $this->input->get('location',true) ?>" />
            </div>
            
            <div class="search-input-group btn-search-group">
                <button type="submit" class="btn-search-modern">Search</button>
            </div>
        </form>

        <?php if (!empty($jobs)): ?>
            <div class="job-cards-grid">
                <?php foreach ($jobs as $job): ?>
                    <div class="job-card-modern" onclick="openModal(<?= $job->id ?>)">
                        <div class="job-details">
                            <h4 class="job-title-modern"><?= htmlspecialchars($job->job_title) ?></h4>
                            <p class="job-company">
                                <?= htmlspecialchars($job->company) ?>
                            </p>
                            
                            <div class="job-location-salary">
                                <span class="job-location"><i class='fas fa-map-marker-alt'></i> <?= htmlspecialchars($job->location) ?></span>
                                <span class="job-salary"><i class='fas fa-money-bill-wave'></i> <?= htmlspecialchars($job->salary_range) ?></span>
                            </div>

                            <p class="job-qualifications-summary">
                                <strong>Qualifications:</strong> <?= htmlspecialchars($job->qualifications) ?>
                            </p>
                        </div>
                    </div>

                    <div id="job-modal-<?= $job->id ?>" class="modal">
                        <div class="modal-content">
                            <div class="modal-header-custom">
                                <h3><?= htmlspecialchars($job->job_title) ?></h3>
                                <span class="close" onclick="closeModal(<?= $job->id ?>)">&times;</span>
                            </div>
                            
                            <?php if ($job->image_filename): ?>
                                <img 
                                    src="<?= base_url('./assets/uploads/jobs/' . $job->image_filename) ?>" 
                                    class="card-img-top" 
                                    alt="Job Image" 
                                    style="width: 100%; max-height: 300px; object-fit: cover;"
                                    onerror="this.onerror=null; this.src='https://placehold.co/900x300/f0f2f5/606770?text=Company+Image+Unavailable';"
                                >
                            <?php endif; ?>
                            
                            <p><strong>Company:</strong> <?= htmlspecialchars($job->company) ?></p>
                            <p><strong>Location:</strong> <?= htmlspecialchars($job->location) ?></p>
                            <p><strong>Salary Range:</strong> <?= htmlspecialchars($job->salary_range) ?></p>
                            <p><strong>Contact Details:</strong> <?= htmlspecialchars($job->contact_details) ?></p>
                            <hr>
                            <p><strong>Qualifications:</strong><br><?= htmlspecialchars($job->qualifications) ?></p>
                            <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($job->description)) ?></p>
                            <hr>
                            
                            <form method="post" enctype="multipart/form-data" action="<?= base_url('jobs/apply/' . $job->id) ?>">
                                <label for="attachment">Attach Resume (PDF/DOCX):</label>
                                <input type="file" name="attachment" accept=".pdf,.doc,.docx" class="form-control-modern" required style="width: 100%; margin-bottom: 15px;"><br>
                                <button type="submit" class="btn-apply-modern">Apply Now</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center p-5" style="border: 1px dashed var(--border-color); border-radius: var(--border-radius-lg);">
                <i class="fas fa-search-minus fa-3x" style="color: var(--text-muted); margin-bottom: 15px;"></i>
                <p class="lead" style="color: var(--text-dark);">No job listings available matching your criteria.</p>
                <p style="color: var(--text-muted);">Try broadening your search keywords or location.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>