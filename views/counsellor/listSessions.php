<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Counselling Sessions</title>
    <link rel="stylesheet" href="/HIVE/public/css/counsellor-styles.css">
</head>
<body>
    <header>
        <h1>Upcoming Counselling Sessions</h1>
        <nav>
            <a href="index.php?action=counsellorEditAvailability">Edit Availability</a>
            <a href="index.php?action=counsellorBlockDates">Block Dates</a>
        </nav>
    </header>

    <main>
        <section class="session-table">
            <table>
                <thead>
                    <tr>
                        <th>Session Code</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Mode</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sessions)): ?>
                        <?php foreach ($sessions as $session): ?>
                            <tr>
                                <td><?= htmlspecialchars($session['session_code']) ?></td>
                                <td><?= htmlspecialchars($session['date']) ?></td>
                                <td><?= htmlspecialchars($session['time']) ?></td>
                                <td><?= htmlspecialchars($session['mode']) ?></td>
                                <td><?= htmlspecialchars($session['status']) ?></td>
                                <td>
                                    <a href="index.php?action=counsellorSaveNotes&sessionId=<?= $session['id'] ?>">Add/Edit Notes</a> |
                                    <a href="index.php?action=counsellorUpdateStatus&sessionId=<?= $session['id'] ?>&status=Completed">Mark Completed</a> |
                                    <a href="index.php?action=counsellorUpdateStatus&sessionId=<?= $session['id'] ?>&status=Missed">Mark Missed</a> |
                                    <a href="index.php?action=counsellorUpdateStatus&sessionId=<?= $session['id'] ?>&status=Rescheduled">Reschedule</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No upcoming sessions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Counsellor Dashboard</p>
    </footer>
</body>
</html>
