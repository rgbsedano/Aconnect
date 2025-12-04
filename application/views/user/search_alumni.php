<!--
    This file has been refactored using Tailwind CSS for a modern, wider layout
    and larger profile tiles, while strictly preserving the original PHP logic,
    database access calls, and JavaScript functionality.
-->
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* 🎨 TAILWIND CUSTOM CONFIG FOR BRANDING COLORS */
    :root {
        --primary-maroon: #700A0A; /* SDCA Primary Color */
    }
    .bg-maroon { background-color: var(--primary-maroon); }
    .text-maroon { color: var(--primary-maroon); }
    .border-maroon { border-color: var(--primary-maroon); }
    
    /* Global Styles & Font */
    body {
        font-family: 'Inter', sans-serif;
        /* Using Tailwind defaults for bg-gray-100 equivalent */
        background-color: #f3f4f6;
    }

    /* Modal Styling - necessary override for the look of the existing modal content */
    .modal-header-custom {
        background-color: var(--primary-maroon);
        color: white;
        border-top-left-radius: 0.75rem; /* rounded-xl */
        border-top-right-radius: 0.75rem; /* rounded-xl */
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-title-custom {
        font-weight: 700;
        font-size: 1.25rem;
    }
    .modal-body-custom {
        padding: 1.5rem;
    }
    .modal-content {
        border-radius: 0.75rem; /* rounded-xl */
    }
</style>

<script>
    // The original JavaScript is kept intact, relying on the preserved IDs and classes.
    document.addEventListener('DOMContentLoaded', function () {
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearch');
        const filterButtons = document.querySelectorAll('.btn-filter');
        const hiddenFilterInput = document.getElementById('filter_status');
        
        // --- Search Functionality ---
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                hiddenFilterInput.value = ''; 
                searchForm.submit();
            });
        }
        
        // --- Filter Functionality ---
        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const filterValue = this.getAttribute('data-filter');
                
                // Toggle logic
                if (this.classList.contains('bg-maroon')) {
                    hiddenFilterInput.value = '';
                } else {
                    hiddenFilterInput.value = filterValue;
                }
                
                searchInput.value = ''; 
                searchForm.submit();
            });
        });
        
        // --- Active Filter Class Persistence (Updated to use Tailwind class `bg-maroon`) ---
        const currentFilter = hiddenFilterInput.value;
        if (currentFilter !== null && currentFilter !== '') {
            filterButtons.forEach(button => {
                if (button.getAttribute('data-filter') === currentFilter) {
                    button.classList.add('bg-maroon', 'text-white');
                    button.classList.remove('bg-white', 'text-gray-700');
                } else {
                    button.classList.remove('bg-maroon', 'text-white');
                    button.classList.add('bg-white', 'text-gray-700');
                }
            });
        } else {
            // Default: 'All Alumni' is active
            const allAlumniBtn = document.querySelector('.btn-filter[data-filter=""]');
            if (allAlumniBtn) {
                allAlumniBtn.classList.add('bg-maroon', 'text-white');
                allAlumniBtn.classList.remove('bg-white', 'text-gray-700');
            }
        }
    });
</script>

<div class="min-h-screen p-4 sm:p-6 bg-gray-100">
    <div class="header-area max-w-4xl mx-auto mb-6">
        <!-- Section Header -->
        <h2 class="text-3xl font-extrabold text-gray-900 mb-1 flex items-center gap-3">
            <svg class="w-8 h-8 text-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2m0 2H7m10 0h3m-5.885-2.172a3 3 0 00-4.664 0m0 0H6a2 2 0 00-2 2v2m-2-2a2 2 0 002-2h4a2 2 0 002-2V9a2 2 0 00-2-2H8a2 2 0 00-2 2v3m0 0h12m-6 0h.01M12 7V5a2 2 0 012-2h2a2 2 0 012 2v2M8 7V5a2 2 0 00-2-2H4a2 2 0 00-2 2v2"></path></svg>
            Alumni Connect Feed
        </h2>
        <p class="text-gray-500 text-base border-b pb-4 mb-4">
            Connect with peers! Find alumni by name, degree, or ID below. Use the filters to view specific connection statuses.
        </p>

        <div class="search-filter-controls">
            <!-- Filter Buttons (Chips) -->
            <div class="filter-buttons flex flex-wrap gap-2 mb-4">
                <button class="btn-filter px-4 py-2 text-sm font-semibold rounded-full bg-white text-gray-700 shadow-sm transition hover:bg-gray-50 flex items-center gap-1" data-filter="">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h4a2 2 0 002-2v-1a2 2 0 012-2h2.945M8 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2h-4m-7 0a3 3 0 00-6 0h6zM12 7a3 3 0 00-6 0h6z"></path></svg> 
                    All Alumni
                </button>
                <button class="btn-filter px-4 py-2 text-sm font-semibold rounded-full bg-white text-gray-700 shadow-sm transition hover:bg-gray-50 flex items-center gap-1" data-filter="connected">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 
                    Connected
                </button>
                <button class="btn-filter px-4 py-2 text-sm font-semibold rounded-full bg-white text-gray-700 shadow-sm transition hover:bg-gray-50 flex items-center gap-1" data-filter="pending">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Requests Sent
                </button>
            </div>
            
            <!-- Wide Search Form -->
            <form method="get" class="flex gap-4 items-center" id="searchForm">
                <input type="hidden" name="filter_status" id="filter_status" value="<?= $this->input->get('filter_status') ?>">
                
                <div class="relative flex-grow">
                    <input type="text" name="search" id="searchInput" class="w-full p-3 pl-12 border border-gray-300 rounded-lg focus:ring-maroon focus:border-maroon shadow-md text-base" placeholder="Search alumni (e.g., Jane Doe, BSIT, 12345)..." value="<?= $this->input->get('search') ?>">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <?php if ($this->input->get('search')): ?>
                        <button type="button" id="clearSearch" class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700 text-2xl">
                            &times;
                        </button>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="bg-maroon hover:bg-red-800 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-150 flex-shrink-0 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> 
                    Find
                </button>
            </form>
        </div>
    </div>

    <!-- Alumni Feed Grid - Large Tiles -->
    <div class="alumni-grid max-w-4xl mx-auto grid grid-cols-1 gap-6">
        <?php if (!empty($alumni_list)): ?>
            <?php foreach ($alumni_list as $alumnus): ?>
                <?php 
                    $current_filter = $this->input->get('filter_status');
                    $display_alumnus = true;
                    
                    if (!empty($current_filter)) {
                        if ($current_filter === 'connected' && $alumnus->connection_status !== 'accepted') {
                            $display_alumnus = false;
                        } elseif ($current_filter === 'pending' && $alumnus->connection_status !== 'pending') {
                            $display_alumnus = false;
                        }
                    }

                    // --- Image Logic (Preserved) ---
                    $profileImage = base_url('assets/images/placeholder.png'); // Default generic placeholder
                    if ($alumnus && isset($alumnus->profile_image)) {
                        $profileImage = base_url('assets/uploads/alumni/' . $alumnus->profile_image);
                    } elseif (isset($alumnus->gender) && strtolower($alumnus->gender) === 'male') {
                        $profileImage = base_url('assets/images/person-male.png');
                    } elseif (isset($alumnus->gender) && strtolower($alumnus->gender) === 'female') {
                        $profileImage = base_url('assets/images/person-female.png');
                    }
                ?>
                
                <?php if ($display_alumnus): ?>
                    <div class="alumni-card bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 ease-in-out">
                        <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center">
                            
                            <!-- Profile Picture (Made Bigger) & Status -->
                            <div class="flex-shrink-0 text-center">
                                <div class="profile-image-thumb h-24 w-24 sm:h-28 sm:w-28 rounded-full overflow-hidden border-4 border-maroon mx-auto">
                                    <img src="<?= $profileImage ?>" alt="Profile Image" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://placehold.co/112x112/cccccc/333333?text=Profile'">
                                </div>
                                <div class="mt-2">
                                    <?php if (isset($alumnus->connection_status) && $alumnus->connection_status == 'accepted'): ?>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-500 text-white flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Connected
                                        </span>
                                    <?php elseif (isset($alumnus->connection_status) && $alumnus->connection_status == 'pending'): ?>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-400 text-gray-800 flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Pending
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Alumni Details & Summary -->
                            <div class="flex-grow w-full">
                                <h5 class="text-2xl font-bold text-gray-900 mb-1">
                                    <?= ucwords(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?>
                                </h5>
                                <p class="text-maroon font-semibold mb-3">
                                    <?= $alumnus->degree ?: 'No Degree Listed' ?>
                                </p>
                                
                                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm text-gray-700">
                                    <p><strong>Job:</strong> <span class="text-gray-900"><?= !empty($alumnus->current_job) ? $alumnus->current_job : 'N/A' ?></span></p>
                                    <p><strong>Org:</strong> <span class="text-gray-900"><?= !empty($alumnus->current_job_organization) ? $alumnus->current_job_organization : 'N/A' ?></span></p>
                                    <p><strong>Year:</strong> <span class="text-gray-900"><?= $alumnus->graduation_year ?: 'N/A' ?></span></p>
                                    <p class="col-span-2"><strong>Skills:</strong> <span class="text-gray-900"><?= !empty($alumnus->technical_skills) ? substr($alumnus->technical_skills, 0, 70) . (strlen($alumnus->technical_skills) > 70 ? '...' : '') : 'N/A' ?></span></p>
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col sm:flex-row gap-3">
                                    <!-- Action Buttons -->
                                    <button type="button" class="flex-1 px-4 py-2 text-white font-semibold rounded-lg shadow-md bg-gray-500 hover:bg-gray-600 transition duration-150 flex items-center justify-center gap-2" data-toggle="modal" data-target="#viewProfileModal<?= $alumnus->id ?>">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v10a2 2 0 002 2h5m0-16h8a2 2 0 012 2v10a2 2 0 01-2 2h-8m-5-8a2 2 0 11-4 0 2 2 0 014 0zM17 6h.01"></path></svg>
                                        View Profile
                                    </button>

                                    <?php if (isset($alumnus->connection_status) && $alumnus->connection_status !== 'accepted' && $alumnus->connection_status !== 'pending'): ?>
                                        <form method="post" action="<?= site_url('alumni/send_request') ?>" class="flex-1" style="flex-grow: 1;">
                                            <input type="hidden" name="receiver_id" value="<?= $alumnus->id ?>">
                                            <button type="submit" class="w-full px-4 py-2 text-white font-semibold rounded-lg shadow-md bg-green-600 hover:bg-green-700 transition duration-150 flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v2.5m0 0h6m6-6v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2h10a2 2 0 012 2z"></path></svg>
                                                Connect
                                            </button>
                                        </form>
                                    <?php elseif (isset($alumnus->connection_status) && $alumnus->connection_status == 'accepted'): ?>
                                        <button type="button" class="flex-1 px-4 py-2 text-white font-semibold rounded-lg shadow-md bg-blue-600 hover:bg-blue-700 transition duration-150 flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.78A9.957 9.957 0 0112 4c4.97 0 9 3.582 9 8z"></path></svg>
                                            Message
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="flex-1 px-4 py-2 text-gray-700 font-semibold rounded-lg shadow-md bg-gray-200 cursor-not-allowed flex items-center justify-center gap-2" disabled>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Request Sent
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Modal (Kept external structure but styled header) -->
                    <div class="modal fade" id="viewProfileModal<?= $alumnus->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header modal-header-custom">
                                    <h5 class="modal-title modal-title-custom" id="viewProfileModalLabel">
                                        <?= ucwords(strtolower($alumnus->first_name . ' ' . $alumnus->last_name)) ?>
                                    </h5>
                                    <!-- The close button requires Bootstrap's JS handling (data-dismiss="modal") -->
                                    <button type="button" class="close text-white text-3xl font-light hover:opacity-75 transition" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                
                                <!-- Modal Body -->
                                <div class="modal-body modal-body-custom">
                                    <div class="flex flex-col md:flex-row gap-6">
                                        <!-- Left Column (Profile Summary) -->
                                        <div class="md:w-1/3 text-center mb-4 md:mb-0">
                                            <div class="profile-image-container mb-4">
                                                <!-- Increased profile picture size inside modal -->
                                                <img src="<?= $profileImage ?>" alt="Profile Image" class="rounded-full w-32 h-32 object-cover mx-auto border-4 border-gray-300" onerror="this.onerror=null; this.src='https://placehold.co/128x128/cccccc/333333?text=Profile'">
                                            </div>
                                            <p class="text-lg font-bold text-gray-800 mb-0">
                                                <?= $alumnus->degree ?: 'N/A' ?>
                                            </p>
                                            <p class="text-gray-500 text-sm">Graduated: <?= $alumnus->graduation_year ?: 'N/A' ?></p>
                                        </div>
                                        
                                        <!-- Right Column (Details) -->
                                        <div class="md:w-2/3 space-y-4">
                                            <div class="border-b pb-2">
                                                <h6 class="text-lg font-bold text-maroon">Contact & ID</h6>
                                                <p><span class="font-semibold">Alumni ID:</span> <?= !empty($alumnus->alumni_number) ? $alumnus->alumni_number : 'N/A' ?></p>
                                                <p><span class="font-semibold">Email:</span> <?= !empty($alumnus->email) ? $alumnus->email : 'N/A' ?></p>
                                                <p><span class="font-semibold">Phone:</span> <?= !empty($alumnus->phone) ? $alumnus->phone : 'N/A' ?></p>
                                            </div>

                                            <div class="border-b pb-2">
                                                <h6 class="text-lg font-bold text-maroon">Employment</h6>
                                                <p><span class="font-semibold">Job Title:</span> <?= !empty($alumnus->current_job) ? $alumnus->current_job : 'N/A' ?></p>
                                                <p><span class="font-semibold">Organization:</span> <?= !empty($alumnus->current_job_organization) ? $alumnus->current_job_organization : 'N/A' ?></p>
                                                <p><span class="font-semibold">Job Duration:</span> <?= !empty($alumnus->current_job_length) ? $alumnus->current_job_length : 'N/A' ?></p>
                                            </div>

                                            <div>
                                                <h6 class="text-lg font-bold text-maroon">Skills & Location</h6>
                                                <p><span class="font-semibold">Technical Skills:</span> <?= !empty($alumnus->technical_skills) ? $alumnus->technical_skills : 'N/A' ?></p>
                                                <p><span class="font-semibold">Location:</span> <?= !empty($alumnus->current_address) ? $alumnus->current_address : 'N/A' ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Modal Footer -->
                                <div class="modal-footer p-4 bg-gray-50 flex justify-end rounded-b-xl">
                                    <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alumni-card bg-white p-8 rounded-xl shadow-lg">
                <div class="flex items-center justify-center text-center text-gray-500">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">No alumni found matching your criteria. Try adjusting your search or filters.</span>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>