<?php
// expects maybe data like $availability (array) to pre‐fill form, if you have it
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Availability</title>
</head>
<body>
    <h1>Edit My Availability</h1>

    <form method="post" action="index.php?action=counsellorEditAvailability">
        <p>Add or update your available time slots:</p>

        <!-- Example: allow multiple lines. You may use JS to add rows dynamically -->
        <div id="slots">
            <div class="slot">
                Date: <input type="date" name="availability[0][date]" required>
                Start: <input type="time" name="availability[0][start_time]" required>
                End:   <input type="time" name="availability[0][end_time]" required>
            </div>
            <div class="slot">
                Date: <input type="date" name="availability[1][date]">
                Start: <input type="time" name="availability[1][start_time]">
                End:   <input type="time" name="availability[1][end_time]">
            </div>
            <!-- add more as needed -->
        </div>

        <button type="submit" name="update">Update Availability</button>
    </form>

    <p><a href="index.php?action=counsellorListSessions">Back to Sessions</a></p>
</body>
</html>
