<?php
session_start();    
include_once '../Database.php';
if (!isset($_SESSION['reviewer_id'])) {
    echo json_encode(["error" => "Reviewer not logged in"]);
    exit();
}

$reviewer_id = $_SESSION['reviewer_id'];
// Select the data of uploaded thesis
$sql = "SELECT * FROM repoTable WHERE status = 'rejected' and reviewer_id = '$reviewer_id'";
$result = mysqli_query($connect, $sql);

$uploads = [];
<<<<<<< HEAD
while ($row = mysqli_fetch_assoc($result)) {
=======
while ($row = mysqli_fetch_assoc($result)) {    
    $student_id = $row['student_id'];
    $profileImgQuery = "SELECT profileImg FROM student WHERE student_id = '$student_id'";
    $profileImgResult = $connect->query($profileImgQuery);
    $profileImgRow = $profileImgResult ? $profileImgResult->fetch_assoc() : null;
    $row['profileImg'] = $profileImgRow ? $profileImgRow['profileImg'] : null;
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
    $uploads[] = $row;  // Add each row to the uploads array
}

echo json_encode($uploads);





?>