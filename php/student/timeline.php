<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();    
include_once '../Database.php';
if (!isset($_SESSION['student_id'])) {
    echo json_encode(["error" => "Student not logged in"]);
    exit();
}

$id = isset($_POST['id']) ? $_POST['id'] : null;
if (!$id) {
    echo json_encode(['error' => 'No ID provided']);
    exit();
}

$sql = "SELECT r.* 
        FROM repoTable r
        JOIN publicRepo p ON r.student_id = p.student_id AND r.ThesisFile = p.ThesisFile
        WHERE r.student_id = '$id' AND p.Privacy = 'public'";

$result = mysqli_query($connect, $sql);

$uploads = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Fetch profile image for this student
    $student_id = $row['student_id'];
    $profileImgQuery = "SELECT profileImg FROM student WHERE student_id = '$student_id'";
    $profileImgResult = $connect->query($profileImgQuery);
    $profileImgRow = $profileImgResult ? $profileImgResult->fetch_assoc() : null;
    $row['profileImg'] = $profileImgRow ? $profileImgRow['profileImg'] : null;
    $uploads[] = $row;
}

echo json_encode($uploads);
?>
