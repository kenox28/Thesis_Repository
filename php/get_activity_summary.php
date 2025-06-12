<?php
session_start();
require_once 'Database.php';

// Check if user is logged in as super admin
if (!isset($_SESSION['super_admin_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit();
}

try {
    // Get total activities
    $total_query = "SELECT COUNT(*) as total FROM activity_logs";
    $total_result = mysqli_query($connect, $total_query);
    $total_activities = mysqli_fetch_assoc($total_result)['total'];

    // Get active admins (admins who have activities in the last 24 hours)
    $active_admins_query = "SELECT COUNT(DISTINCT user_id) as active_count 
                           FROM activity_logs 
                           WHERE user_type = 'admin' 
                           AND created_at >= NOW() - INTERVAL 24 HOUR";
    $active_admins_result = mysqli_query($connect, $active_admins_query);
    $active_admins = mysqli_fetch_assoc($active_admins_result)['active_count'];

    // Get today's activities
    $today_query = "SELECT COUNT(*) as today_count 
                   FROM activity_logs 
                   WHERE DATE(created_at) = CURDATE()";
    $today_result = mysqli_query($connect, $today_query);
    $today_activities = mysqli_fetch_assoc($today_result)['today_count'];

    // Get critical actions (DELETE, UPDATE operations)
    $critical_query = "SELECT COUNT(*) as critical_count 
                      FROM activity_logs 
                      WHERE action_type IN ('DELETE', 'UPDATE')";
    $critical_result = mysqli_query($connect, $critical_query);
    $critical_actions = mysqli_fetch_assoc($critical_result)['critical_count'];

    echo json_encode([
        "status" => "success",
        "total_activities" => $total_activities,
        "active_admins" => $active_admins,
        "today_activities" => $today_activities,
        "critical_actions" => $critical_actions
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to fetch activity summary: " . $e->getMessage()
    ]);
} 