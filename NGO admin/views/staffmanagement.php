<?php
$pageTitle = 'Staff Management - HIVeCare';
$pageDescription = 'Manage all staff members including doctors, counsellors, and lab technicians';
ob_start();
?>

<style>
  .staff-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
  }
  
  .staff-card {
    background: var(--white);
    padding: 40px;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    text-align: center;
    transition: var(--transition);
    text-decoration: none;
    color: inherit;
    border: 2px solid transparent;
  }
  
  .staff-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    border-color: var(--primary-color);
  }
  
  .staff-icon {
    font-size: 4rem;
    color: var(--primary-color);
    margin-bottom: 20px;
  }
  
  .staff-card h3 {
    color: var(--text-color);
    font-size: 1.5rem;
    margin-bottom: 15px;
  }
  
  .staff-card p {
    color: var(--text-light);
    font-size: 1rem;
    line-height: 1.6;
  }
  
  .about-hero {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: var(--white);
    padding: 80px 0;
    text-align: center;
  }
  
  .about-hero h1 {
    font-size: 3rem;
    margin-bottom: 20px;
  }
  
  .about-hero p {
    font-size: 1.2rem;
    opacity: 0.9;
  }
</style>

<!-- About Hero Section -->
<section class="about-hero">
  <div class="container">
    <h1>Staff Management</h1>
    <p>Manage all healthcare professionals in your organization</p>
  </div>
</section>

<main>
  <div class="container" style="padding: 60px 0;">
    <div class="staff-grid">
      <!-- Doctors -->
      <a href="index.php?action=doctors" class="staff-card">
        <div class="staff-icon">
          <i class="fas fa-user-md"></i>
        </div>
        <h3>Doctors</h3>
        <p>Manage doctor profiles, qualifications, and medical licenses. Add, edit, or remove doctor records.</p>
      </a>

      <!-- Counsellors -->
      <a href="index.php?action=counsellors" class="staff-card">
        <div class="staff-icon">
          <i class="fas fa-hand-holding-heart"></i>
        </div>
        <h3>Counsellors</h3>
        <p>Manage counsellor information, specializations, and certifications. Handle counselling staff records.</p>
      </a>

      <!-- Lab Technicians -->
      <a href="index.php?action=labtech" class="staff-card">
        <div class="staff-icon">
          <i class="fas fa-flask"></i>
        </div>
        <h3>Lab Technicians</h3>
        <p>Manage lab technician profiles, technical qualifications, and laboratory certifications.</p>
      </a>
    </div>
  </div>
</main>

<?php 
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
