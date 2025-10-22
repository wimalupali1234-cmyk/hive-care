<?php
// Variables passed from controller
$approved_count = $counts['approved'];
$pending_count  = $counts['pending'];
$inactive_count = $counts['inactive'];
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Hospitals - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
</head>
<body>
<header class="header">
  <h1><i class="fas fa-hospital"></i> Manage Hospitals</h1>
  <a href="index.php?action=dashboard" class="back-link">Back to Dashboard</a>
</header>

<div class="main-container">

  <!-- Stats -->
  <div class="stats">
    <div class="stat-box">
      <div class="stat-number"><?= (int)$approved_count ?></div>
      <div>Approved Hospitals</div>
    </div>
    <div class="stat-box">
      <div class="stat-number"><?= (int)$pending_count ?></div>
      <div>Pending Requests</div>
    </div>
    <div class="stat-box">
      <div class="stat-number"><?= (int)$inactive_count ?></div>
      <div>Inactive Hospitals</div>
    </div>
  </div>

  <!-- Filter/Search -->
  <form method="GET" class="filters" action="index.php">
    <input type="hidden" name="action" value="manageHospitals">
    <input type="text" name="search" placeholder="Search hospital..." value="<?= htmlspecialchars($search) ?>">
    <select name="filter">
      <option value="all" <?= $filter=='all'?'selected':'' ?>>All</option>
      <option value="Active" <?= $filter=='Active'?'selected':'' ?>>Active</option>
      <option value="Pending" <?= $filter=='Pending'?'selected':'' ?>>Pending</option>
      <option value="Inactive" <?= $filter=='Inactive'?'selected':'' ?>>Inactive</option>
      <option value="Rejected" <?= $filter=='Rejected'?'selected':'' ?>>Rejected</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
  </form>

  <div class="manage-container">

    <!-- Left Column: Add Hospital -->
    <div class="left-column">
      <h2>Add New Hospital</h2>
      <form method="POST" action="index.php?action=manageHospitals">
        <input type="text" name="name" placeholder="Hospital Name" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <input type="email" name="email" placeholder="Email" required>
        <select name="status">
          <option>Active</option>
          <option>Pending</option>
          <option>Inactive</option>
        </select>
        <button type="submit" name="add" class="add-btn">+ Add Hospital</button>
      </form>
    </div>

    <!-- Right Column: List Hospitals -->
    <div class="right-column">
      <div class="hospital-grid">
        <?php if (!empty($hospitals)): ?>
          <?php foreach ($hospitals as $row): ?>
            <div class="hospital-card">
              <h3><?= htmlspecialchars($row['NAME']) ?></h3>
              <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($row['address']) ?></p>
              <p><i class="fas fa-phone"></i> <?= htmlspecialchars($row['contact_number']) ?></p>
              <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email']) ?></p>
              <span class="status <?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span>
              <div class="actions">
                <?php if($row['status'] == 'Pending'): ?>
                  <a href="index.php?action=manageHospitals&approve=<?= $row['id'] ?>" class="btn-approve"><i class="fas fa-check"></i> Approve</a>
                  <a href="index.php?action=manageHospitals&reject=<?= $row['id'] ?>" class="btn-reject"><i class="fas fa-times"></i> Reject</a>
                <?php elseif($row['status'] == 'Active'): ?>
                  <a href="index.php?action=manageHospitals&deactivate=<?= $row['id'] ?>" class="btn-deactivate"><i class="fas fa-ban"></i> Deactivate</a>
                <?php elseif($row['status'] == 'Inactive'): ?>
                  <a href="index.php?action=manageHospitals&activate=<?= $row['id'] ?>" class="btn-activate"><i class="fas fa-check-circle"></i> Activate</a>
                <?php endif; ?>
                <a href="index.php?action=editHospital&id=<?= $row['id'] ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                <a href="index.php?action=manageHospitals&delete=<?= $row['id'] ?>" onclick="return confirm('Delete this hospital?')" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="empty-note">No hospitals found.</div>
        <?php endif; ?>
      </div>
    </div>

  </div> <!-- .manage-container -->

</div> <!-- .main-container -->
</body>
</html>
