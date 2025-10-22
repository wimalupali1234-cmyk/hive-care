<?php
$data = $data ?? [];
$full = $data;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lab Tech Registration - Personal Details</title>
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
          <h2><i class="fas fa-user"></i> Personal Details</h2>
          <p>Step 1 of 3</p>
        </div>

        <form method="POST" action="index.php?action=labtech_step1">
          <div class="form-grid">
            <div class="form-group">
              <label for="full_name">Full Name <span style="color:#e74c3c">*</span></label>
              <input id="full_name" name="full_name" type="text" required value="<?php echo htmlspecialchars($full['full_name'] ?? ''); ?>" placeholder="Enter full name" />
            </div>

            <div class="form-group">
              <label for="gender">Gender <span style="color:#e74c3c">*</span></label>
              <select id="gender" name="gender" required>
                <option value="">Select gender</option>
                <option value="Male" <?php if (($full['gender'] ?? '')==='Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if (($full['gender'] ?? '')==='Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if (($full['gender'] ?? '')==='Other') echo 'selected'; ?>>Other</option>
              </select>
            </div>

            <div class="form-group">
              <label for="dob">Date of Birth</label>
              <input id="dob" name="dob" type="date" value="<?php echo htmlspecialchars($full['dob'] ?? ''); ?>" />
            </div>

            <div class="form-group">
              <label for="nic_number">NIC <span style="color:#e74c3c">*</span></label>
              <input id="nic_number" name="nic_number" type="text" required value="<?php echo htmlspecialchars($full['nic_number'] ?? ''); ?>" placeholder="Enter NIC number" />
            </div>

            <div class="form-group">
              <label for="primary_contact">Primary Contact <span style="color:#e74c3c">*</span></label>
              <input id="primary_contact" name="primary_contact" type="tel" required value="<?php echo htmlspecialchars($full['primary_contact'] ?? ''); ?>" placeholder="Enter primary contact number" />
            </div>

            <div class="form-group">
              <label for="secondary_contact">Secondary Contact</label>
              <input id="secondary_contact" name="secondary_contact" type="tel" value="<?php echo htmlspecialchars($full['secondary_contact'] ?? ''); ?>" placeholder="Enter secondary contact number" />
            </div>

            <div class="form-group">
              <label for="email_address">Email <span style="color:#e74c3c">*</span></label>
              <input id="email_address" name="email_address" type="email" required value="<?php echo htmlspecialchars($full['email_address'] ?? ''); ?>" placeholder="Enter email address" />
            </div>

            <div class="form-group">
              <label for="address">Address <span style="color:#e74c3c">*</span></label>
              <textarea id="address" name="address" required placeholder="Enter full address"><?php echo htmlspecialchars($full['address'] ?? ''); ?></textarea>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn btn-secondary-outline" onclick="window.location.href='index.php?action=labtech'">Cancel</button>
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
