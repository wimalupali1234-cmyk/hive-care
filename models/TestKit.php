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
            $query .= " AND status='$filter_esc'";
        }
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $query .= " AND (testkit_name LIKE '%$search_esc%' OR manufacturer LIKE '%$search_esc%' OR batch_number LIKE '%$search_esc%')";
        }
        $query .= " ORDER BY last_updated DESC";
        return $this->conn->query($query);
    }

    // Add new test kit
    public function add($data) {
        $stmt = $this->conn->prepare("INSERT INTO testkits (testkit_name, test_type, batch_number, manufacturer, manufacture_date, expiry_date, quantity_available, status, received_date, supplier_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssissss",
            $data['testkit_name'],
            $data['test_type'],
            $data['batch_number'],
            $data['manufacturer'],
            $data['manufacture_date'],
            $data['expiry_date'],
            $data['quantity_available'],
            $data['status'],
            $data['received_date'],
            $data['supplier_name']
        );
        $stmt->execute();
        $stmt->close();
    }

    // Get test kit by ID
    public function getById($id) {
        $id = intval($id);
        $stmt = $this->conn->prepare("SELECT * FROM testkits WHERE testkit_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update test kit
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE testkits SET testkit_name=?, test_type=?, batch_number=?, manufacturer=?, manufacture_date=?, expiry_date=?, quantity_available=?, status=?, received_date=?, supplier_name=? WHERE testkit_id=?");
        $stmt->bind_param("sssssissssi",
            $data['testkit_name'],
            $data['test_type'],
            $data['batch_number'],
            $data['manufacturer'],
            $data['manufacture_date'],
            $data['expiry_date'],
            $data['quantity_available'],
            $data['status'],
            $data['received_date'],
            $data['supplier_name'],
            $id
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Delete a test kit
    public function delete($id) {
        $id = intval($id);
        $stmt = $this->conn->prepare("DELETE FROM testkits WHERE testkit_id=?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Update quantity
    public function updateQuantity($id, $quantity) {
        $stmt = $this->conn->prepare("UPDATE testkits SET quantity_available=?, last_updated=NOW() WHERE testkit_id=?");
        $stmt->bind_param("ii", $quantity, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Update status based on quantity and expiry
    public function updateStatus($id) {
        $kit = $this->getById($id);
        if (!$kit) return false;

        $status = 'Available';
        if ($kit['quantity_available'] == 0) {
            $status = 'Out of Stock';
        } elseif ($kit['quantity_available'] <= 10) {
            $status = 'Low Stock';
        } elseif (strtotime($kit['expiry_date']) < time()) {
            $status = 'Expired';
        }

        $stmt = $this->conn->prepare("UPDATE testkits SET status=?, last_updated=NOW() WHERE testkit_id=?");
        $stmt->bind_param("si", $status, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Count total kits
    public function countTotal() {
        return (int)($this->conn->query("SELECT COUNT(*) AS total FROM testkits")->fetch_assoc()['total'] ?? 0);
    }

    // Get counts by status
    public function getCounts() {
        $counts = [];
        $statuses = ['Available', 'Low Stock', 'Expired', 'Out of Stock'];
        foreach ($statuses as $status) {
            $count = $this->conn->query("SELECT COUNT(*) AS total FROM testkits WHERE status='$status'")->fetch_assoc()['total'] ?? 0;
            $counts[strtolower(str_replace(' ', '_', $status))] = (int)$count;
        }
        return $counts;
    }
}
