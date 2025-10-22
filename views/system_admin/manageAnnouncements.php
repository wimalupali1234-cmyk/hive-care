

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Announcements & Events - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    body { background: #f9fafb; font-family: 'Poppins', sans-serif; color: #333; }
    .header { display:flex; justify-content:space-between; align-items:center; background:#1d3557; color:#fff; padding:20px 40px; }
    .header h1 { font-size:24px; }
    .back-link { color:#fff; text-decoration:none; }
    .back-link:hover { text-decoration:underline; }
    .container { padding:40px; max-width:1100px; margin:auto; }

    /* Upload form */
    .upload-form { background:#fff; padding:25px 30px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.1); margin-bottom:40px; }
    .upload-form h2 { margin-bottom:15px; color:#1d3557; }
    .upload-form label { display:block; margin:10px 0 5px; font-weight:500; }
    .upload-form input, .upload-form textarea {
      width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:15px;
    }
    .upload-form textarea { resize:vertical; height:100px; }
    .upload-form button {
      margin-top:15px; background:#1d3557; color:#fff; border:none;
      padding:10px 20px; border-radius:8px; cursor:pointer;
    }
    .upload-form button:hover { background:#16324f; }

    /* Announcement list */
    .announcement-list { display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:20px; }
    .announcement-card {
      background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.08);
      display:flex; flex-direction:column; justify-content:space-between;
    }
    .announcement-card h3 { color:#1d3557; margin-bottom:8px; }
    .announcement-card p { font-size:14px; color:#555; }
    .announcement-meta { font-size:13px; color:#777; margin-top:8px; }
    .card-actions { margin-top:10px; display:flex; gap:10px; }
    .btn-delete { background:#e63946; color:#fff; padding:6px 10px; border-radius:6px; text-decoration:none; }
    .btn-delete:hover { opacity:0.85; }
  </style>
</head>
<body>
  <header class="header">
    <h1><i class="fas fa-calendar-alt"></i> Manage Announcements & Events</h1>
  <a href="index.php?action=dashboard" class="back-link">Back to Dashboard</a>
  </header>

  <div class="container">
    <?php if(isset($_GET['uploaded'])): ?>
      <p style="color:green; text-align:center;">Announcement added successfully!</p>
    <?php endif; ?>

    <div class="upload-form">
      <h2>📢 Add New Announcement / Event</h2>
      <form method="POST">
        <label>Title</label>
        <input type="text" name="title" required>

        <label>Description</label>
        <textarea name="description" placeholder="Brief details about the announcement or event..." required></textarea>

        <label>Event / Announcement Date</label>
        <input type="date" name="event_date" required>

        <button type="submit" name="upload"><i class="fas fa-upload"></i> Publish</button>
      </form>
    </div>

    <h2 style="color:#1d3557; margin-bottom:20px;">📅 Upcoming & Past Announcements</h2>
    <div class="announcement-list">
      <?php if (!empty($announcements)): ?>
        <?php foreach($announcements as $row): ?>
          <div class="announcement-card">
            <div>
              <h3><?= htmlspecialchars($row['title']) ?></h3>
              <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
              <div class="announcement-meta"><i class="fas fa-calendar"></i> <?= htmlspecialchars($row['event_date']) ?></div>
            </div>
            <div class="card-actions">
<<<<<<< HEAD
              <a href="?delete=<?= (int)$row['id'] ?>" class="btn-delete" onclick="return confirm('Delete this announcement?')"><i class="fas fa-trash"></i> Delete</a>
=======
              <a href="index.php?action=editAnnouncement&id=<?= (int)$row['id'] ?>" class="btn-edit" style="background:#28a745; color:#fff; padding:6px 10px; border-radius:6px; text-decoration:none;"><i class="fas fa-edit"></i> Edit</a>
              <a href="index.php?action=manageAnnouncements&delete=<?= (int)$row['id'] ?>" class="btn-delete" onclick="return confirm('Delete this announcement?')"><i class="fas fa-trash"></i> Delete</a>
>>>>>>> origin/main
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center; color:#666;">No announcements or events yet.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
