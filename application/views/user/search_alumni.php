<style>
    .container-fluid {
        padding: 30px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    h2 {
        color: #333;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .search-form {
        display: flex;
        margin-bottom: 30px;
    }

    .search-input {
        flex-grow: 1;
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 8px 0 0 8px;
        font-size: 1rem;
        outline: none;
    }

    .search-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 0 8px 8px 0;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.2s ease-in-out;
    }

    .search-button:hover {
        background-color: #0056b3;
    }

    .alumni-list {
        list-style: none;
        padding: 0;
    }

    .alumni-item {
        background-color: #fff;
        padding: 15px 20px;
        margin-bottom: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .alumni-name {
        font-weight: 500;
        color: #333;
    }

    .connection-status {
        color: #777;
        font-size: 0.9rem;
        margin-left: 10px;
    }

    .connect-form {
        margin-left: auto;
    }

    .connect-button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background-color 0.2s ease-in-out;
    }

    .connect-button:hover {
        background-color: #1e7e34;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
        .search-form {
            flex-direction: column;
        }

        .search-input {
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .search-button {
            border-radius: 8px;
        }

        .alumni-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .connect-form {
            margin-left: 0;
            margin-top: 10px;
        }
        
    }
    .search-wrapper {
    position: relative;
    display: inline-block;
    width: 300px;
}

.search-input {
    width: 100%;
    padding-right: 30px; /* space for the X button */
}

.clear-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: transparent;
    font-size: 18px;
    cursor: pointer;
    display: none;
    color: #999;
}
</style>

<div class="container-fluid">
    <h2>Search and Connect Alumni</h2>

    <form method="get" class="mb-4" id="searchForm">
  <div class="row">
    <div class="col-md-10 position-relative">
      <input type="text" name="search" id="searchInput" class="form-control pr-5" placeholder="Search alumni..." value="<?= $this->input->get('search') ?>">

      <?php if ($this->input->get('search')): ?>
        <button type="button" id="clearSearch" class="btn btn-sm btn-light position-absolute" style="right: 45px; top: 50%; transform: translateY(-50%);">
          &times;
        </button>
      <?php endif; ?>
    </div>
    <div class="col-md-2">
      <button type="submit" style="background: #700A0A;" class="btn text-white btn-block">Search</button>
    </div>
  </div>
</form>

<div class="container mt-4">
    <div class="row">
        <?php foreach ($alumni_list as $alumnus): ?>
            <div class="col-md-4 mb-4">
                <!-- Card for each alumni -->
                <div class="card shadow-sm border-light rounded">
                    <div class="card-body">
                        <!-- Profile Image -->
                        <div class="d-flex align-items-center mb-3">

                            <?php if ($alumnus && isset($alumnus->profile_image)): ?>
                                <img class="rounded-circle" src="<?= base_url('assets/uploads/alumni/' . $alumnus->profile_image) ?>" alt="Profile Image" style="width: 60px; height: 60px; margin-right: 15px;">
                                
                            <?php else: ?>

                                <?php if (strtolower($alumnus->gender) === 'male'): ?>
                                    <div class="rounded-circle" style="width: 60px; height: 60px; margin-right: 15px;">
                                    <img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/person-male.png'); ?>" alt="My Photo" style="border-radius: 50%; width: 100%; height: 100%">
                                    </div>
                                <?php else: ?>
                                    <div class="rounded-circle" style="width: 60px; height: 60px; margin-right: 15px;">
                                    <img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/person-female.png'); ?>" alt="My Photo" style="border-radius: 50%; width: 100%; height: 100%">
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="alumni-name">
                                <h5 class="font-weight-bold text-dark mb-0"><?= ucwords(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?></h5>
                                <small class="text-muted"><?= $alumnus->degree ?: 'No Degree Listed' ?></small>
                            </div>
                        </div>

                        <!-- Alumni Name and View Profile Button -->
                        <div class="d-flex justify-content-between mb-3">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewProfileModal<?= $alumnus->id ?>" style="background-color: #700A0A; color: #fff;">
                                View Profile
                            </button>
                        </div>

                        <!-- Connection Status and Connect Button -->
                        <div>
                            <?php if ($alumnus->connection_status == 'accepted'): ?>
                                <span class="badge badge-success">Connected</span>
                            <?php elseif ($alumnus->connection_status == 'pending'): ?>
                                <span class="badge badge-warning">Pending Request</span>
                            <?php else: ?>
                                <form method="post" action="<?= site_url('alumni/send_request') ?>" class="connect-form d-inline">
                                    <input type="hidden" name="receiver_id" value="<?= $alumnus->id ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Connect</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <small class="text-muted">Graduation Year: <?= $alumnus->graduation_year ?></small>
                    </div>
                </div>
            </div>

      <!-- Modal for displaying full alumni details -->
      <div class="modal fade" id="viewProfileModal<?= $alumnus->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewProfileModalLabel" style="color: #700A0A;"><b> <?= ucwords(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?></b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?php if ($alumnus && isset($alumnus->profile_image)): ?>
                                    <img class="img-fluid rounded-circle" src="<?= base_url('assets/uploads/alumni/' . $alumnus->profile_image) ?>" alt="Profile Image" class="img-fluid rounded-circle">
                                    
                                <?php else: ?>
                                    <?php if (strtolower($alumnus->gender) === 'male'): ?>
                                        <img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/person-male.png'); ?>" alt="My Photo">
                                    <?php else: ?>
                                        <img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/person-female.png'); ?>" alt="My Photo">
                                        
                                    <?php endif; ?>
                                <?php endif; ?>
                            
                        </div>
                        <div class="col-md-8">
                          <!-- Profile Details Section -->
                          <div class="mb-4">
                                <h6 class="font-weight-bold" style="color: #700A0A;"><strong>Profile Details</strong></h6>
                                <p><strong>Alumni ID:</strong> <?= !empty($alumnus->email) ? $alumnus->alumni_number : 'N/A' ?></p>
                                <p><strong>Student Number:</strong> <?= !empty($alumnus->email) ? $alumnus->student_number : 'N/A' ?></p>
                                <p><strong>Email:</strong> <?= !empty($alumnus->email) ? $alumnus->email : 'N/A' ?></p>
                                <p><strong>Phone:</strong> <?= !empty($alumnus->phone) ? $alumnus->phone : 'N/A' ?></p>
                                <p><strong>Graduation Year:</strong> <?= !empty($alumnus->graduation_year) ? $alumnus->graduation_year : 'N/A' ?></p>
                                <p><strong>Degree:</strong> <?= !empty($alumnus->degree) ? $alumnus->degree : 'N/A' ?></p>
                                
                            </div>

                            <!-- Current Job Section -->
                            <div class="mb-4">
                                <h6 class="font-weight-bold" style="color: #700A0A;"><strong>Current Job</strong></h6>
                                <p><strong>Job Title:</strong> <?= !empty($alumnus->current_job) ? $alumnus->current_job : 'N/A' ?></p>
                                <p><strong>Organization:</strong> <?= !empty($alumnus->current_job_organization) ? $alumnus->current_job_organization : 'N/A' ?></p>
                                <p><strong>Job Duration:</strong> <?= !empty($alumnus->current_job_length) ? $alumnus->current_job_length : 'N/A' ?></p>
                            </div>

                            <!-- Skills Section -->
                            <div>
                                <h6 class="font-weight-bold" style="color: #700A0A;"><strong>Skills</strong></h6>
                                <p><strong>Soft Skills:</strong> <?= !empty($alumnus->soft_skills) ? $alumnus->soft_skills : 'N/A' ?></p>
                                <p><strong>Technical Skills:</strong> <?= !empty($alumnus->technical_skills) ? $alumnus->technical_skills : 'N/A' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
    
</div>

<script>
document.getElementById('clearSearch')?.addEventListener('click', function () {
  const input = document.getElementById('searchInput');
  input.value = '';
  document.getElementById('searchForm').submit(); // Optional: auto-submit to reset results
});
</script>
<!-- Bootstrap JS + jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>