<?php
// filepath: c:\xampp\htdocs\Thesis_Repository\php\admin\admin_logout.php
session_start();
require_once "../Database.php";
require_once "../Logger.php";

// Log the logout activity before destroying the session
if (isset($_SESSION['admin_id'])) {
    $logger = new Logger($connect);
    $logger->logActivity(
        $_SESSION['admin_id'],
        'LOGOUT',
        'Admin logged out'
    );
}

// Clear session
session_unset();
session_destroy();

echo json_encode([
    "status" => "success", 
    "message" => "Logged out successfully"
]);
exit();
?>