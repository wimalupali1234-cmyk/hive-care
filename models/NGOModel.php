<?php
class NGOModel {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    // --- Add a new NGO ---
    public function addNGO($data){
        $stmt = $this->conn->prepare(
            "INSERT INTO ngos (name, address, contact_number, email, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param(
            "sssss",
            $data['name'],
            $data['address'],
            $data['contact'],
            $data['email'],
            $data['status']
        );
        return $stmt->execute();
    }

    // --- Delete an NGO ---
    public function deleteNGO($id){
        $stmt = $this->conn->prepare("DELETE FROM ngos WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // --- Update NGO status ---
    public function updateStatus($id, $status){
        $stmt = $this->conn->prepare("UPDATE ngos SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    // --- Get counts by status ---
    public function getCounts(){
        $counts['approved'] = $this->conn->query("SELECT COUNT(*) AS total FROM ngos WHERE status='Active'")->fetch_assoc()['total'] ?? 0;
        $counts['pending']  = $this->conn->query("SELECT COUNT(*) AS total FROM ngos WHERE status='Pending'")->fetch_assoc()['total'] ?? 0;
        $counts['inactive'] = $this->conn->query("SELECT COUNT(*) AS total FROM ngos WHERE status='Inactive'")->fetch_assoc()['total'] ?? 0;
        return $counts;
    }

    // --- Get list of NGOs ---
    public function getNGOs($filter='all', $search=''){
        $query = "SELECT * FROM ngos WHERE 1";
        if($filter !== 'all'){
            $filter_esc = $this->conn->real_escape_string($filter);
            $query .= " AND status='$filter_esc'";
        }
        if(!empty($search)){
            $search_esc = $this->conn->real_escape_string($search);
            $query .= " AND name LIKE '%$search_esc%'";
        }
        $query .= " ORDER BY created_at DESC";

        $result = $this->conn->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // --- Get single NGO by ID ---
    public function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM ngos WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // --- Update NGO details ---
    public function update($id, $data){
        $stmt = $this->conn->prepare("
            UPDATE ngos
            SET name=?, email=?, address=?, contact_number=?, status=?
            WHERE id=?
        ");
        $stmt->bind_param(
            "sssssi",
            $data['name'],
            $data['email'],
            $data['address'],
            $data['contact_number'],
            $data['status'],
            $id
        );
        return $stmt->execute();
    }
}
?>
