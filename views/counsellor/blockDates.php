<?php
// expects optional $blockedDates (array) and $message
require_once __DIR__ . '/header.php';
$blockedDates = isset($blockedDates) ? $blockedDates : array();
$message = isset($message) ? $message : '';
?>
<div class="main-container">

    <?php if (!empty($message)): ?>
        <div class="success-msg"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <header class="header-top">
        <h1><i class="fas fa-ban"></i> Block Dates</h1>
        <a href="index.php?action=counsellorListSessions" class="back-link">Back to Dashboard</a>
    </header>

    <!-- Stats -->
    <div class="stats">
        <div class="stat-box">
            <div class="stat-number"><?php echo count($blockedDates); ?></div>
            <div>Blocked Dates</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">0</div>
            <div>Upcoming Conflicts</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">0</div>
            <div>Requests</div>
        </div>
    </div>

    <!-- Filter / Search -->
    <form class="filters" method="get" action="">
        <input type="text" name="q" placeholder="Search blocked dates...">
        <select name="status" aria-label="Filter status">
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="expired">Expired</option>
        </select>
        <button type="submit" class="filter-btn">Filter</button>
    </form>

    <div class="manage-container">

        <!-- Left Column (Add Form) -->
        <div class="left-column">
            <h2>Add Block Date</h2>
            <form method="post" action="index.php?action=counsellorBlockDates">
                <label>Date: <input type="date" name="date" required></label>
                <label>Reason: <input type="text" name="reason" placeholder="Reason (optional)"></label>
                <label>All day: <select name="all_day"><option value="1">Yes</option><option value="0">No</option></select></label>
                <button type="submit" name="block" class="add-btn">+ Block Date</button>
            </form>
        </div>

        <!-- Right Column (Blocked Date Cards) -->
        <div class="right-column">
            <div class="hospital-grid">
                <?php if (!empty($blockedDates)): ?>
                    <?php foreach ($blockedDates as $bd): ?>
                        <div class="hospital-card">
                            <h3><i class="fas fa-calendar-times"></i> <?php echo htmlspecialchars(isset($bd['date']) ? $bd['date'] : ''); ?></h3>
                            <p><?php echo htmlspecialchars(isset($bd['reason']) ? $bd['reason'] : 'No reason provided'); ?></p>
                            <p><i class="fas fa-clock"></i> <?php echo htmlspecialchars(isset($bd['all_day']) && $bd['all_day'] ? 'All day' : 'Partial'); ?></p>
                            <span class="status Active">Active</span>
                            <div class="actions">
                                <a href="index.php?action=counsellorEditBlock&date=<?php echo urlencode(isset($bd['date']) ? $bd['date'] : ''); ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                <a href="index.php?action=counsellorRemoveBlock&date=<?php echo urlencode(isset($bd['date']) ? $bd['date'] : ''); ?>" class="btn-delete" onclick="return confirm('Remove this blocked date?')"><i class="fas fa-trash"></i> Remove</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="muted">No blocked dates found.</div>
                <?php endif; ?>
            </div>
        </div>

    </div> <!-- .manage-container -->

</div> <!-- .main-container -->

<?php require_once __DIR__ . '/footer.php'; ?>
