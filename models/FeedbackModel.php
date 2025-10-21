<?php
class FeedbackModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all feedbacks (with optional filter)
    public function getAll($filter = 'all') {
        $query = "SELECT * FROM feedback";
        if ($filter !== 'all') {
            $query .= " WHERE type='" . mysqli_real_escape_string($this->conn, $filter) . "'";
        }
        $query .= " ORDER BY submitted_at DESC";
        return $this->conn->query($query);
    }

    // Update response
    public function respond($id, $response) {
        $response = mysqli_real_escape_string($this->conn, $response);
        $sql = "UPDATE feedback 
                SET response='$response', status='Resolved', responded_at=NOW() 
                WHERE id=$id";
        return $this->conn->query($sql);
    }

    // Delete feedback
    public function delete($id) {
        return $this->conn->query("DELETE FROM feedback WHERE id=$id");
    }
}
