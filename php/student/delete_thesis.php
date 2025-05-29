<?php
session_start();
header('Content-Type: application/json');
include_once '../Database.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing thesis ID.']);
    exit;
}
$thesis_id = $data['id'];
$student_id = $_SESSION['student_id'] ?? null;

if (!$student_id) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated.']);
    exit;
}

// Optionally, check if the thesis belongs to the student
$stmt = $connect->prepare("DELETE FROM repoTable WHERE id=? AND student_id=?");
$stmt->bind_param("is", $thesis_id, $student_id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Thesis deleted successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete thesis.']);
}
$stmt->close();
$connect->close();
?>
