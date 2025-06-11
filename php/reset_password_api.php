<?php
header('Content-Type: application/json');
require_once 'Database.php';

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'] ?? '';
$password_raw = $data['password'] ?? '';
$confirm_raw = $data['confirm'] ?? '';

if (!$user_id || !$password_raw || !$confirm_raw) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}
if ($password_raw !== $confirm_raw) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
    exit;
}
if (strlen($password_raw) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters.']);
    exit;
}
$password = md5($password_raw);

$stmt = $connect->prepare('UPDATE Student SET passw=? WHERE student_id=?');
$stmt->bind_param('ss', $password, $user_id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Password updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update password.']);
}
$stmt->close(); 