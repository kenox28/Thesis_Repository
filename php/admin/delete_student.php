<?php
session_start();
require_once "../Database.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['student_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "No student ID provided"
    ]);
    exit();
}

$student_id = $data['student_id'];

$sql = "DELETE FROM student WHERE student_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $student_id);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Student deleted successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to delete student"
    ]);
}
?>
