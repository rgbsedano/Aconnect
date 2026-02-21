
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ===== SCOPED ONLY TO ACCOUNTS PAGE ===== */
.accounts-page {
    --primary-bg: #f8fafc;
    --card-bg: #ffffff;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --accent-red: #700a0a;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --border-radius: 24px;
}

.accounts-page .dashboard-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px 24px;
}

.accounts-page .header-section {
    margin-bottom: 24px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}

.accounts-page .header-section h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 4px;
    color: white;
}

.accounts-page .header-section h1 span { color: #ff6b6b; }
.accounts-page .header-section p { color: rgba(255,255,255,0.85); font-size: 14px; margin: 0; }

.accounts-page .main-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border: 1px solid #f1f5f9;
}

/* ===== TABLE (IDENTICAL TO OFFICERS) ===== */
.accounts-page .custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
}

.accounts-page .custom-table th {
    padding: 12px 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--text-muted);
}

.accounts-page .custom-table tr.data-row {
    background: white;
    transition: var(--transition);
}

.accounts-page .custom-table tr.data-row:hover {
    transform: scale(1.005);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.accounts-page .custom-table td {
    padding: 16px 20px;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
}

/* EVEN STRIPING */
.accounts-page .custom-table tbody tr.data-row:nth-child(even) {
    background: #f9fafb;
}

.accounts-page .custom-table tr.data-row:hover {
    background: #ffffff;
}

/* STICKY HEADER */
.accounts-page .table-responsive {
    max-height: 520px;
    overflow-y: auto;
}

.accounts-page .custom-table thead th {
    position: sticky;
    top: 0;
    background: #ffffff;
    z-index: 5;
    box-shadow: 0 1px 0 #f1f5f9;
}

/* SEARCH POLISH */
.accounts-page #alumniSearch {
    border-radius: 12px;
    font-size: 13px;
}

/* PAGINATION */
.accounts-page .pagination-wrapper {
    margin-top: 28px;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

.accounts-page .pagination-wrapper a,
.accounts-page .pagination-wrapper strong {
    padding: 8px 14px;
    margin: 4px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    border: 1px solid #e2e8f0;
    color: var(--accent-red);
    background: #ffffff;
    text-decoration: none;
    transition: var(--transition);
}

.accounts-page .pagination-wrapper strong {
    background: var(--accent-red);
    border-color: var(--accent-red);
    color: white;
}

.accounts-page .pagination-wrapper a:hover {
    background: #f8fafc;
    border-color: var(--accent-red);
    color: var(--accent-red);
    transform: translateY(-1px);
}

/* MODAL SPACING MATCH */
.accounts-page .modal-dialog {
    margin-top: 10vh !important;
    margin-bottom: 40px;
}

/* ===== MODAL THEME (MATCH OFFICERS) ===== */

.modal-wide {
    max-width: 900px;
}

.modal-header-red {
    background: linear-gradient(135deg, #7f1d1d, #991b1b);
    color: white;
    border: none;
    padding: 22px 26px;
}

.modal-header-red .modal-title {
    font-weight: 700;
}

.modal-footer-soft {
    background: #f8fafc;
    border: none;
    padding: 18px 24px;
}

.form-label {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 6px;
}

.form-input {
    border-radius: 12px;
    padding: 12px;
    border: 1px solid #e2e8f0;
    font-weight: 500;
}

.form-input:focus {
    border-color: #7f1d1d;
    box-shadow: 0 0 0 4px rgba(127,29,29,.08);
}

.btn-red {
    background: #7f1d1d;
    border-color: #7f1d1d;
    font-weight: 700;
    border-radius: 12px;
}

.accounts-page .modal-dialog {
    margin-top: 10vh !important;
    margin-bottom: 40px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="accounts-page">
<div class="dashboard-wrapper">

    <!-- ✅ HEADER (NOW MATCHES OFFICERS) -->
    <div class="header-section">
        <div>
            <h1>Alumni <span>Accounts</span></h1>
            <p>Manage alumni credentials and access.</p>
        </div>
    </div>

    <!-- ✅ TABLE CARD -->
    <div class="main-card">

        <div class="table-controls d-flex justify-content-between align-items-center flex-wrap mb-3">

            <!-- LEFT: search -->
            <div style="position: relative; max-width: 260px;">
                <input type="text"
                       id="alumniSearch"
                       class="form-control form-input"
                       placeholder="Search alumni..."
                       style="padding-left:36px;">
                <i class="fas fa-search"
                   style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
            </div>

            <!-- RIGHT: rows info -->
            <div class="text-muted" style="font-size:13px; font-weight:600;">
                Showing <span id="rowCount"><?= count($alumni_list ?? []) ?></span> alumni
            </div>

        </div>

        <!-- ✅ TABLE PARTIAL -->
        <div id="alumniTableContainer">
            <?php $this->load->view('admin/partials/alumni_table'); ?>
        </div>

    </div>

</div>


<!-- VIEW MODAL -->
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog modal-wide">
    <div class="modal-content">

      <div class="modal-header modal-header-red">
        <h5 class="modal-title">
          <i class="fas fa-id-card mr-2"></i>
          Alumni Profile
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body" id="viewModalContent">
        <div class="text-center py-5">
          <div class="spinner-border text-danger"></div>
        </div>
      </div>

      <div class="modal-footer modal-footer-soft">
        <button type="button" class="btn btn-light" data-dismiss="modal">
          Close
        </button>
      </div>

    </div>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editAccountModal" tabindex="-1">
  <div class="modal-dialog modal-wide">
    <div class="modal-content">

      <div class="modal-header modal-header-red">
        <h5 class="modal-title">
          <i class="fas fa-user-edit mr-2"></i>
          Edit Account
        </h5>
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
              <label class="form-label">New Password</label>
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
              <label class="form-label">Email</label>
              <input type="email" name="email" id="edit_email" class="form-control form-input" required>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" id="edit_phone" class="form-control form-input">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Gender</label>
              <select name="gender" id="edit_gender" class="form-control form-input">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>

            <div class="col-12 mb-3">
              <label class="form-label">Replace Picture</label>
              <input type="file" name="profile_image" class="form-control border-0 p-0">
            </div>

          </div>

        </div>

        <div class="modal-footer modal-footer-soft">
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger btn-red">Update</button>
        </div>
      </form>

    </div>
  </div>
</div>
</div>





<script>
$(document).ready(function () {

    let searchTimer;

    // 🚫 Prevent row click when clicking buttons/forms
    $(document).on('click', '.edit-profile, .delete-form, .delete-form button', function (e) {
        e.stopPropagation();
    });

    // ===============================
    // SEARCH (debounced)
    // ===============================
    $('#alumniSearch').on('keyup', function () {
        clearTimeout(searchTimer);

        let keyword = $(this).val().trim();

        searchTimer = setTimeout(function () {
            loadAlumni(keyword);
        }, 400);
    });

    function loadAlumni(keyword = '')
    {
        $.ajax({
            url: '<?= site_url("AdminManageAccounts/search") ?>',
            type: 'GET',
            data: { keyword: keyword },
            success: function (response) {
                $('#alumniTableContainer').html(response);
                $('#rowCount').text($('.custom-table tbody tr.data-row').length);
            }
        });
    }

    // ===============================
    // AJAX PAGINATION
    // ===============================
    $(document).on('click', '.pagination-wrapper a', function (e) {

        let url = $(this).attr('href');

        if (url && url.includes('AdminManageAccounts/search')) {
            e.preventDefault();

            let keyword = $('#alumniSearch').val();

            if (keyword) {
                url += (url.indexOf('?') > -1 ? '&' : '?') +
                       'keyword=' + encodeURIComponent(keyword);
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    $('#alumniTableContainer').html(response);
                    $('#rowCount').text($('.custom-table tbody tr.data-row').length);
                }
            });
        }
    });

    // ===============================
    // VIEW PROFILE
    // ===============================
    $(document).on('click', '.view-profile', function () {

        const id = $(this).data('id');

        if (!id) return;

        $('#viewModal').modal('show');

        $('#viewModalContent').html(
            '<div class="text-center py-5"><div class="spinner-border text-danger"></div></div>'
        );

        $.ajax({
            url: '<?= base_url("AdminManageAccounts/details") ?>',
            type: 'POST',
            data: { id: id },
            success: function (response) {
                $('#viewModalContent').html(response);
            }
        });
    });

    // ===============================
    // EDIT PROFILE
    // ===============================
    $(document).on('click', '.edit-profile', function () {

        const id = $(this).data('id');

        if (!id) return;

        $('#editAccountModal').modal('show');

        $.ajax({
            url: '<?= base_url("AdminManageAccounts/get_edit_data") ?>',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function (data) {

                if (!data) return;

                $('#editForm').attr(
                    'action',
                    '<?= base_url("AdminManageAccounts/update/") ?>' + data.id
                );

                $('#edit_first_name').val(data.first_name);
                $('#edit_last_name').val(data.last_name);
                $('#edit_email').val(data.email);
                $('#edit_phone').val(data.phone);
                $('#edit_gender').val(data.gender);
                $('#edit_student_number').val(data.student_number);
            }
        });
    });

});
</script>

<?php if ($this->session->flashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

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