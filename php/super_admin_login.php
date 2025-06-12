<?php
session_start();
include_once "Database.php";
require_once "Logger.php";

$email = mysqli_real_escape_string($connect, $_POST['email'] ?? '');
$pass = $_POST['passw'] ?? '';

if (!empty($email) && !empty($pass)) {
    $sql = "SELECT * FROM super_admin WHERE email = '{$email}'";
    $result = mysqli_query($connect, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (md5($pass) === $row['pass']) {
            $_SESSION['super_admin_id'] = $row['super_admin_id'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['email'] = $row['email'];

            // Log successful login
            $logger = new Logger($connect);
            $logger->logActivity(
                $row['super_admin_id'],
                'LOGIN',
                'Super admin logged in successfully'
            );

            echo json_encode([
                "status" => "success",
                "message" => "Super Admin login successful"
            ]);
            exit();
        } else {
            // Log failed login attempt
            $logger = new Logger($connect);
            $logger->logActivity(
                $row['super_admin_id'],
                'LOGIN_FAILED',
                'Failed login attempt for super admin account'
            );
        }
    }
    echo json_encode(["status" => "failed", "message" => "Wrong password or email"]);
} else {
    echo json_encode(["status" => "failed", "message" => "Enter both email and password"]);
}
?> 