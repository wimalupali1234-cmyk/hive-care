<?php
// Headers for CORS support - using traditional PHP instead of JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include necessary files - using absolute paths like the working registration system
require_once __DIR__ . '/models/connection.php';
require_once __DIR__ . '/models/FacilityBasedTestAppointment.php';
require_once __DIR__ . '/controllers/FacilityBasedTestAppointmentController.php';

try {
    // Initialize database
    $database = new Database();

    // Test database connection first
    try {
        $db = $database->getConnection();
    } catch (Exception $e) {
        http_response_code(500);
        echo "Database connection failed: " . $e->getMessage();
        exit;
    }

    // Initialize database and table if needed
    try {
        $database->initializeDatabase();
    } catch (Exception $e) {
        http_response_code(500);
        echo "Database initialization failed: " . $e->getMessage();
        exit;
    }

    // Initialize controller
    try {
        $controller = new FacilityBasedTestAppointmentController($db);
    } catch (Exception $e) {
        http_response_code(500);
        echo "Controller initialization failed: " . $e->getMessage();
        exit;
    }

    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo "Method not allowed. Use POST.";
        exit;
    }

    // Get form data - traditional PHP style
    $testType = trim($_POST['test-type'] ?? '');
    $profileId = trim($_POST['account-number'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $hospital = trim($_POST['hospital'] ?? '');
    $date = trim($_POST['appointment-date'] ?? '');
    $timeSlot = trim($_POST['time-slot'] ?? '');

    // Debug: Log raw POST data
    error_log("APPOINTMENT DEBUG - Raw POST data: " . json_encode($_POST));

    // Validate required fields
    if (empty($testType) || empty($profileId) || empty($district) || empty($hospital) || empty($date) || empty($timeSlot)) {
        http_response_code(400);
        echo "Error: All fields are required. Please fill in all the appointment details.";
        exit;
    }

    // Validate date format (YYYY-MM-DD)
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        http_response_code(400);
        echo "Error: Invalid date format. Please use YYYY-MM-DD format.";
        exit;
    }

    // Validate time format (should be like "09:00 AM")
    if (!preg_match('/^\d{1,2}:\d{2}\s(AM|PM)$/i', $timeSlot)) {
        http_response_code(400);
        echo "Error: Invalid time format. Please use format like '09:00 AM'.";
        exit;
    }

    // Convert time format to HH:MM:SS
    $timeSlot24 = convertTo24Hour($timeSlot);
    if (!$timeSlot24) {
        http_response_code(400);
        echo "Error: Invalid time format.";
        exit;
    }

    // Debug: Log all received data
    error_log("APPOINTMENT DEBUG - Received data: " . json_encode([
        'testType' => $testType,
        'profileId' => $profileId,
        'district' => $district,
        'hospital' => $hospital,
        'date' => $date,
        'timeSlot' => $timeSlot,
        'timeSlot24' => $timeSlot24,
        'all_POST' => $_POST
    ]));

    // Check if time slot is available for this specific hospital and date
    try {
        if (!$controller->isTimeSlotAvailable($hospital, $date, $timeSlot24)) {
            http_response_code(409);
            echo "Error: This time slot is already booked for the selected hospital and date. Please choose a different time.";
            exit;
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo "Error checking time slot availability: " . $e->getMessage();
        exit;
    }

    // Create data array for controller
    $appointmentData = [
        'test_type' => $testType,
        'profile_id' => $profileId,
        'district' => $district,
        'hospital' => $hospital,
        'date' => $date,
        'time_slot' => $timeSlot24
    ];

    // Attempt to create appointment using controller method
    try {
        $result = $controller->create($appointmentData);
        error_log("Controller create result: " . ($result ? 'true' : 'false'));

        if ($result) {
            // Appointment created successfully - redirect to success page
            header("Location: appointment-success.html?profile_id=" . urlencode($profileId) . "&test_type=" . urlencode($testType) . "&hospital=" . urlencode($hospital) . "&date=" . urlencode($date) . "&time=" . urlencode($timeSlot));
            exit;
        } else {
            // Creation failed - redirect with error
            header("Location: appointment-booking.html?error=1&message=" . urlencode("Unable to book appointment. Please try again."));
            exit;
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo "Appointment creation failed: " . $e->getMessage();
        exit;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo "Server error: " . $e->getMessage();
    exit;
}

// Helper function to convert 12-hour time to 24-hour format
function convertTo24Hour($time12) {
    $timeParts = explode(' ', $time12);
    if (count($timeParts) !== 2) return false;

    $time = $timeParts[0];
    $period = strtoupper($timeParts[1]);

    $timeComponents = explode(':', $time);
    if (count($timeComponents) !== 2) return false;

    $hours = (int)$timeComponents[0];
    $minutes = $timeComponents[1];

    if ($period === 'PM' && $hours !== 12) {
        $hours += 12;
    } elseif ($period === 'AM' && $hours === 12) {
        $hours = 0;
    }

    return sprintf('%02d:%02d:00', $hours, $minutes);
}
?>
