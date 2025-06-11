<?php
session_start();
include_once '../Database.php';        

if (!isset($_SESSION['reviewer_id'])) {
    echo json_encode(["error" => "Reviewer not logged in"]);
    exit();
}

$reviewer_id = $_SESSION['reviewer_id'];

<<<<<<< HEAD
$sql = "SELECT * FROM repoTable WHERE reviewer_id = '$reviewer_id' AND status = 'pending'";
=======
$sql = "SELECT * FROM repoTable WHERE reviewer_id = '$reviewer_id' AND status = 'Pending'";
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
$result = mysqli_query($connect, $sql);

$uploads = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
<<<<<<< HEAD
=======
        $student_id = $row['student_id'];
        $profileImgQuery = "SELECT profileImg FROM student WHERE student_id = '$student_id'";
        $profileImgResult = $connect->query($profileImgQuery);
        $profileImgRow = $profileImgResult ? $profileImgResult->fetch_assoc() : null;
        $row['profileImg'] = $profileImgRow ? $profileImgRow['profileImg'] : null;
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
        $uploads[] = $row;
    }
    echo json_encode($uploads);
} else {
    echo json_encode(["error" => "Query failed"]);
}
?>
