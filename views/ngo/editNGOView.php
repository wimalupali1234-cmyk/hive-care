<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit NGO</title>
  <link rel="stylesheet" href="../../style.css">
</head>
<body>

<div class="edit-container">
  <h2>Edit NGO Details</h2>

  <form method="POST">
    <label>NGO Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($ngo['name']); ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($ngo['email']); ?>" required>

    <label>Contact Number</label>
    <input type="text" name="contact" value="<?php echo htmlspecialchars($ngo['contact_number']); ?>" required>

    <label>Status</label>
    <select name="status" required>
      <option value="Pending" <?php if($ngo['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
      <option value="Active" <?php if($ngo['status'] == 'Active') echo 'selected'; ?>>Active</option>
      <option value="Inactive" <?php if($ngo['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
    </select>

    <button type="submit" name="update" class="btn-primary">Update</button>
    <a href="index.php?action=manageNGOs" class="btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>
