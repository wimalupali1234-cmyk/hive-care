<?php
// expects: $appointments (array), optional $message (string)
$appointments = $appointments ?? [];
$message = $message ?? '';
?>
<?php
$pageTitle = 'Appointment Management - HIVeCare';
$pageDescription = 'Manage patient appointments and scheduling';
ob_start();
?>

<main>
  <div class="container" style="padding: 60px 0;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
      <h1 class="page-title">Appointment Management</h1>
    </div>

    <?php if ($message): ?>
      <div class="alert"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="table-container">
      <table id="Table" style="width:100%;border-collapse:collapse;">
        <thead>
        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <th>Appointment ID</th><th>Patient ID</th><th>Type</th><th>Date</th><th>Time</th><th>Status</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($appointments as $row): ?>
            <tr>
              <form method="POST" action="index.php?action=appointments" style="display:contents;">
                <input type="hidden" name="appointment_id" value="<?php echo (int)$row['appointment_id']; ?>">
                <td><?php echo (int)$row['appointment_id']; ?></td>
                <td><input type="text" name="patient_id" value="<?php echo htmlspecialchars($row['patient_id']); ?>" required></td>
                <td><input type="text" name="type" value="<?php echo htmlspecialchars($row['type']); ?>" required></td>
                <td><input type="date" name="appointment_date" value="<?php echo htmlspecialchars($row['appointment_date']); ?>" required></td>
                <td><input type="time" name="appointment_time" value="<?php echo htmlspecialchars($row['appointment_time']); ?>" required></td>
                <td>
                  <select name="status" required>
                    <option value="Pending" <?php if ($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Completed" <?php if ($row['status']=='Completed') echo 'selected'; ?>>Completed</option>
                    <option value="Cancelled" <?php if ($row['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
                  </select>
                </td>
                <td style="display:flex;gap:6px;">
                  <button type="submit" name="update_appointment_id" class="btn primary-btn"><i class="fas fa-save"></i></button>
                  <button type="submit" name="delete_appointment_id" value="<?php echo (int)$row['appointment_id']; ?>" class="btn" onclick="return confirm('Delete this appointment?')"><i class="fas fa-trash"></i></button>
                </td>
              </form>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<?php 
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>