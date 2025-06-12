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
    // If search is empty, return all approved reviewers (limited)
    if (empty($search)) {
        $query = "SELECT reviewer_id, fname, lname, email, approve, last_active 
                  FROM reviewer 
                  WHERE approve = 1
                  ORDER BY lname, fname 
                  LIMIT 20";
    } else {
        // Search with LOWER() for case-insensitive search among approved reviewers
        $query = "SELECT reviewer_id, fname, lname, email, approve, last_active 
                  FROM reviewer 
                  WHERE approve = 1
                  AND (
                      LOWER(CONCAT(fname, ' ', lname)) LIKE LOWER('%$search%')
                      OR LOWER(email) LIKE LOWER('%$search%')
                      OR LOWER(reviewer_id) LIKE LOWER('%$search%')
                  )
                  ORDER BY lname, fname 
                  LIMIT 20";
    }
    
    $result = mysqli_query($connect, $query);
    
    if (!$result) {
        error_log("Search query failed: " . mysqli_error($connect));
        throw new Exception("Database query failed");
    }
    
    $reviewers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $reviewers[] = [
            'reviewer_id' => $row['reviewer_id'],
            'fname' => $row['fname'],
            'lname' => $row['lname'],
            'email' => $row['email'],
            'approve' => $row['approve'],
            'last_active' => $row['last_active']
        ];
    }
    
    echo json_encode([
        "status" => "success",
        "data" => $reviewers,
        "count" => count($reviewers)
    ]);

} catch (Exception $e) {
    error_log("Search reviewers error: " . $e->getMessage());
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
} 