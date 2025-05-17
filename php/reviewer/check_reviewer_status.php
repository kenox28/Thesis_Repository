<?php

session_start();
include_once "../../php/Database.php";

if (!isset($_SESSION['reviewer_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit();
}

$reviewer_id = $_SESSION['reviewer_id'];

$sql = "SELECT approve FROM reviewer WHERE reviewer_id = '$reviewer_id'";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(["status" => "success", "approve" => $row['approve']]);
} else {
    echo json_encode(["status" => "error", "message" => "Reviewer not found"]);
}
?>