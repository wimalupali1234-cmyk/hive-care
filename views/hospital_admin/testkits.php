
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Test kits management - HIV Support Portal</title>
  <meta name="description" content="Learn about different types of facility-based HIV testing including viral load, STI, Hepatitis B and C testing.">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
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
      HIV Test Kit Inventory
    </h1>

    <!-- Test Kit Table -->
    <table id="kitTable" style="width: 100%; border-collapse: collapse; background-color: var(--white); box-shadow: var(--box-shadow); border-radius: var(--border-radius); overflow: hidden;">
      <thead>
        <tr style="background-color: #f8f9fa;">
          <th style="padding: 14px 20px; text-align: left;">Test Type</th>
          <th style="padding: 14px 20px; text-align: left;">Stock Available</th>
          <th style="padding: 14px 20px; text-align: left;">Pending Orders</th>
          <th style="padding: 14px 20px; text-align: left;">Sent Orders</th>
          <th style="padding: 14px 20px; text-align: left;">Expiry Date</th>
          <th style="padding: 14px 20px; text-align: left;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Oral Fluid Testing</td>
          <td>100</td>
          <td>10</td>
          <td>15</td>
          <td>2025-11-30</td>
          <td><a class="update-btn">Update</a></td>
        </tr>
        <tr>
          <td>Finger Prick Blood Testing</td>
          <td>80</td>
          <td>5</td>
          <td>12</td>
          <td>2026-01-15</td>
          <td><a class="update-btn">Update</a></td>
        </tr>
        <tr>
          <td>Dried Blood Spot Testing</td>
          <td>60</td>
          <td>7</td>
          <td>8</td>
          <td>2026-03-20</td>
          <td><a class="update-btn">Update</a></td>
        </tr>
      </tbody>
    </table>
  </div>

  <script>
    // Enable in-place update
    document.querySelectorAll('.update-btn').forEach(button => {
      button.addEventListener('click', function() {
        const row = this.closest('tr');
        if (this.textContent === 'Update') {
          // Convert cells to editable inputs (Stock, Pending, Sent, Expiry)
          row.querySelectorAll('td').forEach((cell, index) => {
            if (index > 0 && index < 5) { 
              const value = cell.textContent;
              cell.innerHTML = `<input type="${index === 4 ? 'date' : 'number'}" value="${value}">`;
            }
          });
          this.textContent = 'Save';
        } else {
          // Save updated values
          row.querySelectorAll('td').forEach((cell, index) => {
            if (index > 0 && index < 5) {
              const input = cell.querySelector('input');
              cell.textContent = input.value;
            }
          });
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
