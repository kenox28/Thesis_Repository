<?php
session_start();
include_once '../Database.php';
if (!isset($_SESSION['student_id'])) {
    echo json_encode(["error" => "Student not logged in"]);
    exit();
}

$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM repoTable WHERE student_id = '$student_id' and status = 'pending' order by created_at desc";
$result = mysqli_query($connect, $sql);

$uploads = [];
while ($row = mysqli_fetch_assoc($result)) {
    $uploads[] = $row;  // Add each row to the uploads array
}

echo json_encode($uploads);

// echo json_encode(['status' => 'success', 'message' => 'Thesis uploaded successfully!','result'=> "$uploads"]);
exit;
?>
