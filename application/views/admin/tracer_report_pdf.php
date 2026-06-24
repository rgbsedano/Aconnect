<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tracer Study Report</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; line-height: 1.4; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #34495e; color: white; font-weight: bold; }
        tr:nth-child(even) { background: #ecf0f1; }
        h2 { color: #34495e; border-bottom: 2px solid #34495e; padding-bottom: 8px; }
        .meta { color: #7f8c8d; font-size: 9px; }
        .no-data { text-align: center; padding: 20px; color: #7f8c8d; }
    </style>
</head>
<body>
    <h2>Tracer Study Report</h2>
    <p class="meta">Generated: <?= date('F j, Y g:ia') ?></p>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Alumni Name</th>
                <th>Alumni Number</th>
                <th>Email</th>
                <th>Year Graduated</th>
                <th>Rating 1</th>
                <th>Rating 2</th>
                <th>Rating 3</th>
                <th>Rating 4</th>
                <th>Waiting Time</th>
                <th>Key Competencies</th>
                <th>Submitted</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rows)): $i=1; foreach ($rows as $r): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($r['last_name'].', '.$r['first_name']) ?></td>
                    <td><?= htmlspecialchars($r['alumni_number'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($r['email']) ?></td>
                    <td><?= htmlspecialchars($r['year_graduated']) ?></td>
                    <td><?= (int)$r['rating_1'] ?></td>
                    <td><?= (int)$r['rating_2'] ?></td>
                    <td><?= (int)$r['rating_3'] ?></td>
                    <td><?= (int)$r['rating_4'] ?></td>
                    <td><?= htmlspecialchars($r['waiting_time'] ?? 'Not specified') ?></td>
                    <td><?= htmlspecialchars(substr($r['competencies'] ?? 'N/A', 0, 50)) ?></td>
                    <td><?= $r['created_at'] ?></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="12" class="no-data">No tracer responses available.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
