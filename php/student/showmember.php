<?php
require_once "../Database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$sql = "SELECT student_id, fname, lname FROM student";
$result = mysqli_query($connect, $sql);

$members = [];

if ($result && mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$members[] = [
			'student_id' => $row['student_id'],
			'student_name' => $row['fname'] . ' ' . $row['lname']
		];
	}
}

header('Content-Type: application/json');
echo json_encode($members);
?>
