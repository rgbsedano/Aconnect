<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Previous Events Feed - 2 Columns</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body { font-family: 'Inter', sans-serif; background-color: #f7f9fb; }
    .modal-overlay { background-color: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); transition: opacity 0.3s ease; }
    .modal-content { animation: fadeInScale 0.3s ease-out; }
    @keyframes fadeInScale { from { opacity: 0; transform: scale(0.9) translateY(20px); } to { opacity: 1; transform: scale(1) translateY(0); } }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
</head>
<body class="antialiased">

<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">Previous Events</h2>

    <!-- Two-column Grid -->
    <div id="event-feed-container" class="grid grid-cols-1 sm:grid-cols-2 gap-6"></div>

    <div id="no-events-message" class="hidden text-center py-12 bg-white rounded-xl shadow-md mt-6">
        <p class="text-gray-500 text-lg">No previous events found.</p>
    </div>
</div>

<div id="modal-container"></div>

<script>
    const eventsData = <?= json_encode(array_map(function($event) {
        return [
            'id' => $event->id,
            'event_name' => $event->event_name,
            'location' => $event->location,
            'event_date' => $event->event_date,
            'event_time_duration' => $event->event_time_duration,
            'contact_person' => $event->contact_person,
            'description' => $event->description,
            'created_at' => $event->created_at ?? date('Y-m-d H:i:s')
        ];
    }, $events)) ?>;

    function timeAgo(dateString) {
        const now = new Date();
        const past = new Date(dateString);
        const seconds = Math.floor((now - past) / 1000);
        let interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + " years ago";
        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + " months ago";
        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + " days ago";
        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + " hours ago";
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + " minutes ago";
        return Math.floor(seconds) + " seconds ago";
    }

    const filteredEvents = eventsData.filter(event => new Date(event.event_date) < new Date());
    const eventContainer = document.getElementById('event-feed-container');
    const modalContainer = document.getElementById('modal-container');
    const noEventsMessage = document.getElementById('no-events-message');

    function renderEvents() {
        if (filteredEvents.length === 0) {
            noEventsMessage.classList.remove('hidden');
            return;
        }

        filteredEvents.forEach(event => {
            const cardHtml = `
                <div id="event-card-${event.id}" class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 ease-in-out cursor-pointer p-6 border-t-4 border-red-500" onclick="openModal(${event.id})">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xl font-bold text-gray-900">${event.event_name}</h4>
                        <span class="text-xs font-medium text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Finished</span>
                    </div>
                    <div class="text-sm text-gray-500 mb-4 flex items-center space-x-4">
                        <span title="Location" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.727A8 8 0 0115.485 20.91a1.2 1.2 0 01-1.09-2.17l.03-.04A6 6 0 0013 10a6 6 0 00-6 6 6 6 0 00.515 2.273A8 8 0 1117.657 16.727z" />
                            </svg>${event.location}
                        </span>
                        <span title="Time Ago" class="text-gray-400">${timeAgo(event.event_date)}</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed truncate">${event.description}</p>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end">
                        <span class="text-sm font-semibold text-red-600 hover:text-red-700">View Details &rarr;</span>
                    </div>
                </div>
            `;
            eventContainer.insertAdjacentHTML('beforeend', cardHtml);

            const formattedDate = new Date(event.event_date).toLocaleString('en-US', {
                year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
            });

            const modalHtml = `
                <div id="event-modal-${event.id}" class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center p-4">
                    <div class="modal-content bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative">
                        <button type="button" class="close absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition" onclick="closeModal(${event.id})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <h3 class="text-2xl font-extrabold text-gray-900 border-b pb-3 mb-4">${event.event_name}</h3>
                        <div class="space-y-3 text-sm text-gray-700 no-scrollbar max-h-96 overflow-y-auto pr-2">
                            <p><strong class="text-gray-800 w-32 inline-block">Date & Time:</strong> ${formattedDate}</p>
                            <p><strong class="text-gray-800 w-32 inline-block">Location:</strong> ${event.location}</p>
                            <p><strong class="text-gray-800 w-32 inline-block">Duration:</strong> ${event.event_time_duration}</p>
                            <p><strong class="text-gray-800 w-32 inline-block">Contact:</strong> ${event.contact_person}</p>
                            <div class="pt-4 border-t border-gray-100">
                                <strong class="text-base text-gray-800 block mb-2">Description:</strong>
                                <p class="whitespace-pre-wrap">${event.description}</p>
                            </div>
                            <p class="pt-3 border-t border-gray-100 text-xs text-gray-400">Published: ${new Date(event.created_at).toLocaleDateString()}</p>
                        </div>
                    </div>
                </div>
            `;
            modalContainer.insertAdjacentHTML('beforeend', modalHtml);
        });
    }

    document.addEventListener('DOMContentLoaded', renderEvents);

    function openModal(id) {
        const modal = document.getElementById('event-modal-' + id);
        if (modal) { modal.classList.remove('hidden'); modal.classList.add('flex'); }
    }
    function closeModal(id) {
        const modal = document.getElementById('event-modal-' + id);
        if (modal) { modal.classList.remove('flex'); modal.classList.add('hidden'); }
    }

    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('modal-overlay')) {
            document.querySelectorAll('.modal-overlay.flex').forEach(modal => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            });
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.flex').forEach(modal => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            });
        }
    });
</script>

</body>
</html>
