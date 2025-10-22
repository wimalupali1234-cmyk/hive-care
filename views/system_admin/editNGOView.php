<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit NGO - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
</head>
<body>


<!-- Main Section -->
<main>
  <div class="main-container">
    <div class="edit-container">
      <h2><i class="fas fa-handshake"></i> Edit NGO</h2>

      <form method="POST" action="index.php?action=editNGO&id=<?= $ngo['id'] ?>">
        <label for="name">NGO Name *</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($ngo['name'] ?? ''); ?>" required>

        <label for="email">Email Address *</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($ngo['email'] ?? ''); ?>" required>

        <label for="address">Address *</label>
        <textarea id="address" name="address" rows="3" required><?php echo htmlspecialchars($ngo['address'] ?? ''); ?></textarea>

        <label for="contact">Contact Number *</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($ngo['contact_number'] ?? ''); ?>" required>

        <label for="status">Status *</label>
        <select id="status" name="status" required>
          <option value="Active" <?php echo ($ngo['status'] ?? '') === 'Active' ? 'selected' : ''; ?>>Active</option>
          <option value="Inactive" <?php echo ($ngo['status'] ?? '') === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
          <option value="Pending" <?php echo ($ngo['status'] ?? '') === 'Pending' ? 'selected' : ''; ?>>Pending</option>
        </select>

        <button type="submit" name="update" class="btn-primary">
          <i class="fas fa-save"></i> Update NGO
        </button>

        <a href="index.php?action=manageNGOs" class="btn-secondary">
          <i class="fas fa-times"></i> Cancel
        </a>
      </form>
    </div>
  </div>
</main>



</body>
</html>
