<?php

class OtherMaterialModel {
    private $conn;
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $rows = [];
        $res = $this->conn->query("SELECT * FROM other_material ORDER BY material_name ASC");
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                $rows[] = $r;
            }
            $res->free();
        }
        return $rows;
    }

    public function update(array $data): bool {
        $sql = "UPDATE other_material SET
                    stock_available = ?,
                    expiry_date = ?,
                    batch_number = ?,
                    manufacturer = ?,
                    manufacture_date = ?,
                    status = ?,
                    received_date = ?,
                    supplier_name = ?
                WHERE material_name = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            return false;
        }

        // bind types: i = int (stock), s = string (others)
        $stock = isset($data['stock_available']) ? (int)$data['stock_available'] : 0;
        $expiry = $data['expiry_date'] ?? '';
        $batch = $data['batch_number'] ?? '';
        $manufacturer = $data['manufacturer'] ?? '';
        $manufacture_date = $data['manufacture_date'] ?? '';
        $status = $data['status'] ?? '';
        $received_date = $data['received_date'] ?? '';
        $supplier = $data['supplier_name'] ?? '';
        $material_name = $data['material_name'] ?? '';

        $stmt->bind_param(
            'issssssss',
            $stock,
            $expiry,
            $batch,
            $manufacturer,
            $manufacture_date,
            $status,
            $received_date,
            $supplier,
            $material_name
        );

        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>