<div class="container-fluid"></div>

<div class="container mt-5">
    <h2 class="mb-4">Manage Events</h2>
    <button class="btn btn-success mb-4" data-toggle="modal" data-target="#createModal" style="background: #700A0A" >+ Create Event</button>
    <div class="row">
        <?php foreach($events as $event): ?>
            <div class="col-md-4 mb-4">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title"><?= $event->event_name ?></h5>
                        <p class="card-text">
                            <strong>Date:</strong> <?= date('F d, Y h:i A', strtotime($event->event_date)) ?><br>
                            <strong>Location:</strong> <?= $event->location ?>
                        </p>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?= $event->id ?>">Edit</button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $event->id ?>">Delete</button>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#participantModal<?= $event->id ?>">View Participants</button>
                    </div>
                </div>
            </div>

            <!-- Create Modal -->
                <div class="modal fade" id="createModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <form action="<?= base_url('AdminEvents/create') ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                        <h5 class="modal-title">Create Event</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                        <div class="form-group">
                            <label>Event Name</label>
                            <input type="text" name="event_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Date & Time</label>
                            <input type="datetime-local" name="event_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Event Time Duration</label>
                            <input type="text" name="event_time_duration" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Contact Person</label>
                            <input type="text" name="contact_person" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attach Image</label>
                            <input type="file" name="image" class="form-control-file" accept="image/*">
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
            <div class="modal fade" id="editModal<?= $event->id ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="<?= base_url('AdminEvents/update/'.$event->id) ?>" method="post" enctype="multipart/form-data">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Event</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                           
                      </div>
                      <div class="modal-body">
                      <div class="form-group">
                            <?php if ($event->image): ?>
                                    <img src="<?= base_url('./assets/uploads/events/' . $event->image) ?>" class="card-img-top" alt="Event Image" style="height: 300px; max-width: 100%;">
                                <?php endif; ?>
                            </div>
                        <div class="form-group">
                                <label>Event Name</label>
                                <input type="text" name="event_name" class="form-control" value="<?= $event->event_name ?>">
                            </div>
                          <div class="form-group">
                              <label>Date & Time</label>
                              <input type="datetime-local" name="event_date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($event->event_date)) ?>">
                          </div>
                          <div class="form-group">
                              <label>Location</label>
                              <input type="text" name="location" class="form-control" value="<?= $event->location ?>">
                          </div>

                        <div class="form-group">
                            <label>Event Time Duration</label>
                            <input type="text" name="event_time_duration" class="form-control" value="<?= $event->event_time_duration ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Contact Person</label>
                            <input type="text" name="contact_person" class="form-control" value="<?= $event->contact_person ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control"  required><?= $event->description ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attach Image</label>
                            <input type="file" name="image" class="form-control-file" accept="image/*">
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
            <div class="modal fade" id="deleteModal<?= $event->id ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="<?= base_url('AdminEvents/delete/'.$event->id) ?>" method="post">
                      <div class="modal-header">
                          <h5 class="modal-title">Delete Event</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                          Are you sure you want to delete "<strong><?= $event->event_name ?></strong>"?
                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-danger">Delete</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- View Participants Modal -->
            <div class="modal fade" id="participantModal<?= $event->id ?>" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Participants for <?= $event->event_name ?></h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                      <?php
                      $this->db->select('alumni.*');
                      $this->db->from('event_registrations');
                      $this->db->join('alumni', 'alumni.id = event_registrations.alumni_id');
                      $this->db->where('event_registrations.event_id', $event->id);
                      $participants = $this->db->get()->result();
                      ?>
                      <?php if (count($participants) > 0): ?>
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>Name</th>
                                      <th>Student Number</th>
                                      <th>Email</th>
                                      <th>Graduation Year</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php foreach($participants as $alum): ?>
                                      <tr>
                                          <td><?= $alum->first_name . ' ' . $alum->last_name ?></td>
                                          <td><?= $alum->student_number ?></td>
                                          <td><?= $alum->email ?></td>
                                          <td><?= $alum->graduation_year ?></td>
                                      </tr>
                                  <?php endforeach; ?>
                              </tbody>
                          </table>
                      <?php else: ?>
                          <p>No participants registered yet.</p>
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