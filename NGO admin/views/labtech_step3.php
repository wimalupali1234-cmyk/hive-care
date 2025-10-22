<?php
$prev1 = $prevStep1 ?? [];
$prev2 = $prevStep2 ?? [];
$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lab Tech Registration - Professional Credentials</title>
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
          <h2><i class="fas fa-certificate"></i> Professional Credentials</h2>
          <p>Step 3 of 3</p>
        </div>

        <?php if ($error): ?>
          <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="index.php?action=labtech_step3" enctype="multipart/form-data">
          <div class="form-grid">
            <div class="form-group">
              <label for="qualification">Highest Qualification <span style="color:#e74c3c">*</span></label>
              <input id="qualification" name="qualification" type="text" required placeholder="Enter highest qualification" />
            </div>

            <div class="form-group">
              <label for="university">University/Institute <span style="color:#e74c3c">*</span></label>
              <input id="university" name="university" type="text" required placeholder="Enter university/institute name" />
            </div>

            <div class="form-group">
              <label for="license_number">License Number <span style="color:#e74c3c">*</span></label>
              <input id="license_number" name="license_number" type="text" required placeholder="Enter license number" />
            </div>

            <div class="form-group">
              <label for="license_expiry">License Expiry Date</label>
              <input id="license_expiry" name="license_expiry" type="date" />
              <small style="color: #666;">Leave blank if not applicable</small>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn btn-secondary-outline" onclick="window.location.href='index.php?action=labtech_step2'">Back</button>
            <button type="submit" class="btn btn-primary">Submit & Create</button>
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
