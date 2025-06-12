<?php
class Logger {
    private $connect;

    public function __construct($db_connection) {
        $this->connect = $db_connection;
    }

    public function logActivity($admin_id, $action_type, $description) {
        $admin_id = mysqli_real_escape_string($this->connect, $admin_id);
        $action_type = mysqli_real_escape_string($this->connect, $action_type);
        $description = mysqli_real_escape_string($this->connect, $description);
        $ip_address = $_SERVER['REMOTE_ADDR'];

        $sql = "INSERT INTO activity_logs (admin_id, action_type, description, ip_address) 
                VALUES ('$admin_id', '$action_type', '$description', '$ip_address')";

        return mysqli_query($this->connect, $sql);
    }

    public function getActivityLogs($limit = 100, $offset = 0, $filters = []) {
        $where_clauses = [];
        $params = [];

        if (!empty($filters['admin_id'])) {
            $admin_id = mysqli_real_escape_string($this->connect, $filters['admin_id']);
            $where_clauses[] = "admin_id = '$admin_id'";
        }

        if (!empty($filters['action_type'])) {
            $action_type = mysqli_real_escape_string($this->connect, $filters['action_type']);
            $where_clauses[] = "action_type = '$action_type'";
        }

        if (!empty($filters['date_from'])) {
            $date_from = mysqli_real_escape_string($this->connect, $filters['date_from']);
            $where_clauses[] = "created_at >= '$date_from'";
        }

        if (!empty($filters['date_to'])) {
            $date_to = mysqli_real_escape_string($this->connect, $filters['date_to']);
            $where_clauses[] = "created_at <= '$date_to'";
        }

        $where_sql = !empty($where_clauses) ? "WHERE " . implode(" AND ", $where_clauses) : "";

        $sql = "SELECT l.*, a.fname, a.lname 
                FROM activity_logs l 
                LEFT JOIN admin a ON l.admin_id = a.admin_id 
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
            $where_clauses[] = "admin_id = '$admin_id'";
        }

        if (!empty($filters['action_type'])) {
            $action_type = mysqli_real_escape_string($this->connect, $filters['action_type']);
            $where_clauses[] = "action_type = '$action_type'";
        }

        if (!empty($filters['date_from'])) {
            $date_from = mysqli_real_escape_string($this->connect, $filters['date_from']);
            $where_clauses[] = "created_at >= '$date_from'";
        }

        if (!empty($filters['date_to'])) {
            $date_to = mysqli_real_escape_string($this->connect, $filters['date_to']);
            $where_clauses[] = "created_at <= '$date_to'";
        }

        $where_sql = !empty($where_clauses) ? "WHERE " . implode(" AND ", $where_clauses) : "";

        $sql = "SELECT COUNT(*) as total FROM activity_logs $where_sql";
        $result = mysqli_query($this->connect, $sql);
        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }
} 