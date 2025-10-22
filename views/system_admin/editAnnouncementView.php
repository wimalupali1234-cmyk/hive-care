<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Announcement - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIVe/public/css/style.css">
  <link rel="stylesheet" href="style.css">
  <style>
    body { background: #f9fafb; font-family: 'Poppins', sans-serif; color: #333; }
    .header { display:flex; justify-content:space-between; align-items:center; background:#1d3557; color:#fff; padding:20px 40px; }
    .header h1 { font-size:24px; }
    .back-link { color:#fff; text-decoration:none; }
    .back-link:hover { text-decoration:underline; }
    .container { padding:40px; max-width:800px; margin:auto; }

    .edit-form { background:#fff; padding:30px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
    .edit-form h2 { margin-bottom:20px; color:#1d3557; text-align:center; }
    .edit-form label { display:block; margin:15px 0 8px; font-weight:500; }
    .edit-form input, .edit-form textarea {
      width:100%; padding:12px; border-radius:8px; border:1px solid #ccc; font-size:15px;
    }
    .edit-form textarea { resize:vertical; height:120px; }
    .form-buttons {
      margin-top:25px; display:flex; gap:15px; justify-content:center;
    }
    .btn-primary {
      background:#28a745; color:#fff; border:none; padding:12px 25px;
      border-radius:8px; cursor:pointer; font-size:16px;
    }
    .btn-primary:hover { background:#218838; }
    .btn-secondary {
      background:#6c757d; color:#fff; border:none; padding:12px 25px;
      border-radius:8px; cursor:pointer; font-size:16px; text-decoration:none;
    }
    .btn-secondary:hover { background:#5a6268; }
  </style>
</head>
<body>
  <header class="header">
    <h1><i class="fas fa-calendar-alt"></i> Edit Announcement</h1>
    <a href="index.php?action=manageAnnouncements" class="back-link">Back to Announcements</a>
  </header>

  <div class="container">
    <div class="edit-form">
      <h2><i class="fas fa-edit"></i> Edit Announcement Details</h2>

      <form method="POST">
        <label for="title">Announcement Title *</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($announcement['title'] ?? ''); ?>" required>

        <label for="description">Description *</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($announcement['description'] ?? ''); ?></textarea>

        <label for="event_date">Event / Announcement Date *</label>
        <input type="date" id="event_date" name="event_date" value="<?php echo htmlspecialchars($announcement['event_date'] ?? ''); ?>" required>

        <div class="form-buttons">
          <button type="submit" name="update" class="btn-primary">
            <i class="fas fa-save"></i> Update Announcement
          </button>
          <a href="index.php?action=manageAnnouncements" class="btn-secondary">
            <i class="fas fa-times"></i> Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
