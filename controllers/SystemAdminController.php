<?php
require_once __DIR__ . '/../models/SystemAdminModel.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/TestKit.php';


class SystemAdminController {
    private $conn;
    private $model;

    public function __construct($conn){
        $this->conn = $conn;
        $this->model = new SystemAdminModel($conn);
    }

    // ---------------- Dashboard ----------------
    public function dashboard(){
        $data = [
            'total_hospitals' => $this->model->getHospitalCount(),
            'total_doctors' => $this->model->getDoctorCount(),
            'total_counsellors' => $this->model->getCounsellorCount(),
            'total_testkits' => $this->model->getTestKitCount(),
            'total_appointments' => $this->model->getAppointmentCount(),
            // view expects $dashAnnouncements
            'dashAnnouncements' => $this->model->getUpcomingAnnouncements()
        ];

        // export array keys as variables for the view (e.g. $total_hospitals)
        extract($data);

        include __DIR__ . '/../views/system_admin/dashboard.php';
    }

    // ---------------- Manage Appointments ----------------
    public function manageAppointments() {
        $appointmentModel = new Appointment($this->conn);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
            $appointmentModel->updateStatus($_POST['appointment_id'], $_POST['status']);
            header("Location: index.php?action=manageAppointments");
            exit;
        }

        if (isset($_GET['delete'])) {
            $appointmentModel->delete($_GET['delete']);
            header("Location: index.php?action=manageAppointments");
            exit;
        }

        $filter = $_GET['filter'] ?? 'all';
        $search = $_GET['search'] ?? '';

        $appointments = $appointmentModel->getAll($filter, $search);
        $total_appointments = $appointmentModel->countByStatus();
        $pending = $appointmentModel->countByStatus('Pending');
        $completed = $appointmentModel->countByStatus('Completed');

        include __DIR__ . '/../views/system_admin/manageAppointments.php';
    }

    // ---------------- Manage Test Kits ----------------
    public function manageTestKits() {
        $testKitModel = new TestKit($this->conn);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
<<<<<<< HEAD
            $testKitModel->add($_POST['name'], $_POST['type'], $_POST['quantity'], $_POST['expiry_date']);
=======
            $data = [
                'testkit_name' => $_POST['testkit_name'],
                'test_type' => $_POST['test_type'],
                'batch_number' => $_POST['batch_number'],
                'manufacturer' => $_POST['manufacturer'] ?? null,
                'manufacture_date' => $_POST['manufacture_date'] ?? null,
                'expiry_date' => $_POST['expiry_date'],
                'quantity_available' => $_POST['quantity_available'],
                'status' => $_POST['status'],
                'received_date' => $_POST['received_date'] ?? null,
                'supplier_name' => $_POST['supplier_name'] ?? null
            ];
            $testKitModel->add($data);
>>>>>>> origin/main
            header("Location: index.php?action=manageTestKits");
            exit;
        }

        if (isset($_GET['delete'])) {
            $testKitModel->delete($_GET['delete']);
            header("Location: index.php?action=manageTestKits");
            exit;
        }

        $filter = $_GET['filter'] ?? 'all';
        $search = $_GET['search'] ?? '';

        $kits = $testKitModel->getAll($filter, $search);
        $total_kits = $testKitModel->countTotal();
<<<<<<< HEAD
=======
        $counts = $testKitModel->getCounts();
>>>>>>> origin/main

        include __DIR__ . '/../views/system_admin/manageTestKits.php';
    }

<<<<<<< HEAD
=======
    // ---------------- Edit Test Kit ----------------
    public function editTestKit() {
        if (!isset($_GET['id'])) {
            die("Error: No test kit ID provided.");
        }

        $id = intval($_GET['id']);
        $testKitModel = new TestKit($this->conn);
        $kit = $testKitModel->getById($id);

        if (!$kit) {
            die("Error: Test kit not found.");
        }

        // Update test kit
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $data = [
                'testkit_name' => $_POST['testkit_name'],
                'test_type' => $_POST['test_type'],
                'batch_number' => $_POST['batch_number'],
                'manufacturer' => $_POST['manufacturer'] ?? null,
                'manufacture_date' => $_POST['manufacture_date'] ?? null,
                'expiry_date' => $_POST['expiry_date'],
                'quantity_available' => $_POST['quantity_available'],
                'status' => $_POST['status'],
                'received_date' => $_POST['received_date'] ?? null,
                'supplier_name' => $_POST['supplier_name'] ?? null
            ];

            if ($testKitModel->update($id, $data)) {
                header("Location: index.php?action=manageTestKits&updated=true");
                exit;
            } else {
                echo "Error updating test kit.";
            }
        }

        include __DIR__ . '/../views/system_admin/editTestKitView.php';
    }

>>>>>>> origin/main
    // ---------------- Manage Content ----------------
    public function manageContent() {
        if (isset($_POST['upload'])) {
            $title = trim($_POST['title']);
            $category = trim($_POST['category']);
            $description = trim($_POST['description']);
            $file_path = '';

            if (!empty($_FILES['file']['name'])) {
                $target_dir = "uploads/";
                if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
                $file_name = time() . "_" . basename($_FILES["file"]["name"]);
                $target_file = $target_dir . $file_name;
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $file_path = $target_file;
                }
            }

            $stmt = $this->conn->prepare(
                "INSERT INTO content (title, category, description, file_path) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("ssss", $title, $category, $description, $file_path);
            $stmt->execute();
            header("Location: index.php?action=manageContent");
            exit;
        }

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $this->conn->query("DELETE FROM content WHERE id=$id");
            header("Location: index.php?action=manageContent");
            exit;
        }

        $result = $this->conn->query("SELECT * FROM content ORDER BY id DESC");
        include __DIR__ . '/../views/system_admin/manageContent.php';
    }
}
?>
