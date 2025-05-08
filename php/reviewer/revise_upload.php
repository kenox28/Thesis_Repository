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
                    // Insert data into the revise_table
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
