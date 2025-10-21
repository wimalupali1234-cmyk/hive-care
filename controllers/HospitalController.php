<?php
require_once __DIR__ . '/../models/HospitalModel.php';


class HospitalController {
    private $model;

    public function __construct($conn) {
        $this->model = new HospitalModel($conn);
    }

    // ---------------------- MAIN HANDLER ----------------------
    public function handleRequest() {
        // --- Add hospital ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
            $this->model->addHospital($_POST);
            header("Location: index.php?action=manageHospitals");
            exit;
        }

        // --- Edit hospital (redirect to edit form) ---
        if (isset($_GET['edit'])) {
            $this->edit();
            return;
        }

        // --- Delete / Approve / Reject / Deactivate / Activate ---
        $actions = ['delete', 'approve', 'reject', 'deactivate', 'activate'];
        foreach ($actions as $act) {
            if (isset($_GET[$act])) {
                $id = intval($_GET[$act]);
                $statusMap = [
                    'approve' => 'Active',
                    'reject' => 'Rejected',
                    'deactivate' => 'Inactive',
                    'activate' => 'Active'
                ];
                if ($act === 'delete') {
                    $this->model->deleteHospital($id);
                } else {
                    $this->model->updateStatus($id, $statusMap[$act]);
                }
                header("Location: index.php?action=manageHospitals");
                exit;
            }
        }

        // --- Load hospital list ---
        $filter = $_GET['filter'] ?? 'all';
        $search = $_GET['search'] ?? '';
        $counts = $this->model->getCounts();
        $hospitals = $this->model->getHospitals($filter, $search);

    include __DIR__ . '/../views/system_admin/manageHospitals.php';
    }

    // ---------------------- EDIT HOSPITAL ----------------------
    public function edit() {
        if (!isset($_GET['id'])) {
            die("Error: No hospital ID provided.");
        }

        $id = intval($_GET['id']);
        $hospital = $this->model->getById($id);

        if (!$hospital) {
            die("Error: Hospital not found.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $updatedData = [
                'name' => $_POST['name'],
                'address' => $_POST['address'],
                'contact' => $_POST['contact'],
                'email' => $_POST['email'],
                'status' => $_POST['status']
            ];

            if ($this->model->update($id, $updatedData)) {
                header("Location: index.php?action=manageHospitals&updated=true");
                exit;
            } else {
                echo "Error updating hospital.";
            }
        }

        include '../views/system_admin/editHospitalView.php';
    }
}
?>
