<?php
session_start();
include_once "Database.php";

// Check if user is logged in as super admin
if (!isset($_SESSION['super_admin_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['adminId'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Admin ID is required"
    ]);
    exit();
}

$admin_id = mysqli_real_escape_string($connect, $data['adminId']);

// Delete admin
$sql = "DELETE FROM admin WHERE admin_id = '$admin_id'";

if (mysqli_query($connect, $sql)) {
    echo json_encode([
        "status" => "success",
        "message" => "Admin deleted successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to delete admin: " . mysqli_error($connect)
    ]);
}
?> 