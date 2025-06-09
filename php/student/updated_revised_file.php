<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated.']);
    exit;
}

// Check if file and title are present
if (!isset($_FILES['revised_file']) || !isset($_POST['title']) || !isset($_POST['newtitle']) || !isset($_POST['abstract'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing file, title, new title, or abstract.']);
    exit;
}

$title = $_POST['title'];
$newtitle = $_POST['newtitle'];
$abstract = $_POST['abstract'];
$student_id = $_SESSION['student_id'];
$file = $_FILES['revised_file'];

// Validate file type
if ($file['type'] !== 'application/pdf') {
    echo json_encode(['status' => 'error', 'message' => 'Only PDF files are allowed.']);
    exit;
}

require_once '../../php/Database.php'; // $connect should be defined here

if (!$connect || $connect->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// 1. Find the thesis in repoTable
$stmt = $connect->prepare("SELECT id, ThesisFile FROM repoTable WHERE title=? AND student_id=?");
$stmt->bind_param("ss", $title, $student_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Thesis not found.']);
    $stmt->close();
    $connect->close();
    exit;
}

$stmt->bind_result($thesis_id, $oldFileName);
$stmt->fetch();
$stmt->close();

// 2. Delete the old file in thesisfile/ if it exists
$oldFilePath = '../../assets/thesisfile/' . $oldFileName;
if (!empty($oldFileName) && file_exists($oldFilePath)) {
    unlink($oldFilePath);
}

// 3. Upload the new file to thesisfile/
$timestamp = time();
$safeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', $newtitle);
$thesisfileDir = '../../assets/thesisfile/';
$revisedDir = '../../assets/revised/';
if (!is_dir($thesisfileDir)) {
    mkdir($thesisfileDir, 0777, true);
}
if (!is_dir($revisedDir)) {
    mkdir($revisedDir, 0777, true);
}
$newFileName = $safeTitle . '_' . $student_id . '_' . $timestamp . '.pdf';
$thesisfileTarget = $thesisfileDir . $newFileName;
$revisedTarget = $revisedDir . $newFileName;

if (move_uploaded_file($file['tmp_name'], $thesisfileTarget)) {
    // Copy the file to revised/ for history
    copy($thesisfileTarget, $revisedTarget);

    // 4. Update ThesisFile, title, and abstract in repoTable
    $stmt2 = $connect->prepare("UPDATE repoTable SET ThesisFile=?, title=?, abstract=?, updated=NOW(), status='Pending' WHERE id=? AND student_id=?");
    if (!$stmt2) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $connect->error]);
        $connect->close();
        exit;
    }
    $stmt2->bind_param("ssssi", $newFileName, $newtitle, $abstract, $thesis_id, $student_id);

    if ($stmt2->execute()) {
        // 5. Insert into thesis_history (file_name is in revised/)
        $stmt3 = $connect->prepare("SELECT MAX(revision_num) FROM thesis_history WHERE thesis_id=?");
        $stmt3->bind_param("i", $thesis_id);
        $stmt3->execute();
        $stmt3->bind_result($max_rev);
        $stmt3->fetch();
        $stmt3->close();
        $next_revision = ($max_rev !== null) ? $max_rev + 1 : 1;

        $revised_by = $_SESSION['fname'] . ' ' . $_SESSION['lname'];
        $status = 'Revised';
        $notes = '';

        $stmt4 = $connect->prepare("INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt4->bind_param("iisssss", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);
        $stmt4->execute();
        $stmt4->close();

        echo json_encode(['status' => 'success', 'message' => 'File updated and history recorded successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database update failed.']);
    }
    $stmt2->close();
    $connect->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to upload file.']);
}
?>
