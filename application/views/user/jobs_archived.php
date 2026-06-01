<?php
    $savedJobsData = isset($saved_jobs) && is_array($saved_jobs) ? $saved_jobs : [];
    $appliedJobsData = isset($applied_jobs) && is_array($applied_jobs) ? $applied_jobs : [];
    $interviewJobsData = isset($interview_jobs) && is_array($interview_jobs) ? $interview_jobs : [];

    $uniqueAppliedJobs = [];
    $seenAppliedIds = [];
    foreach ($appliedJobsData as $job) {
        $jobId = isset($job->id) ? (int) $job->id : 0;
        if ($jobId > 0 && !isset($seenAppliedIds[$jobId])) {
            $seenAppliedIds[$jobId] = true;
            $uniqueAppliedJobs[] = $job;
        }
    }
    $appliedJobsData = $uniqueAppliedJobs;

    $savedCount = count($savedJobsData);
    $appliedCount = count($appliedJobsData);
    $interviewCount = count($interviewJobsData);
?>

<style>
    :root {
        --maroon: #a12124;
        --maroon-dark: #7d181b;
        --gold: #D4A574;
        --bg: #FAFAF8;
        --card: #ffffff;
        --text: #1F2937;
        --muted: #6B7280;
        --border: #E5E7EB;
        --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    }

    .myjobs-wrap {
        max-width: 980px;
        margin: 20px auto 40px;
        padding: 32px;
        background: var(--card);
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        color: var(--text);
    }

    .myjobs-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 1.5px solid var(--border);
        background: var(--card);
        color: #4b5563;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0;
        font-size: 18px;
        flex-shrink: 0;
        order: 2;
    }

    .btn-back:hover {
        background: #f9f9f9;
        border-color: var(--muted);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .myjobs-title {
        margin: 0;
        font-size: 56px;
        line-height: 1.1;
        font-weight: 800;
        letter-spacing: -1.2px;
        color: var(--text);
        order: 1;
    }

    .title-my {
        color: #000000;
        font-size: 2.5rem;
        font-weight: 900;
        letter-spacing: -0.025em;
        line-height: 1;
    }

    .title-jobs {
        color: #881337;
        font-size: 2.5rem;
        font-weight: 900;
        letter-spacing: -0.025em;
        line-height: 1;
    }

    .myjobs-tabs {
        display: flex;
        gap: 28px;
        border-bottom: 2px solid var(--border);
        margin-bottom: 24px;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        padding-bottom: 0;
    }

    .myjobs-tabs::-webkit-scrollbar {
        display: none;
    }

    .tab-link {
        display: inline-block;
        text-decoration: none;
        color: var(--muted);
        padding: 12px 0;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 600;
        position: relative;
        background: none;
        border-top: none;
        border-left: none;
        border-right: none;
        cursor: pointer;
    }

    .tab-link:hover {
        color: var(--text);
    }

    .tab-link .tab-count {
        font-weight: 700;
        margin-right: 4px;
        color: var(--maroon);
    }

    .tab-link.active {
        color: var(--text);
        border-bottom-color: var(--maroon);
    }

    .tab-link.active .tab-count {
        color: var(--maroon);
    }

    .myjobs-controls {
        display: flex;
        justify-content: flex-start;
        width: 100%;
        margin-bottom: 20px;
    }

    .search-box {
        position: relative;
        width: 100%;
        max-width: 520px;
    }

    .search-box i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 14px;
        pointer-events: none;
    }

    .search-box input {
        width: 100%;
        padding: 13px 16px 13px 44px;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        background: #f8fafb;
        color: #111827;
        font-size: 14px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--maroon);
        box-shadow: 0 0 0 3px rgba(161, 33, 36, 0.12);
        background: #ffffff;
    }

    .search-box input::placeholder {
        color: #9ca3af;
        opacity: 1;
    }

    .pagination-wrap {
        display: flex;
        justify-content: center;
        padding: 16px 0 0;
    }

    .pagination-controls {
        display: inline-flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .pagination-btn {
        border: 1px solid #d1d5db;
        background: #fff;
        color: #374151;
        padding: 8px 12px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 13px;
        min-width: 48px;
    }

    .pagination-btn:hover:not(:disabled) {
        border-color: var(--maroon);
        color: var(--maroon);
    }

    .pagination-btn.active {
        background: var(--maroon);
        color: white;
        border-color: var(--maroon);
    }

    .pagination-btn.active:hover {
        background: var(--maroon);
        color: white;
        border-color: var(--maroon);
    }

    .pagination-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    .myjobs-section {
        display: none;
    }

    .myjobs-section.active {
        display: block;
    }

    .jobs-list {
        display: flex;
        flex-direction: column;
        gap: 0;
        background: var(--bg);
    }

    .job-row {
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: center;
        gap: 14px;
        padding: 16px 0;
        border-bottom: 1px solid var(--border);
        transition: all 0.2s ease;
    }

    .job-row:hover {
        background: #fafaf8;
        padding-left: 12px;
        padding-right: 12px;
        margin-left: -12px;
        margin-right: -12px;
        border-radius: 8px;
    }

    .job-row:last-child {
        border-bottom: none;
    }

    .job-logo {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .job-main {
        flex: 1;
    }

    .job-main h3 {
        margin: 0 0 6px 0;
        font-size: 15px;
        line-height: 1.4;
        font-weight: 700;
        color: var(--text);
    }

    .job-main h3:hover {
        color: #0a66c2;
        text-decoration: underline;
        cursor: pointer;
    }

    .job-main p {
        margin: 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.3;
    }

    .job-company {
        color: #374151;
        font-weight: 600;
        display: inline;
    }

    .job-location {
        display: inline;
        margin-left: 0;
    }

    .job-location::before {
        content: " • ";
        margin: 0 4px;
        color: #d1d5db;
    }

    .job-meta {
        color: #9ca3af;
        font-size: 12px;
        margin-top: 4px;
    }

    .job-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-apply-now {
        border: none;
        background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn-apply-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(161, 33, 36, 0.2);
    }

    .action-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: var(--card);
        color: var(--muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .action-icon:hover {
        background: #f9f9f9;
        border-color: var(--maroon);
        color: var(--maroon);
    }

    .empty-state {
        text-align: center;
        border: 2px dashed var(--border);
        border-radius: 12px;
        padding: 60px 20px;
        background: #fafaf8;
        color: var(--muted);
    }

    .empty-state i {
        font-size: 48px;
        color: #c7d2e0;
        margin-bottom: 16px;
        display: block;
    }

    .empty-state p {
        margin: 0;
        font-size: 15px;
        line-height: 1.5;
    }

    .empty-state .title {
        font-weight: 700;
        font-size: 18px;
        color: var(--text);
        margin-bottom: 8px;
    }

    .empty-state .subtitle {
        color: var(--muted);
        margin-bottom: 20px;
    }

    .empty-state .cta {
        margin-top: 24px;
    }

    .empty-state a {
        color: var(--maroon);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .empty-state a:hover {
        color: var(--maroon-dark);
        text-decoration: underline;
    }

    @media (max-width: 900px) {
        .myjobs-wrap {
            margin: 16px auto 32px;
            padding: 20px;
        }

        .myjobs-header {
            margin-bottom: 20px;
        }

        .myjobs-title,
        .title-my,
        .title-jobs {
            font-size: 60px;
            font-weight: 900;
            letter-spacing: -0.025em;
            line-height: 1;
        }

        .job-row {
            grid-template-columns: auto 1fr;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
        }

        .job-row:hover {
            padding-left: 8px;
            padding-right: 8px;
            margin-left: -8px;
            margin-right: -8px;
        }

        .job-actions {
            grid-column: 1 / -1;
            margin-left: 56px;
            margin-top: 8px;
        }

        .job-main h3 {
            font-size: 14px;
        }

        .job-main p {
            font-size: 12px;
        }

        .btn-apply-now {
            font-size: 11px;
            padding: 6px 12px;
        }

        .tab-link {
            font-size: 13px;
            padding: 10px 0;
        }
    }

    @media (max-width: 576px) {
        .myjobs-wrap {
            margin: 12px auto 24px;
            padding: 16px;
            border-radius: 12px;
        }

        .myjobs-header {
            gap: 10px;
            margin-bottom: 16px;
        }

        .btn-back {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .myjobs-title,
        .title-my,
        .title-jobs {
            font-size: 52px;
            font-weight: 900;
            letter-spacing: -0.025em;
            line-height: 1;
        }

        .myjobs-tabs {
            gap: 16px;
            margin-bottom: 20px;
        }

        .tab-link {
            font-size: 12px;
            padding: 8px 0;
        }

        .job-row {
            gap: 8px;
            padding: 10px 0;
        }

        .job-row:hover {
            padding-left: 6px;
            padding-right: 6px;
            margin-left: -6px;
            margin-right: -6px;
        }

        .job-logo {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }

        .job-main h3 {
            font-size: 13px;
        }

        .job-main p {
            font-size: 11px;
        }

        .job-actions {
            gap: 6px;
            margin-left: 46px;
        }

        .action-icon {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }

        .btn-apply-now {
            font-size: 10px;
            padding: 5px 10px;
        }

        .empty-state {
            padding: 40px 12px;
        }

        .empty-state i {
            font-size: 40px;
            margin-bottom: 12px;
        }

        .empty-state .title {
            font-size: 16px;
        }

        .empty-state p {
            font-size: 13px;
        }
    }
</style>

<div class="myjobs-wrap">
    <div class="myjobs-header">
        <button class="btn-back" onclick="window.history.back()" aria-label="Go back" title="Return to previous page">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h1 class="myjobs-title"><span class="title-my">My</span> <span class="title-jobs">Jobs</span></h1>
    </div>

    <div class="myjobs-tabs">
        <button type="button" class="tab-link" data-tab="saved">
            <span class="tab-count" id="count-saved"><?= (int) $savedCount ?></span> Saved
        </button>
        <button type="button" class="tab-link" data-tab="applied">
            <span class="tab-count" id="count-applied"><?= (int) $appliedCount ?></span> Applied
        </button>
        <button type="button" class="tab-link" data-tab="interviews">
            <span class="tab-count" id="count-interviews"><?= (int) $interviewCount ?></span> Interviews
        </button>
        <button type="button" class="tab-link active" data-tab="archived">
            <span class="tab-count" id="count-archived">0</span> Archived
        </button>
    </div>

    <div class="myjobs-controls">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input id="myjobs-search" type="search" placeholder="Search jobs by title, company, or location" aria-label="Search jobs">
        </div>
    </div>

    <section id="section-saved" class="myjobs-section">
        <div id="saved-list" class="jobs-list"></div>
        <div id="saved-pagination" class="pagination-wrap"></div>
    </section>

    <section id="section-applied" class="myjobs-section">
        <div id="applied-list" class="jobs-list"></div>
        <div id="applied-pagination" class="pagination-wrap"></div>
    </section>

    <section id="section-interviews" class="myjobs-section">
        <?php if (!empty($interviewJobsData)): ?>
            <div class="jobs-list">
            <?php foreach ($interviewJobsData as $job): ?>
                    <article class="job-row">
                        <div class="job-logo">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="job-main">
                            <h3><?= htmlspecialchars($job->job_title ?? 'Untitled Role') ?></h3>
                            <p><span class="job-company"><?= htmlspecialchars($job->company ?? 'Unknown Company') ?></span><span class="job-location"><?= htmlspecialchars($job->location ?? 'Location not set') ?></span></p>
                            <div class="job-meta">Interview</div>
                        </div>
                        <div class="job-actions">
                            <button class="btn-apply-now" type="button" onclick="window.location.href='<?= base_url('jobs') ?>'">View job</button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-calendar-check"></i>
                <p class="title">No interviews yet</p>
                <p class="subtitle">Interview invitations will appear here.</p>
                <div class="cta">
                    <a href="<?= base_url('jobs') ?>">Browse all jobs →</a>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <section id="section-archived" class="myjobs-section active">
        <div id="archived-list" class="jobs-list"></div>
        <div id="archived-list-pagination" class="pagination-wrap"></div>
        <div style="height: 18px;"></div>
        <div id="archived-applied-list" class="jobs-list"></div>
        <div id="archived-applied-pagination" class="pagination-wrap"></div>
    </section>
</div>

<script>
    const baseUrl = '<?= base_url() ?>';
    const savedJobsFromServer = <?= json_encode($savedJobsData, JSON_UNESCAPED_SLASHES) ?>;
    const appliedJobsFromServer = <?= json_encode($appliedJobsData, JSON_UNESCAPED_SLASHES) ?>;
    const removedSavedIds = new Set();
    const archivedAppliedJobsKey = 'archivedAppliedJobs';
        const uiAppliedJobsKey = 'uiAppliedJobs';
        const uiAppliedJobsDataKey = 'uiAppliedJobsData';
        let archiveAppliedTransitionPending = false;

        function getUIAppliedJobIds() {
            try {
                const raw = JSON.parse(localStorage.getItem(uiAppliedJobsKey) || '[]');
                if (!Array.isArray(raw)) {
                    return [];
                }
                return [...new Set(raw.map(id => String(parseInt(id, 10))).filter(id => id !== 'NaN' && parseInt(id, 10) > 0))];
            } catch (e) {
                return [];
            }
        }

        function setUIAppliedJobIds(ids) {
            localStorage.setItem(uiAppliedJobsKey, JSON.stringify(ids.map(id => parseInt(id, 10))));
        }

        function getUIAppliedJobData() {
            try {
                const raw = JSON.parse(localStorage.getItem(uiAppliedJobsDataKey) || '{}');
                return typeof raw === 'object' ? raw : {};
            } catch (e) {
                return {};
            }
        }

        function setUIAppliedJobData(jobId, jobData) {
            try {
                const normalized = String(parseInt(jobId, 10));
                const data = getUIAppliedJobData();
                data[normalized] = jobData;
                localStorage.setItem(uiAppliedJobsDataKey, JSON.stringify(data));
            } catch (e) {
                console.log('Error storing UI applied job data', e);
            }
        }

        function addUIAppliedJob(jobId, jobData = null) {
            const normalized = String(parseInt(jobId, 10));
            const uiApplied = getUIAppliedJobIds();
            if (!uiApplied.includes(normalized)) {
                uiApplied.push(normalized);
                setUIAppliedJobIds([...new Set(uiApplied)]);
            }
            if (jobData) {
                setUIAppliedJobData(jobId, jobData);
            }
        }

        function removeUIAppliedJob(jobId) {
            const normalized = String(parseInt(jobId, 10));
            const uiApplied = getUIAppliedJobIds().filter(id => id !== normalized);
            setUIAppliedJobIds(uiApplied);
        
            try {
                const data = getUIAppliedJobData();
                delete data[normalized];
                localStorage.setItem(uiAppliedJobsDataKey, JSON.stringify(data));
            } catch (e) {
                console.log('Error removing UI applied job data', e);
            }
        }

    function getArchivedAppliedJobIds() {
        try {
            const raw = JSON.parse(localStorage.getItem(archivedAppliedJobsKey) || '[]');
            if (!Array.isArray(raw)) {
                return [];
            }
            return [...new Set(raw.map(id => String(parseInt(id, 10))).filter(id => id !== 'NaN' && parseInt(id, 10) > 0))];
        } catch (e) {
            return [];
        }
    }

    function setArchivedAppliedJobIds(ids) {
        localStorage.setItem(archivedAppliedJobsKey, JSON.stringify(ids.map(id => parseInt(id, 10))));
    }

    function archiveAppliedJob(jobId) {
        const normalized = String(parseInt(jobId, 10));
        const archived = getArchivedAppliedJobIds();
        if (!archived.includes(normalized)) {
            archived.push(normalized);
            setArchivedAppliedJobIds([...new Set(archived)]);
        }
    }

    function unarchiveAppliedJob(jobId) {
        const normalized = String(parseInt(jobId, 10));
        const archived = getArchivedAppliedJobIds().filter(id => id !== normalized);
        setArchivedAppliedJobIds(archived);
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value == null ? '' : String(value);
        return div.innerHTML;
    }

    function getSavedJobIdsFromLocalStorage() {
        try {
            const raw = JSON.parse(localStorage.getItem('savedJobs') || '[]');
            if (!Array.isArray(raw)) {
                return [];
            }
            return [...new Set(raw.map(id => String(parseInt(id, 10))).filter(id => id !== 'NaN' && parseInt(id, 10) > 0))];
        } catch (e) {
            return [];
        }
    }

    function toJobMap(jobs) {
        const map = new Map();
        jobs.forEach(job => {
            const id = String(parseInt(job.id, 10));
            if (id !== 'NaN') {
                map.set(id, job);
            }
        });
        return map;
    }

    function dedupeJobs(jobs) {
        const map = new Map();
        jobs.forEach(job => {
            const id = String(parseInt(job.id, 10));
            if (id !== 'NaN' && !map.has(id)) {
                map.set(id, job);
            }
        });
        return [...map.values()];
    }

    function renderJobRow(job, opts = {}) {
        const id = String(parseInt(job.id, 10));
        const showUnsave = !!opts.showUnsave;
        const showUnarchive = !!opts.showUnarchive;
        const showArchiveApplied = !!opts.showArchiveApplied;
        const showRestoreApplied = !!opts.showRestoreApplied;
        const metaText = opts.metaText || 'Saved for later';

        return `
            <article class="job-row" data-job-id="${escapeHtml(id)}">
                <div class="job-logo">
                    <i class="fas fa-briefcase"></i>
                </div>

                <div class="job-main">
                    <h3>${escapeHtml(job.job_title || 'Untitled Role')}</h3>
                    <p><span class="job-company">${escapeHtml(job.company || 'Unknown Company')}</span><span class="job-location">${escapeHtml(job.location || 'Location not set')}</span></p>
                    <div class="job-meta">${escapeHtml(metaText)}</div>
                </div>

                <div class="job-actions">
                    <button class="btn-apply-now" type="button" onclick="window.location.href='${baseUrl}jobs'">View job</button>
                    ${showUnsave ? `<button class="action-icon btn-unsave" type="button" data-job-id="${escapeHtml(id)}" aria-label="Unsave job"><i class="fas fa-bookmark"></i></button>` : ''}
                    ${showUnarchive ? `<button class="action-icon btn-unarchive" type="button" data-job-id="${escapeHtml(id)}" aria-label="Unarchive job"><i class="fas fa-archive"></i></button>` : ''}
                    ${showArchiveApplied ? `<button class="action-icon btn-archive-applied" type="button" data-job-id="${escapeHtml(id)}" aria-label="Archive applied job"><i class="fas fa-archive"></i></button>` : ''}
                    ${showRestoreApplied ? `<button class="action-icon btn-restore-applied" type="button" data-job-id="${escapeHtml(id)}" aria-label="Restore applied job"><i class="fas fa-undo"></i></button>` : ''}
                </div>
            </article>
        `;
    }

    function renderEmpty(container, title, subtitle) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-bookmark"></i>
                <p class="title">${escapeHtml(title)}</p>
                <p class="subtitle">${escapeHtml(subtitle)}</p>
                <div class="cta">
                    <a href="${baseUrl}jobs">Browse all jobs →</a>
                </div>
            </div>
        `;
    }

    async function hydrateJobsByIds(ids) {
        if (!ids.length) {
            return [];
        }

        const response = await fetch(baseUrl + 'jobs/get_jobs_by_ids', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ job_ids: ids })
        });

        const payload = await response.json();
        if (!payload.status || !Array.isArray(payload.jobs)) {
            return [];
        }

        return payload.jobs;
    }

    async function buildSavedMergedList() {
        const uiAppliedIds = new Set(getUIAppliedJobIds());
        const localIds = getSavedJobIdsFromLocalStorage()
            .filter(id => !removedSavedIds.has(id) && !uiAppliedIds.has(id));
        const serverMap = toJobMap(savedJobsFromServer || []);
        const serverIds = [...serverMap.keys()].filter(id => !removedSavedIds.has(id) && !uiAppliedIds.has(id));
        const mergedIds = [...new Set([...localIds, ...serverIds])];

        const missingIds = mergedIds.filter(id => !serverMap.has(id));
        if (missingIds.length) {
            try {
                const hydrated = await hydrateJobsByIds(missingIds);
                hydrated.forEach(job => {
                    serverMap.set(String(parseInt(job.id, 10)), job);
                });
            } catch (e) {
                console.log('Unable to hydrate missing saved jobs', e);
            }
        }

        return mergedIds
            .filter(id => !removedSavedIds.has(id) && !uiAppliedIds.has(id))
            .map(id => serverMap.get(id))
            .filter(Boolean);
    }

    async function buildAppliedJobsList() {
        const archivedIds = new Set(getArchivedAppliedJobIds());
        const uiAppliedIds = getUIAppliedJobIds();
        const uiAppliedData = getUIAppliedJobData();
        
        // Jobs from server that aren't archived
        const serverJobs = dedupeJobs(appliedJobsFromServer || []).filter(job => !archivedIds.has(String(parseInt(job.id, 10))));
        
        // Jobs marked as applied via UI - get from localStorage first, then hydrate if needed
        const uiAppliedJobObjects = [];
        for (const jobId of uiAppliedIds) {
            if (uiAppliedData[jobId]) {
                uiAppliedJobObjects.push(uiAppliedData[jobId]);
            }
        }
        
        // If any are missing, try to hydrate them
        const missingIds = uiAppliedIds.filter(id => !uiAppliedData[id]);
        if (missingIds.length) {
            try {
                const hydrated = await hydrateJobsByIds(missingIds);
                hydrated.forEach(job => {
                    const jobId = String(parseInt(job.id, 10));
                    setUIAppliedJobData(jobId, job);
                    uiAppliedJobObjects.push(job);
                });
            } catch (e) {
                console.log('Unable to hydrate UI-applied jobs', e);
            }
        }
        
        // Combine and dedupe
        return dedupeJobs([...serverJobs, ...uiAppliedJobObjects]);
    }

    function buildArchivedAppliedJobsList() {
        const archivedIds = new Set(getArchivedAppliedJobIds());
        return dedupeJobs(appliedJobsFromServer || []).filter(job => archivedIds.has(String(parseInt(job.id, 10))));
    }

    function setCount(id, count) {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = String(count);
        }
    }

    function activateTab(tabName) {
        document.querySelectorAll('.tab-link').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.tab === tabName);
        });

        document.querySelectorAll('.myjobs-section').forEach(section => {
            section.classList.toggle('active', section.id === `section-${tabName}`);
        });

        try {
            sessionStorage.setItem('myJobsActiveTab', tabName);
        } catch (e) {
            // Ignore storage errors.
        }
    }

    function unsaveInLocalStorage(jobId) {
        const normalized = String(parseInt(jobId, 10));
        const savedIds = getSavedJobIdsFromLocalStorage();
        const next = savedIds.filter(id => id !== normalized);
        localStorage.setItem('savedJobs', JSON.stringify(next.map(id => parseInt(id, 10))));
    }

    function attachUnsaveHandlers() {
        document.querySelectorAll('.btn-unsave').forEach(btn => {
            btn.addEventListener('click', async function() {
                const jobId = this.dataset.jobId;
                unsaveInLocalStorage(jobId);
                removedSavedIds.add(String(parseInt(jobId, 10)));

                await fetch(baseUrl + 'jobs/unsave_job_action/' + jobId, { method: 'DELETE' })
                    .catch(() => {});

                await renderSavedAndArchivedSections();
            });
        });
    }

    function attachUnarchiveHandlers() {
        document.querySelectorAll('.btn-unarchive').forEach(btn => {
            btn.addEventListener('click', async function() {
                const jobId = this.dataset.jobId;
                unsaveInLocalStorage(jobId);
                removedSavedIds.add(String(parseInt(jobId, 10)));

                await fetch(baseUrl + 'jobs/unsave_job_action/' + jobId, { method: 'DELETE' })
                    .catch(() => {});

                await renderSavedAndArchivedSections();
            });
        });
    }

    function attachArchiveAppliedHandlers() {
        document.querySelectorAll('.btn-archive-applied').forEach(btn => {
            btn.addEventListener('click', async function() {
                archiveAppliedTransitionPending = true;
                archiveAppliedJob(this.dataset.jobId);
                await renderAppliedSection();
                await renderSavedAndArchivedSections();
                archiveAppliedTransitionPending = false;
                await renderAppliedSection();
                await renderSavedAndArchivedSections();
                activateTab('archived');
            });
        });
    }

    function attachRestoreAppliedHandlers() {
        document.querySelectorAll('.btn-restore-applied').forEach(btn => {
            btn.addEventListener('click', async function() {
                unarchiveAppliedJob(this.dataset.jobId);
                await renderAppliedSection();
                await renderSavedAndArchivedSections();
            });
        });
    }

    let allSavedJobs = [];
    let allAppliedJobs = [];
    let allArchivedAppliedJobs = [];
    let currentSavedPage = getStoredPage('saved');
    let currentAppliedPage = getStoredPage('applied');
    let currentArchivedAppliedPage = getStoredPage('archived-applied');
    const PAGE_SIZE = 5;

    function paginateItems(items, page = 1, pageSize = PAGE_SIZE) {
        const totalPages = Math.max(1, Math.ceil(items.length / pageSize));
        const currentPage = Math.min(Math.max(1, page), totalPages);
        const start = (currentPage - 1) * pageSize;
        return {
            items: items.slice(start, start + pageSize),
            totalPages,
            currentPage,
        };
    }

    function buildPaginationHtml(currentPage, totalPages, target) {
        if (totalPages <= 1) {
            return '';
        }

        let html = '<div class="pagination-controls">';
        html += `<button type="button" class="pagination-btn" data-target="${target}" data-page="${currentPage - 1}" ${currentPage === 1 ? 'disabled' : ''}>Previous</button>`;

        for (let page = 1; page <= totalPages; page += 1) {
            html += `<button type="button" class="pagination-btn ${page === currentPage ? 'active' : ''}" data-target="${target}" data-page="${page}">${page}</button>`;
        }

        html += `<button type="button" class="pagination-btn" data-target="${target}" data-page="${currentPage + 1}" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;
        html += '</div>';
        return html;
    }

    function getStoredPage(target) {
        try {
            const value = parseInt(sessionStorage.getItem(`myJobsPage_${target}`), 10);
            return Number.isInteger(value) && value > 0 ? value : 1;
        } catch (e) {
            return 1;
        }
    }

    function setStoredPage(target, page) {
        try {
            sessionStorage.setItem(`myJobsPage_${target}`, String(page));
        } catch (e) {
            // Ignore storage errors.
        }
    }

    function attachPaginationHandlers(targetId) {
        const container = document.getElementById(targetId);
        if (!container) return;

        container.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', async function () {
                const page = parseInt(this.dataset.page, 10);
                const target = this.dataset.target;
                if (Number.isNaN(page) || page < 1) return;

                if (target === 'saved') {
                    currentSavedPage = page;
                    setStoredPage('saved', currentSavedPage);
                    renderSavedSection(allSavedJobs);
                } else if (target === 'applied') {
                    currentAppliedPage = page;
                    setStoredPage('applied', currentAppliedPage);
                    renderAppliedSection(allAppliedJobs);
                } else if (target === 'archived-applied') {
                    currentArchivedAppliedPage = page;
                    setStoredPage('archived-applied', currentArchivedAppliedPage);
                    renderArchivedAppliedSection(allArchivedAppliedJobs);
                }
            });
        });
    }

    function renderSavedSection(jobs) {
        const savedList = document.getElementById('saved-list');
        const savedPagination = document.getElementById('saved-pagination');
        const merged = jobs || [];
        setCount('count-saved', merged.length);

        if (!merged.length) {
            savedList.innerHTML = '';
            savedPagination.innerHTML = '';
            renderEmpty(savedList, 'No saved jobs', 'Save jobs to view them here.');
            return;
        }

        const paged = paginateItems(merged, currentSavedPage);
        if (paged.currentPage !== currentSavedPage) {
            currentSavedPage = paged.currentPage;
            setStoredPage('saved', currentSavedPage);
        }
        savedList.innerHTML = paged.items.map(job => renderJobRow(job, { showUnsave: true, metaText: 'Saved for later' })).join('');
        savedPagination.innerHTML = buildPaginationHtml(paged.currentPage, paged.totalPages, 'saved');
        attachPaginationHandlers('saved-pagination');
        attachUnsaveHandlers();
    }

    async function renderAppliedSection(jobs) {
        const appliedList = document.getElementById('applied-list');
        const appliedPagination = document.getElementById('applied-pagination');
        const applied = jobs || await buildAppliedJobsList();
        setCount('count-applied', applied.length);

        if (!applied.length) {
            appliedList.innerHTML = '';
            appliedPagination.innerHTML = '';
            if (archiveAppliedTransitionPending) {
                return;
            }
            renderEmpty(appliedList, 'No applied jobs yet', 'Apply to jobs and track them here.');
            return;
        }

        const paged = paginateItems(applied, currentAppliedPage);
        if (paged.currentPage !== currentAppliedPage) {
            currentAppliedPage = paged.currentPage;
            setStoredPage('applied', currentAppliedPage);
        }
        appliedList.innerHTML = paged.items.map(job => renderJobRow(job, { showArchiveApplied: true, metaText: 'Applied' })).join('');
        appliedPagination.innerHTML = buildPaginationHtml(paged.currentPage, paged.totalPages, 'applied');
        attachPaginationHandlers('applied-pagination');
        attachArchiveAppliedHandlers();
    }

    function renderArchivedAppliedSection(jobs) {
        const archivedAppliedList = document.getElementById('archived-applied-list');
        const archivedPagination = document.getElementById('archived-applied-pagination');
        const archivedApplied = jobs || buildArchivedAppliedJobsList();
        setCount('count-archived', archivedApplied.length);

        if (!archivedApplied.length) {
            archivedAppliedList.innerHTML = '';
            archivedPagination.innerHTML = '';
            if (archiveAppliedTransitionPending) {
                return;
            }
            renderEmpty(archivedAppliedList, 'No archived applied jobs yet', 'Archive jobs from the Applied tab to keep this list tidy.');
            return;
        }

        const paged = paginateItems(archivedApplied, currentArchivedAppliedPage);
        if (paged.currentPage !== currentArchivedAppliedPage) {
            currentArchivedAppliedPage = paged.currentPage;
            setStoredPage('archived-applied', currentArchivedAppliedPage);
        }
        archivedAppliedList.innerHTML = paged.items.map(job => renderJobRow(job, { showRestoreApplied: true, metaText: 'Archived from Applied' })).join('');
        archivedPagination.innerHTML = buildPaginationHtml(paged.currentPage, paged.totalPages, 'archived-applied');
        attachPaginationHandlers('archived-applied-pagination');
        attachRestoreAppliedHandlers();
    }

    function renderSavedAndArchivedSections() {
        return Promise.resolve().then(async () => {
            allSavedJobs = await buildSavedMergedList();
            allArchivedAppliedJobs = buildArchivedAppliedJobsList();
            renderSavedSection(allSavedJobs);
            renderArchivedAppliedSection(allArchivedAppliedJobs);
        });
    }

    function filterJobsBySearch(jobs, searchTerm) {
        if (!searchTerm || searchTerm.length < 4) {
            return jobs;
        }

        const term = searchTerm.toLowerCase();
        return jobs.filter(job => {
            const title = (job.job_title || '').toLowerCase();
            const company = (job.company || '').toLowerCase();
            const location = (job.location || '').toLowerCase();
            return title.includes(term) || company.includes(term) || location.includes(term);
        });
    }

    async function performLiveSearch() {
        const searchInput = document.getElementById('myjobs-search');
        if (!searchInput) return;

        const searchTerm = searchInput.value.trim();
        const activeTab = document.querySelector('.tab-link.active')?.dataset.tab;

        if (searchTerm.length < 4) {
            // Show the normal paged list for the current tab when search is not active.
            if (activeTab === 'saved') {
                const saved = await buildSavedMergedList();
                renderSavedSection(saved);
            } else if (activeTab === 'applied') {
                renderAppliedSection(allAppliedJobs);
            } else if (activeTab === 'archived') {
                await renderSavedAndArchivedSections();
            }
            return;
        }

        // Filter jobs based on search term
        if (activeTab === 'saved') {
            currentSavedPage = 1;
            const filtered = filterJobsBySearch(allSavedJobs, searchTerm);
            renderSavedSection(filtered);
        } else if (activeTab === 'applied') {
            currentAppliedPage = 1;
            const filtered = filterJobsBySearch(allAppliedJobs, searchTerm);
            renderAppliedSection(filtered);
        } else if (activeTab === 'archived') {
            currentArchivedAppliedPage = 1;
            const filteredArchived = filterJobsBySearch(allArchivedAppliedJobs, searchTerm);
            renderArchivedAppliedSection(filteredArchived);
        }
    }

    /* State dropdown handlers for auto-tab switching */
    document.addEventListener('DOMContentLoaded', async function() {
        document.querySelectorAll('.tab-link').forEach(tab => {
            tab.addEventListener('click', function() {
                activateTab(this.dataset.tab);
                const searchInput = document.getElementById('myjobs-search');
                if (searchInput) {
                    searchInput.value = '';
                }
                performLiveSearch();
            });
        });

        const searchInput = document.getElementById('myjobs-search');
        if (searchInput) {
            searchInput.addEventListener('input', performLiveSearch);
        }

        await renderAppliedSection();
        await renderSavedAndArchivedSections();

        // Cache all jobs for searching
        allSavedJobs = await buildSavedMergedList();
        allAppliedJobs = await buildAppliedJobsList();
        allArchivedAppliedJobs = buildArchivedAppliedJobsList();

        let defaultTab = 'archived';
        try {
            const stored = sessionStorage.getItem('myJobsActiveTab');
            if (stored) {
                defaultTab = stored;
            }
        } catch (e) {
            // Ignore storage errors.
        }
        activateTab(defaultTab);
    });
</script>
