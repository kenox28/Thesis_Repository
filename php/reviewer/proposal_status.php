<?php
session_start();
include_once '../Database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $thesis_id = $_POST['thesis_id'];
    $status = $_POST['status'];
    $message = $_POST['message'];

    $sql = "UPDATE repoTable SET status = ?, message = ? WHERE id = ?";
    $stmt = $connect->prepare($sql);
    if (!$stmt) {
        echo json_encode(["status" => "failed", "message" => "Prepare failed: " . $connect->error]);
        exit;
    }
    $stmt->bind_param("ssi", $status, $message, $thesis_id);

    if ($stmt->execute()) {
        // Only handle 'continue' and 'reject' statuses
        if (strtolower($status) === 'continue') {
            $sql5 = "UPDATE repoTable SET chapter = ? WHERE id = ?";
            $stmt5 = $connect->prepare($sql5);
            if ($stmt5) {
                $chapterValue = '1';
                $stmt5->bind_param("si", $chapterValue, $thesis_id);
                $stmt5->execute();
                $stmt5->close();
            }
        }
        // No extra logic for 'reject', just update status and message
        echo json_encode(["status" => "success", "message" => "Thesis status updated successfully!"]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Failed to update thesis status."]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "failed", "message" => "Invalid request."]);
}
?>
