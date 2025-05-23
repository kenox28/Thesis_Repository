<?php
session_start();
include_once "../Database.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if file and thesis_id are set
    if (isset($_FILES['revised_pdf']) && isset($_POST['thesis_id'])) {
        $thesis_id = $_POST['thesis_id'];
        $reviewer_id = $_SESSION['reviewer_id']; // Make sure this is set in session

        $file = $_FILES['revised_pdf'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $allowedTypes = ['application/pdf'];

        if (in_array($fileType, $allowedTypes)) {
            // Set upload directory
            $uploadDir = '../../assets/revised/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); 
            }

            $uniqueName = uniqid('', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $destinationPath = $uploadDir . $uniqueName;

            // Move file to the uploads folder
            if (move_uploaded_file($fileTmpName, $destinationPath)) {
                // Get original thesis info for student_id, fname, lname, title, abstract, ThesisFile
                $sql = "SELECT student_id, fname, lname, title, abstract, ThesisFile FROM repoTable WHERE id = ?";
                $stmt = mysqli_prepare($connect, $sql);
                mysqli_stmt_bind_param($stmt, "i", $thesis_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    $sql2 = "INSERT INTO revise_table (student_id, fname, lname, title, abstract, ThesisFile, reviewer_id, `status`) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, 'Revised')";
                    $stmt2 = mysqli_prepare($connect, $sql2);
                    if (!$stmt2) {
                        die("Prepare failed: " . mysqli_error($connect));
                    }
                    mysqli_stmt_bind_param($stmt2, "sssssss", 
                        $row['student_id'], $row['fname'], $row['lname'], $row['title'], $row['abstract'], $uniqueName, $reviewer_id
                    );
                    if (mysqli_stmt_execute($stmt2)) {
                        $sql_history = "SELECT MAX(revision_num) as max_rev FROM thesis_history WHERE thesis_id = ?";
                        $stmt_history = mysqli_prepare($connect, $sql_history);
                        mysqli_stmt_bind_param($stmt_history, "i", $thesis_id);
                        mysqli_stmt_execute($stmt_history);
                        $result_history = mysqli_stmt_get_result($stmt_history);
                        $row_history = mysqli_fetch_assoc($result_history);
                        $next_revision = ($row_history && $row_history['max_rev'] !== null) ? $row_history['max_rev'] + 1 : 1;

                        // 2. Insert the new revision into thesis_history
                        $sql_insert_history = "INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes)
                                               VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt_insert_history = mysqli_prepare($connect, $sql_insert_history);
                        $notes = ''; // You can add notes if needed
                        $status = 'Revised'; // Or whatever status you want
                        mysqli_stmt_bind_param(
                            $stmt_insert_history,
                            "isissss",
                            $thesis_id,
                            $row['student_id'],
                            $next_revision,
                            $uniqueName,
                            $reviewer_id,
                            $status,
                            $notes
                        );
                        mysqli_stmt_execute($stmt_insert_history);

                        // Update the status in repoTable to 'Revised'
                        $sql_update_repo = "UPDATE repoTable SET status = 'Revised' WHERE id = ?";
                        $stmt_update_repo = mysqli_prepare($connect, $sql_update_repo);
                        mysqli_stmt_bind_param($stmt_update_repo, "i", $thesis_id);
                        mysqli_stmt_execute($stmt_update_repo);

                        echo json_encode(["status" => "success", "message" => "Revised thesis uploaded successfully!"]);
                    } else {
                        echo json_encode(["status" => "failed", "message" => "Database insertion failed."]);
                    }
                } else {
                    echo json_encode(["status" => "failed", "message" => "Original thesis not found."]);
                }
            } else {
                echo json_encode(["status" => "failed", "message" => "Failed to upload file."]);
            }
        } else {
            echo json_encode(["status" => "failed", "message" => "Only PDF files are allowed."]);
        }
    } else {
        echo json_encode(["status" => "failed", "message" => "Please select a file."]);
    }
} else {
    echo json_encode(["status" => "failed", "message" => "Invalid request."]);
}
?>
