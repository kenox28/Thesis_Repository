<?php
session_start();

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}

// Log the page visit
require_once '../../php/Database.php';
require_once '../../php/Logger.php';

$logger = new Logger($connect);
$logger->logActivity(
    $_SESSION['admin_id'],
    'VIEW',
    'Accessed admin dashboard'
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="../../assets/css/Admin_Page.css?v=1.0.2" rel="stylesheet">
    <style>
        .dashboard-container {
            padding: 20px;
        }

        .section-title {
            color: #1976a5;
            margin-bottom: 20px;
            font-size: 1.8rem;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .student-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .student-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .student-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #1976a5;
        }

        .student-info h3 {
            margin: 0;
            color: #1976a5;
            font-size: 1.2rem;
        }

        .student-id, .student-email {
            margin: 5px 0;
            color: #666;
            font-size: 0.9rem;
        }

        .student-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .student-actions button {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: background-color 0.2s;
        }

        .btn-primary {
            background: #1976a5;
            color: white;
        }

        .btn-primary:hover {
            background: #155d84;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }

        .error-message {
            text-align: center;
            padding: 40px;
            color: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #ffe5e5;
            border-radius: 8px;
            margin: 20px 0;
        }

        .no-students {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px dashed #ccc;
        }

        /* SweetAlert2 Custom Styles */
        .student-details {
            text-align: left;
            margin-top: 20px;
        }

        .student-details p {
            margin: 10px 0;
            color: #333;
        }

        .student-details strong {
            color: #1976a5;
            margin-right: 5px;
        }

        .swal2-input {
            margin: 10px 0;
        }

        /* Reviewer Section Styles */
        .reviewer-section {
            margin-top: 40px;
        }

        #approvedReviewers, #pendingReviewers {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .reviewer-tile {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Admin Dashboard</h1>
            <nav>
                <a href="admin_dashboard.php" class="active">Home</a>
                <a href="Display_Reviewer.php">Manage Reviewers</a>
                <a href="public_thesis.php">Publication thesis</a>
                <a href="#" class="btn btn-danger" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </div>
    </header>

    <div class="container dashboard-container">
        <!-- Students Section -->
        <div class="student-section">
            <h2 class="section-title">Registered Students</h2>
            <div id="studentContainer">
                <!-- Student cards will be dynamically added here -->
            </div>
        </div>

        <!-- Reviewers Section -->
        <div class="reviewer-section">
            <h2 class="section-title">Reviewers</h2>
            
            <h3>Approved Reviewers</h3>
            <div id="approvedReviewers">
                <!-- Approved reviewers will be dynamically added here -->
            </div>

            <h3>Pending Reviewers</h3>
            <div id="pendingReviewers">
                <!-- Pending reviewers will be dynamically added here -->
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../js/admin_dashboard.js?v=1.0.9"></script>
</body>
</html>