<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Alumni Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #700A0A;
            --accent-gold: #D4AF37;
            --sidebar-width: 260px;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 8px 30px rgba(0,0,0,0.08);
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #334155;
            overflow-x: hidden;
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }
        .modal {
            z-index: 1050 !important;
        }

        .admin-wrapper {
            padding: 40px 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .alumni-card {
            background: var(--glass-bg);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow-md);
            padding: 30px;
        }

        .page-guide {
            background: #fff9f9;
            border-left: 4px solid var(--primary-color);
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 4px 12px 12px 4px;
            font-size: 0.9rem;
        }

        .main-header {
            color: var(--primary-color);
            font-weight: 800;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-box-wrapper {
            background: #fff;
            border-radius: 12px;
            padding: 10px;
            box-shadow: var(--shadow-sm);
            border: 1px solid #e2e8f0;
        }

        .search-input-clean {
            border: none !important;
            box-shadow: none !important;
            font-size: 0.95rem;
        }

        .btn-modern-search {
            background: var(--primary-color);
            color: white;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
        }

        .btn-modern-search:hover {
            background: #5A0808;
            color: #fff;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: visible;
        }

        .table-modern {
            border-collapse: separate;
            border-spacing: 0 8px;
            background: transparent;
        }

        .table-modern thead th {
            background: transparent !important;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            border: none;
            padding: 15px;
        }

        .table-modern tbody tr {
            background: #fff;
            box-shadow: var(--shadow-sm);
        }

        .table-modern td {
            padding: 18px 15px;
            border: none;
            vertical-align: middle;
        }

        .table-modern td:first-child { border-radius: 12px 0 0 12px; }
        .table-modern td:last-child { border-radius: 0 12px 12px 0; }

        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            background: #ecfdf5;
            color: #059669;
        }

        .pagination .page-link {
            color: var(--primary-color);
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }

        .modal-modern .modal-content {
            border: none;
            border-radius: 24px;
            overflow: hidden;
        }

        .modal-modern .modal-header {
            background: var(--primary-color);
            color: #fff;
            padding: 25px;
            border: none;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 10px;
        }

        .info-item {
            padding: 12px;
            background: #f8fafc;
            border-radius: 12px;
        }

        .info-label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 4px;
            font-weight: 700;
        }

        .info-value {
            font-weight: 600;
            color: #1e293b;
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <div class="alumni-card">
        <div class="main-header mb-4">
            <div>
                <h2 class="mb-0"><i class="fas fa-id-card-alt mr-3"></i>Alumni Directory</h2>
                <p class="text-muted mt-2 mb-0">Manage and oversee all registered alumni records</p>
            </div>
            <button class="btn btn-outline-danger btn-sm" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i> Refresh Data
            </button>
        </div>

        <div class="page-guide">
            <i class="fas fa-info-circle mr-2 text-danger"></i>
            <strong>Admin Guide:</strong> Click on any row to view full profile details. Use the universal search bar to filter by degree, year, or student ID.
        </div>

        <form method="get" id="searchForm" class="mb-5">
            <div class="search-box-wrapper d-flex align-items-center">
                <i class="fas fa-search ml-3 text-muted"></i>
                <input type="text" name="search" id="searchInput" 
                       class="form-control search-input-clean flex-grow-1" 
                       placeholder="Global search: Enter name, ID, or Batch..." 
                       value="<?= $this->input->get('search') ?>">
                
                <?php if ($this->input->get('search')): ?>
                    <button type="button" id="clearSearch" class="btn text-muted mx-2">
                        <i class="fas fa-times-circle"></i>
                    </button>
                <?php endif; ?>
                
                <button type="submit" class="btn btn-modern-search ml-2">
                    Generate List
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag mr-1"></i> ID</th>
                        <th>Name & Contact</th>
                        <th>Degree Info</th>
                        <th>Batch</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alumni_list)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 80px; opacity: 0.3;">
                                <p class="text-muted mt-3">No matching records found in database.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($alumni_list as $alumni): ?>
                            <tr>
                                <td class="font-weight-bold text-danger"><?= $alumni['student_number'] ?></td>
                                <td>
                                    <div class="font-weight-bold"><?= ucwords(htmlspecialchars($alumni['first_name'] . ' ' . $alumni['last_name'])) ?></div>
                                    <div class="small text-muted"><?= htmlspecialchars($alumni['email']) ?></div>
                                </td>
                                <td>
                                    <div class="small font-weight-bold"><?= ucwords(htmlspecialchars($alumni['degree'])) ?></div>
                                    <div class="small text-muted"><?= htmlspecialchars($alumni['school']) ?></div>
                                </td>
                                <td><span class="badge badge-light p-2"><?= $alumni['graduation_year'] ?></span></td>
                                <td><span class="badge-status">Active</span></td>
                                <td class="text-right">
                                    <button class="btn btn-sm btn-light btn-view-custom" data-toggle="modal" data-target="#viewModal<?= $alumni['id'] ?>">
                                        <i class="fas fa-external-link-alt text-danger"></i> Profile
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <?= $pagination ?>
            </nav>
        </div>
    </div>
</div>

<?php if (!empty($alumni_list)): ?>
    <?php foreach ($alumni_list as $alumni): ?>
        <div class="modal fade modal-modern" id="viewModal<?= $alumni['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white p-3 mr-3">
                                <i class="fas fa-user-tie text-danger fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="modal-title mb-0"><?= ucwords(htmlspecialchars($alumni['first_name'] . ' ' . $alumni['last_name'])) ?></h4>
                                <small class="text-white-50">Alumni Member since <?= date('Y') ?></small>
                            </div>
                        </div>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        <h6 class="text-uppercase font-weight-bold text-danger mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">Academic History</h6>
                        <div class="info-grid mb-4">
                            <div class="info-item"><span class="info-label">Degree</span><span class="info-value"><?= $alumni['degree'] ?></span></div>
                            <div class="info-item"><span class="info-label">Student ID</span><span class="info-value"><?= $alumni['student_number'] ?></span></div>
                            <div class="info-item"><span class="info-label">Grad Year</span><span class="info-value"><?= $alumni['graduation_year'] ?></span></div>
                            <div class="info-item"><span class="info-label">School</span><span class="info-value"><?= $alumni['school'] ?></span></div>
                        </div>

                        <h6 class="text-uppercase font-weight-bold text-danger mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">Professional Background</h6>
                        <div class="info-grid">
                            <div class="info-item"><span class="info-label">Current Role</span><span class="info-value"><?= $alumni['current_job'] ?: 'Unspecified' ?></span></div>
                            <div class="info-item"><span class="info-label">Company</span><span class="info-value"><?= $alumni['current_job_organization'] ?: 'N/A' ?></span></div>
                            <div class="info-item"><span class="info-label">Phone</span><span class="info-value"><?= $alumni['phone'] ?></span></div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close Overlay</button>
                        <button type="button" class="btn btn-danger rounded-pill px-4">Generate Report</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#clearSearch').on('click', function() {
            $('#searchInput').val('');
            window.location.href = window.location.pathname;
        });

        $(document).on('click', '.table-modern tbody tr', function(e) {
            if ($(e.target).closest('.btn-view-custom').length) return;
            $(this).find('.btn-view-custom').click();
        });
    });
</script>
</body>
</html>