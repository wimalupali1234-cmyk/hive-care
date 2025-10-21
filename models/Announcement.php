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
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM announcements WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function update($id, $title, $description, $event_date) {
        $stmt = $this->conn->prepare("UPDATE announcements SET title=?, description=?, event_date=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $description, $event_date, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
