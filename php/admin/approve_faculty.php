<?php
session_start();
include_once "../../php/Database.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$reviewer_id = $data['reviewer_id'] ?? null;

if (!$reviewer_id) {
    echo json_encode(["status" => "error", "message" => "Faculty ID is required"]);
    exit();
}

// Update the 'approve' column in the reviewer table for faculty
$sql = "UPDATE reviewer SET approve = 1 WHERE reviewer_id = '$reviewer_id'";
if (mysqli_query($connect, $sql)) {
    echo json_encode(["status" => "success", "message" => "Faculty approved successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "SQL Error: " . mysqli_error($connect)]);
}
?>
