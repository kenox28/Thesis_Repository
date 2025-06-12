<?php
session_start();
include_once "../Database.php";

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit();
}

$admin_id = $_SESSION['admin_id'];

if (isset($_FILES['profileImg']) && $_FILES['profileImg']['error'] === UPLOAD_ERR_OK) {
    $img = uniqid('admin_', true) . '_' . basename($_FILES['profileImg']['name']);
    $tempimage = $_FILES['profileImg']['tmp_name'];
    $folder = '../../assets/ImageProfile/' . $img;
    if (move_uploaded_file($tempimage, $folder)) {
        // Update DB
        $sql = "UPDATE admin SET profileImg = '$img' WHERE admin_id = '$admin_id'";
        if (mysqli_query($connect, $sql)) {
            $_SESSION['profileImg'] = $img;
            header('Location: ../../views/admin/admin_dashboard.php');
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
?> 