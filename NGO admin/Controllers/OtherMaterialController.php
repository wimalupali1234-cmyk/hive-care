<?php

require_once __DIR__ . '/../models/OtherMaterialModel.php';

class OtherMaterialController {
    private $model;
    public function __construct(mysqli $conn) {
        $this->model = new OtherMaterialModel($conn);
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'material_name'    => $_POST['Material_Name'] ?? '',
                'stock_available'  => isset($_POST['Stock_Available']) ? (int)$_POST['Stock_Available'] : 0,
                'expiry_date'      => $_POST['Expiry_Date'] ?? null,
                'batch_number'     => $_POST['Batch_Number'] ?? '',
                'manufacturer'     => $_POST['Manufacturer'] ?? '',
                'manufacture_date' => $_POST['Manufacture_Date'] ?? null,
                'status'           => $_POST['Status'] ?? '',
                'received_date'    => $_POST['Received_Date'] ?? null,
                'supplier_name'    => $_POST['Supplier_Name'] ?? '',
            ];

            $ok = $this->model->update($data);
            $this->message = $ok ? '✅ Material stock updated successfully!' : '❌ Error updating record.';
            // optional: implement PRG (redirect) if needed
        }

        $materials = $this->model->getAll();
        include __DIR__ . '/../views/othermaterial.php';
    }
}
?>