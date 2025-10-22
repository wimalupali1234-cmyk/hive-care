<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Appointments - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
</head>
<body>
<header class="header">
  <h1><i class="fas fa-calendar-alt"></i> Manage Appointments</h1>
  <a href="index.php?action=dashboard" class="back-link">Back to Dashboard</a>
</header>

<div class="main-container">

  <!-- Stats -->
  <div class="stats">
    <div class="stat-box">
      <div class="stat-number"><?= $total_appointments ?></div>
      <div>Total Appointments</div>
    </div>
    <div class="stat-box">
      <div class="stat-number"><?= $pending ?></div>
      <div>Pending</div>
    </div>
    <div class="stat-box">
      <div class="stat-number"><?= $completed ?></div>
      <div>Completed</div>
    </div>
  </div>

  <!-- Filters -->
  <form method="GET" class="filters" action="index.php">
    <input type="hidden" name="action" value="manageAppointments">
    <input type="text" name="search" placeholder="Search by name..." value="<?= htmlspecialchars($search) ?>">
    <select name="filter">
      <option value="all" <?= $filter=='all'?'selected':'' ?>>All Types</option>
      <option value="HIV Test" <?= $filter=='HIV Test'?'selected':'' ?>>HIV Test</option>
      <option value="Counselling Session" <?= $filter=='Counselling Session'?'selected':'' ?>>Counselling Session</option>
      <option value="Other" <?= $filter=='Other'?'selected':'' ?>>Other</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
  </form>

  <!-- Appointment List -->
  <div class="appointment-list">
    <?php if ($appointments): ?>
      <?php foreach($appointments as $row): ?>
        <div class="appointment-card">
          <h3><i class="fas fa-user"></i> <?= htmlspecialchars($row['user_name']) ?></h3>
          <p><strong>Email:</strong> <?= htmlspecialchars($row['user_email']) ?></p>
          <p><strong>Type:</strong> <?= htmlspecialchars($row['appointment_type']) ?></p>
          <p><strong>Date:</strong> <?= htmlspecialchars($row['date']) ?> | <strong>Time:</strong> <?= htmlspecialchars($row['time']) ?></p>
          <p><strong>Status:</strong> <span class="status <?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></p>

          <div class="actions">
            <form method="POST" style="display:flex; gap:8px; align-items:center;">
              <input type="hidden" name="appointment_id" value="<?= (int)$row['id'] ?>">
              <select name="status">
                <option <?= $row['status']=='Pending' ? 'selected':'' ?>>Pending</option>
                <option <?= $row['status']=='Confirmed' ? 'selected':'' ?>>Confirmed</option>
                <option <?= $row['status']=='Completed' ? 'selected':'' ?>>Completed</option>
                <option <?= $row['status']=='Cancelled' ? 'selected':'' ?>>Cancelled</option>
              </select>
              <button type="submit" name="update_status" class="btn-update"><i class="fas fa-sync"></i> Update</button>
            </form>
            <a href="index.php?action=manageAppointments&delete=<?= (int)$row['id'] ?>" onclick="return confirm('Delete this appointment?')" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="empty-note">No appointments found.</div>
    <?php endif; ?>
  </div>

</div>
</body>
</html>
