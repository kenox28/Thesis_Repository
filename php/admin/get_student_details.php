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

if (!isset($_GET['id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "No student ID provided"
    ]);
    exit();
}

$student_id = $_GET['id'];
$sql = "SELECT student_id, fname, lname, email, profileImg, created_at FROM student WHERE student_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if ($student) {
    echo json_encode([
        "status" => "success",
        "student" => $student
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Student not found"
    ]);
}
?>
