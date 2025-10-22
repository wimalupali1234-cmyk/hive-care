<?php

require_once __DIR__ . '/../models/TestKitsModel.php';

class TestKitsController {
    private $model;

    public function __construct(mysqli $conn) {
        $this->model = new TestKitsModel($conn);
    }

    public function index() {
        // POST -> update then redirect (PRG)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'kit_id' => isset($_POST['kit_id']) ? (int)$_POST['kit_id'] : 0,
                'stock_available' => isset($_POST['stock_available']) ? (int)$_POST['stock_available'] : 0,
                'pending_orders' => isset($_POST['pending_orders']) ? (int)$_POST['pending_orders'] : 0,
                'sent_orders' => isset($_POST['sent_orders']) ? (int)$_POST['sent_orders'] : 0,
                'expiry_date' => $_POST['expiry_date'] ?? '',
                'batch_number' => $_POST['batch_number'] ?? '',
                'manufacturer' => $_POST['manufacturer'] ?? '',
                'manufacture_date' => $_POST['manufacture_date'] ?? '',
                'status' => $_POST['status'] ?? '',
                'received_date' => $_POST['received_date'] ?? '',
                'supplier_name' => $_POST['supplier_name'] ?? '',
            ];

            $ok = $this->model->update($data);

            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['testkits_message'] = $ok ? '✅ Test kit inventory updated successfully!' : '❌ Error updating record.';
            header('Location: index.php?action=testkits');
            exit;
        }

        // GET -> show page
        $testkits = $this->model->getAll();

        // flash message
        $message = '';
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!empty($_SESSION['testkits_message'])) {
            $message = $_SESSION['testkits_message'];
            unset($_SESSION['testkits_message']);
        }

        include __DIR__ . '/../views/testkits.php';
    }
}
?>