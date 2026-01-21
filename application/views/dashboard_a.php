<style>
    /* LinkedIn-style Dashboard Layout */
    .dashboard-container {
        max-width: 1128px;
        margin: 0 auto;
        padding: 24px 15px;
        font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", "Fira Sans", Ubuntu, Oxygen, "Oxygen Sans", Cantarell, "Droid Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Lucida Grande", Helvetica, Arial, sans-serif;
    }

    .analytics-section {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 0 0 1px rgba(0,0,0,0.02);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0f0f0;
    }

    .section-header h2 {
        font-size: 20px;
        font-weight: 600;
        color: rgba(0,0,0,0.9);
        margin: 0;
    }

    /* Chart Container */
    .chart-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px 0;
    }

    /* Grid for Widgets */
    .dashboard-widgets {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }

    /* Professional Card Design */
    .widget {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 16px;
        transition: box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
    }

    .widget:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .widget-header {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }

    .widget-icon-container {
        width: 48px;
        height: 48px;
        background: #f3f2ef;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
    }

    .widget-icon-container img {
        width: 24px;
        height: 24px;
        object-fit: contain;
    }

    .widget-info {
        flex-grow: 1;
    }

    .widget-title {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: rgba(0,0,0,0.6);
    }

    .widget-value {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: rgba(0,0,0,0.9);
    }

    /* LinkedIn-style Action Button */
    .widget-button {
        margin-top: 16px;
        padding: 6px 16px;
        border: 1px solid var(--primary-color);
        background: transparent;
        color: var(--primary-color);
        border-radius: 16px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s;
        display: inline-block;
    }

    .widget-button:hover {
        background: rgba(112, 10, 10, 0.05);
        border-width: 2px;
        padding: 5px 15px;
        color: var(--primary-color);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .chart-wrapper #alumniChart {
            width: 100% !important;
        }
    }
</style>

<div class="dashboard-container">
    <section class="analytics-section">
        <div class="section-header">
            <h2><i class="fas fa-chart-pie mr-2" style="color: var(--primary-color);"></i> Alumni Analytics</h2>
            <span class="text-muted" style="font-size: 12px;">Real-time status</span>
        </div>
        <div class="chart-wrapper">
            <canvas id="alumniChart" style="max-width: 400px; max-height: 400px;"></canvas>
        </div>
    </section>

    <div class="dashboard-widgets">
        <?php
        function widget($icon, $value, $title, $link) {
            $icon_url = base_url("/assets/icons/$icon");
            $target_url = site_url($link);
            echo "
            <div class='widget'>
                <div>
                    <div class='widget-header'>
                        <div class='widget-icon-container'>
                            <img src='{$icon_url}' alt='{$title}'>
                        </div>
                        <div class='widget-info'>
                            <span class='widget-title'>{$title}</span>
                            <span class='widget-value'>{$value}</span>
                        </div>
                    </div>
                </div>
                <a href='{$target_url}' class='widget-button'>Manage</a>
            </div>";
        }

        widget('events.png', $total_events, 'Total Events', 'AdminEvents');
        widget('post.png', $total_post, 'Feed Posts', 'AdminPost');
        widget('job.png', $total_jobs, 'Active Jobs', 'AdminJobPosting');
        widget('user.svg', $total_alumni, 'Alumni Directory', 'AdminAlumni');
        widget('user.svg', $total_accounts, 'System Accounts', 'AdminManageAccounts');
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('alumniChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Active Members', 'Inactive Members'],
                datasets: [{
                    data: [<?= $active_users ?>, <?= $inactive_users ?>],
                    backgroundColor: ['#057642', '#d11124'],
                    hoverOffset: 4,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 13 }
                        }
                    }
                }
            }
        });
    });
</script>