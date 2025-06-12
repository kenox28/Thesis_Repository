<?php
class Logger {
    private $connect;

    public function __construct($db_connection) {
        $this->connect = $db_connection;
    }

    public function logActivity($user_id, $action_type, $description) {
        $user_id = mysqli_real_escape_string($this->connect, $user_id);
        $action_type = mysqli_real_escape_string($this->connect, $action_type);
        $description = mysqli_real_escape_string($this->connect, $description);
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        // Determine user type based on ID prefix
        $user_type = (substr($user_id, 0, 4) === 'SADM') ? 'super_admin' : 'admin';

        $sql = "INSERT INTO activity_logs (user_id, user_type, action_type, description, ip_address) 
                VALUES ('$user_id', '$user_type', '$action_type', '$description', '$ip_address')";

        if (!mysqli_query($this->connect, $sql)) {
            error_log("Failed to log activity: " . mysqli_error($this->connect));
            return false;
        }
        return true;
    }

    public function getActivityLogs($limit = 100, $offset = 0, $filters = []) {
        $where_clauses = [];
        $params = [];

        if (!empty($filters['admin_id'])) {
            $admin_id = mysqli_real_escape_string($this->connect, $filters['admin_id']);
            $where_clauses[] = "l.user_id = '$admin_id'";
        }

        if (!empty($filters['action_type'])) {
            $action_type = mysqli_real_escape_string($this->connect, $filters['action_type']);
            $where_clauses[] = "l.action_type = '$action_type'";
        }

        if (!empty($filters['date_from'])) {
            $date_from = mysqli_real_escape_string($this->connect, $filters['date_from']);
            $where_clauses[] = "l.created_at >= '$date_from 00:00:00'";
        }

        if (!empty($filters['date_to'])) {
            $date_to = mysqli_real_escape_string($this->connect, $filters['date_to']);
            $where_clauses[] = "l.created_at <= '$date_to 23:59:59'";
        }

        $where_sql = !empty($where_clauses) ? "WHERE " . implode(" AND ", $where_clauses) : "";

        $sql = "SELECT l.*, 
                CASE 
                    WHEN l.user_type = 'admin' THEN a.fname
                    WHEN l.user_type = 'super_admin' THEN sa.fname
                    ELSE NULL
                END as fname,
                CASE 
                    WHEN l.user_type = 'admin' THEN a.lname
                    WHEN l.user_type = 'super_admin' THEN sa.lname
                    ELSE NULL
                END as lname,
                l.user_type
                FROM activity_logs l 
                LEFT JOIN admin a ON l.user_id = a.admin_id AND l.user_type = 'admin'
                LEFT JOIN super_admin sa ON l.user_id = sa.super_admin_id AND l.user_type = 'super_admin'
                $where_sql 
                ORDER BY l.created_at DESC 
                LIMIT $limit OFFSET $offset";

        $result = mysqli_query($this->connect, $sql);
        $logs = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $logs[] = $row;
            }
        }

        return $logs;
    }

    public function getTotalLogs($filters = []) {
        $where_clauses = [];

        if (!empty($filters['admin_id'])) {
            $admin_id = mysqli_real_escape_string($this->connect, $filters['admin_id']);
            $where_clauses[] = "user_id = '$admin_id'";
        }

        if (!empty($filters['action_type'])) {
            $action_type = mysqli_real_escape_string($this->connect, $filters['action_type']);
            $where_clauses[] = "action_type = '$action_type'";
        }

        if (!empty($filters['date_from'])) {
            $date_from = mysqli_real_escape_string($this->connect, $filters['date_from']);
            $where_clauses[] = "created_at >= '$date_from 00:00:00'";
        }

        if (!empty($filters['date_to'])) {
            $date_to = mysqli_real_escape_string($this->connect, $filters['date_to']);
            $where_clauses[] = "created_at <= '$date_to 23:59:59'";
        }

        $where_sql = !empty($where_clauses) ? "WHERE " . implode(" AND ", $where_clauses) : "";

        $sql = "SELECT COUNT(*) as total FROM activity_logs $where_sql";
        $result = mysqli_query($this->connect, $sql);
        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }
} 