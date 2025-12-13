<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upcoming Events Feed</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f7f9fb;
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
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* FIX: Custom style for guaranteed center positioning */
    #instant-success-popup-container {
        pointer-events: none; /* Allows clicks to go through the transparent area */
    }

    #instant-success-popup-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); /* Moves element back by half its width/height */
        opacity: 0;
        transition: opacity 0.3s ease, transform 0.3s ease;
        z-index: 50;
    }
    
    #instant-success-popup-container.opacity-100 #instant-success-popup-content {
        opacity: 1;
        transform: translate(-50%, -50%); /* Maintains center position */
    }
</style>
</head>
<body class="antialiased">



<div class="max-w-xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">Upcoming Events</h2>

    <div id="event-feed-container" class="space-y-6"></div>

    <div id="no-events-message" class="hidden text-center py-12 bg-white rounded-xl shadow-md">
        <p class="text-gray-500 text-lg">No upcoming events found.</p>
    </div>
</div>

<div id="modal-container">
    <div id="instant-success-popup-container" class="fixed inset-0 z-50 hidden">
    <div id="instant-success-popup-content" class="bg-emerald-600 text-white p-4 rounded-lg shadow-xl flex items-center space-x-2">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <p class="font-medium">Registered Successfully!</p>
    </div>
</div>
</div>

<script>
    // --- UTILITY FUNCTIONS ---

    function getRegisteredButtonHtml(isModal = false) {
        const text = isModal ? 'You Are Registered!' : 'Registered';
        
        return `
            <svg class="h-4 w-4 inline mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
            ${text}
        `;
    }

    function updateButtonToRegistered(buttonElement) {
        // Determine if it's the modal button (large) or card button (small)
        const isModalButton = buttonElement.innerHTML.includes('Register for Event');

        // Apply new styles
        buttonElement.disabled = true;
        buttonElement.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
        buttonElement.classList.add('bg-gray-400', 'cursor-not-allowed');

        // Update content
        buttonElement.innerHTML = getRegisteredButtonHtml(isModalButton);
    }
    
    function showRegisteredPopup() {
        const container = document.getElementById('instant-success-popup-container');
        if (container) {
            // Display container and add the class that triggers the opacity change via custom CSS
            container.classList.remove('hidden');
            
            // Force reflow to ensure CSS transition runs
            void container.offsetWidth; 
            container.classList.add('opacity-100');
            
            // Hide after 3 seconds
            setTimeout(() => {
                container.classList.remove('opacity-100');
                // Use a short delay before hiding completely to allow fade-out transition
                setTimeout(() => {
                    container.classList.add('hidden');
                }, 300); 
            }, 3000);
        }
    }


    // --- DATA HANDLING ---

    // Convert PHP $events array to JS
    const eventsData = <?= json_encode(array_map(function($event) {
        return [
            'id' => $event->id,
            'event_name' => $event->event_name,
            'location' => $event->location,
            'event_date' => $event->event_date,
            'event_time_duration' => $event->event_time_duration,
            'contact_person' => $event->contact_person,
            'description' => $event->description,
            'created_at' => $event->created_at ?? date('Y-m-d H:i:s'), 
            'is_registered' => $event->is_registered ?? false 
        ];
    }, $events)) ?>;

    function timeToEvent(dateString) {
        const now = new Date();
        const future = new Date(dateString);
        const seconds = Math.floor((future - now) / 1000);
        if (seconds < 0) return "Event already passed";

        let interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + " years away";
        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + " months away";
        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + " days away";
        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + " hours away";
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + " minutes away";
        return "Happening soon";
    }

    const filteredEvents = eventsData.filter(event => new Date(event.event_date) >= new Date());
    const eventContainer = document.getElementById('event-feed-container');
    const modalContainer = document.getElementById('modal-container');
    const noEventsMessage = document.getElementById('no-events-message');

    // --- RENDERING ---

    function renderEvents() {
        if (filteredEvents.length === 0) {
            noEventsMessage.classList.remove('hidden');
            return;
        }

        filteredEvents.forEach(event => {
            
            // --- Card Button HTML ---
            let cardButtonHtml;
            if (event.is_registered) {
                cardButtonHtml = `
                    <button id="card-btn-${event.id}" class="bg-gray-400 text-white font-bold py-2 px-4 rounded-lg cursor-not-allowed transition duration-150 shadow-md text-sm" disabled>
                        ${getRegisteredButtonHtml(false)}
                    </button>
                `;
            } else {
                cardButtonHtml = `
                    <button id="card-btn-${event.id}" onclick="event.stopPropagation(); handleRegistration(${event.id}, this)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 shadow-md text-sm">
                        Register Now
                    </button>
                `;
            }
            
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
                            </svg>${event.location}
                        </span>
                        <span title="Time Remaining" class="text-emerald-500 font-semibold">${timeToEvent(event.event_date)}</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed truncate">${event.description}</p>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                        ${cardButtonHtml}
                        <span class="text-sm font-semibold text-gray-500 hover:text-gray-600">View Details &rarr;</span>
                    </div>
                </div>
            `;
            eventContainer.insertAdjacentHTML('beforeend', cardHtml);

            const formattedDate = new Date(event.event_date).toLocaleString('en-US', {
                year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
            });

            // --- Modal Button HTML ---
            let modalButtonHtml;
            if (event.is_registered) {
                modalButtonHtml = `
                    <button id="modal-btn-${event.id}" class="bg-gray-400 text-white font-bold py-3 px-6 rounded-xl transition duration-150 shadow-lg text-base w-full sm:w-auto cursor-not-allowed" disabled>
                        ${getRegisteredButtonHtml(true)}
                    </button>
                `;
            } else {
                modalButtonHtml = `
                    <button id="modal-btn-${event.id}" onclick="handleRegistration(${event.id}, this); closeModal(${event.id})" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition duration-150 shadow-lg text-base w-full sm:w-auto">
                        Register for Event
                    </button>
                `;
            }
            
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
                            ${modalButtonHtml}
                        </div>
                    </div>
                </div>
            `;
            modalContainer.insertAdjacentHTML('beforeend', modalHtml);
        });
    }

    document.addEventListener('DOMContentLoaded', renderEvents);

    // --- EVENT HANDLERS ---

    function openModal(id) {
        const modal = document.getElementById('event-modal-' + id);
        if (modal) { modal.classList.remove('hidden'); modal.classList.add('flex'); }
    }
    function closeModal(id) {
        const modal = document.getElementById('event-modal-' + id);
        if (modal) { modal.classList.remove('flex'); modal.classList.add('hidden'); }
    }
    
    /**
     * Handles the registration click.
     * 1. Updates the button's appearance immediately to 'Registered'.
     * 2. Shows the instant pop-up.
     * 3. Triggers the server redirect after a short delay.
     * @param {number} id - Event ID.
     * @param {HTMLElement} buttonElement - The button that was clicked.
     */
    function handleRegistration(id, buttonElement) {
        // 1. Instant Visual Feedback: Change button and show pop-up
        updateButtonToRegistered(buttonElement); 
        showRegisteredPopup();

        // 2. Local State Update (Optional, but good practice)
        const eventIndex = filteredEvents.findIndex(e => e.id == id);
        if (eventIndex !== -1) {
             filteredEvents[eventIndex].is_registered = true;
        }

        // 3. Triggers the server action (which causes the page reload)
        // Delay ensures the visual update and pop-up animation start before redirect.
        setTimeout(() => {
            window.location.href = "<?= base_url('Events/register/') ?>" + id;
        }, 200); 
    }

    // Modal closing logic
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