<?php
// expects maybe $sessionId and optionally existing notes in $existingNotes
// try to populate $sessionId from local variables or request
if (!isset($sessionId)) {
    if (!empty($_POST['sessionId'])) {
        $sessionId = intval($_POST['sessionId']);
    } elseif (!empty($_GET['sessionId'])) {
        $sessionId = intval($_GET['sessionId']);
    } else {
        $sessionId = null;
    }
}

require_once __DIR__ . '/header.php';
?>
<main class="container">
    <?php if (empty($sessionId)): ?>
        <div class="content-section">
            <h2>Session Notes</h2>
            <p class="muted">No session ID provided. <a href="index.php?action=counsellorListSessions">Return to dashboard</a></p>
        </div>
    <?php else: ?>
        <h1>Session Notes (Session #<?php echo htmlspecialchars($sessionId); ?>)</h1>

        <form method="post" action="index.php?action=counsellorSaveNotes">
            <input type="hidden" name="sessionId" value="<?php echo htmlspecialchars($sessionId); ?>">
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="10" class="form-control"><?php echo htmlspecialchars(isset($existingNotes) ? $existingNotes : ''); ?></textarea>
            </div>
            <button type="submit" name="save" class="btn btn-success">Save Notes</button>
            <a href="index.php?action=counsellorListSessions" class="btn btn-warning">Back</a>
        </form>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
