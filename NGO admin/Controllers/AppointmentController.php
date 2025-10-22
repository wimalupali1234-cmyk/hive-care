<?php

require_once __DIR__ . '/../models/AppointmentModel.php';

class AppointmentController {
    private $model;
    
    public function __construct(mysqli $conn) {
        $this->model = new AppointmentModel($conn);
    }
    
    public function index() {
        // Handle POST requests for update/delete
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update_appointment_id'])) {
                $data = [
                    'appointment_id' => (int)$_POST['appointment_id'],
                    'patient_id' => $_POST['patient_id'] ?? '',
                    'type' => $_POST['type'] ?? '',
                    'appointment_date' => $_POST['appointment_date'] ?? '',
                    'appointment_time' => $_POST['appointment_time'] ?? '',
                    'status' => $_POST['status'] ?? '',
                ];
                $ok = $this->model->update($data);
                $_SESSION['appointment_message'] = $ok ? '✅ Appointment updated successfully.' : '❌ Error updating appointment.';
                header('Location: index.php?action=appointments');
                exit;
            }

            if (isset($_POST['delete_appointment_id'])) {
                $id = (int)$_POST['delete_appointment_id'];
                $ok = $this->model->delete($id);
                $_SESSION['appointment_message'] = $ok ? '🗑️ Appointment deleted.' : '❌ Error deleting appointment.';
                header('Location: index.php?action=appointments');
                exit;
            }
        }

        $appointments = $this->model->getAll();
        $message = $_SESSION['appointment_message'] ?? '';
        unset($_SESSION['appointment_message']);
        include __DIR__ . '/../views/appointmentmanagement.php';
    }
}
?>
