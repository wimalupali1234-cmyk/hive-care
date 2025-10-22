<?php
class Appointment {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all appointments with optional filter and search
    public function getAll($filter = 'all', $search = '') {
        $query = "SELECT * FROM appointments WHERE 1";

        if ($filter !== 'all') {
            $filter_esc = $this->conn->real_escape_string($filter);
            $query .= " AND appointment_type='$filter_esc'";
        }

        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $query .= " AND user_name LIKE '%$search_esc%'";
        }

        $query .= " ORDER BY date DESC, time DESC";
        $result = $this->conn->query($query);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Count appointments by status
    public function countByStatus($status = null) {
        $sql = "SELECT COUNT(*) AS total FROM appointments";
        if ($status) $sql .= " WHERE status='".$this->conn->real_escape_string($status)."'";
        return (int)($this->conn->query($sql)->fetch_assoc()['total'] ?? 0);
    }

    // Update appointment status
    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE appointments SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
    }

    // Delete appointment
    public function delete($id) {
        $id = intval($id);
        $this->conn->query("DELETE FROM appointments WHERE id=$id");
    }
}
