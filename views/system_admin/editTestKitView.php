<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Test Kit - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
</head>
<body>

<!-- Main Section -->
<main>
  <div class="main-container">
    <div class="edit-container">
      <h2><i class="fas fa-vial"></i> Edit Test Kit</h2>

      <form method="POST" action="index.php?action=editTestKit&id=<?= $kit['testkit_id'] ?>">
        <label for="testkit_name">Test Kit Name *</label>
        <input type="text" id="testkit_name" name="testkit_name" value="<?php echo htmlspecialchars($kit['testkit_name'] ?? ''); ?>" required>

        <label for="test_type">Test Type *</label>
        <select id="test_type" name="test_type" required>
          <option value="Antibody Test Kit" <?php echo ($kit['test_type'] ?? '') === 'Antibody Test Kit' ? 'selected' : ''; ?>>Antibody Test Kit</option>
          <option value="Antigen/Antibody Combo Test Kit" <?php echo ($kit['test_type'] ?? '') === 'Antigen/Antibody Combo Test Kit' ? 'selected' : ''; ?>>Antigen/Antibody Combo Test Kit</option>
          <option value="Nucleic Acid Test (NAT) Kit" <?php echo ($kit['test_type'] ?? '') === 'Nucleic Acid Test (NAT) Kit' ? 'selected' : ''; ?>>Nucleic Acid Test (NAT) Kit</option>
        </select>

        <label for="batch_number">Batch Number *</label>
        <input type="text" id="batch_number" name="batch_number" value="<?php echo htmlspecialchars($kit['batch_number'] ?? ''); ?>" required>

        <label for="manufacturer">Manufacturer</label>
        <input type="text" id="manufacturer" name="manufacturer" value="<?php echo htmlspecialchars($kit['manufacturer'] ?? ''); ?>">

        <label for="manufacture_date">Manufacture Date</label>
        <input type="date" id="manufacture_date" name="manufacture_date" value="<?php echo htmlspecialchars($kit['manufacture_date'] ?? ''); ?>">

        <label for="expiry_date">Expiry Date *</label>
        <input type="date" id="expiry_date" name="expiry_date" value="<?php echo htmlspecialchars($kit['expiry_date'] ?? ''); ?>" required>

        <label for="quantity_available">Quantity Available *</label>
        <input type="number" id="quantity_available" name="quantity_available" value="<?php echo htmlspecialchars($kit['quantity_available'] ?? ''); ?>" min="0" required>

        <label for="supplier_name">Supplier Name</label>
        <input type="text" id="supplier_name" name="supplier_name" value="<?php echo htmlspecialchars($kit['supplier_name'] ?? ''); ?>">

        <label for="received_date">Received Date</label>
        <input type="date" id="received_date" name="received_date" value="<?php echo htmlspecialchars($kit['received_date'] ?? ''); ?>">

        <label for="status">Status *</label>
        <select id="status" name="status" required>
          <option value="Available" <?php echo ($kit['status'] ?? '') === 'Available' ? 'selected' : ''; ?>>Available</option>
          <option value="Low Stock" <?php echo ($kit['status'] ?? '') === 'Low Stock' ? 'selected' : ''; ?>>Low Stock</option>
          <option value="Expired" <?php echo ($kit['status'] ?? '') === 'Expired' ? 'selected' : ''; ?>>Expired</option>
          <option value="Out of Stock" <?php echo ($kit['status'] ?? '') === 'Out of Stock' ? 'selected' : ''; ?>>Out of Stock</option>
        </select>

        <button type="submit" name="update" class="btn-primary">
          <i class="fas fa-save"></i> Update Test Kit
        </button>

        <a href="index.php?action=manageTestKits" class="btn-secondary">
          <i class="fas fa-times"></i> Cancel
        </a>
      </form>
    </div>
  </div>
</main>

</body>
</html>
