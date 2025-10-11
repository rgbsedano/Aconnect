<style>
    

.dashboard-widgets {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Creates a responsive grid */
    gap: 1.5rem;
    margin-top: 2rem;
}

.widget {
    background-color: white;
    border-radius: 0.5rem;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.widget-icon img {
    width: 2rem;
    height: 2rem;
    margin-bottom: 0.5rem;
    /* Add styling for your icons */
}

.widget-value {
    font-size: 1.75rem;
    font-weight: bold;
    color: #232d42;
}

.widget-title {
    color: #8a92a6;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.widget-button {
    background-color: #700A0A; /* Example button color */
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    cursor: pointer;
    font-size: 0.875rem;
    transition: background-color 0.2s ease;
}

.widget-button:hover {
    background-color: #e94040;
    
}

.job-section { padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 20px; }
</style>

<!-- edit content start here-->

<div class="container-fluid">
          <!-- Page Heading -->
         

<!-- Content Row 1 -->
<div class="dashboard-container">
      
        <main class="main-content" class>
            
            <div class="content-area">
                
                <h2>📊 Alumni Status Overview</h2>
                <canvas id="alumniChart" style=" width: 50%;
  max-height: 60%;" ></canvas>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('alumniChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Active Users', 'Inactive Users'],
                            datasets: [{
                                label: 'Alumni Status',
                                data: [<?= $active_users ?>, <?= $inactive_users ?>],
                                backgroundColor: ['#4CAF50', '#FF7043'],
                                borderColor: ['#388E3C', '#E64A19'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom' },
                                title: { display: true, text: 'Active vs Inactive Alumni' }
                            }
                        }
                    });
                </script>

                <div class="dashboard-widgets">
                    <?php
                    function widget($icon, $value, $title, $link) {
                        echo "
                        <div class='widget'>
                            <div class='widget-icon'><img src='" . base_url("/assets/icons/$icon") . "' alt='$title'></div>
                            <div class='widget-info'>
                                <span class='widget-value'>$value</span><br>
                                <span class='widget-title'>$title</span>
                            </div>
                            <a href='" . site_url($link) . "' class='widget-button'>View Details</a>
                        </div>";
                    }

                    widget('events.png', $total_events, 'Total Events', 'AdminEvents');
                    widget('post.png', $total_post, 'Post', 'AdminPost');
                    widget('job.png', $total_jobs, 'Total Job Posts', 'AdminJobPosting');
                    widget('user.svg', $total_alumni, 'Total Alumni Members', 'AdminAlumni');
                    widget('user.svg', $total_accounts, 'Total Active Users', 'AdminManageAccounts');
                    ?>
                </div>  
            </div>
        </main>
    </div>


  

</div> <!-- /.container-fluid -->
<!-- end of content-->
</div>


