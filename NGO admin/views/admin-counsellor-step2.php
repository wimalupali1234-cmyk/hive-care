<?php
$step2 = $step2 ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Counsellor Registration - Professional Details</title>
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

        <form method="POST" action="index.php?action=counsellor&step=2" novalidate>
          <div class="form-grid">
            <div class="form-group">
              <label for="last_hospital">Last Hospital</label>
              <input id="last_hospital" name="last_hospital" type="text" value="<?php echo htmlspecialchars($step2['last_hospital'] ?? ''); ?>" placeholder="Enter hospital name" />
            </div>

            <div class="form-group">
              <label for="hospital_address">Hospital Address</label>
              <textarea id="hospital_address" name="hospital_address" placeholder="Enter hospital address"><?php echo htmlspecialchars($step2['hospital_address'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
              <label for="department">Department</label>
              <select id="department" name="department">
                <option value="">Select department</option>
                <?php 
                $deps = ['Pathology','Microbiology','Biochemistry','Hematology','Immunology','Virology','Other'];
                foreach($deps as $d) {
                  $selected = (($step2['department']??'')===$d) ? ' selected' : '';
                  echo '<option value="'.htmlspecialchars($d).'"'.$selected.'>'.htmlspecialchars($d).'</option>';
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="experience">Experience</label>
              <select id="experience" name="experience">
                <option value="">Select experience range</option>
                <?php 
                foreach(['0-2','3-5','6-10','11-15','16-20','20+'] as $e) {
                  $selected = (($step2['experience']??'')===$e) ? ' selected' : '';
                  echo '<option value="'.htmlspecialchars($e).'"'.$selected.'>'.htmlspecialchars($e).' years</option>';
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="reference">Reference</label>
              <input id="reference" name="reference" type="text" value="<?php echo htmlspecialchars($step2['reference'] ?? ''); ?>" placeholder="Enter reference name" />
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn btn-secondary-outline" onclick="window.location.href='index.php?action=counsellor&step=1'">Back</button>
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
