<?php
// expects $userInfo (assoc) and $history (array)
require_once __DIR__ . '/header.php';
?>
<main class="container">
    <section class="content-section">
        <div class="section-header">
            <h2>History for User Code: <?php echo htmlspecialchars(isset($userInfo['user_code']) ? $userInfo['user_code'] : ''); ?></h2>
        </div>

        <p class="muted">Demographics: Gender: <?php echo htmlspecialchars(isset($userInfo['gender']) ? $userInfo['gender'] : ''); ?> | Age Group: <?php echo htmlspecialchars(isset($userInfo['age_group']) ? $userInfo['age_group'] : ''); ?></p>

        <h3>Previous Sessions</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr><th>Date</th><th>Time</th><th>Mode</th><th>Status</th><th>Notes</th></tr>
                </thead>
                <tbody>
                <?php if (!empty($history)): ?>
                        <?php foreach ($history as $h): ?>
                                <tr>
                                        <td><?php echo htmlspecialchars(isset($h['date']) ? $h['date'] : ''); ?></td>
                                        <td><?php echo htmlspecialchars(isset($h['time']) ? $h['time'] : ''); ?></td>
                                        <td><?php echo htmlspecialchars(isset($h['mode']) ? $h['mode'] : ''); ?></td>
                                        <td><?php echo htmlspecialchars(isset($h['status']) ? $h['status'] : ''); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars(isset($h['notes']) ? $h['notes'] : '')); ?></td>
                                </tr>
                        <?php endforeach; ?>
                <?php else: ?>
                        <tr><td colspan="5">No previous sessions found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <p><a href="index.php?action=counsellorListSessions" class="btn btn-warning">Back to Dashboard</a></p>
    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
