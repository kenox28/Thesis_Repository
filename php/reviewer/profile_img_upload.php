<?php
session_start();
include_once "../Database.php";

header('Content-Type: application/json');

if (!isset($_SESSION['reviewer_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit();
}

$reviewer_id = $_SESSION['reviewer_id'];

if (isset($_FILES['profileImg']) && $_FILES['profileImg']['error'] === UPLOAD_ERR_OK) {
    $img = uniqid('profile_', true) . '_' . basename($_FILES['profileImg']['name']);
    $tempimage = $_FILES['profileImg']['tmp_name'];
    $folder = '../../assets/ImageProfile/' . $img;
    if (move_uploaded_file($tempimage, $folder)) {
        // Update DB
        $sql = "UPDATE reviewer SET profileImg = '$img' WHERE reviewer_id = '$reviewer_id'";
        if (mysqli_query($connect, $sql)) {
            $_SESSION['profileImg'] = $img;
            echo json_encode(["success" => true, "newImg" => $img]);
            exit();
        } else {
            echo json_encode(["success" => false, "error" => "DB update failed"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "File upload failed"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No file uploaded"]);
} 