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
        color: var(--text-main);
    }

    .header-section h1 span { color: var(--accent-red); }
    .header-section p { color: var(--text-muted); font-size: 14px; margin: 0; }

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
        border: 1px solid #e2e8f0; color: var(--text-muted); transition: var(--transition);
    }
    .pagination-wrapper strong { background: var(--accent-red); border-color: var(--accent-red); color: white; }
    .pagination-wrapper a:hover { background: #f8fafc; color: var(--accent-red); border-color: var(--accent-red); }

</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if($this->session->flashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
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
                                <div class="user-name"><?= ucwords($a->first_name . " " . $a->last_name) ?></div>
                                <div class="student-id"><?= $a->student_number ?></div>
                            </td>
                            <td>
                                <span class="badge-status <?= $a->status == 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                    <?= ucfirst($a->status) ?>
                                </span>
                            </td>
                            <td class="text-right">
                                <button class="btn-action" data-toggle="modal" data-target="#editModal<?= $a->id ?>" title="Edit Account">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action delete" data-toggle="modal" data-target="#deleteModal<?= $a->id ?>" title="Delete Account">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- EDIT MODAL -->
                        <div class="modal fade" id="editModal<?= $a->id ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="font-weight: 700;"><i class="fas fa-user-edit mr-2"></i> Edit Account</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form method="post" action="<?= base_url('AdminManageAccounts/update/'.$a->id) ?>">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" name="first_name" class="form-control form-input" value="<?= $a->first_name ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" name="last_name" class="form-control form-input" value="<?= $a->last_name ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Email (Immutable)</label>
                                                    <input type="email" class="form-control form-input text-muted" style="background: #f8fafc;" value="<?= $a->email ?>" readonly>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Phone Number</label>
                                                    <input type="text" name="phone" class="form-control form-input" value="<?= $a->phone ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Graduation Year</label>
                                                    <input type="number" name="graduation_year" value="<?= $a->graduation_year ?>" class="form-control form-input">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Student ID No.</label>
                                                    <input type="text" name="student_number" class="form-control form-input" value="<?= $a->student_number ?>">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Account Privilege Status</label>
                                                    <select name="status" class="form-control form-input">
                                                        <option value="active" <?= $a->status == "active" ? "selected" : "" ?>>Active - Full Access</option>
                                                        <option value="inactive" <?= $a->status == "inactive" ? "selected" : "" ?>>Inactive - Restricted</option>
                                                    </select>
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

                        <!-- DELETE MODAL -->
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

