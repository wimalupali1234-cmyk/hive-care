<?php

require_once __DIR__ . '/../models/PatientModel.php';

class PatientController {
    private $model;
    
    public function __construct(mysqli $conn) {
        $this->model = new PatientModel($conn);
    }
    
    public function index() {
        // Handle POST requests for update/delete
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update_patient_id'])) {
                $data = [
                    'patient_id' => (int)$_POST['patient_id'],
                    'address' => $_POST['address'] ?? '',
                    'telephone' => $_POST['telephone'] ?? '',
                    'email' => $_POST['email'] ?? '',
                ];
                $ok = $this->model->update($data);
                $_SESSION['patient_message'] = $ok ? '✅ Patient updated successfully.' : '❌ Error updating patient.';
                header('Location: index.php?action=patients');
                exit;
            }

            if (isset($_POST['delete_patient_id'])) {
                $id = (int)$_POST['delete_patient_id'];
                $ok = $this->model->delete($id);
                $_SESSION['patient_message'] = $ok ? '🗑️ Patient deleted.' : '❌ Error deleting patient.';
                header('Location: index.php?action=patients');
                exit;
            }
        }

        $patients = $this->model->getAll();
        $message = $_SESSION['patient_message'] ?? '';
        unset($_SESSION['patient_message']);
        include __DIR__ . '/../views/patientmanagement.php';
    }
}
?>
