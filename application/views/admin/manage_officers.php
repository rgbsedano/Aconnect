<style>


/* ===== SEARCH POLISH ===== */
.accounts-page #alumniSearch {
    border-radius: 12px;
    font-size: 13px;
}
/* ===== SCOPED ONLY TO OFFICERS PAGE ===== */
.officers-page {
    --primary-bg: #f8fafc;
    --card-bg: #ffffff;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --accent-red: #a12124;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --border-radius: 24px;
}

.officers-page .dashboard-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px 24px;
}

.officers-page .header-section {
    margin-bottom: 24px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}

.officers-page .header-section h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 4px;
    color: white;
}

.officers-page .header-section h1 span { color: #ff6b6b; }
.officers-page .header-section p { color: rgba(255, 255, 255, 0.85); font-size: 14px; margin: 0; }

.officers-page .main-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
}

/* ===== TABLE ===== */
.officers-page .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
.officers-page .custom-table th {
    padding: 12px 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--text-muted);
}

.officers-page .custom-table tr.data-row {
    background: white;
    transition: var(--transition);
}

.officers-page .custom-table tr.data-row:hover {
    transform: scale(1.005);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.officers-page .custom-table td {
    padding: 16px 20px;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
}

.officers-page .user-name {
    font-weight: 700;
    color: var(--text-main);
    font-size: 15px;
}

.officers-page .student-id {
    font-size: 12px;
    font-weight: 600;
    color: var(--accent-red);
    background: #fef2f2;
    padding: 2px 8px;
    border-radius: 6px;
    display: inline-block;
    margin-top: 2px;
}

.officers-page .badge-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.officers-page .badge-active { background: #dcfce7; color: #166534; }
.officers-page .badge-inactive { background: #f1f5f9; color: var(--text-muted); }

.officers-page .btn-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    color: var(--text-muted);
    border: 1px solid #e2e8f0;
    transition: var(--transition);
    margin-left: 5px;
}

.officers-page .btn-action:hover {
    background: var(--accent-red);
    color: white;
    border-color: var(--accent-red);
    transform: translateY(-2px);
}

.officers-page .btn-action.delete:hover {
    background: #ef4444;
    border-color: #ef4444;
}

/* ===== MODAL FIX ===== */
.officers-page .modal-dialog {
    margin-top: 10vh !important;
    margin-bottom: 40px;
}

.officers-page .modal-content {
    border-radius: 24px;
    border: none;
    overflow: hidden;
}

.officers-page .modal-header {
    background: var(--accent-red);
    color: white;
    padding: 22px 26px;
    border: none;
}

.officers-page .modal-body { padding: 26px; }
.officers-page .modal-footer {
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
    padding: 18px 24px;
}

/* ===== PAGINATION STYLE ===== */
.officers-page .pagination-wrapper {
    margin-top: 28px;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

.officers-page .pagination-wrapper a,
.officers-page .pagination-wrapper strong {
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

/* current page */
.officers-page .pagination-wrapper strong {
    background: var(--accent-red);
    border-color: var(--accent-red);
    color: white;
}

/* hover */
.officers-page .pagination-wrapper a:hover {
    background: #f8fafc;
    border-color: var(--accent-red);
    color: var(--accent-red);
    transform: translateY(-1px);
}

/* ===== EVEN ROW STRIPING ===== */
.officers-page .custom-table tbody tr.data-row:nth-child(even) {
    background: #f9fafb;
}

/* keep hover stronger than stripe */
.officers-page .custom-table tr.data-row:hover {
    background: #ffffff;
}

/* sticky header */
.officers-page .table-responsive {
    max-height: 520px;
    overflow-y: auto;
}

.officers-page .custom-table thead th {
    position: sticky;
    top: 0;
    background: #ffffff;
    z-index: 5;
    box-shadow: 0 1px 0 #f1f5f9;
}

/* smoother hover */
.officers-page .custom-table tr.data-row {
    transition: all 0.18s ease;
}

/* search box polish */
.officers-page #officerSearch {
    border-radius: 12px;
    font-size: 13px;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="officers-page">
<div class="dashboard-wrapper">

    <!-- HEADER -->
    <div class="header-section">
        <div>
            <h1>Alumni <span>Officers</span></h1>
            <p>Manage alumni officer information and visibility.</p>
        </div>

        <button class="btn btn-danger"
                style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 20px;"
                data-toggle="modal"
                data-target="#officerModal"
                onclick="openAddOfficer()">
            <i class="fas fa-plus mr-1"></i> Add Officer
        </button>
    </div>

    <!-- TABLE -->
    <div class="main-card">
        <div class="table-controls d-flex justify-content-between align-items-center flex-wrap mb-3">

    <!-- LEFT: search -->
    <div style="position: relative; max-width: 260px;">
        <input type="text"
               id="officerSearch"
               class="form-control form-input"
               placeholder="Search officers..."
               style="padding-left:36px;">
        <i class="fas fa-search"
           style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
    </div>

    <!-- RIGHT: rows info -->
    <div class="text-muted" style="font-size:13px; font-weight:600;">
        Showing <span id="rowCount"><?= count($officers) ?></span> officers
    </div>

</div>
<div id="officersTableContainer">
    <?php $this->load->view('admin/partials/officers_table'); ?>
        
</div>

        </div>
    </div>

    <!-- MODAL (IMPORTANT: INSIDE officers-page) -->
    <div class="modal fade" id="officerModal" tabindex="-1">
        <div class="modal-dialog modal-adaptive">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><span id="modalTitle">Add Officer</span></h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <form id="officerForm" method="post" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" id="off_full_name" class="form-control form-input" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="off_gender" class="form-control form-input">
                                <option value="">-- Select Gender --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Position</label>
                            <select name="position" id="off_position" class="form-control form-input" required>
                                <option value="">-- Select Position --</option>
                                <option>President</option>
                                <option>Vice President</option>
                                <option>Secretary</option>
                                <option>Treasurer</option>
                                <option>Auditor</option>
                                <option>PRO</option>
                                <option>Board Member</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="off_email" class="form-control form-input">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="off_status" class="form-control form-input">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" id="off_bio" class="form-control form-input" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control border-0 p-0" style="font-size:12px;">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" style="background: var(--accent-red);">Save Officer</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- VIEW OFFICER MODAL -->
<div class="modal fade" id="viewOfficerModal" tabindex="-1">
    <div class="modal-dialog modal-adaptive">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-tie mr-2"></i>
                    Officer Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body text-center">

                <div style="display:flex; justify-content:center; margin-bottom:12px;">
                    <img id="view_photo"
                        src=""
                        style="width:90px;height:90px;border-radius:50%;object-fit:cover;">
                </div>

                <h4 id="view_name" style="font-weight:700;"></h4>
                <div id="view_position" style="color:var(--accent-red);font-weight:600;margin-bottom:10px;"></div>
                
                <p id="view_email" style="font-size:14px;color:#64748b;"></p>

                <hr>

                <p id="view_bio" style="font-size:14px;"></p>

            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

</div>
</div>



<script>
function openAddOfficer() {
    $('#modalTitle').text('Add Officer');
    $('#officerForm')[0].reset();
    $('#officerForm').attr('action', '<?= site_url("AdminOfficers/store") ?>');
}

function openEditOfficer(id) {
    $('#modalTitle').text('Edit Officer');
    $('#officerModal').modal('show');

    $.ajax({
        url: '<?= site_url("AdminOfficers/get_officer") ?>',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(o) {
            console.log(o); // 🔥 debug (remove later)

            $('#officerForm').attr(
                'action',
                '<?= site_url("AdminOfficers/update/") ?>' + o.id
            );

            $('#off_full_name').val(o.full_name);
            $('#off_gender').val(o.gender); 
            $('#off_position').val(o.position);
            $('#off_email').val(o.email);
            $('#off_status').val(o.status);
            $('#off_bio').val(o.bio);
        },
        error: function() {
            alert('Failed to fetch officer data.');
        }
    });
}

$(document).on('click', '.officer-row', function () {
    const id = $(this).data('id');

    $.ajax({
        url: '<?= site_url("AdminOfficers/get_officer") ?>', 
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(o) {

            let photoPath = '';

            if (o.photo) {
                photoPath = '<?= base_url() ?>' + o.photo;
            } else {
                if (o.gender === 'Male') {
                    photoPath = '<?= base_url("assets/images/person-male.png") ?>';
                } else if (o.gender === 'Female') {
                    photoPath = '<?= base_url("assets/images/person-female.png") ?>';
                } else {
                    photoPath = '<?= base_url("assets/images/person-default.png") ?>';
                }
            }

            $('#view_photo').attr('src', photoPath);

            $('#view_name').text(o.full_name);
            $('#view_position').text(o.position);
            $('#view_gender').text(o.gender ?? '');
            $('#view_email').text(o.email ?? '');
            $('#view_bio').text(o.bio ?? '');
            $('#viewOfficerModal').modal('show');
        }
    });
});


let searchTimer;

$('#officerSearch').on('keyup', function () {
    clearTimeout(searchTimer);

    let keyword = $(this).val().trim();



    searchTimer = setTimeout(function () {
        loadOfficers(keyword);
    }, 400);
});

function loadOfficers(keyword = '')
{
    $.ajax({
        url: '<?= site_url("AdminOfficers/search") ?>',
        type: 'GET',
        data: { keyword: keyword },
        success: function (response) {
            $('#officersTableContainer').html(response);

            // ✅ update visible row count
            $('#rowCount').text($('.custom-table tbody tr.data-row').length);
        },
        error: function () {
            console.error('Search AJAX failed');
        }
    });
}

// pagination click (AJAX)

$(document).on('click', '.pagination-wrapper a', function (e) {

    let url = $(this).attr('href');

    
    if (url.includes('AdminOfficers/search')) {
        e.preventDefault();

        let keyword = $('#officerSearch').val();

        if (keyword) {
            if (url.indexOf('?') > -1) {
                url += '&keyword=' + encodeURIComponent(keyword);
            } else {
                url += '?keyword=' + encodeURIComponent(keyword);
            }
        }

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                $('#officersTableContainer').html(response);
                $('#rowCount').text($('.custom-table tbody tr.data-row').length);
            }
        });
    }

});

</script>

<?php if (
    $this->session->flashdata('success') &&
    $this->session->flashdata('success_source') === 'officers'
): ?>
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

<?php if (
    $this->session->flashdata('error') &&
    $this->session->flashdata('error_source') === 'officers'
): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true
    });

    Toast.fire({
        icon: 'error',
        title: '<?= $this->session->flashdata('error') ?>'
    });

});
</script>
<?php endif; ?>