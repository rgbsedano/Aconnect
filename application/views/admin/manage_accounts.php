<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #700a0a;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 24px;
    }

    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px 24px;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-section {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .header-section h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 4px;
        color: white;
    }

    .header-section h1 span { color: #ff6b6b; }
    .header-section p { color: rgba(255, 255, 255, 0.85); font-size: 14px; margin: 0; }

    /* Main Table Card */
    .main-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    /* Custom Table */
    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .custom-table th { padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); border: none; }
    .custom-table tr.data-row { background: white; transition: var(--transition); }
    .custom-table tr.data-row:hover { transform: scale(1.005); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .custom-table td { padding: 16px 20px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    .custom-table td:first-child { border-left: 1px solid #f1f5f9; border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
    .custom-table td:last-child { border-right: 1px solid #f1f5f9; border-top-right-radius: 14px; border-bottom-right-radius: 14px; }

    .user-name { font-weight: 700; color: var(--text-main); font-size: 15px; }
    .student-id { font-size: 12px; font-weight: 600; color: var(--accent-red); background: #fef2f2; padding: 2px 8px; border-radius: 6px; display: inline-block; margin-top: 2px; }
    
    .badge-status { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-inactive { background: #f1f5f9; color: var(--text-muted); }

    .btn-action {
        width: 36px; height: 36px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center;
        background: #f8fafc; color: var(--text-muted); border: 1px solid #e2e8f0; transition: var(--transition);
        margin-left: 5px;
    }
    .btn-action:hover { background: var(--accent-red); color: white; border-color: var(--accent-red); transform: translateY(-2px); }
    .btn-action.delete:hover { background: #ef4444; border-color: #ef4444; }

    /* Modal Styling */
    .modal-content { border-radius: 24px; border: none; overflow: hidden; }
    .modal-header { background: var(--accent-red); color: white; padding: 25px; border: none; }
    .modal-body { padding: 30px; }
    
    .form-label { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; display: block; }
    .form-input { border-radius: 12px; padding: 12px; font-size: 14px; font-weight: 500; border: 1px solid #e2e8f0; }
    .form-input:focus { border-color: var(--accent-red); box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05); }

    .pagination-wrapper { margin-top: 30px; display: flex; justify-content: center; }
    .pagination-wrapper a, .pagination-wrapper strong {
        padding: 8px 16px; margin: 0 4px; border-radius: 10px; font-weight: 600; font-size: 14px;
        border: 1px solid #e2e8f0; color: var(--accent-red); transition: var(--transition);
    }
    .pagination-wrapper strong { background: var(--accent-red); border-color: var(--accent-red); color: white; }
    .pagination-wrapper a:hover { background: #f8fafc; color: var(--accent-red); border-color: var(--accent-red); }

    /* Modal Spacing for Header */
    .modal-dialog { margin-top: 100px !important; margin-bottom: 50px !important; }

    @media (min-width: 992px) {
        /* Desktop: Wide for profile, adaptive for others */
        .modal-wide { max-width: 900px !important; }
        .modal-adaptive { max-width: 650px !important; }
    }

    @media (max-width: 768px) {
        /* Mobile Modal Adjustments */
        .modal-dialog { margin-top: 60px !important; margin-left: 12px; margin-right: 12px; margin-bottom: 30px !important; }
        .modal-content { border-radius: 20px; }
        .modal-body { padding: 20px; }
        .modal-header { padding: 20px; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if($this->session->flashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    Toast.fire({
        icon: 'success',
        title: '<?= $this->session->flashdata('success') ?>'
    });
});
</script>
<?php endif; ?>


<div class="dashboard-wrapper">
    <div class="header-section">
        <div>
            <h1>User <span>Accounts</span></h1>
            <p>Manage alumni credentials, access status, and profile information.</p>
        </div>
    </div>

    <div class="main-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Alumni Profile</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($alumni_list as $a): ?>
                        <tr class="data-row">
                            <td>
                                <div class="user-name view-profile" data-id="<?= $a->id ?>" style="cursor: pointer; color: var(--text-muted); transition: var(--transition);" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                    <?= ucwords($a->first_name . " " . $a->last_name) ?>
                                </div>
                                <div class="student-id"><?= $a->student_number ?></div>
                            </td>
                            <td>
                                <span class="badge-status <?= $a->status == 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                    <?= ucfirst($a->status) ?>
                                </span>
                            </td>
                            <td class="text-right">
                                <button class="btn-action edit-profile" data-id="<?= $a->id ?>" title="Edit Account">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action delete" data-toggle="modal" data-target="#deleteModal<?= $a->id ?>" title="Delete Account">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- DELETE MODAL (Keep per row for simplicity since it's small) -->
                        <div class="modal fade" id="deleteModal<?= $a->id ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body text-center p-5">
                                        <div style="width: 80px; height: 80px; background: #fff1f2; color: #e11d48; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 32px;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <h3 style="font-weight: 700; color: var(--text-main);">Delete Account?</h3>
                                        <p class="text-muted">Are you sure you want to delete <strong><?= ucwords($a->first_name . " " . $a->last_name) ?></strong>? This action cannot be undone.</p>
                                        <div class="d-flex justify-content-center gap-3 mt-4">
                                            <button class="btn btn-light" data-dismiss="modal" style="border-radius: 12px; font-weight: 600; padding: 10px 24px;">Cancel</button>
                                            <a href="<?= base_url('AdminManageAccounts/delete/'.$a->id) ?>" class="btn btn-danger" style="border-radius: 12px; font-weight: 700; padding: 10px 24px;">Confirm Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrapper">
        <?= $pagination ?>
    </div>
</div>


<!-- EDIT ACCOUNT MODAL (Shared) -->
<div class="modal fade" id="editAccountModal" tabindex="-1">
    <div class="modal-dialog modal-wide">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;"><i class="fas fa-user-edit mr-2"></i> Edit Account Profile</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="editForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Student Number</label>
                            <input type="text" name="student_number" id="edit_student_number" class="form-control form-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">New Password (Leave blank to keep)</label>
                            <input type="password" name="password" class="form-control form-input">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control form-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control form-input" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Email - (Do not use the SDCA Email)</label>
                            <input type="email" name="email" id="edit_email" class="form-control form-input" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Alternate Email</label>
                            <input type="email" name="alternative_email" id="edit_alternative_email" class="form-control form-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control form-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telephone Number</label>
                            <input type="text" name="telephone" id="edit_telephone" class="form-control form-input">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Graduation Year</label>
                            <input type="number" name="graduation_year" id="edit_graduation_year" class="form-control form-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Degree</label>
                            <select name="degree" id="edit_degree" class="form-control form-input" required onchange="toggleOtherDegree(this, 'edit_other_degree_container')">
                                <option value="">-- Select Degree --</option>
                                <optgroup label="School of Nursing and Allied Health Studies">
                                    <option value="BS in Nursing">BS in Nursing</option>
                                    <option value="BS in Radiologic Technology">BS in Radiologic Technology</option>
                                    <option value="BS in Physical Therapy">BS in Physical Therapy</option>
                                </optgroup>
                                <optgroup label="School of Medical Laboratory Science">
                                    <option value="BS in Medical Laboratory Science">BS in Medical Laboratory Science</option>
                                    <option value="BS in Pharmacy">BS in Pharmacy</option>
                                    <option value="BS in Biology">BS in Biology</option>
                                </optgroup>
                                <optgroup label="School of Accountancy, Science, and Education">
                                    <option value="BS in Accountancy">BS in Accountancy</option>
                                    <option value="BS in Accounting Technology / AIS">BS in Accounting Technology / AIS</option>
                                    <option value="BS in Psychology">BS in Psychology</option>
                                    <option value="BS in Elementary Education">BS in Elementary Education</option>
                                    <option value="BS in Secondary Education">BS in Secondary Education</option>
                                </optgroup>
                                <optgroup label="School of International, Hospitality, Tourism & Management">
                                    <option value="BS in Business Administration - Financial Management">BS in Business Administration - Financial Management</option>
                                    <option value="BS in Business Administration - Marketing Management">BS in Business Administration - Marketing Management</option>
                                    <option value="BS in Business Administration - HR Development">BS in Business Administration - HR Development</option>
                                    <option value="BS in Business Administration - Operations Management">BS in Business Administration - Operations Management</option>
                                    <option value="BS in Tourism Management">BS in Tourism Management</option>
                                    <option value="BS in Hospitality Management">BS in Hospitality Management</option>
                                    <option value="BS in Hospitality Management - Culinary Arts">BS in Hospitality Management - Culinary Arts</option>
                                    <option value="BS in Hospitality Management - Cruiseline Operations">BS in Hospitality Management - Cruiseline Operations</option>
                                </optgroup>
                                <optgroup label="School of Communication, Multimedia, and Computer Studies">
                                    <option value="BA in Communication">BA in Communication</option>
                                    <option value="Bachelor of Multimedia Arts">Bachelor of Multimedia Arts</option>
                                    <option value="BS in Information Technology">BS in Information Technology</option>
                                </optgroup>
                                <option value="Other">Other (Not Listed)</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3 d-none" id="edit_other_degree_container">
                            <label class="form-label">Specify Other Degree</label>
                            <input type="text" name="degree_other" id="edit_degree_other" class="form-control form-input" placeholder="Enter your degree">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="edit_gender" class="form-control form-input" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Replace Picture</label>
                            <input type="file" name="profile_image" class="form-control border-0 p-0" style="font-size: 12px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 12px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- VIEW MODAL -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-wide">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;"><i class="fas fa-id-card mr-2"></i> Alumni Detailed Profile</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="viewModalContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 12px; font-weight: 600;">Close View</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    // View Profile
    $('.view-profile').on('click', function() {
        const id = $(this).data('id');
        $('#viewModalContent').html('<div class="text-center py-5"><div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div></div>');
        $('#viewModal').modal('show');

        $.ajax({
            url: '<?= base_url("AdminManageAccounts/details") ?>',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                $('#viewModalContent').html(response);
            },
            error: function() {
                $('#viewModalContent').html('<div class="alert alert-danger">Failed to load profile details. Please try again.</div>');
            }
        });
    });

    // Edit Profile (Fetch Data)
    $('.edit-profile').on('click', function() {
        const id = $(this).data('id');
        $('#editAccountModal').modal('show');

        $.ajax({
            url: '<?= base_url("AdminManageAccounts/get_edit_data") ?>',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(data) {
                $('#editForm').attr('action', '<?= base_url("AdminManageAccounts/update/") ?>' + data.id);
                $('#edit_first_name').val(data.first_name);
                $('#edit_last_name').val(data.last_name);
                $('#edit_email').val(data.email);
                $('#edit_alternative_email').val(data.alternative_email);
                $('#edit_phone').val(data.phone);
                $('#edit_telephone').val(data.telephone);
                $('#edit_graduation_year').val(data.graduation_year);
                $('#edit_student_number').val(data.student_number);
                $('#edit_degree').val(data.degree);
                $('#edit_gender').val(data.gender);

                // Handle "Other" degree initial state
                if ($('#edit_degree option[value="' + data.degree + '"]').length === 0 && data.degree !== "") {
                    $('#edit_degree').val("Other");
                    $('#edit_degree_other').val(data.degree);
                    $('#edit_other_degree_container').removeClass('d-none');
                } else {
                    $('#edit_other_degree_container').addClass('d-none');
                }
            }
        });
    });
});

function toggleOtherDegree(select, containerId) {
    const container = $('#' + containerId);
    if (select.value === "Other") {
        container.removeClass('d-none');
        container.find('input').attr('required', true);
    } else {
        container.addClass('d-none');
        container.find('input').attr('required', false);
    }
}
</script>

