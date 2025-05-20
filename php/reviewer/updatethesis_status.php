<?php
session_start();
include_once '../Database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $thesis_id = $_POST['thesis_id'];
    $status = $_POST['status'];

    $sql = "UPDATE repoTable SET status = ? WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("si", $status, $thesis_id);

    if ($stmt->execute()) {
        // If status is 'approved', select all from repoTable and insert into publicRepo if privacy is public
        if (strtolower($status) === 'approved') {
            $sql2 = "SELECT * FROM repoTable WHERE id = ?";
            $stmt2 = $connect->prepare($sql2);
            $stmt2->bind_param("i", $thesis_id);
            $stmt2->execute();
            $result = $stmt2->get_result();
            $thesis = $result->fetch_assoc();
            $stmt2->close();

            if ($thesis) {
                // Check if already in publicRepo
                $sql3 = "SELECT id FROM publicRepo WHERE title = ? AND student_id = ?";
                $stmt3 = $connect->prepare($sql3);
                $stmt3->bind_param("ss", $thesis['title'], $thesis['student_id']);
                $stmt3->execute();
                $stmt3->store_result();
                if ($stmt3->num_rows === 0) {
                    // Insert into publicRepo
                    $privacyValue = 'public';
                    $stmt4 = $connect->prepare("INSERT INTO publicRepo (student_id, fname, lname, title, abstract, ThesisFile, reviewer_id, Privacy) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt4->bind_param(
                        "ssssssss",
                        $thesis['student_id'],
                        $thesis['fname'],
                        $thesis['lname'],
                        $thesis['title'],
                        $thesis['abstract'],
                        $thesis['ThesisFile'],
                        $thesis['reviewer_id'],
                        $privacyValue
                    );
                    $stmt4->execute();
                    $stmt4->close();
                }
                $stmt3->close();
            }
        }
        echo json_encode(["status" => "success", "message" => "Thesis status updated successfully!"]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Failed to update thesis status."]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "failed", "message" => "Invalid request."]);
}
?>
