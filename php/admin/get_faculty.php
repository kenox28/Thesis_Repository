<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../Database.php';

header('Content-Type: application/json');

$query = "SELECT * FROM reviewer WHERE role = 'Faculty'";
$result = mysqli_query($connect, $query);

$faculty = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $faculty[] = $row;
    }
    echo json_encode(['status' => 'success', 'faculty' => $faculty]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch faculty',
        'error' => mysqli_error($connect)
    ]);
}
?>
