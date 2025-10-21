<?php
// no specific data needed beyond possible message
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Block Unavailable Dates</title>
</head>
<body>
    <h1>Block Unavailable Dates</h1>

    <form method="post" action="index.php?action=counsellorBlockDates">
        <p>Select dates you will *not* be available for counselling:</p>

        <div id="dates">
            <input type="date" name="dates[]" required>
            <input type="date" name="dates[]">
            <input type="date" name="dates[]">
            <!-- add more inputs dynamically as needed -->
        </div>

        <button type="submit" name="block">Block Dates</button>
    </form>

    <p><a href="index.php?action=counsellorListSessions">Back to Sessions</a></p>
</body>
</html>
