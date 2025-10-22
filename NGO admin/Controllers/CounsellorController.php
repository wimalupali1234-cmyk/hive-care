<?php

require_once __DIR__ . '/../models/CounsellorModel.php';

class CounsellorController {
    private $model;
    public function __construct(mysqli $conn) {
        $this->model = new CounsellorModel($conn);
    }

    // list page with update/delete handling
    public function index() {
        // Handle POST requests for update/delete
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update_counsellor_id'])) {
                $data = [
                    'counsellor_id' => $_POST['counsellor_id'],
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
                $_SESSION['counsellor_message'] = $ok ? '✅ Counsellor record updated.' : '❌ Error updating counsellor.';
                header('Location: index.php?action=counsellors');
                exit;
            }

            if (isset($_POST['delete_counsellor_id'])) {
                $id = $_POST['delete_counsellor_id'];
                $ok = $this->model->delete($id);
                $_SESSION['counsellor_message'] = $ok ? '🗑️ Counsellor deleted.' : '❌ Error deleting counsellor.';
                header('Location: index.php?action=counsellors');
                exit;
            }
        }

        $counsellors = $this->model->getAll();
        $message = $_SESSION['counsellor_message'] ?? '';
        unset($_SESSION['counsellor_message']);
        include __DIR__ . '/../views/counsellor.php';
    }

    // handle steps and final submission
    public function step() {
        $step = (int)($_GET['step'] ?? 1);

        // POST handling: save step data in session
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($step === 1) {
                $_SESSION['counsellor_step1'] = [
                    'full_name' => trim($_POST['full_name'] ?? ''),
                    'gender' => $_POST['gender'] ?? '',
                    'dob' => $_POST['dob'] ?? '',
                    'nic' => trim($_POST['nic'] ?? ''),
                    'primary_contact' => trim($_POST['primary_contact'] ?? ''),
                    'secondary_contact' => trim($_POST['secondary_contact'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'address' => trim($_POST['address'] ?? '')
                ];
                header('Location: index.php?action=counsellor&step=2');
                exit;
            }

            if ($step === 2) {
                $_SESSION['counsellor_step2'] = [
                    'last_hospital' => trim($_POST['last_hospital'] ?? ''),
                    'hospital_address' => trim($_POST['hospital_address'] ?? ''),
                    'department' => $_POST['department'] ?? '',
                    'experience' => $_POST['experience'] ?? '',
                    'reference' => trim($_POST['reference'] ?? '')
                ];
                header('Location: index.php?action=counsellor&step=3');
                exit;
            }

            if ($step === 3 && isset($_POST['submit_all'])) {
                // final submission: merge session data + current POST
                $s1 = $_SESSION['counsellor_step1'] ?? [];
                $s2 = $_SESSION['counsellor_step2'] ?? [];
                $s3 = [
                    'qualification' => $_POST['highest_qualification'] ?? '',
                    'university' => trim($_POST['university'] ?? ''),
                    'license_no' => trim($_POST['license_no'] ?? ''),
                    'license_expiry' => $_POST['license_expiry'] ?? ''
                ];

                $payload = array_merge($s1, $s2, $s3);

                // Map field names to model insert keys
                $insertData = [
                    'full_name' => $payload['full_name'] ?? '',
                    'gender' => $payload['gender'] ?? '',
                    'email' => $payload['email'] ?? '',
                    'nic' => $payload['nic'] ?? '',
                    'primary_contact' => $payload['primary_contact'] ?? '',
                    'secondary_contact' => $payload['secondary_contact'] ?? '',
                    'address' => $payload['address'] ?? '',
                    'last_hospital' => $payload['last_hospital'] ?? '',
                    'hospital_address' => $payload['hospital_address'] ?? '',
                    'department' => $payload['department'] ?? '',
                    'experience' => $payload['experience'] ?? '',
                    'qualification' => $payload['qualification'] ?? '',
                    'university' => $payload['university'] ?? '',
                    'license_no' => $payload['license_no'] ?? '',
                    'license_expiry' => $payload['license_expiry'] ?? '',
                ];

                // Debug: Log the data being inserted
                error_log("Counsellor registration data: " . print_r($insertData, true));

                $ok = $this->model->insert($insertData);
                $_SESSION['counsellor_message'] = $ok ? '✅ Counsellor added.' : '❌ Error adding counsellor. Check error logs for details.';
                // clear step data
                unset($_SESSION['counsellor_step1'], $_SESSION['counsellor_step2']);
                header('Location: index.php?action=counsellors');
                exit;
            }
        }

        // render step view with prefilled session data
        $values = array_merge(
            $_SESSION['counsellor_step1'] ?? [],
            $_SESSION['counsellor_step2'] ?? []
        );
        include __DIR__ . "/../views/admin-counsellor-step{$step}.php";
    }
}
?>