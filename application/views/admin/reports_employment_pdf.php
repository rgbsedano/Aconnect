<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employment Report</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #333; padding: 4px 6px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Employment / Tracer Report</h2>
    <p>Generated: <?= date('F j, Y g:ia') ?></p>
    <table>
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
            <?php if (!empty($rows)): $i=1; foreach ($rows as $r): ?>
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
                <tr><td colspan="10" style="text-align:center;">No records available.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
