<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events Feed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for aesthetic enhancements */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fb; /* Light background for a clean feed look */
        }
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            transition: opacity 0.3s ease;
        }
        .modal-content {
            animation: fadeInScale 0.3s ease-out;
        }
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        /* Hide scrollbar for a cleaner look while keeping content scrollable */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="antialiased">

    <div class="max-w-xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">
            Upcoming Events
        </h2>

        <div id="event-feed-container" class="space-y-6">
            </div>

        <div id="no-events-message" class="hidden text-center py-12 bg-white rounded-xl shadow-md">
            <p class="text-gray-500 text-lg">No upcoming events found.</p>
        </div>
    </div>

    <div id="modal-container">
        </div>

    <script>
        // Sample Data (Replacing PHP $events array)
        const eventsData = [
            {
                id: 101,
                event_name: "Annual Product Launch Keynote",
                location: "Virtual (Live Stream)",
                event_date: "2025-12-10 10:00:00",
                event_time_duration: "60 minutes",
                contact_person: "Alex Chen",
                description: "Be the first to see our exciting new product line for 2026. Includes live Q&A with the CEO and product team.",
                created_at: "2025-11-20 09:00:00"
            },
            {
                id: 102,
                event_name: "Data Science Training Workshop",
                location: "Training Room C, Level 5",
                event_date: "2025-12-05 13:30:00",
                event_time_duration: "3 hours",
                contact_person: "Dr. Evelyn Reed",
                description: "A hands-on workshop focused on advanced predictive modeling techniques using Python and TensorFlow.",
                created_at: "2025-11-01 11:00:00"
            },
            {
                id: 103,
                event_name: "Holiday Charity Gala",
                location: "Grand Ballroom, City Hotel",
                event_date: "2025-12-24 18:00:00",
                event_time_duration: "4 hours",
                contact_person: "Finance Dept.",
                description: "Join us for our annual fundraising gala to support local education initiatives. Dinner, dancing, and silent auction included.",
                created_at: "2025-10-15 12:00:00"
            }
        ];

        // Helper function to calculate time difference until event (Replacing PHP timespan())
        function timeToEvent(dateString) {
            const now = new Date();
            const future = new Date(dateString);
            const seconds = Math.floor((future - now) / 1000);

            if (seconds < 0) {
                return "Event already passed";
            }
            
            let interval = seconds / 31536000;
            if (interval > 1) {
                return Math.floor(interval) + " years away";
            }
            interval = seconds / 2592000;
            if (interval > 1) {
                return Math.floor(interval) + " months away";
            }
            interval = seconds / 86400;
            if (interval > 1) {
                return Math.floor(interval) + " days away";
            }
            interval = seconds / 3600;
            if (interval > 1) {
                return Math.floor(interval) + " hours away";
            }
            interval = seconds / 60;
            if (interval > 1) {
                return Math.floor(interval) + " minutes away";
            }
            return "Happening soon";
        }

        const filteredEvents = eventsData.filter(event => new Date(event.event_date) >= new Date());
        
        const eventContainer = document.getElementById('event-feed-container');
        const modalContainer = document.getElementById('modal-container');
        const noEventsMessage = document.getElementById('no-events-message');

        // Main rendering function
        function renderEvents() {
            if (filteredEvents.length === 0) {
                noEventsMessage.classList.remove('hidden');
                return;
            }

            filteredEvents.forEach(event => {
                // 1. Create the Event Card (Social Post Style)
                const cardHtml = `
                    <div id="event-card-${event.id}" class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 ease-in-out cursor-pointer p-6 border-t-4 border-emerald-500" onclick="openModal(${event.id})">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xl font-bold text-gray-900">${event.event_name}</h4>
                            <span class="text-xs font-medium text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-full">Upcoming</span>
                        </div>
                        
                        <div class="text-sm text-gray-500 mb-4 flex items-center space-x-4">
                            <span title="Location" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.727A8 8 0 0115.485 20.91a1.2 1.2 0 01-1.09-2.17l.03-.04A6 6 0 0013 10a6 6 0 00-6 6 6 6 0 00.515 2.273A8 8 0 1117.657 16.727z" />
                                </svg>
                                ${event.location}
                            </span>
                            <span title="Time Remaining" class="text-emerald-500 font-semibold">
                                ${timeToEvent(event.event_date)}
                            </span>
                        </div>

                        <p class="text-gray-700 leading-relaxed truncate">${event.description}</p>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <button onclick="event.stopPropagation(); handleRegistration(${event.id}, '${event.event_name}')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 shadow-md text-sm">
                                Register Now
                            </button>
                            <span class="text-sm font-semibold text-gray-500 hover:text-gray-600">
                                View Details &rarr;
                            </span>
                        </div>
                    </div>
                `;
                eventContainer.insertAdjacentHTML('beforeend', cardHtml);


                // 2. Create the Modal (Popup)
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
                            
                            <div class="mt-6 flex justify-end">
                                <button onclick="handleRegistration(${event.id}, '${event.event_name}'); closeModal(${event.id})" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition duration-150 shadow-lg text-base w-full sm:w-auto">
                                    Register for Event
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                modalContainer.insertAdjacentHTML('beforeend', modalHtml);
            });
        }

        // Initialize rendering on load
        document.addEventListener('DOMContentLoaded', renderEvents);


        // JavaScript Modal Functions
        function openModal(id) {
            const modal = document.getElementById('event-modal-' + id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById('event-modal-' + id);
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }
        
        // Mock registration function (replacing PHP form submission)
        function handleRegistration(id, name) {
            // In a real application, this would send an AJAX request to:
            // <?= base_url('events/register/') ?> + id
            alert('Thank you! Registration for "' + name + '" (ID: ' + id + ') simulated.');
        }

        // Close modal when clicking outside of it
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('modal-overlay')) {
                const openModals = document.querySelectorAll('.modal-overlay.flex');
                openModals.forEach(modal => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                });
            }
        });
        
        // Close modal when pressing the Escape key
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                const openModals = document.querySelectorAll('.modal-overlay.flex');
                openModals.forEach(modal => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                });
            }
        });
    </script>
</body>
</html>