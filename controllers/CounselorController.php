<?php
require_once __DIR__ . '/../models/CounsellorModel.php';

class CounsellorController {
    private $model;
    private $counsellorId;

    public function __construct($conn, $counsellorId) {
        $this->model = new CounsellorModel($conn);
        $this->counsellorId = (int)$counsellorId;
    }

    // Main entry: decides action based on query param
    public function handleRequest() {
        $action = $_GET['action'] ?? 'listSessions';

        switch ($action) {
            case 'listSessions':
                $this->listSessions();
                break;

            case 'editAvailability':
                $this->editAvailability();
                break;

            case 'blockDates':
                $this->blockDates();
                break;

            case 'updateStatus':
                $this->updateStatus();
                break;

            case 'saveNotes':
                $this->saveNotes();
                break;

            case 'viewUserHistory':
                $this->viewUserHistory();
                break;

            default:
                echo "<h2>404 - Page not found</h2>";
                break;
        }
    }

    // 1. Show upcoming sessions
    public function listSessions() {
        $sessions = $this->model->getUpcomingSessions($this->counsellorId);
        include __DIR__ . '/../views/counsellor/listSessions.php';
    }

    // 2. Edit availability
    public function editAvailability() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // expect availability data from form
            $availabilityData = $_POST['availability'];  // adjust accordingly
            $this->model->updateAvailability($this->counsellorId, $availabilityData);
            header("Location: index.php?action=editAvailability&updated=true");
            exit;
        }
        include __DIR__ . '/../views/counsellor/editAvailability.php';
    }

    // 3. Block off unavailable dates
    public function blockDates() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dates = $_POST['dates'];  // array of dates
            $this->model->blockDates($this->counsellorId, $dates);
            header("Location: index.php?action=blockDates&blocked=true");
            exit;
        }
        include __DIR__ . '/../views/counsellor/blockDates.php';
    }

    // 4. Update session status (Completed/Missed/Rescheduled)
    public function updateStatus() {
        if (!isset($_GET['sessionId']) || !isset($_GET['status'])) {
            die("Invalid request.");
        }
        $sessionId = intval($_GET['sessionId']);
        $status = $_GET['status']; // should validate this value
        $this->model->updateSessionStatus($sessionId, $status);
        header("Location: index.php?action=listSessions");
        exit;
    }

    // 5. Save session notes
    public function saveNotes() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sessionId = intval($_POST['sessionId']);
            $notes = $_POST['notes'];
            $this->model->saveSessionNotes($sessionId, $notes);
            header("Location: index.php?action=viewNotes&sessionId={$sessionId}&saved=true");
            exit;
        }
        if (!isset($_GET['sessionId'])) {
            die("Missing session ID.");
        }
        $sessionId = intval($_GET['sessionId']);
        // Optionally fetch session details to pre‐fill form
        include __DIR__ . '/../views/counsellor/editNotes.php';
    }

    // 6. View previous sessions for a user (anonymised)
    public function viewUserHistory() {
        if (!isset($_GET['userCode'])) {
            die("User code missing.");
        }
        $userCode = $_GET['userCode'];
        $userInfo = $this->model->getUserAnonymised($userCode);
        $history = $this->model->getPreviousSessionsForUser($userCode);
        include __DIR__ . '/../views/counsellor/userHistory.php';
    }
}
?>
