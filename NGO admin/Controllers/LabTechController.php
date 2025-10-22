<?php

require_once __DIR__ . '/../models/LabTechModel.php';

class LabTechController {
    private $model;
    private $uploadsDir;

    public function __construct(mysqli $conn) {
        $this->model = new LabTechModel($conn);
        $this->uploadsDir = __DIR__ . '/../uploads/labtech';
        if (!is_dir($this->uploadsDir)) mkdir($this->uploadsDir, 0755, true);
    }

    public function index() {
        // Handle POST requests for update/delete
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update_tech_id'])) {
                $data = [
                    'tech_id' => $_POST['tech_id'],
                    'full_name' => $_POST['full_name'] ?? '',
                    'gender' => $_POST['gender'] ?? '',
                    'nic_number' => $_POST['nic_number'] ?? '',
                    'primary_contact' => $_POST['primary_contact'] ?? '',
                    'secondary_contact' => $_POST['secondary_contact'] ?? '',
                    'email_address' => $_POST['email_address'] ?? '',
                    'address' => $_POST['address'] ?? '',
                    'last_hospital_name' => $_POST['last_hospital_name'] ?? '',
                    'hospital_address' => $_POST['hospital_address'] ?? '',
                    'department' => $_POST['department'] ?? '',
                    'experience' => $_POST['experience'] ?? '',
                    'highest_qualification' => $_POST['highest_qualification'] ?? '',
                    'university_name' => $_POST['university_name'] ?? '',
                    'license_number' => $_POST['license_number'] ?? '',
                    'license_expiry' => $_POST['license_expiry'] ?? null,
                ];
                $ok = $this->model->update($data);
                $_SESSION['labtech_message'] = $ok ? '✅ Lab technician record updated.' : '❌ Error updating lab technician.';
                header('Location: index.php?action=labtech');
                exit;
            }

            if (isset($_POST['delete_tech_id'])) {
                $id = $_POST['delete_tech_id'];
                $ok = $this->model->delete($id);
                $_SESSION['labtech_message'] = $ok ? '🗑️ Lab technician deleted.' : '❌ Error deleting lab technician.';
                header('Location: index.php?action=labtech');
                exit;
            }
        }

        $labtechs = $this->model->getAll();
        $message = $_SESSION['labtech_message'] ?? '';
        unset($_SESSION['labtech_message']);
        include __DIR__ . '/../views/labtech.php';
    }

    // step1 collects personal details and redirects to step2
    public function step1() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['labtech_step1'] = [
                'full_name' => trim($_POST['full_name'] ?? ''),
                'gender' => $_POST['gender'] ?? '',
                'dob' => $_POST['dob'] ?? '',
                'nic_number' => trim($_POST['nic_number'] ?? ''),
                'primary_contact' => trim($_POST['primary_contact'] ?? ''),
                'secondary_contact' => trim($_POST['secondary_contact'] ?? ''),
                'email_address' => trim($_POST['email_address'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
            ];
            header('Location: index.php?action=labtech_step2');
            exit;
        }
        $data = $_SESSION['labtech_step1'] ?? [];
        include __DIR__ . '/../views/labtech_step1.php';
    }

    // step2 collects professional details and redirects to step3
    public function step2() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['labtech_step2'] = [
                'last_hospital_name' => trim($_POST['last_hospital_name'] ?? ''),
                'hospital_address' => trim($_POST['hospital_address'] ?? ''),
                'department' => $_POST['department'] ?? '',
                'designation' => trim($_POST['designation'] ?? ''),
                'experience' => $_POST['experience'] ?? '',
                'reference' => trim($_POST['reference'] ?? ''),
            ];
            header('Location: index.php?action=labtech_step3');
            exit;
        }
        $data = $_SESSION['labtech_step2'] ?? [];
        include __DIR__ . '/../views/labtech_step2.php';
    }

    // step3 collects credentials/files and on POST creates record
    public function step3() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // collect previous steps
            $step1 = $_SESSION['labtech_step1'] ?? [];
            $step2 = $_SESSION['labtech_step2'] ?? [];

            // handle uploads
            $uploads = ['degree_certificate','professional_license','employment_letter'];
            $saved = [];
            foreach ($uploads as $key) {
                $saved[$key] = '';
                if (!empty($_FILES[$key]['name'])) {
                    $ext = pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION);
                    $fname = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
                    $dst = $this->uploadsDir . '/' . $fname;
                    if (move_uploaded_file($_FILES[$key]['tmp_name'], $dst)) {
                        $saved[$key] = $fname;
                    }
                }
            }

            // assemble data for DB
            $data = [
                'full_name' => $step1['full_name'] ?? '',
                'gender' => $step1['gender'] ?? '',
                'nic_number' => $step1['nic_number'] ?? '',
                'primary_contact' => $step1['primary_contact'] ?? '',
                'secondary_contact' => $step1['secondary_contact'] ?? '',
                'email_address' => $step1['email_address'] ?? '',
                'address' => $step1['address'] ?? '',
                'last_hospital_name' => $step2['last_hospital_name'] ?? '',
                'hospital_address' => $step2['hospital_address'] ?? '',
                'department' => $step2['department'] ?? '',
                'experience' => $step2['experience'] ?? '',
                'highest_qualification' => trim($_POST['qualification'] ?? ''),
                'university_name' => trim($_POST['university'] ?? ''),
                'license_number' => trim($_POST['license_number'] ?? ''),
                'license_expiry' => $_POST['license_expiry'] ?? null,
                'degree_certificate' => $saved['degree_certificate'],
                'professional_license' => $saved['professional_license'],
                'employment_letter' => $saved['employment_letter'],
            ];

            // Debug: Log the data being inserted
            error_log("Lab Tech registration data: " . print_r($data, true));
            
            $ok = $this->model->create($data);
            // clear session steps after success (or always)
            unset($_SESSION['labtech_step1'], $_SESSION['labtech_step2']);
            $_SESSION['labtech_message'] = $ok ? '✅ Lab technician added successfully.' : '❌ Error adding lab technician. Check error logs for details.';
            header('Location: index.php?action=labtech');
            exit;
        }

        $prevStep1 = $_SESSION['labtech_step1'] ?? [];
        $prevStep2 = $_SESSION['labtech_step2'] ?? [];
        include __DIR__ . '/../views/labtech_step3.php';
    }

    // delete handler (POST)
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tech_id'])) {
            $id = $_POST['delete_tech_id'];
            $this->model->delete($id);
        }
        header('Location: index.php?action=labtech');
        exit;
    }
}
?>