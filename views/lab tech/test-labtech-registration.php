<?php
// Test script for lab technician registration
echo "Testing Lab Technician Registration System...\n";

// Test database connection
require_once __DIR__ . '/models/connection.php';
require_once __DIR__ . '/models/LabTechModel.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    echo "✓ Database connection successful\n";

    // Initialize database
    $database->initializeDatabase();
    echo "✓ Database initialization successful\n";

    // Test data insertion
    $model = new LabTechModel($db);

    $testData = [
        'full_name' => 'Test Lab Technician',
        'gender' => 'Male',
        'dob' => '1990-01-01',
        'nic' => 123456789012,
        'first_contact_no' => 712345678,
        'second_phone_no' => 712345679,
        'email' => 'test.labtech@example.com',
        'address' => 'Test Address, Test City',
        'organization' => 'Test Hospital',
        'org_address' => 'Test Hospital Address',
        'department' => 'Pathology',
        'designation' => 'Senior Lab Technician',
        'employee_id' => 'EMP001',
        'years_experience' => 5,
        'reference' => 'Dr. Test Reference',
        'qualification' => 'Bachelor Degree',
        'institute' => 'Test University',
        'licenseNo' => 'LIC001',
        'license_expiry' => '2025-12-31',
        'degree_certificate' => 'test_degree.pdf',
        'professional_license' => 'test_license.pdf',
        'employee_letter' => 'test_letter.pdf',
        'password' => password_hash('testpassword123', PASSWORD_DEFAULT),
        'labtech_id' => 'LT' . time() . rand(1000, 9999)
    ];

    // First, let's check the current table structure
    try {
        $stmt = $db->query("DESCRIBE labtechaccountregister");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Current table structure:\n";
        foreach ($columns as $column) {
            echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
        }
        echo "\n";
    } catch (Exception $e) {
        echo "Error checking table structure: " . $e->getMessage() . "\n";
    }

    $result = $model->createLabTech($testData);

    if ($result) {
        echo "✓ Test data inserted successfully\n";
        echo "✓ Lab Technician ID: " . $testData['labtech_id'] . "\n";

        // Test data retrieval
        $retrieved = $model->getLabTechById($testData['labtech_id']);
        if ($retrieved && $retrieved['full_name'] === $testData['full_name']) {
            echo "✓ Data retrieval test passed\n";
        } else {
            echo "✗ Data retrieval test failed\n";
        }

    } else {
        echo "✗ Test data insertion failed\n";
    }

} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\nTest completed.\n";
?>
