<?php
session_start();

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="../../assets/css/Admin_Page.css?v=1.0.2" rel="stylesheet">

</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Admin Dashboard</h1>
            <nav>
                <a href="admin_dashboard.php">Home</a>
                <a href="Display_Reviewer.php">Manage Reviewers</a>
                <a href="view_reports.php">Book Request</a>
                <a href="#" class="btn btn-danger" id="logoutBtn">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">
        
        <h1>All Registered Students</h1>
        <div class="student-container" id="studentContainer">
            <!-- Student tiles will be dynamically added here -->
        </div>
    </div>
<script src="../../js/admin_dashboard.js"></script>
</body>
</html>