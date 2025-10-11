<div class="container-fluid">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Activity Logs</h3>
        <div>
            <button onclick="printLogs()" class="btn btn-sm btn-outline-primary mr-2">🖨️ Print</button>
            <a href="<?= base_url('adminactivitylog/download?search=' . urlencode($this->input->get('search'))) ?>" class="btn btn-sm btn-outline-success mr-2">⬇️ Excel</a>
            <a href="<?= base_url('adminactivitylog/download_pdf?search=' . urlencode($this->input->get('search'))) ?>" class="btn btn-sm btn-outline-danger">⬇️ PDF</a>
        </div>
        </div>

        <!-- Search Form -->
        <form method="get" class="mb-3" id="searchForm">
        <div class="input-group">
            <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search by name or activity..." value="<?= $this->input->get('search') ?>">
            <?php if ($this->input->get('search')): ?>
                <div class="input-group-append">
                    <button type="button" class="btn btn-light" id="clearSearch">&times;</button>
                </div>
            <?php endif; ?>
            <div class="input-group-append">
            <button class="btn text-white" style="background:#700A0A;" type="submit">Search</button>
        </div>
    </div>
        </form>

    <!-- Printable Section -->
    <div id="printSection">
        <div class="print-header-only d-none-print">
            <h2 style="text-align:center;">Activity Logs Report</h2>
            <p style="text-align:center;"><strong>Date Printed:</strong> <?= date('F j, Y g:i A') ?></p>
        </div>
      <table class="table table-bordered table-striped">
        <thead style="background-color: #700A0A; color: white; -webkit-print-color-adjust: exact;">
          <tr>
            <th>Alumni Name</th>
            <th>Activity</th>
            <th>Date & Time</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($logs)): ?>
            <?php foreach ($logs as $log): ?>
              <tr>
                <td><?= $log->first_name . ' ' . $log->last_name ?></td>
                <td><?= $log->activity ?></td>
                <td><?= date('F j, Y g:i A', strtotime($log->created_at)) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="3">No logs found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      <div class="print-footer print-header-only">
        <p style="text-align:center; font-size:12px;">
            Page <?= $current_page ?> of <?= $total_pages ?> — Activity Logs Report
        </p>
        </div>
    </div>



        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            <?= $pagination ?>
        </div>
    </div>
</div>
<script>
  document.getElementById('clearSearch')?.addEventListener('click', function () {
    document.getElementById('searchInput').value = '';
    document.getElementById('searchForm').submit();
  });

  function printLogs() {
    const printContents = document.getElementById('printSection').innerHTML;
    const originalContents = document.body.innerHTML;

    
    window.print();
    document.body.innerHTML = originalContents;
    location.reload(); // reload to restore scripts
  }
</script>


<!-- Print Styles -->
<style>
  /* Hide on screen, show in print */
  .print-header-only {
    display: none;
  }

  @media print {
    body * {
      visibility: hidden;
    }

    #printSection, #printSection * {
      visibility: visible;
    }

    #printSection {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      padding: 20px;
    }

    .print-header-only {
      display: block;
      margin-bottom: 20px;
    }

    .print-header-only h2 {
      margin: 0;
      font-size: 24px;
    }

    .print-header-only p {
      font-size: 14px;
    }

    #printSection table {
      width: 100%;
      border-collapse: collapse;
    }

    #printSection th, #printSection td {
      border: 1px solid black !important;
      padding: 8px;
      text-align: left;
    }

    #printSection th {
      background-color: #700A0A !important;
      color: white !important;
    }
    
  }
  
</style>