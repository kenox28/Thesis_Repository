<?php
session_start();
include_once "Database.php";
include_once "Logger.php";

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

if (!$data || !isset($data['action_type']) || !isset($data['description'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit();
}

$logger = new Logger($connect);
$result = $logger->logActivity(
    $_SESSION['super_admin_id'],
    $data['action_type'],
    $data['description']
);

if ($result) {
    echo json_encode([
        "status" => "success",
        "message" => "Activity logged successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to log activity"
    ]);
} 