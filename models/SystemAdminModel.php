<?php
class SystemAdminModel {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getHospitalCount(){
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM hospitals");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function getDoctorCount(){
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM doctors");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function getCounsellorCount(){
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM counsellors");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function getTestKitCount(){
        $result = $this->conn->query("SELECT SUM(quantity_available) AS total FROM testkits");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function getAppointmentCount(){
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM appointments");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function getUpcomingAnnouncements($limit = 5){
        $stmt = $this->conn->prepare("
            SELECT id, title, description, event_date 
            FROM announcements 
            ORDER BY event_date ASC 
            LIMIT ?
        ");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
