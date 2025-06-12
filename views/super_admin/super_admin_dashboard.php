<?php
session_start();

// Redirect to login page if super admin is not logged in
if (!isset($_SESSION['super_admin_id'])) {
    header("Location: ../super_admin_login.php");
    exit();
}

// Database connection
require_once '../../php/Database.php';

// Fetch statistics
// Count active admins
$adminQuery = "SELECT COUNT(*) as admin_count FROM admin";
$adminResult = mysqli_query($connect, $adminQuery);
$adminCount = $adminResult->fetch_assoc()['admin_count'];

// Count student users
$studentQuery = "SELECT COUNT(*) as student_count FROM student";
$studentResult = mysqli_query($connect, $studentQuery);
$studentCount = $studentResult->fetch_assoc()['student_count'];

// Count thesis entries
$thesisQuery = "SELECT COUNT(*) as thesis_count FROM publicRepo";
$thesisResult = mysqli_query($connect, $thesisQuery);
$thesisCount = $thesisResult->fetch_assoc()['thesis_count'];

// Calculate system uptime (you might want to implement your own logic here)
$uptimePercentage = "99.9%";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link href="../../assets/css/Admin_Page.css?v=1.0.2" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1976a5;
            --primary-dark: #155d84;
            --primary-light: #2893c7;
            --accent-color: #ff6b6b;
            --background-light: #f8fafc;
            --text-dark: #2d3748;
            --text-light: #718096;
            --success-color: #48bb78;
            --warning-color: #ecc94b;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        body {
            background: var(--background-light);
            color: var(--text-dark);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
            min-height: 100vh;
        }

        header {
            background: linear-gradient(-45deg, var(--primary-color), var(--primary-dark), var(--primary-light));
            background-size: 200% 200%;
            animation: gradientBG 15s ease infinite;
            padding: 1.5rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            color: white;
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        header h1::before {
            content: '⚡';
            font-size: 1.5rem;
        }

        nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        nav a:hover::before {
            transform: translateX(0);
        }

        nav a.active {
            background: rgba(255, 255, 255, 0.2);
            font-weight: 500;
        }

        .btn-danger {
            background: var(--accent-color);
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
        }

        .welcome-section {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            margin: 2rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            animation: slideUp 0.5s ease-out;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .welcome-section h1 {
            color: var(--primary-color);
            margin: 0 0 0.5rem 0;
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .welcome-section p {
            color: var(--text-light);
            margin: 0;
            font-size: 1.1rem;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-color);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            color: var(--primary-color);
            margin: 0 0 1rem 0;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card p {
            color: var(--text-light);
            margin: 0;
            line-height: 1.6;
        }

        .card-icon {
            font-size: 1.4rem;
            color: var(--primary-color);
        }

        .student-view-card {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
        }

        .student-view-card h2 {
            color: white;
        }

        .student-view-card p {
            color: rgba(255, 255, 255, 0.9);
        }

        .btn-student-view {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.8rem 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            color: var(--primary-color);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-student-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background: white;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        /* Stats Section */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header .container {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .welcome-section {
                text-align: center;
            }

            .dashboard-cards {
                grid-template-columns: 1fr;
            }
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
                <a href="#" class="btn btn-danger" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="welcome-section">
            <h1>
                Welcome, Super Admin!
                <span style="font-size: 1.5rem">👋</span>
            </h1>
            <p>Manage your thesis repository system from this central dashboard.</p>
        </div>

        <div class="dashboard-cards">
            <a href="manage_admin.php" class="card-link">
                <div class="card">
                    <h2>
                        <i class="fas fa-users-cog card-icon"></i>
                        Manage Admins
                    </h2>
                    <p>Add, edit, or remove system administrators and manage their permissions.</p>
                </div>
            </a>
            

            <a href="#" class="card-link">
                <div class="card">
                    <h2>
                        <i class="fas fa-cogs card-icon"></i>
                        System Settings
                    </h2>
                    <p>Configure system-wide settings, backup options, and security preferences.</p>
                </div>
            </a>

            <a href="activity_logs.php" class="card-link">
                <div class="card">
                    <h2>
                        <i class="fas fa-history card-icon"></i>
                        Activity Logs
                    </h2>
                    <p>Monitor and review system activities, user actions, and security events.</p>
                </div>
            </a>
        </div>

        <div class="card student-view-card">
                <h2>
                    <i class="fas fa-user-graduate card-icon"></i>
                    Student View Access
                </h2>
                <p>Access the thesis repository as a student to view and verify the content presentation.</p>
                <a href="../student/public_repo.php" class="btn-student-view" id="studentViewBtn">
                    <i class="fas fa-sign-in-alt"></i>
                    View Student Repository
                </a>
            </div>

        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-number"><?php echo $adminCount; ?></div>
                <div class="stat-label">Active Admins</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $studentCount; ?>+</div>
                <div class="stat-label">Student Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $thesisCount; ?>+</div>
                <div class="stat-label">Thesis Entries</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $uptimePercentage; ?></div>
                <div class="stat-label">System Uptime</div>
            </div>
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
                text: 'You will be redirected to the student repository. Continue?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#1976a5',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, continue'
            }).then((result) => {
                if (result.isConfirmed) {
<<<<<<< HEAD
                    // Set super admin student view session before redirect
                    fetch('../../php/set_super_admin_student_view.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                window.location.href = '../student/public_repo.php';
                            } else {
                                throw new Error(data.message || 'Failed to switch to student view');
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message || 'Failed to switch to student view',
                                confirmButtonColor: '#1976a5'
                            });
                        });
=======
                    window.location.href = '../../views/student_login.php';
>>>>>>> 022513b1ffd3b67ac5d932cdcda3235d4fbe8e81
                }
            });
        });
    </script>
</body>
</html> 