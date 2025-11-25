
<div class="container-fluid">
<div class="container mt-5">
    <h2 class="mb-4">Posted Jobs</h2>
        <!-- Create Job Button -->
        <button class="btn btn-success mb-4" data-toggle="modal" data-target="#createJobModal" style="background: #700A0A">+ Create Job</button>
    <div class="row">
        <?php foreach($jobs as $job): ?>
            <div class="col-md-4 mb-4">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title"><?= $job->job_title ?></h5>
                        <p class="card-text"><strong>Company:</strong> <?= $job->company ?><br>
                        <strong>Location:</strong> <?= $job->location ?></p>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?= $job->id ?>">Edit</button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $job->id ?>">Delete</button>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#applicantModal<?= $job->id ?>">View Applicants</button>
                    </div>
                </div>
            </div>

            <!-- Create Job Modal -->
            <div class="modal fade" id="createJobModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <form action="<?= base_url('AdminJobPosting/create') ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                        <h5 class="modal-title">Create Job</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                        <div class="form-group">
                            <label>Job Title</label>
                            <input type="text" name="job_title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" name="company" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Salary Range</label>
                            <input type="text" name="salary_range" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" name="qualifications" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Contact Details</label>
                            <input type="text" name="contact_details" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attach Image</label>
                            <input type="file" name="image_filename" class="form-control-file" accept="image/*">
                        </div>

                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal<?= $job->id ?>" tabindex="-1">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <form action="<?= base_url('AdminJobPosting/update/'.$job->id) ?>" method="post" enctype="multipart/form-data">
                      <div class="modal-header">
                          <h5 class="modal-title">Edit Job</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                          <?php if ($job->image_filename): ?>
                                <img src="<?= base_url('./assets/uploads/jobs/' . $job->image_filename) ?>" class="card-img-top" alt="Job Image" style="height: 300px; max-width: 100%;">
                            <?php endif; ?>
                          </div>

                          <div class="form-group">
                              <label>Job Title</label>
                              <input type="text" name="job_title" class="form-control" value="<?= $job->job_title ?>">
                          </div>
                          <div class="form-group">
                              <label>Company</label>
                              <input type="text" name="company" class="form-control" value="<?= $job->company ?>">
                          </div>
                          <div class="form-group">
                              <label>Location</label>
                              <input type="text" name="location" class="form-control" value="<?= $job->location ?>">
                          </div>
                          <div class="form-group">
                                <label>Salary Range</label>
                                <input type="text" name="salary_range" class="form-control" value="<?= $job->salary_range ?>">
                            </div>
                            <div class="form-group">
                                <label>Qualifications</label>
                                <textarea name="qualifications" class="form-control"><?= $job->qualifications ?><?= $job->description ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Contact Details</label>
                                <input type="text" name="contact_details" class="form-control" value="<?= $job->contact_details ?>">
                            </div>
                          <div class="form-group">
                              <label>Description</label>
                              <textarea name="description" class="form-control"><?= $job->description ?></textarea>
                          </div>
                         
                          <div class="form-group">
                            <label>Attach Image</label>
                            <input type="file" name="image_filename" class="form-control">
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
            <div class="modal fade" id="deleteModal<?= $job->id ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="<?= base_url('AdminJobPosting/delete/'.$job->id) ?>" method="post">
                      <div class="modal-header">
                          <h5 class="modal-title">Delete Job</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                          Are you sure you want to delete the job "<strong><?= $job->job_title ?></strong>"?
                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-danger">Delete</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- View Applicants Modal -->
            <div class="modal fade" id="applicantModal<?= $job->id ?>" tabindex="-1">
              <div class="modal-dialog modal-xl custom-modal-width">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Applicants for <?= $job->job_title ?></h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                      <?php
                      $this->db->select('alumni.*');
                      $this->db->from('job_applications');
                      $this->db->join('alumni', 'alumni.id = job_applications.alumni_id');
                      $this->db->where('job_applications.job_id', $job->id);
                      $applicants = $this->db->get()->result();
                      ?>
                      <?php if (count($applicants) > 0): ?>
                        <div class="table-responsive">
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>Name</th>
                                      <th>Alumni Number</th>
                                      <th>Student Number</th>
                                      <th>Email</th>
                                      <th>Graduation Year</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php foreach($applicants as $applicant): ?>
                                      <tr>
                                          <td><?= $applicant->first_name . ' ' . $applicant->last_name ?></td>
                                          <td><?= $applicant->alumni_number ?></td>
                                          <td><?= $applicant->student_number ?></td>
                                          <td><?= $applicant->email ?></td>
                                          <td><?= $applicant->graduation_year ?></td>
                                      </tr>
                                  <?php endforeach; ?>
                              </tbody>
                          </table>
                        </div>
                      <?php else: ?>
                          <p>No applicants yet.</p>
                      <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>
</div> <!-- /.container-fluid -->
<!-- end of content-->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
