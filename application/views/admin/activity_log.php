<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #700a0a;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 24px;
    }

    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px 24px;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-section {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .header-section h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 4px;
        color: white;
    }

    .header-section h1 span { color: #ff6b6b; }
    .header-section p { color: rgba(255, 255, 255, 0.9); font-size: 14px; margin: 0; }

    /* Action Buttons */
    .btn-export {
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        border: 1px solid #e2e8f0;
        background: white;
        color: var(--text-main);
    }

    .btn-export:hover { background: #f8fafc; transform: translateY(-2px); border-color: var(--accent-red); color: var(--accent-red); text-decoration: none; }

    /* Main Card */
    .main-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        margin-top: 20px;
    }

    /* Toolbar */
    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 20px;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-box i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #cbd5e1;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px 12px 45px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        font-weight: 500;
        transition: var(--transition);
    }

    .search-input:focus {
        border-color: var(--accent-red);
        box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05);
        outline: none;
    }

    /* Custom Table */
    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .custom-table th { padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); border: none; }
    .custom-table tr.data-row { background: white; transition: var(--transition); }
    .custom-table tr.data-row:hover { transform: scale(1.002); box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
    .custom-table td { padding: 16px 20px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    .custom-table td:first-child { border-left: 1px solid #f1f5f9; border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
    .custom-table td:last-child { border-right: 1px solid #f1f5f9; border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

    .alumni-info { font-weight: 700; color: var(--text-main); font-size: 14px; }
    .activity-text { font-size: 14px; color: var(--text-muted); line-height: 1.5; }
    .activity-time { font-size: 12px; color: #94a3b8; font-weight: 500; }

    .pagination-wrapper { margin-top: 30px; display: flex; justify-content: center; }
    .pagination-wrapper a, .pagination-wrapper strong {
        padding: 8px 16px; margin: 0 4px; border-radius: 10px; font-weight: 600; font-size: 14px;
        border: 1px solid #e2e8f0; color: var(--text-muted); transition: var(--transition);
    }
    .pagination-wrapper strong { background: var(--accent-red); border-color: var(--accent-red); color: white; }
    .pagination-wrapper a:hover { background: #f8fafc; color: var(--accent-red); border-color: var(--accent-red); }

    @media (max-width: 768px) {
        .dashboard-wrapper { padding: 15px; margin: 10px auto; }
        .header-section { flex-direction: column; align-items: flex-start !important; gap: 15px; }
        .header-section h1 { font-size: 24px; }
        .main-card { padding: 15px; }
        .toolbar { flex-direction: column; align-items: stretch; }
        .search-box { max-width: none; }
        .btn-export { width: 100%; justify-content: center; }
        .header-section .d-flex { flex-direction: column; width: 100%; gap: 10px; }
    }

    @media print {
        .dashboard-wrapper { padding: 0; }
        .header-section, .toolbar, .pagination-wrapper { display: none !important; }
        .main-card { box-shadow: none; border: none; padding: 0; }
        .custom-table { border-spacing: 0; width: 100%; border: 1px solid #000; }
        .custom-table th, .custom-table td { border: 1px solid #000 !important; padding: 10px; border-radius: 0 !important; }
        .print-only-header { display: block !important; text-align: center; margin-bottom: 30px; }
    }
</style>

<div class="dashboard-wrapper">
    <div class="header-section">
        <div>
            <h1>Platform <span>Activity</span></h1>
            <p>Monitored system actions and administrative logs.</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn-export">
                <i class="fas fa-print"></i> Print
            </button>
            <a href="<?= base_url('adminactivitylog/download?search=' . urlencode($this->input->get('search'))) ?>" class="btn-export">
                <i class="fas fa-file-excel" style="color: #166534;"></i> Excel
            </a>
            <a href="<?= base_url('adminactivitylog/download_pdf?search=' . urlencode($this->input->get('search'))) ?>" class="btn-export">
                <i class="fas fa-file-pdf" style="color: #991b1b;"></i> PDF
            </a>
        </div>
    </div>

    <div class="main-card">
        <div class="print-only-header" style="display: none;">
            <h2 style="font-weight: 700; color: #000; margin-bottom: 5px;">AConnect - Activity Logs Report</h2>
            <p style="color: #666; font-size: 14px;">Date Generated: <?= date('F j, Y g:i A') ?></p>
            <hr style="border: 1px solid #000; margin: 20px 0;">
        </div>

        <div class="toolbar">
            <div class="search-box">
                <form method="get" id="searchLogForm">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="search-input" placeholder="Search by name or activity..." value="<?= $this->input->get('search') ?>" id="logSearchInput">
                </form>
            </div>
            <div class="text-muted small font-weight-bold uppercase">
                Showing <?= count($logs) ?> logs in this page
            </div>
        </div>

        <div class="table-responsive">
            <table class="custom-table" id="logTable">
                <thead>
                    <tr>
                        <th style="width: 250px;">Personnel / Alumni</th>
                        <th>Activity Performed</th>
                        <th style="width: 200px;">Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr class="data-row">
                                <td>
                                    <div class="alumni-info"><?= ucwords($log->first_name . ' ' . $log->last_name) ?></div>
                                    <div style="font-size: 11px; color: var(--accent-red); font-weight: 700;">USER LOG</div>
                                </td>
                                <td>
                                    <div class="activity-text"><?= $log->activity ?></div>
                                </td>
                                <td>
                                    <div class="activity-time">
                                        <i class="far fa-clock mr-1"></i>
                                        <?= date('M d, Y | g:i A', strtotime($log->created_at)) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <i class="fas fa-history fa-3x text-light mb-3"></i>
                                <p class="text-muted font-weight-bold">No activity logs found matching your criteria.</p>
                                <a href="<?= base_url('adminactivitylog') ?>" class="btn-export mt-2">Clear Selection</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="print-footer mt-4" style="display: none; text-align: center; font-size: 12px; border-top: 1px solid #eee; padding-top: 20px;">
            Page <?= $current_page ?> of <?= $total_pages ?> — AConnect System Activity Log Report
        </div>
    </div>

    <div class="pagination-wrapper">
        <?= $pagination ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Auto-submit search on typing (with debounce)
        let searchTimer;
        $('#logSearchInput').on('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                $('#searchLogForm').submit();
            }, 800);
        });
    });
</script>
