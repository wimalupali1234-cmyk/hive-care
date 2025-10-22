<?php
// expects maybe $sessionId and optionally existing notes in $existingNotes
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add / Edit Session Notes</title>
</head>
<body>
    <h1>Session Notes (Session #<?= htmlspecialchars($sessionId) ?>)</h1>

    <form method="post" action="index.php?action=counsellorSaveNotes">
        <input type="hidden" name="sessionId" value="<?= htmlspecialchars($sessionId) ?>">
        <p>Notes:</p>
        <textarea name="notes" rows="10" cols="80"><?= htmlspecialchars($existingNotes ?? '') ?></textarea>
        <br>
        <button type="submit" name="save">Save Notes</button>
    </form>

    <p><a href="index.php?action=counsellorListSessions">Back to Sessions</a></p>
</body>
</html>
