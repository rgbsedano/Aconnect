<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni List | Enhanced</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #700A0A; /* Deep Red/Maroon */
            --primary-light: #A83A3A; 
            --secondary-bg: #F8F9FA; /* Light background */
            --light-bg: #FFFFFF;
            --text-dark: #212529;
            --text-muted: #6C757D;
        }

        body {
            background-color: var(--secondary-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Main Container Styling */
        .alumni-container {
            padding: 30px;
            background: var(--light-bg);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .main-header {
            color: var(--primary-color);
            font-weight: 700;
            border-bottom: 2px solid #E9ECEF;
            padding-bottom: 15px;
            margin-bottom: 25px !important;
        }

        /* Search Form Styling */
        #searchInput {
            border-radius: 8px 0 0 8px;
            height: 45px;
        }
        .btn-search {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color);
            transition: background-color 0.3s;
            border-radius: 0 8px 8px 0;
            height: 45px;
            font-weight: 600;
        }
        .btn-search:hover {
            background-color: #5A0808 !important;
            border-color: #5A0808;
        }
        #clearSearch {
            color: var(--text-dark);
            border: none;
            background: transparent !important;
            opacity: 0.7;
            font-size: 1.2rem;
        }

        /* Table Styling */
        .table-bordered, .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }
        .table thead {
            background-color: var(--primary-color) !important;
            color: #fff;
        }
        .table thead th {
            border-color: #5A0808; /* Darker border for header */
            padding: 12px 15px;
            font-weight: 600;
            vertical-align: middle;
        }
        .table tbody tr {
            transition: background-color 0.2s;
        }
        .table tbody tr:nth-of-type(even) {
            background-color: #FDFDFD; /* Slightly off-white for striping */
        }
        .table tbody tr:hover {
            background-color: #E9ECEF; /* Light hover background */
            cursor: pointer;
        }
        .table td {
            vertical-align: middle;
        }

        /* Action Button */
        .btn-view-custom {
            background: var(--primary-color) !important;
            border-color: var(--primary-color);
            color: white;
            font-weight: 500;
            border-radius: 6px;
        }
        .btn-view-custom:hover {
            background: #5A0808 !important;
            border-color: #5A0808;
        }

        /* Modal Styling */
        .modal-header-custom {
            background-color: var(--primary-color) !important;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .modal-title-icon {
            margin-right: 10px;
        }
        .modal-body strong {
            color: var(--text-dark);
            font-weight: 600;
        }
        .modal-section-header {
            color: var(--primary-color);
            font-weight: 600;
            border-bottom: 1px dashed #E9ECEF;
            padding-bottom: 5px;
            margin-top: 15px;
            margin-bottom: 15px !important;
            font-size: 1.15rem;
        }
        .data-icon {
            color: var(--primary-light);
            width: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container alumni-container">
    <h2 class="main-header"><i class="fas fa-users-cog mr-2"></i> Alumni list</h2>
    
    <form method="get" class="mb-5" id="searchForm">
        <div class="row align-items-center">
            <div class="col-md-10 position-relative">
                <input type="text" name="search" id="searchInput" class="form-control pr-5" placeholder="Search by name, alumni number, email, or degree..." value="<?= $this->input->get('search') ?>">
                <?php if ($this->input->get('search')): ?>
                    <button type="button" id="clearSearch" class="btn btn-sm btn-light position-absolute" style="right: 50px; top: 50%; transform: translateY(-50%); ">
                        &times;
                    </button>
                <?php endif; ?>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn text-white btn-block btn-search"><i class="fas fa-search mr-1"></i> Search</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Alumni No.</th>
                    <th>Student No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Grad Year</th>
                    <th>Degree</th>
                    <th>Action</th>
                </tr>
            </thead> 
            <tbody>
                <?php if (empty($alumni_list)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-info-circle mr-1 text-muted"></i> No alumni records found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($alumni_list as $alumni): ?>
                        <tr>
                            <td><?= htmlspecialchars($alumni['alumni_number']) ?></td>
                            <td><?= htmlspecialchars($alumni['student_number']) ?></td>
                            <td><?= ucwords(htmlspecialchars($alumni['first_name'] . ' ' . $alumni['last_name'])) ?></td>
                            <td><?= htmlspecialchars($alumni['email']) ?></td>
                            <td><?= htmlspecialchars($alumni['phone']) ?></td>
                            <td><?= htmlspecialchars($alumni['graduation_year']) ?></td>
                            <td><?= ucwords(htmlspecialchars($alumni['degree'])) ?></td>
                            <td>
                                <button class="btn btn-sm btn-view-custom" data-toggle="modal" data-target="#viewModal<?= $alumni['id'] ?>">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="viewModal<?= $alumni['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?= $alumni['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header modal-header-custom">
                                        <h5 class="modal-title" id="viewModalLabel<?= $alumni['id'] ?>">
                                            <i class="fas fa-id-badge modal-title-icon"></i> Alumni Profile: <?= ucwords(htmlspecialchars($alumni['first_name'] . ' ' . $alumni['last_name'])) ?>
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            
                                            <h5 class="modal-section-header"><i class="fas fa-user-circle mr-2"></i> Personal & Registration</h5>
                                            <div class="row">
                                                <div class="col-md-6 mb-2"><i class="fas fa-hashtag data-icon"></i> <strong>Alumni No.:</strong> <?= htmlspecialchars($alumni['alumni_number']) ?></div>
                                                <div class="col-md-6 mb-2"><i class="fas fa-id-card data-icon"></i> <strong>Student No.:</strong> <?= htmlspecialchars($alumni['student_number']) ?></div>
                                                <div class="col-md-6 mb-2"><i class="fas fa-user-tag data-icon"></i> <strong>Full Name:</strong> <?= ucwords(htmlspecialchars($alumni['first_name'] . ' ' . $alumni['last_name'])) ?></div>
                                                <div class="col-md-6 mb-2"><i class="fas fa-check-circle data-icon"></i> <strong>Status:</strong> <?= htmlspecialchars($alumni['status']) ?></div>
                                            </div>

                                            <h5 class="modal-section-header"><i class="fas fa-phone-alt mr-2"></i> Contact Information</h5>
                                            <div class="row">
                                                <div class="col-md-6 mb-2"><i class="fas fa-envelope data-icon"></i> <strong>Primary Email:</strong> <a href="mailto:<?= htmlspecialchars($alumni['email']) ?>"><?= htmlspecialchars($alumni['email']) ?></a></div>
                                                <div class="col-md-6 mb-2"><i class="far fa-envelope data-icon"></i> <strong>Alternative Email:</strong> <?= htmlspecialchars($alumni['alternative_email']) ?: 'N/A' ?></div>
                                                <div class="col-md-6 mb-2"><i class="fas fa-mobile-alt data-icon"></i> <strong>Primary Phone:</strong> <?= htmlspecialchars($alumni['phone']) ?></div>
                                                <div class="col-md-6 mb-2"><i class="fas fa-phone-square-alt data-icon"></i> <strong>Alternative Phone:</strong> <?= htmlspecialchars($alumni['alternative_phone']) ?: 'N/A' ?></div>
                                            </div>

                                            <h5 class="modal-section-header"><i class="fas fa-graduation-cap mr-2"></i> Educational Background</h5>
                                            <div class="row">
                                                <div class="col-md-6 mb-2"><i class="far fa-calendar-alt data-icon"></i> <strong>Graduation Year:</strong> <?= htmlspecialchars($alumni['graduation_year']) ?></div>
                                                <div class="col-md-6 mb-2"><i class="fas fa-book data-icon"></i> <strong>Degree:</strong> <?= ucwords(htmlspecialchars($alumni['degree'])) ?></div>
                                                <div class="col-md-12 mb-2"><i class="fas fa-university data-icon"></i> <strong>School/College:</strong> <?= htmlspecialchars($alumni['school']) ?></div>
                                            </div>

                                            <h5 class="modal-section-header"><i class="fas fa-briefcase mr-2"></i> Current Employment</h5>
                                            <div class="row">
                                                <div class="col-md-6 mb-2"><i class="fas fa-user-tie data-icon"></i> <strong>Job Title:</strong> <?= ucwords(htmlspecialchars($alumni['current_job']) ?: 'N/A') ?></div>
                                                <div class="col-md-6 mb-2"><i class="fas fa-building data-icon"></i> <strong>Organization:</strong> <?= ucwords(htmlspecialchars($alumni['current_job_organization']) ?: 'N/A') ?></div>
                                                <div class="col-md-6 mb-2"><i class="far fa-clock data-icon"></i> <strong>Length:</strong> <?= htmlspecialchars($alumni['current_job_length']) ?: 'N/A' ?></div>
                                            </div>

                                            <h5 class="modal-section-header"><i class="fas fa-lightbulb mr-2"></i> Skills & Capabilities</h5>
                                            <div class="row">
                                                <div class="col-md-12 mb-2"><i class="fas fa-comments data-icon"></i> <strong>Soft Skills:</strong> <?= ucwords(htmlspecialchars($alumni['soft_skills']) ?: 'N/A') ?></div>
                                                <div class="col-md-12 mb-2"><i class="fas fa-code data-icon"></i> <strong>Technical Skills:</strong> <?= ucwords(htmlspecialchars($alumni['technical_skills']) ?: 'N/A') ?></div>
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
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        <?= $pagination ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.getElementById('clearSearch')?.addEventListener('click', function () {
        document.getElementById('searchInput').value = '';
        // Redirect to the base URL to clear search results completely
        window.location.href = window.location.pathname; 
    });

    // Functionality to open the modal by clicking anywhere on the table row
    $(document).ready(function() {
        $('.table tbody tr').on('click', function() {
            // Find the view button within the clicked row and trigger its click event
            $(this).find('.btn-view-custom').click();
        });
    });
</script>
</body>
</html>