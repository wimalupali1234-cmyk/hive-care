<?php
class ReportModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getReportData($reportType, $startDate = null, $endDate = null) {
        $where = "";

        if ($reportType === 'custom' && !empty($startDate) && !empty($endDate)) {
            $where = "WHERE DATE(created_at) BETWEEN '$startDate' AND '$endDate'";
        } elseif ($reportType === 'monthly') {
            $where = "WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        } else {
            $where = "WHERE DATE(created_at) = CURDATE()";
        }

        $data = [];
        $data['tests'] = (int)($this->conn->query("SELECT COUNT(*) AS total FROM appointments $where AND type='test'")->fetch_assoc()['total'] ?? 0);
        $data['counselling'] = (int)($this->conn->query("SELECT COUNT(*) AS total FROM appointments $where AND type='counselling'")->fetch_assoc()['total'] ?? 0);
        $data['contents'] = (int)($this->conn->query("SELECT COUNT(*) AS total FROM content $where")->fetch_assoc()['total'] ?? 0);
        $data['feedback'] = (int)($this->conn->query("SELECT COUNT(*) AS total FROM feedback $where")->fetch_assoc()['total'] ?? 0);

        return $data;
    }
}
