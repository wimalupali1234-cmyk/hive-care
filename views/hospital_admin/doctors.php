<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Doctors - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
</head>
<body>
<header class="header">
  <h1><i class="fas fa-user-md"></i> Manage Doctors</h1>
<a href="index.php?action=hospitalAdminDashboard" class="back-link">Back to Dashboard</a>
</header>

<div class="main-container">

  <!-- Success message -->
  <div class="success-msg">New doctor added successfully!</div>

  <!-- Stats -->
  <div class="stats">
    <div class="stat-box">
      <div class="stat-number">10</div>
      <div>Active Doctors</div>
    </div>
    <div class="stat-box">
      <div class="stat-number">3</div>
      <div>Pending Requests</div>
    </div>
    <div class="stat-box">
      <div class="stat-number">2</div>
      <div>Inactive Doctors</div>
    </div>
  </div>

  <!-- Filter -->
  <form class="filters">
    <input type="text" placeholder="Search doctor...">
    <select aria-label="Filter status">
      <option>All</option>
      <option>Active</option>
      <option>Pending</option>
      <option>Inactive</option>
      <option>Rejected</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
  </form>

  <!-- Two Columns -->
  <div class="manage-container">

    <!-- Left Column (Add Form) -->
    <div class="left-column">
      <h2>Add New Doctor</h2>
      <form>
        <input type="text" placeholder="Full Name" required>
        <input type="email" placeholder="Email" required>
        <input type="text" placeholder="Contact Number">
        <input type="text" placeholder="NIC">
        <select required>
          <option value="">Select Gender</option>
          <option>Male</option>
          <option>Female</option>
          <option>Other</option>
        </select>
        <input type="date" placeholder="Date of Birth">
        <input type="date" placeholder="Joined Date">
        <input type="text" placeholder="Qualifications">
        <input type="text" placeholder="License Number">
        <input type="date" placeholder="License Expiry Date">
        <button type="submit" class="add-btn">+ Add Doctor</button>
      </form>
    </div>

    <!-- Right Column (Doctor Cards) -->
    <div class="right-column">
      <div class="hospital-grid">
        <!-- Doctor Card Example -->
        <div class="hospital-card">
          <h3><i class="fas fa-user-md"></i> Dr. John Doe</h3>
          <p><i class="fas fa-envelope"></i> john@example.com</p>
          <p><i class="fas fa-phone"></i> 0771234567</p>
          <p><i class="fas fa-id-card"></i> 123456789V</p>
          <p><i class="fas fa-graduation-cap"></i> MBBS</p>
          <p><i class="fas fa-calendar-alt"></i> Joined: 2024-01-10</p>
          <span class="status Active">Active</span>
          <div class="actions">
            <a href="#" class="btn-deactivate"><i class="fas fa-ban"></i> Deactivate</a>
            <a href="#" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
            <a href="#" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
          </div>
        </div>

        <div class="hospital-card">
          <h3><i class="fas fa-user-md"></i> Dr. Jane Smith</h3>
          <p><i class="fas fa-envelope"></i> jane@example.com</p>
          <p><i class="fas fa-phone"></i> 0719876543</p>
          <p><i class="fas fa-id-card"></i> 987654321V</p>
          <p><i class="fas fa-graduation-cap"></i> MBBS, MD</p>
          <p><i class="fas fa-calendar-alt"></i> Joined: 2024-03-15</p>
          <span class="status Pending">Pending</span>
          <div class="actions">
            <a href="#" class="btn-approve"><i class="fas fa-check"></i> Approve</a>
            <a href="#" class="btn-reject"><i class="fas fa-times"></i> Reject</a>
            <a href="#" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
          </div>
        </div>

        <!-- Add more static doctor cards here -->

      </div>
    </div>

  </div> <!-- .manage-container -->

</div> <!-- .main-container -->
</body>
</html>
