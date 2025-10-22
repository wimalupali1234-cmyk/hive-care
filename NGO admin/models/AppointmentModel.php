<?php

class AppointmentModel {
    private $conn;
    
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }
    
    public function getAll(): array {
        $rows = [];
        $res = $this->conn->query("SELECT * FROM admin_appointment ORDER BY appointment_id DESC");
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                $rows[] = $r;
            }
            $res->free();
        }
        return $rows;
    }
    
    public function update(array $data): bool {
        $sql = "UPDATE admin_appointment SET
            patient_id=?, type=?, appointment_date=?, appointment_time=?, status=?
            WHERE appointment_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param(
            'sssssi',
            $data['patient_id'],
            $data['type'],
            $data['appointment_date'],
            $data['appointment_time'],
            $data['status'],
            $data['appointment_id']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
    
    public function delete(int $appointment_id): bool {
        $stmt = $this->conn->prepare("DELETE FROM admin_appointment WHERE appointment_id = ?");
        if (!$stmt) return false;
        $stmt->bind_param('i', $appointment_id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>
