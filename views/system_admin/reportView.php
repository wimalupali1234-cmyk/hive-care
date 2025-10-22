<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Report - HIVeCare</title>
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
  <link rel="stylesheet" href="/HIVe/public/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
[existing code]
</body>
</html>
<?php
include 'config.php';

// Default values
$reportType = $_POST['report_type'] ?? 'daily';
$startDate = $_POST['start_date'] ?? date('Y-m-d');
$endDate = $_POST['end_date'] ?? date('Y-m-d');

// Query filter
$where = "";
if ($reportType === 'custom' && !empty($startDate) && !empty($endDate)) {
    $where = "WHERE DATE(created_at) BETWEEN '$startDate' AND '$endDate'";
} elseif ($reportType === 'monthly') {
    $where = "WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
} else {
    $where = "WHERE DATE(created_at) = CURDATE()";
}

// Collect data
$tests = $conn->query("SELECT COUNT(*) AS total FROM appointments $where AND type='test'")->fetch_assoc()['total'] ?? 0;
$counselling = $conn->query("SELECT COUNT(*) AS total FROM appointments $where AND type='counselling'")->fetch_assoc()['total'] ?? 0;
$contents = $conn->query("SELECT COUNT(*) AS total FROM content $where")->fetch_assoc()['total'] ?? 0;
$feedback = $conn->query("SELECT COUNT(*) AS total FROM feedback $where")->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Generate Reports - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    body { background:#f9fafb; font-family:'Poppins',sans-serif; color:#333; margin:0; }
    .header { display:flex; justify-content:space-between; align-items:center; background:#1d3557; color:#fff; padding:20px 40px; }
    .header h1 { font-size:24px; margin:0; }
    .back-link { color:#fff; text-decoration:none; font-weight:bold; }
    .back-link:hover { text-decoration:underline; }
    .container { padding:40px; max-width:1100px; margin:auto; }

    .report-form { background:#fff; padding:25px 30px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.1); margin-bottom:30px; }
    .report-form label { display:block; margin:10px 0 5px; font-weight:500; }
    .report-form select, .report-form input { width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:15px; }
    .report-form button {
      margin-top:15px; background:#1d3557; color:#fff; border:none;
      padding:10px 20px; border-radius:8px; cursor:pointer;
    }
    .report-form button:hover { background:#16324f; }

    .report-summary {
      display:grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap:20px;
      margin-top:25px;
    }

    .summary-card {
      background:#fff;
      padding:20px;
      border-radius:12px;
      box-shadow:0 4px 8px rgba(0,0,0,0.08);
      text-align:center;
    }

    .summary-card h3 { color:#1d3557; font-size:16px; margin-bottom:8px; }
    .summary-card .num { font-size:26px; font-weight:700; color:#1d3557; }

    .download-btn {
      display:inline-block;
      background:#457b9d;
      color:#fff;
      padding:10px 18px;
      border-radius:8px;
      text-decoration:none;
      margin-top:25px;
      transition:0.3s;
    }
    .download-btn:hover { background:#1d3557; }
  </style>
</head>
<body>
  <header class="header">
    <h1><i class="fas fa-chart-line"></i> Generate Reports</h1>
    <a href="dashboard.php" class="back-link">Back to Dashboard</a>
  </header>

  <div class="container">
    <!-- Report Form -->
    <form method="POST" class="report-form">
      <label>Report Type</label>
      <select name="report_type" id="report_type" onchange="toggleCustomDates(this.value)">
        <option value="daily" <?= $reportType==='daily'?'selected':'' ?>>Daily Report</option>
        <option value="monthly" <?= $reportType==='monthly'?'selected':'' ?>>Monthly Report</option>
        <option value="custom" <?= $reportType==='custom'?'selected':'' ?>>Custom Range</option>
      </select>

      <div id="custom_dates" style="display:<?= $reportType==='custom'?'block':'none' ?>;">
        <label>Start Date</label>
        <input type="date" name="start_date" value="<?= $startDate ?>">
        <label>End Date</label>
        <input type="date" name="end_date" value="<?= $endDate ?>">
      </div>

      <button type="submit"><i class="fas fa-file-alt"></i> Generate</button>
    </form>

    <!-- Summary Cards -->
    <div class="report-summary">
      <div class="summary-card"><h3><i class="fas fa-vial"></i> Tests Booked</h3><div class="num"><?= $tests ?></div></div>
      <div class="summary-card"><h3><i class="fas fa-comments"></i> Counselling Sessions</h3><div class="num"><?= $counselling ?></div></div>
      <div class="summary-card"><h3><i class="fas fa-upload"></i> Uploaded Content</h3><div class="num"><?= $contents ?></div></div>
      <div class="summary-card"><h3><i class="fas fa-envelope"></i> Feedback</h3><div class="num"><?= $feedback ?></div></div>
    </div>

    <a href="#" class="download-btn"><i class="fas fa-download"></i> Download Report (PDF)</a>
  </div>

  <script>
    function toggleCustomDates(value) {
      document.getElementById('custom_dates').style.display = value === 'custom' ? 'block' : 'none';
    }
  </script>
</body>
</html>
