<?php
session_start();
include_once "../php/Database.php";

// Accept login by admin_id or email
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

if (!$login || !$password) {
    header("Location: ../views/admin_login.php?error=missing_fields");
    exit();
}

// Try to find admin by ID or email
$sql = "SELECT * FROM admin WHERE (admin_id = ? OR email = ?)";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ss", $login, $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    if (md5($password) === $row['pass']) {
        // Set session for admin
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        $_SESSION['profileImg'] = $row['profileImg'] ?? 'noprofile.png';
        $_SESSION['email'] = $row['email'];
        header("Location: ../views/admin/admin_dashboard.php");
        exit();
    }
}

// Redirect back to login with error
header("Location: ../views/admin_login.php?error=invalid_credentials");
exit();
?>