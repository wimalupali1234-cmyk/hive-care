<?php

class PreventiveMedModel {
    private $conn;
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $rows = [];
        $res = $this->conn->query("SELECT * FROM preventive_medication ORDER BY Medication_Name ASC");
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                $rows[] = $r;
            }
            $res->free();
        }
        return $rows;
    }

    public function update(array $data): bool {
        $sql = "UPDATE preventive_medication
                SET Stock_Available = ?,
                    Pending_Orders  = ?,
                    Sent_Orders     = ?,
                    Expiry_Date     = ?,
                    batch_number    = ?,
                    manufacturer    = ?,
                    status          = ?,
                    received_date   = ?
                WHERE Medication_Name = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param(
            'iiissssss',
            $data['Stock_Available'],
            $data['Pending_Orders'],
            $data['Sent_Orders'],
            $data['Expiry_Date'],
            $data['batch_number'],
            $data['manufacturer'],
            $data['status'],
            $data['received_date'],
            $data['Medication_Name']
        );

        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>