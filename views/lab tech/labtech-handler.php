<?php
require_once 'models/connection.php';
require_once 'models/LabTechModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get form data
$data = [
    'fullName' => $_POST['fullName'] ?? '',
    'gender' => $_POST['gender'] ?? '',
    'dob' => $_POST['dob'] ?? '',
    'nic' => $_POST['nic'] ?? '',
    'primaryContact' => $_POST['primaryContact'] ?? '',
    'secondaryContact' => $_POST['secondaryContact'] ?? '',
    'email' => $_POST['email'] ?? '',
    'address' => $_POST['address'] ?? '',
    'currentHospital' => $_POST['currentHospital'] ?? '',
    'hospitalAddress' => $_POST['hospitalAddress'] ?? '',
    'department' => $_POST['department'] ?? '',
    'designation' => $_POST['designation'] ?? '',
    'employeeId' => $_POST['employeeId'] ?? '',
    'yearsExperience' => $_POST['yearsExperience'] ?? '',
    'reference' => $_POST['reference'] ?? '',
    'qualification' => $_POST['qualification'] ?? '',
    'university' => $_POST['university'] ?? '',
    'licenseNumber' => $_POST['licenseNumber'] ?? '',
    'licenseExpiry' => $_POST['licenseExpiry'] ?? '',

    'password' => $_POST['password'] ?? ''
];

// Handle file uploads
$uploadDir = 'uploads/labtech_documents/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$data['degreeCertificate'] = handleFileUpload('degreeCertificate', $uploadDir);
$data['professionalLicense'] = handleFileUpload('professionalLicense', $uploadDir);
$data['employmentLetter'] = handleFileUpload('employmentLetter', $uploadDir);

// Validate required fields
$requiredFields = ['fullName', 'gender', 'dob', 'nic', 'primaryContact', 'email',
                  'currentHospital', 'department', 'designation', 'employeeId',
                  'qualification', 'password'];

foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        echo json_encode([
            'success' => false,
            'message' => ucfirst(str_replace(['Contact', 'Id'], ['Contact', 'ID'], $field)) . ' is required'
        ]);
        exit;
    }
}

// Validate email
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address'
    ]);
    exit;
}

// Validate NIC (Sri Lankan format)
if (!preg_match('/^\d{9}[vVxX]|\d{13}$/', $data['nic'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid NIC number'
    ]);
    exit;
}

// Initialize database connection
try {
    $database = new Database();
    $conn = $database->getConnection();

    $labTechModel = new LabTechModel($conn);

    // Register the lab technician
    $result = $labTechModel->registerLabTech($data);

    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'message' => 'Registration submitted successfully',
            'tech_id' => $result['tech_id'],
            'redirect' => 'lab-tech-pending-verification.html'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $result['message']
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection error: ' . $e->getMessage()
    ]);
}

/**
 * Handle file upload
 */
function handleFileUpload($fieldName, $uploadDir) {
    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES[$fieldName];
        $fileName = time() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        // Validate file type
        $allowedTypes = ['application/pdf'];
        if (!in_array($file['type'], $allowedTypes)) {
            return '';
        }

        // Validate file size (5MB max)
        if ($file['size'] > 5 * 1024 * 1024) {
            return '';
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $targetPath;
        }
    }

    return '';
}
?>
