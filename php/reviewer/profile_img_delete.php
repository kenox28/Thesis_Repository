<?php
session_start();
include_once "../Database.php";

if (!isset($_SESSION['reviewer_id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit();
}

$reviewer_id = $_SESSION['reviewer_id'];
$currentImg = $_SESSION['profileImg'];

if ($currentImg && $currentImg !== 'noprofile.png') {
    $imgPath = '../../assets/ImageProfile/' . $currentImg;
    if (file_exists($imgPath)) {
        unlink($imgPath);
    }
}

$sql = "UPDATE reviewer SET profileImg = 'noprofile.png' WHERE reviewer_id = '$reviewer_id'";
if (mysqli_query($connect, $sql)) {
    $_SESSION['profileImg'] = 'noprofile.png';
    header('Location: ../../views/reviewer/View_thesis.php');
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "DB update failed"]);
} 