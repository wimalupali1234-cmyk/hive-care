<?php
class HospitalAdminController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // ---------------- Dashboard ----------------
    public function dashboard() {
        include __DIR__ . '/../../views/hospital_admin/dashboard.php';
    }

    // ---------------- Staff Management ----------------
    public function staffManagement() {
        // Fetch counts for each staff type
        $doctor_count = $this->conn->query("SELECT COUNT(*) AS total FROM doctors")->fetch_assoc()['total'] ?? 0;
        $counsellor_count = $this->conn->query("SELECT COUNT(*) AS total FROM counsellors")->fetch_assoc()['total'] ?? 0;
        $labtech_count = $this->conn->query("SELECT COUNT(*) AS total FROM lab_technicians")->fetch_assoc()['total'] ?? 0;

        // Include the view
        include __DIR__ . '/../../views/hospital_admin/staffmanagement.php';
    }

    // ---------------- Doctors ----------------
    public function doctors() {
        include __DIR__ . '/../../views/hospital_admin/doctors.php';
    }

    // ---------------- Counsellors ----------------
    public function counsellors() {
        include __DIR__ . '/../../views/hospital_admin/counsellors.php';
    }

    // ---------------- Lab Technicians ----------------
    public function labTech() {
        include __DIR__ . '/../../views/hospital_admin/labtech.php';
    }

    // ---------------- Patients ----------------
    public function patients() {
        include __DIR__ . '/../../views/hospital_admin/manage_patients.php';
    }

    // ---------------- Inventory Management ----------------
    public function inventory() {
        include __DIR__ . '/../../views/hospital_admin/inventorymanagement.php';
    }

    // Inventory subpages
    public function testkits() {
        include __DIR__ . '/../../views/hospital_admin/testkits.php';
    }

    public function preventivemed() {
        include __DIR__ . '/../../views/hospital_admin/preventivemed.php';
    }

    public function facilitytest() {
        include __DIR__ . '/../../views/hospital_admin/facilitytest.php';
    }

    public function othermaterial() {
        include __DIR__ . '/../../views/hospital_admin/othermaterial.php';
    }

    // ---------------- Appointments ----------------
    public function appointments() {
        include __DIR__ . '/../../views/hospital_admin/appointmentmanagement.php';
    }
}
?>
