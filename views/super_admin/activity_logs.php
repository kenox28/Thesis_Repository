<?php
session_start();

// Redirect to login page if super admin is not logged in
if (!isset($_SESSION['super_admin_id'])) {
    header("Location: ../super_admin_login.php");
    exit();
}

// Log the page visit
require_once '../../php/Database.php';
require_once '../../php/Logger.php';

$logger = new Logger($connect);
$logger->logActivity(
    $_SESSION['super_admin_id'],
    'VIEW',
    'Accessed activity logs page'
);

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
        .user-type-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }

        .user-type-admin {
            background: #e3f2fd;
            color: #1976a5;
        }

        .user-type-super-admin {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .summary-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .summary-number {
            font-size: 24px;
            font-weight: bold;
            color: #1976a5;
            margin-bottom: 8px;
        }

        .summary-label {
            color: #666;
            font-size: 14px;
        }

        .action-details {
            font-size: 14px;
            color: #666;
            margin-top: 4px;
        }

        .filter-group select, .filter-group input {
            width: 100%;
        }

        .export-btn {
            background: #4caf50;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .export-btn:hover {
            background: #43a047;
        }

        .clear-filters {
            background: #f5f5f5;
            color: #666;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }

        .clear-filters:hover {
            background: #e0e0e0;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Activity Monitoring</h1>
            <nav>
                <a href="super_admin_dashboard.php">Home</a>
                <a href="manage_admin.php">Manage Admins</a>
                <a href="activity_logs.php" class="active">Activity Logs</a>
                <a href="#" class="btn btn-danger" id="logoutBtn">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-number" id="totalActivities">0</div>
                <div class="summary-label">Total Activities</div>
            </div>
            <div class="summary-card">
                <div class="summary-number" id="activeAdmins">0</div>
                <div class="summary-label">Active Admins</div>
            </div>
            <div class="summary-card">
                <div class="summary-number" id="todayActivities">0</div>
                <div class="summary-label">Today's Activities</div>
            </div>
            <div class="summary-card">
                <div class="summary-number" id="criticalActions">0</div>
                <div class="summary-label">Critical Actions</div>
            </div>
        </div>

        <div class="logs-container">
            <div class="filters">
                <div class="filter-group">
                    <label for="adminFilter">Admin</label>
                    <select id="adminFilter" class="filter-input">
                        <option value="">All Users</option>
                        <option value="admin">Admins Only</option>
                        <option value="super_admin">Super Admins Only</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="actionFilter">Action Type</label>
                    <select id="actionFilter" class="filter-input">
                        <option value="">All Actions</option>
                        <option value="LOGIN">Login</option>
                        <option value="LOGOUT">Logout</option>
                        <option value="CREATE">Create</option>
                        <option value="UPDATE">Update</option>
                        <option value="DELETE">Delete</option>
                        <option value="VIEW">View</option>
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

            <button class="export-btn" onclick="exportLogs()">
                <i class="fas fa-download"></i> Export to Excel
            </button>
            <button class="clear-filters" onclick="clearFilters()">
                <i class="fas fa-times"></i> Clear Filters
            </button>

            <div id="loading" class="loading">Loading...</div>
            
            <table class="logs-table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>User</th>
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
            updateSummaryCards();
        });

        async function updateSummaryCards() {
            try {
                const response = await fetch('../../php/get_activity_summary.php');
                const data = await response.json();

                if (data.status === 'success') {
                    document.getElementById('totalActivities').textContent = data.total_activities;
                    document.getElementById('activeAdmins').textContent = data.active_admins;
                    document.getElementById('todayActivities').textContent = data.today_activities;
                    document.getElementById('criticalActions').textContent = data.critical_actions;
                }
            } catch (error) {
                console.error('Error updating summary:', error);
            }
        }

        async function loadLogs(page = 1) {
            const loading = document.getElementById('loading');
            const tableBody = document.getElementById('logsTableBody');
            const noLogs = document.getElementById('noLogs');
            
            try {
                loading.style.display = 'block';
                tableBody.innerHTML = '';
                noLogs.style.display = 'none';

                // Get filter values
                const adminFilter = document.getElementById('adminFilter').value;
                const actionType = document.getElementById('actionFilter').value;
                const dateFrom = document.getElementById('dateFrom').value;
                const dateTo = document.getElementById('dateTo').value;

                // Build query string
                const params = new URLSearchParams({
                    page: page,
                    limit: 10,
                    user_type: adminFilter,
                    action_type: actionType,
                    date_from: dateFrom,
                    date_to: dateTo
                });

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
                            const userTypeBadge = `<span class="user-type-badge user-type-${log.user_type.toLowerCase()}">${log.user_type}</span>`;
                            row.innerHTML = `
                                <td>${formatDateTime(log.created_at)}</td>
                                <td>${log.fname} ${log.lname} ${userTypeBadge}</td>
                                <td><span class="action-type ${log.action_type.toLowerCase()}">${log.action_type}</span></td>
                                <td>
                                    ${log.description}
                                    <div class="action-details">IP: ${log.ip_address}</div>
                                </td>
                                <td>${log.ip_address}</td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }

                    updatePagination(data.data.pagination);
                    updateSummaryCards();
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

        function clearFilters() {
            document.getElementById('adminFilter').value = '';
            document.getElementById('actionFilter').value = '';
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
            loadLogs(1);
        }

        async function exportLogs() {
            try {
                const adminFilter = document.getElementById('adminFilter').value;
                const actionType = document.getElementById('actionFilter').value;
                const dateFrom = document.getElementById('dateFrom').value;
                const dateTo = document.getElementById('dateTo').value;

                const params = new URLSearchParams({
                    user_type: adminFilter,
                    action_type: actionType,
                    date_from: dateFrom,
                    date_to: dateTo,
                    export: true
                });

                window.location.href = `../../php/export_logs.php?${params.toString()}`;
            } catch (error) {
                console.error('Error exporting logs:', error);
                showError('Error', 'Failed to export logs');
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