<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management Dashboard | Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --maroon: #8B1538;
            --maroon-dark: #6B0F2A;
            --bg: #FAFAF8;
            --card: #ffffff;
            --text: #1F2937;
            --muted: #6B7280;
            --border: #E5E7EB;
            --success: #10B981;
            --danger: #EF4444;
        }

        body { 
            background: var(--bg); 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; 
            color: var(--text); 
        }

        .admin-wrapper { 
            max-width: 1400px; 
            margin: 40px auto; 
            padding: 0 20px; 
        }

        .alumni-card {
            background: var(--card);
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: 1px solid var(--border);
        }

        .btn-modern-primary {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white !important;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .stat-card {
            background: #F9FAFB;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
        }

        .stat-value {
            color: var(--maroon);
            font-size: 2rem;
            font-weight: 800;
        }

        .search-box-wrapper {
            background: #f9f9f9;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 8px 20px;
        }

        .search-input-clean {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: white;
            color: var(--muted);
            cursor: pointer;
        }

        .action-btn:hover { background: var(--maroon); color: white; }
        .action-btn.delete:hover { background: var(--danger); color: white; }

        /* Centered Modal Styles */
        .modal-dialog-centered { display: flex; align-items: center; min-height: calc(100% - 1rem); }
        .modal-content { border-radius: 16px; border: none; box-shadow: 0 20px 50px rgba(0,0,0,0.2); }
        .modal-header { border-bottom: 1px solid var(--border); background: #F9FAFB; border-radius: 16px 16px 0 0; }
        .form-control { border-radius: 8px; padding: 12px; }

        /* Toast Styles */
        #toastContainer {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .custom-toast {
            min-width: 280px;
            padding: 16px 20px;
            border-radius: 12px;
            color: white;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease-out;
        }

        .toast-success { background: var(--success); }
        .toast-error { background: var(--danger); }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>

<div id="toastContainer"></div>

<div class="admin-wrapper">
    <div class="alumni-card">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 style="color: var(--maroon); font-weight: 800;"><i class="fas fa-calendar-check mr-3"></i>Event Management</h2>
            <button type="button" class="btn btn-modern-primary" onclick="prepareCreate()">
                <i class="fas fa-plus mr-2"></i> Create Event
            </button>
        </div>

        <div class="row mb-5">
            <div class="col-md-4 mb-3"><div class="stat-card text-center"><p class="small font-weight-bold text-muted">Total Events</p><p class="stat-value"><?= count($events) ?></p></div></div>
            <div class="col-md-4 mb-3"><div class="stat-card text-center"><p class="small font-weight-bold text-muted">Upcoming</p><p class="stat-value"><?= $upcoming_count ?? 0 ?></p></div></div>
            <div class="col-md-4 mb-3"><div class="stat-card text-center"><p class="small font-weight-bold text-muted">Total Reach</p><p class="stat-value"><?= $total_participants_all ?? 0 ?></p></div></div>
        </div>

        <div class="search-box-wrapper mb-4 d-flex align-items-center">
            <i class="fas fa-search text-muted mr-2"></i>
            <input type="text" class="form-control search-input-clean" id="eventSearchInput" placeholder="Search events...">
        </div>

        <div class="table-responsive">
            <table class="table" id="eventTable">
                <thead>
                    <tr class="text-muted small">
                        <th>Event Name</th>
                        <th>Date & Time</th>
                        <th>Location</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($events)): foreach($events as $event): ?>
                    <tr id="row-<?= $event->id ?>">
                        <td class="font-weight-bold"><?= htmlspecialchars($event->event_name) ?></td>
                        <td class="text-muted"><?= date('M d, Y • h:i A', strtotime($event->event_date)) ?></td>
                        <td><i class="fas fa-map-marker-alt text-maroon mr-1"></i> <?= htmlspecialchars($event->location) ?></td>
                        <td class="text-right">
                            <button class="action-btn" onclick='editEvent(<?= json_encode($event) ?>)'><i class="fas fa-edit"></i></button>
                            <button class="action-btn delete" onclick="deleteEvent(<?= $event->id ?>)"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modalTitle">Create Event</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="eventForm">
                <div class="modal-body">
                    <input type="hidden" name="event_id" id="event_id">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-muted text-uppercase">Event Title</label>
                        <input type="text" name="event_name" id="event_name" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold text-muted text-uppercase">Date & Time</label>
                            <input type="datetime-local" name="event_date" id="event_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold text-muted text-uppercase">Location</label>
                            <input type="text" name="location" id="location" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold text-muted text-uppercase">Duration (hours)</label>
                            <input type="number" name="event_time_duration" id="event_time_duration" class="form-control" placeholder="e.g. 2">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold text-muted text-uppercase">Contact Person</label>
                            <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted text-uppercase">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" placeholder="Event details..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveBtn" class="btn btn-modern-primary">Save Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function showToast(message, type = 'success') {
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const toastClass = type === 'success' ? 'toast-success' : 'toast-error';
        const html = `
            <div class="custom-toast ${toastClass}">
                <i class="fas ${icon} mr-3"></i>
                <span class="font-weight-bold">${message}</span>
            </div>
        `;
        const $toast = $(html);
        $('#toastContainer').append($toast);
        setTimeout(() => { $toast.fadeOut(400, function() { $(this).remove(); }); }, 3000);
    }

    function prepareCreate() {
        $('#modalTitle').text('Create New Event');
        $('#eventForm')[0].reset();
        $('#event_id').val('');
        $('#eventModal').modal('show');
    }

    function editEvent(data) {
        $('#modalTitle').text('Edit Event');
        $('#event_id').val(data.id);
        $('#event_name').val(data.event_name);
        if (data.event_date) {
            let date = new Date(data.event_date);
            $('#event_date').val(date.toISOString().slice(0, 16));
        }
        $('#location').val(data.location);
        $('#event_time_duration').val(data.event_time_duration ?? '');
        $('#contact_person').val(data.contact_person ?? '');
        $('#description').val(data.description ?? '');
        $('#eventModal').modal('show');
    }

    function deleteEvent(id) {
        if(confirm('Delete this event?')) {
            window.location.href = '<?= base_url('AdminEvents/delete/') ?>' + id;
        }
    }

    $(document).ready(function() {
        $('#eventForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#saveBtn');
            btn.prop('disabled', true).text('Processing...');

            const eventId = $('#event_id').val();
            const action = eventId ? '<?= base_url('AdminEvents/update/') ?>' + eventId : '<?= base_url('AdminEvents/create') ?>';

            $.ajax({
                url: action,
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#eventModal').modal('hide');
                    showToast('Event saved successfully!');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function() {
                    showToast('Failed to save event. Check your connection.', 'error');
                    btn.prop('disabled', false).text('Save Event');
                }
            });
        });

        $("#eventSearchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#eventTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
</body>
</html>