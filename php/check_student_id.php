<?php
require_once 'Database.php';
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['student_id'] ?? '';
// Check Student
$stmt = $connect->prepare("SELECT student_id FROM Student WHERE student_id=?");
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    echo json_encode(['status'=>'success', 'role'=>'student']);
    exit;
}
$stmt->close();
// Check Reviewer
$stmt = $connect->prepare("SELECT reviewer_id FROM reviewer WHERE reviewer_id=?");
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    echo json_encode(['status'=>'success', 'role'=>'reviewer']);
    exit;
}
$stmt->close();
echo json_encode(['status'=>'error', 'message'=>'ID not found.']);
?>
