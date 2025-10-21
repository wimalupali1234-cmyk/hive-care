<?php
// Temporary counts for UI only (no DB)
$doctor_count = 12;
$counsellor_count = 5;
$labtech_count = 3;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Management - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
</head>
<body>

<!-- Header (same style as Manage Doctors) -->
<header class="header">
  <h1><i class="fas fa-users-cog"></i> Staff Management</h1>
  <a href="index.php?action=hospitalAdminDashboard" class="back-link">Back to Dashboard</a>
</header>

<!-- Main Section -->
<div class="main-container">

  <!-- Staff Cards -->
  <div class="hospital-grid">

    <!-- Doctors -->
    <a href="index.php?action=hospitalAdminDoctors" class="hospital-card" style="text-decoration: none; color: inherit;">
      <div class="card-icon"><i class="fas fa-user-md"></i></div>
      <h3>Doctors</h3>
      <p>Total: <?= $doctor_count ?></p>
    </a>

    <!-- Counsellors -->
    <a href="index.php?action=hospitalAdminCounsellors" class="hospital-card" style="text-decoration: none; color: inherit;">
      <div class="card-icon"><i class="fas fa-hand-holding-heart"></i></div>
      <h3>Counsellors</h3>
      <p>Total: <?= $counsellor_count ?></p>
    </a>

    <!-- Lab Technicians -->
    <a href="index.php?action=hospitalAdminLabTech" class="hospital-card" style="text-decoration: none; color: inherit;">
      <div class="card-icon"><i class="fas fa-flask"></i></div>
      <h3>Lab Technicians</h3>
      <p>Total: <?= $labtech_count ?></p>
    </a>

  </div>

</div> <!-- .main-container -->

</body>
</html>
