<?php
// defensive defaults so view can be included safely
$patientsServed      = $patientsServed ?? 0;
$testKitsDistributed = $testKitsDistributed ?? 0;
$consultationsMade   = $consultationsMade ?? 0;
$pendingAppointments = $pendingAppointments ?? 0;
$careProvided        = $careProvided ?? '0%';

// Dashboard categories
$categories = [
    ['slug' => 'staffmanagement', 'title' => 'Staff Management', 'icon' => 'fa-user-tie'],
    ['slug' => 'patients', 'title' => 'Patient Management', 'icon' => 'fa-user-injured'],
    ['slug' => 'appointments', 'title' => 'Appointment Management', 'icon' => 'fa-calendar-check'],
    ['slug' => 'inventory', 'title' => 'Inventory Management', 'icon' => 'fa-boxes'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NGO Admin Dashboard - HIV Support Portal</title>
  <meta name="description" content="NGO Admin Dashboard">
  <link rel="stylesheet" href="/HIV/NGO%20admin/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <!-- Header Section -->
  <header class="header">
    <div class="container">
      <div class="logo"><h1><i class="fas fa-heartbeat"></i> HIVeCare</h1></div>
      <nav class="main-nav">
        <ul>
          <li><a href="/HIV/Homepage/index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="helpadmin.html">Help</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>

      <div class="auth-buttons">
        <button class="auth-btn login-btn">Logout</button>
        
      </div>

      <div class="language-switcher">
        <select id="language-select" onchange="changeLanguage(this.value)">
          <option value="en" selected>English</option>
          <option value="si">සිංහල (Sinhala)</option>
        </select>
      </div>
      <button class="mobile-menu-btn" aria-label="Toggle menu"><i class="fas fa-bars"></i></button>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    
     <!-- NGO Profile Button -->
  

  <div class="container">
    <div class="hero-content">
    <h1>HIV Services Management Overview</h1>
    <p>Monitor key performance metrics for your organization in real time — from service coverage and care delivery percentages to test kit distribution, consultations completed, and pending appointments. Designed for efficiency and clarity, this platform helps you streamline operations, track impact, and make data-driven decisions to enhance the quality of care your team provides.</p>

    <div class="hero-stats">
  <div class="stat-item">
    <span class="stat-number"><?php echo $patientsServed; ?></span>
    <span class="stat-label">Patients Served</span>
  </div>
  <div class="stat-item">
    <span class="stat-number"><?php echo $careProvided; ?></span>
    <span class="stat-label">% Care Provided</span>
  </div>
  <div class="stat-item">
    <span class="stat-number"><?php echo $testKitsDistributed; ?></span>
    <span class="stat-label">Test Kits Distributed</span>
  </div>
  <div class="stat-item">
    <span class="stat-number"><?php echo $consultationsMade; ?></span>
    <span class="stat-label">Consultations Made</span>
  </div>
  <div class="stat-item">
    <span class="stat-number"><?php echo $pendingAppointments; ?></span>
    <span class="stat-label">Pending Appointments</span>
  </div>
</div>

  </div>
</section>

<main>
<div class="category-grid">
  <!-- Staff management -->
  <a href="index.php?action=staffmanagement" class="category-card" style="text-decoration: none; color: inherit; display: block;">
  <div class="card-icon">
    <i class="fas fa-user-tie"></i> <!-- Professional staff icon -->
  </div>
  <h3>Staff Management</h3>
  </a>


  <!-- Patient management -->
  <a href="index.php?action=patients" class="category-card" style="text-decoration: none; color: inherit; display: block;">
  <div class="card-icon">
    <i class="fas fa-user-injured"></i> 
  </div>
  <h3>Patient Management</h3>
  </a>

  <!-- Inventory management -->
  <a href="index.php?action=inventory" class="category-card" style="text-decoration: none; color: inherit; display: block;">
  <div class="card-icon">
    <i class="fas fa-boxes"></i> 
  </div>
  <h3>Inventory Management</h3>
  </a>

  <!-- Appointment management -->
  <a href="index.php?action=appointments" class="category-card" style="text-decoration: none; color: inherit; display: block;">
  <div class="card-icon">
    <i class="fas fa-calendar-check"></i>
  </div>
  <h3>Appointment Management</h3>
  </a>
</div>

</main>

  <!-- Footer Section -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
          <h3><i class="fas fa-heartbeat"></i> HIV Support Portal</h3>
          <p>Providing confidential support and resources for people affected by HIV. Your privacy and well-being are our top priorities.</p>
          <div class="social-links">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
        <div class="footer-col">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="helpadmin.html">Help Center</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Resources</h4>
          <ul>
            <li><a href="testing.html">Testing Centers</a></li>
            <li><a href="#">Support Groups</a></li>
            <li><a href="#">Educational Materials</a></li>
            <li><a href="privacy.html">Privacy Policy</a></li>
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
        <p>&copy; 2024 HIV Support Portal. All rights reserved. | <a href="privacy.html">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
      </div>
    </div>
  </footer>
  <script src="script.js"></script>
</body>
</html>