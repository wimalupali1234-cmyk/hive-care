<?php
class HospitalModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // ------------------- ADD HOSPITAL -------------------
    public function addHospital($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO hospitals (NAME, address, contact_number, email, status, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("sssss",
            $data['name'],
            $data['address'],
            $data['contact'],
            $data['email'],
            $data['status']
        );
        return $stmt->execute();
    }

    // ------------------- DELETE HOSPITAL -------------------
    public function deleteHospital($id) {
        $stmt = $this->conn->prepare("DELETE FROM hospitals WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ------------------- UPDATE STATUS -------------------
    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE hospitals SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    // ------------------- GET COUNTS -------------------
    public function getCounts() {
        $counts = [];
        $counts['approved'] = $this->conn->query("SELECT COUNT(*) AS total FROM hospitals WHERE status = 'Active'")
            ->fetch_assoc()['total'] ?? 0;
        $counts['pending']  = $this->conn->query("SELECT COUNT(*) AS total FROM hospitals WHERE status = 'Pending'")
            ->fetch_assoc()['total'] ?? 0;
        $counts['inactive'] = $this->conn->query("SELECT COUNT(*) AS total FROM hospitals WHERE status = 'Inactive'")
            ->fetch_assoc()['total'] ?? 0;
        return $counts;
    }

    // ------------------- GET ALL HOSPITALS -------------------
    public function getHospitals($filter = 'all', $search = '') {
        $query = "SELECT * FROM hospitals WHERE 1";

        if ($filter !== 'all') {
            $filter_esc = $this->conn->real_escape_string($filter);
            $query .= " AND status = '$filter_esc'";
        }

        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $query .= " AND NAME LIKE '%$search_esc%'";
        }

        $query .= " ORDER BY created_at DESC";

        $result = $this->conn->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // ------------------- GET BY ID (FOR EDIT) -------------------
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM hospitals WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ------------------- UPDATE HOSPITAL (EDIT) -------------------
    public function update($id, $name, $address, $contact, $email, $status) {
        $stmt = $this->conn->prepare("
            UPDATE hospitals
            SET NAME = ?, address = ?, contact_number = ?, email = ?, status = ?
            WHERE id = ?
        ");
        $stmt->bind_param("sssssi", $name, $address, $contact, $email, $status, $id);
        return $stmt->execute();
    }
}
?>
