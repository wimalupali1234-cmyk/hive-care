<?php
require_once __DIR__ . '/../models/PreventiveMedModel.php';

class PreventiveMedController {
    private $model;

    public function __construct(mysqli $conn) {
        $this->model = new PreventiveMedModel($conn);
    }

    public function index() {
        // handle POST -> update then redirect (PRG)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['Medication_Name'])) {
            $data = [
                'Medication_Name'  => $_POST['Medication_Name'] ?? '',
                'Stock_Available'  => isset($_POST['Stock_Available']) ? (int)$_POST['Stock_Available'] : 0,
                'Pending_Orders'   => isset($_POST['Pending_Orders']) ? (int)$_POST['Pending_Orders'] : 0,
                'Sent_Orders'      => isset($_POST['Sent_Orders']) ? (int)$_POST['Sent_Orders'] : 0,
                'Expiry_Date'      => $_POST['Expiry_Date'] ?? '',
                'batch_number'     => $_POST['batch_number'] ?? '',
                'manufacturer'     => $_POST['manufacturer'] ?? '',
                'status'           => $_POST['status'] ?? '',
                'received_date'    => $_POST['received_date'] ?? '',
            ];

            $ok = $this->model->update($data);

            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['preventive_message'] = $ok ? '✅ Medication inventory updated successfully!' : '❌ Error updating record.';
            header('Location: index.php?action=preventivemed');
            exit;
        }

        // GET -> show page
        $meds = $this->model->getAll();

        $message = '';
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!empty($_SESSION['preventive_message'])) {
            $message = $_SESSION['preventive_message'];
            unset($_SESSION['preventive_message']);
        }

        include __DIR__ . '/../views/preventivemed.php';
    }
}
?>