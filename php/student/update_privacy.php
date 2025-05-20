<?php
session_start();
header('Content-Type: application/json');
include_once '../Database.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['privacy']) || !isset($data['title'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters.']);
    exit;
}

$title = $data['title'];
$privacy = $data['privacy'] === 'public' ? 'public' : 'private';
$student_id = $_SESSION['student_id'];

// Check if the thesis exists in publicRepo by title only
$stmt = $connect->prepare("SELECT * FROM publicRepo WHERE title=?");
$stmt->bind_param("s", $title);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Thesis not found in publicRepo.']);
    $stmt->close();
    $connect->close();
    exit;
}
$stmt->close();

// Update the Privacy column in publicRepo by title and student_id
$stmt2 = $connect->prepare("UPDATE publicRepo SET Privacy=? WHERE title=? AND student_id=?");
if (!$stmt2) {
    echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $connect->error]);
    $connect->close();
    exit;
}
$stmt2->bind_param("sss", $privacy, $title, $student_id);

if ($stmt2->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Privacy updated in publicRepo.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database update failed.']);
}
$stmt2->close();
$connect->close();
?> 