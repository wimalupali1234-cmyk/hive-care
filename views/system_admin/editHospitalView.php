<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Hospital - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
</head>
<body>


<!-- Main Section -->
<main>
  <div class="main-container">
    <div class="edit-container">
      <h2><i class="fas fa-hospital"></i> Edit Hospital</h2>

      <form method="POST" action="">
        <label for="name">Hospital Name *</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($hospital['NAME'] ?? ''); ?>" required>

        <label for="email">Email Address *</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($hospital['email'] ?? ''); ?>" required>

        <label for="address">Address *</label>
        <textarea id="address" name="address" rows="3" required><?php echo htmlspecialchars($hospital['address'] ?? ''); ?></textarea>

        <label for="contact">Contact Number *</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($hospital['contact_number'] ?? ''); ?>" required>

        <label for="status">Status *</label>
        <select id="status" name="status" required>
          <option value="Active" <?php echo ($hospital['status'] ?? '') === 'Active' ? 'selected' : ''; ?>>Active</option>
          <option value="Inactive" <?php echo ($hospital['status'] ?? '') === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
          <option value="Pending" <?php echo ($hospital['status'] ?? '') === 'Pending' ? 'selected' : ''; ?>>Pending</option>
        </select>

        <button type="submit" name="update" class="btn-primary">
          <i class="fas fa-save"></i> Update Hospital
        </button>

        <a href="../systemadmin/index.php?action=manageHospitals" class="btn-secondary">
          <i class="fas fa-times"></i> Cancel
        </a>
      </form>
    </div>
  </div>
</main>



</body>
</html>
