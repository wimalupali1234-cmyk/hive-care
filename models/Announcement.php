<?php
class Announcement {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM announcements ORDER BY event_date DESC";
        return $this->conn->query($query);
    }

    public function create($title, $description, $event_date) {
        $stmt = $this->conn->prepare("INSERT INTO announcements (title, description, event_date) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $event_date);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
