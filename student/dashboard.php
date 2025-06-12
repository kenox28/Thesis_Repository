<?php
session_start();

// Check if user is logged in as student or super admin in student view
if (!isset($_SESSION['student_id']) && (!isset($_SESSION['super_admin_id']) || !isset($_SESSION['super_admin_student_view']))) {
    header("Location: ../views/student_login.php");
    exit();
}

// If super admin is viewing, get their info
$isAdminView = isset($_SESSION['super_admin_id']) && isset($_SESSION['super_admin_student_view']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="../assets/css/Admin_Page.css" rel="stylesheet">
    <style>
        .admin-view-banner {
            background: #1976a5;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-view-banner button {
            background: white;
            color: #1976a5;
            border: none;
            padding: 5px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }
        .admin-view-banner button:hover {
            background: #f0f0f0;
        }
        .main-content {
            margin-top: <?php echo $isAdminView ? '60px' : '0'; ?>;
        }
    </style>
</head>
<body>
    <?php if ($isAdminView): ?>
    <div class="admin-view-banner">
        <span>You are viewing the student dashboard as a Super Admin</span>
        <button onclick="window.location.href='../views/super_admin/super_admin_dashboard.php'">
            Return to Admin Dashboard
        </button>
    </div>
    <?php endif; ?>

    <div class="main-content">
        <!-- Add your student dashboard content here -->
        <h1>Student Dashboard</h1>
        <!-- Add more content as needed -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html> 