<?php
// filepath: c:\xampp\htdocs\Thesis_Repository\php\admin\admin_logout.php
session_start();
session_unset();
session_destroy();

echo json_encode(["status" => "success", "message" => "Logged out successfully"]);
exit();
?>