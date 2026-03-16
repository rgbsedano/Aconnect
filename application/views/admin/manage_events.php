<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #a12124;
        --accent-blue: #3b59ff;
        --accent-green: #04b373;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 24px;
    }

    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px 24px;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-section {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .header-section h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 4px;
        color: white;
    }

    .header-section h1 span { color: #ff6b6b; }
    .header-section p { color: rgba(255, 255, 255, 0.9); font-size: 14px; margin: 0; }

    /* Stats Section */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card-mini {
        background: white;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
    }

    .stat-info h4 { font-size: 24px; font-weight: 800; color: var(--text-main); margin: 0; }
    .stat-info span { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }

    /* Main Table Card */
    .main-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .search-box {
        background: #f1f5f9;
        border-radius: 14px;
        padding: 8px 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        max-width: 400px;
        border: 2px solid transparent;
        transition: var(--transition);
    }

    .search-box:focus-within {
        background: white;
        border-color: var(--accent-red);
        box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05);
    }

    .search-input {
        background: transparent;
        border: none;
        outline: none;
        font-size: 14px;
        font-weight: 500;
        width: 100%;
    }

    /* Filter Pills */
    .filter-pills { display: flex; gap: 8px; }
    .pill {
        padding: 6px 16px; border-radius: 10px; font-size: 13px; font-weight: 700;
        cursor: pointer; transition: var(--transition); border: 1px solid #e2e8f0; background: white; color: var(--text-muted);
    }
    .pill.active { background: var(--accent-red); color: white; border-color: var(--accent-red); }

    /* Custom Table */
    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .custom-table th { padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); }
    .custom-table tr.data-row { background: white; transition: var(--transition); }
    .custom-table tr.data-row:hover { transform: scale(1.005); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .custom-table td { padding: 16px 20px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    .custom-table td:first-child { border-left: 1px solid #f1f5f9; border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
    .custom-table td:last-child { border-right: 1px solid #f1f5f9; border-top-right-radius: 14px; border-bottom-right-radius: 14px; }

    .event-name { font-weight: 700; color: var(--text-main); font-size: 15px; }
    .event-date { font-size: 12px; font-weight: 600; color: var(--accent-red); display: block; margin-top: 2px; }
    .badge-status { padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; }
    .badge-upcoming { background: #dcfce7; color: #166534; }
    .badge-ended { background: #f1f5f9; color: var(--text-muted); }

    .btn-action {
        width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;
        background: #f8fafc; color: var(--text-muted); border: 1px solid #e2e8f0; transition: var(--transition);
        margin-left: 5px;
    }
    .btn-action:hover { background: var(--accent-red); color: white; border-color: var(--accent-red); transform: translateY(-2px); }
    .btn-action.delete:hover { background: #ef4444; border-color: #ef4444; }

    /* Modal Styling */
    .modal-content { border-radius: 24px; border: none; overflow: hidden; }
    .modal-header { background: var(--accent-red); color: white; padding: 25px; border: none; }
    .modal-body { padding: 30px; }
    .form-label { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; display: block; }
    .form-input { border-radius: 12px; padding: 12px; font-size: 14px; font-weight: 500; border: 1px solid #e2e8f0; }
    .form-input:focus { border-color: var(--accent-red); box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05); }

    @media (max-width: 768px) {
        .dashboard-wrapper { padding: 15px; margin: 10px auto; }
        .header-section { flex-direction: column; align-items: flex-start !important; gap: 15px; }
        .header-section h1 { font-size: 24px; }
        .stats-grid { grid-template-columns: 1fr; }
        .main-card { padding: 15px; }
        .toolbar { flex-direction: column; align-items: stretch; }
        .search-box { max-width: none; }
    }

    @media (max-width: 576px) {
        .actions, .actions .btn { width: 100%; }
        .filter-pills { overflow-x: auto; padding-bottom: 5px; }
    }

    /* Modal Spacing for Header */
    .modal-dialog { margin-top: 100px !important; margin-bottom: 50px !important; }

    @media (min-width: 992px) {
        /* Desktop: Wide for event details, adaptive for others */
        .modal-wide { max-width: 950px !important; }
        .modal-adaptive { max-width: 650px !important; }
    }

    @media (max-width: 768px) {
        /* Mobile Modal Adjustments */
        .modal-dialog { margin-top: 60px !important; margin-left: 12px; margin-right: 12px; margin-bottom: 30px !important; }
        .modal-content { border-radius: 20px; }
        .modal-body { padding: 20px; }
        .modal-header { padding: 20px; }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if($this->session->flashdata('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '<?= $this->session->flashdata('success') ?>',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php endif; ?>

<div class="dashboard-wrapper">
    <div class="header-section">
        <div>
            <h1>Community <span>Events</span></h1>
            <p>Organize gatherings, webinars, and networking opportunities.</p>
        </div>
        <div class="actions">
            <button class="btn btn-danger" onclick="prepareCreate()" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">
                <i class="fas fa-plus mr-2"></i> Create Event
            </button>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card-mini">
            <div class="stat-icon" style="background: #eff6ff; color: #3b59ff;"><i class="fas fa-calendar-alt"></i></div>
            <div class="stat-info"><span>Total Events</span><h4><?= count($events) ?></h4></div>
        </div>
        <div class="stat-card-mini">
            <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;"><i class="fas fa-clock"></i></div>
            <div class="stat-info"><span>Upcoming</span><h4><?= $upcoming_count ?? 0 ?></h4></div>
        </div>
        <div class="stat-card-mini">
            <div class="stat-icon" style="background: #fff7ed; color: #ea580c;"><i class="fas fa-users"></i></div>
            <div class="stat-info"><span>Reach</span><h4><?= $total_participants_all ?? 0 ?></h4></div>
        </div>
    </div>

    <div class="main-card">
        <div class="toolbar">
            <div class="search-box">
                <i class="fas fa-search text-muted"></i>
                <input type="text" id="eventSearchInput" class="search-input" placeholder="Search events by name or location...">
            </div>
            <div class="filter-pills">
                <div class="pill active" data-filter="all">All</div>
                <div class="pill" data-filter="active">Active</div>
                <div class="pill" data-filter="ended">Ended</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="custom-table" id="eventTable">
                <thead>
                    <tr>
                        <th>Event Detail</th>
                        <th>Location</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($events)): foreach($events as $event): 
                        $is_ended = strtotime($event->event_date) < time();
                        $status_class = $is_ended ? 'ended' : 'active';
                    ?>
                        <tr class="data-row" id="row-<?= $event->id ?>" data-status="<?= $status_class ?>">
                            <td>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <?php if(!empty($event->image)): ?>
                                        <div style="width:48px; height:48px; overflow:hidden; border-radius:8px; flex-shrink:0;">
                                            <img src="<?= base_url('assets/uploads/events/') . $event->image ?>" style="width:100%; height:100%; object-fit:cover;">
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="event-name"><?= htmlspecialchars($event->event_name) ?></div>
                                        <span class="event-date"><?= date('M d, Y • h:i A', strtotime($event->event_date)) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-main);">
                                    <i class="fas fa-map-marker-alt text-danger mr-1" style="font-size: 11px;"></i> 
                                    <?= htmlspecialchars($event->location) ?>
                                </div>
                            </td>
                            <td><span style="font-size: 12px; color: var(--text-muted); font-weight: 500;"><?= date('M d, Y', strtotime($event->created_at ?? 'today')) ?></span></td>
                            <td>
                                <?php if($is_ended): ?>
                                    <span class="badge-status badge-ended">Ended</span>
                                <?php else: ?>
                                    <span class="badge-status badge-upcoming">Upcoming</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <button class="btn-action" onclick='editEvent(<?= json_encode($event) ?>)' title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action delete" onclick="deleteEvent(<?= $event->id ?>)" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-wide" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;" id="modalTitle">Create Event</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="eventForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Event Image</label>
                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                        <small class="form-text text-muted">Optional — upload a poster or hero image for the event.</small>
                    </div>
                    <input type="hidden" name="event_id" id="event_id">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Event Title</label>
                            <input type="text" name="event_name" id="event_name" class="form-control form-input" placeholder="Give your event a memorable title" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date & Time</label>
                            <input type="datetime-local" name="event_date" id="event_date" class="form-control form-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Exact Location</label>
                            <input type="text" name="location" id="location" class="form-control form-input" placeholder="e.g. Grand Hall, Main Campus" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estimate Duration (hours)</label>
                            <input type="number" name="event_time_duration" id="event_time_duration" class="form-control form-input" placeholder="e.g. 3">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primary Contact</label>
                            <input type="text" name="contact_person" id="contact_person" class="form-control form-input" placeholder="Name of coordinator">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description & Agenda</label>
                            <textarea name="description" id="description" class="form-control form-input" rows="4" placeholder="Describe the purpose, highlights, and agenda for the attendees..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 12px; font-weight: 600;">Cancel</button>
                    <button type="submit" id="saveBtn" class="btn btn-danger" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">Save Event</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    function prepareCreate() {
        $('#modalTitle').text('New Event Initiative');
        $('#eventForm')[0].reset();
        $('#event_id').val('');
        $('#eventModal').modal('show');
    }

    function editEvent(data) {
        $('#modalTitle').text('Edit Event Details');
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
        if(confirm('Are you sure you want to permanently delete this event? This action cannot be undone.')) {
            window.location.href = '<?= base_url('AdminEvents/delete/') ?>' + id;
        }
    }

    function prepareCreate() {
    $('#modalTitle').text('New Event Initiative');
    $('#eventForm')[0].reset();
    $('#event_id').val('');

    // ✅ IMPORTANT
    $('#eventForm').attr(
        'action',
        '<?= base_url('AdminEvents/create') ?>'
    );

    $('#eventModal').modal('show');
    }

    function editEvent(data) {
    $('#modalTitle').text('Edit Event Details');
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

    // ✅ IMPORTANT
    $('#eventForm').attr(
        'action',
        '<?= base_url('AdminEvents/update/') ?>' + data.id
    );

    $('#eventModal').modal('show');
    }



    $(document).ready(function() {
        

        $("#eventSearchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#eventTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('.pill').on('click', function() {
            $('.pill').removeClass('active');
            $(this).addClass('active');
            
            const filter = $(this).data('filter');
            
            $("#eventTable tbody tr").each(function() {
                const status = $(this).data('status');
                if (filter === 'all' || status === filter) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

