<?php
session_start();
header('Content-Type: application/json');
include_once '../Database.php';

if (!isset($_SESSION['reviewer_id'])) {
    echo json_encode(["error" => "Reviewer not logged in"]);
    exit();
}

$reviewer_id = $_SESSION['reviewer_id'];

// Pending
$stmt = $connect->prepare("SELECT COUNT(*) FROM repoTable WHERE reviewer_id = ? AND status = 'pending'");
$stmt->bind_param("s", $reviewer_id);
$stmt->execute();
$stmt->bind_result($pending);
$stmt->fetch();
$stmt->close();

// Approved
$stmt = $connect->prepare("SELECT COUNT(*) FROM repoTable WHERE reviewer_id = ? AND status = 'approved'");
$stmt->bind_param("s", $reviewer_id);
$stmt->execute();
$stmt->bind_result($approved);
$stmt->fetch();
$stmt->close();

// Rejected
$stmt = $connect->prepare("SELECT COUNT(*) FROM repoTable WHERE reviewer_id = ? AND status = 'rejected'");
$stmt->bind_param("s", $reviewer_id);
$stmt->execute();
$stmt->bind_result($rejected);
$stmt->fetch();
$stmt->close();

// Public Repo (approved and in publicRepo)
$stmt = $connect->prepare("SELECT COUNT(*) FROM publicRepo WHERE reviewer_id = ? AND Privacy = 'public'");
$stmt->bind_param("s", $reviewer_id);
$stmt->execute();
$stmt->bind_result($public);
$stmt->fetch();
$stmt->close();

echo json_encode([
    "pending" => $pending,
    "approved" => $approved,
    "rejected" => $rejected,
    "public" => $public
]);
?>