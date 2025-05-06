<?php
require_once "Database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$sql = "SELECT reviewer_id, fname, lname FROM reviewer";
$result = mysqli_query($connect, $sql);

$reviewers = [];

if ($result && mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$reviewers[] = [
			'reviewer_id' => $row['reviewer_id'],
			'reviewer_name' => $row['fname'] . ' ' . $row['lname']
		];
	}
}

header('Content-Type: application/json');
echo json_encode($reviewers);
?>
