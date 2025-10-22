
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage HIV Content - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    body { background:#f9fafb; font-family:'Poppins',sans-serif; color:#333; margin:0; }
    .header { display:flex; justify-content:space-between; align-items:center; background:#1d3557; color:#fff; padding:20px 40px; }
    .header h1 { font-size:24px; margin:0; }
    .back-link { color:#fff; text-decoration:none; font-weight:bold; }
    .back-link:hover { text-decoration:underline; }
    .container { padding:40px; max-width:1100px; margin:auto; }

    .upload-form { background:#fff; padding:25px 30px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.1); margin-bottom:40px; }
    .upload-form h2 { margin-bottom:15px; color:#1d3557; }
    .upload-form label { display:block; margin:10px 0 5px; font-weight:500; }
    .upload-form input, .upload-form textarea, .upload-form select {
      width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:15px;
    }
    .upload-form textarea { resize:vertical; height:100px; }
    .upload-form button {
      margin-top:15px; background:#1d3557; color:#fff; border:none;
      padding:10px 20px; border-radius:8px; cursor:pointer;
    }
    .upload-form button:hover { background:#16324f; }

    .content-list { display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:20px; }
    .content-card {
      background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.08);
      display:flex; flex-direction:column; justify-content:space-between;
    }
    .content-card h3 { color:#1d3557; margin-bottom:8px; }
    .content-card p { font-size:14px; color:#555; margin-bottom:5px; }
    .card-actions { margin-top:10px; display:flex; gap:10px; }
    .btn-delete { background:#e63946; color:#fff; padding:6px 10px; border-radius:6px; text-decoration:none; }
    .btn-view { background:#1d3557; color:#fff; padding:6px 10px; border-radius:6px; text-decoration:none; }
    .btn-delete:hover, .btn-view:hover { opacity:0.85; }
    .empty-note { text-align:center; color:#666; padding:20px; background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.05);}
  </style>
</head>
<body>

<header class="header">
  <h1><i class="fas fa-upload"></i> Manage HIV Content</h1>
  <a href="index.php?action=dashboard" class="back-link">Back to Dashboard</a>
</header>

<div class="container">
  <!-- Upload Form -->
  <div class="upload-form">
    <h2>📤 Upload HIV-Related Content</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Title</label>
      <input type="text" name="title" required placeholder="e.g., Understanding HIV Transmission">

      <label>Category</label>
      <select name="category" required>
        <option value="Prevention">Prevention</option>
        <option value="Treatment & Medication">Treatment & Medication</option>
        <option value="Testing & Diagnosis">Testing & Diagnosis</option>
        <option value="Counselling & Support">Counselling & Support</option>
        <option value="Community Awareness">Community Awareness</option>
      </select>

      <label>Description</label>
      <textarea name="description" required placeholder="Brief summary or details..."></textarea>

      <label>Attach File (optional)</label>
      <input type="file" name="file" accept=".pdf,.jpg,.png,.jpeg,.mp4,.docx,.pptx">

      <button type="submit" name="upload"><i class="fas fa-upload"></i> Upload</button>
    </form>
  </div>

  <!-- Uploaded Content -->
  <h2 style="color:#1d3557; margin-bottom:20px;">📚 Uploaded HIV Awareness Materials</h2>
  <div class="content-list">
    <?php if (!empty($contentList)): ?>
      <?php foreach($contentList as $row): ?>
        <div class="content-card">
          <div>
            <h3><i class="fas fa-file-alt"></i> <?= htmlspecialchars($row['title']) ?></h3>
            <p><strong>Category:</strong> <?= htmlspecialchars($row['category']) ?></p>
            <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
          </div>
          <div class="card-actions">
            <?php if (!empty($row['file_path'])): ?>
              <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank" class="btn-view"><i class="fas fa-eye"></i> View</a>
            <?php endif; ?>
            <a href="?action=manageContent&delete=<?= (int)$row['id'] ?>" onclick="return confirm('Delete this content?')" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="empty-note">No HIV-related content uploaded yet.</div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
