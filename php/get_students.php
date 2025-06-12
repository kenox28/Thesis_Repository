<?php
session_start();
require_once "Database.php";

// Check if user is super admin
if (!isset($_SESSION['super_admin_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit();
}

try {
    $query = "SELECT student_id, fname, lname, email, profileImg, created_at 
              FROM student 
              ORDER BY lname, fname";
    
    $result = mysqli_query($connect, $query);
    
    if (!$result) {
        throw new Exception(mysqli_error($connect));
    }
    
    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = [
            'student_id' => $row['student_id'],
            'fname' => $row['fname'],
            'lname' => $row['lname'],
            'email' => $row['email'],
            'profileImg' => $row['profileImg'] ?? 'noprofile.png',
            'created_at' => $row['created_at']
        ];
    }
    
    echo json_encode([
        "status" => "success",
        "data" => $students
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
} 