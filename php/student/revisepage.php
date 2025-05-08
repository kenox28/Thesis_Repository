<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['student_id'])) {
    echo json_encode(['error' => 'Not logged in.']);
    exit;
}

include_once '../Database.php';

$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM revise_table WHERE student_id = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "s", $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo json_encode(['error' => 'Failed to fetch revised uploads.']);
    exit;
}

$uploads = [];
while ($row = mysqli_fetch_assoc($result)) {
    $uploads[] = $row;
}

echo json_encode($uploads);
?>
