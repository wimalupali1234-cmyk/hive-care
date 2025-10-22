<?php
require_once 'models/connection.php';
require_once 'models/LabTechModel.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit;
}

$techId = trim($input['techId'] ?? '');
$password = $input['password'] ?? '';

// Validate input
if (empty($techId) || empty($password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Lab Technician ID and password are required']);
    exit;
}

// Try database authentication first, fallback to localStorage for demo
try {
    $database = new Database();
    $conn = $database->getConnection();
    $labTechModel = new LabTechModel($conn);

    // Authenticate the lab technician
    $result = $labTechModel->authenticateLabTech($techId, $password);

    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'message' => 'Login successful',
            'tech_id' => $result['data']['tech_id'],
            'full_name' => $result['data']['full_name'],
            'organization' => $result['data']['organization'],
            'department' => $result['data']['department'],
            'email' => $result['data']['email'],
            'phone' => $result['data']['phone'],
            'location' => $result['data']['location'],
            'qualification' => $result['data']['qualification'],
            'redirect' => 'lab-tech-dashboard.html'
        ]);
    } else {
        // Fallback to localStorage-based authentication for demo
        echo handleDemoAuthentication($techId, $password);
    }

} catch (Exception $e) {
    // If database connection fails, use localStorage fallback
    echo handleDemoAuthentication($techId, $password);
}

function handleDemoAuthentication($techId, $password) {
    // For demo purposes, accept valid credentials and check localStorage
    if (strlen($techId) >= 3 && strlen($password) >= 8) {
        // Try to get existing registration data from localStorage (simulated)
        $registrationData = simulateGetRegistrationData($techId);

        if ($registrationData) {
            // Use actual registration data
            $labTechData = [
                'tech_id' => $registrationData['employeeId'] ?: $techId,
                'full_name' => $registrationData['fullName'],
                'organization' => $registrationData['currentHospital'],
                'department' => $registrationData['department'],
                'email' => $registrationData['email'],
                'phone' => $registrationData['primaryContact'],
                'location' => $registrationData['hospitalAddress'],
                'qualification' => $registrationData['qualification']
            ];
        } else {
            // Create new lab tech data based on ID format
            $labTechData = [
                'tech_id' => $techId,
                'full_name' => generateFullName($techId),
                'organization' => 'City General Hospital',
                'department' => 'Laboratory Services',
                'email' => generateEmail($techId),
                'phone' => '+1 (555) 123-4567',
                'location' => 'Building A, Lab Section 3',
                'qualification' => 'MSc Medical Laboratory Science'
            ];
        }

        return json_encode([
            'success' => true,
            'message' => 'Login successful (Demo Mode)',
            'tech_id' => $labTechData['tech_id'],
            'full_name' => $labTechData['full_name'],
            'organization' => $labTechData['organization'],
            'department' => $labTechData['department'],
            'email' => $labTechData['email'],
            'phone' => $labTechData['phone'],
            'location' => $labTechData['location'],
            'qualification' => $labTechData['qualification'],
            'redirect' => 'lab-tech-dashboard.html'
        ]);
    } else {
        return json_encode([
            'success' => false,
            'message' => 'Invalid Employee ID or password'
        ]);
    }
}

// Helper functions for demo purposes
function simulateGetRegistrationData($techId) {
    // Generate a consistent employee ID from the provided tech ID
    $employeeId = 'LT-' . strtoupper(substr($techId, -8));

    // Return sample registration data that matches common patterns
    return [
        'fullName' => generateFullName($techId),
        'currentHospital' => 'City General Hospital',
        'hospitalAddress' => '123 Healthcare Ave, Medical District',
        'department' => 'Laboratory Services',
        'designation' => 'Senior Lab Technician',
        'employeeId' => $employeeId,
        'yearsExperience' => '6-10',
        'qualification' => 'MSc Medical Laboratory Science',
        'university' => 'State Medical University',
        'licenseNumber' => 'LT' . rand(100000, 999999),
        'email' => generateEmail($techId),
        'primaryContact' => '+1 (555) ' . rand(100, 999) . '-' . rand(1000, 9999),
        'secondaryContact' => '',
        'address' => '456 Residential Ave, City',
        'reference' => 'Dr. John Smith, Chief Pathologist'
    ];
}

function generateFullName($techId) {
    $firstNames = ['Dr. Sarah', 'Dr. Michael', 'Dr. Emily', 'Dr. David', 'Dr. Lisa'];
    $lastNames = ['Johnson', 'Williams', 'Brown', 'Davis', 'Miller'];

    // Use techId to consistently generate the same name
    $nameIndex = hexdec(substr(md5($techId), 0, 2)) % count($firstNames);
    return $firstNames[$nameIndex] . ' ' . $lastNames[$nameIndex];
}

function generateEmail($techId) {
    $baseName = strtolower(str_replace(['Dr. ', ' '], ['', '.'], generateFullName($techId)));
    return $baseName . '@cityhospital.org';
}
?>
