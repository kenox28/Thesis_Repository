<?php
session_start();
include_once '../Database.php';

if (!isset($_GET['thesis_id'])) {
    echo json_encode(['error' => 'No thesis_id provided.']);
    exit;
}

$thesis_id = $_GET['thesis_id'];

$sql = "SELECT th.*, CONCAT(r.lname, ', ', r.fname) AS reviewer_name
        FROM thesis_history th
        LEFT JOIN reviewer r ON th.revised_by = r.reviewer_id
        WHERE th.thesis_id = ?
        ORDER BY th.revision_num ASC";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "i", $thesis_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$history = [];
while ($row = mysqli_fetch_assoc($result)) {
    $history[] = $row;
}

echo json_encode($history);
?>
