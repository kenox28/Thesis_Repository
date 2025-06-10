<?php
session_start();
include_once '../Database.php';

if (!isset($_SESSION['student_id'])) {
    echo json_encode(["error" => "Student not logged in"]);
    exit();
}

$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM repoTable WHERE student_id = ? AND status = 'continue' AND Chapter = '2' ORDER BY created_at DESC";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$uploads = [];
while ($row = $result->fetch_assoc()) {
    // If you want to process members_id for each row:
    $member_ids = isset($row['members_id']) ? explode(',', $row['members_id']) : [];

    // Get the profile image for the student in this row
    $profileImgQuery = "SELECT profileImg FROM student WHERE student_id = ?";
    $imgStmt = $connect->prepare($profileImgQuery);
    $imgStmt->bind_param("s", $row['student_id']);
    $imgStmt->execute();
    $imgResult = $imgStmt->get_result();
    $profileImgRow = $imgResult ? $imgResult->fetch_assoc() : null;
    $row['profileImg'] = $profileImgRow ? $profileImgRow['profileImg'] : null;
    $uploads[] = $row;
    $imgStmt->close();
}

echo json_encode($uploads);
$stmt->close();
exit;
?>
