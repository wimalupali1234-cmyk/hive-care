<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Feedback & Queries - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIVe/public/css/style.css">
  <link rel="stylesheet" href="style.css">
  <style>
    body { background:#f8f9fa; font-family:'Poppins',sans-serif; color:#333; }
    .header { display:flex; justify-content:space-between; align-items:center; background:#1d3557; color:#fff; padding:20px 40px; }
    .header h1 { font-size:24px; }
    .back-link { color:#fff; text-decoration:none; }
    .back-link:hover { text-decoration:underline; }

    .container { padding:40px; max-width:1100px; margin:auto; }

    /* Filter bar */
    .filters { display:flex; justify-content:flex-end; margin-bottom:25px; gap:10px; }
    .filters select, .filters button {
      padding:8px 12px; border-radius:8px; border:1px solid #ccc;
      background:#fff; cursor:pointer; font-size:14px;
    }
    .filters button {
      background:#1d3557; color:#fff; border:none;
    }
    .filters button:hover { background:#16324f; }

    /* Feedback cards */
    .feedback-list {
      display:grid; grid-template-columns:repeat(auto-fill,minmax(330px,1fr)); gap:20px;
    }
    .feedback-card {
      background:#fff; padding:20px; border-radius:12px;
      box-shadow:0 2px 8px rgba(0,0,0,0.08);
    }
    .feedback-card h3 { color:#1d3557; font-size:18px; margin-bottom:10px; }
    .feedback-card p { font-size:14px; color:#444; }
    .meta { font-size:13px; color:#666; margin-top:8px; }
    .status {
      display:inline-block; padding:5px 10px; border-radius:8px; font-size:13px; font-weight:600;
      margin-top:8px;
    }
    .status.Pending { background:#fdd835; color:#333; }
    .status.Resolved { background:#2ecc71; color:#fff; }

    .actions { margin-top:15px; display:flex; gap:10px; }
    .btn-delete { background:#e63946; color:#fff; padding:6px 10px; border-radius:6px; text-decoration:none; }
    .btn-delete:hover { opacity:0.85; }

    /* Respond form */
    .respond-box {
      margin-top:10px; padding:10px; background:#f1f3f6; border-radius:8px;
    }
    .respond-box textarea {
      width:100%; border-radius:8px; border:1px solid #ccc;
      padding:8px; resize:vertical; font-size:14px;
    }
    .respond-box button {
      background:#1d3557; color:#fff; border:none; padding:8px 12px;
      border-radius:6px; margin-top:8px; cursor:pointer;
    }
    .respond-box button:hover { background:#16324f; }
  </style>
</head>
<body>
  <header class="header">
    <h1><i class="fas fa-comments"></i> Feedback & Queries</h1>
    <a href="index.php?action=dashboard" class="back-link">Back to Dashboard</a>
  </header>

  <div class="container">
    <form method="GET" action="index.php" class="filters">
      <input type="hidden" name="action" value="manageFeedback">
      <select name="filter">
        <option value="all" <?= $filter=='all'?'selected':'' ?>>All</option>
        <option value="Feedback" <?= $filter=='Feedback'?'selected':'' ?>>Feedback</option>
        <option value="Query" <?= $filter=='Query'?'selected':'' ?>>Queries</option>
        <option value="Complaint" <?= $filter=='Complaint'?'selected':'' ?>>Complaints</option>
      </select>
      <button type="submit">Filter</button>
    </form>

    <div class="feedback-list">
      <?php if (!empty($result) && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <div class="feedback-card">
            <h3><i class="fas fa-user-circle"></i> <?= htmlspecialchars($row['user_name'] ?? 'Anonymous') ?></h3>
            <p><strong>Type:</strong> <?= htmlspecialchars($row['type']) ?></p>
            <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
            <div class="meta"><i class="fas fa-calendar"></i> <?= htmlspecialchars($row['submitted_at']) ?></div>
            <div class="status <?= htmlspecialchars($row['status']) ?>">
              <?= htmlspecialchars($row['status']) ?>
            </div>

            <?php if (!empty($row['response'])): ?>
              <div class="respond-box">
                <strong>Response:</strong>
                <p><?= nl2br(htmlspecialchars($row['response'])) ?></p>
              </div>
            <?php else: ?>
              <form method="POST" action="index.php?action=manageFeedback" class="respond-box">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <textarea name="response" placeholder="Write a response..." required></textarea>
                <button type="submit" name="respond"><i class="fas fa-reply"></i> Send Response</button>
              </form>
            <?php endif; ?>

            <div class="actions">
              <a href="index.php?action=manageFeedback&delete=<?= $row['id'] ?>" 
                 class="btn-delete" 
                 onclick="return confirm('Delete this feedback?')">
                 <i class="fas fa-trash"></i> Delete
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center; color:#666;">No feedback or queries yet.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
