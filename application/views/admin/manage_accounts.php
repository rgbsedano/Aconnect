<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accounts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        :root {
            --primary-color: #700A0A;
            --primary-dark: #5A0808;
            --background: #F8F9FA;
            --light: #FFFFFF;
        }

        body {
            background: var(--background);
        }

        .main-box {
            background: var(--light);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .header-title {
            color: var(--primary-color);
            font-weight: 700;
            border-bottom: 2px solid #EEE;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .table thead {
            background: var(--primary-color);
            color: white;
        }

        .table tbody tr:hover {
            background: #E9ECEF;
        }

        .btn-edit {
            background: var(--primary-color);
            color: white;
            border-radius: 6px;
        }

        .btn-edit:hover {
            background: var(--primary-dark);
        }

        .btn-delete {
            background: #C82333;
            color: white;
            border-radius: 6px;
        }

        .modal-header-custom {
            background: var(--primary-color);
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
    </style>
</head>

<body>

<div class="container main-box">
    <h2 class="header-title"><i class="fas fa-user-cog mr-2"></i> Manage Accounts</h2>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Student No.</th>
                <th>Status</th>
                <th style="width: 140px;">Action</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach($alumni_list as $a): ?>
            <tr>
                <td><?= ucwords($a->first_name . " " . $a->last_name) ?></td>
                <td><?= $a->student_number ?></td>
                <td><?= ucfirst($a->status) ?></td>
                <td>
                    <button class="btn btn-sm btn-edit" data-toggle="modal" data-target="#editModal<?= $a->id ?>">
                        <i class="fas fa-edit"></i> Edit
                    </button>

                    <button class="btn btn-sm btn-delete" data-toggle="modal" data-target="#deleteModal<?= $a->id ?>">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>

            <!-- EDIT MODAL -->
            <div class="modal fade" id="editModal<?= $a->id ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title">
                                <i class="fas fa-user-edit mr-2"></i> Edit Account
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>

                        <form method="post" action="<?= base_url('AdminManageAccounts/update/'.$a->id) ?>">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="<?= $a->first_name ?>">
                                </div>

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="<?= $a->last_name ?>">
                                </div>

                                <div class="form-group">
                                    <label>Email (Read-only)</label>
                                    <input type="email" class="form-control" value="<?= $a->email ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?= $a->phone ?>">
                                </div>

                                <div class="form-group">
                                    <label>Graduation Year</label>
                                    <input type="number" name="graduation_year" value="<?= $a->graduation_year ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Student Number</label>
                                    <input type="text" name="student_number" class="form-control" value="<?= $a->student_number ?>">
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="active" <?= $a->status == "active" ? "selected" : "" ?>>Active</option>
                                        <option value="inactive" <?= $a->status == "inactive" ? "selected" : "" ?>>Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-edit">Save Changes</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <!-- DELETE MODAL -->
            <div class="modal fade" id="deleteModal<?= $a->id ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title">
                                <i class="fas fa-exclamation-triangle mr-2"></i> Confirm Delete
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>

                        <form method="post" action="<?= base_url('AdminManageAccounts/delete/'.$a->id) ?>">
                            <div class="modal-body">
                                Are you sure you want to delete <strong><?= ucwords($a->first_name . " " . $a->last_name) ?></strong>?
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-delete">Delete</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center mt-4">
    <?= $pagination ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
