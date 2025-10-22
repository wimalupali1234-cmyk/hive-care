<?php
session_start();

// Show all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Debug marker
echo "<!-- PHP_RUNNING_MARKER: index.php loaded -->\n";

require_once __DIR__ . '/config.php';

// ------------------ Controllers ------------------
require_once __DIR__ . '/controllers/SystemAdminController.php';
<<<<<<< HEAD
require_once __DIR__ . '/controllers/CounselorController.php';
=======
>>>>>>> origin/main
require_once __DIR__ . '/controllers/HospitalController.php';
require_once __DIR__ . '/controllers/NGOController.php';
require_once __DIR__ . '/controllers/ReportController.php';
require_once __DIR__ . '/controllers/AnnouncementController.php';
require_once __DIR__ . '/controllers/FeedbackController.php';
require_once __DIR__ . '/controllers/hospital_admin/HospitalAdminController.php'; // Hospital Admin controller

$action = $_GET['action'] ?? 'dashboard';

<<<<<<< HEAD
$_SESSION['counsellor_id'] = 1; // For testing purposes only


=======
>>>>>>> origin/main
// ------------------ ROUTING ------------------
switch($action) {

    // ---------------- System Admin ----------------
    case 'dashboard':
    case 'manageAppointments':
    case 'manageTestKits':
<<<<<<< HEAD
=======
    case 'editTestKit':
>>>>>>> origin/main
    case 'manageContent':
    case 'manageHospitals':
    case 'editHospital':
    case 'manageNGOs':
    case 'editNGO':
    case 'generateReport':
    case 'manageAnnouncements':
<<<<<<< HEAD
    case 'manageFeedback':
        // Instantiate System/Hospital/NGO controllers based on action
        if (in_array($action, ['dashboard', 'manageAppointments', 'manageTestKits', 'manageContent'])) {
=======
    case 'editAnnouncement':
    case 'manageFeedback':
        // Instantiate System/Hospital/NGO controllers based on action
        if (in_array($action, ['dashboard', 'manageAppointments', 'manageTestKits', 'editTestKit', 'manageContent'])) {
>>>>>>> origin/main
            $controller = new SystemAdminController($conn);
            $controller->{$action}();
        } elseif (in_array($action, ['manageHospitals', 'editHospital'])) {
            $controller = new HospitalController($conn);
            $action === 'editHospital' ? $controller->edit() : $controller->handleRequest();
        } elseif (in_array($action, ['manageNGOs', 'editNGO'])) {
            $controller = new NGOController($conn);
            $action === 'editNGO' ? $controller->edit() : $controller->handleRequest();
        } elseif ($action === 'generateReport') {
            $controller = new ReportController($conn);
            $controller->generateReport();
        } elseif ($action === 'manageAnnouncements') {
            $controller = new AnnouncementController($conn);
            $controller->handleRequest();
<<<<<<< HEAD
=======
        } elseif ($action === 'editAnnouncement') {
            $controller = new AnnouncementController($conn);
            $controller->edit();
>>>>>>> origin/main
        } elseif ($action === 'manageFeedback') {
            $controller = new FeedbackController($conn);
            $controller->handleRequest();
        }
        break;

    // ---------------- Hospital Admin ----------------
    // ---------------- Hospital Admin ----------------
case 'hospitalAdminDashboard':
case 'hospitalAdminStaff':
case 'hospitalAdminDoctors':
case 'hospitalAdminCounsellors':
case 'hospitalAdminLabTech':
case 'hospitalAdminPatients':
case 'hospitalAdminInventory':
case 'hospitalAdminAppointments':
    // Pass $conn to the controller
    $hospitalController = new HospitalAdminController($conn);
    switch($action) {
        case 'hospitalAdminDashboard': $hospitalController->dashboard(); break;
        case 'hospitalAdminStaff': $hospitalController->staffManagement(); break;
        case 'hospitalAdminDoctors': $hospitalController->doctors(); break;
        case 'hospitalAdminCounsellors': $hospitalController->counsellors(); break;
        case 'hospitalAdminLabTech': $hospitalController->labTech(); break;
        case 'hospitalAdminPatients': $hospitalController->patients(); break;
        case 'hospitalAdminInventory': $hospitalController->inventory(); break;
        case 'hospitalAdminTestKits': $hospitalController->testkits(); break;
        case 'hospitalAdminPreventiveMed': $hospitalController->preventivemed(); break;
        case 'hospitalAdminFacilityTest': $hospitalController->facilitytest(); break;
        case 'hospitalAdminOtherMaterial': $hospitalController->othermaterial(); break;

        case 'hospitalAdminAppointments': $hospitalController->appointments(); break;
    }
    break;

<<<<<<< HEAD
    //Counsellor Actions

case 'counsellorListSessions':
    $controller = new CounsellorController($conn, $_SESSION['counsellor_id']);
    $controller->listSessions();
    break;

case 'counsellorEditAvailability':
    $controller = new CounsellorController($conn, $_SESSION['counsellor_id']);
    $controller->editAvailability();
    break;

case 'counsellorBlockDates':
    $controller = new CounsellorController($conn, $_SESSION['counsellor_id']);
    $controller->blockDates();
    break;

case 'counsellorUpdateStatus':
    $controller = new CounsellorController($conn, $_SESSION['counsellor_id']);
    $controller->updateStatus();
    break;

case 'counsellorSaveNotes':
    $controller = new CounsellorController($conn, $_SESSION['counsellor_id']);
    $controller->saveNotes();
    break;

case 'counsellorUserHistory':
    $controller = new CounsellorController($conn, $_SESSION['counsellor_id']);
    $controller->viewUserHistory();
    break;


=======
>>>>>>> origin/main
    default:
        echo "<h2>404 - Page not found</h2>";
        break;
}
