<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointment Management - HIVeCare</title>
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

    /* Appointment Table */
    table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
    table th, table td { padding: 12px 16px; border-bottom: 1px solid #ddd; text-align: left; }
    table th { background-color: #f8f9fa; }
    .btn { padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; }
    .primary-btn { background-color: #1d3557; color: #fff; }

    /* Status labels */
    .status-Pending { color: #e9c46a; font-weight: bold; }
    .status-Completed { color: #2a9d8f; font-weight: bold; }
  </style>
</head>
<body>

<header class="header">
  <h1><i class="fas fa-calendar-check"></i> Appointment Management</h1>
  <a href="index.php?action=hospitalAdminDashboard" class="back-link" style="color:white;">Back to Dashboard</a>
</header>

<div class="main-container">

  <!-- Stats -->
  <div class="stats">
    <div class="stat-box">
      <div class="stat-number">5</div>
      <div>Pending Appointments</div>
    </div>
    <div class="stat-box">
      <div class="stat-number">8</div>
      <div>Completed Appointments</div>
    </div>
  </div>

  <!-- Filter -->
  <form class="filters">
    <input type="text" placeholder="Search by patient name/email">
    <select>
      <option>All Statuses</option>
      <option>Pending</option>
      <option>Completed</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
  </form>

  <!-- Appointment Table -->
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Appointment ID</th>
          <th>Patient Name</th>
          <th>Type</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>John Doe</td>
          <td>HIV Test</td>
          <td>2025-10-22</td>
          <td>09:00</td>
          <td class="status-Pending">Pending</td>
          <td><button class="btn primary-btn"><i class="fas fa-save"></i> Update</button></td>
        </tr>
        <tr>
          <td>2</td>
          <td>Jane Smith</td>
          <td>Counselling</td>
          <td>2025-10-23</td>
          <td>11:00</td>
          <td class="status-Completed">Completed</td>
          <td><button class="btn primary-btn"><i class="fas fa-save"></i> Update</button></td>
        </tr>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
