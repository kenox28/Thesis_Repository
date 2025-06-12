<?php
session_start();
require_once 'Database.php';
require_once 'Logger.php';

// Check if user is logged in as super admin
if (!isset($_SESSION['super_admin_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit();
}

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="activity_logs_' . date('Y-m-d_H-i-s') . '.xls"');

// Create Logger instance
$logger = new Logger($connect);

// Get filter parameters
$filters = [
    'user_type' => $_GET['user_type'] ?? '',
    'action_type' => $_GET['action_type'] ?? '',
    'date_from' => $_GET['date_from'] ?? '',
    'date_to' => $_GET['date_to'] ?? ''
];

try {
    // Get all logs without pagination
    $logs = $logger->getActivityLogs(1000000, 0, $filters); // Large limit to get all logs

    // Start Excel file content
    echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <style>
        td, th { border: 1px solid #000; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>User</th>
                <th>User Type</th>
                <th>Action</th>
                <th>Description</th>
                <th>IP Address</th>
            </tr>
        </thead>
        <tbody>";

    foreach ($logs as $log) {
        echo "<tr>
            <td>" . htmlspecialchars($log['created_at']) . "</td>
            <td>" . htmlspecialchars($log['fname'] . ' ' . $log['lname']) . "</td>
            <td>" . htmlspecialchars($log['user_type']) . "</td>
            <td>" . htmlspecialchars($log['action_type']) . "</td>
            <td>" . htmlspecialchars($log['description']) . "</td>
            <td>" . htmlspecialchars($log['ip_address']) . "</td>
        </tr>";
    }

    echo "</tbody></table></body></html>";

} catch (Exception $e) {
    echo "Error exporting logs: " . $e->getMessage();
} 