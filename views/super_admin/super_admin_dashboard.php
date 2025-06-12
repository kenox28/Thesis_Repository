<?php
session_start();

// Redirect to login page if super admin is not logged in
if (!isset($_SESSION['super_admin_id'])) {
    header("Location: ../super_admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link href="../../assets/css/Admin_Page.css?v=1.0.2" rel="stylesheet">
    <style>
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .card h2 {
            color: #1976a5;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .student-view-card {
            background: linear-gradient(135deg, #1976a5, #155d84);
            color: white;
        }
        .student-view-card h2 {
            color: white;
        }
        .student-view-card p {
            color: rgba(255, 255, 255, 0.9);
        }
        .card-icon {
            font-size: 1.2em;
            margin-right: 5px;
        }
        .welcome-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .welcome-section h1 {
            color: #1976a5;
            margin-bottom: 10px;
        }
        .welcome-section p {
            color: #666;
            margin: 0;
        }
        .btn-student-view {
            display: inline-block;
            padding: 10px 20px;
            background-color: white;
            color: #1976a5;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 15px;
            transition: all 0.2s;
        }
        .btn-student-view:hover {
            background-color: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Super Admin Dashboard</h1>
            <nav>
                <a href="super_admin_dashboard.php" class="active">Home</a>
                <a href="manage_admin.php">Manage Admins</a>
                <a href="activity_logs.php">Activity Logs</a>
                <a href="#" class="btn btn-danger" id="logoutBtn">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="welcome-section">
            <h1>Welcome, Super Admin!</h1>
            <p>Manage your thesis repository system from this central dashboard.</p>
        </div>

        <div class="dashboard-cards">
            <a href="manage_admin.php" class="card-link">
                <div class="card">
                    <h2>
                        <i class="fas fa-users-cog card-icon"></i>
                        Manage Admins
                    </h2>
                    <p>Add, edit, or remove system administrators</p>
                </div>
            </a>
            
            <div class="card student-view-card">
                <h2>
                    <i class="fas fa-user-graduate card-icon"></i>
                    Student View Access
                </h2>
                <p>Access the thesis repository as a student to view and verify the content presentation.</p>
                <a href="../../student/login.php" class="btn-student-view" id="studentViewBtn">
                    <i class="fas fa-sign-in-alt"></i> Login as Student
                </a>
            </div>

            <a href="#" class="card-link">
                <div class="card">
                    <h2>
                        <i class="fas fa-cogs card-icon"></i>
                        System Settings
                    </h2>
                    <p>Configure system-wide settings and preferences</p>
                </div>
            </a>

            <a href="activity_logs.php" class="card-link">
                <div class="card">
                    <h2>
                        <i class="fas fa-history card-icon"></i>
                        Activity Logs
                    </h2>
                    <p>View system and user activity history</p>
                </div>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
    <script>
        // Handle logout button
        document.getElementById('logoutBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Logout',
                text: 'Are you sure you want to logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../../php/logout.php';
                }
            });
        });

        // Handle student view button
        document.getElementById('studentViewBtn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Switch to Student View',
                text: 'You will be redirected to the student login page. Continue?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#1976a5',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, continue'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../../views/student_login.php';
                }
            });
        });
    </script>
</body>
</html> 