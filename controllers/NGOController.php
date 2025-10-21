<?php
require_once __DIR__ . '/../models/NGOModel.php';
class NGOController {
    private $model;

    public function __construct($conn){
        $this->model = new NGOModel($conn);
    }

    // --- Handle listing, adding, deleting, status updates ---
    public function handleRequest(){
        // Add new NGO
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['add'])){
            $this->model->addNGO($_POST);
            header("Location: index.php?action=manageNGOs");
            exit;
        }

        // Status actions: delete, approve, reject, deactivate, activate
        $actions = ['delete','approve','reject','deactivate','activate'];
        foreach($actions as $act){
            if(isset($_GET[$act])){
                $id = intval($_GET[$act]);
                $statusMap = [
                    'approve' => 'Active',
                    'reject' => 'Rejected',
                    'deactivate' => 'Inactive',
                    'activate' => 'Active'
                ];

                if($act == 'delete'){
                    $this->model->deleteNGO($id);
                } else {
                    $this->model->updateStatus($id, $statusMap[$act]);
                }

                header("Location: index.php?action=manageNGOs");
                exit;
            }
        }

        // Filters & search
        $filter = $_GET['filter'] ?? 'all';
        $search = $_GET['search'] ?? '';
        $counts = $this->model->getCounts();
        $ngos = $this->model->getNGOs($filter, $search);

    include __DIR__ . '/../views/system_admin/manageNGOs.php';
    }

    // --- Edit a single NGO ---
    public function edit() {
        if (!isset($_GET['id'])) {
            die("Error: No NGO ID provided.");
        }

        $id = intval($_GET['id']);
        $ngo = $this->model->getById($id);

        if (!$ngo) {
            die("Error: NGO not found.");
        }

        // Update NGO
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'contact' => $_POST['contact'],
                'status' => $_POST['status']
            ];

            if ($this->model->update($id, $data)) {
                header("Location: index.php?action=manageNGOs&updated=true");
                exit;
            } else {
                echo "Error updating NGO.";
            }
        }

        include '../views/system_admin/editNGOView.php';
    }
}
?>
