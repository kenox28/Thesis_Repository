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

// Get all admins from database
$sql = "SELECT admin_id, fname, lname, email, created_at FROM admin ORDER BY created_at DESC";
$result = mysqli_query($connect, $sql);

if ($result) {
    $admins = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $admins[] = [
            'admin_id' => $row['admin_id'],
            'fname' => $row['fname'],
            'lname' => $row['lname'],
            'email' => $row['email'],
            'created_at' => date('Y-m-d H:i:s', strtotime($row['created_at']))
        ];
    }
    echo json_encode([
        "status" => "success",
        "data" => $admins
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to fetch admins"
    ]);
}
?> 