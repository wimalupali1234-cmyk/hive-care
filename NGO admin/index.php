<?php
session_start();

// show errors while developing
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// load config
require_once __DIR__ . '/config.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    http_response_code(500);
    die("Database connection error: \$conn is not defined or not a mysqli instance. Check config.php");
}

// --- required controllers ---
require_once __DIR__ . '/Controllers/NGOController.php';
require_once __DIR__ . '/Controllers/InventoryController.php';
require_once __DIR__ . '/Controllers/TestKitsController.php';
require_once __DIR__ . '/Controllers/PreventiveMedController.php';
require_once __DIR__ . '/Controllers/FacilityTestController.php';
require_once __DIR__ . '/Controllers/OtherMaterialController.php';
require_once __DIR__ . '/Controllers/CounsellorController.php';
require_once __DIR__ . '/Controllers/DoctorController.php';
require_once __DIR__ . '/Controllers/LabTechController.php';
require_once __DIR__ . '/Controllers/StaffManagementController.php';
require_once __DIR__ . '/Controllers/AppointmentController.php';
require_once __DIR__ . '/Controllers/PatientController.php';

// simple router
$action = $_GET['action'] ?? 'dashboard';

switch ($action) {

    case 'dashboard':
        $ctrl = new NGOController($conn);
        $ctrl->dashboard();
        break;

    // inventory landing (no DB required)
    case 'inventory':
        $ctrl = new InventoryController();
        $ctrl->index();
        break;

    // inventory sub-pages (controllers expect $conn)
    case 'testkits':
        $ctrl = new TestKitsController($conn);
        $ctrl->index();
        break;

    case 'preventivemed':
        $ctrl = new PreventiveMedController($conn);
        $ctrl->index();
        break;

    case 'facilitytest':
        $ctrl = new FacilityTestController($conn);
        $ctrl->index();
        break;

    case 'othermaterial':
        $ctrl = new OtherMaterialController($conn);
        $ctrl->index();
        break;

    // Staff Management Routes
    case 'staffmanagement':
        $ctrl = new StaffManagementController();
        $ctrl->index();
        break;
    case 'doctors':
        $ctrl = new DoctorController($conn);
        $ctrl->index();
        break;

    case 'doctor_add':
        $ctrl = new DoctorController($conn);
        $ctrl->add();
        break;

    case 'counsellors':
        $ctrl = new CounsellorController($conn);
        $ctrl->index();
        break;

    case 'counsellor':
        $ctrl = new CounsellorController($conn);
        $ctrl->step();
        break;

    case 'labtech':
        $ctrl = new LabTechController($conn);
        $ctrl->index();
        break;

    case 'labtech_step1':
        $ctrl = new LabTechController($conn);
        $ctrl->step1();
        break;

    case 'labtech_step2':
        $ctrl = new LabTechController($conn);
        $ctrl->step2();
        break;

    case 'labtech_step3':
        $ctrl = new LabTechController($conn);
        $ctrl->step3();
        break;

    case 'appointments':
        $ctrl = new AppointmentController($conn);
        $ctrl->index();
        break;

    case 'patients':
        $ctrl = new PatientController($conn);
        $ctrl->index();
        break;

    default:
        http_response_code(404);
        echo "<h2>404 - Page not found</h2>";
        break;
}
?>