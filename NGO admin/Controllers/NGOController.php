<?php

require_once __DIR__ . '/../models/DashboardModel.php';

class NGOController {
    private $model;
    public function __construct(mysqli $conn) {
        $this->model = new DashboardModel($conn);
    }

    public function dashboard() {
        // fetch data
        $patientsServed = $this->model->getPatientsServed();
        $testKitsDistributed = $this->model->getTestKitsDistributed();
        $consultationsMade = $this->model->getConsultationsMade();
        $pendingAppointments = $this->model->getPendingAppointments();
        $careProvided = $this->model->getCareProvidedPercent();

        // load view (keeps original view path/name)
        include __DIR__ . '/../views/dashboard.php';
    }
}
?>