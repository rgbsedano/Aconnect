<style>
    /* 🎨 MODERN & COMPACT JOB LISTING STYLES */
    :root {
        --primary-maroon: #700A0A; /* SDCA Primary Color */
        --light-bg: #f8f9fa; /* Light background for the list item */
        --card-bg: #ffffff;
        --text-dark: #1c1e21;
        --text-muted: #6c757d;
        --accent-green: #28a745;
        --border-color: #e3e6f0;
        --border-radius-lg: 10px;
        --border-radius-sm: 5px;
    }

    /* Overall Container */
    .job-section {
        padding: 20px;
        max-width: 1200px; /* Use a wider space for the job board */
        margin: 0 auto;
        background-color: var(--card-bg); /* Match the sidebar background if used in the main content area */
        border-radius: var(--border-radius-lg);
    }

    /* Heading */
    .job-heading {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 25px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 10px;
    }

    /* Search Form */
    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 30px;
        padding: 0;
    }

    .search-input-group {
        flex-grow: 1;
        min-width: 200px;
        display: flex;
        flex-direction: column;
    }

    .form-control-modern {
        padding: 10px 15px;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        font-size: 1rem;
        height: 45px;
    }

    .btn-search-modern {
        width: 100%;
        background: var(--primary-maroon) !important;
        color: white;
        border: none;
        height: 45px;
        border-radius: var(--border-radius-sm);
        font-weight: 600;
        transition: background-color 0.2s;
    }

    .btn-search-modern:hover {
        background: #5a0808 !important;
    }

    /* Job Card Grid */
    .job-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    /* Individual Job Card */
    .job-card-modern {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-lg);
        padding: 20px;
        cursor: pointer;
        transition: box-shadow 0.3s, transform 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 220px; /* Ensure cards have a minimum height */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .job-card-modern:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .job-title-modern {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-maroon);
        margin-top: 0;
        margin-bottom: 5px;
    }

    .job-company {
        font-size: 1rem;
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 5px;
    }

    .job-location-salary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    .job-salary {
        color: var(--accent-green);
        font-weight: 700;
    }

    /* Qualifications Summary (Compact) */
    .job-qualifications-summary {
        font-size: 0.9rem;
        color: var(--text-muted);
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Limit text to 3 lines */
        -webkit-box-orient: vertical;
    }

    /* Modal styles (Preserving original names but enhancing appearance) */
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1000; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgba(0,0,0,0.6); 
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: var(--card-bg);
        margin: auto;
        padding: 30px;
        border: none;
        width: 90%; 
        max-width: 700px; /* Wider modal for readability */
        border-radius: var(--border-radius-lg);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        position: relative;
    }
    
    .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
    
    .modal-content h3 {
        color: var(--primary-maroon);
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .close {
        color: var(--text-dark);
        font-size: 32px;
        font-weight: normal;
        line-height: 1;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .close:hover {
        opacity: 1;
    }

    .modal-content strong {
        color: var(--text-dark);
        font-weight: 600;
    }
    
    .modal-content p {
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .modal-content img {
        margin-bottom: 15px;
        border-radius: var(--border-radius-sm);
    }
    
    .btn-apply-modern {
        background-color: var(--accent-green);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: var(--border-radius-sm);
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    
    .btn-apply-modern:hover {
        background-color: #1e7e34;
    }
    
    /* Responsive Adjustments */
    @media (min-width: 768px) {
        .search-form {
            flex-wrap: nowrap;
        }
        .search-input-group {
            flex-grow: 1;
        }
        .btn-search-group {
            width: 150px; /* Fixed width for search button on desktop */
        }
    }
</style>

<script>
    function openModal(id) {
        document.getElementById('job-modal-' + id).style.display = 'flex'; // Use flex to center
    }
    function closeModal(id) {
        document.getElementById('job-modal-' + id).style.display = 'none';
    }
    // Close modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>

<div class="job-section">
    <h2 class="job-heading">Job Opportunities</h2>

    <form method="get" action="<?= base_url('jobs') ?>" class="search-form">
        <div class="search-input-group">
            <input type="text" name="search" class="form-control-modern" placeholder="Keyword... jobs or company" value="<?= $this->input->get('search',true) ?>" />
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
                            <img src="<?= base_url('./assets/uploads/jobs/' . $job->image_filename) ?>" class="card-img-top" alt="Job Image" style="width: 100%; max-height: 300px; object-fit: cover;">
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
        <p>No job listings available matching your criteria.</p>
    <?php endif; ?>
</div>  