
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Counselors of NGO - HIV Support Portal</title>
  <meta name="description" content="Learn about different types of facility-based HIV testing including viral load, STI, Hepatitis B and C testing.">
  <link rel="stylesheet" href="styles.css">
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

<main>
    <div class="container" style="padding: 60px 0;">
    <h1 style="color: var(--primary-color); text-align: center; margin-bottom: 30px;">
      Other Materials Inventory
    </h1>

    <!-- Other Materials Table -->
    <table id="otherTable" style="width: 100%; border-collapse: collapse; background-color: var(--white); box-shadow: var(--box-shadow); border-radius: var(--border-radius); overflow: hidden;">
      <thead>
        <tr style="background-color: #f8f9fa;">
          <th style="padding: 14px 20px; text-align: left;">Material Name</th>
          <th style="padding: 14px 20px; text-align: left;">Stock Available</th>
          <th style="padding: 14px 20px; text-align: left;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>Alcohol swabs and cotton balls</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Tourniquets</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Labels and markers for sample identification</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Biohazard bags for transport</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Pipette tips (sterile, disposable)</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Centrifuge (to separate plasma or serum)</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Micropipettes (for accurate liquid handling)</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Vortex mixer (for mixing samples and reagents)</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Refrigerators (2–8 °C for short-term storage)</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Freezers (−20 °C or −80 °C for long-term storage)</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Incubators (for tests like ELISA)</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Microplates (ELISA plates if applicable)</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Microcentrifuge tubes</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Reservoirs and reagent containers</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Disposable Gloves</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Lab Coats</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Masks</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Face Shields</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Waste disposal containers for sharps and biohazard materials</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
        <tr><td>Pipette fillers or bulb pipettes</td><td>0</td><td><a class="update-btn">Update</a></td></tr>
      </tbody>
    </table>
  </div>

  <script>
    // Enable in-place update for Stock column only
    document.querySelectorAll('.update-btn').forEach(button => {
      button.addEventListener('click', function() {
        const row = this.closest('tr');
        if (this.textContent === 'Update') {
          const stockCell = row.children[1];
          const value = stockCell.textContent;
          stockCell.innerHTML = `<input type="number" value="${value}">`;
          this.textContent = 'Save';
        } else {
          const stockCell = row.children[1];
          const input = stockCell.querySelector('input');
          stockCell.textContent = input.value;
          this.textContent = 'Update';
        }
      });
    });
  </script>
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
</body>
</html>