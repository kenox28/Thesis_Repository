<?php
require_once 'Database.php';
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';

// Check Student table
$stmt = $connect->prepare("SELECT student_id, fname, lname, 'student' as role FROM Student WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $fname, $lname, $role);
    $stmt->fetch();
    $stmt->close();
    echo json_encode(['status'=>'success', 'student_id'=>$id, 'fname'=>$fname, 'lname'=>$lname, 'role'=>$role]);
    exit;
}
$stmt->close();

// Check Reviewer table
$stmt = $connect->prepare("SELECT reviewer_id, fname, lname, 'reviewer' as role FROM reviewer WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $fname, $lname, $role);
    $stmt->fetch();
    $stmt->close();
    echo json_encode(['status'=>'success', 'student_id'=>$id, 'fname'=>$fname, 'lname'=>$lname, 'role'=>$role]);
    exit;
}
$stmt->close();

echo json_encode(['status'=>'error', 'message'=>'Email not found.']);
?>
