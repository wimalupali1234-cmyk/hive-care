<?php
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Test Kits - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIVe/public/css/style.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
</head>
<body>
<header class="header">
  <h1><i class="fas fa-vial"></i> Manage Test Kits</h1>
  <a href="index.php?action=dashboard" class="back-link">Back to Dashboard</a>
</header>

<div class="main-container">

  <!-- Stats -->
  <div class="stats">
    <div class="stat-box">
      <div class="stat-number"><?= (int)$total_kits ?></div>
      <div>Total Kits</div>
    </div>
<<<<<<< HEAD
=======
    <div class="stat-box">
      <div class="stat-number"><?= (int)($counts['available'] ?? 0) ?></div>
      <div>Available</div>
    </div>
    <div class="stat-box">
      <div class="stat-number"><?= (int)($counts['low_stock'] ?? 0) ?></div>
      <div>Low Stock</div>
    </div>
    <div class="stat-box">
      <div class="stat-number"><?= (int)($counts['expired'] ?? 0) ?></div>
      <div>Expired</div>
    </div>
>>>>>>> origin/main
  </div>

  <!-- Filter -->
  <form method="GET" class="filters" action="index.php">
    <input type="hidden" name="action" value="manageTestKits">
    <input type="text" name="search" placeholder="Search kits..." value="<?= htmlspecialchars($search) ?>">
<<<<<<< HEAD
    <select name="filter" aria-label="Filter by type">
      <option value="all" <?= $filter=='all'?'selected':'' ?>>All Types</option>
      <option value="Antibody Test Kit" <?= $filter=='Antibody Test Kit'?'selected':'' ?>>Antibody Test Kits</option>
      <option value="Antigen/Antibody Combo Test Kit" <?= $filter=='Antigen/Antibody Combo Test Kit'?'selected':'' ?>>Antigen/Antibody Combo Kits</option>
      <option value="Nucleic Acid Test (NAT) Kit" <?= $filter=='Nucleic Acid Test (NAT) Kit'?'selected':'' ?>>NAT Kits</option>
=======
    <select name="filter" aria-label="Filter by status">
      <option value="all" <?= $filter=='all'?'selected':'' ?>>All Status</option>
      <option value="Available" <?= $filter=='Available'?'selected':'' ?>>Available</option>
      <option value="Low Stock" <?= $filter=='Low Stock'?'selected':'' ?>>Low Stock</option>
      <option value="Expired" <?= $filter=='Expired'?'selected':'' ?>>Expired</option>
      <option value="Out of Stock" <?= $filter=='Out of Stock'?'selected':'' ?>>Out of Stock</option>
>>>>>>> origin/main
    </select>
    <button type="submit" class="filter-btn">Filter</button>
  </form>

  <div class="manage-container">
    <!-- Left Column: Add Kit -->
    <div class="left-column">
      <h2>Add New Test Kit</h2>
      <form method="POST" action="index.php?action=manageTestKits">
<<<<<<< HEAD
        <input type="text" name="name" placeholder="Kit Name" required>
        <select name="type" required>
=======
        <input type="text" name="testkit_name" placeholder="Test Kit Name" required>
        <select name="test_type" required>
>>>>>>> origin/main
          <option value="Antibody Test Kit">Antibody Test Kit</option>
          <option value="Antigen/Antibody Combo Test Kit">Antigen/Antibody Combo Test Kit</option>
          <option value="Nucleic Acid Test (NAT) Kit">Nucleic Acid Test (NAT) Kit</option>
        </select>
<<<<<<< HEAD
        <input type="number" name="quantity" placeholder="Quantity" min="1" required>
        <input type="date" name="expiry_date" required>
=======
        <input type="text" name="batch_number" placeholder="Batch Number" required>
        <input type="text" name="manufacturer" placeholder="Manufacturer">
        <label for="manufacture_date">Manufacture Date</label>
        <input type="date" name="manufacture_date" id="manufacture_date">
        <label for="expiry_date">Expiry Date</label>
        <input type="date" name="expiry_date" id="expiry_date" required>
        <input type="number" name="quantity_available" placeholder="Quantity Available" min="0" required>
        <input type="text" name="supplier_name" placeholder="Supplier Name">
        <label for="received_date">Received Date</label>
        <input type="date" name="received_date" id="received_date">
        <select name="status" required>
          <option value="Available">Available</option>
          <option value="Low Stock">Low Stock</option>
          <option value="Out of Stock">Out of Stock</option>
        </select>
>>>>>>> origin/main
        <button type="submit" name="add" class="add-btn">+ Add Test Kit</button>
      </form>
    </div>

    <!-- Right Column: List Kits -->
    <div class="right-column">
      <div class="hospital-grid">
        <?php if ($kits && $kits->num_rows > 0): ?>
          <?php while($row = $kits->fetch_assoc()): ?>
            <div class="hospital-card">
              <h3><i class="fas fa-vial"></i> <?= htmlspecialchars($row['testkit_name']) ?></h3>
              <p><strong>Type:</strong> <?= htmlspecialchars($row['test_type']) ?></p>
<<<<<<< HEAD
              <p><strong>Quantity:</strong> <?= htmlspecialchars($row['quantity_available']) ?></p>
              <p><strong>Expiry:</strong> <?= htmlspecialchars($row['expiry_date']) ?></p>
=======
              <p><strong>Batch:</strong> <?= htmlspecialchars($row['batch_number']) ?></p>
              <?php if($row['manufacturer']): ?>
                <p><strong>Manufacturer:</strong> <?= htmlspecialchars($row['manufacturer']) ?></p>
              <?php endif; ?>
              <p><strong>Quantity:</strong> <?= htmlspecialchars($row['quantity_available']) ?></p>
              <p><strong>Expiry:</strong> <?= htmlspecialchars($row['expiry_date']) ?></p>
              <?php if($row['supplier_name']): ?>
                <p><strong>Supplier:</strong> <?= htmlspecialchars($row['supplier_name']) ?></p>
              <?php endif; ?>
              <span class="status <?= strtolower(str_replace(' ', '-', $row['status'])) ?>"><?= htmlspecialchars($row['status']) ?></span>
>>>>>>> origin/main
              <div class="actions">
                <a href="index.php?action=editTestKit&id=<?= $row['testkit_id'] ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                <a href="index.php?action=manageTestKits&delete=<?= $row['testkit_id'] ?>" onclick="return confirm('Delete this kit?')" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="empty-note">No test kits found.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div>
</body>
</html>
