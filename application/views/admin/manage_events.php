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
            /* Exact Maroon Palette from Alumni Screenshot */
            --primary-maroon: #7D0A0A; 
            --dark-text: #2D3436;
            --muted-text: #636e72;
            --body-bg: #FDFCFB; /* Soft off-white */
            --white: #FFFFFF;
        }

        body {
            background-color: var(--body-bg);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: var(--dark-text);
        }

        /* 1. Dashboard Header Styling */
        .dashboard-header {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--dark-text);
            margin-bottom: 0;
        }
        
        .header-icon {
            color: var(--primary-maroon);
            font-size: 1.5rem;
            margin-right: 12px;
        }

        /* 2. Button Styling (Matching 'Create Event' & 'Connect' buttons) */
        .btn-maroon-pill {
            background-color: var(--primary-maroon) !important;
            border: none !important;
            color: var(--white) !important;
            border-radius: 8px; /* Matching the 'Create Event' button shape */
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-maroon-pill:hover {
            background-color: #5a0707 !important;
            transform: translateY(-1px);
        }

        /* 3. Stat Cards Design */
        .stat-card {
            background: var(--white);
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #EAEAEA;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            text-align: left;
        }

        .stat-label {
            color: var(--muted-text);
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .stat-value {
            color: var(--primary-maroon);
            font-size: 2.2rem;
            font-weight: 800;
            margin: 0;
        }

        /* 4. Search Bar (Pill Shape from Screenshot) */
        .pill-search-wrapper {
            background: var(--white);
            border: 1px solid #DDD;
            border-radius: 50px; /* Full pill shape */
            padding: 6px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }

        .pill-search-wrapper i {
            color: var(--muted-text);
            margin-right: 15px;
        }

        .pill-search-wrapper input {
            border: none !important;
            box-shadow: none !important;
            width: 100%;
            font-size: 0.95rem;
        }

        /* 5. Event Table / List Area */
        .event-list-container {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid #efefef;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }

        .table-header-text {
            color: #b2bec3;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            border-bottom: 2px solid #f8f9fa;
            padding-bottom: 15px;
        }

        .event-row td {
            padding: 20px 10px;
            vertical-align: middle;
            border-bottom: 1px solid #f8f9fa;
        }

        .event-name {
            font-weight: 700;
            font-size: 1rem;
            color: var(--dark-text);
            margin-bottom: 2px;
        }

        .event-subtext {
            color: var(--muted-text);
            font-size: 0.85rem;
        }

        .badge-upcoming {
            background-color: rgba(125, 10, 10, 0.1);
            color: var(--primary-maroon);
            font-weight: 700;
            font-size: 0.7rem;
            padding: 5px 12px;
            border-radius: 4px;
        }

        .action-icon-btn {
            color: var(--muted-text);
            background: transparent;
            border: none;
            padding: 5px 10px;
            transition: color 0.2s;
        }

        .action-icon-btn:hover {
            color: var(--primary-maroon);
        }

        .btn-delete:hover {
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="dashboard-header">
            <i class="fas fa-university header-icon"></i> Alumni Events
        </h2>
        <button class="btn btn-maroon-pill" data-toggle="modal" data-target="#createModal">
            <i class="fas fa-plus mr-2"></i> Create Event
        </button>
    </div>

    <div class="row mb-5">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stat-card">
                <p class="stat-label">Global Events</p>
                <p class="stat-value"><?= count($events) ?></p>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stat-card">
                <p class="stat-label">Live / Upcoming</p>
                <p class="stat-value"><?= $upcoming_count ?? 0 ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <p class="stat-label">Total Reach</p>
                <p class="stat-value"><?= $total_participants_all ?? 0 ?></p>
            </div>
        </div>
    </div>

    <div class="event-list-container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="pill-search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="eventSearchInput" placeholder="Search events by name, location, or date...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="eventTable">
                <thead>
                    <tr>
                        <th class="table-header-text border-0">Event Details</th>
                        <th class="table-header-text border-0">Venue</th>
                        <th class="table-header-text border-0">Status</th>
                        <th class="table-header-text border-0 text-right">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($events as $event): ?>
                    <tr class="event-row">
                        <td>
                            <div class="event-name"><?= htmlspecialchars($event->event_name) ?></div>
                            <div class="event-subtext"><?= date('M d, Y • h:i A', strtotime($event->event_date)) ?></div>
                        </td>
                        <td>
                            <div class="event-subtext">
                                <i class="fas fa-map-marker-alt mr-1"></i> <?= htmlspecialchars($event->location) ?>
                            </div>
                        </td>
                        <td>
                            <?php if(strtotime($event->event_date) > time()): ?>
                                <span class="badge-upcoming">UPCOMING</span>
                            <?php else: ?>
                                <span class="badge badge-light text-muted small font-weight-bold">PAST</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-right">
                            <button class="action-icon-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-icon-btn btn-delete" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
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