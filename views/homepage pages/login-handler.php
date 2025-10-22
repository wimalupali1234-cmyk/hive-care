<?php
// Headers for CORS support
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include necessary files
require_once __DIR__ . '/models/connection.php';
require_once __DIR__ . '/models/PatientCreateAccount.php';
require_once __DIR__ . '/controllers/PatientCreateAccountController.php';

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
        echo json_encode([
            "success" => false,
            "message" => "Method not allowed. Use POST."
        ]);
        exit;
    }

    // Get JSON input data
    $input = file_get_contents("php://input");
    $data = json_decode($input);

    if (!$data) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Invalid JSON data received."
        ]);
        exit;
    }

    // Extract login credentials
    $profileId = trim($data->profileId ?? '');
    $password = trim($data->password ?? '');

    // Validate required fields
    if (empty($profileId) || empty($password)) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Profile ID and password are required."
        ]);
        exit;
    }

    // Validate password length
    if (strlen($password) < 8) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Password must be at least 8 characters long."
        ]);
        exit;
    }

    // Initialize patient model for authentication
    $patient = new PatientCreateAccount($db);

    // Check if profile exists and get user data
    $patient->profile_id = $profileId;
    if (!$patient->profileExists()) {
        http_response_code(401);
        echo json_encode([
            "success" => false,
            "message" => "Invalid Profile ID or password."
        ]);
        exit;
    }

    // Read the complete patient record
    if (!$patient->readOne()) {
        http_response_code(401);
        echo json_encode([
            "success" => false,
            "message" => "Unable to retrieve account information."
        ]);
        exit;
    }

    // Verify password (Note: Passwords are stored as plain text in current implementation)
    if ($patient->password !== $password) {
        http_response_code(401);
        echo json_encode([
            "success" => false,
            "message" => "Invalid Profile ID or password."
        ]);
        exit;
    }

    // Set session data for dashboard
    $userSession = [
        "profile_id" => $patient->profile_id,
        "first_name_letter" => $patient->first_name_letter,
        "last_name_letter" => $patient->last_name_letter,
        "primary_phone" => $patient->primary_phone,
        "secondary_phone" => $patient->secondary_phone,
        "district" => $patient->district,
        "account_created_datetime" => $patient->account_created_datetime,
        "login_time" => date('Y-m-d H:i:s')
    ];

    // Authentication successful
    echo json_encode([
        "success" => true,
        "message" => "Login successful.",
        "profile_id" => $patient->profile_id,
        "first_name_letter" => $patient->first_name_letter,
        "last_name_letter" => $patient->last_name_letter,
        "primary_phone" => $patient->primary_phone,
        "secondary_phone" => $patient->secondary_phone,
        "district" => $patient->district,
        "account_created_datetime" => $patient->account_created_datetime,
        "redirect" => "dashboard.html"
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage()
    ]);
}
?>
