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
    <title>Manage Admins - Super Admin</title>
    <link href="../../assets/css/Admin_Page.css?v=1.0.2" rel="stylesheet">
    <style>
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .admin-table th, .admin-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .admin-table th {
            background-color: #1976a5;
            color: white;
            font-weight: 600;
            white-space: nowrap;
        }
        .admin-table tr:hover {
            background-color: #f5f5f5;
        }
        .admin-table tr:last-child td {
            border-bottom: none;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn-edit, .btn-delete {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-edit {
            background-color: #2ecc71;
            color: white;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }
        .btn-edit:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
        }
        .btn-delete:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }
        .add-admin-btn {
            background-color: #1976a5;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            margin: 20px 0;
            transition: all 0.2s;
            font-size: 1rem;
        }
        .add-admin-btn:hover {
            background-color: #155d84;
            transform: translateY(-2px);
        }
        .table-container {
            margin-top: 20px;
            overflow-x: auto;
            border-radius: 8px;
            background: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .page-title {
            color: #1976a5;
            margin: 0;
        }
        .search-container {
            display: flex;
            gap: 15px;
            align-items: center;
            margin: 20px 0;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .search-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        .search-input:focus {
            outline: none;
            border-color: #1976a5;
        }
        .search-input::placeholder {
            color: #999;
        }
        .no-results {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
        /* Loading spinner */
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .loading:after {
            content: "Loading...";
            color: #1976a5;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Manage Admins</h1>
            <nav>
                <a href="super_admin_dashboard.php">Home</a>
                <a href="manage_admin.php" class="active">Manage Admins</a>
                <a href="#">System Settings</a>
                <a href="#" class="btn btn-danger" id="logoutBtn">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Admin Management</h2>
            <button class="add-admin-btn" onclick="openAddAdminModal()">
                <i class="fas fa-plus"></i> Add New Admin
            </button>
        </div>

        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="Search by name, email, or ID...">
        </div>
        
        <div class="table-container">
            <div id="loading" class="loading"></div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Admin ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="adminTableBody">
                    <!-- Admin data will be loaded here dynamically -->
                </tbody>
            </table>
            <div id="noResults" class="no-results" style="display: none;">
                No admins found matching your search.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
    <script src="../../js/manage_admin.js"></script>
</body>
</html>
