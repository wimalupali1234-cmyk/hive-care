<?php
// expects: $patients (array), optional $message (string)
$patients = $patients ?? [];
$message = $message ?? '';
?>
<?php
$pageTitle = 'Patient Management - HIVeCare';
$pageDescription = 'Manage patient information and records';
ob_start();
?>

<main>
  <div class="container" style="padding: 60px 0;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
      <h1 class="page-title">Patient Management</h1>
    </div>

    <?php if ($message): ?>
      <div class="alert"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="table-container  style="overflow-x:auto;">
      <table id="Table" style="width:100%;border-collapse:collapse;">
        <thead>
        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <th>Patient ID</th><th>Name</th><th>Address</th><th>Telephone</th><th>Email</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($patients as $row): ?>
            <tr>
              <form method="POST" action="index.php?action=patients" style="display:contents;">
                <input type="hidden" name="patient_id" value="<?php echo (int)$row['patient_id']; ?>">
                <td style=font-weight: bold;><?php echo (int)$row['patient_id']; ?></td>
                <td><?php echo htmlspecialchars($row['name'] ?? 'N/A'); ?></td>
                <td><input type="text" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" required></td>
                <td><input type="tel" name="telephone" value="<?php echo htmlspecialchars($row['telephone']); ?>" required></td>
                <td><input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required></td>
                <td style="display:flex;gap:6px;">
                  <button type="submit" name="update_patient_id" class="btn primary-btn"><i class="fas fa-save"></i></button>
                  <button type="submit" name="delete_patient_id" value="<?php echo (int)$row['patient_id']; ?>" class="btn" onclick="return confirm('Delete this patient?')"><i class="fas fa-trash"></i></button>
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