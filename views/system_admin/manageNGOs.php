<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage NGOs - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIVE/public/css/style.css">
</head>
<body>
<header class="header">
  <h1><i class="fas fa-hand-holding-heart"></i> Manage NGOs</h1>
  <a href="index.php?action=dashboard" class="back-link">Back to Dashboard</a>
</header>

<div class="main-container">

  <!-- Stats -->
  <div class="stats">
    <div class="stat-box">
      <div class="stat-number"><?= (int)$counts['approved'] ?></div>
      <div>Approved NGOs</div>
    </div>
    <div class="stat-box">
      <div class="stat-number"><?= (int)$counts['pending'] ?></div>
      <div>Pending Requests</div>
    </div>
    <div class="stat-box">
      <div class="stat-number"><?= (int)$counts['inactive'] ?></div>
      <div>Inactive NGOs</div>
    </div>
  </div>

  <!-- Filter -->
  <form method="GET" class="filters" action="index.php">
    <input type="hidden" name="action" value="manageNGOs">
    <input type="text" name="search" placeholder="Search NGO..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <select name="filter" aria-label="Filter status">
      <option value="all" <?= ($_GET['filter'] ?? '')=='all'?'selected':'' ?>>All</option>
      <option value="Active" <?= ($_GET['filter'] ?? '')=='Active'?'selected':'' ?>>Active</option>
      <option value="Pending" <?= ($_GET['filter'] ?? '')=='Pending'?'selected':'' ?>>Pending</option>
      <option value="Inactive" <?= ($_GET['filter'] ?? '')=='Inactive'?'selected':'' ?>>Inactive</option>
      <option value="Rejected" <?= ($_GET['filter'] ?? '')=='Rejected'?'selected':'' ?>>Rejected</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
  </form>

  <div class="manage-container">

    <!-- Left Column -->
    <div class="left-column">
      <h2>Add New NGO</h2>
      <form method="POST" action="index.php?action=manageNGOs">
        <input type="text" name="name" placeholder="NGO Name" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <input type="email" name="email" placeholder="Email" required>
        <select name="status">
          <option>Active</option>
          <option>Pending</option>
          <option>Inactive</option>
        </select>
        <button type="submit" name="add" class="add-btn">+ Add NGO</button>
      </form>
    </div>

    <!-- Right Column -->
    <div class="right-column">
      <div class="hospital-grid">
        <?php if ($ngos): ?>
          <?php foreach($ngos as $row): ?>
            <div class="hospital-card">
              <h3><?= htmlspecialchars($row['name']) ?></h3>
              <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($row['address']) ?></p>
              <p><i class="fas fa-phone"></i> <?= htmlspecialchars($row['contact_number']) ?></p>
              <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email']) ?></p>
              <span class="status <?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span>
              <div class="actions">
                <?php if($row['status'] == 'Pending'){ ?>
                  <a href="index.php?action=manageNGOs&approve=<?= $row['id'] ?>" class="btn-approve"><i class="fas fa-check"></i> Approve</a>
                  <a href="index.php?action=manageNGOs&reject=<?= $row['id'] ?>" class="btn-reject"><i class="fas fa-times"></i> Reject</a>
                <?php } elseif($row['status'] == 'Active'){ ?>
                  <a href="index.php?action=manageNGOs&deactivate=<?= $row['id'] ?>" class="btn-deactivate"><i class="fas fa-ban"></i> Deactivate</a>
                <?php } elseif($row['status'] == 'Inactive'){ ?>
                  <a href="index.php?action=manageNGOs&activate=<?= $row['id'] ?>" class="btn-activate"><i class="fas fa-check-circle"></i> Activate</a>
                <?php } ?>
                <a href="editNGO.php?id=<?= $row['id'] ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                <a href="index.php?action=manageNGOs&delete=<?= $row['id'] ?>" onclick="return confirm('Delete this NGO?')" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="empty-note">No NGOs found.</div>
        <?php endif; ?>
      </div>
    </div>

  </div> <!-- .manage-container -->

</div> <!-- .main-container -->
</body>
</html>
