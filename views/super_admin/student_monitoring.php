<?php
session_start();

// Redirect to login page if super admin is not logged in
if (!isset($_SESSION['super_admin_id'])) {
    header("Location: ../super_admin_login.php");
    exit();
}

// Database connection
require_once '../../php/Database.php';

// Create student_activity table if it doesn't exist
include '../../php/super_admin/create_student_activity_table.php';

// Ensure we have a valid connection
if (!$connect) {
    die("Database connection failed");
}

// Fetch overall statistics
$totalStudentsQuery = "SELECT COUNT(*) as total FROM student";
$activeStudentsQuery = "SELECT COUNT(DISTINCT s.student_id) as active 
                       FROM student s 
                       LEFT JOIN student_activity sa ON s.student_id = sa.student_id 
                       WHERE sa.activity_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
$thesisSubmissionsQuery = "SELECT COUNT(*) as submissions FROM publicRepo WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";

$totalStudentsResult = mysqli_query($connect, $totalStudentsQuery);
$activeStudentsResult = mysqli_query($connect, $activeStudentsQuery);
$thesisSubmissionsResult = mysqli_query($connect, $thesisSubmissionsQuery);

$totalStudents = $totalStudentsResult->fetch_assoc()['total'];
$activeStudents = $activeStudentsResult ? $activeStudentsResult->fetch_assoc()['active'] : 0;
$recentSubmissions = $thesisSubmissionsResult ? $thesisSubmissionsResult->fetch_assoc()['submissions'] : 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Monitoring - Super Admin</title>
    <link href="../../assets/css/Admin_Page.css?v=1.0.2" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00246b;
            --primary-dark: #001c54;
            --primary-light: #002d82;
            --accent-color: #ff6b6b;
            --background-light: #f8fafc;
            --text-dark: #2d3748;
            --text-light: #718096;
            --success-color: #48bb78;
            --warning-color: #ecc94b;
            --danger-color: #e53e3e;
        }

        header {
            background: #00246b;
            padding: 1.5rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        header h1 {
            color: white;
            margin: 0;
            font-size: 1.8rem;
        }

        header nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        header nav a {
            color: white;
            text-decoration: none;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        header nav a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        header nav a.active {
            background: rgba(255, 255, 255, 0.2);
        }

        .btn-danger {
            background: var(--accent-color);
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #ff5252;
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-light);
            font-size: 1rem;
        }

        .monitoring-section {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin: 0;
        }

        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .student-table th,
        .student-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .student-table th {
            background-color: #f7fafc;
            font-weight: 600;
            color: var(--text-dark);
        }

        .student-table tr:hover {
            background-color: #f7fafc;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #c6f6d5;
            color: #2f855a;
        }

        .status-inactive {
            background-color: #fed7d7;
            color: #c53030;
        }

        .search-bar {
            width: 100%;
            max-width: 400px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .filter-dropdown {
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            margin-left: 1rem;
            font-size: 1rem;
            background-color: white;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 2rem;
            gap: 0.5rem;
        }

        .pagination-button {
            padding: 0.5rem 1rem;
            border: 1px solid var(--primary-color);
            border-radius: 5px;
            background: white;
            color: var(--primary-color);
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination-button:hover {
            background: var(--primary-color);
            color: white;
        }

        .pagination-button.active {
            background: var(--primary-color);
            color: white;
        }

        .chart-container {
            height: 300px;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .section-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .search-bar,
            .filter-dropdown {
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Student Monitoring</h1>
            <nav>
                <a href="super_admin_dashboard.php">Dashboard</a>
                
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
        <!-- Statistics Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalStudents; ?></div>
                <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $activeStudents; ?></div>
                <div class="stat-label">Active Students (Last 7 Days)</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $recentSubmissions; ?></div>
                <div class="stat-label">Recent Thesis Submissions (30 Days)</div>
            </div>
        </div>

        <!-- Activity Monitoring Section -->
        <div class="monitoring-section">
            <div class="section-header">
                <h2 class="section-title">Student Activity Monitor</h2>
                <div>
                    <input type="text" class="search-bar" id="studentSearch" placeholder="Search students...">
                    <select class="filter-dropdown" id="activityFilter">
                        <option value="all">All Activities</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="student-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Last Active</th>
                            <th>Status</th>
                            <th>Thesis Submissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <!-- Table content will be loaded dynamically -->
                    </tbody>
                </table>
            </div>
            <div class="pagination" id="pagination">
                <!-- Pagination will be added dynamically -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Variables for pagination
        let currentPage = 1;
        const itemsPerPage = 10;
        let totalPages = 1;

        // Function to load student data
        async function loadStudentData(page = 1, search = '', filter = 'all') {
            try {
                const response = await fetch(`../../php/super_admin/get_student_activities.php?page=${page}&search=${search}&filter=${filter}`);
                const data = await response.json();

                if (data.status === 'success') {
                    renderStudentTable(data.students);
                    renderPagination(data.totalPages);
                    totalPages = data.totalPages;
                } else {
                    throw new Error(data.message || 'Failed to load student data');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message,
                    confirmButtonColor: '#1976a5'
                });
            }
        }

        // Function to render student table
        function renderStudentTable(students) {
            const tableBody = document.getElementById('studentTableBody');
            tableBody.innerHTML = students.map(student => `
                <tr>
                    <td>${student.student_id}</td>
                    <td>${student.fname} ${student.lname}</td>
                    <td>${formatDate(student.last_active)}</td>
                    <td>
                        <span class="status-badge ${student.is_active ? 'status-active' : 'status-inactive'}">
                            ${student.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td>${student.thesis_count}</td>
                    <td>
                        <button onclick="viewStudentDetails('${student.student_id}')" class="btn-role-glass">
                            View Details
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Function to render pagination
        function renderPagination(totalPages) {
            const pagination = document.getElementById('pagination');
            let paginationHTML = '';

            // Previous button
            paginationHTML += `
                <button class="pagination-button" 
                        onclick="changePage(${currentPage - 1})"
                        ${currentPage === 1 ? 'disabled' : ''}>
                    Previous
                </button>
            `;

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                paginationHTML += `
                    <button class="pagination-button ${currentPage === i ? 'active' : ''}"
                            onclick="changePage(${i})">
                        ${i}
                    </button>
                `;
            }

            // Next button
            paginationHTML += `
                <button class="pagination-button"
                        onclick="changePage(${currentPage + 1})"
                        ${currentPage === totalPages ? 'disabled' : ''}>
                    Next
                </button>
            `;

            pagination.innerHTML = paginationHTML;
        }

        // Function to change page
        function changePage(page) {
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            loadStudentData(currentPage, document.getElementById('studentSearch').value, document.getElementById('activityFilter').value);
        }

        // Function to format date
        function formatDate(dateString) {
            if (!dateString) return 'Never';
            const date = new Date(dateString);
            return date.toLocaleString();
        }

        // Function to view student details
        function viewStudentDetails(studentId) {
            // Implement student details view functionality
            Swal.fire({
                title: 'Student Details',
                text: `Viewing details for student ${studentId}`,
                icon: 'info',
                confirmButtonColor: '#1976a5'
            });
        }

        // Event listeners
        document.getElementById('studentSearch').addEventListener('input', debounce(function(e) {
            currentPage = 1;
            loadStudentData(currentPage, e.target.value, document.getElementById('activityFilter').value);
        }, 300));

        document.getElementById('activityFilter').addEventListener('change', function(e) {
            currentPage = 1;
            loadStudentData(currentPage, document.getElementById('studentSearch').value, e.target.value);
        });

        // Debounce function for search
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Logout functionality
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
                    fetch('../../php/logout.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                window.location.href = '../../views/landingpage.php';
                            } else {
                                throw new Error(data.message || 'Logout failed');
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message || 'Failed to logout',
                                confirmButtonColor: '#1976a5'
                            });
                        });
                }
            });
        });

        // Initial load
        loadStudentData();
    </script>
</body>
</html>
<?php
// Close the database connection at the end of the page
mysqli_close($connect);
?>