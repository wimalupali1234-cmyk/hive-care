<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Patients - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
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

  <!-- Filter/Search -->
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

  <!-- Patient Table -->
  <div class="manage-container">
    <div class="right-column">
      <table>
        <thead>
          <tr>
            <th>Patient ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>DOB</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>John Doe</td>
            <td>john@example.com</td>
            <td>0771234567</td>
            <td>1990-01-01</td>
            <td>Male</td>
            <td><span class="status Active">Active</span></td>
            <td>
              <a href="#" class="btn-view"><i class="fas fa-eye"></i> View</a>
              <a href="#" class="btn-edit"><i class="fas fa-edit"></i> Update</a>
              <a href="#" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jane Smith</td>
            <td>jane@example.com</td>
            <td>0719876543</td>
            <td>1992-05-15</td>
            <td>Female</td>
            <td><span class="status Pending">Pending</span></td>
            <td>
              <a href="#" class="btn-view"><i class="fas fa-eye"></i> View</a>
              <a href="#" class="btn-edit"><i class="fas fa-edit"></i> Update</a>
              <a href="#" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
            </td>
          </tr>
          <!-- Add more patient rows as needed -->
        </tbody>
      </table>
    </div>
  </div>

</div> <!-- .main-container -->

</body>
</html>
