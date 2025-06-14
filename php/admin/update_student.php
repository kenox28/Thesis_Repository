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

if (!isset($data['student_id'], $data['fname'], $data['lname'], $data['email'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit();
}

$student_id = $data['student_id'];
$fname = $data['fname'];
$lname = $data['lname'];
$email = $data['email'];

$sql = "UPDATE student SET fname = ?, lname = ?, email = ? WHERE student_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ssss", $fname, $lname, $email, $student_id);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Student updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update student"
    ]);
}
?>
