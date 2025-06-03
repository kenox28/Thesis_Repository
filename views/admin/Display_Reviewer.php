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
    <title>Manage Reviewers</title>
    <link href="../../assets/css/Admin_Page.css?v=1.0.1" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Manage Reviewers</h1>
            <nav>
                <a href="admin_dashboard.php">Home</a>
                <a href="Display_Reviewer.php">Manage Reviewers</a>
                <a href="public_thesis.php">Publication thesis</a>
                <a href="#" class="btn btn-danger" id="logoutBtn">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <h1>Approved Reviewers</h1>
        <div class="reviewer-container" id="approvedReviewers">
            <!-- Approved reviewer tiles will be dynamically added here -->
        </div>

        <h1>Pending Reviewers</h1>
        <div class="reviewer-container" id="pendingReviewers">
            <!-- Pending reviewer tiles will be dynamically added here -->
        </div>
    </div>

    <script src="../../js/admin_dashboard.js?v=1.0.1"></script>
</body>
</html>