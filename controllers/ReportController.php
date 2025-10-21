<?php
require_once __DIR__ . '/../models/ReportModel.php';

class ReportController {
    private $model;

    public function __construct($conn) {
        $this->model = new ReportModel($conn);
    }

    public function generateReport() {
        $reportType = $_POST['report_type'] ?? 'daily';
        $startDate = $_POST['start_date'] ?? date('Y-m-d');
        $endDate = $_POST['end_date'] ?? date('Y-m-d');

        $reportData = $this->model->getReportData($reportType, $startDate, $endDate);

    include __DIR__ . '/../views/system_admin/reportView.php';
    }
}
