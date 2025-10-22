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
<<<<<<< HEAD
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Management - HIV Support Portal</title>
  <meta name="description" content="Learn about different types of facility-based HIV testing including viral load, STI, Hepatitis B and C testing.">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<!-- Header -->
<header class="header">
  <div class="container">
    <div class="logo">
      <h1><i class="fas fa-heartbeat"></i> HIVeCare</h1>
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="NGOadmin.php">Profile</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="helpadmin.php">Help</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
    <div class="language-switcher">
      <select id="language-select" onchange="changeLanguage(this.value)">
        <option value="en" selected>English</option>
        <option value="si">සිංහල (Sinhala)</option>
      </select>
    </div>
    <button class="mobile-menu-btn" aria-label="Toggle menu">
      <i class="fas fa-bars"></i>
    </button>
  </div>
</header>

<!-- Hero -->
<section class="about-hero">
  <div class="container">
    <h1>Staff Management</h1>
  </div>
</section>

<!-- Staff Cards -->
<div class="container">
  <!-- Doctors -->
  <a href="index.php?action=hospitalAdminDoctors" class="category-card" style="text-decoration: none; color: inherit; display: block;">
  <div class="card-icon"><i class="fas fa-user-md"></i></div>
  <h3>Doctors</h3>
  <p>Total: <?php echo isset($doctor_count) ? $doctor_count : 0; ?></p>
</a>


  <!-- Counsellors -->
<a href="index.php?action=hospitalAdminCounsellors" class="category-card" style="text-decoration: none; color: inherit; display: block;">
  <div class="card-icon"><i class="fas fa-hand-holding-heart"></i></div>
  <h3>Counsellors</h3>
  <p>Total: <?php echo isset($counsellor_count) ? $counsellor_count : 0; ?></p>
</a>

<!-- Lab Technicians -->
<a href="index.php?action=hospitalAdminLabTech" class="category-card" style="text-decoration: none; color: inherit; display: block;">
  <div class="card-icon"><i class="fas fa-flask"></i></div>
  <h3>Lab Technicians</h3>
  <p>Total: <?php echo isset($labtech_count) ? $labtech_count : 0; ?></p>
</a>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-col">
        <h3><i class="fas fa-heartbeat"></i> HIV Support Portal</h3>
        <p>Providing confidential support and resources for people affected by HIV. Your privacy and well-being are our top priorities.</p>
        <div class="social-links">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="helpadmin.php">Help Center</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Resources</h4>
        <ul>
          <li><a href="testing.php">Testing Centers</a></li>
          <li><a href="#">Support Groups</a></li>
          <li><a href="#">Educational Materials</a></li>
          <li><a href="privacy.php">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Contact Us</h4>
        <ul>
          <li><i class="fas fa-phone"></i> 1-800-HIV-HELP</li>
          <li><i class="fas fa-envelope"></i> support@hivportal.org</li>
          <li><i class="fas fa-map-marker-alt"></i> 123 Health St, City</li>
          <li><i class="fas fa-clock"></i> 24/7 Support Available</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2024 HIV Support Portal. All rights reserved.</p>
    </div>
  </div>
</footer>
</body>
</html>
=======
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
>>>>>>> origin/main
