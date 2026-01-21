<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #faf8f3;
            font-family: 'Inter', sans-serif;
        }
        
        .fade-in-up { 
            animation: fadeInUp 0.5s ease-out forwards; 
            opacity: 0; 
            transform: translateY(20px); 
        }
        @keyframes fadeInUp { 
            to { opacity: 1; transform: translateY(0); } 
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d4a574; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #b8860b; }
        .custom-scrollbar { scrollbar-width: thin; scrollbar-color: #d4a574 transparent; }

        .modal-backdrop, .modal-panel { transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); }
        
        /* Theme color variables */
        .text-primary { color: #8B1538; }
        .bg-primary { background-color: #8B1538; }
        .ring-primary { box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1); }
        .hover\:bg-primary-dark:hover { background-color: #6B0F2A; }
        .focus\:ring-primary:focus { box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.5); }
        .border-primary { border-color: #8B1538; }
    </style>
</head>
<body class="text-gray-800 antialiased">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2">
                        <span>🗓️</span> Previous Events
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Review details from our past workshops, hackathons, and networking events.</p>
                </div>
                <div class="text-right hidden sm:block">
                    <span id="total-counter" class="text-lg font-bold text-primary bg-yellow-50 px-4 py-2 rounded-lg border border-yellow-200 shadow-inner">
                        Loading...
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-5 mb-10">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 items-center">
                <div class="col-span-2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="search-input" placeholder="Search event name..." class="pl-10 w-full p-3 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent block" onkeyup="renderEvents()">
                </div>

                <div>
                    <select id="filter-type" class="w-full p-3 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" onchange="renderEvents()">
                        <option value="all">All Types</option>
                        <option value="workshop">Workshop</option>
                        <option value="networking">Networking</option>
                        <option value="hackathon">Hackathon</option>
                        <option value="conference">Conference</option>
                    </select>
                </div>

                <div>
                    <select id="filter-time" class="w-full p-3 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" onchange="renderEvents()">
                        <option value="all">Any Time</option>
                        <option value="last-month">Last 30 Days</option>
                        <option value="last-6-months">Last 6 Months</option>
                        <option value="last-year">Last Year</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button onclick="resetFilters()" class="w-full py-3 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 19M16 4h4.582M19 10V5h-.582"></path></svg>
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <div id="event-feed-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"></div>

        <div id="no-events-message" class="hidden text-center py-20 bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-50 mb-4 border border-red-200">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">No Events Found</h3>
            <p class="text-gray-600 mt-2">The current filters returned no matching results.</p>
            <button onclick="resetFilters()" class="mt-6 px-6 py-2.5 text-sm font-semibold text-white bg-primary rounded-lg hover:bg-primary-dark transition shadow-md hover:shadow-lg">
                Clear All Filters
            </button>
        </div>

        <div id="modal-container"></div>
    </div>

    <script>
        // Database events from PHP controller
        const eventsData = <?php echo json_encode($events ?? []); ?>;

        // Helper Functions
        function timeAgo(dateString) {
            const now = new Date();
            const past = new Date(dateString);
            const seconds = Math.floor((now - past) / 1000);
            const intervals = [
                { label: 'year', seconds: 31536000 },
                { label: 'month', seconds: 2592000 },
                { label: 'day', seconds: 86400 },
                { label: 'hour', seconds: 3600 },
                { label: 'minute', seconds: 60 }
            ];
            for (let i = 0; i < intervals.length; i++) {
                const interval = intervals[i];
                const count = Math.floor(seconds / interval.seconds);
                if (count >= 1) {
                    return count === 1 ? `1 ${interval.label} ago` : `${count} ${interval.label}s ago`;
                }
            }
            return "Just now";
        }

        function getEventStyle(type) {
            const styles = {
                workshop: { 
                    bg: "bg-yellow-100", text: "text-yellow-800", ring: "ring-yellow-500",
                    icon: `<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>`
                },
                networking: { 
                    bg: "bg-amber-100", text: "text-amber-800", ring: "ring-amber-500",
                    icon: `<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-5a1 1 0 00-1-1h-4a1 1 0 00-1 1v5zm-7-1h4a1 1 0 001-1v-4a1 1 0 00-1-1h-4a1 1 0 00-1 1v4a1 1 0 001 1zM2 10h4a1 1 0 001-1V5a1 1 0 00-1-1H2a1 1 0 00-1 1v4a1 1 0 001 1z"></path></svg>`
                },
                hackathon: { 
                    bg: "bg-red-100", text: "text-red-800", ring: "ring-red-500",
                    icon: `<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>`
                },
                conference: { 
                    bg: "bg-rose-100", text: "text-rose-800", ring: "ring-rose-500",
                    icon: `<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>`
                }
            };
            return styles[type] || { bg: "bg-gray-100", text: "text-gray-800", ring: "ring-gray-500", icon: "" };
        }

        // Main Render Logic
        const eventContainer = document.getElementById('event-feed-container');
        const modalContainer = document.getElementById('modal-container');
        const noEventsMessage = document.getElementById('no-events-message');
        const counterElement = document.getElementById('total-counter');

        function renderEvents() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const filterType = document.getElementById('filter-type').value;
            const filterTime = document.getElementById('filter-time').value;

            // Base Filter: Past events only
            let results = eventsData.filter(event => new Date(event.event_date) < new Date());

            // Text Search
            if (searchTerm) {
                results = results.filter(e => 
                    (e.event_name && e.event_name.toLowerCase().includes(searchTerm)) || 
                    (e.description && e.description.toLowerCase().includes(searchTerm))
                );
            }

            // Type Filter
            if (filterType !== 'all') {
                results = results.filter(e => e.event_type === filterType);
            }

            // Time Range Filter
            const now = new Date();
            if (filterTime !== 'all') {
                results = results.filter(e => {
                    const eDate = new Date(e.event_date);
                    const diffTime = Math.abs(now - eDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                    
                    if (filterTime === 'last-month') return diffDays <= 30;
                    if (filterTime === 'last-6-months') return diffDays <= 180;
                    if (filterTime === 'last-year') return diffDays <= 365;
                    return true;
                });
            }

            // Sorting (Newest first)
            results.sort((a, b) => {
                const dateA = new Date(a.event_date);
                const dateB = new Date(b.event_date);
                return dateB - dateA;
            });

            // Update UI
            eventContainer.innerHTML = '';
            modalContainer.innerHTML = '';
            counterElement.textContent = `${results.length} Event${results.length !== 1 ? 's' : ''}`;

            if (results.length === 0) {
                noEventsMessage.classList.remove('hidden');
            } else {
                noEventsMessage.classList.add('hidden');
                
                let delay = 0;

                results.forEach(event => {
                    const style = getEventStyle(event.event_type || 'workshop');
                    const dateObj = new Date(event.event_date);
                    const dateStr = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    
                    const cardHtml = `
                        <div class="fade-in-up group bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-xl transition-all duration-500 overflow-hidden flex flex-col h-full hover:ring-2 ${style.ring}/50 cursor-pointer" onclick="openModal(${event.id})" style="animation-delay: ${delay}ms">
                            <div class="h-40 w-full overflow-hidden relative bg-gray-200">
                                ${event.image_url ? `<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="${event.image_url}" alt="${event.event_name}" loading="lazy">` : '<div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300"></div>'}
                                <div class="absolute inset-0 bg-black/10"></div>
                            </div>

                            <div class="p-6 flex-grow">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${style.bg} ${style.text}">
                                        ${style.icon} ${(event.event_type || 'Event').charAt(0).toUpperCase() + (event.event_type || 'Event').slice(1)}
                                    </span>
                                    <span class="text-xs text-gray-600 font-medium">
                                        ${dateStr}
                                    </span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors mb-2 line-clamp-1" title="${event.event_name}">
                                    ${event.event_name}
                                </h3>
                                
                                <p class="text-gray-700 text-sm line-clamp-3 leading-relaxed mb-4">
                                    ${event.description || 'No description available'}
                                </p>
                                
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.727A8 8 0 0115.485 20.91a1.2 1.2 0 01-1.09-2.17l.03-.04A6 6 0 0113 10a6 6 0 00-6 6 6 6 0 00.515 2.273A8 8 0 1117.657 16.727z"></path></svg>
                                    <span class="line-clamp-1">${event.location || 'TBA'}</span>
                                </div>
                            </div>

                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                                <div class="flex items-center">
                                    ${event.organizer_avatar ? `<img class="h-8 w-8 rounded-full ring-2 ring-white" src="${event.organizer_avatar}" alt="">` : '<div class="h-8 w-8 rounded-full ring-2 ring-white bg-gray-300"></div>'}
                                    <div class="ml-3">
                                        <p class="text-xs font-medium text-gray-900">${event.contact_person || 'Organizer'}</p>
                                        <p class="text-[10px] text-gray-600">Event Host</p>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-primary group-hover:text-primary transition flex items-center">
                                    View Details <span aria-hidden="true" class="ml-1 text-lg">&rarr;</span>
                                </span>
                            </div>
                        </div>
                    `;
                    eventContainer.insertAdjacentHTML('beforeend', cardHtml);
                    createModal(event, style);
                    delay += 75;
                });
            }
        }

        function createModal(event, style) {
            const formattedDate = new Date(event.event_date).toLocaleString('en-US', { dateStyle: 'full', timeStyle: 'short' });
            
            const modalHtml = `
                <div id="modal-${event.id}" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0 modal-backdrop" onclick="closeModal(${event.id})"></div>

                    <div class="fixed inset-0 z-10 overflow-y-auto">
                        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                            <div class="relative transform rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl scale-95 opacity-0 modal-panel">
                                
                                <div class="h-48 overflow-hidden relative rounded-t-2xl bg-gray-200">
                                    ${event.image_url ? `<img class="w-full h-full object-cover" src="${event.image_url}" alt="${event.event_name}">` : '<div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300"></div>'}
                                    <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-sm font-bold shadow-lg ${style.bg} ${style.text}">
                                        ${(event.event_type || 'EVENT').toUpperCase()}
                                    </span>
                                </div>

                                <div class="bg-white px-6 pb-6 pt-5">
                                    <div class="flex justify-between items-start">
                                        <div class="w-full">
                                            <h3 class="text-2xl font-extrabold leading-tight text-gray-900 mb-1 mt-1">${event.event_name}</h3>
                                            <p class="text-sm text-gray-600 mb-6 flex items-center">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                ${formattedDate}
                                            </p>

                                            <h4 class="text-lg font-semibold text-gray-900 mb-2 border-b border-gray-200 pb-1">Summary</h4>
                                            <div class="text-sm text-gray-700 custom-scrollbar max-h-40 overflow-y-auto pr-2">
                                                <p class="whitespace-pre-wrap leading-relaxed">${event.description || 'No description available'}</p>
                                            </div>

                                            <h4 class="text-lg font-semibold text-gray-900 mb-4 mt-6 border-b border-gray-200 pb-1">Event Details</h4>
                                            <dl class="grid grid-cols-2 gap-x-6 gap-y-4 text-sm">
                                                <div>
                                                    <dt class="font-medium text-gray-900">Duration</dt>
                                                    <dd class="text-primary font-semibold mt-1">${event.event_time_duration || 'TBA'}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium text-gray-900">Location</dt>
                                                    <dd class="text-gray-700 mt-1">${event.location || 'TBA'}</dd>
                                                </div>
                                                <div class="col-span-2">
                                                    <dt class="font-medium text-gray-900 mb-2">Host & Information</dt>
                                                    <div class="flex items-center bg-gray-50 p-3 rounded-lg border border-gray-200">
                                                        ${event.organizer_avatar ? `<img class="h-10 w-10 rounded-full ring-2 ring-white" src="${event.organizer_avatar}" alt="">` : '<div class="h-10 w-10 rounded-full ring-2 ring-white bg-gray-300"></div>'}
                                                        <div class="ml-3">
                                                            <p class="text-sm font-semibold text-gray-900">${event.contact_person || 'Organizer'}</p>
                                                            <p class="text-xs text-gray-600">Event Host • Posted ${timeAgo(event.created_at)}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </dl>
                                        </div>
                                        <button onclick="closeModal(${event.id})" class="text-gray-500 hover:text-gray-700 ml-4 p-1 rounded-full bg-white hover:bg-gray-100 transition flex-shrink-0">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="bg-gray-50 px-6 py-4 sm:flex sm:px-6 border-t border-gray-200 rounded-b-2xl">
                                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-primary-dark transition sm:mt-0 sm:w-auto" onclick="closeModal(${event.id})">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            modalContainer.insertAdjacentHTML('beforeend', modalHtml);
        }

        // Interactive Logic
        function resetFilters() {
            document.getElementById('search-input').value = '';
            document.getElementById('filter-type').value = 'all';
            document.getElementById('filter-time').value = 'all';
            renderEvents();
        }

        function openModal(id) {
            const modal = document.getElementById(`modal-${id}`);
            if (!modal) return;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                modal.querySelector('.modal-backdrop').classList.remove('opacity-0');
                const panel = modal.querySelector('.modal-panel');
                panel.classList.remove('scale-95', 'opacity-0');
                panel.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(`modal-${id}`);
            if (!modal) return;
            
            const backdrop = modal.querySelector('.modal-backdrop');
            const panel = modal.querySelector('.modal-panel');
            
            backdrop.classList.add('opacity-0');
            panel.classList.remove('scale-100', 'opacity-100');
            panel.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="modal-"]:not(.hidden)').forEach(el => {
                    const id = el.id.replace('modal-', '');
                    closeModal(id);
                });
            }
        });

        document.addEventListener('DOMContentLoaded', renderEvents);
    </script>
</body>
</html>
