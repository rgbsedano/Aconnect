
<div class="container-fluid">

<div class="container mt-5">
    <h2 class="mb-4">Manage Accounts</h2>
    <table class="table table-bordered">
        <thead style="background-color: #700A0A; color: #fff;">
            <tr>
                <th>Full Name</th>
                <th>Student Number</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($alumni_list as $alumnus): ?>
                <tr>
                    <td><?= $alumnus->first_name . ' ' . $alumnus->last_name ?></td>
                    <td><?= $alumnus->student_number ?></td>
                    <td><?= ucfirst($alumnus->status) ?></td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?= $alumnus->id ?>">Edit</button>
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?= $alumnus->id ?>">Delete</button>
                    </td>
                </tr>

                <!-- Edit Modal -->
<div class="modal fade" id="editModal<?= $alumnus->id ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('AdminManageAccounts/update/'.$alumnus->id) ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title">Edit Alumni</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?= $alumnus->first_name ?>">
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?= $alumnus->last_name ?>">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $alumnus->email ?>" readonly>
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= $alumnus->phone ?>">
          </div>
          <div class="form-group">
            <label>Graduation Year</label>
            <input type="number" name="graduation_year" class="form-control" value="<?= $alumnus->graduation_year ?>">
          </div>
          <div class="form-group">
            <label>Student Number</label>
            <input type="text" name="student_number" class="form-control" value="<?= $alumnus->student_number ?>">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="active" <?= $alumnus->status == 'active' ? 'selected' : '' ?>>Active</option>
              <option value="inactive" <?= $alumnus->status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal<?= $alumnus->id ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="<?= base_url('AdminManageAccounts/delete/'.$alumnus->id) ?>" method="post">
                          <div class="modal-header">
                              <h5 class="modal-title">Delete Confirmation</h5>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                              Are you sure you want to delete <?= $alumnus->first_name . ' ' . $alumnus->last_name ?>?
                          </div>
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-danger">Yes, Delete</button>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div> <!-- /.container-fluid -->
<!-- end of content-->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

