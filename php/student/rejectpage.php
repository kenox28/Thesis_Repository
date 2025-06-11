<?php
session_start();    
include_once '../Database.php';
if (!isset($_SESSION['student_id'])) {
    echo json_encode(["error" => "Student not logged in"]);
    exit();
}

$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM repoTable WHERE status = 'rejected' and student_id = '$student_id'";
$result = mysqli_query($connect, $sql);

$uploads = [];
while ($row = mysqli_fetch_assoc($result)) {
<<<<<<< HEAD
    $uploads[] = $row;  
=======
    $student_id = $row['student_id'];
    $profileImgQuery = "SELECT profileImg FROM student WHERE student_id = '$student_id'";
    $profileImgResult = $connect->query($profileImgQuery);
    $profileImgRow = $profileImgResult ? $profileImgResult->fetch_assoc() : null;
    $row['profileImg'] = $profileImgRow ? $profileImgRow['profileImg'] : null;
    $uploads[] = $row;
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
}

echo json_encode($uploads);





?>