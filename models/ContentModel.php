<?php
class ContentModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllContent() {
        $result = $this->conn->query("SELECT * FROM content ORDER BY id DESC");
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function addContent($title, $category, $description, $file_path) {
        $stmt = $this->conn->prepare(
            "INSERT INTO content (title, category, description, file_path) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $title, $category, $description, $file_path);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteContent($id) {
        $id = intval($id);
        $this->conn->query("DELETE FROM content WHERE id=$id");
    }
}
