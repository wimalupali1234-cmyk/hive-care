<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Admin Dashboard - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/styles.css">
</head>
<body>
  <!-- Sidebar can be included here if needed -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Admin Dashboard - HIVeCare</title>
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<header class="header">
  <div class="container">
    <div class="logo">
      <h1><i class="fas fa-heartbeat"></i> HIVeCare</h1>
    </div>
    <div class="auth-buttons">
      <nav class="main-nav">
        <ul>
          <li><a href="index.php">Home</a></li>
        </ul>
      </nav>
      <a href="logout.php" class="auth-btn logout-btn">Logout</a>
    </div>
  </div>
</header>

<section class="hero">
  <div class="container">
    <div class="hero-content">
      <h1>Hospital Admin Dashboard</h1>
      <p>Monitor and manage your hospital’s HIV services, staff, patients, inventory, and appointments efficiently.</p>
      <div class="hero-stats">
        <div class="stat-item"><span class="stat-number">0</span><span class="stat-label">Doctors</span></div>
        <div class="stat-item"><span class="stat-number">0</span><span class="stat-label">Patients</span></div>
        <div class="stat-item"><span class="stat-number">0</span><span class="stat-label">Appointments</span></div>
        <div class="stat-item"><span class="stat-number">0</span><span class="stat-label">Test Kits</span></div>
      </div>
    </div>
  </div>
</section>

<section class="categories">
  <div class="container">
    <h2>Quick Actions</h2>
    <div class="category-grid">
<a href="index.php?action=hospitalAdminStaff" class="category-card">
  <div class="card-icon"><i class="fas fa-user-tie"></i></div>
  <h3>Staff Management</h3>
  <p>Manage hospital staff profiles and roles.</p>
</a>

<a href="index.php?action=hospitalAdminPatients" class="category-card">
  <div class="card-icon"><i class="fas fa-user-injured"></i></div>
  <h3>Patient Management</h3>
  <p>View and manage patient records and HIV services.</p>
</a>

<a href="index.php?action=hospitalAdminInventory" class="category-card">
  <div class="card-icon"><i class="fas fa-boxes"></i></div>
  <h3>Inventory Management</h3>
  <p>Track and manage test kit inventory and supplies.</p>
</a>

<a href="index.php?action=hospitalAdminAppointments" class="category-card">
  <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
  <h3>Appointment Management</h3>
  <p>Monitor and schedule appointments and sessions.</p>
</a>

    </div>
  </div>
</section>



<footer class="footer">
  <div class="container">
    <p>&copy; 2024 HIVeCare. All rights reserved.</p>
  </div>
</footer>

<script>
// Example chart for hospital admin (can be customized)
const ctx = document.getElementById('analyticsChart')?.getContext('2d');
if(ctx){
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Doctors', 'Patients', 'Appointments', 'Test Kits'],
      datasets: [{
        label: 'This Month',
        data: [0, 0, 0, 0],
        backgroundColor: ['#ff6384','#36a2eb','#ffcd56','#4bc0c0']
      }]
    }
  });
}
</script>

</body>
</html>
