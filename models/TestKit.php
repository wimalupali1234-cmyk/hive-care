<?php
class TestKit {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all test kits with optional filter & search
    public function getAll($filter = 'all', $search = '') {
        $query = "SELECT * FROM testkits WHERE 1";
        if ($filter !== 'all') {
            $filter_esc = $this->conn->real_escape_string($filter);
            $query .= " AND test_type='$filter_esc'";
        }
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $query .= " AND testkit_name LIKE '%$search_esc%'";
        }
        $query .= " ORDER BY last_updated DESC";
        return $this->conn->query($query);
    }

    // Add new test kit
    public function add($testkit_name, $test_type, $quantity_available, $expiry_date) {
        $stmt = $this->conn->prepare("INSERT INTO testkits (testkit_name, test_type, quantity_available, expiry_date, last_updated) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssis", $testkit_name, $test_type, $quantity_available, $expiry_date);
        $stmt->execute();
        $stmt->close();
    }

    // Delete a test kit
    public function delete($id) {
        $id = intval($id);
        $this->conn->query("DELETE FROM testkits WHERE testkit_id=$id");
    }

    // Count total kits
    public function countTotal() {
        return (int)($this->conn->query("SELECT COUNT(*) AS total FROM testkits")->fetch_assoc()['total'] ?? 0);
    }
}
