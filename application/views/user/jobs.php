<style>
    .job-card-modern {
        background-color: #f8f9fa;
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
        padding: 15px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
    }

    .job-card-modern:hover {
        background-color: #edf2f7;
        border-color: #d2ddec;
    }

    .job-details {
        flex-grow: 1;
    }

    .job-title-modern {
        margin-top: 0;
        margin-bottom: 5px;
        color: #4e73df;
        font-size: 1.1rem;
        font-weight: bold;
    }

    .job-company-location {
        margin-bottom: 5px;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .job-salary {
        color: #28a745;
        font-weight: bold;
        font-size: 0.95rem;
    }

    .job-meta {
        color: #6c757d;
        font-size: 0.8rem;
    }

    .job-flag-icon {
        color: #4e73df;
        font-size: 2rem;
        margin-left: 15px;
    }

    /* Modal styles */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1000; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
        border-radius: 0.35rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        position: relative;
    }

    .close {
        color: #aaa;
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-content h3 {
        color: #4e73df;
        margin-top: 0;
        margin-bottom: 15px;
    }

    .modal-content p {
        margin-bottom: 10px;
        color: #6c757d;
    }

    .modal-content strong {
        color: #212529;
    }

    .modal-content label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #495057;
    }

    .modal-content input[type=file] {
        display: block;
        margin-bottom: 15px;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .modal-content button[type=submit] {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 0.25rem;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.2s ease-in-out;
    }

    .modal-content button[type=submit]:hover {
        background-color: #218838;
    }

    .form-control{
        width: 49%;
        display: inline;
        margin: 0;
        gap: 0;
    }
</style>

<script>
    function openModal(id) {
        document.getElementById('job-modal-' + id).style.display = 'block';
    }
    function closeModal(id) {
        document.getElementById('job-modal-' + id).style.display = 'none';
    }
</script>

<div class="job-section">
    <h2 class="job-heading">Job Opportunities</h2>

    <form method="get" action="<?= base_url('jobs') ?>" style="margin-bottom: 20px; justify-content: center; padding:0">
        <input type="text" name="search" class="form-control" placeholder="Keyword... jobs or company " value="<?= $this->input->get('search',true) ?>" />
        <input type="text" name="location" class="form-control" placeholder="Search locations..." value="<?= $this->input->get('location',true) ?>" />
        <br>
        <button type="submit" class="btn btn-primary mt-2" style="width: 98%; display: content; justify-content: center; margin top:0; background: #700A0A;" >Search</button>
    </form>

    <?php if (!empty($jobs)): ?>
        <div class="job-cards">
            <?php foreach ($jobs as $job): ?>
                <div class="job-card-modern" onclick="openModal(<?= $job->id ?>)">
                    <div class="job-details" style="max-width: 300px;">
                        <h4 class="job-title-modern text-danger"><?= htmlspecialchars($job->job_title) ?></h4>
                        <div class="job-company-location">
                            <b>Company: </b><?= htmlspecialchars($job->company) ?><br>
                            <i class='fas fa-map-marker-alt'></i> <?= htmlspecialchars($job->location) ?>
                            <p><i class='fas fa-money-bill-wave'></i> <?= htmlspecialchars($job->salary_range) ?></p>
                            <p><b>Qualifications</b> <?= htmlspecialchars($job->qualifications) ?></p>
                        </div>
                    </div>
                    <div class="job-flag-icon"  >
                        <i class="fas fa-flag" style="color: #700A0A"></i>
                    </div>
                </div>

                <div id="job-modal-<?= $job->id ?>" class="modal">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h3><?= htmlspecialchars($job->job_title) ?></h3>
                          <span class="close" style= "margin: 10px" onclick="closeModal(<?= $job->id ?>)">&times;</span>
                      </div>
                        
                        <?php if ($job->image_filename): ?>
                                <img src="<?= base_url('./assets/uploads/jobs/' . $job->image_filename) ?>" class="card-img-top" alt="Job Image" style="max-width: 100%; height: 400px;">
                            <?php endif; ?>
                        <p><strong>Company:</strong> <?= htmlspecialchars($job->company) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($job->location) ?></p>
                        <p><strong>Salary Range:</strong> <?= htmlspecialchars($job->salary_range) ?></p>
                        <p><strong>Qualifications:</strong> <?= htmlspecialchars($job->qualifications) ?></p>
                        <p><strong>Contact Details:</strong> <?= htmlspecialchars($job->contact_details) ?></p>
                        <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($job->description)) ?></p>

                        <form method="post" enctype="multipart/form-data" action="<?= base_url('jobs/apply/' . $job->id) ?>">
                            <label for="attachment">Attach Resume:</label>
                            <input type="file" name="attachment" accept=".pdf,.doc,.docx" class="form-control-file" required><br><br>
                            <button type="submit" class="btn btn-success">Apply</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No job listings available.</p>
    <?php endif; ?>
</div>



