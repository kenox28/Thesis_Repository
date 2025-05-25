<?php
session_start();
require_once '../config/database.php';

try {
    $stmt = $conn->prepare("
        SELECT t.*, s.fname, s.lname 
        FROM thesis t 
        JOIN student s ON t.student_id = s.student_id 
        WHERE t.status = 'public'
        ORDER BY t.upload_date DESC
    ");
    
    $stmt->execute();
    $theses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the results as JSON
    header('Content-Type: application/json');
    echo json_encode($theses);
    
} catch(PDOException $e) {
    // Return error message
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?> 