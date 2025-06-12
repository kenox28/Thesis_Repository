<?php
session_start();
include_once "Database.php";
include_once "Logger.php";

// Check if user is logged in as super admin
if (!isset($_SESSION['super_admin_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit();
}

// Get query parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

// Get filters
$filters = [
    'admin_id' => isset($_GET['admin_id']) ? $_GET['admin_id'] : null,
    'action_type' => isset($_GET['action_type']) ? $_GET['action_type'] : null,
    'date_from' => isset($_GET['date_from']) ? $_GET['date_from'] : null,
    'date_to' => isset($_GET['date_to']) ? $_GET['date_to'] : null
];

$logger = new Logger($connect);

try {
    // Get logs
    $logs = $logger->getActivityLogs($limit, $offset, $filters);
    $total = $logger->getTotalLogs($filters);
    $total_pages = ceil($total / $limit);

    echo json_encode([
        "status" => "success",
        "data" => [
            "logs" => $logs,
            "pagination" => [
                "current_page" => $page,
                "total_pages" => $total_pages,
                "total_records" => $total,
                "limit" => $limit
            ]
        ]
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to fetch activity logs: " . $e->getMessage()
    ]);
} 