<?php
require_once 'Database.php';
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$stmt = $connect->prepare("SELECT student_id, fname, lname FROM Student WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    echo json_encode(['status'=>'error', 'message'=>'Email not found.']);
    exit;
}
$stmt->bind_result($student_id, $fname, $lname);
$stmt->fetch();
$stmt->close();
echo json_encode(['status'=>'success', 'student_id'=>$student_id, 'fname'=>$fname, 'lname'=>$lname]);
?>
