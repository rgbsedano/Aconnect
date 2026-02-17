<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-red: #BE123C;
            --brand-gold: #D97706;
            --surface-gold: #FFFBEB;
        }

        body { 
            background-color: #F8FAFC;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Grid Pattern Background */
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
            border-color: var(--brand-gold);
            box-shadow: 0 12px 24px -10px rgba(190, 18, 60, 0.1);
        }

        .modal-overlay {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: none;
        }

        .modal-overlay.active {
            display: flex;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        /* Animation for list entry */
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
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Past Events <span class="text-rose-700">Archive</span></h1>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">Company Portfolio 2025</p>
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
                <input type="text" id="search-input" onkeyup="renderEvents()" placeholder="Filter by event title or keywords..." class="w-full py-3 bg-transparent outline-none text-sm font-medium">
            </div>
            <div class="flex flex-wrap md:flex-nowrap gap-2 p-1">
                <select id="filter-type" onchange="renderEvents()" class="bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none focus:ring-2 focus:ring-rose-700/20 cursor-pointer">
                    <option value="all">Category: All</option>
                    <option value="workshop">Workshop</option>
                    <option value="networking">Networking</option>
                    <option value="hackathon">Hackathon</option>
                    <option value="conference">Conference</option>
                </select>
                <select id="filter-time" onchange="renderEvents()" class="bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none focus:ring-2 focus:ring-rose-700/20 cursor-pointer">
                    <option value="all">Time: Any</option>
                    <option value="last-month">Last 30 Days</option>
                    <option value="last-year">Last Year</option>
                </select>
                <button onclick="resetFilters()" class="bg-rose-700 text-white text-xs font-bold px-6 py-2 rounded-xl hover:bg-rose-800 transition shadow-md shadow-rose-100">Search</button>
            </div>
        </div>

        <div id="event-feed-container" class="space-y-4"></div>

        <div id="no-events-message" class="hidden text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
            <h3 class="text-lg font-bold text-slate-900">No matching events found</h3>
            <p class="text-slate-500 text-sm mt-1">Try adjusting your filters or search terms.</p>
        </div>
    </main>

    <div id="modal-container"></div>

    <script>
        const eventsData = <?php echo json_encode($events ?? []); ?>;

        function renderEvents() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const filterType = document.getElementById('filter-type').value;
            const filterTime = document.getElementById('filter-time').value;

            let results = eventsData.filter(event => new Date(event.event_date) < new Date());

            if (searchTerm) {
                results = results.filter(e => e.event_name.toLowerCase().includes(searchTerm) || (e.description && e.description.toLowerCase().includes(searchTerm)));
            }
            if (filterType !== 'all') {
                results = results.filter(e => e.event_type === filterType);
            }

            results.sort((a, b) => new Date(b.event_date) - new Date(a.event_date));

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
                             style="animation-delay: ${idx * 40}ms"
                             onclick="openModal(${event.id})">
                            
                            <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 bg-slate-100 border border-slate-200">
                                ${event.image ? `<img src="<?= base_url('assets/uploads/events/') ?>${event.image}" class="w-full h-full object-cover">` : `<div class="w-full h-full flex items-center justify-center text-rose-700 font-bold">${event.event_name.charAt(0)}</div>`}
                            </div>

                            <div class="flex-grow">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-600">${event.event_type || 'Event'}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    <span class="text-xs font-medium text-slate-500">${dateStr}</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-rose-700">${event.event_name}</h3>
                                <div class="flex items-center gap-4 mt-2">
                                    <div class="flex items-center gap-1 text-slate-500 text-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.727L12 21l-5.657-4.273A8 8 0 1117.657 16.727z"/></svg>
                                        ${event.location || 'Remote'}
                                    </div>
                                    <div class="flex items-center gap-1 text-slate-500 text-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        ${event.event_time_duration || 'All Day'}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0 border-slate-50">
                                <button class="flex-grow md:flex-grow-0 bg-white border border-slate-200 text-slate-700 text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-slate-50 transition">View Details</button>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', card);
                    generateModal(event);
                });
            }
        }

        function generateModal(event) {
            const html = `
                <div id="modal-${event.id}" class="modal-overlay fixed inset-0 z-50 p-4 items-center justify-center" onclick="closeModal(${event.id})">
                    <div class="bg-white w-full max-w-2xl rounded-3xl overflow-hidden shadow-2xl transition-all scale-100" onclick="event.stopPropagation()">
                        ${event.image ? 
                            `<div class="w-full h-48 overflow-hidden"><img src="<?= base_url('assets/uploads/events/') ?>${event.image}" class="w-full h-full object-cover"></div>` :
                            `<div class="h-32 bg-rose-700 relative">
                                <div class="absolute -bottom-8 left-8 w-20 h-20 rounded-2xl bg-white p-1 shadow-xl">
                                    <div class="w-full h-full rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center font-bold text-rose-700 text-2xl">
                                        ${event.event_name.charAt(0)}
                                    </div>
                                </div>
                            </div>`
                        }
                        <div class="p-8 ${event.image ? 'pt-6' : 'pt-12'}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-2xl font-extrabold text-slate-900">${event.event_name}</h2>
                                    <p class="text-amber-600 font-bold text-sm uppercase tracking-wider mt-1">${event.event_type}</p>
                                </div>
                                <button onclick="closeModal(${event.id})" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-8">
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Date & Time</p>
                                    <p class="text-sm font-bold text-slate-700 mt-1">${new Date(event.event_date).toDateString()}</p>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Location</p>
                                    <p class="text-sm font-bold text-slate-700 mt-1">${event.location || 'Not Specified'}</p>
                                </div>
                            </div>

                            <div class="mt-8">
                                <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">Event Overview</h4>
                                <div class="text-slate-600 text-sm leading-relaxed custom-scrollbar max-h-48 overflow-y-auto">
                                    ${event.description || 'No detailed description available for this past event.'}
                                </div>
                            </div>

                            <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-[10px] font-bold">
                                        ${(event.contact_person || 'A').charAt(0)}
                                    </div>
                                    <p class="text-xs font-bold text-slate-700">${event.contact_person || 'Admin'}</p>
                                </div>
                                <button onclick="closeModal(${event.id})" class="bg-rose-700 text-white text-xs font-bold px-8 py-3 rounded-xl hover:bg-rose-800 transition">Close Archive</button>
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
            document.getElementById('filter-time').value = 'all';
            renderEvents();
        }

        document.addEventListener('DOMContentLoaded', renderEvents);
    </script>
</body>
</html>