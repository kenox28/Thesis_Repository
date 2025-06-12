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

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['adminId']) || !isset($data['fname']) || !isset($data['lname']) || !isset($data['email'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit();
}

$admin_id = mysqli_real_escape_string($connect, $data['adminId']);
$fname = mysqli_real_escape_string($connect, $data['fname']);
$lname = mysqli_real_escape_string($connect, $data['lname']);
$email = mysqli_real_escape_string($connect, $data['email']);

// Check if email exists for other admins
$check_email = "SELECT * FROM admin WHERE email = '$email' AND admin_id != '$admin_id'";
$result = mysqli_query($connect, $check_email);
if (mysqli_num_rows($result) > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Email already exists"
    ]);
    exit();
}

// Build update query
$sql = "UPDATE admin SET fname = '$fname', lname = '$lname', email = '$email'";

// Add password update if provided
if (isset($data['password']) && !empty($data['password'])) {
    $password = md5($data['password']);
    $sql .= ", pass = '$password'";
}

$sql .= " WHERE admin_id = '$admin_id'";

if (mysqli_query($connect, $sql)) {
    echo json_encode([
        "status" => "success",
        "message" => "Admin updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update admin: " . mysqli_error($connect)
    ]);
}
?> 