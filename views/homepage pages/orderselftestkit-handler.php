<?php
// Headers for CORS support - using traditional PHP instead of JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include necessary files - using absolute paths like the working registration system
require_once __DIR__ . '/models/connection.php';
require_once __DIR__ . '/models/OrderSelfTestKit.php';
require_once __DIR__ . '/controllers/OrderSelfTestKitController.php';

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
        $controller = new OrderSelfTestKitController($db);
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
    $kitType = trim($_POST['kit-type'] ?? '');
    $profileId = trim($_POST['account-number'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $collectionPoint = trim($_POST['collection-point'] ?? '');
    $address = trim($_POST['delivery-address'] ?? '');
    $date = trim($_POST['collection-date'] ?? '');
    $time = trim($_POST['collection-time'] ?? '');

    // Debug: Log raw POST data
    error_log("ORDER DEBUG - Raw POST data: " . json_encode($_POST));

    // Validate required fields
    if (empty($kitType) || empty($profileId) || empty($district) || empty($collectionPoint) || empty($address) || empty($date) || empty($time)) {
        http_response_code(400);
        echo "Error: All fields are required. Please fill in all the order details.";
        exit;
    }

    // Validate date format (YYYY-MM-DD)
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        http_response_code(400);
        echo "Error: Invalid date format. Please use YYYY-MM-DD format.";
        exit;
    }

    // Validate time format (should be like "09:00 AM")
    if (!preg_match('/^\d{1,2}:\d{2}\s(AM|PM)$/i', $time)) {
        http_response_code(400);
        echo "Error: Invalid time format. Please use format like '09:00 AM'.";
        exit;
    }

    // Convert time format to HH:MM:SS
    $time24 = convertTo24Hour($time);
    if (!$time24) {
        http_response_code(400);
        echo "Error: Invalid time format.";
        exit;
    }

    // Debug: Log all received data
    error_log("ORDER DEBUG - Received data: " . json_encode([
        'kitType' => $kitType,
        'profileId' => $profileId,
        'district' => $district,
        'collectionPoint' => $collectionPoint,
        'address' => $address,
        'date' => $date,
        'time' => $time,
        'time24' => $time24,
        'all_POST' => $_POST
    ]));

    // Check if collection slot is available for this specific collection point and date
    try {
        if (!$controller->isCollectionSlotAvailable($collectionPoint, $date, $time24)) {
            http_response_code(409);
            echo "Error: This collection slot is already booked for the selected collection point and date. Please choose a different time.";
            exit;
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo "Error checking collection slot availability: " . $e->getMessage();
        exit;
    }

    // Create data array for controller
    $orderData = [
        'kit_type' => $kitType,
        'profile_id' => $profileId,
        'district' => $district,
        'collection_point' => $collectionPoint,
        'address' => $address,
        'date' => $date,
        'time' => $time24
    ];

    // Attempt to create order using controller method
    try {
        $result = $controller->create($orderData);
        error_log("Controller create result: " . ($result ? 'true' : 'false'));

        if ($result) {
            // Order created successfully - redirect to success page
            header("Location: orderselftestkit-success.html?profile_id=" . urlencode($profileId) . "&kit_type=" . urlencode($kitType) . "&collection_point=" . urlencode($collectionPoint) . "&date=" . urlencode($date) . "&time=" . urlencode($time));
            exit;
        } else {
            // Creation failed - redirect with error
            header("Location: orderselftestkit-booking.html?error=1&message=" . urlencode("Unable to place order. Please try again."));
            exit;
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo "Order creation failed: " . $e->getMessage();
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
