<?php
session_start();
require_once "Database.php";
require_once "Logger.php";

// Check if user is logged in as super admin
if (!isset($_SESSION['super_admin_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit();
}

try {
    // Set a session variable to indicate super admin is in student view
    $_SESSION['super_admin_student_view'] = true;
    
    // Log the activity
    $logger = new Logger($connect);
    $logger->logActivity(
        $_SESSION['super_admin_id'],
        'VIEW',
        'Super admin switched to student repository view'
    );

    echo json_encode([
        "status" => "success",
        "message" => "Successfully enabled student view"
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to enable student view: " . $e->getMessage()
    ]);
}
?>