
<script>
function openEditModal() {
    document.getElementById('editProfileModal').classList.add('show');
    document.getElementById('editJobModal').classList.add('show');
    document.getElementById('editSkillModal').classList.add('show');
}

function closeEditModal() {
    document.getElementById('editProfileModal').classList.remove('show');
    document.getElementById('editJobModal').classList.remove('show');
    document.getElementById('editSkillModal').classList.remove('show');
}
</script>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Profile</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background: #700A0A">
            <h6 class="m-0 font-weight-bold text-white"  >Personal Information</h6>
        </div>
        
        <div class="card-body d-flex align-items-center">
        
            <?php if ($alumni && isset($alumni->profile_image)): ?>
                <img class="profile-image rounded-circle mr-4" src="<?= base_url('assets/uploads/alumni/' . $alumni->profile_image) ?>" alt="Profile Image" style="width: 200px; height: 200px;">
                
            <?php else: ?>
                <div class="bg-light rounded-circle mr-4 d-flex align-items-center justify-content-center" style="width: 200px; height: 200px;">
                <img  style="border-radius: 50%; width: 100%; height: 100%" src="<?php echo base_url('assets/images/person-male.png'); ?>" alt="My Photo">
                </div>
                
            <?php endif; ?>
            <div class="profile-info">
                <h2 class="mb-0 font-weight-bold text-gray-800"><?= isset($alumni->first_name) && isset($alumni->last_name) ? ucwords(strtolower($alumni->first_name . ' ' . $alumni->last_name)) : 'N/A' ?></h2>
                <p class="mb-1 text-gray-700"><strong>Alumni ID Number:</strong> <?= isset($alumni->alumni_number) ? $alumni->alumni_number : 'N/A' ?></p>
                <p class="mb-1 text-gray-700"><strong>Student Number:</strong> <?= isset($alumni->student_number) ? $alumni->student_number : 'N/A' ?></p>
                <p class="mb-1 text-gray-700"><strong>Email:</strong> <?= isset($alumni->email) ? $alumni->email : 'N/A' ?></p>
                <p class="mb-1 text-gray-700"><strong>Phone:</strong> <?= isset($alumni->phone) ? $alumni->phone : 'N/A' ?></p>
                <p class="mb-1 text-gray-700"><strong>Graduation Year:</strong> <?= isset($alumni->graduation_year) ? $alumni->graduation_year : 'N/A' ?></p>
                <p class="mb-0 text-gray-700"><strong>Degree:</strong> <?= isset($alumni->degree) ? $alumni->degree : 'N/A' ?></p>
            </div>

        </div>
        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editProfileModal" style="background: #700A0A">
        <i class="fas fa-edit mr-2"></i>Edit
        </a>
    </div>

        <!-- Bootstrap Modal -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php if ($this->session->flashdata('edit_error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('edit_error'); ?></div>
            <?php elseif ($this->session->flashdata('edit_success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('edit_success'); ?></div>
            <?php endif; ?>

            <form action="<?= base_url('profile/update/' . $alumni->id) ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="form-group">
                    <label>Alumni ID</label>
                    <input type="text" name="alumni_number" class="form-control" value="<?= $alumni->alumni_number ?>">
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?= $alumni->first_name ?>">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?= $alumni->last_name ?>">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= $alumni->phone ?>">
                </div>
                <div class="form-group">
                    <label>Graduation Year</label>
                    <input type="number" name="graduation_year" class="form-control" value="<?= $alumni->graduation_year ?>">
                </div>
                <div class="form-group">
                    <label>Degree</label>
                    <input type="text" name="degree" class="form-control" value="<?= $alumni->degree ?>">
                </div>
                <div class="form-group">
                    <label>Profile Image</label>
                    <input type="file" name="profile_image" class="form-control">
                </div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" style="background: #700A0A" class="btn btn-success">Save Changes</button>
                </div>
            </form>

            </div>
        </div>
        </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #700A0A">
            <h6 class="m-0 font-weight-bold text-white">Current Job</h6>
        </div>
        <div class="card-body">
            <p class="mb-2 text-gray-700">Showcase your accomplishments and get up to 2X as many profile views and connections</p>
            <div class="d-flex align-items-start mb-3">
                <div class="bg-light rounded p-2 mr-3" style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
                    <i class="fas fa-briefcase text-gray-500 fa-sm"></i>
                </div>
                <div>
                    <h6 class="mb-0 font-weight-bold text-gray-800">
                        <?= !empty($alumni->current_job) ? $alumni->current_job : 'Job Title/Position:' ?>
                    </h6>
                    <small class="text-muted">
                        <?= !empty($alumni->current_job_organization) ? $alumni->current_job_organization : 'Organization:' ?>
                    </small><br>
                    <small class="text-muted">
                        <?= !empty($alumni->current_job_length) ? $alumni->current_job_length : 'Example: 2019 - present' ?>
                    </small>
                </div>
            </div>
            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editJobModal" style="background: #700A0A"><i class="fas fa-plus mr-2"></i>Edit</a>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="editJobModal" tabindex="-1" role="dialog" aria-labelledby="editJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="editJobModalLabel">Edit Job Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="<?= base_url('profile/update_job_info/' . $alumni->id) ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
       
                <div class="form-group">
                    <label>Current Job</label>
                    <input type="text" class="form-control" name="current_job" value="<?= $alumni->current_job ?>">
                </div>

                <div class="form-group">
                    <label>Organization</label>
                    <input type="text" class="form-control" name="current_job_organization" value="<?= $alumni->current_job_organization ?>">
                </div>

                <div class="form-group">
                    <label>Length (e.g., 2 years)</label>
                    <input type="text" class="form-control" name="current_job_length" value="<?= $alumni->current_job_length ?>">
                </div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" style="background: #700A0A" class="btn btn-success">Save Changes</button>
                </div>
            </form>

            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #700A0A">
            <h6 class="m-0 font-weight-bold text-white">Skills</h6>
        </div>
        <div class="card-body">
            <p class="mb-2 text-gray-700">Communicate your fit for new opportunities — 50% of hirers use skills data to fill their roles</p>
            <p class="mb-1 text-gray-800"><strong>Soft skills:</strong></p>
            <p class="mb-2 text-gray-700">
                <?= !empty($alumni->soft_skills) ? $alumni->soft_skills : '' ?>
            </p>
            <p class="mb-1 text-gray-800"><strong>Technical skills:</strong></p>
            <p class="mb-2 text-gray-700">
                <?= !empty($alumni->technical_skills) ? $alumni->technical_skills : 'N/A' ?>
            </p>
            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editSkillModal" style="background: #700A0A">
                <i class="fas fa-plus mr-2"></i>Add skills
            </a>
        </div>
    </div>

      <!-- Bootstrap Modal -->
      <div class="modal fade" id="editSkillModal" tabindex="-1" role="dialog" aria-labelledby="editSkillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="editSkillModalLabel">Edit Skills Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="<?= base_url('profile/update_skill_info/' . $alumni->id) ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
       
                <div class="form-group">
                    <label>Soft Skills</label>
                    <input type="text" class="form-control" name="soft_skills" value="<?= $alumni->soft_skills ?>">
                </div>

                <div class="form-group">
                    <label>Technical Skills</label>
                    <input type="text" class="form-control" name="technical_skills" value="<?= $alumni->technical_skills ?>">
                </div>

                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" style="background: #700A0A" class="btn btn-success">Save Changes</button>
                </div>
            </form>

            </div>
        </div>
    </div>

<!-- Bootstrap 4 JS dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>


</div> <style>
    .profile-image {
        border-radius: 50%;
        width: 80px;
        height: 80px;
        object-fit: cover;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }

    .profile-info h5 {
        margin-bottom: 5px;
        color: #4e73df;
    }
        .modal {
    display: none;
    position: fixed;
    z-index: 10000;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.modal.show {
    display: flex;
}
</style>

<script>
    // Close modal if background is clicked
    window.onclick = function(event) {
        var modal = document.getElementById('editProfileModal');
        if (event.target === modal) {
            closeEditModal();
        }
    };
</script>

<?php if ($this->session->flashdata('show_edit_modal')): ?>
<script>
    $(document).ready(function () {
        $('#editProfileModal').modal('show');
    });
</script>
<?php endif; ?>