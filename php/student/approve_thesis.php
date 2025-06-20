<?php
session_start();    
include_once '../Database.php';
if (!isset($_SESSION['student_id'])) {
    echo json_encode(["error" => "Student not logged in"]);
    exit();
}

$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM repoTable WHERE status = 'approved' and student_id = '$student_id'";
$result = mysqli_query($connect, $sql);

$uploads = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Fetch profile image for this student
    $student_id = $row['student_id']; // Make sure this matches your column name
    $profileImgQuery = "SELECT profileImg FROM student WHERE student_id = '$student_id'";
    $profileImgResult = $connect->query($profileImgQuery);
    $profileImgRow = $profileImgResult ? $profileImgResult->fetch_assoc() : null;
    $row['profileImg'] = $profileImgRow ? $profileImgRow['profileImg'] : null;
    $uploads[] = $row;
}

echo json_encode($uploads);





?>