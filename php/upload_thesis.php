<?php
session_start();
include_once "Database.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['docfile']) && isset($_POST['abstract']) && isset($_POST['student_id']) && isset($_POST['title'])) {
        $student_id = $_POST['student_id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $reviewer_id = $_POST['reviewer_id'];

        $abstract = mysqli_real_escape_string($connect, $_POST['abstract']);
        $title = mysqli_real_escape_string($connect, $_POST['title']);

        $file = $_FILES['docfile'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        if (in_array($fileType, $allowedTypes)) {
            // Set upload directory
            $uploadDir = '../assets/thesisfile/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); 
            }

            $uniqueName = uniqid('', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $destinationPath = $uploadDir . $uniqueName;

            // Move file to the uploads folder
            if (move_uploaded_file($fileTmpName, $destinationPath)) {
                // Insert data into the database
                $sql = "INSERT INTO repoTable (student_id, fname, lname, title, abstract, ThesisFile, reviewer_id, status) 
                        VALUES ('$student_id', '$fname', '$lname', '$title', '$abstract', '$uniqueName', '$reviewer_id', 'Pending')";
                if (mysqli_query($connect, $sql)) {
                    echo json_encode(["status" => "success", "message" => "Thesis uploaded successfully!"]);
                } else {
                    echo json_encode(["status" => "failed", "message" => "Database insertion failed."]);
                }
            } else {
                echo json_encode(["status" => "failed", "message" => "Faile upload"]);
            }
        } else {
            echo json_encode(["status" => "failed", "message" => "Only PDF, DOC, DOCX."]);
        }
    } else {
        echo json_encode(["status" => "failed", "message" => "Please fill in all the  input."]);
    }
} else {
    echo json_encode(["status" => "failed", "message" => "Invalid."]);
}
?>
