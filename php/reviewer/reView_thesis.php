<?php
session_start();
include_once '../Database.php';        

if (!isset($_SESSION['reviewer_id'])) {
    echo json_encode(["error" => "Reviewer not logged in"]);
    exit();
}

$reviewer_id = $_SESSION['reviewer_id'];

// Fetch the role
$roleResult = mysqli_query($connect, "SELECT role FROM reviewer WHERE reviewer_id = '$reviewer_id'");
$roleRow = $roleResult ? mysqli_fetch_assoc($roleResult) : null;
$currentRole = $roleRow ? $roleRow['role'] : 'reviewer';

$sql = "SELECT * FROM repoTable WHERE JSON_CONTAINS(reviewer_id, '\"$reviewer_id\"') AND status = 'Pending' AND (Chapter = '1' or Chapter = '2' or Chapter = '3' or Chapter = '4')";
$result = mysqli_query($connect, $sql);

$uploads = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $student_id = $row['student_id'];
        $profileImgQuery = "SELECT profileImg FROM student WHERE student_id = '$student_id'";
        $profileImgResult = $connect->query($profileImgQuery);
        $profileImgRow = $profileImgResult ? $profileImgResult->fetch_assoc() : null;
        $row['profileImg'] = $profileImgRow ? $profileImgRow['profileImg'] : null;
        $uploads[] = $row;
    }
    $permRes = mysqli_query($connect, "SELECT permissions FROM reviewer WHERE reviewer_id = '$reviewer_id'");
    $permRow = $permRes ? mysqli_fetch_assoc($permRes) : null;
    $permissions = [];
    if ($permRow && $permRow['permissions']) {
        $permVal = $permRow['permissions'];
        $decoded = json_decode($permVal, true);
        if (is_array($decoded)) {
            $permissions = $decoded;
        } else {
            // fallback: comma-separated string
            $permissions = array_map('trim', explode(',', $permVal));
        }
    }
    echo json_encode([
        "role" => $currentRole,
        "uploads" => $uploads,
        "permissions" => $permissions
    ]);
} else {
    echo json_encode(["error" => "Query failed"]);
}
?>