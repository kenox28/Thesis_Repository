<?php
session_start();
include_once '../Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['student_id'])) {
        echo json_encode(['status' => 'failed', 'message' => 'Not logged in.']);
        exit;
    }
    if (!isset($_FILES['revised_pdf']) || !isset($_POST['thesis_id'])) {
        echo json_encode(['status' => 'failed', 'message' => 'Missing data.']);
        exit;
    }

    $student_id = $_SESSION['student_id'];
    $thesis_id = $_POST['thesis_id'];
    $file = $_FILES['revised_pdf'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileType = $file['type'];

    if ($fileType !== 'application/pdf') {
        echo json_encode(['status' => 'failed', 'message' => 'Only PDF files allowed.']);
        exit;
    }

    $uploadDir = '../../assets/revised/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $uniqueName = uniqid('', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
    $destinationPath = $uploadDir . $uniqueName;

    if (!move_uploaded_file($fileTmpName, $destinationPath)) {
        echo json_encode(['status' => 'failed', 'message' => 'Failed to upload file.']);
        exit;
    }

    // Get current max revision_num
    $sql = "SELECT MAX(revision_num) as max_rev FROM thesis_history WHERE thesis_id = ? AND student_id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "is", $thesis_id, $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $next_revision = ($row && $row['max_rev'] !== null) ? $row['max_rev'] + 1 : 1;

    // Insert into thesis_history
    $status = 'Student Revised';
    $notes = '';
    $sql2 = "INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes)
             VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt2 = mysqli_prepare($connect, $sql2);
    mysqli_stmt_bind_param($stmt2, "isissss", $thesis_id, $student_id, $next_revision, $uniqueName, $student_id, $status, $notes);
    mysqli_stmt_execute($stmt2);

    // Update repoTable with the new file
    $sql3 = "UPDATE repoTable SET ThesisFile = ? WHERE id = ? AND student_id = ?";
    $stmt3 = mysqli_prepare($connect, $sql3);
    mysqli_stmt_bind_param($stmt3, "sis", $uniqueName, $thesis_id, $student_id);
    mysqli_stmt_execute($stmt3);

    echo json_encode(['status' => 'success', 'message' => 'Revision uploaded and history updated!']);
}
?>
