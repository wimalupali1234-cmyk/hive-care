<?php
// expects: $testkits (array), optional $message (string)
$testkits = $testkits ?? [];
$message = $message ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>HIV Test Kit Inventory - HIVeCare</title>
  <link rel="stylesheet" href="/HIV/NGO%20admin/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body>
<header class="header">
  <div class="container">
    <div class="logo"><h1><i class="fas fa-heartbeat"></i> HIVeCare</h1></div>
    <nav class="main-nav">
      <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="helpadmin.html">Help</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
    <div class="auth-buttons">
        <button class="auth-btn login-btn">Logout</button>
        
      </div>
    <div class="language-switcher">
      <select id="language-select">
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
  <div class="container" style="padding:60px 0;">
  <div class="back-button-container">
        <a href="/HIV/NGO%20admin/index.php?action=inventory" class="back-btn">Back to Inventory management</a>
      </div>
    <h1 class="page-title">HIV Test Kit Inventory</h1>

    <?php if (!empty($message)) : ?>
      <div class="alert"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="table-container">
      <table id="Table" style="width:100%; border-collapse:collapse; border: 2px solid #ddd; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <thead>
          <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left; font-weight: bold;">Test Type</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Stock Available</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Pending Orders</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Sent Orders</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Expiry Date</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Batch Number</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Manufacturer</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Manufacture Date</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Status</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Received Date</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Supplier Name</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($testkits as $row): ?>
            <?php
              $kitId = isset($row['kit_id']) ? (int)$row['kit_id'] : 0;
              $testType = htmlspecialchars($row['test_type'] ?? '');
              $stock = (int)($row['stock_available'] ?? 0);
              $pending = (int)($row['pending_orders'] ?? 0);
              $sent = (int)($row['sent_orders'] ?? 0);
              $expiry = htmlspecialchars($row['expiry_date'] ?? '');
              $batch = htmlspecialchars($row['batch_number'] ?? '');
              $manufacturer = htmlspecialchars($row['manufacturer'] ?? '');
              $mfg_date = htmlspecialchars($row['manufacture_date'] ?? '');
              $status = htmlspecialchars($row['status'] ?? '');
              $received = htmlspecialchars($row['received_date'] ?? '');
              $supplier = htmlspecialchars($row['supplier_name'] ?? '');
            ?>
            <form class="row-form" method="POST" action="index.php?action=testkits" novalidate>
              <input type="hidden" name="kit_id" value="<?php echo $kitId; ?>">
              <tr style="background: #f9f9f9; border-bottom: 1px solid #ddd;">
                <td style="border: 1px solid #ddd; padding: 12px; font-weight: bold; background: #e8f4fd;"><?php echo $testType; ?></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="number" name="stock_available" value="<?php echo $stock; ?>" min="0" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="number" name="pending_orders" value="<?php echo $pending; ?>" min="0" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="number" name="sent_orders" value="<?php echo $sent; ?>" min="0" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="date" name="expiry_date" value="<?php echo $expiry; ?>" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="batch_number" value="<?php echo $batch; ?>" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="manufacturer" value="<?php echo $manufacturer; ?>" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="date" name="manufacture_date" value="<?php echo $mfg_date; ?>" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;">
                  <select name="status" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                    <?php
                      $opts = ['available'=>'Available','low stock'=>'Low Stock','expired'=>'Expired','out of stock'=>'Out of Stock'];
                      foreach ($opts as $val=>$label) {
                        $sel = ($status === $val) ? 'selected' : '';
                        echo '<option value="'.htmlspecialchars($val).'" '.$sel.'>'.htmlspecialchars($label).'</option>';
                      }
                    ?>
                  </select>
                </td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="date" name="received_date" value="<?php echo $received; ?>" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="supplier_name" value="<?php echo $supplier; ?>" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><button type="submit" class="btn primary-btn" style="padding: 8px 16px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-save"></i> Update</button></td>
              </tr>
            </form>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-col">
        <h3><i class="fas fa-heartbeat"></i> HIV Support Portal</h3>
        <p>Providing confidential support and resources for people affected by HIV. Your privacy and well-being are our top priorities.</p>
      </div>
      <div class="footer-col">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
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