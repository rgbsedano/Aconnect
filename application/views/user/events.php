<style>
            .event-section {
                margin: 40px 20px;
            }
            .event-heading {
                font-size: 28px;
                margin-bottom: 25px;
                color: #333;
                font-weight: 500;
            }
            .event-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 25px;
            }
            .event-card {
                background-color: #fff;
                border-radius: 12px;
                padding: 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                cursor: pointer;
                transition: transform 0.2s ease-in-out;
                border: 1px solid #eee;
            }
            .event-card:hover {
                transform: scale(1.02);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            }
            .event-card h4 {
                font-size: 18px;
                font-weight: 600;
                color: #222;
                margin-bottom: 8px;
            }
            .event-timestamp {
                font-size: 13px;
                color: #777;
            }
            .modal {
                position: fixed;
                z-index: 1050;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                background-color: rgba(0, 0, 0, 0.4);
                display: none; /* Ensure modal is hidden by default */
                align-items: center;
                justify-content: center;
            }
            .modal-content {
                background: #fff;
                border-radius: 12px;
                padding: 30px;
                width: 90%;
                max-width: 500px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
                position: relative;
            }
            .close {
                position: absolute;
                top: 15px;
                right: 20px;
                font-size: 28px;
                font-weight: 400;
                color: #aaa;
                cursor: pointer;
                border: none;
                background: none;
                padding: 0;
                line-height: 1;
            }
            .close:hover,
            .close:focus {
                color: #333;
                text-decoration: none;
                outline: none;
            }
            .modal-content h3 {
                font-size: 24px;
                font-weight: 600;
                color: #333;
                margin-bottom: 15px;
            }
            .modal-content p {
                line-height: 1.6;
                color: #555;
                margin-bottom: 10px;
            }
            .modal-content strong {
                font-weight: 600;
                color: #222;
            }
            .modal-content form button {
                background-color:rgb(209, 19, 19);
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 6px;
                cursor: pointer;
                font-size: 16px;
                transition: background-color 0.2s ease-in-out;
                margin-top: 15px;
            }
            .modal-content form button:hover {
                background-color:rgb(204, 38, 38);
            }
            .page-heading-minimal {
                font-size: 28px;
                color: #444;
                margin-bottom: 30px;
                font-weight: 500;
            }
            .report-button-minimal {
                display: none; /* Hiding the button for a cleaner look */
            }
        </style>

        <script>
            function openModal(id) {
                document.getElementById('event-modal-' + id).style.display = 'flex';
            }
            function closeModal(id) {
                document.getElementById('event-modal-' + id).style.display = 'none';
            }
        </script>

<?php
$currentDate = date('Y-m-d H:i:s');

$upcomingEvents = array_filter($events, function($event) use ($currentDate) {
    return $event->event_date >= $currentDate;
});
?>

<?php
$previousEvents = array_filter($events, function($event) use ($currentDate) {
    return $event->event_date < $currentDate;
});
?>

        <div class="container-fluid">
            <div class="event-section">
                <h2 class="event-heading">Upcoming Events</h2>
                <?php if (!empty($upcomingEvents)): ?>
                    <div class="event-cards">
                        <?php foreach ($upcomingEvents as $event): ?>
                            <div class="event-card" onclick="openModal(<?= $event->id ?>)">
                                <h4><?= htmlspecialchars($event->event_name) ?></h4>
                                <p><strong>Location:</strong> <?= htmlspecialchars($event->location) ?></p>
                                <div class="event-timestamp">
                                    <?= timespan(time(), strtotime($event->event_date), 1) ?> to go
                                </div>
                            </div>

                            <div id="event-modal-<?= $event->id ?>" class="modal">
                                <div class="modal-content">
                                    <button type="button" class="close" onclick="closeModal(<?= $event->id ?>)">&times;</button>
                                    <h3><?= htmlspecialchars($event->event_name) ?></h3>
                                    <p><strong>Date:</strong> <?= date('F j, Y, g:i a', strtotime($event->event_date)) ?></p>
                                    <p><strong>Location:</strong> <?= htmlspecialchars($event->location) ?></p>
                                    <p><strong>Time Duration:</strong> <?= htmlspecialchars($event->event_time_duration) ?></p>
                                    <p><strong>Contact Person:</strong> <?= htmlspecialchars($event->contact_person) ?></p>
                                    <p><?= nl2br(htmlspecialchars($event->description)) ?></p>
                                    <p>Date Published: <?= htmlspecialchars($event->created_at) ?></p>
                                    <form method="post" action="<?= base_url('events/register/' . $event->id) ?>">
                                        <button type="submit">Register</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No upcoming events found.</p>
                <?php endif; ?>
            </div>
        </div>