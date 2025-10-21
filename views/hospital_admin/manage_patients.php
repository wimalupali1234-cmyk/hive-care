<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Patients - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
  <style>
    /* Main container */
    .main-container { max-width: 1200px; margin: 40px auto; padding: 20px; }

    /* Stats */
    .stats { display: flex; gap: 20px; margin-bottom: 30px; }
    .stat-box { flex: 1; background: #fff; padding: 20px; text-align: center; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .stat-number { font-size: 28px; font-weight: bold; }

    /* Filters */
    .filters { display: flex; gap: 10px; margin-bottom: 30px; }
    .filters input, .filters select { padding: 8px 10px; border-radius: 5px; border: 1px solid #ccc; flex: 1; }
    .filter-btn { padding: 8px 15px; background: #1d3557; color: #fff; border: none; border-radius: 5px; cursor: pointer; }

    /* Patient Cards */
    .hospital-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
    .hospital-card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .hospital-card h3 { margin-top: 0; margin-bottom: 10px; font-size: 18px; }
    .hospital-card p { margin: 6px 0; font-size: 14px; }
    .hospital-card .status { display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; margin-top: 8px; }
    .status.Active { background-color: #2a9d8f; color: #fff; }
    .status.Pending { background-color: #e9c46a; color: #000; }
    .status.Inactive { background-color: #f4a261; color: #fff; }

    /* Action Buttons */
    .actions { margin-top: 12px; }
    .actions a { text-decoration: none; color: #fff; padding: 6px 12px; border-radius: 5px; font-size: 13px; margin-right: 5px; display: inline-block; }
    .btn-view { background: #1d3557; }
    .btn-edit { background: #457b9d; }
    .btn-delete { background: #e63946; }
    .btn-view:hover { background: #0f2f4d; }
    .btn-edit:hover { background: #1a5276; }
    .btn-delete:hover { background: #c5303f; }

    /* Form-style layout inside cards */
    .hospital-card label { display: block; font-weight: 600; font-size: 12px; margin-top: 10px; color: #555; }
    .hospital-card .field-value { font-size: 14px; padding: 6px 10px; background: #f4f6f9; border-radius: 5px; margin-top: 3px; }
  </style>
</head>
<body>

<header class="header">
  <h1><i class="fas fa-hospital-user"></i> Manage Patients</h1>
  <a href="index.php?action=hospitalAdminDashboard" class="back-link">Back to Dashboard</a>
</header>

<div class="main-container">

  <!-- Stats -->
  <div class="stats">
    <div class="stat-box">
      <div class="stat-number">12</div>
      <div>Active Patients</div>
    </div>
    <div class="stat-box">
      <div class="stat-number">3</div>
      <div>Pending Patients</div>
    </div>
    <div class="stat-box">
      <div class="stat-number">1</div>
      <div>Inactive Patients</div>
    </div>
  </div>

  <!-- Filter -->
  <form class="filters">
    <input type="text" placeholder="Search patient...">
    <select aria-label="Filter status">
      <option>All</option>
      <option>Active</option>
      <option>Pending</option>
      <option>Inactive</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
  </form>

  <!-- Patient Cards -->
  <div class="hospital-grid">

    <!-- Example Patient Card -->
    <div class="hospital-card">
      <h3>John Doe</h3>
      <label>Patient ID</label>
      <div class="field-value">1</div>

      <label>Email</label>
      <div class="field-value">john@example.com</div>

      <label>Contact Number</label>
      <div class="field-value">0771234567</div>

      <label>Date of Birth</label>
      <div class="field-value">1990-01-01</div>

      <label>Gender</label>
      <div class="field-value">Male</div>

      <label>Registered At</label>
      <div class="field-value">2024-01-15</div>

      <label>Status</label>
      <span class="status Active">Active</span>

      <div class="actions">
        <a href="#" class="btn-view"><i class="fas fa-eye"></i> View History</a>
        <a href="#" class="btn-edit"><i class="fas fa-edit"></i> Update</a>
        <a href="#" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
      </div>
    </div>

    <div class="hospital-card">
      <h3>Jane Smith</h3>
      <label>Patient ID</label>
      <div class="field-value">2</div>

      <label>Email</label>
      <div class="field-value">jane@example.com</div>

      <label>Contact Number</label>
      <div class="field-value">0719876543</div>

      <label>Date of Birth</label>
      <div class="field-value">1992-05-15</div>

      <label>Gender</label>
      <div class="field-value">Female</div>

      <label>Registered At</label>
      <div class="field-value">2024-03-01</div>

      <label>Status</label>
      <span class="status Pending">Pending</span>

      <div class="actions">
        <a href="#" class="btn-view"><i class="fas fa-eye"></i> View History</a>
        <a href="#" class="btn-edit"><i class="fas fa-edit"></i> Update</a>
        <a href="#" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
      </div>
    </div>

    <!-- Add more patient cards dynamically as needed -->

  </div> <!-- .hospital-grid -->

</div> <!-- .main-container -->

</body>
</html>
