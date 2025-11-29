<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Event Feed</title>
    <!-- Load Tailwind CSS CDN -->
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

    <!-- Main Content Container -->
    <div class="max-w-xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">
            Previous Events
        </h2>

        <!-- Event Cards Container (Simulating Social Feed) -->
        <div id="event-feed-container" class="space-y-6">
            <!-- Event cards will be injected here by JavaScript -->
        </div>

        <!-- No Events Found Placeholder -->
        <div id="no-events-message" class="hidden text-center py-12 bg-white rounded-xl shadow-md">
            <p class="text-gray-500 text-lg">No previous events found in the database.</p>
        </div>
    </div>

    <!-- Modal Container (Dynamically rendered based on card clicks) -->
    <div id="modal-container">
        <!-- Modals will be injected here by JavaScript -->
    </div>

    <script>
        // Sample Data (Replacing PHP $events array)
        const eventsData = [
            {
                id: 1,
                event_name: "Q3 Project Review & Networking",
                location: "Online (Zoom)",
                event_date: "2024-11-20 14:00:00",
                event_time_duration: "90 minutes",
                contact_person: "Sarah Connor",
                description: "A deep dive into the achievements and challenges of the third quarter, followed by an open networking session for all attendees.",
                created_at: "2024-10-01 10:00:00"
            },
            {
                id: 2,
                event_name: "Annual Company Hackathon",
                location: "Headquarters, Floor 12",
                event_date: "2024-09-15 08:30:00",
                event_time_duration: "24 hours",
                contact_person: "John Doe",
                description: "The yearly innovation challenge. Teams competed to build prototypes using emerging technology. Great energy and amazing results!",
                created_at: "2024-08-01 10:00:00"
            },
            {
                id: 3,
                event_name: "Marketing Strategy Workshop",
                location: "Event Hall B",
                event_date: "2024-07-05 10:00:00",
                event_time_duration: "4 hours",
                contact_person: "Jane Smith",
                description: "Focused session on defining the outreach goals for the next fiscal year. Key topics included digital transformation and SEO optimization.",
                created_at: "2024-06-15 10:00:00"
            }
        ];

        // Helper function to calculate time difference (Replacing PHP timespan())
        function timeAgo(dateString) {
            const now = new Date();
            const past = new Date(dateString);
            const seconds = Math.floor((now - past) / 1000);
            
            let interval = seconds / 31536000;
            if (interval > 1) {
                return Math.floor(interval) + " years ago";
            }
            interval = seconds / 2592000;
            if (interval > 1) {
                return Math.floor(interval) + " months ago";
            }
            interval = seconds / 86400;
            if (interval > 1) {
                return Math.floor(interval) + " days ago";
            }
            interval = seconds / 3600;
            if (interval > 1) {
                return Math.floor(interval) + " hours ago";
            }
            interval = seconds / 60;
            if (interval > 1) {
                return Math.floor(interval) + " minutes ago";
            }
            return Math.floor(seconds) + " seconds ago";
        }

        const filteredEvents = eventsData.filter(event => new Date(event.event_date) < new Date());
        
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
                    <div id="event-card-${event.id}" class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 ease-in-out cursor-pointer p-6 border-t-4 border-red-500" onclick="openModal(${event.id})">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xl font-bold text-gray-900">${event.event_name}</h4>
                            <span class="text-xs font-medium text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Finished</span>
                        </div>
                        
                        <div class="text-sm text-gray-500 mb-4 flex items-center space-x-4">
                            <span title="Location" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.727A8 8 0 0115.485 20.91a1.2 1.2 0 01-1.09-2.17l.03-.04A6 6 0 0013 10a6 6 0 00-6 6 6 6 0 00.515 2.273A8 8 0 1117.657 16.727z" />
                                </svg>
                                ${event.location}
                            </span>
                            <span title="Time Ago" class="text-gray-400">
                                ${timeAgo(event.event_date)}
                            </span>
                        </div>

                        <p class="text-gray-700 leading-relaxed truncate">${event.description}</p>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end">
                            <span class="text-sm font-semibold text-red-600 hover:text-red-700">
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