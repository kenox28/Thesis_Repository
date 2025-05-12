<?php
session_start();
include_once '../Database.php';

if (!isset($_GET['title'])) {
    echo json_encode(['error' => 'No title provided.']);
    exit;
}

$title = $_GET['title'];

$sql = "SELECT th.* 
        FROM thesis_history th
        JOIN repoTable rt ON th.thesis_id = rt.id
        WHERE rt.title = ?
        ORDER BY th.revision_num ASC";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "s", $title);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$history = [];
while ($row = mysqli_fetch_assoc($result)) {
    $history[] = $row;
}

echo json_encode($history);
?>