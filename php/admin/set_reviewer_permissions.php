<?php
session_start();
include_once "../../php/Database.php";
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}
$data = json_decode(file_get_contents("php://input"), true);
$reviewer_id = $data['reviewer_id'] ?? null;
$permissions = $data['permissions'] ?? '';
if (!$reviewer_id) {
    echo json_encode(["status" => "error", "message" => "Reviewer ID required"]);
    exit();
}
$sql = "UPDATE reviewer SET permissions = ? WHERE reviewer_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ss", $permissions, $reviewer_id);
if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update"]);
}
?> 