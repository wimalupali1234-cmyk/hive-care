<?php

class FacilityTestModel {
    private $conn;
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $rows = [];
        $res = $this->conn->query("SELECT * FROM facility_test ORDER BY Test_type ASC");
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                $rows[] = $r;
            }
            $res->free();
        }
        return $rows;
    }

    public function update(array $data): bool {
        $sql = "UPDATE facility_test
                SET Stock_Available = ?,
                    Expiry_Date = ?,
                    batch_number = ?,
                    manufacturer = ?,
                    manufacture_date = ?,
                    status = ?,
                    received_date = ?,
                    supplier_name = ?
                WHERE Test_type = ?";

        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            return false;
        }

        // bind types: i = int, s = string
        $stmt->bind_param(
            'issssssss',
            $data['Stock_Available'],
            $data['Expiry_Date'],
            $data['batch_number'],
            $data['manufacturer'],
            $data['manufacture_date'],
            $data['status'],
            $data['received_date'],
            $data['supplier_name'],
            $data['Test_type']
        );

        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>