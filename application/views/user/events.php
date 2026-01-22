<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-red: #BE123C;
            --brand-gold: #D97706;
        }

        body { 
            background-color: #F8FAFC;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Job Board Pattern Background */
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }

        .job-card {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
        }

        .job-card:hover {
            transform: translateY(-4px);
            border-color: #D97706;
            box-shadow: 0 12px 24px -10px rgba(190, 18, 60, 0.1);
        }

        .modal-overlay {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            z-index: 50;
        }

        .modal-overlay.active {
            display: flex;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-list { animation: slideUp 0.4s ease-out forwards; }
    </style>
</head>
<body class="bg-pattern text-slate-900 antialiased">

    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-rose-700 rounded-xl flex items-center justify-center shadow-lg shadow-rose-200">
                    <svg class="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7 2a2 2 0 00-2 2v1h10V4a2 2 0 00-2-2H7zM5 7a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2V9a2 2 0 00-2-2H5z"/></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Upcoming <span class="text-rose-700">Events</span></h1>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">Opportunities Portal 2026</p>
                </div>
            </div>
            <div id="total-counter" class="bg-amber-50 text-amber-700 px-3 py-1 rounded-full text-xs font-bold border border-amber-200">
                0 Events
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-12">
        
        <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200 mb-12 flex flex-col md:flex-row gap-2">
            <div class="flex-grow flex items-center px-4 gap-3 border-r border-slate-100">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="search-input" onkeyup="renderEvents()" placeholder="Search events, workshops, or topics..." class="w-full py-3 bg-transparent outline-none text-sm font-medium">
            </div>
            <div class="flex flex-wrap md:flex-nowrap gap-2 p-1">
                <select id="filter-type" onchange="renderEvents()" class="bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none focus:ring-2 focus:ring-rose-700/20 cursor-pointer">
                    <option value="all">All Categories</option>
                    <option value="workshop">Workshop</option>
                    <option value="networking">Networking</option>
                    <option value="hackathon">Hackathon</option>
                    <option value="conference">Conference</option>
                </select>
                <select id="sort-order" onchange="renderEvents()" class="bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none focus:ring-2 focus:ring-rose-700/20 cursor-pointer">
                    <option value="closest">Soonest First</option>
                    <option value="farthest">Latest First</option>
                </select>
                <button onclick="resetFilters()" class="bg-rose-700 text-white text-xs font-bold px-6 py-2 rounded-xl hover:bg-rose-800 transition shadow-md shadow-rose-100">Reset</button>
            </div>
        </div>

        <div id="event-feed-container" class="space-y-4"></div>

        <div id="no-events-message" class="hidden text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">No upcoming events found</h3>
            <p class="text-slate-500 text-sm mt-1">Try adjusting your filters or check back later.</p>
        </div>
    </main>

    <div id="modal-container"></div>

    <script>
        const eventsData = <?php echo json_encode($events ?? []); ?>;

        function timeUntil(dateString) {
            const now = new Date();
            const future = new Date(dateString);
            const diff = future - now;
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            if (days === 0) return "Starting Today";
            if (days === 1) return "Starts Tomorrow";
            return `In ${days} days`;
        }

        function renderEvents() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const filterType = document.getElementById('filter-type').value;
            const sortOrder = document.getElementById('sort-order').value;

            let results = eventsData.filter(event => new Date(event.event_date) > new Date());

            if (searchTerm) {
                results = results.filter(e => e.event_name.toLowerCase().includes(searchTerm) || (e.description && e.description.toLowerCase().includes(searchTerm)));
            }
            if (filterType !== 'all') {
                results = results.filter(e => e.event_type === filterType);
            }

            results.sort((a, b) => {
                const dateA = new Date(a.event_date);
                const dateB = new Date(b.event_date);
                return sortOrder === 'closest' ? dateA - dateB : dateB - dateA;
            });

            const container = document.getElementById('event-feed-container');
            const noEvents = document.getElementById('no-events-message');
            container.innerHTML = '';
            document.getElementById('total-counter').textContent = `${results.length} Events Found`;

            if (results.length === 0) {
                noEvents.classList.remove('hidden');
            } else {
                noEvents.classList.add('hidden');
                results.forEach((event, idx) => {
                    const date = new Date(event.event_date);
                    const dateStr = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    
                    const card = `
                        <div class="job-card bg-white p-5 rounded-2xl flex flex-col md:flex-row items-start md:items-center gap-6 cursor-pointer animate-list" 
                             style="animation-delay: ${idx * 50}ms"
                             onclick="openModal(${event.id})">
                            
                            <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 bg-slate-100 border border-slate-200">
                                ${event.image_url ? `<img src="${event.image_url}" class="w-full h-full object-cover">` : `<div class="w-full h-full flex items-center justify-center text-rose-700 font-bold text-xl">${event.event_name.charAt(0)}</div>`}
                            </div>

                            <div class="flex-grow">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-600">${event.event_type || 'General'}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    <span class="text-xs font-bold text-rose-700">${timeUntil(event.event_date)}</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-rose-700">${event.event_name}</h3>
                                <div class="flex items-center gap-4 mt-2">
                                    <div class="flex items-center gap-1 text-slate-500 text-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        ${dateStr}
                                    </div>
                                    <div class="flex items-center gap-1 text-slate-500 text-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.727L12 21l-5.657-4.273A8 8 0 1117.657 16.727z"/></svg>
                                        ${event.location || 'Remote'}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0 border-slate-50">
                                <form action="<?= base_url('events/register/') ?>${event.id}" method="post" class="w-full md:w-auto" onclick="event.stopPropagation()">
                                    <button type="submit" class="w-full bg-rose-700 text-white text-xs font-bold px-6 py-2.5 rounded-xl hover:bg-rose-800 transition shadow-md shadow-rose-100">Register Now</button>
                                </form>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', card);
                    generateModal(event);
                });
            }
        }

        function generateModal(event) {
            const formattedDate = new Date(event.event_date).toLocaleString('en-US', { dateStyle: 'full', timeStyle: 'short' });
            const html = `
                <div id="modal-${event.id}" class="modal-overlay fixed inset-0 items-center justify-center p-4" onclick="closeModal(${event.id})">
                    <div class="bg-white w-full max-w-2xl rounded-3xl overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
                        <div class="h-32 bg-rose-700 relative">
                            <div class="absolute -bottom-8 left-8 w-20 h-20 rounded-2xl bg-white p-1 shadow-xl">
                                <div class="w-full h-full rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center font-bold text-rose-700 text-2xl">
                                    ${event.image_url ? `<img src="${event.image_url}" class="w-full h-full object-cover">` : event.event_name.charAt(0)}
                                </div>
                            </div>
                        </div>
                        <div class="p-8 pt-12">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-2xl font-extrabold text-slate-900 leading-tight">${event.event_name}</h2>
                                    <p class="text-amber-600 font-bold text-sm uppercase tracking-wider mt-1">${event.event_type}</p>
                                </div>
                                <button onclick="closeModal(${event.id})" class="text-slate-400 hover:text-slate-600 bg-slate-50 p-2 rounded-full"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-8">
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">When</p>
                                    <p class="text-sm font-bold text-slate-700 mt-1">${formattedDate}</p>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Where</p>
                                    <p class="text-sm font-bold text-slate-700 mt-1">${event.location || 'TBA'}</p>
                                </div>
                            </div>

                            <div class="mt-8">
                                <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">Description</h4>
                                <div class="text-slate-600 text-sm leading-relaxed custom-scrollbar max-h-40 overflow-y-auto">
                                    ${event.description || 'Join us for this upcoming session. Detailed agenda will be shared shortly.'}
                                </div>
                            </div>

                            <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200">
                                        ${(event.contact_person || 'O').charAt(0)}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-700">${event.contact_person || 'Organizer'}</p>
                                        <p class="text-[10px] text-slate-500 font-medium">Event Host</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <button onclick="closeModal(${event.id})" class="px-6 py-3 text-xs font-bold text-slate-600 bg-slate-50 rounded-xl hover:bg-slate-100 transition">Close</button>
                                    <form action="<?= base_url('events/register/') ?>${event.id}" method="post">
                                        <button type="submit" class="bg-rose-700 text-white text-xs font-bold px-8 py-3 rounded-xl hover:bg-rose-800 transition shadow-lg shadow-rose-100">Confirm Registration</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('modal-container').insertAdjacentHTML('beforeend', html);
        }

        function openModal(id) {
            document.getElementById(`modal-${id}`).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(`modal-${id}`).classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function resetFilters() {
            document.getElementById('search-input').value = '';
            document.getElementById('filter-type').value = 'all';
            document.getElementById('sort-order').value = 'closest';
            renderEvents();
        }

        document.addEventListener('DOMContentLoaded', renderEvents);
    </script>
</body>
</html>