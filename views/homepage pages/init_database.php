<?php
require_once 'models/connection.php';

try {
    $database = new Database();
    $result = $database->initializeDatabase();

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Database initialized successfully! All tables are ready.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database initialization failed.'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
