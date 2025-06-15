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

// Count approved reviewers
$reviewerQuery = "SELECT COUNT(*) as reviewer_count FROM reviewer WHERE approve = 1";
$reviewerResult = mysqli_query($connect, $reviewerQuery);
$reviewerCount = $reviewerResult->fetch_assoc()['reviewer_count'];

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
            --primary-color: #00246b;
            --primary-dark: #001c54;
            --primary-light: #002d82;
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

        /* Student List Modal Styles */
        .student-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow-y: auto;
        }

        .student-modal-content {
            background: white;
            margin: 2% auto;
            padding: 20px;
            width: 90%;
            max-width: 1000px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .student-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        .student-modal-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin: 0;
        }

        .student-search-container {
            position: relative;
            margin-bottom: 20px;
        }

        .student-search {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 50%;
            font-size: 1rem;
            padding-left: 40px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .loading-spinner {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            display: none;
        }

        .no-results {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
            background: #f8f9fa;
            border-radius: 8px;
            margin-top: 20px;
        }

        .student-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .student-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid #e0e0e0;
        }

        .student-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .student-info {
            flex: 1;
        }

        .student-name {
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 5px 0;
        }

        .student-email {
            color: var(--text-light);
            font-size: 0.9rem;
            margin: 0;
        }

        .student-id {
            color: var(--text-light);
            font-size: 0.8rem;
            margin: 5px 0 0 0;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            color: #666;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close-modal:hover {
            color: var(--primary-color);
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

            .student-search {
                width: 100%;
            }
            
            .student-list {
                grid-template-columns: 1fr;
            }
        }

        .btn-role-glass {
            background: rgba(202,220,252,0.45);
            color: #1976a5;
            border: 1.5px solid #1976a5;
            font-weight: 600;
            border-radius: 18px;
            padding: 0.5rem 1.2rem;
            margin: 0 0.2rem 0.2rem 0;
            font-size: 1rem;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            cursor: pointer;
            outline: none;
            box-shadow: 0 2px 8px #cadcfc22;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-role-glass:hover, .btn-role-glass:focus {
            background: #1976a5;
            color: #fff;
            box-shadow: 0 4px 16px #1976a555;
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
            

            <a href="student_monitoring.php" class="card-link">
                <div class="card">
                    <h2>
                        <i class="fas fa-cogs card-icon"></i>
                        Student Logs
                    </h2>
                    <p>Monitor and review system activities of the students.</p>
                </div>
            </a>

            <a href="activity_logs.php" class="card-link">
                <div class="card">
                    <h2>
                        <i class="fas fa-history card-icon"></i>
                        Admin Logs
                    </h2>
                    <p>Monitor and review system activities of the admins.</p>
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
            <div class="stat-card" style="cursor: pointer;" onclick="showStudentList()">
                <div class="stat-number"><?php echo $studentCount; ?></div>
                <div class="stat-label">Student Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $thesisCount; ?></div>
                <div class="stat-label">Thesis Entries</div>
            </div>
            <div class="stat-card" style="cursor: pointer;" onclick="showReviewerList()">
                <div class="stat-number"><?php echo $reviewerCount; ?></div>
                <div class="stat-label">Approved Reviewers</div>
            </div>
        </div>

        <!-- Student List Modal -->
        <div id="studentListModal" class="student-modal">
            <div class="student-modal-content">
                <span class="close-modal" id="closeStudentModal">&times;</span>
                <div class="student-modal-header">
                    <h2 class="student-modal-title">
                        <i class="fas fa-users"></i>
                        Student List
                    </h2>
                </div>
                <div class="student-search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="studentSearch" class="student-search" placeholder="Search by name, email, or ID...">
                    <i class="fas fa-spinner fa-spin loading-spinner" id="searchSpinner"></i>
                </div>
                <div id="studentList" class="student-list">
                    <!-- Students will be loaded here -->
                </div>
                <div id="noResults" class="no-results" style="display: none;">
                    No students found matching your search.
                </div>
            </div>
        </div>

        <!-- Reviewer List Modal -->
        <div id="reviewerListModal" class="student-modal">
            <div class="student-modal-content">
                <span class="close-modal" id="closeReviewerModal">&times;</span>
                <div class="student-modal-header">
                    <h2 class="student-modal-title">
                        <i class="fas fa-user-tie"></i>
                        Approved Reviewer List
                    </h2>
                </div>
                <div class="student-search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="reviewerSearch" class="student-search" placeholder="Search approved reviewers...">
                    <i class="fas fa-spinner fa-spin loading-spinner" id="reviewerSearchSpinner"></i>
                </div>
                <div id="reviewerList" class="student-list">
                    <!-- Reviewers will be loaded here -->
                </div>
                <div id="noReviewerResults" class="no-results" style="display: none;">
                    No reviewers found matching your search.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        let searchTimeout = null;
        const searchSpinner = document.getElementById('searchSpinner');
        const noResults = document.getElementById('noResults');
        const studentModal = document.getElementById('studentListModal');
        const studentList = document.getElementById('studentList');
        const searchInput = document.getElementById('studentSearch');
        const reviewerModal = document.getElementById('reviewerListModal');
        const reviewerList = document.getElementById('reviewerList');
        const reviewerSearch = document.getElementById('reviewerSearch');
        const reviewerSearchSpinner = document.getElementById('reviewerSearchSpinner');
        const noReviewerResults = document.getElementById('noReviewerResults');
        let reviewerSearchTimeout = null;

        // Function to show student list modal
        function showStudentList() {
            studentModal.style.display = 'block';
            searchInput.value = ''; // Clear search input
            loadStudents(); // Load initial list
        }

        // Function to close modal
        function closeModal() {
            studentModal.style.display = 'none';
            studentList.innerHTML = ''; // Clear the list
            searchInput.value = ''; // Clear search input
            noResults.style.display = 'none';
        }

        // Close modal when clicking X or outside
        document.getElementById('closeStudentModal').addEventListener('click', closeModal);
        window.addEventListener('click', function(event) {
            if (event.target === studentModal) {
                closeModal();
            }
        });

        // Load initial students
        async function loadStudents() {
            try {
                searchSpinner.style.display = 'block';
                const response = await fetch('../../php/search_students.php');
                if (!response.ok) {
                    throw new Error('Failed to load students');
                }
                const data = await response.json();
                
                if (data.status === 'success') {
                    renderStudents(data.data);
                } else {
                    throw new Error(data.message || 'Failed to load students');
                }
            } catch (error) {
                console.error('Load error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message,
                    confirmButtonColor: '#1976a5'
                });
            } finally {
                searchSpinner.style.display = 'none';
            }
        }

        // Live search functionality
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.trim();
            
            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }

            // Show spinner
            searchSpinner.style.display = 'block';

            // Set new timeout
            searchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`../../php/search_students.php?search=${encodeURIComponent(searchTerm)}`);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    
                    const data = await response.json();
                    console.log('Search response:', data); // Debug log

                    if (data.status === 'success') {
                        renderStudents(data.data);
                    } else {
                        throw new Error(data.message || 'Failed to search students');
                    }
                } catch (error) {
                    console.error('Search error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Search Error',
                        text: error.message,
                        confirmButtonColor: '#1976a5'
                    });
                } finally {
                    searchSpinner.style.display = 'none';
                }
            }, 300);
        });

        function renderStudents(students) {
            if (!Array.isArray(students)) {
                console.error('Expected students to be an array, got:', students);
                return;
            }

            noResults.style.display = students.length === 0 ? 'block' : 'none';
            
            studentList.innerHTML = students.map(student => `
                <div class="student-card">
                    <img src="../../assets/ImageProfile/${student.profileImg || 'noprofile.png'}" 
                         alt="${student.fname} ${student.lname}" 
                         class="student-avatar"
                         onerror="this.src='../../assets/ImageProfile/noprofile.png'">
                    <div class="student-info">
                        <h3 class="student-name">${student.fname} ${student.lname}</h3>
                        <p class="student-email">${student.email}</p>
                        <p class="student-id">${student.student_id}</p>
                        <button class="btn-role-glass" onclick="setRole('${student.student_id}', 'reviewer')">Set Role to Reviewer</button>
                    </div>
                </div>
            `).join('');
        }

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
                    // First destroy the session
                    fetch('../../php/logout.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Then redirect to landing page
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
                }
            });
        });

        // Function to show reviewer list modal
        function showReviewerList() {
            reviewerModal.style.display = 'block';
            reviewerSearch.value = ''; // Clear search input
            loadReviewers(); // Load initial list
        }

        // Function to close reviewer modal
        function closeReviewerModal() {
            reviewerModal.style.display = 'none';
            reviewerList.innerHTML = ''; // Clear the list
            reviewerSearch.value = ''; // Clear search input
            noReviewerResults.style.display = 'none';
        }

        // Close reviewer modal when clicking X or outside
        document.getElementById('closeReviewerModal').addEventListener('click', closeReviewerModal);
        window.addEventListener('click', function(event) {
            if (event.target === reviewerModal) {
                closeReviewerModal();
            }
        });

        // Load initial reviewers
        async function loadReviewers() {
            try {
                reviewerSearchSpinner.style.display = 'block';
                const response = await fetch('../../php/search_reviewers.php');
                if (!response.ok) {
                    throw new Error('Failed to load reviewers');
                }
                const data = await response.json();
                
                if (data.status === 'success') {
                    renderReviewers(data.data);
                } else {
                    throw new Error(data.message || 'Failed to load reviewers');
                }
            } catch (error) {
                console.error('Load error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message,
                    confirmButtonColor: '#1976a5'
                });
            } finally {
                reviewerSearchSpinner.style.display = 'none';
            }
        }

        // Live search functionality for reviewers
        reviewerSearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.trim();
            
            if (reviewerSearchTimeout) {
                clearTimeout(reviewerSearchTimeout);
            }

            reviewerSearchSpinner.style.display = 'block';

            reviewerSearchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`../../php/search_reviewers.php?search=${encodeURIComponent(searchTerm)}`);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    
                    const data = await response.json();
                    console.log('Reviewer search response:', data);

                    if (data.status === 'success') {
                        renderReviewers(data.data);
                    } else {
                        throw new Error(data.message || 'Failed to search reviewers');
                    }
                } catch (error) {
                    console.error('Search error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Search Error',
                        text: error.message,
                        confirmButtonColor: '#1976a5'
                    });
                } finally {
                    reviewerSearchSpinner.style.display = 'none';
                }
            }, 300);
        });

        function renderReviewers(reviewers) {
            if (!Array.isArray(reviewers)) {
                console.error('Expected reviewers to be an array, got:', reviewers);
                return;
            }

            noReviewerResults.style.display = reviewers.length === 0 ? 'block' : 'none';
            
            reviewerList.innerHTML = reviewers.map(reviewer => `
                <div class="student-card">
                    <img src="../../assets/ImageProfile/noprofile.png" 
                         alt="${reviewer.fname} ${reviewer.lname}" 
                         class="student-avatar">
                    <div class="student-info">
                        <h3 class="student-name">${reviewer.fname} ${reviewer.lname}</h3>
                        <p class="student-email">${reviewer.email}</p>
                        <p class="student-id">Reviewer ID: ${reviewer.reviewer_id}</p>
                        <p class="last-active">Last Active: ${reviewer.last_active ? new Date(reviewer.last_active).toLocaleString() : 'Never'}</p>
                        <button class="btn-role-glass" onclick="setRole('${reviewer.reviewer_id}', 'student')">Set Role to Student</button>
                    </div>
                </div>
            `).join('');
        }

        async function fetchData(url, method = "GET", body = null) {
            try {
                const options = {
                    method,
                    headers: { "Content-Type": "application/json" },
                };
                if (body) options.body = JSON.stringify(body);

                const response = await fetch(url, options);
                const text = await response.text();
                return JSON.parse(text);
            } catch (error) {
                console.error(`Error fetching from ${url}:`, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
                    confirmButtonColor: '#1976a5'
                });
                return null;
            }
        }

        async function setRole(id, role) {
            const result = await fetchData("../../php/admin/set_role.php", "POST", {
                id,
                role,
            });
            if (!result) return;
            if (result.status === "success") {
                Swal.fire({
                    title: "Success",
                    text: result.message,
                    icon: "success",
                });
            }
        }
    </script>
</body>
</html> 