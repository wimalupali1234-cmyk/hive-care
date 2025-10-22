<?php
class TestKitsModel {
    private $conn;
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $rows = [];
        $res = $this->conn->query("SELECT * FROM test_kits");
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                $rows[] = $r;
            }
            $res->free();
        }
        return $rows;
    }

    public function update(array $data): bool {
        $sql = "UPDATE test_kits
                SET stock_available = ?,
                    pending_orders = ?,
                    sent_orders = ?,
                    expiry_date = ?,
                    batch_number = ?,
                    manufacturer = ?,
                    manufacture_date = ?,
                    status = ?,
                    received_date = ?,
                    supplier_name = ?
                WHERE kit_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            return false;
        }

        // Bind types: i = int, s = string
        $stmt->bind_param(
            'iiisssssssi',
            $data['stock_available'],
            $data['pending_orders'],
            $data['sent_orders'],
            $data['expiry_date'],
            $data['batch_number'],
            $data['manufacturer'],
            $data['manufacture_date'],
            $data['status'],
            $data['received_date'],
            $data['supplier_name'],
            $data['kit_id']
        );

        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>