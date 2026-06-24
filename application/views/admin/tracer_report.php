<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #a12124;
        --accent-green: #10b981;
        --accent-blue: #3b82f6;
        --accent-purple: #8b5cf6;
        --accent-amber: #f59e0b;
        --transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        --radius: 20px;
    }

    .tr-wrapper { max-width: 1400px; margin: 0 auto; padding: 20px 24px; animation: fadeIn .7s ease-out; }
    @keyframes fadeIn { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }

    /* Header */
    .tr-header { display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:28px; flex-wrap:wrap; gap:16px; }
    .tr-header h1 { font-size:28px; font-weight:700; color:#fff; margin:0 0 4px; }
    .tr-header h1 span { color:#ff6b6b; }
    .tr-header p  { color:rgba(255,255,255,.85); font-size:14px; margin:0; }

    /* Buttons */
    .btn-act { padding:10px 20px; border-radius:12px; font-size:13px; font-weight:700;
               display:inline-flex; align-items:center; gap:8px; border:none; cursor:pointer; transition:var(--transition); text-decoration:none; }
    .btn-primary { background:var(--accent-red); color:#fff; }
    .btn-primary:hover { background:#7f1d1e; transform:translateY(-2px); color:#fff; }
    .btn-outline  { background:#fff; border:1px solid #e2e8f0; color:var(--text-main); }
    .btn-outline:hover { border-color:var(--accent-red); color:var(--accent-red); transform:translateY(-2px); }
    .btn-excel    { background:#dcfce7; color:#166534; }
    .btn-excel:hover { background:#bbf7d0; }
    .btn-pdf      { background:#fee2e2; color:#991b1b; }
    .btn-pdf:hover { background:#fecaca; }

    /* Stat Cards */
    .stat-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:18px; margin-bottom:24px; }
    .stat-card { background:var(--card-bg); border-radius:var(--radius); padding:22px 24px;
                 box-shadow:0 2px 8px rgba(0,0,0,.05); border:1px solid #f1f5f9; transition:var(--transition); }
    .stat-card:hover { transform:translateY(-4px); box-shadow:0 12px 24px rgba(0,0,0,.07); }
    .stat-label { font-size:11px; font-weight:700; text-transform:uppercase; color:var(--text-muted); margin-bottom:6px; }
    .stat-value { font-size:30px; font-weight:800; color:var(--text-main); line-height:1; }
    .stat-sub   { font-size:12px; color:var(--text-muted); margin-top:6px; }
    .stat-icon  { font-size:22px; margin-bottom:10px; }

    /* Rating bar inside stat */
    .rating-bar-wrap { margin-top:10px; }
    .rating-bar-track { background:#f1f5f9; border-radius:99px; height:7px; overflow:hidden; }
    .rating-bar-fill  { height:100%; border-radius:99px; transition:width .8s ease; }
    .fill-green  { background:var(--accent-green); }
    .fill-blue   { background:var(--accent-blue); }
    .fill-purple { background:var(--accent-purple); }
    .fill-amber  { background:var(--accent-amber); }

    /* Section card */
    .section-card { background:var(--card-bg); border-radius:var(--radius); padding:24px;
                    box-shadow:0 2px 8px rgba(0,0,0,.05); border:1px solid #f1f5f9; margin-bottom:24px; }
    .section-title { font-size:16px; font-weight:700; color:var(--text-main); margin-bottom:18px;
                     display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; }
    .section-sub   { font-size:11px; color:var(--text-muted); font-weight:500; }

    /* Chart grid */
    .chart-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px; }
    .chart-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; margin-bottom:24px; }
    .chart-wrap   { position:relative; height:280px; }

    /* AI Insights */
    .ai-card { background:linear-gradient(135deg,#1e1b4b 0%,#312e81 60%,#1e293b 100%);
               border-radius:var(--radius); padding:28px; margin-bottom:24px; }
    .ai-header { display:flex; align-items:center; gap:12px; margin-bottom:18px; }
    .ai-header h3 { color:#fff; font-size:17px; font-weight:700; margin:0; }
    .ai-badge { background:rgba(255,255,255,.15); color:#c7d2fe; font-size:11px; font-weight:700;
                padding:4px 10px; border-radius:8px; }
    .ai-pulse { width:10px; height:10px; border-radius:50%; background:#6ee7b7;
                animation:pulse 2s infinite; flex-shrink:0; }
    @keyframes pulse { 0%,100%{box-shadow:0 0 0 0 rgba(110,231,183,.4)} 50%{box-shadow:0 0 0 8px rgba(110,231,183,0)} }
    .ai-insight-list { list-style:none; padding:0; margin:0; display:grid; gap:10px; }
    .ai-insight-item { display:flex; align-items:flex-start; gap:10px; background:rgba(255,255,255,.08);
                       border-radius:12px; padding:14px 16px; }
    .ai-insight-icon { color:#a5b4fc; font-size:14px; margin-top:2px; flex-shrink:0; }
    .ai-insight-text { color:#e0e7ff; font-size:13px; font-weight:500; line-height:1.5; }

    /* Filter */
    .filter-bar { background:#f8fafc; border-radius:16px; padding:18px 20px; margin-bottom:22px; border:1px solid #e2e8f0; }
    .filter-bar label { font-size:11px; font-weight:700; text-transform:uppercase; color:var(--text-muted); display:block; margin-bottom:6px; }
    .filter-bar select, .filter-bar input[type=date] {
        border-radius:10px; padding:9px 12px; font-size:13px; font-weight:600;
        border:1px solid #cbd5e1; width:100%; background:#fff; }

    /* Table */
    .data-table { width:100%; border-collapse:separate; border-spacing:0 7px; }
    .data-table th { padding:11px 18px; font-size:11px; font-weight:700; text-transform:uppercase; color:var(--text-muted); }
    .data-table tr.dr { background:#fff; transition:var(--transition); }
    .data-table tr.dr:hover { transform:scale(1.001); box-shadow:0 4px 12px rgba(0,0,0,.04); }
    .data-table td { padding:13px 18px; vertical-align:middle; border-top:1px solid #f1f5f9; border-bottom:1px solid #f1f5f9; font-size:13px; color:var(--text-main); }
    .data-table td:first-child { border-left:1px solid #f1f5f9; border-top-left-radius:10px; border-bottom-left-radius:10px; }
    .data-table td:last-child  { border-right:1px solid #f1f5f9; border-top-right-radius:10px; border-bottom-right-radius:10px; }

    /* Badges */
    .badge { display:inline-block; padding:4px 10px; border-radius:8px; font-size:11px; font-weight:700; }
    .badge-r5,.badge-5 { background:#dcfce7; color:#166534; }
    .badge-r4,.badge-4 { background:#dbeafe; color:#1e40af; }
    .badge-r3,.badge-3 { background:#fef3c7; color:#92400e; }
    .badge-r2,.badge-2 { background:#fed7aa; color:#9a3412; }
    .badge-r1,.badge-1 { background:#fee2e2; color:#991b1b; }
    .badge-wait { background:#f3e8ff; color:#6b21a8; }
    .badge-sat  { background:#e0f2fe; color:#0369a1; }
    .badge-intent { background:#fef9c3; color:#713f12; }

    /* Mini bar for perf ratings */
    .perf-mini { display:flex; gap:3px; align-items:center; flex-wrap:wrap; }
    .perf-dot  { width:22px; height:22px; border-radius:50%; font-size:10px; font-weight:700;
                 display:flex; align-items:center; justify-content:center; color:#fff; }

    @media (max-width:900px) {
        .chart-grid-2,.chart-grid-3 { grid-template-columns:1fr; }
        .tr-header { flex-direction:column; align-items:flex-start; }
        .tr-wrapper { padding:14px; }
    }
    @media (max-width:576px) {
        .stat-grid { grid-template-columns:1fr 1fr; }
        .stat-value { font-size:24px; }
        .tr-header h1 { font-size:22px; }
    }
</style>

<?php
/* ---- helpers ---- */
$perf_labels = [
    'Complete tasks professionally',
    'Committed and dedicated',
    'Resourceful with company resources',
    'Works harmoniously with peers',
    'Punctual and regular attendance',
    'Joins company activities',
];

function perf_color($v) {
    $map = [5=>'#10b981',4=>'#3b82f6',3=>'#f59e0b',2=>'#f97316',1=>'#ef4444'];
    return $map[(int)$v] ?? '#94a3b8';
}
$q = http_build_query([
    'grad_year' => $filters['grad_year'] ?? '',
    'date_from' => $filters['date_from'] ?? '',
    'date_to'   => $filters['date_to']   ?? '',
]);
?>

<div class="tr-wrapper">

    <!-- ── Header ── -->
    <div class="tr-header">
        <div>
            <h1>Tracer Study <span>Report</span></h1>
            <p>Alumni survey responses · Career tracking · Program effectiveness analytics</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="<?= base_url('AdminReports/tracer_excel').'?'.$q ?>" class="btn-act btn-excel">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="<?= base_url('AdminReports/tracer_pdf').'?'.$q ?>" class="btn-act btn-pdf">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="<?= base_url('AdminReports') ?>" class="btn-act btn-outline">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- ── Stat Cards ── -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div class="stat-label">Total Responses</div>
            <div class="stat-value"><?= $tracer_summary['total_responses'] ?></div>
            <div class="stat-sub">Alumni surveys collected</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-label">Curriculum Relevance</div>
            <div class="stat-value"><?= number_format($tracer_summary['avg_rating_1'],1) ?><small style="font-size:16px;color:var(--text-muted)">/5</small></div>
            <div class="rating-bar-wrap">
                <div class="rating-bar-track"><div class="rating-bar-fill fill-green" style="width:<?= ($tracer_summary['avg_rating_1']/5)*100 ?>%"></div></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎓</div>
            <div class="stat-label">Teaching Quality</div>
            <div class="stat-value"><?= number_format($tracer_summary['avg_rating_2'],1) ?><small style="font-size:16px;color:var(--text-muted)">/5</small></div>
            <div class="rating-bar-wrap">
                <div class="rating-bar-track"><div class="rating-bar-fill fill-blue" style="width:<?= ($tracer_summary['avg_rating_2']/5)*100 ?>%"></div></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🛠️</div>
            <div class="stat-label">Skills Development</div>
            <div class="stat-value"><?= number_format($tracer_summary['avg_rating_3'],1) ?><small style="font-size:16px;color:var(--text-muted)">/5</small></div>
            <div class="rating-bar-wrap">
                <div class="rating-bar-track"><div class="rating-bar-fill fill-purple" style="width:<?= ($tracer_summary['avg_rating_3']/5)*100 ?>%"></div></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💼</div>
            <div class="stat-label">Career Preparation</div>
            <div class="stat-value"><?= number_format($tracer_summary['avg_rating_4'],1) ?><small style="font-size:16px;color:var(--text-muted)">/5</small></div>
            <div class="rating-bar-wrap">
                <div class="rating-bar-track"><div class="rating-bar-fill fill-amber" style="width:<?= ($tracer_summary['avg_rating_4']/5)*100 ?>%"></div></div>
            </div>
        </div>
    </div>

    <!-- ── AI Analytics Card ── -->
    <?php if (!empty($tracer_ai)): ?>
    <div class="ai-card">
        <div class="ai-header">
            <div class="ai-pulse"></div>
            <h3>AI Analytics Interpretation</h3>
            <span class="ai-badge">Automated Insights</span>
        </div>
        <ul class="ai-insight-list">
            <?php foreach ($tracer_ai as $insight): ?>
            <li class="ai-insight-item">
                <i class="fas fa-lightbulb ai-insight-icon"></i>
                <span class="ai-insight-text"><?= htmlspecialchars($insight) ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- ── Charts Row 1: Ratings + Waiting Time ── -->
    <div class="chart-grid-2">
        <div class="section-card" style="margin-bottom:0">
            <div class="section-title">
                Program Rating Overview
                <span class="section-sub">Average per dimension</span>
            </div>
            <div class="chart-wrap"><canvas id="ratingsChart"></canvas></div>
        </div>
        <div class="section-card" style="margin-bottom:0">
            <div class="section-title">
                Time to Employment
                <span class="section-sub">Distribution by waiting time</span>
            </div>
            <div class="chart-wrap"><canvas id="waitingChart"></canvas></div>
        </div>
    </div>

    <!-- ── Charts Row 2: Satisfaction + Intent + Responses by Year ── -->
    <div class="chart-grid-3">
        <div class="section-card" style="margin-bottom:0">
            <div class="section-title">Work Satisfaction</div>
            <div class="chart-wrap" style="height:230px"><canvas id="satChart"></canvas></div>
        </div>
        <div class="section-card" style="margin-bottom:0">
            <div class="section-title">Career Intent</div>
            <div class="chart-wrap" style="height:230px"><canvas id="intentChart"></canvas></div>
        </div>
        <div class="section-card" style="margin-bottom:0">
            <div class="section-title">Responses by Batch Year</div>
            <div class="chart-wrap" style="height:230px"><canvas id="yearChart"></canvas></div>
        </div>
    </div>

    <!-- ── Charts Row 3: Performance Ratings + Top Competencies ── -->
    <div class="chart-grid-2">
        <div class="section-card" style="margin-bottom:0">
            <div class="section-title">
                Avg. Workplace Performance Ratings
                <span class="section-sub">Self-assessed (1–5)</span>
            </div>
            <div class="chart-wrap"><canvas id="perfChart"></canvas></div>
        </div>
        <div class="section-card" style="margin-bottom:0">
            <div class="section-title">
                Top Key Competencies
                <span class="section-sub">As cited by alumni</span>
            </div>
            <div class="chart-wrap"><canvas id="compChart"></canvas></div>
        </div>
    </div>

    <!-- ── Data Table ── -->
    <div class="section-card">
        <div class="section-title">
            Alumni Tracer Responses
            <span class="section-sub"><?= $tracer_summary['total_responses'] ?> total</span>
        </div>

        <!-- Filter -->
        <form method="get" action="<?= base_url('AdminReports/tracer_report') ?>" class="filter-bar">
            <div class="row align-items-end">
                <div class="col-md-3 mb-3 mb-md-0">
                    <label>Graduation Year</label>
                    <select name="grad_year">
                        <option value="">All Years</option>
                        <?php for ($y = date('Y'); $y >= 1980; $y--): ?>
                            <option value="<?= $y ?>" <?= (($filters['grad_year'] ?? '') == $y) ? 'selected':'' ?>>Batch <?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <label>Date Range (Submitted)</label>
                    <div class="d-flex gap-2">
                        <input type="date" name="date_from" value="<?= $filters['date_from'] ?? '' ?>">
                        <input type="date" name="date_to"   value="<?= $filters['date_to']   ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-5 d-flex gap-2">
                    <button type="submit" class="btn-act btn-primary flex-fill justify-content-center">Apply Filters</button>
                    <a href="<?= base_url('AdminReports/tracer_report') ?>" class="btn-act btn-outline"><i class="fas fa-undo"></i></a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Alumni</th>
                        <th>Batch</th>
                        <th>Ratings</th>
                        <th>Wait Time</th>
                        <th>Satisfaction</th>
                        <th>Intent</th>
                        <th>Competencies</th>
                        <th>Perf. Ratings</th>
                        <th>Submitted</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($tracer_rows)): ?>
                    <?php foreach ($tracer_rows as $row): ?>
                    <?php
                        $comps_arr = @json_decode($row['competencies'] ?? '', true);
                        $perfs_arr = @json_decode($row['performance_ratings'] ?? '', true);
                    ?>
                    <tr class="dr">
                        <td>
                            <div style="font-weight:700"><?= htmlspecialchars($row['first_name'].' '.$row['last_name']) ?></div>
                            <div style="font-size:11px;color:var(--text-muted)"><?= htmlspecialchars($row['email']) ?></div>
                            <?php if (!empty($row['alumni_number'])): ?>
                            <div style="font-size:11px;color:var(--text-muted)">#<?= htmlspecialchars($row['alumni_number']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight:700"><?= htmlspecialchars($row['year_graduated']) ?></td>
                        <td>
                            <div style="display:flex;gap:4px;flex-wrap:wrap">
                                <?php foreach([1,2,3,4] as $ri): ?>
                                    <?php $rv = $row['rating_'.$ri] ?? 0; if($rv): ?>
                                    <span class="badge badge-<?= $rv ?>" title="R<?=$ri?>: <?= ['','Curriculum','Teaching','Skills','Career'][$ri] ?>"><?= $rv ?>★</span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td>
                            <?php if (!empty($row['waiting_time'])): ?>
                            <span class="badge badge-wait"><?= htmlspecialchars($row['waiting_time']) ?></span>
                            <?php else: ?><span style="color:var(--text-muted);font-size:11px">—</span><?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($row['satisfaction'])): ?>
                            <span class="badge badge-sat"><?= htmlspecialchars($row['satisfaction']) ?></span>
                            <?php else: ?><span style="color:var(--text-muted);font-size:11px">—</span><?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($row['intent'])): ?>
                            <span class="badge badge-intent"><?= htmlspecialchars($row['intent']) ?></span>
                            <?php else: ?><span style="color:var(--text-muted);font-size:11px">—</span><?php endif; ?>
                        </td>
                        <td style="max-width:160px">
                            <?php if (is_array($comps_arr) && !empty($comps_arr)): ?>
                                <?php foreach (array_slice($comps_arr,0,3) as $c): ?>
                                <div style="font-size:11px;background:#f1f5f9;border-radius:6px;padding:2px 7px;margin-bottom:3px;display:inline-block"><?= htmlspecialchars($c) ?></div>
                                <?php endforeach; ?>
                                <?php if (count($comps_arr)>3): ?><div style="font-size:10px;color:var(--text-muted)">+<?= count($comps_arr)-3 ?> more</div><?php endif; ?>
                            <?php elseif(!empty($row['competencies'])): ?>
                                <div style="font-size:11px;color:var(--text-muted)"><?= htmlspecialchars(substr($row['competencies'],0,80)) ?></div>
                            <?php else: ?><span style="color:var(--text-muted);font-size:11px">—</span><?php endif; ?>
                        </td>
                        <td>
                            <?php if (is_array($perfs_arr) && !empty($perfs_arr)): ?>
                            <div class="perf-mini">
                                <?php foreach ($perfs_arr as $pi => $pv): ?>
                                <div class="perf-dot" style="background:<?= perf_color($pv) ?>" title="<?= htmlspecialchars($perf_labels[$pi] ?? 'P'.($pi+1)) ?>: <?= $pv ?>"><?= $pv ?></div>
                                <?php endforeach; ?>
                            </div>
                            <?php else: ?><span style="color:var(--text-muted);font-size:11px">—</span><?php endif; ?>
                        </td>
                        <td style="font-size:11px;color:var(--text-muted);white-space:nowrap"><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center py-5 text-muted">No tracer responses found for the selected filters.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ── Chart.js ── -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
    const palette = ['#a12124','#3b82f6','#10b981','#f59e0b','#8b5cf6','#f97316','#06b6d4','#ec4899'];

    /* 1. Ratings Radar / Bar */
    new Chart(document.getElementById('ratingsChart'), {
        type: 'bar',
        data: {
            labels: ['Curriculum\nRelevance','Teaching\nQuality','Skills\nDevelopment','Career\nPreparation'],
            datasets: [{
                label: 'Avg Rating',
                data: [
                    <?= $tracer_summary['avg_rating_1'] ?>,
                    <?= $tracer_summary['avg_rating_2'] ?>,
                    <?= $tracer_summary['avg_rating_3'] ?>,
                    <?= $tracer_summary['avg_rating_4'] ?>
                ],
                backgroundColor: ['#10b981','#3b82f6','#8b5cf6','#f59e0b'],
                borderRadius: 10,
            }]
        },
        options: {
            responsive:true, maintainAspectRatio:false,
            plugins:{ legend:{display:false} },
            scales:{
                y:{ min:0, max:5, ticks:{stepSize:1}, grid:{color:'#f1f5f9'} },
                x:{ grid:{display:false} }
            }
        }
    });

    /* 2. Waiting Time Doughnut */
    const waitLabels = <?= json_encode(array_keys($tracer_summary['waiting_time_dist'])) ?>;
    const waitData   = <?= json_encode(array_values($tracer_summary['waiting_time_dist'])) ?>;
    if (waitLabels.length) {
        new Chart(document.getElementById('waitingChart'), {
            type:'doughnut',
            data:{ labels:waitLabels, datasets:[{ data:waitData, backgroundColor:palette, borderWidth:2, borderColor:'#fff' }] },
            options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ position:'right', labels:{font:{size:11},padding:12} } } }
        });
    }

    /* 3. Satisfaction Pie */
    const satLabels = <?= json_encode(array_keys($tracer_summary['satisfaction_dist'])) ?>;
    const satData   = <?= json_encode(array_values($tracer_summary['satisfaction_dist'])) ?>;
    if (satLabels.length) {
        new Chart(document.getElementById('satChart'), {
            type:'pie',
            data:{ labels:satLabels, datasets:[{ data:satData, backgroundColor:palette, borderWidth:2, borderColor:'#fff' }] },
            options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ position:'bottom', labels:{font:{size:11},padding:8} } } }
        });
    }

    /* 4. Intent Bar */
    const intentLabels = <?= json_encode(array_keys($tracer_summary['intent_dist'])) ?>;
    const intentData   = <?= json_encode(array_values($tracer_summary['intent_dist'])) ?>;
    if (intentLabels.length) {
        new Chart(document.getElementById('intentChart'), {
            type:'bar',
            data:{ labels:intentLabels, datasets:[{ label:'Count', data:intentData, backgroundColor:'#8b5cf6', borderRadius:8 }] },
            options:{ indexAxis:'y', responsive:true, maintainAspectRatio:false,
                plugins:{ legend:{display:false} },
                scales:{ x:{grid:{color:'#f1f5f9'}}, y:{grid:{display:false},ticks:{font:{size:10}}} }
            }
        });
    }

    /* 5. Responses by Year */
    const yearLabels = <?= json_encode(array_keys($tracer_summary['responses_by_year'])) ?>;
    const yearData   = <?= json_encode(array_values($tracer_summary['responses_by_year'])) ?>;
    if (yearLabels.length) {
        new Chart(document.getElementById('yearChart'), {
            type:'bar',
            data:{ labels:yearLabels, datasets:[{ label:'Responses', data:yearData, backgroundColor:'#a12124', borderRadius:8 }] },
            options:{ responsive:true, maintainAspectRatio:false,
                plugins:{ legend:{display:false} },
                scales:{ y:{grid:{color:'#f1f5f9'},ticks:{precision:0}}, x:{grid:{display:false}} }
            }
        });
    }

    /* 6. Performance Ratings Horizontal Bar */
    const perfLabels = <?= json_encode($perf_labels) ?>;
    const perfData   = <?= json_encode(array_values($tracer_summary['performance_avg'])) ?>;
    if (perfData.length) {
        new Chart(document.getElementById('perfChart'), {
            type:'bar',
            data:{ labels:perfLabels, datasets:[{ label:'Avg Rating', data:perfData, backgroundColor:'#3b82f6', borderRadius:8 }] },
            options:{
                indexAxis:'y', responsive:true, maintainAspectRatio:false,
                plugins:{ legend:{display:false} },
                scales:{ x:{min:0,max:5,grid:{color:'#f1f5f9'}}, y:{grid:{display:false},ticks:{font:{size:10}}} }
            }
        });
    } else {
        document.getElementById('perfChart').parentElement.innerHTML =
            '<p class="text-center text-muted py-5" style="font-size:13px">No performance rating data yet.</p>';
    }

    /* 7. Top Competencies */
    const compAll    = <?= json_encode($tracer_summary['competency_freq']) ?>;
    const compKeys   = Object.keys(compAll).slice(0,8);
    const compVals   = compKeys.map(k => compAll[k]);
    if (compKeys.length) {
        new Chart(document.getElementById('compChart'), {
            type:'bar',
            data:{ labels:compKeys, datasets:[{ label:'Frequency', data:compVals, backgroundColor:'#f59e0b', borderRadius:8 }] },
            options:{
                indexAxis:'y', responsive:true, maintainAspectRatio:false,
                plugins:{ legend:{display:false} },
                scales:{ x:{grid:{color:'#f1f5f9'},ticks:{precision:0}}, y:{grid:{display:false},ticks:{font:{size:10}}} }
            }
        });
    } else {
        document.getElementById('compChart').parentElement.innerHTML =
            '<p class="text-center text-muted py-5" style="font-size:13px">No competency data yet.</p>';
    }
})();
</script>
<?php
/* PHP var for JS */
$perf_labels_js = json_encode($perf_labels);
?>
<script>
// expose perf labels globally in case needed
window._perfLabels = <?= json_encode($perf_labels) ?>;
</script>