<?php
require_once '../models/connection.php';
require_once '../models/FacilityBasedTestSamplesModel.php';

// Removed JSON header and direct POST handler to avoid JSON usage

class FacilityBasedTestSamplesController {
    private $model;

    public function __construct() {
        $database = new Database();
        $this->model = new FacilityBasedTestSamplesModel($database->getConnection());
    }

    /**
     * Handle sample management requests
     */
    public function handleRequest() {
        $action = $_GET['action'] ?? 'list';

        switch ($action) {
            case 'add':
                $this->addSample();
                break;
            case 'edit':
                $this->editSample();
                break;
            case 'update':
                $this->updateSample();
                break;
            case 'delete':
                $this->deleteSample();
                break;
            case 'view':
                $this->viewSample();
                break;
            case 'stats':
                $this->getStats();
                break;
            case 'by_patient':
                $this->getSamplesByPatient();
                break;
            case 'update_status':
                $this->updateStatus();
                break;
            default:
                $this->listSamples();
                break;
        }
    }

    /**
     * Display list of samples
     */
    private function listSamples() {
        $filters = [];

        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }

        if (isset($_GET['patient_id']) && !empty($_GET['patient_id'])) {
            $filters['patient_id'] = $_GET['patient_id'];
        }

        if (isset($_GET['sample_type']) && !empty($_GET['sample_type'])) {
            $filters['sample_type'] = $_GET['sample_type'];
        }

        $result = $this->model->getAllSamples($filters);

        if ($result['success']) {
            $samples = $result['data'];
        } else {
            $samples = [];
            $error = $result['message'];
        }

        include 'facility-test-samples.php';
    }

    /**
     * Show add sample form
     */
    private function addSample() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->addSample($_POST);

            if ($result['success']) {
                $success = $result['message'];
                header("Location: ../facility-test-samples.php?success=" . urlencode($success));
                exit;
            } else {
                $error = $result['message'];
                header("Location: ../facility-test-samples.php?error=" . urlencode($error));
                exit;
            }
        }

        include 'facility-test-samples-add.php';
    }

    /**
     * Show edit sample form
     */
    private function editSample() {
        $sampleId = $_GET['id'] ?? '';

        if (empty($sampleId)) {
            header("Location: ../facility-test-samples.php?error=" . urlencode('Sample ID is required'));
            exit;
        }

        $result = $this->model->getSampleById($sampleId);

        if ($result['success']) {
            $sample = $result['data'];
        } else {
            header("Location: ../facility-test-samples.php?error=" . urlencode($result['message']));
            exit;
        }

        include 'facility-test-samples-edit.php';
    }

    /**
     * Update sample
     */
    private function updateSample() {
        $sampleId = $_POST['sample_id'] ?? '';

        if (empty($sampleId)) {
            header("Location: ../facility-test-samples.php?error=" . urlencode('Sample ID is required'));
            exit;
        }

        $result = $this->model->updateSample($sampleId, $_POST);

        if ($result['success']) {
            header("Location: ../facility-test-samples.php?success=" . urlencode($result['message']));
            exit;
        } else {
            header("Location: ../facility-test-samples-edit.php?id=" . urlencode($sampleId) . "&error=" . urlencode($result['message']));
            exit;
        }
    }

    /**
     * Delete sample
     */
    private function deleteSample() {
        $sampleId = $_GET['id'] ?? '';

        if (empty($sampleId)) {
            header("Location: ../facility-test-samples.php?error=" . urlencode('Sample ID is required'));
            exit;
        }

        if (!isset($_GET['confirm']) || $_GET['confirm'] !== 'yes') {
            header("Location: ../facility-test-samples.php?error=" . urlencode('Please confirm deletion'));
            exit;
        }

        $result = $this->model->deleteSample($sampleId);

        if ($result['success']) {
            header("Location: ../facility-test-samples.php?success=" . urlencode($result['message']));
            exit;
        } else {
            header("Location: ../facility-test-samples.php?error=" . urlencode($result['message']));
            exit;
        }
    }

    /**
     * View single sample
     */
    private function viewSample() {
        $sampleId = $_GET['id'] ?? '';

        if (empty($sampleId)) {
            header("Location: ../facility-test-samples.php?error=" . urlencode('Sample ID is required'));
            exit;
        }

        $result = $this->model->getSampleById($sampleId);

        if ($result['success']) {
            $sample = $result['data'];
        } else {
            header("Location: ../facility-test-samples.php?error=" . urlencode($result['message']));
            exit;
        }

        include 'facility-test-samples-view.php';
    }

    /**
     * Get sample statistics
     */
    private function getStats() {
        $result = $this->model->getSampleStats();

        if ($result['success']) {
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    }

    /**
     * Get samples by patient
     */
    private function getSamplesByPatient() {
        $patientId = $_GET['patient_id'] ?? '';

        if (empty($patientId)) {
            header("Location: ../facility-test-samples.php?error=" . urlencode('Patient ID is required'));
            exit;
        }

        $result = $this->model->getSamplesByPatient($patientId);

        if ($result['success']) {
            $samples = $result['data'];
        } else {
            $samples = [];
            $error = $result['message'];
        }

        include 'facility-test-samples-patient.php';
    }

    /**
     * Update sample status
     */
    private function updateStatus() {
        $sampleId = $_POST['sample_id'] ?? '';
        $status = $_POST['status'] ?? '';

        if (empty($sampleId) || empty($status)) {
            header("Location: ../facility-test-samples.php?error=" . urlencode('Sample ID and status are required'));
            exit;
        }

        $result = $this->model->updateSampleStatus($sampleId, $status);

        if ($result['success']) {
            header("Location: ../facility-test-samples.php?success=" . urlencode($result['message']));
            exit;
        } else {
            header("Location: ../facility-test-samples.php?error=" . urlencode($result['message']));
            exit;
        }
    }
}

// Initialize controller and handle request
$controller = new FacilityBasedTestSamplesController();
$controller->handleRequest();
?>
