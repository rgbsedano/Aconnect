<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #700a0a;
        --accent-green: #10b981;
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
        margin-bottom: 30px;
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

    /* Report Summary Cards */
    .report-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 30px;
    }

    .report-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        transition: var(--transition);
    }

    .report-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); }

    .card-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Filter Sidebar/Top Bar */
    .filter-section {
        background: #f8fafc;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
    }

    .form-group label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 8px;
        display: block;
    }

    .form-select, .form-date {
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #cbd5e1;
        width: 100%;
    }

    /* Modern Buttons */
    .btn-action {
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        border: none;
    }

    .btn-primary { background: var(--accent-red); color: white; }
    .btn-primary:hover { background: #5a0808; transform: translateY(-2px); }
    
    .btn-outline { background: white; border: 1px solid #e2e8f0; color: var(--text-main); }
    .btn-outline:hover { border-color: var(--accent-red); color: var(--accent-red); transform: translateY(-2px); }

    .btn-excel { background: #dcfce7; color: #166534; }
    .btn-excel:hover { background: #bbf7d0; }
    
    .btn-pdf { background: #fee2e2; color: #991b1b; }
    .btn-pdf:hover { background: #fecaca; }

    /* Custom Table Style */
    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .custom-table th { padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); border: none; }
    .custom-table tr.data-row { background: white; transition: var(--transition); }
    .custom-table tr.data-row:hover { transform: scale(1.002); box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
    .custom-table td { padding: 14px 20px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: var(--text-main); }
    .custom-table td:first-child { border-left: 1px solid #f1f5f9; border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
    .custom-table td:last-child { border-right: 1px solid #f1f5f9; border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

    .status-badge {
        padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700;
    }
    .status-employed { background: #dcfce7; color: #166534; }
    .status-unemployed { background: #f1f5f9; color: var(--text-muted); }
    .status-self { background: #fef2f2; color: var(--accent-red); }

    .chart-container-card { padding: 30px; }
    .chart-wrapper { position: relative; height: 350px; width: 100%; }

    @media (max-width: 768px) {
        .chart-container-card { padding: 15px; }
        .chart-wrapper { height: 250px; }
        .header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
        
        .header-section .d-flex {
            width: 100%;
            flex-wrap: wrap;
        }

        .btn-action {
            flex: 1;
            justify-content: center;
        }

        .dashboard-wrapper {
            padding: 15px;
        }

        .report-card {
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .header-section h1 {
            font-size: 22px;
        }
        
        .custom-table th, .custom-table td {
            padding: 10px;
            font-size: 12px;
        }
    }

</style>

<div class="dashboard-wrapper">
    <div class="header-section">
        <div>
            <h1>Reports & <span>Analytics</span></h1>
            <p>Comprehensive overview of alumni engagement and tracer records.</p>
        </div>
        <div class="d-flex gap-2">
            <?php
                $q = http_build_query([
                    'grad_year' => $filters['grad_year'] ?? '',
                    'status'    => $filters['status'] ?? '',
                    'date_from' => $filters['date_from'] ?? '',
                    'date_to'   => $filters['date_to'] ?? ''
                ]);
            ?>
            <a href="<?= base_url('AdminReports/employment_excel') . '?' . $q ?>" class="btn-action btn-excel">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="<?= base_url('AdminReports/employment_pdf') . '?' . $q ?>" class="btn-action btn-pdf">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <!-- Analytics Chart -->
    <div class="report-card mb-4 chart-container-card">
        <div class="card-title">
            <span>Alumni Engagement Trend</span>
            <span style="font-size: 11px; color: var(--text-muted);">Interactive Data Visualization</span>
        </div>
        <div class="chart-wrapper">
            <canvas id="engagementChart"></canvas>
        </div>
    </div>

    <!-- Tracer Records Section -->
    <div class="report-card">
        <div class="card-title">Tracer / Employment Database</div>
        
        <!-- Filters -->
        <form method="get" action="<?= base_url('AdminReports') ?>" class="filter-section">
            <div class="row align-items-end">
                <div class="col-md-3 mb-3 mb-md-0">
                    <label>Graduation Year</label>
                    <select name="grad_year" class="form-select">
                        <option value="">All Years</option>
                        <?php
                        $cur = date('Y');
                        for ($y = $cur; $y >= 1980; $y--) {
                            $sel = (isset($filters['grad_year']) && $filters['grad_year'] == $y) ? 'selected' : '';
                            echo "<option value=\"{$y}\" {$sel}>Batch {$y}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <label>Status</label>
                    <?php $st = $filters['status'] ?? ''; ?>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Employed" <?= $st=='Employed' ? 'selected':'' ?>>Employed</option>
                        <option value="Unemployed" <?= $st=='Unemployed' ? 'selected':'' ?>>Unemployed</option>
                        <option value="Self-employed" <?= $st=='Self-employed' ? 'selected':'' ?>>Self-employed</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <label>Date Range (Submitted)</label>
                    <div class="d-flex gap-2">
                        <input type="date" name="date_from" class="form-date" value="<?= $filters['date_from'] ?? '' ?>">
                        <input type="date" name="date_to" class="form-date" value="<?= $filters['date_to'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn-action btn-primary flex-fill justify-content-center">Apply</button>
                    <a href="<?= base_url('AdminReports') ?>" class="btn-action btn-outline" title="Reset Filters"><i class="fas fa-undo"></i></a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Alumni</th>
                        <th>Batch</th>
                        <th>Employment Status</th>
                        <th>Company & Role</th>
                        <th>Experience</th>
                        <th>Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($employment_rows)): foreach($employment_rows as $r): ?>
                        <tr class="data-row">
                            <td>
                                <div style="font-weight: 700; color: var(--text-main);"><?= htmlspecialchars($r['first_name'].' '.$r['last_name']) ?></div>
                                <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($r['email']) ?></div>
                            </td>
                            <td class="font-weight-bold"><?= htmlspecialchars($r['graduation_year']) ?></td>
                            <td>
                                <span class="status-badge <?= $r['employment_status'] == 'Employed' ? 'status-employed' : ($r['employment_status'] == 'Self-employed' ? 'status-self' : 'status-unemployed') ?>">
                                    <?= htmlspecialchars($r['employment_status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if($r['employment_status'] != 'Unemployed'): ?>
                                    <div style="font-weight: 600;"><?= htmlspecialchars($r['job_title']) ?></div>
                                    <div style="font-size: 11px; color: var(--accent-red);"><?= htmlspecialchars($r['company_name']) ?></div>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--text-main);"><?= (int)$r['year_of_service'] ?> Years</div>
                                <div style="font-size: 11px; color: var(--accent-green); font-weight: 700;"><?= (int)$r['promotion_count'] ?> Promotions</div>
                            </td>
                            <td>
                                <div style="font-size: 11px; color: var(--text-muted); font-weight: 500;">
                                    <?= date('M d, Y', strtotime($r['created_at'])) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="6" class="text-center py-5 text-muted">No records found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function(){
        const labels = <?= json_encode(array_column($engagement_by_year, 'graduation_year')) ?>;
        const total = <?= json_encode(array_column($engagement_by_year, 'total_alumni')) ?>;
        const active = <?= json_encode(array_column($engagement_by_year, 'active_alumni')) ?>;
        const events = <?= json_encode(array_column($engagement_by_year, 'event_registrations')) ?>;
        const apps = <?= json_encode(array_column($engagement_by_year, 'job_applications')) ?>;

        const ctx = document.getElementById('engagementChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Total Alumni', data: total, backgroundColor: '#e2e8f0', borderRadius: 8 },
                    { label: 'Active (30d)', data: active, backgroundColor: '#94a3b8', borderRadius: 8 },
                    { label: 'Event Registrations', data: events, backgroundColor: '#700a0a', borderRadius: 8 },
                    { label: 'Job Applications', data: apps, backgroundColor: '#1e293b', borderRadius: 8 },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'top', 
                        labels: { 
                            usePointStyle: true, 
                            boxWidth: 8,
                            padding: 20,
                            font: { family: 'Plus Jakarta Sans', weight: '700', size: 11 } 
                        } 
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', weight: '600', size: 10 } } },
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] }, ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } } }
                }
            }
        });
    })();
</script>
