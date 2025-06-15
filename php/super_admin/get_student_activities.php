<?php
require_once __DIR__ . '/../Database.php';

// Disable error reporting for the client
error_reporting(0);
ini_set('display_errors', 0);

// Start output buffering to capture any unwanted output
ob_start();

// Set headers for JSON response
header('Content-Type: application/json');

try {
    // Get parameters from request
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

    // Items per page
    $itemsPerPage = 10;
    $offset = ($page - 1) * $itemsPerPage;

    // Ensure student_activity table exists
    include __DIR__ . '/create_student_activity_table.php';

    // Clear any output that might have been generated
    ob_clean();

    // Base query
    $baseQuery = "FROM student s
                  LEFT JOIN student_activity sa ON s.student_id = sa.student_id
                  LEFT JOIN publicRepo pr ON s.student_id = pr.student_id";

    // Add search condition if search term is provided
    $searchCondition = '';
    if (!empty($search)) {
        $searchCondition = " WHERE (s.student_id LIKE '%$search%' 
                             OR s.fname LIKE '%$search%' 
                             OR s.lname LIKE '%$search%' 
                             OR CONCAT(s.fname, ' ', s.lname) LIKE '%$search%')";
    }

    // Add filter condition
    $filterCondition = '';
    if ($filter !== 'all') {
        $isActive = $filter === 'active' ? 1 : 0;
        $filterCondition = !empty($searchCondition) ? 
            " AND sa.last_active >= DATE_SUB(NOW(), INTERVAL 7 DAY) = $isActive" :
            " WHERE sa.last_active >= DATE_SUB(NOW(), INTERVAL 7 DAY) = $isActive";
    }

    // Count total records
    $countQuery = "SELECT COUNT(DISTINCT s.student_id) as total $baseQuery $searchCondition $filterCondition";
    $countResult = mysqli_query($connect, $countQuery);
    if (!$countResult) {
        throw new Exception("Error counting records: " . mysqli_error($connect));
    }
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($totalRecords / $itemsPerPage);

    // Get student data
    $query = "SELECT 
                s.student_id,
                s.fname,
                s.lname,
                MAX(sa.activity_date) as last_active,
                COUNT(DISTINCT pr.id) as thesis_count,
                CASE 
                    WHEN MAX(sa.activity_date) >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1
                    ELSE 0
                END as is_active
              $baseQuery
              $searchCondition
              $filterCondition
              GROUP BY s.student_id, s.fname, s.lname
              ORDER BY last_active DESC
              LIMIT $offset, $itemsPerPage";

    $result = mysqli_query($connect, $query);
    if (!$result) {
        throw new Exception("Error fetching student data: " . mysqli_error($connect));
    }

    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = [
            'student_id' => $row['student_id'],
            'fname' => $row['fname'],
            'lname' => $row['lname'],
            'last_active' => $row['last_active'],
            'thesis_count' => $row['thesis_count'],
            'is_active' => (bool)$row['is_active']
        ];
    }

    echo json_encode([
        'status' => 'success',
        'students' => $students,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ]);

} catch (Exception $e) {
    // Clear any output that might have been generated
    ob_clean();
    
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

mysqli_close($connect);

// End output buffering and send the response
ob_end_flush();
?> 