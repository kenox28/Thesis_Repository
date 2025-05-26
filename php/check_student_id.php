<?php
require_once 'Database.php';
$data = json_decode(file_get_contents('php://input'), true);
$student_id = $data['student_id'] ?? '';
$stmt = $connect->prepare("SELECT student_id FROM Student WHERE student_id=?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    echo json_encode(['status'=>'error', 'message'=>'Student ID not found.']);
    exit;
}
$stmt->close();
echo json_encode(['status'=>'success']);
?>
