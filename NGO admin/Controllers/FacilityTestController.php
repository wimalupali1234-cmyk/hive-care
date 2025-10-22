<?php
require_once __DIR__ . '/../models/FacilityTestModel.php';

class FacilityTestController {
    private $model;

    public function __construct(mysqli $conn) {
        $this->model = new FacilityTestModel($conn);
    }

    public function index() {
        // handle POST update
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['Test_type'])) {
            $data = [
                'Test_type' => $_POST['Test_type'] ?? '',
                'Stock_Available' => isset($_POST['Stock_Available']) ? (int)$_POST['Stock_Available'] : 0,
                'Expiry_Date' => $_POST['Expiry_Date'] ?? '',
                'batch_number' => $_POST['batch_number'] ?? '',
                'manufacturer' => $_POST['manufacturer'] ?? '',
                'manufacture_date' => $_POST['manufacture_date'] ?? '',
                'status' => $_POST['status'] ?? '',
                'received_date' => $_POST['received_date'] ?? '',
                'supplier_name' => $_POST['supplier_name'] ?? '',
            ];

            $ok = $this->model->update($data);

            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['facility_message'] = $ok ? '✅ Inventory updated successfully!' : '❌ Error updating record.';
            header('Location: index.php?action=facilitytest');
            exit;
        }

        $facilityTests = $this->model->getAll();
        $message = '';
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!empty($_SESSION['facility_message'])) {
            $message = $_SESSION['facility_message'];
            unset($_SESSION['facility_message']);
        }

        include __DIR__ . '/../views/facilitytest.php';
    }
}
?>