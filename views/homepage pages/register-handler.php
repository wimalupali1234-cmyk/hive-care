<?php
// Headers for CORS support
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include necessary files
require_once __DIR__ . '/../../models/connection.php';
require_once __DIR__ . '/../../models/PatientCreateAccount.php';
require_once __DIR__ . '/../../controllers/PatientCreateAccountController.php';

try {
    // Initialize database
    $database = new Database();
    $db = $database->getConnection();

    // Initialize database and table if needed
    if (!$database->initializeDatabase()) {
        // Error already handled by initializeDatabase method
        exit;
    }

    // Initialize controller
    $controller = new PatientCreateAccountController($db);

    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed. Use POST."]);
        exit;
    }

    // Get form data - traditional PHP style
    $firstInitial = trim($_POST['first-initial'] ?? '');
    $lastInitial = trim($_POST['last-initial'] ?? '');
    $phone1 = trim($_POST['phone1'] ?? '');
    $phone2 = trim($_POST['phone2'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate required fields
    if (empty($firstInitial) || empty($lastInitial) || empty($phone1) || empty($district) || empty($password)) {
        http_response_code(400);
        echo json_encode([
            "message" => "Missing required fields.",
            "errors" => [
                "first-initial" => empty($firstInitial) ? "First initial is required" : null,
                "last-initial" => empty($lastInitial) ? "Last initial is required" : null,
                "phone1" => empty($phone1) ? "Primary phone is required" : null,
                "district" => empty($district) ? "District is required" : null,
                "password" => empty($password) ? "Password is required" : null
            ]
        ]);
        exit;
    }

    // Validate field formats
    if (strlen($firstInitial) > 1) {
        http_response_code(400);
        echo json_encode(["message" => "First initial must be exactly one character."]);
        exit;
    }

    if (strlen($lastInitial) > 1) {
        http_response_code(400);
        echo json_encode(["message" => "Last initial must be exactly one character."]);
        exit;
    }

    // Validate phone number format (Sri Lankan format)
    if (!preg_match('/^07[0-9]{8}$/', $phone1)) {
        http_response_code(400);
        echo json_encode(["message" => "Primary phone must be in format 07xxxxxxxx (10 digits starting with 07)."]);
        exit;
    }

    if (!empty($phone2) && !preg_match('/^07[0-9]{8}$/', $phone2)) {
        http_response_code(400);
        echo json_encode(["message" => "Secondary phone must be in format 07xxxxxxxx (10 digits starting with 07)."]);
        exit;
    }

    // Generate Profile ID using same format as frontend: first initial + last initial + district + date + time
    $dateStr = date('Ymd'); // YYYYMMDD format
    $timeStr = date('His'); // HHMMSS format

    $profileId = strtoupper($firstInitial . $lastInitial . $district . $dateStr . $timeStr);

    // Create data array for controller
    $patientData = [
        'profile_id' => $profileId,
        'first_name_letter' => $firstInitial,
        'last_name_letter' => $lastInitial,
        'primary_phone' => $phone1,
        'secondary_phone' => !empty($phone2) ? $phone2 : null,
        'district' => $district,
        'password' => $password
    ];

    // Attempt to create patient using controller method
    if ($controller->create($patientData)) {
        // Patient created successfully
        echo json_encode([
            "success" => true,
            "message" => "Patient account created successfully.",
            "profile_id" => $profileId,
            "redirect" => "register-review.html"
        ]);
    } else {
        // Creation failed - error already sent by model/controller
        // Send a generic error response if none was sent
        if (!headers_sent()) {
            http_response_code(503);
            echo json_encode([
                "success" => false,
                "message" => "Unable to create patient account. Please try again."
            ]);
        }
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage()
    ]);
}
?>
