<?php
require_once '../Database.php'; // Use the correct path to your DB connection
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['reviewer_id'])) {
    echo json_encode([
        'pending' => 0,
        'approved' => 0,
        'rejected' => 0,
        'public' => 0,
        'error' => 'Not logged in'
    ]);
    exit;
}

$reviewer_id = $_SESSION['reviewer_id'];

try {
    $counts = [];

    // Pending (case-insensitive)
    $stmt = $connect->prepare("SELECT COUNT(*) FROM repoTable WHERE LOWER(status) = 'pending' AND reviewer_id = ?");
    $stmt->bind_param("s", $reviewer_id);
    $stmt->execute();
    $stmt->bind_result($pending);
    $stmt->fetch();
    $counts['pending'] = $pending;
    $stmt->close();

    // Approved (case-insensitive)
    $stmt = $connect->prepare("SELECT COUNT(*) FROM repoTable WHERE LOWER(status) = 'approved' AND reviewer_id = ?");
    $stmt->bind_param("s", $reviewer_id);
    $stmt->execute();
    $stmt->bind_result($approved);
    $stmt->fetch();
    $counts['approved'] = $approved;
    $stmt->close();

    // Rejected (case-insensitive)
    $stmt = $connect->prepare("SELECT COUNT(*) FROM repoTable WHERE LOWER(status) = 'rejected' AND reviewer_id = ?");
    $stmt->bind_param("s", $reviewer_id);
    $stmt->execute();
    $stmt->bind_result($rejected);
    $stmt->fetch();
    $counts['rejected'] = $rejected;
    $stmt->close();

    // Public Repo (from publicRepo table)
    $stmt = $connect->prepare("SELECT COUNT(*) FROM publicRepo WHERE Privacy = 'public' AND reviewer_id = ?");
    $stmt->bind_param("s", $reviewer_id);
    $stmt->execute();
    $stmt->bind_result($public);
    $stmt->fetch();
    $counts['public'] = $public;
    $stmt->close();

    echo json_encode($counts);
} catch (Exception $e) {
    echo json_encode([
        'pending' => 0,
        'approved' => 0,
        'rejected' => 0,
        'public' => 0,
        'error' => $e->getMessage()
    ]);
}
?>