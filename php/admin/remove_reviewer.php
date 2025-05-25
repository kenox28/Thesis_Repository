<?php
// filepath: c:\xampp\htdocs\Thesis_Repository\php\admin\remove_reviewer.php
session_start();
include_once "../../php/Database.php";

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$reviewer_id = $data['reviewer_id'] ?? null;

if (!$reviewer_id) {
    echo json_encode(["status" => "error", "message" => "Reviewer ID is required"]);
    exit();
}

$sql = "DELETE FROM reviewer WHERE reviewer_id = '$reviewer_id'";
if (mysqli_query($connect, $sql)) {
    echo json_encode(["status" => "success", "message" => "Reviewer removed successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to remove reviewer"]);
}
?>