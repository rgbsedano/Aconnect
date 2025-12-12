<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --success-color: #28A745;
            --danger-color: #DC3545;
            --info-color: #17A2B8;
        }

        body {
            background-color: var(--secondary-color);
        }

        /* Modernized button style for the Create button */
        .btn-custom-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transition: all 0.2s ease-in-out;
        }

        /* Card-like effect for the main container */
        .event-management-container {
            padding: 30px;
            background: #ffffff;
            border-radius: 12px; /* Slightly more rounded corners */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); /* Stronger, modern shadow */
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        /* Table enhancements */
        .table-event-list th {
            background-color: var(--primary-color);
            color: white;
            border-top: 2px solid var(--primary-color);
        }
        .table-event-list td {
            vertical-align: middle;
        }
        
        /* Improved form styling for modals */
        .modal-content {
            border-radius: 10px;
        }
        
        /* Modal Header Customization */
        .modal-header-custom-primary {
            background-color: var(--primary-color);
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        /* Stat Cards for Dashboard feel */
        .stat-card {
            border-radius: 8px;
            padding: 20px;
            color: white;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .stat-card h3 {
            font-size: 2rem;
            margin-bottom: 0;
        }
        .stat-card p {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Event image preview in Edit Modal */
        .edit-image-preview {
            max-height: 200px;
            width: auto;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 15px;
            display: block;
        }

        /* Highlight upcoming events */
        .table-event-list .upcoming-event {
            border-left: 5px solid var(--success-color);
        }
    </style>
</head>
<body>

<?php
// --- Mock Data/Calculations for Demonstration ---
// In a real CodeIgniter app, these would come from the controller
$total_events = count($events);
$upcoming_events = 0;
$total_participants_all = 0;
$today = time();

foreach ($events as $event) {
    // Assuming 'event_date' is a valid date string
    if (strtotime($event->event_date) > $today) {
        $upcoming_events++;
    }
    
    // Recalculate participants to have the variable available for stat card
    $this->db->where('event_id', $event->id);
    $participants_count = $this->db->count_all_results('event_registrations');
    $event->participants_count = $participants_count; // Add to object for table use
    $total_participants_all += $participants_count;
}
// -----------------------------------------------
?>

<div class="container-fluid py-4">
    <div class="container event-management-container">
        <h2 class="mb-5 text-dark"><i class="fas fa-calendar-alt mr-2"></i> Event Management Dashboard</h2>
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card bg-info">
                    <p>Total Events</p>
                    <h3 class="font-weight-bold"><?= $total_events ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card" style="background-color: var(--success-color);">
                    <p>Upcoming Events</p>
                    <h3 class="font-weight-bold"><?= $upcoming_events ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card" style="background-color: var(--primary-color);">
                    <p>Total Participants</p>
                    <h3 class="font-weight-bold"><?= $total_participants_all ?></h3>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-4 flex-column flex-md-row">
            <button class="btn btn-custom-primary mb-2 mb-md-0" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus-circle mr-1"></i> Create New Event
            </button>
            
            <div class="input-group" style="max-width: 300px;">
                <input type="text" class="form-control" placeholder="Search events..." id="eventSearchInput">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>
        
        <hr class="mb-4">

        ## Event List

        <div class="row">
            <div class="col-12">
                
                <?php if (empty($events)): ?>
                    <div class="alert alert-info text-center" role="alert">
                        <i class="fas fa-info-circle mr-1"></i> No events found. Click "Create New Event" to add one.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-event-list align-middle" id="eventTable">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Date & Time</th>
                                    <th>Location</th>
                                    <th>Participants</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($events as $event): ?>
                                <tr class="<?= (strtotime($event->event_date) > $today) ? 'upcoming-event' : '' ?>">
                                    <td><strong><?= htmlspecialchars($event->event_name) ?></strong></td>
                                    <td>
                                        <?= date('M d, Y', strtotime($event->event_date)) ?>
                                        <br>
                                        <small class="text-muted"><i class="far fa-clock mr-1"></i> <?= date('h:i A', strtotime($event->event_date)) ?></small>
                                    </td>
                                    <td><i class="fas fa-map-marker-alt mr-1"></i> <?= htmlspecialchars($event->location) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#participantModal<?= $event->id ?>">
                                            <i class="fas fa-users mr-1"></i> <?= $event->participants_count ?? 0 ?> Registered
                                        </button>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#editModal<?= $event->id ?>" title="Edit Event">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $event->id ?>" title="Delete Event">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>

        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="<?= base_url('AdminEvents/create') ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-header modal-header-custom-primary">
                            <h5 class="modal-title" id="createModalLabel"><i class="fas fa-calendar-plus mr-2"></i> Create New Event</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="eventName"><i class="fas fa-tag mr-1"></i> Event Name</label>
                                <input type="text" name="event_name" id="eventName" class="form-control" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="eventDate"><i class="far fa-calendar-alt mr-1"></i> Date & Time</label>
                                    <input type="datetime-local" name="event_date" id="eventDate" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="eventDuration"><i class="far fa-hourglass mr-1"></i> Duration</label>
                                    <input type="text" name="event_time_duration" id="eventDuration" class="form-control" placeholder="e.g., 2 hours, 1 day" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="eventLocation"><i class="fas fa-map-pin mr-1"></i> Location</label>
                                <input type="text" name="location" id="eventLocation" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="contactPerson"><i class="fas fa-user-tie mr-1"></i> Contact Person</label>
                                <input type="text" name="contact_person" id="contactPerson" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="eventDescription"><i class="fas fa-align-left mr-1"></i> Description</label>
                                <textarea name="description" id="eventDescription" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="eventImage"><i class="far fa-image mr-1"></i> Attach Image</label>
                                <input type="file" name="image" id="eventImage" class="form-control-file" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Create Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php foreach($events as $event): ?>
            
            <div class="modal fade" id="editModal<?= $event->id ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $event->id ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="<?= base_url('AdminEvents/update/'.$event->id) ?>" method="post" enctype="multipart/form-data">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="editModalLabel<?= $event->id ?>"><i class="fas fa-edit mr-2"></i> Edit Event: <?= htmlspecialchars($event->event_name) ?></h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group text-center">
                                    <?php if ($event->image): ?>
                                        <label>Current Image</label>
                                        <img src="<?= base_url('./assets/uploads/events/' . $event->image) ?>" class="edit-image-preview" alt="Event Image">
                                        <input type="hidden" name="current_image" value="<?= $event->image ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-tag mr-1"></i> Event Name</label>
                                    <input type="text" name="event_name" class="form-control" value="<?= htmlspecialchars($event->event_name) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="far fa-calendar-alt mr-1"></i> Date & Time</label>
                                    <input type="datetime-local" name="event_date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($event->event_date)) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-map-pin mr-1"></i> Location</label>
                                    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($event->location) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="far fa-hourglass mr-1"></i> Event Time Duration</label>
                                    <input type="text" name="event_time_duration" class="form-control" value="<?= htmlspecialchars($event->event_time_duration) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-user-tie mr-1"></i> Contact Person</label>
                                    <input type="text" name="contact_person" class="form-control" value="<?= htmlspecialchars($event->contact_person) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-align-left mr-1"></i> Description</label>
                                    <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($event->description) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label><i class="far fa-image mr-1"></i> Replace Image (Optional)</label>
                                    <input type="file" name="image" class="form-control-file" accept="image/*">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal<?= $event->id ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?= $event->id ?>" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <form action="<?= base_url('AdminEvents/delete/'.$event->id) ?>" method="post">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="deleteModalLabel<?= $event->id ?>"><i class="fas fa-exclamation-triangle mr-2"></i> Confirm Delete</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete event: <strong><?= htmlspecialchars($event->event_name) ?></strong>?</p>
                                <small class="text-danger"><i class="fas fa-info-circle"></i> This action cannot be undone.</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt mr-1"></i> Delete Permanently</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="participantModal<?= $event->id ?>" tabindex="-1" role="dialog" aria-labelledby="participantModalLabel<?= $event->id ?>" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="participantModalLabel<?= $event->id ?>"><i class="fas fa-users mr-2"></i> Participants for: <?= htmlspecialchars($event->event_name) ?></h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php
                            // The database logic to fetch participants
                            $this->db->select('alumni.*');
                            $this->db->from('event_registrations');
                            $this->db->join('alumni', 'alumni.id = event_registrations.alumni_id');
                            $this->db->where('event_registrations.event_id', $event->id);
                            $participants = $this->db->get()->result();
                            ?>
                            <?php if (count($participants) > 0): ?>
                                <div class="d-flex justify-content-end mb-3">
                                    <a href="<?= base_url('AdminEvents/export_participants/'.$event->id) ?>" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-file-excel mr-1"></i> Export to Excel (<?= count($participants) ?>)
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
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
                                                    <td><?= htmlspecialchars($alum->first_name . ' ' . $alum->last_name) ?></td>
                                                    <td><?= htmlspecialchars($alum->student_number) ?></td>
                                                    <td><?= htmlspecialchars($alum->email) ?></td>
                                                    <td><?= htmlspecialchars($alum->graduation_year) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning text-center" role="alert">
                                    <i class="fas fa-exclamation-circle mr-1"></i> No participants have registered for this event yet.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
        
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
    $("#eventSearchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#eventTable tbody tr").filter(function() {
            // Check if the row text contains the search value
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
</body>
</html>