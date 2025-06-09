<?php
session_start();
header('Content-Type: application/json');
include_once '../Database.php';

// Fetch all public theses
$sql = "SELECT * FROM publicRepo WHERE Privacy = 'public' ORDER BY id DESC";
$result = $connect->query($sql);

$theses = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Fetch profile image for this student
        $student_id = $row['student_id']; // Make sure this matches your column name
        $profileImgQuery = "SELECT profileImg FROM student WHERE student_id = '$student_id'";
        $profileImgResult = $connect->query($profileImgQuery);
        $profileImgRow = $profileImgResult ? $profileImgResult->fetch_assoc() : null;
        $row['profileImg'] = $profileImgRow ? $profileImgRow['profileImg'] : null;

        $theses[] = $row;
    }
    echo json_encode($theses);
} else {
    echo json_encode(['error' => 'Failed to fetch public theses.']);
}
$connect->close();
?>
