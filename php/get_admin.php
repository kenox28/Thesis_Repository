<?php
session_start();
include_once "Database.php";

// Check if user is logged in as super admin
if (!isset($_SESSION['super_admin_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit();
}

// Get admin ID from query string
$admin_id = mysqli_real_escape_string($connect, $_GET['id']);

// Get admin details
$sql = "SELECT admin_id, fname, lname, email FROM admin WHERE admin_id = '$admin_id'";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $admin = mysqli_fetch_assoc($result);
    echo json_encode([
        "status" => "success",
        "data" => $admin
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Admin not found"
    ]);
}
?> 