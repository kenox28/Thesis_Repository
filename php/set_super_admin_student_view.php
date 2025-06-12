<?php
session_start();

// Prevent any HTML output
error_reporting(0);
header('Content-Type: application/json');

try {
    // Check if the user is a super admin
    if (!isset($_SESSION['super_admin_id'])) {
        throw new Exception('Unauthorized access');
    }

    // Set special session variables for student view
    $_SESSION['super_admin_student_view'] = true;
    $_SESSION['student_view_time'] = time();

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>