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

if (!$data || !isset($data['fname']) || !isset($data['lname']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit();
}

$fname = mysqli_real_escape_string($connect, $data['fname']);
$lname = mysqli_real_escape_string($connect, $data['lname']);
$email = mysqli_real_escape_string($connect, $data['email']);
$password = md5($data['password']); // Hash the password

// Generate unique admin ID
$prefix = 'ADM';
$sql = "SELECT MAX(CAST(SUBSTRING(admin_id, 4) AS UNSIGNED)) as max_id FROM admin WHERE admin_id LIKE 'ADM%'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
$next_id = str_pad(($row['max_id'] + 1), 3, '0', STR_PAD_LEFT);
$admin_id = $prefix . $next_id;

// Check if email already exists
$check_email = "SELECT * FROM admin WHERE email = '$email'";
$result = mysqli_query($connect, $check_email);
if (mysqli_num_rows($result) > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Email already exists"
    ]);
    exit();
}

// Insert new admin
$sql = "INSERT INTO admin (admin_id, fname, lname, email, pass) VALUES ('$admin_id', '$fname', '$lname', '$email', '$password')";

if (mysqli_query($connect, $sql)) {
    echo json_encode([
        "status" => "success",
        "message" => "Admin added successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to add admin: " . mysqli_error($connect)
    ]);
}
?> 