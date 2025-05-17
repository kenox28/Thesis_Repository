<?php
// filepath: c:\xampp\htdocs\Thesis_Repository\php\admin\get_reviewers.php
session_start();
include_once "../../php/Database.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit();
}

// Fetch all reviewers
$sql = "SELECT reviewer_id, fname, lname, email, approve FROM reviewer";
$result = mysqli_query($connect, $sql);

if (!$result) {
    // Output the SQL error for debugging
    echo json_encode(["status" => "error", "message" => "SQL Error: " . mysqli_error($connect)]);
    exit();
}

$reviewers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reviewers[] = $row;
}

echo json_encode(["status" => "success", "data" => $reviewers]);
?>