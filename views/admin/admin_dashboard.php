<?php
<!-- filepath: c:\xampp\htdocs\Thesis_Repository\views\admin_dashboard.php -->
<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome, Admin</h1>
        <p>This is the admin dashboard. You can manage the system here.</p>
        <a href="../php/admin/admin_logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>