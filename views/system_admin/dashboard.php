<?php
// Variables expected from controller: $total_hospitals, $total_doctors, $total_counsellors,
// $total_testkits, $total_appointments, $dashAnnouncements
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
  <style>
    .dashboard-stats { display:flex; gap:20px; flex-wrap:wrap; margin:20px 0; }
    .stat-card { background:#fff; padding:18px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.06); flex:1; min-width:160px; }
    .stat-number { font-size:28px; font-weight:700; color:#1d3557; }
    .announcements { margin-top:24px; }
    .announcement { background:#fff; padding:12px; border-radius:8px; margin-bottom:10px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
    .ann-title { font-weight:600; }
    .muted { color:#666; font-size:13px; }
  </style>
</head>
<body>
  <header class="header">
    <h1><i class="fas fa-tachometer-alt"></i> System Admin Dashboard</h1>
    <a href="index.php?action=manageHospitals" class="back-link">Manage</a>
  </header>

  <div class="container">
    <div class="dashboard-stats">
      <div class="stat-card">
        <div class="stat-number"><?= (int)($total_hospitals ?? 0) ?></div>
        <div>Total Hospitals</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?= (int)($total_doctors ?? 0) ?></div>
        <div>Total Doctors</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?= (int)($total_counsellors ?? 0) ?></div>
        <div>Total Counsellors</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?= (int)($total_testkits ?? 0) ?></div>
        <div>Total Test Kits</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?= (int)($total_appointments ?? 0) ?></div>
        <div>Total Appointments</div>
      </div>
    </div>

    <section class="announcements">
      <h2>Upcoming Announcements</h2>
      <?php if (!empty($dashAnnouncements) && is_array($dashAnnouncements)): ?>
        <?php foreach ($dashAnnouncements as $ann): ?>
          <div class="announcement">
            <div class="ann-title"><?= htmlspecialchars($ann['title'] ?? $ann['TITLE'] ?? 'Untitled') ?></div>
            <div class="muted"><?= htmlspecialchars($ann['date'] ?? $ann['created_at'] ?? '') ?></div>
            <div><?= nl2br(htmlspecialchars($ann['content'] ?? $ann['DESCRIPTION'] ?? '')) ?></div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="muted">No upcoming announcements.</p>
      <?php endif; ?>
    </section>
  </div>
</body>
</html>
