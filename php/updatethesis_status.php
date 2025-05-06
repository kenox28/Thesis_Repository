<?php
session_start();
include_once 'Database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $thesis_id = $_POST['thesis_id'];
    $status = $_POST['status'];

    $sql = "UPDATE repoTable SET status = '$status' WHERE id = '$thesis_id'";
    if (mysqli_query($connect, $sql)) {
        echo json_encode(["status" => "success", "message" => "Thesis status updated successfully!"]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Failed to update thesis status."]);
    }
} else {
    echo json_encode(["status" => "failed", "message" => "Invalid request."]);
}
?>
