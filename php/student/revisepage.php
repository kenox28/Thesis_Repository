<?php
session_start();
include_once '../Database.php';
if (!isset($_SESSION['student_id'])) {
    echo json_encode(["error" => "Student not logged in"]);
    exit();
}

$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM repoTable WHERE student_id = '$student_id' and status = 'revised' order by created_at desc";
$result = mysqli_query($connect, $sql);

$uploads = [];
while ($row = mysqli_fetch_assoc($result)) {
<<<<<<< HEAD
=======
    $student_id = $row['student_id'];
    $profileImgQuery = "SELECT profileImg FROM student WHERE student_id = '$student_id'";
    $profileImgResult = $connect->query($profileImgQuery);
    $profileImgRow = $profileImgResult ? $profileImgResult->fetch_assoc() : null;
    $row['profileImg'] = $profileImgRow ? $profileImgRow['profileImg'] : null;
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
    $uploads[] = $row;  // Add each row to the uploads array
}

echo json_encode($uploads);

// echo json_encode(['status' => 'success', 'message' => 'Thesis uploaded successfully!','result'=> "$uploads"]);
exit;
?>
