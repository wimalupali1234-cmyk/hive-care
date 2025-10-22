<?php

class DashboardModel {
    private $conn;
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    private function singleValueQuery(string $sql, $default = 0) {
        $res = $this->conn->query($sql);
        if ($res === false) {
            // error_log("SQL Error: " . $this->conn->error . " — Query: $sql");
            return $default;
        }
        $row = $res->fetch_assoc();
        return $row['total'] ?? $default;
    }

    public function getPatientsServed(): int {
        return (int) $this->singleValueQuery("SELECT COUNT(*) AS total FROM admin_patients", 0);
    }

    public function getTestKitsDistributed(): int {
        $val = (int) $this->singleValueQuery("SELECT SUM(sent_orders) AS total FROM testkits", 0);
        if ($val === 0) {
            $val = (int) $this->singleValueQuery("SELECT SUM(sent_orders) AS total FROM test_kits", 0);
        }
        return $val;
    }

    public function getConsultationsMade(): int {
        return (int) $this->singleValueQuery("SELECT COUNT(*) AS total FROM admin_appointment WHERE status='Completed'", 0);
    }

    public function getPendingAppointments(): int {
        return (int) $this->singleValueQuery("SELECT COUNT(*) AS total FROM admin_appointment WHERE status='Pending'", 0);
    }

    public function getCareProvidedPercent(): string {
        $completed = $this->getConsultationsMade();
        $total = (int) $this->singleValueQuery("SELECT COUNT(*) AS total FROM admin_appointment", 0);
        if ($total > 0) {
            return round(($completed / $total) * 100, 1) . '%';
        }
        return '0%';
    }
}
?>