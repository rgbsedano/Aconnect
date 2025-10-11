<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #700A0A;
            color: white;
        }
    </style>
</head>
<body>

        <div class="print-header-only d-none-print">
            <h2 style="text-align:center;">Activity Logs Report</h2>
            <p style="text-align:center;"><strong>Date Printed:</strong> <?= date('F j, Y g:i A') ?></p>
        </div>
    <table>
        <thead>
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

</body>
</html>
