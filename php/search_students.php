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

// Get search term from query parameter
$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';

try {
    // If search is empty, return all students (limited)
    if (empty($search)) {
        $query = "SELECT student_id, fname, lname, email, profileImg, created_at 
                  FROM student 
                  ORDER BY lname, fname 
                  LIMIT 20";
    } else {
        // Search with LOWER() for case-insensitive search
        $query = "SELECT student_id, fname, lname, email, profileImg, created_at 
                  FROM student 
                  WHERE LOWER(CONCAT(fname, ' ', lname)) LIKE LOWER('%$search%')
                  OR LOWER(email) LIKE LOWER('%$search%')
                  OR LOWER(student_id) LIKE LOWER('%$search%')
                  ORDER BY lname, fname 
                  LIMIT 20";
    }
    
    $result = mysqli_query($connect, $query);
    
    if (!$result) {
        error_log("Search query failed: " . mysqli_error($connect));
        throw new Exception("Database query failed");
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
        "data" => $students,
        "count" => count($students)
    ]);

} catch (Exception $e) {
    error_log("Search students error: " . $e->getMessage());
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
} 