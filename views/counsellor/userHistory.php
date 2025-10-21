<?php
// expects $userInfo (assoc) and $history (array)
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User History for Code <?= htmlspecialchars($userInfo['user_code']) ?></title>
</head>
<body>
    <h1>History for User Code: <?= htmlspecialchars($userInfo['user_code']) ?></h1>

    <p>Demographics: Gender: <?= htmlspecialchars($userInfo['gender']) ?> | Age Group: <?= htmlspecialchars($userInfo['age_group']) ?></p>

    <h2>Previous Sessions</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr><th>Date</th><th>Time</th><th>Mode</th><th>Status</th><th>Notes</th></tr>
        </thead>
        <tbody>
        <?php if (!empty($history)): ?>
            <?php foreach ($history as $h): ?>
                <tr>
                    <td><?= htmlspecialchars($h['date']) ?></td>
                    <td><?= htmlspecialchars($h['time']) ?></td>
                    <td><?= htmlspecialchars($h['mode']) ?></td>
                    <td><?= htmlspecialchars($h['status']) ?></td>
                    <td><?= nl2br(htmlspecialchars($h['notes'])) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No previous sessions found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <p><a href="index.php?action=counsellorListSessions">Back to Sessions</a></p>
</body>
</html>
