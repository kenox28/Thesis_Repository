<?php
session_start();
include_once "../Database.php";

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../../views/admin/admin_dashboard.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];
$oldImg = $_SESSION['profileImg'] ?? 'noprofile.png';

// Only delete the file if it's not the default
if ($oldImg !== 'noprofile.png' && file_exists('../../assets/ImageProfile/' . $oldImg)) {
    @unlink('../../assets/ImageProfile/' . $oldImg);
}

$sql = "UPDATE admin SET profileImg = 'noprofile.png' WHERE admin_id = '$admin_id'";
if (mysqli_query($connect, $sql)) {
    $_SESSION['profileImg'] = 'noprofile.png';
}
header('Location: ../../views/admin/admin_dashboard.php');
exit();
?> 