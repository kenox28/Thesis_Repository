<?php
session_start();
include_once "../Database.php";

if (!isset($_SESSION['student_id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit();
}

$student_id = $_SESSION['student_id'];

if (isset($_FILES['profileImg']) && $_FILES['profileImg']['error'] === UPLOAD_ERR_OK) {
    $img = basename($_FILES['profileImg']['name']);
    $tempimage = $_FILES['profileImg']['tmp_name'];
    $folder = '../../assets/ImageProfile/' . $img;
    if (move_uploaded_file($tempimage, $folder)) {
        // Update DB
        $sql = "UPDATE student SET profileImg = '$img' WHERE student_id = '$student_id'";
        if (mysqli_query($connect, $sql)) {
            $_SESSION['profileImg'] = $img;
            header('Location: ../../views/student/homepage.php');
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "DB update failed"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "File upload failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No file uploaded"]);
} 