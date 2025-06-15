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
    <link href="../../assets/css/Admin_Page.css?v=1.0.2" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .reviewer-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .reviewer-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .reviewer-card:hover {
            transform: translateY(-5px);
        }

        .reviewer-header {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .reviewer-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .reviewer-info {
            flex: 1;
        }

        .reviewer-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .reviewer-email {
            color: var(--text-light);
            font-size: 0.9rem;
            margin: 0.2rem 0;
        }

        .reviewer-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-approve {
            background: var(--success-color);
            color: white;
        }

        .btn-approve:hover {
            background: #3da066;
        }

        .btn-remove {
            background: var(--danger-color);
            color: white;
        }

        .btn-remove:hover {
            background: #c53030;
        }

        .btn-inactive {
            background: var(--warning-color);
            color: white;
        }

        .btn-inactive:hover {
            background: #d6b43f;
        }

        .no-reviewers {
            text-align: center;
            color: var(--text-light);
            font-style: italic;
            padding: 2rem;
            grid-column: 1 / -1;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Manage Reviewers</h1>
            <nav>
                <a href="admin_dashboard.php">Home</a>
                <a href="admin_dashboard.php">Students</a>
                <a href="Display_Reviewer.php" class="active">Manage Reviewers</a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadReviewers();
            setupLogoutHandler();
        });

        function loadReviewers() {
            fetch('../../php/admin/get_reviewers.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const approvedContainer = document.getElementById('approvedReviewers');
                        const pendingContainer = document.getElementById('pendingReviewers');
                        
                        approvedContainer.innerHTML = '';
                        pendingContainer.innerHTML = '';

                        const approvedReviewers = data.data.filter(r => r.Approve === '1');
                        const pendingReviewers = data.data.filter(r => r.Approve === '0');

                        if (approvedReviewers.length === 0) {
                            approvedContainer.innerHTML = '<div class="no-reviewers">No approved reviewers found.</div>';
                        } else {
                            approvedReviewers.forEach(reviewer => {
                                approvedContainer.appendChild(createReviewerCard(reviewer, true));
                            });
                        }

                        if (pendingReviewers.length === 0) {
                            pendingContainer.innerHTML = '<div class="no-reviewers">No pending reviewers found.</div>';
                        } else {
                            pendingReviewers.forEach(reviewer => {
                                pendingContainer.appendChild(createReviewerCard(reviewer, false));
                            });
                        }
                    } else {
                        throw new Error(data.message || 'Failed to load reviewers');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load reviewers. Please try again later.',
                        confirmButtonColor: '#00246b'
                    });
                });
        }

        function createReviewerCard(reviewer, isApproved) {
            const card = document.createElement('div');
            card.className = 'reviewer-card';
            
            const profileImg = reviewer.profileImg || 'noprofile.png';
            
            card.innerHTML = `
                <div class="reviewer-header">
                    <img src="../../assets/ImageProfile/${profileImg}" alt="${reviewer.fname} ${reviewer.lname}" class="reviewer-avatar" onerror="this.src='../../assets/ImageProfile/noprofile.png'">
                    <div class="reviewer-info">
                        <h3 class="reviewer-name">${reviewer.fname} ${reviewer.lname}</h3>
                        <p class="reviewer-email">${reviewer.email}</p>
                        <p class="reviewer-id">ID: ${reviewer.reviewer_id}</p>
                    </div>
                </div>
                <div class="reviewer-actions">
                    ${isApproved ? `
                        <button class="btn btn-inactive" onclick="inactiveReviewer('${reviewer.reviewer_id}')">
                            <i class="fas fa-user-slash"></i> Set Inactive
                        </button>
                        <button class="btn btn-remove" onclick="removeReviewer('${reviewer.reviewer_id}')">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    ` : `
                        <button class="btn btn-approve" onclick="approveReviewer('${reviewer.reviewer_id}')">
                            <i class="fas fa-check"></i> Approve
                        </button>
                        <button class="btn btn-remove" onclick="removeReviewer('${reviewer.reviewer_id}')">
                            <i class="fas fa-times"></i> Reject
                        </button>
                    `}
                </div>
            `;
            
            return card;
        }

        async function approveReviewer(reviewerId) {
            try {
                const response = await fetch('../../php/admin/approve_reviewer.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ reviewer_id: reviewerId })
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Reviewer approved successfully!',
                        confirmButtonColor: '#00246b'
                    });
                    loadReviewers();
                } else {
                    throw new Error(data.message || 'Failed to approve reviewer');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Failed to approve reviewer',
                    confirmButtonColor: '#00246b'
                });
            }
        }

        async function removeReviewer(reviewerId) {
            try {
                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#00246b',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                });

                if (result.isConfirmed) {
                    const response = await fetch('../../php/admin/remove_reviewer.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ reviewer_id: reviewerId })
                    });
                    
                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: 'Reviewer has been removed.',
                            confirmButtonColor: '#00246b'
                        });
                        loadReviewers();
                    } else {
                        throw new Error(data.message || 'Failed to remove reviewer');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Failed to remove reviewer',
                    confirmButtonColor: '#00246b'
                });
            }
        }

        async function inactiveReviewer(reviewerId) {
            try {
                const response = await fetch('../../php/admin/inactive_reviewer.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ reviewer_id: reviewerId })
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Reviewer set to inactive successfully!',
                        confirmButtonColor: '#00246b'
                    });
                    loadReviewers();
                } else {
                    throw new Error(data.message || 'Failed to set reviewer inactive');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Failed to set reviewer inactive',
                    confirmButtonColor: '#00246b'
                });
            }
        }

        function setupLogoutHandler() {
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
                                    confirmButtonColor: '#00246b'
                                });
                            });
                    }
                });
            });
        }
    </script>
</body>
</html>
