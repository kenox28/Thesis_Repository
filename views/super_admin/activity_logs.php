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
    <title>Activity Logs - Super Admin</title>
    <link href="../../assets/css/Admin_Page.css?v=1.0.2" rel="stylesheet">
    <style>
        .logs-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .filters {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .filter-group label {
            font-weight: 600;
            color: #1976a5;
        }
        .filter-input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .filter-input:focus {
            outline: none;
            border-color: #1976a5;
        }
        .logs-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .logs-table th, .logs-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .logs-table th {
            background-color: #1976a5;
            color: white;
            font-weight: 600;
        }
        .logs-table tr:hover {
            background-color: #f5f5f5;
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        .page-btn {
            padding: 8px 12px;
            border: 1px solid #1976a5;
            background: white;
            color: #1976a5;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .page-btn:hover {
            background: #1976a5;
            color: white;
        }
        .page-btn.active {
            background: #1976a5;
            color: white;
        }
        .page-btn:disabled {
            border-color: #ddd;
            color: #999;
            cursor: not-allowed;
        }
        .action-type {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        .action-type.create {
            background: #e3f2fd;
            color: #1976a5;
        }
        .action-type.update {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .action-type.delete {
            background: #fce4ec;
            color: #c2185b;
        }
        .no-logs {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
        .loading {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Activity Logs</h1>
            <nav>
                <a href="super_admin_dashboard.php">Home</a>
                <a href="manage_admin.php">Manage Admins</a>
                <a href="activity_logs.php" class="active">Activity Logs</a>
                <a href="#" class="btn btn-danger" id="logoutBtn">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="logs-container">
            <div class="filters">
                <div class="filter-group">
                    <label for="adminFilter">Admin</label>
                    <select id="adminFilter" class="filter-input">
                        <option value="">All Admins</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="actionFilter">Action Type</label>
                    <select id="actionFilter" class="filter-input">
                        <option value="">All Actions</option>
                        <option value="create">Create</option>
                        <option value="update">Update</option>
                        <option value="delete">Delete</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="dateFrom">Date From</label>
                    <input type="date" id="dateFrom" class="filter-input">
                </div>
                <div class="filter-group">
                    <label for="dateTo">Date To</label>
                    <input type="date" id="dateTo" class="filter-input">
                </div>
            </div>

            <div id="loading" class="loading">Loading...</div>
            
            <table class="logs-table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Admin</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody id="logsTableBody">
                    <!-- Logs will be loaded here -->
                </tbody>
            </table>
            
            <div id="noLogs" class="no-logs" style="display: none;">
                No activity logs found.
            </div>

            <div id="pagination" class="pagination">
                <!-- Pagination will be added here -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
    <script>
        let currentPage = 1;
        let totalPages = 1;

        // Load logs when page loads
        document.addEventListener('DOMContentLoaded', () => {
            loadLogs();
            loadAdminOptions();
            setupFilterListeners();
        });

        async function loadLogs(page = 1) {
            const loading = document.getElementById('loading');
            const tableBody = document.getElementById('logsTableBody');
            const noLogs = document.getElementById('noLogs');
            
            try {
                loading.style.display = 'block';
                tableBody.innerHTML = '';
                noLogs.style.display = 'none';

                // Get filter values
                const adminId = document.getElementById('adminFilter').value;
                const actionType = document.getElementById('actionFilter').value;
                const dateFrom = document.getElementById('dateFrom').value;
                const dateTo = document.getElementById('dateTo').value;

                // Build query string
                const params = new URLSearchParams({
                    page: page,
                    limit: 10
                });

                if (adminId) params.append('admin_id', adminId);
                if (actionType) params.append('action_type', actionType);
                if (dateFrom) params.append('date_from', dateFrom);
                if (dateTo) params.append('date_to', dateTo);

                const response = await fetch(`../../php/get_activity_logs.php?${params.toString()}`);
                const data = await response.json();

                if (data.status === 'success') {
                    const logs = data.data.logs;
                    currentPage = data.data.pagination.current_page;
                    totalPages = data.data.pagination.total_pages;

                    if (logs.length === 0) {
                        noLogs.style.display = 'block';
                    } else {
                        logs.forEach(log => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${formatDateTime(log.created_at)}</td>
                                <td>${log.fname} ${log.lname}</td>
                                <td><span class="action-type ${log.action_type.toLowerCase()}">${log.action_type}</span></td>
                                <td>${log.description}</td>
                                <td>${log.ip_address}</td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }

                    updatePagination(data.data.pagination);
                } else {
                    showError('Error', data.message || 'Failed to load activity logs');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Error', 'Failed to load activity logs');
            } finally {
                loading.style.display = 'none';
            }
        }

        async function loadAdminOptions() {
            try {
                const response = await fetch('../../php/get_admins.php');
                const data = await response.json();

                if (data.status === 'success') {
                    const select = document.getElementById('adminFilter');
                    data.data.forEach(admin => {
                        const option = document.createElement('option');
                        option.value = admin.admin_id;
                        option.textContent = `${admin.fname} ${admin.lname}`;
                        select.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error loading admin options:', error);
            }
        }

        function setupFilterListeners() {
            const filters = ['adminFilter', 'actionFilter', 'dateFrom', 'dateTo'];
            filters.forEach(id => {
                document.getElementById(id).addEventListener('change', () => loadLogs(1));
            });
        }

        function updatePagination(pagination) {
            const paginationDiv = document.getElementById('pagination');
            paginationDiv.innerHTML = '';

            // Previous button
            const prevBtn = document.createElement('button');
            prevBtn.className = 'page-btn';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevBtn.disabled = pagination.current_page === 1;
            prevBtn.onclick = () => loadLogs(pagination.current_page - 1);
            paginationDiv.appendChild(prevBtn);

            // Page numbers
            for (let i = 1; i <= pagination.total_pages; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = `page-btn ${i === pagination.current_page ? 'active' : ''}`;
                pageBtn.textContent = i;
                pageBtn.onclick = () => loadLogs(i);
                paginationDiv.appendChild(pageBtn);
            }

            // Next button
            const nextBtn = document.createElement('button');
            nextBtn.className = 'page-btn';
            nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextBtn.disabled = pagination.current_page === pagination.total_pages;
            nextBtn.onclick = () => loadLogs(pagination.current_page + 1);
            paginationDiv.appendChild(nextBtn);
        }

        function formatDateTime(dateString) {
            const options = { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }

        function showError(title, text) {
            Swal.fire({
                icon: 'error',
                title: title,
                text: text,
                confirmButtonColor: '#1976a5'
            });
        }

        // Handle logout
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
    </script>
</body>
</html> 