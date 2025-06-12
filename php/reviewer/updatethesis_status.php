<?php
session_start();
include_once '../Database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $thesis_id = $_POST['thesis_id'];
    $status = $_POST['status'];
    $message = $_POST['message'];
    $chapter = $_POST['chapter'];


    $sql = "UPDATE repoTable SET status = ?, message = ? WHERE id = ?";
    $stmt = $connect->prepare($sql);
    if (!$stmt) {
        echo json_encode(["status" => "failed", "message" => "Prepare failed: " . $connect->error]);
        exit;
    }
    $stmt->bind_param("ssi", $status, $message, $thesis_id);

    if ($stmt->execute()) {
        // If status is 'approved', insert into publicRepo if not already there
        if (strtolower($status) === 'approved') {
            $sql2 = "SELECT * FROM repoTable WHERE id = ?";
            $stmt2 = $connect->prepare($sql2);
            if ($stmt2) {
                $stmt2->bind_param("i", $thesis_id);
                $stmt2->execute();
                $result = $stmt2->get_result();
                $thesis = $result->fetch_assoc();
                $stmt2->close();

                if ($thesis) {
                    // Check if already in publicRepo
                    $sql3 = "SELECT id FROM publicRepo WHERE title = ? AND student_id = ?";
                    $stmt3 = $connect->prepare($sql3);
                    if ($stmt3) {
                        $stmt3->bind_param("ss", $thesis['title'], $thesis['student_id']);
                        $stmt3->execute();
                        $stmt3->store_result();
                        if ($stmt3->num_rows === 0) {
                            // Insert into publicRepo
                            $privacyValue = 'public';
                            $stmt4 = $connect->prepare("INSERT INTO publicRepo (student_id, fname, lname, title, abstract, ThesisFile, reviewer_id, Privacy) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            if ($stmt4) {
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
                        }
                        $stmt3->close();
                    }
                }
            }
        }

        // If status is 'continue', update chapter to 2
        if (strtolower($status) === 'continue') {
            // Get the current chapter from POST, default to 1 if not set
            $currentChapter = isset($_POST['chapter']) ? intval($_POST['chapter']) : 1;
            $nextChapter = $currentChapter + 1;
            if ($nextChapter == 5) {
                $statusif5 = 'pending';
                $sql5 = "UPDATE repoTable SET status = ?, chapter = ? WHERE id = ?";
                $stmt5 = $connect->prepare($sql5);
                if ($stmt5) {
                    $stmt5->bind_param("ssi", $statusif5, $nextChapter, $thesis_id);
                    $stmt5->execute();
                    $stmt5->close();
                }
            }else{
            $sql5 = "UPDATE repoTable SET chapter = ? WHERE id = ?";
            $stmt5 = $connect->prepare($sql5);
            if ($stmt5) {
                $stmt5->bind_param("si", $nextChapter, $thesis_id);
                    $stmt5->execute();
                    $stmt5->close();
                }
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