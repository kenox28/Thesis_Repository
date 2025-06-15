<?php
// filepath: c:\xampp\htdocs\Thesis_Repository\php\admin\remove_reviewer.php
session_start();
include_once "../../php/Database.php";

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

// Delete reviewer
$sql = "DELETE FROM reviewer WHERE reviewer_id = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "s", $reviewerId);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["status" => "success", "message" => "Reviewer removed successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to remove reviewer: " . mysqli_error($connect)]);
}

mysqli_stmt_close($stmt);
mysqli_close($connect);
?>