<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Inventory management - HIV Support Portal</title>
  <meta name="description" content="Learn about different types of facility-based HIV testing including viral load, STI, Hepatitis B and C testing.">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>


<body>
  
  
    <!-- Header Section -->
<header class="header">
  <div class="container">
    <div class="logo">
      <h1><i class="fas fa-heartbeat"></i> HIVeCare</h1>
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="NGOadmin.html">Profile</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="helpadmin.html">Help</a></li>
        <li><a href="contact.html">Contact</a></li>
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

 <!-- About Hero Section -->
  <section class="about-hero">
    <div class="container">
      <h1>Inventory management</h1>
    </div>
  </section>

  <!-- Main Categories Section -->
  <section class="categories">
    <div class="container">
      <div class="category-grid">

       

        <a href="index.php?action=hospitalAdminTestKits" class="category-card">
  <div class="card-icon"><i class="fas fa-vial"></i></div>
  <h3>Testing Kits</h3>
</a>

<a href="index.php?action=hospitalAdminPreventiveMed" class="category-card">
  <div class="card-icon"><i class="fas fa-pills"></i></div>
  <h3>Preventive Medication</h3>
</a>

<a href="index.php?action=hospitalAdminFacilityTest" class="category-card">
  <div class="card-icon"><i class="fas fa-hospital"></i></div>
  <h3>Facility Based Tests</h3>
</a>

<a href="index.php?action=hospitalAdminOtherMaterial" class="category-card">
  <div class="card-icon"><i class="fas fa-box-open"></i></div>
  <h3>Other Materials</h3>
</a>

      </div>
    </div>
  </section>

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
          <li><a href="testing.php">Testing Centers</a></li>
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
</body>
</html>