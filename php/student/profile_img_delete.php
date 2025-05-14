<?php
session_start();
include_once "../Database.php";

if (!isset($_SESSION['student_id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit();
}

$student_id = $_SESSION['student_id'];
$currentImg = $_SESSION['profileImg'];

if ($currentImg && $currentImg !== 'noprofile.png') {
    $imgPath = '../../assets/ImageProfile/' . $currentImg;
    if (file_exists($imgPath)) {
        unlink($imgPath);
    }
}

$sql = "UPDATE student SET profileImg = 'noprofile.png' WHERE student_id = '$student_id'";
if (mysqli_query($connect, $sql)) {
    $_SESSION['profileImg'] = 'noprofile.png';
    header('Location: ../../views/student/homepage.php');
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "DB update failed"]);
} 