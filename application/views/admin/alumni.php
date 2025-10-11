<div class="container mt-5">
    <h2>Alumni List</h2>
    <form method="get" class="mb-4" id="searchForm">
      <div class="row">
        <div class="col-md-10 position-relative">
          <input type="text" name="search" id="searchInput" class="form-control pr-5" placeholder="Search alumni..." value="<?= $this->input->get('search') ?>">
          <?php if ($this->input->get('search')): ?>
            <button type="button" id="clearSearch"  class="btn btn-sm btn-light position-absolute" style="right: 45px; top: 50%; transform: translateY(-50%); ">
              &times;
            </button>
          <?php endif; ?>
        </div>
        <div class="col-md-2">
          <button type="submit" style="background: #700A0A;" class="btn text-white btn-block">Search</button>
        </div>
      </div>
    </form>

    <table class="table table-bordered">
        <thead style="background-color: #700A0A; color: #fff;">
            <tr>
                <th>Alumni No.</th>
                <th>Student No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Graduation Year</th>
                <th>Degree</th>
                <th>Action</th>
            </tr>
        </thead>                                                             
        <tbody>
            <?php foreach ($alumni_list as $alumni): ?>
                <tr>
                    <td><?= $alumni['alumni_number'] ?></td>
                    <td><?= $alumni['student_number'] ?></td>
                    <td><?= ucwords($alumni['first_name'] . ' ' . $alumni['last_name']) ?></td>
                    <td><?= $alumni['email'] ?></td>
                    <td><?= $alumni['phone'] ?></td>
                    <td><?= $alumni['graduation_year'] ?></td>
                    <td><?= ucwords($alumni['degree']) ?></td>
                    <td>
                        <button class="btn btn-info btn-sm"  style="background: #700A0A;" data-toggle="modal" data-target="#viewModal<?= $alumni['id'] ?>">View</button>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="viewModal<?= $alumni['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?= $alumni['id'] ?>" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header text-white" style="background-color: #700A0A;">
                        <h5 class="modal-title" id="viewModalLabel<?= $alumni['id'] ?>">Alumni Details</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
                      </div>

                      <div class="modal-body">
                        <div class="container-fluid">
                          <!-- Basic Info -->
                          <h5 class="mb-2" style="color: #700A0A">Basic Information</h5>
                          <div class="row mb-2">
                            <div class="col-md-6"><strong>Alumni No.:</strong> <?= $alumni['alumni_number'] ?></div>
                            <div class="col-md-6"><strong>Student No.:</strong> <?= $alumni['student_number'] ?></div>
                            <div class="col-md-6"><strong>Name:</strong> <?= ucwords($alumni['first_name'] . ' ' . $alumni['last_name']) ?></div>
                            <div class="col-md-6"><strong>Status:</strong> <?= $alumni['status'] ?></div>
                          </div>

                          <!-- Contact Info -->
                          <h5 class="mt-3 mb-2" style="color: #700A0A">Contact Information</h5>
                          <div class="row mb-2">
                            <div class="col-md-6"><strong>Email:</strong> <?= $alumni['email'] ?></div>
                            <div class="col-md-6"><strong>Alternative Email:</strong> <?= $alumni['alternative_email'] ?></div>
                            <div class="col-md-6"><strong>Phone:</strong> <?= $alumni['phone'] ?></div>
                            <div class="col-md-6"><strong>Alternative Phone:</strong> <?= $alumni['alternative_phone'] ?></div>
                          </div>

                          <!-- Education -->
                          <h5 class="mt-3 mb-2" style="color: #700A0A">Educational Background</h5>
                          <div class="row mb-2">
                            <div class="col-md-6"><strong>Graduation Year:</strong> <?= $alumni['graduation_year'] ?></div>
                            <div class="col-md-6"><strong>Degree:</strong> <?= ucwords($alumni['degree']) ?></div>
                            <div class="col-md-12"><strong>School:</strong> <?= $alumni['school'] ?></div>
                          </div>

                          <!-- Job -->
                          <h5 class="mt-3 mb-2" style="color: #700A0A">Current Job</h5>
                          <div class="row mb-2">
                            <div class="col-md-6"><strong>Job Title:</strong> <?= ucwords($alumni['current_job']) ?></div>
                            <div class="col-md-6"><strong>Organization:</strong> <?= ucwords($alumni['current_job_organization']) ?></div>
                            <div class="col-md-6"><strong>Length:</strong> <?= $alumni['current_job_length'] ?></div>
                          </div>

                          <!-- Skills -->
                          <h5 class=" mt-3 mb-2" style="color: #700A0A">Skills</h5>
                          <div class="row mb-2">
                            <div class="col-md-12"><strong>Soft Skills:</strong> <?= ucwords($alumni['soft_skills']) ?></div>
                            <div class="col-md-12"><strong>Technical Skills:</strong> <?= ucwords($alumni['technical_skills']) ?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
    <?= $pagination ?>
    </div>
</div>

<script>
  document.getElementById('clearSearch')?.addEventListener('click', function () {
    document.getElementById('searchInput').value = '';
    document.getElementById('searchForm').submit();
  });
</script>
<!-- Bootstrap JS + jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>