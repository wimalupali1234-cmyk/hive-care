<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Admin Dashboard - HIVeCare</title>
  <link rel="stylesheet" href="/HIVe/public/css/style.css">
  <link rel="stylesheet" href="/HIVe/public/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<header class="header">
  <div class="container">
    <div class="logo">
      <h1><i class="fas fa-heartbeat"></i> HIVeCare</h1>
    </div>
    <div class="auth-buttons">
      <nav class="main-nav">
        <ul>
          <li><a href="index.php">Home</a></li>
        </ul>
      </nav>
      <a href="logout.php" class="auth-btn logout-btn">Logout</a>
    </div>
  </div>
</header>

<section class="hero">
  <div class="container">
    <div class="hero-content">
      <h1>System Admin Dashboard</h1>
      <p>Monitor and manage users, hospitals, NGOs, test kits, appointments, content, and reports while overseeing platform activity and feedback.</p>
      <div class="hero-stats">
        <div class="stat-item"><span class="stat-number"><?= $total_hospitals ?></span><span class="stat-label">Hospitals</span></div>
        <div class="stat-item"><span class="stat-number"><?= $total_doctors ?></span><span class="stat-label">Active Doctors</span></div>
        <div class="stat-item"><span class="stat-number"><?= $total_counsellors ?></span><span class="stat-label">Active Counsellors</span></div>
        <div class="stat-item"><span class="stat-number"><?= $total_testkits ?></span><span class="stat-label">Test Kits Distributed</span></div>
        <div class="stat-item"><span class="stat-number"><?= $total_appointments ?></span><span class="stat-label">Appointments</span></div>
      </div>
    </div>
  </div>
</section>

<section class="categories">
  <div class="container">
    <h2>Quick Actions</h2>
    <div class="category-grid">

  <a href="index.php?action=manageHospitals" class="category-card">
        <div class="card-icon"><i class="fas fa-hospital"></i></div>
        <h3>Manage Hospitals</h3>
        <p>Approve/reject hospital registrations and manage hospital profiles.</p>
      </a>

  <a href="index.php?action=manageNGOs" class="category-card">
        <div class="card-icon"><i class="fas fa-hand-holding-heart"></i></div>
        <h3>Manage NGOs</h3>
        <p>Approve/reject NGO registrations and manage NGO profiles.</p>
      </a>

  <a href="index.php?action=manageTestKits" class="category-card">
        <div class="card-icon"><i class="fas fa-vials"></i></div>
        <h3>Test Kits</h3>
        <p>Track distribution, availability, and requests for self-test kits.</p>
      </a>

  <a href="index.php?action=manageAppointments" class="category-card">
        <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
        <h3>Appointments</h3>
        <p>Monitor booked tests, counselling sessions, and overall appointments.</p>
      </a>

  <a href="index.php?action=manageContent" class="category-card">
        <div class="card-icon"><i class="fas fa-upload"></i></div>
        <h3>Upload Content</h3>
        <p>Upload HIV-related content and schedule homepage announcements or events.</p>
      </a>

  <a href="index.php?action=manageFeedback" class="category-card">
        <div class="card-icon"><i class="fas fa-comment-dots"></i></div>
        <h3>Feedback & Queries</h3>
        <p>View and respond to user feedback, queries, and complaints.</p>
      </a>

  <a href="index.php?action=analytics" class="category-card">
        <div class="card-icon"><i class="fas fa-chart-line"></i></div>
        <h3>Platform Analytics</h3>
        <p>View active users, tests booked, counselling sessions completed, and other anonymized platform activity.</p>
      </a>

  <a href="index.php?action=generateReport" class="category-card">
        <div class="card-icon"><i class="fas fa-file-alt"></i></div>
        <h3>Reports</h3>
        <p>Generate system-wide reports—daily, monthly, or custom.</p>
      </a>

  <a href="index.php?action=manageAnnouncements" class="category-card">
        <div class="card-icon"><i class="fas fa-bullhorn"></i></div>
        <h3>Manage Announcements</h3>
        <p>Create and schedule announcements/events.</p>
      </a>

  <a href="index.php?action=accountSettings" class="category-card">
        <div class="card-icon"><i class="fas fa-user-shield"></i></div>
        <h3>Account Settings</h3>
        <p>Change password, log in, or log out of the system securely.</p>
      </a>

    </div>
  </div>
</section>

<section class="announcements">
  <h2>Announcements</h2>
  <?php if(!empty($dashAnnouncements)): ?>
    <?php foreach($dashAnnouncements as $announcement): ?>
      <div class="announcement-card">
        <h4><?= htmlspecialchars($announcement['title']) ?></h4>
        <p><?= nl2br(htmlspecialchars($announcement['description'])) ?></p>
        <span><?= htmlspecialchars($announcement['event_date']) ?></span>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No announcements at the moment.</p>
  <?php endif; ?>
</section>

<footer class="footer">
  <div class="container">
    <p>&copy; 2024 HIVeCare. All rights reserved.</p>
  </div>
</footer>

<script>
const ctx = document.getElementById('analyticsChart')?.getContext('2d');
if(ctx){
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Doctors', 'Tests Booked', 'Counseling Sessions', 'Kit Requests'],
      datasets: [{
        label: 'This Month',
        data: [<?= $total_doctors ?>, <?= $total_appointments ?>, 30, <?= $total_testkits ?>],
        backgroundColor: ['#ff6384','#36a2eb','#ffcd56','#4bc0c0']
      }]
    }
  });
}
</script>

<script src="/HIVe/public/js/dashboard.js"></script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Admin Dashboard - HIVeCare</title>
  <link rel="stylesheet" href="/HIVE/public/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<header class="header">
  <div class="container">
    <div class="logo">
      <h1><i class="fas fa-heartbeat"></i> HIVeCare</h1>
    </div>
    <div class="auth-buttons">
      <nav class="main-nav">
        <ul>
          <li><a href="index.php">Home</a></li>
        </ul>
      </nav>
      <a href="logout.php" class="auth-btn logout-btn">Logout</a>
    </div>
  </div>
</header>

<section class="hero">
  <div class="container">
    <div class="hero-content">
      <h1>System Admin Dashboard</h1>
      <p>Monitor and manage users, hospitals, NGOs, test kits, appointments, content, and reports while overseeing platform activity and feedback.</p>
      <div class="hero-stats">
        <div class="stat-item"><span class="stat-number"><?= $total_hospitals ?></span><span class="stat-label">Hospitals</span></div>
        <div class="stat-item"><span class="stat-number"><?= $total_doctors ?></span><span class="stat-label">Active Doctors</span></div>
        <div class="stat-item"><span class="stat-number"><?= $total_counsellors ?></span><span class="stat-label">Active Counsellors</span></div>
        <div class="stat-item"><span class="stat-number"><?= $total_testkits ?></span><span class="stat-label">Test Kits Distributed</span></div>
        <div class="stat-item"><span class="stat-number"><?= $total_appointments ?></span><span class="stat-label">Appointments</span></div>
      </div>
    </div>
  </div>
</section>

<section class="categories">
  <div class="container">
    <h2>Quick Actions</h2>
    <div class="category-grid">

  <a href="index.php?action=manageHospitals" class="category-card">
        <div class="card-icon"><i class="fas fa-hospital"></i></div>
        <h3>Manage Hospitals</h3>
        <p>Approve/reject hospital registrations and manage hospital profiles.</p>
      </a>

  <a href="index.php?action=manageNGOs" class="category-card">
        <div class="card-icon"><i class="fas fa-hand-holding-heart"></i></div>
        <h3>Manage NGOs</h3>
        <p>Approve/reject NGO registrations and manage NGO profiles.</p>
      </a>

  <a href="index.php?action=manageTestKits" class="category-card">
        <div class="card-icon"><i class="fas fa-vials"></i></div>
        <h3>Test Kits</h3>
        <p>Track distribution, availability, and requests for self-test kits.</p>
      </a>

  <a href="index.php?action=manageAppointments" class="category-card">
        <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
        <h3>Appointments</h3>
        <p>Monitor booked tests, counselling sessions, and overall appointments.</p>
      </a>

  <a href="index.php?action=manageContent" class="category-card">
        <div class="card-icon"><i class="fas fa-upload"></i></div>
        <h3>Upload Content</h3>
        <p>Upload HIV-related content and schedule homepage announcements or events.</p>
      </a>

  <a href="index.php?action=manageFeedback" class="category-card">
        <div class="card-icon"><i class="fas fa-comment-dots"></i></div>
        <h3>Feedback & Queries</h3>
        <p>View and respond to user feedback, queries, and complaints.</p>
      </a>

  <a href="index.php?action=analytics" class="category-card">
        <div class="card-icon"><i class="fas fa-chart-line"></i></div>
        <h3>Platform Analytics</h3>
        <p>View active users, tests booked, counselling sessions completed, and other anonymized platform activity.</p>
      </a>

  <a href="index.php?action=generateReport" class="category-card">
        <div class="card-icon"><i class="fas fa-file-alt"></i></div>
        <h3>Reports</h3>
        <p>Generate system-wide reports—daily, monthly, or custom.</p>
      </a>

  <a href="index.php?action=manageAnnouncements" class="category-card">
        <div class="card-icon"><i class="fas fa-bullhorn"></i></div>
        <h3>Manage Announcements</h3>
        <p>Create and schedule announcements/events.</p>
      </a>

  <a href="index.php?action=accountSettings" class="category-card">
        <div class="card-icon"><i class="fas fa-user-shield"></i></div>
        <h3>Account Settings</h3>
        <p>Change password, log in, or log out of the system securely.</p>
      </a>

    </div>
  </div>
</section>

<section class="announcements">
  <h2>Announcements</h2>
  <?php if(!empty($dashAnnouncements)): ?>
    <?php foreach($dashAnnouncements as $announcement): ?>
      <div class="announcement-card">
        <h4><?= htmlspecialchars($announcement['title']) ?></h4>
        <p><?= nl2br(htmlspecialchars($announcement['description'])) ?></p>
        <span><?= htmlspecialchars($announcement['event_date']) ?></span>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No announcements at the moment.</p>
  <?php endif; ?>
</section>

<footer class="footer">
  <div class="container">
    <p>&copy; 2024 HIVeCare. All rights reserved.</p>
  </div>
</footer>

<script>
const ctx = document.getElementById('analyticsChart')?.getContext('2d');
if(ctx){
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Doctors', 'Tests Booked', 'Counseling Sessions', 'Kit Requests'],
      datasets: [{
        label: 'This Month',
        data: [<?= $total_doctors ?>, <?= $total_appointments ?>, 30, <?= $total_testkits ?>],
        backgroundColor: ['#ff6384','#36a2eb','#ffcd56','#4bc0c0']
      }]
    }
  });
}
</script>

</body>
</html>
