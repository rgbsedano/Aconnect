<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #a12124;
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

    .main-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid #f1f5f9;
    }

    /* Search Box */
    .search-container {
        background: #f1f5f9;
        border-radius: 16px;
        padding: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: 500px;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .search-container:focus-within {
        background: white;
        border-color: var(--accent-red);
        box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.1);
    }

    .search-input {
        background: transparent;
        border: none;
        padding: 8px 12px;
        font-size: 14px;
        font-weight: 500;
        outline: none;
        flex: 1;
    }

    .btn-search {
        background: var(--accent-red);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition);
    }

    .btn-search:hover { transform: scale(1.02); opacity: 0.9; }

    /* Table Styling */
    .table-container { margin-top: 25px; overflow-x: auto; }
    
    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 12px; }
    .custom-table th { 
        padding: 12px 20px; color: var(--text-muted); font-weight: 700; font-size: 12px; 
        text-transform: uppercase; letter-spacing: 1px; border: none;
    }
    
    .custom-table tr.data-row { 
        background: white; transition: var(--transition); box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    
    .custom-table tr.data-row:hover { 
        transform: scale(1.005); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        background: #fffcfc;
    }

    .custom-table td { 
        padding: 20px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9;
        font-size: 14px; color: var(--text-main);
    }

    .custom-table td:first-child { border-left: 1px solid #f1f5f9; border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .custom-table td:last-child { border-right: 1px solid #f1f5f9; border-top-right-radius: 16px; border-bottom-right-radius: 16px; }

    .alumni-avatar {
        width: 45px; height: 45px; border-radius: 12px; object-fit: cover; background: #eee;
    }

    .student-id { 
        font-family: monospace; font-weight: 700; color: var(--accent-red); background: rgba(112, 10, 10, 0.05);
        padding: 4px 8px; border-radius: 6px;
    }

    .badge-active { background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 11px; }

    .btn-action {
        width: 36px; height: 36px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center;
        background: #f8fafc; color: var(--text-muted); transition: var(--transition); border: 1px solid #e2e8f0;
    }
    .btn-action:hover { background: var(--accent-red); color: white; border-color: var(--accent-red); transform: translateY(-2px); }

    /* Modal Styling */
    .modal-content { border-radius: 24px; border: none; overflow: hidden; }
    .modal-header { background: var(--accent-red); color: white; padding: 25px; border: none; }
    .modal-body { padding: 30px; }
    
    .info-label { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 4px; }
    .info-value { font-size: 16px; font-weight: 600; color: var(--text-main); }
    .profile-section { border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 15px; }

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

    .pagination-wrapper { margin-top: 30px; display: flex; justify-content: center; }
    .pagination-wrapper a, .pagination-wrapper strong {
        padding: 8px 16px; margin: 0 4px; border-radius: 10px; font-weight: 600; font-size: 14px;
        border: 1px solid #e2e8f0; color: var(--accent-red); transition: var(--transition);
    }
    .pagination-wrapper strong { background: var(--accent-red); border-color: var(--accent-red); color: white; }
    .pagination-wrapper a:hover { background: #f8fafc; color: var(--accent-red); border-color: var(--accent-red); }

    /* Override Bootstrap pagination active color */
    .pagination .page-item.active .page-link {
        background-color: #a12124;
        border-color: #a12124;
        color: #ffffff;
    }
    .pagination .page-link {
        color: #a12124;
    }
    .pagination .page-item:not(.active) .page-link:hover {
        background-color: #f8fafc;
        border-color: #a12124;
        color: #a12124;
    }
</style>

<div class="dashboard-wrapper">
    <div class="header-section">
        <div>
            <h1>Alumni <span>Records</span></h1>
            <p>Maintain and verify alumni records and professional profiles.</p>
        </div>
        <div class="actions">
            <button class="btn btn-outline-secondary" onclick="location.reload()" style="border-radius: 12px; font-size: 14px; font-weight: 600;">
                <i class="fas fa-sync-alt mr-2"></i> Sync Database
            </button>
        </div>
    </div>

    <div class="main-card">
        <form method="get" id="searchForm">
            <div class="search-container">
                <i class="fas fa-search ml-3 text-muted"></i>
                <input type="text" name="search" id="searchInput" class="search-input" 
                       placeholder="Find by name, student ID, or batch..." 
                       value="<?= $this->input->get('search') ?>">
                
                <?php if ($this->input->get('search')): ?>
                    <a href="<?= site_url('AdminAlumni') ?>" class="btn text-muted p-0 mr-2"><i class="fas fa-times-circle"></i></a>
                <?php endif; ?>
                
                <button type="submit" class="btn-search">Search</button>
            </div>
        </form>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Alumni</th>
                        <th>Student ID</th>
                        <th>Academic Detail</th>
                        <th>Batch</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alumni_list)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div style="opacity: 0.3; margin-bottom: 15px;"><i class="fas fa-user-slash fa-4x"></i></div>
                                <p class="text-muted">No alumni records found matching your criteria.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($alumni_list as $alumni): ?>
                            <tr class="data-row">
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <?php 
                                            $img = (!empty($alumni['profile_image'])) 
                                                ? base_url('assets/uploads/alumni/' . $alumni['profile_image']) 
                                                : base_url('assets/images/' . (strtolower($alumni['gender'] ?? 'male') === 'female' ? 'person-female.png' : 'person-male.png'));
                                        ?>
                                        <img src="<?= $img ?>" class="alumni-avatar mr-3">
                                        <div>
                                            <div style="font-weight: 700;"><?= ucwords(htmlspecialchars($alumni['first_name'] . ' ' . $alumni['last_name'])) ?></div>
                                            <div style="font-size: 12px; color: var(--text-muted);"><?= htmlspecialchars($alumni['email']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="student-id"><?= $alumni['student_number'] ?></span></td>
                                <td>
                                    <div style="font-weight: 600; font-size: 13px;"><?= ucwords(htmlspecialchars($alumni['degree'])) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($alumni['school']) ?></div>
                                </td>
                                <td><span style="font-weight: 600; color: var(--text-muted);"><?= $alumni['graduation_year'] ?></span></td>
                                <td><span class="badge-active">Verified</span></td>
                                <td class="text-right">
                                    <button class="btn-action" data-toggle="modal" data-target="#viewModal<?= $alumni['id'] ?>" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit-alumni" data-id="<?= $alumni['id'] ?>" title="Edit Profile">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            <?= $pagination ?>
        </div>
    </div>
</div>

<?php if (!empty($alumni_list)): ?>
    <?php foreach ($alumni_list as $alumni): ?>
        <div class="modal fade" id="viewModal<?= $alumni['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-wide" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-circle fa-3x mr-3"></i>
                            <div>
                                <h4 class="modal-title mb-0" style="font-weight: 700;"><?= ucwords(htmlspecialchars($alumni['first_name'] . ' ' . $alumni['last_name'])) ?></h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Member Profile Details</p>
                            </div>
                        </div>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 profile-section">
                                <span class="info-label">Degree</span>
                                <span class="info-value"><?= $alumni['degree'] ?></span>
                            </div>
                            <div class="col-md-6 profile-section">
                                <span class="info-label">Student ID</span>
                                <span class="info-value"><?= $alumni['student_number'] ?></span>
                            </div>
                            <div class="col-md-6 profile-section">
                                <span class="info-label">Grad Year</span>
                                <span class="info-value"><?= $alumni['graduation_year'] ?></span>
                            </div>
                            <div class="col-md-6 profile-section">
                                <span class="info-label">School</span>
                                <span class="info-value"><?= $alumni['school'] ?></span>
                            </div>
                            <div class="col-md-6 profile-section">
                                <span class="info-label">Current Role</span>
                                <span class="info-value"><?= !empty($alumni['current_job']) ? $alumni['current_job'] : 'None Listed' ?></span>
                            </div>
                            <div class="col-md-6 profile-section">
                                <span class="info-label">Organization</span>
                                <span class="info-value"><?= !empty($alumni['current_job_organization']) ? $alumni['current_job_organization'] : 'N/A' ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #f1f5f9;">
                        <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 12px; font-weight: 600;">Close</button>
                        <button type="button" class="btn btn-danger" style="background: var(--accent-red); border-radius: 12px; font-weight: 600;">Download Profile</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-wide" role="document">
        <div class="modal-content">
            <form action="<?= site_url('AdminAlumni/update') ?>" method="post">
                <input type="hidden" name="id" id="edit_alumni_id">
                <div class="modal-header" style="background: #1e293b;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-edit fa-3x mr-3"></i>
                        <div>
                            <h4 class="modal-title mb-0" style="font-weight: 700;">Edit Alumni Info</h4>
                            <p class="text-white-50 mb-0" style="font-size: 13px;">Update profile details</p>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="info-label">First Name</label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control" required style="border-radius: 12px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="info-label">Last Name</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control" required style="border-radius: 12px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="info-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required style="border-radius: 12px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="info-label">Phone</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control" style="border-radius: 12px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="info-label">Student ID</label>
                            <input type="text" name="student_number" id="edit_student_number" class="form-control" required style="border-radius: 12px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="info-label">Degree</label>
                            <input type="text" name="degree" id="edit_degree" class="form-control" required style="border-radius: 12px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="info-label">Graduation Year</label>
                            <input type="number" name="graduation_year" id="edit_graduation_year" class="form-control" required style="border-radius: 12px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="info-label">School</label>
                            <input type="text" name="school" id="edit_school" class="form-control" style="border-radius: 12px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #f1f5f9;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 12px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #1e293b; border: none; border-radius: 12px; font-weight: 600;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    <?php if($this->session->flashdata('success')): ?>
        Toast.fire({
            icon: 'success',
            title: '<?= $this->session->flashdata('success') ?>'
        });
    <?php endif; ?>

    $('.btn-edit-alumni').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('AdminAlumni/get_edit_data') ?>',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(data) {
                $('#edit_alumni_id').val(data.id);
                $('#edit_first_name').val(data.first_name);
                $('#edit_last_name').val(data.last_name);
                $('#edit_email').val(data.email);
                $('#edit_phone').val(data.phone);
                $('#edit_student_number').val(data.student_number);
                $('#edit_degree').val(data.degree);
                $('#edit_graduation_year').val(data.graduation_year);
                $('#edit_school').val(data.school);
                $('#editModal').modal('show');
            }
        });
    });
});
</script>
