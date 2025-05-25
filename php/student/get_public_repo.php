<?php
session_start();
header('Content-Type: application/json');
include_once '../Database.php';

// Fetch all public theses
$sql = "SELECT * FROM publicRepo WHERE Privacy = 'public' ORDER BY id DESC";
$result = $connect->query($sql);

$theses = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $theses[] = $row;
    }
    echo json_encode($theses);
} else {
    echo json_encode(['error' => 'Failed to fetch public theses.']);
}
$connect->close();
?>
