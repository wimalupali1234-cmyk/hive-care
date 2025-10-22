<?php

class PatientModel {
    private $conn;
    
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }
    
    public function getAll(): array {
        $rows = [];
        $res = $this->conn->query("SELECT * FROM admin_patients ORDER BY patient_id DESC");
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                $rows[] = $r;
            }
            $res->free();
        }
        return $rows;
    }
    
    public function update(array $data): bool {
        $sql = "UPDATE admin_patients SET
            address=?, telephone=?, email=?
            WHERE patient_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param(
            'sssi',
            $data['address'],
            $data['telephone'],
            $data['email'],
            $data['patient_id']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
    
    public function delete(int $patient_id): bool {
        $stmt = $this->conn->prepare("DELETE FROM admin_patients WHERE patient_id = ?");
        if (!$stmt) return false;
        $stmt->bind_param('i', $patient_id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>
