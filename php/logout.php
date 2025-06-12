<?php
session_start();
require_once "Database.php";
require_once "Logger.php";

// Log the logout activity before destroying the session
if (isset($_SESSION['super_admin_id'])) {
    $logger = new Logger($connect);
    $logger->logActivity(
        $_SESSION['super_admin_id'],
        'LOGOUT',
        'Super admin logged out'
    );
} elseif (isset($_SESSION['admin_id'])) {
    $logger = new Logger($connect);
    $logger->logActivity(
        $_SESSION['admin_id'],
        'LOGOUT',
        'Admin logged out'
    );
}

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destroy the session
session_destroy();


header("location:../views/student_login.php");
exit();


