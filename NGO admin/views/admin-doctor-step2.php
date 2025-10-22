<?php
$values = $values ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Doctor Registration - Professional Details</title>
  <link rel="stylesheet" href="/HIV/NGO%20admin/styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body>
  <header class="header">
    <div class="container">
      <div class="logo">
        <h1><i class="fas fa-heartbeat"></i> HIVeCare</h1>
      </div>
      <nav class="main-nav">
        <ul>
          <li><a href="/HIV/Homepage/index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="help.html">Help</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="form-page">
    <div class="container">
      <div class="form-card">
        <div class="step-header">
          <h2><i class="fas fa-briefcase"></i> Professional Details</h2>
          <p>Step 2 of 3</p>
        </div>

        <form method="POST" action="index.php?action=doctor_add&step=2">
          <div class="form-grid">
            <div class="form-group">
              <label for="last_hospital">Last Hospital</label>
              <input id="last_hospital" name="last_hospital" type="text" value="<?php echo htmlspecialchars($values['last_hospital'] ?? ''); ?>" placeholder="Enter hospital name" />
            </div>

            <div class="form-group">
              <label for="hospital_address">Hospital Address</label>
              <textarea id="hospital_address" name="hospital_address" placeholder="Enter hospital address"><?php echo htmlspecialchars($values['hospital_address'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
              <label for="department">Department</label>
              <input id="department" name="department" type="text" value="<?php echo htmlspecialchars($values['department'] ?? ''); ?>" placeholder="Enter department" />
            </div>

            <div class="form-group">
              <label for="experience">Experience</label>
              <input id="experience" name="experience" type="text" value="<?php echo htmlspecialchars($values['experience'] ?? ''); ?>" placeholder="Enter years of experience" />
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn btn-secondary-outline" onclick="window.location.href='index.php?action=doctor_add&step=1'">Back</button>
            <button type="submit" class="btn btn-primary">Next</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
          <h3><i class="fas fa-heartbeat"></i> HIV Support Portal</h3>
          <p>Providing confidential support and resources for people affected by HIV.</p>
        </div>
        <div class="footer-col">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="help.html">Help Center</a></li>
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
            <li><i class="fas fa-clock"></i> 24/7 Support Available</li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
