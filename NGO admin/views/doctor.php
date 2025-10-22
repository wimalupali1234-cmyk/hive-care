<?php

// expects: $doctors (array), optional $message (string)
$doctors = $doctors ?? [];
$message = $message ?? '';
?>
<?php
$pageTitle = 'Doctor Management - HIVeCare';
$pageDescription = 'Manage doctor information and records';
ob_start();
?>

<main>
  <div class="container" style="padding:60px 0;">
  <div class="back-button-container">
        <a href="/HIV/NGO%20admin/index.php?action=staffmanagement" class="back-btn">Back to Staff management</a>
      </div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
      <h1 class="page-title">Doctor Management</h1>
      <a href="index.php?action=doctor_add" class="btn primary-btn"><i class="fas fa-plus"></i> Add Doctor</a>
    </div>

    <?php if ($message): ?>
      <div class="alert"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="table-container" style="overflow-x:auto;">
      <table id="Table" style="width:100%;border-collapse:collapse;min-width:2200px; border: 2px solid #ddd; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <thead>
          <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left; font-weight: bold;">ID</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Name</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Gender</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">NIC</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Primary Contact</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Secondary Contact</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Email</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Address</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Last Hospital</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Hospital Address</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Dept</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Experience</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Qualification</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">University</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">License No</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">License Expiry</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($doctors as $row): ?>
            <tr style="background: #f9f9f9; border-bottom: 1px solid #ddd;">
              <form method="POST" action="index.php?action=doctors" style="display:contents;">
                <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($row['doctor_id']); ?>">
                <td style="border: 1px solid #ddd; padding: 12px; font-weight: bold; background: #e8f4fd;"><strong><?php echo htmlspecialchars($row['doctor_id']); ?></strong></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="full_name" value="<?php echo htmlspecialchars($row['full_name']); ?>" style="min-width:150px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;">
                  <select name="gender" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="Male" <?php if ($row['gender']=='Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($row['gender']=='Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if ($row['gender']=='Other') echo 'selected'; ?>>Other</option>
                  </select>
                </td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="nic" value="<?php echo htmlspecialchars($row['nic']); ?>" style="min-width:120px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="tel" name="primary_contact" value="<?php echo htmlspecialchars($row['primary_contact']); ?>" style="min-width:110px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="tel" name="secondary_contact" value="<?php echo htmlspecialchars($row['secondary_contact'] ?? ''); ?>" style="min-width:110px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" style="min-width:180px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="address" value="<?php echo htmlspecialchars($row['address'] ?? ''); ?>" style="min-width:180px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="last_hospital" value="<?php echo htmlspecialchars($row['last_hospital']); ?>" style="min-width:150px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="hospital_address" value="<?php echo htmlspecialchars($row['hospital_address'] ?? ''); ?>" style="min-width:150px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="department" value="<?php echo htmlspecialchars($row['department']); ?>" style="min-width:120px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="experience" value="<?php echo htmlspecialchars($row['experience'] ?? ''); ?>" style="min-width:80px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="qualification" value="<?php echo htmlspecialchars($row['qualification'] ?? ''); ?>" style="min-width:120px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="university" value="<?php echo htmlspecialchars($row['university'] ?? ''); ?>" style="min-width:150px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="text" name="license_no" value="<?php echo htmlspecialchars($row['license_no'] ?? ''); ?>" style="min-width:100px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><input type="date" name="license_expiry" value="<?php echo htmlspecialchars($row['license_expiry'] ?? ''); ?>" style="min-width:130px; width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td style="border: 1px solid #ddd; padding: 12px; display:flex;gap:6px;">
                  <button type="submit" name="update_doctor_id" class="btn primary-btn" style="padding: 8px 12px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-save"></i></button>
                  <button type="submit" name="delete_doctor_id" value="<?php echo htmlspecialchars($row['doctor_id']); ?>" class="btn" onclick="return confirm('Delete this doctor?')" style="padding: 8px 12px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-trash"></i></button>
                </td>
              </form>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>