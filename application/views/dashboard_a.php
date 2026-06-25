<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #a12124;
        --accent-green: #04b373;
        --accent-blue: #3b59ff;
        --accent-pink: #ff2d55;
        --accent-orange: #ff9500;
        --accent-teal: #00a28a;
        --accent-purple: #5856d6;
        --dark-footer: #1a1e2e;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
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
    }

    .header-section h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 4px;
        color: white;
    }

    .header-section h1 span {
        color: #ff6b6b;
    }

    .header-section p {
        color: rgba(255, 255, 255, 0.85);
        font-size: 14px;
    }

    .main-grid {
        display: grid;
        grid-template-columns: minmax(auto, 300px) 1fr;
        gap: 20px;
        margin-bottom: 0;
    }

    /* Left Column: Alumni Status */
    .status-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: var(--transition);
        height: 100%;
        width: 100%;
    }

    .status-card:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .status-card-header {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .status-card-header h3 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: var(--text-main);
    }

    .status-card-header p {
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin: 2px 0 0 0;
    }

    .chart-container {
        position: relative;
        width: 180px;
        height: 180px;
        margin: 10px 0;
    }

    .chart-center-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .chart-center-text .total-num {
        font-size: 32px;
        font-weight: 800;
        line-height: 1;
        display: block;
    }

    .chart-center-text .total-label {
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 0.5px;
    }

    .legend-container {
        width: 100%;
        margin-top: 20px;
    }

    .legend-row {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-bottom: 20px;
    }

    .legend-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 13px;
        font-weight: 600;
        width: 100%;
    }

    .legend-label {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dot.active { background-color: var(--accent-green); box-shadow: 0 0 8px rgba(4, 179, 115, 0.2); }
    .dot.inactive { background-color: var(--accent-pink); box-shadow: 0 0 8px rgba(255, 45, 85, 0.2); }

    /* Right Column: Metrics Grid */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(2, 1fr);
        gap: 20px;
    }

    .metric-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-decoration: none;
        color: inherit;
        transition: var(--transition);
        border: 1px solid transparent;
        position: relative;
        overflow: hidden;
        min-height: 160px;
    }

    .metric-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1);
        border-color: #f1f5f9;
    }
    
    .metric-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: currentColor;
        opacity: 0;
        transition: var(--transition);
    }
    
    .metric-card:hover::after {
        opacity: 0.5;
    }

    .icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        transition: var(--transition);
    }
    
    .metric-card:hover .icon-box {
        transform: scale(1.1) rotate(-5deg);
    }

    .arrow-icon {
        color: var(--text-muted);
        opacity: 0.3;
        font-size: 14px;
        transition: var(--transition);
    }
    
    .metric-card:hover .arrow-icon {
        opacity: 1;
        transform: translateX(5px);
    }

    .metric-content h4 {
        font-size: 11px;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .metric-value-box {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }

    .metric-value {
        font-size: 28px;
        font-weight: 700;
        transition: var(--transition);
    }
    
    .metric-card:hover .metric-value {
        color: var(--accent-red);
    }




    @media (max-width: 1200px) {
        .metrics-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 1024px) {
        .main-grid {
            grid-template-columns: 1fr;
        }
        .status-card {
            max-width: none;
            margin: 0 0 20px;
        }
    }

    @media (max-width: 640px) {
        .metrics-grid {
            grid-template-columns: 1fr;
        }
        .legend-row {
            flex-direction: row;
            gap: 16px;
            justify-content: center;
        }
        .header-section h1 { font-size: 24px; }
        .dashboard-wrapper { padding: 15px; }
        .metric-card { min-height: 140px; }
        .chart-container { width: 150px; height: 150px; }
    }
</style>

<div class="dashboard-wrapper">
    <header class="header-section">
        <h1>Platform <span>Overview</span></h1>
        <p>Welcome back, Administrator. Here's what's happening today.</p>
    </header>

    <div class="main-grid">
        <!-- Alumni Status Card -->
        <aside class="status-card">
            <div class="status-card-header">
                <div>
                    <h3>Alumni Status</h3>
                    <p>Real-time metrics</p>
                </div>
                <div class="text-muted"><i class="fas fa-chart-pie"></i></div>
            </div>

            <div class="chart-container">
                <canvas id="statusChart"></canvas>
                <div class="chart-center-text">
                    <span class="total-num"><?= $total_users ?></span>
                    <span class="total-label">Members</span>
                </div>
            </div>

            <div class="legend-container">
                <div class="legend-row">
                    <span class="legend-label" style="font-size: 12px; font-weight: 600; color: var(--text-main);">
                        <span class="dot active"></span>
                        Active
                    </span>
                    <span class="legend-label" style="font-size: 12px; font-weight: 600; color: var(--text-main);">
                        <span class="dot inactive"></span>
                        Inactive
                    </span>
                </div>
                
                <div class="legend-item">
                    <span class="legend-label">
                        <span class="dot active"></span> Active
                    </span>
                    <span><?= $total_users > 0 ? round(($active_users / $total_users) * 100) : 0 ?>%</span>
                </div>
                <div class="legend-item">
                    <span class="legend-label">
                        <span class="dot inactive"></span> Inactive
                    </span>
                    <span><?= $total_users > 0 ? round(($inactive_users / $total_users) * 100) : 0 ?>%</span>
                </div>
            </div>
        </aside>

        <!-- Metrics Grid -->
        <main class="metrics-grid">
            <!-- Community Events -->
            <a href="<?= site_url('AdminEvents') ?>" class="metric-card" style="color: var(--accent-blue);">
                <div class="metric-top">
                    <div class="icon-box" style="background-color: var(--accent-blue);">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <i class="fas fa-chevron-right arrow-icon"></i>
                </div>
                <div class="metric-content">
                    <h4>Community Events</h4>
                    <div class="metric-value-box">
                        <span class="metric-value"><?= $total_events ?></span>
                        <span class="growth"><i class="fas fa-caret-up"></i> <?= $growth_events ?></span>
                    </div>
                </div>
            </a>

            <!-- Platform Posts -->
            <a href="<?= site_url('AdminPost') ?>" class="metric-card" style="color: var(--accent-pink);">
                <div class="metric-top">
                    <div class="icon-box" style="background-color: var(--accent-pink);">
                        <i class="fas fa-rss"></i>
                    </div>
                    <i class="fas fa-chevron-right arrow-icon"></i>
                </div>
                <div class="metric-content">
                    <h4>Platform Posts</h4>
                    <div class="metric-value-box">
                        <span class="metric-value"><?= $total_post ?></span>
                        <span class="growth"><i class="fas fa-caret-up"></i> <?= $growth_posts ?></span>
                    </div>
                </div>
            </a>

            <!-- Job Opportunities -->
            <a href="<?= site_url('AdminJobPosting') ?>" class="metric-card" style="color: var(--accent-orange);">
                <div class="metric-top">
                    <div class="icon-box" style="background-color: var(--accent-orange);">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <i class="fas fa-chevron-right arrow-icon"></i>
                </div>
                <div class="metric-content">
                    <h4>Job Opportunities</h4>
                    <div class="metric-value-box">
                        <span class="metric-value"><?= $total_jobs ?></span>
                        <span class="growth"><i class="fas fa-caret-up"></i> <?= $growth_jobs ?></span>
                    </div>
                </div>
            </a>

            <!-- Verified Alumni -->
            <a href="<?= site_url('AdminOfficers') ?>" class="metric-card" style="color: var(--accent-teal);">
                <div class="metric-top">
                    <div class="icon-box" style="background-color: var(--accent-teal);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <i class="fas fa-chevron-right arrow-icon"></i>
                </div>
                <div class="metric-content">
                    <h4>Active Officers</h4>
                    <div class="metric-value-box">
                        <span class="metric-value"><?= $total_officers ?></span>
                        <span class="growth"><i class="fas fa-caret-up"></i> <?= $growth_officers ?></span>
                    </div>
                </div>
            </a>

            <!-- Support Chat -->
            <a href="<?= site_url('support/admin_inbox') ?>" class="metric-card" style="color: var(--accent-purple);">
                <div class="metric-top">
                    <div class="icon-box" style="background-color: var(--accent-purple);">
                        <i class="fas fa-headset"></i>
                    </div>
                    <i class="fas fa-chevron-right arrow-icon"></i>
                </div>
                <div class="metric-content">
                    <h4>Support Chat</h4>
                    <div class="metric-value-box">
                        <span class="metric-value">View</span>
                    </div>
                </div>
            </a>

            <!-- Admin Access -->
            <a href="<?= site_url('AdminManageAccounts') ?>" class="metric-card" style="color: var(--accent-teal);">
                <div class="metric-top">
                    <div class="icon-box" style="background-color: var(--accent-teal);">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <i class="fas fa-chevron-right arrow-icon"></i>
                </div>
                <div class="metric-content">
                    <h4>Admin Access</h4>
                    <div class="metric-value-box">
                        <span class="metric-value"><?= $total_alumni ?></span>
                        <span class="growth"><i class="fas fa-caret-up"></i> <?= $growth_accounts ?></span>
                    </div>
                </div>
            </a>
            
        </main>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('statusChart').getContext('2d');
        
        const statusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    data: [<?= $active_users ?>, <?= $inactive_users ?>],
                    backgroundColor: ['#04b373', '#ff2d55'],
                    borderWidth: 0,
                    hoverOffset: 12
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                legend: { display: false }, 
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#1a1e2e',
                        padding: 10,
                        cornerRadius: 10
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 1200,
                    easing: 'easeOutQuart'
                }
            }
        });

        const cards = document.querySelectorAll('.metric-card, .status-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 60 * (index + 1));
        });
    });
</script>
```