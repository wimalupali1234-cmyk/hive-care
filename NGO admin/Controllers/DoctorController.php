<?php

require_once __DIR__ . '/../models/DoctorModel.php';

class DoctorController {
    private $model;
    public function __construct(mysqli $conn) {
        $this->model = new DoctorModel($conn);
    }

    // list + update + delete
    public function index() {
        // handle inline update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update_doctor_id'])) {
                $data = [
                    'doctor_id' => $_POST['doctor_id'],
                    'full_name' => $_POST['full_name'] ?? '',
                    'gender' => $_POST['gender'] ?? '',
                    'nic' => $_POST['nic'] ?? '',
                    'primary_contact' => $_POST['primary_contact'] ?? '',
                    'secondary_contact' => $_POST['secondary_contact'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'address' => $_POST['address'] ?? '',
                    'last_hospital' => $_POST['last_hospital'] ?? '',
                    'hospital_address' => $_POST['hospital_address'] ?? '',
                    'department' => $_POST['department'] ?? '',
                    'experience' => $_POST['experience'] ?? '',
                    'qualification' => $_POST['qualification'] ?? '',
                    'university' => $_POST['university'] ?? '',
                    'license_no' => $_POST['license_no'] ?? '',
                    'license_expiry' => $_POST['license_expiry'] ?? null,
                ];
                $ok = $this->model->update($data);
                $_SESSION['flash_message'] = $ok ? '✅ Doctor record updated.' : '❌ Error updating doctor.';
                header('Location: index.php?action=doctors');
                exit;
            }

            if (isset($_POST['delete_doctor_id'])) {
                $id = $_POST['delete_doctor_id'];
                $ok = $this->model->delete($id);
                $_SESSION['flash_message'] = $ok ? '🗑️ Doctor deleted.' : '❌ Error deleting doctor.';
                header('Location: index.php?action=doctors');
                exit;
            }
        }

        $doctors = $this->model->getAll();
        $message = $_SESSION['flash_message'] ?? '';
        unset($_SESSION['flash_message']);
        include __DIR__ . '/../views/doctor.php';
    }

    // add workflow (multi-step) using session storage
    public function add() {
        $step = (int)($_GET['step'] ?? 1);

        // start session must already be started by index.php
        $_SESSION['doctor_wizard'] = $_SESSION['doctor_wizard'] ?? [];

        // Save POST data and redirect to avoid double-post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // merge posted fields into session
            foreach ($_POST as $k => $v) {
                // avoid file inputs here (not implemented)
                $_SESSION['doctor_wizard'][$k] = $v;
            }

            // if final submit
            if (isset($_POST['submit_all'])) {
                // Gather data from session (doctor_id will be auto-generated)
                $d = &$_SESSION['doctor_wizard'];
                
                $data = [
                    'full_name' => $d['full_name'] ?? '',
                    'gender' => $d['gender'] ?? '',
                    'nic' => $d['nic'] ?? '',
                    'primary_contact' => $d['primary_contact'] ?? '',
                    'secondary_contact' => $d['secondary_contact'] ?? '',
                    'email' => $d['email'] ?? '',
                    'address' => $d['address'] ?? '',
                    'last_hospital' => $d['last_hospital'] ?? '',
                    'hospital_address' => $d['hospital_address'] ?? '',
                    'department' => $d['department'] ?? '',
                    'experience' => $d['experience'] ?? '',
                    'qualification' => $d['qualification'] ?? '',
                    'university' => $d['university'] ?? '',
                    'license_no' => $d['license_no'] ?? '',
                    'license_expiry' => $d['license_expiry'] ?? null,
                ];

                // Debug: Log the data being inserted
                error_log("Doctor registration data: " . print_r($data, true));
                
                $ok = $this->model->create($data);
                unset($_SESSION['doctor_wizard']);
                $_SESSION['flash_message'] = $ok ? '✅ Doctor added successfully.' : '❌ Error adding doctor. Check error logs for details.';
                header('Location: index.php?action=doctors');
                exit;
            }

            // otherwise advance to next step to allow PRG
            $next = $step + 1;
            header("Location: index.php?action=doctor_add&step={$next}");
            exit;
        }

        // render appropriate step view, passing any saved values
        $values = $_SESSION['doctor_wizard'] ?? [];
        include __DIR__ . "/../views/admin-doctor-step{$step}.php";
    }
}
?>