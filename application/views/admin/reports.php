<?php
// Ensure $engagement_by_year, $employment_rows, $filters provided by controller
?>
<div class="container mt-4">
  <h3>Reports & Analytics</h3>

  <!-- Engagement Analytics -->
  <div class="card mb-3">
    <div class="card-body">
      <h5>Alumni Engagement by Graduation Year</h5>
      <canvas id="engagementChart" height="120"></canvas>
    </div>
  </div>

  <!-- Filters for Employment/Tracer -->
  <div class="card mb-3">
    <div class="card-body">
      <h5 class="d-flex justify-content-between">
        <span>Tracer / Employment Records</span>
        <span>
          <?php
            // build query string for export links
            $q = http_build_query([
                'grad_year' => isset($filters['grad_year']) ? $filters['grad_year'] : '',
                'status'    => isset($filters['status']) ? $filters['status'] : '',
                'date_from' => isset($filters['date_from']) ? $filters['date_from'] : '',
                'date_to'   => isset($filters['date_to']) ? $filters['date_to'] : ''
            ]);
          ?>
          <a href="<?= base_url('AdminReports/employment_excel') . '?' . $q ?>" class="btn btn-success btn-sm">Export Excel</a>
          <a href="<?= base_url('AdminReports/employment_pdf') . '?' . $q ?>" class="btn btn-danger btn-sm">Export PDF</a>
        </span>
      </h5>

      <form method="get" class="form-inline mb-3" action="<?= base_url('AdminReports') ?>">
        <div class="form-group mr-2">
          <label class="mr-1">Grad Year</label>
          <select name="grad_year" class="form-control form-control-sm">
            <option value="">All</option>
            <?php
            $cur = date('Y');
            for ($y = $cur; $y >= 1980; $y--) {
                $sel = (isset($filters['grad_year']) && $filters['grad_year'] == $y) ? 'selected' : '';
                echo "<option value=\"{$y}\" {$sel}>{$y}</option>";
            }
            ?>
          </select>
        </div>

        <div class="form-group mr-2">
          <label class="mr-1">Status</label>
          <?php $st = isset($filters['status']) ? $filters['status'] : ''; ?>
          <select name="status" class="form-control form-control-sm">
            <option value="">All</option>
            <option value="Employed" <?= $st=='Employed' ? 'selected':'' ?>>Employed</option>
            <option value="Unemployed" <?= $st=='Unemployed' ? 'selected':'' ?>>Unemployed</option>
            <option value="Self-employed" <?= $st=='Self-employed' ? 'selected':'' ?>>Self-employed</option>
          </select>
        </div>

        <div class="form-group mr-2">
          <label class="mr-1">From</label>
          <input type="date" name="date_from" class="form-control form-control-sm" value="<?= isset($filters['date_from']) ? $filters['date_from'] : '' ?>">
        </div>

        <div class="form-group mr-2">
          <label class="mr-1">To</label>
          <input type="date" name="date_to" class="form-control form-control-sm" value="<?= isset($filters['date_to']) ? $filters['date_to'] : '' ?>">
        </div>

        <button type="submit" class="btn btn-primary btn-sm" style="background:#700A0A;border:none">Apply</button>
        <a href="<?= base_url('AdminReports') ?>" class="btn btn-secondary btn-sm ml-2">Reset</a>
      </form>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Alumni</th>
              <th>Email</th>
              <th>Grad Year</th>
              <th>Status</th>
              <th>Company</th>
              <th>Job Title</th>
              <th>Years</th>
              <th>Promotions</th>
              <th>Submitted</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($employment_rows)): $i=1; foreach($employment_rows as $r): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($r['last_name'].', '.$r['first_name']) ?></td>
                <td><?= htmlspecialchars($r['email']) ?></td>
                <td><?= htmlspecialchars($r['graduation_year']) ?></td>
                <td><?= htmlspecialchars($r['employment_status']) ?></td>
                <td><?= htmlspecialchars($r['company_name']) ?></td>
                <td><?= htmlspecialchars($r['job_title']) ?></td>
                <td><?= (int)$r['year_of_service'] ?></td>
                <td><?= (int)$r['promotion_count'] ?></td>
                <td><?= $r['created_at'] ?></td>
              </tr>
            <?php endforeach; else: ?>
              <tr><td colspan="10" class="text-center">No records found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  (function(){
    // Prepare data for engagement chart
    var labels = <?= json_encode(array_column($engagement_by_year, 'graduation_year')) ?>;
    var total = <?= json_encode(array_column($engagement_by_year, 'total_alumni')) ?>;
    var active = <?= json_encode(array_column($engagement_by_year, 'active_alumni')) ?>;
    var events = <?= json_encode(array_column($engagement_by_year, 'event_registrations')) ?>;
    var apps = <?= json_encode(array_column($engagement_by_year, 'job_applications')) ?>;

    var ctx = document.getElementById('engagementChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                { label: 'Total Alumni', data: total, stack: 'Stack 0', backgroundColor: 'rgba(54,162,235,0.6)' },
                { label: 'Active (30d)', data: active, stack: 'Stack 1', backgroundColor: 'rgba(75,192,192,0.6)' },
                { label: 'Event Registrations', data: events, stack: 'Stack 2', backgroundColor: 'rgba(153,102,255,0.6)' },
                { label: 'Job Applications', data: apps, stack: 'Stack 3', backgroundColor: 'rgba(255,159,64,0.6)' },
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: { stacked: false },
                y: { beginAtZero: true }
            }
        }
    });
  })();
</script>
