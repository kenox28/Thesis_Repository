<?php
// Assuming you are fetching the uploaded thesis data from the database
include_once 'Database.php';

// Select the data of uploaded thesis
$sql = "SELECT * FROM repoTable";
$result = mysqli_query($connect, $sql);

$uploads = [];
while ($row = mysqli_fetch_assoc($result)) {
    $uploads[] = $row;  // Add each row to the uploads array
}

echo json_encode($uploads);
?>
