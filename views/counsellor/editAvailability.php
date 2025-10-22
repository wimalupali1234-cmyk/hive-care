<?php
// expects maybe data like $availability (array) to pre-fill form, if you have it
require_once __DIR__ . '/header.php';
?>
<main class="container">
    <section class="content-section">
        <div class="section-header">
            <h2>Edit My Availability</h2>
        </div>

        <form method="post" action="index.php?action=counsellorEditAvailability">
            <p>Add or update your available time slots:</p>

            <div id="slots">
                <div class="slot">
                    <label>Date: <input type="date" name="availability[0][date]" required></label>
                    <label>Start: <input type="time" name="availability[0][start_time]" required></label>
                    <label>End: <input type="time" name="availability[0][end_time]" required></label>
                </div>
                <div class="slot">
                    <label>Date: <input type="date" name="availability[1][date]"></label>
                    <label>Start: <input type="time" name="availability[1][start_time]"></label>
                    <label>End: <input type="time" name="availability[1][end_time]"></label>
                </div>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update Availability</button>
            <a href="index.php?action=counsellorListSessions" class="btn btn-warning">Back</a>
        </form>
    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
