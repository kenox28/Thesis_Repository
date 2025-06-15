<?php
session_start();
include_once "../../php/Database.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit();
}

// Get the request body
$data = json_decode(file_get_contents("php://input"), true);
$reviewerId = $data['reviewer_id'] ?? null;

if (!$reviewerId) {
    echo json_encode(["status" => "error", "message" => "Reviewer ID is required"]);
    exit();
}

// Update reviewer status to approved
$sql = "UPDATE reviewer SET Approve = 1 WHERE reviewer_id = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "s", $reviewerId);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["status" => "success", "message" => "Reviewer approved successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to approve reviewer: " . mysqli_error($connect)]);
}

mysqli_stmt_close($stmt);
mysqli_close($connect);
?>