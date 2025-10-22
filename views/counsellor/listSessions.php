<?php
require_once __DIR__ . '/header.php';
$sessions = isset($sessions) ? $sessions : array();

$total_upcoming = count($sessions);
$sessions_this_month = 0;
$pending_count = 0;
$cancelled_count = 0;
foreach ($sessions as $s) {
    $sdate = isset($s['date']) ? $s['date'] : null;
    $status = isset($s['status']) ? strtolower($s['status']) : '';
    if ($sdate && date('Y-m', strtotime($sdate)) === date('Y-m')) {
        $sessions_this_month++;
    }
    if (strpos($status, 'pending') !== false) $pending_count++;
    if (strpos($status, 'cancel') !== false) $cancelled_count++;
}
?>

<main class="container">
  <section class="hero">
    <div class="container">
      <div class="hero-content">
        <h1>Counsellor Dashboard</h1>
        <p>Manage sessions, notes and availability from here.</p>
        <div class="hero-stats">
          <div class="stat-item"><span class="stat-number"><?php echo (int)$total_upcoming; ?></span><span class="stat-label">Upcoming</span></div>
          <div class="stat-item"><span class="stat-number"><?php echo (int)$sessions_this_month; ?></span><span class="stat-label">This Month</span></div>
          <div class="stat-item"><span class="stat-number"><?php echo (int)$pending_count; ?></span><span class="stat-label">Pending</span></div>
          <div class="stat-item"><span class="stat-number"><?php echo (int)$cancelled_count; ?></span><span class="stat-label">Cancelled</span></div>
        </div>
      </div>
    </div>
  </section>

  <section class="categories">
    <div class="container">
      <h2>Quick Actions</h2>
      <div class="category-grid">
        <a href="index.php?action=counsellorListSessions" class="category-card">
          <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
          <h3>My Sessions</h3>
          <p>View and manage your upcoming counselling sessions.</p>
        </a>

        <a href="index.php?action=counsellorEditAvailability" class="category-card">
          <div class="card-icon"><i class="fas fa-edit"></i></div>
          <h3>Edit Availability</h3>
          <p>Update your available time slots for clients to book.</p>
        </a>

        <a href="index.php?action=counsellorBlockDates" class="category-card">
          <div class="card-icon"><i class="fas fa-ban"></i></div>
          <h3>Block Dates</h3>
          <p>Block days you are not available for counselling.</p>
        </a>

        <a href="index.php?action=counsellorUserHistory" class="category-card">
          <div class="card-icon"><i class="fas fa-user-injured"></i></div>
          <h3>Client History</h3>
          <p>View past sessions and notes for a client.</p>
        </a>
      </div>
    </div>
  </section>

</main>

<?php require_once __DIR__ . '/footer.php'; ?>