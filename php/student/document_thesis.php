<?php
session_start();
header('Content-Type: application/json');
require_once '../../vendor/autoload.php';
include_once '../Database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

// Get form data
$student_id = $_SESSION['student_id'];
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$newtitle = isset($_POST['newtitle']) ? trim($_POST['newtitle']) : '';
$introduction = isset($_POST['introduction']) ? trim($_POST['introduction']) : '';
$project_objective = isset($_POST['project_objective']) ? trim($_POST['project_objective']) : '';
$significance_of_study = isset($_POST['significance_of_study']) ? trim($_POST['significance_of_study']) : '';
$system_analysis_and_design = isset($_POST['system_analysis_and_design']) ? trim($_POST['system_analysis_and_design']) : '';
$abstract = isset($_POST['abstract']) ? trim($_POST['abstract']) : ''; // If you have this field

// Get members_id from DB or POST
$members_id = '';
if (isset($_POST['members_id']) && !empty($_POST['members_id'])) {
    $members_id = $_POST['members_id'];
} else {
    $stmt = $connect->prepare("SELECT members_id FROM repoTable WHERE student_id=? AND title=?");
    $stmt->bind_param("ss", $student_id, $title);
    $stmt->execute();
    $stmt->bind_result($members_id);
    $stmt->fetch();
    $stmt->close();
}

$memberNames = [];
if (!empty($members_id)) {
    $ids = array_map('intval', explode(',', $members_id));
    $idsList = implode(',', $ids);
    $memberQuery = mysqli_query($connect, "SELECT fname, lname FROM student WHERE student_id IN ($idsList)");
    while ($row = mysqli_fetch_assoc($memberQuery)) {
        $memberNames[] = $row['fname'] . ' ' . $row['lname'];
    }
}
$membersText = !empty($memberNames) ? ("With members: " . implode(', ', $memberNames)) : '';

// Fetch student info for name, etc.
$stmt = $connect->prepare("SELECT fname, lname FROM student WHERE student_id=?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$stmt->bind_result($fname, $lname);
$stmt->fetch();
$stmt->close();

$studentFullName = $fname . ' ' . $lname;
$date = date('Y-m-d');

$phpWord = new PhpWord();
$fontStyle = ['name' => 'Times New Roman', 'size' => 12];
$center = ['alignment' => 'center'];

// 1. Title Page (APA)
$titleSection = $phpWord->addSection([
    'marginTop' => 1440,
    'marginBottom' => 1440,
    'marginLeft' => 1440,
    'marginRight' => 1440
]);
$titleSection->addText(strtoupper($newtitle), array_merge($fontStyle, ['bold' => true]), $center);
$titleSection->addTextBreak(2);
$titleSection->addText('EASTERN VISAYAS STATE UNIVERSITY ORMOC CITY CAMPUS', $fontStyle, $center);
$titleSection->addTextBreak(1);
$titleSection->addText('Computer Studies', $fontStyle, $center);
$titleSection->addTextBreak(1);
$titleSection->addText('Bachelor of Science in Information Technology', $fontStyle, $center);
$titleSection->addTextBreak(1);
$titleSection->addText($date, $fontStyle, $center);
$titleSection->addTextBreak(2);
$titleSection->addText($studentFullName, $fontStyle, $center);
$titleSection->addTextBreak(2);
$titleSection->addText($membersText, $fontStyle, $center);
$titleSection->addTextBreak(2);


// 2. Content Section (all content flows naturally)
$contentSection = $phpWord->addSection([
    'marginTop' => 1440,
    'marginBottom' => 1440,
    'marginLeft' => 1440,
    'marginRight' => 1440
]);

$contentSection->addText('Introduction', array_merge($fontStyle, ['bold' => true]));
$contentSection->addText($introduction, $fontStyle);
$contentSection->addTextBreak(1);

$contentSection->addText('Project Objective', array_merge($fontStyle, ['bold' => true]));
$contentSection->addText($project_objective, $fontStyle);
$contentSection->addTextBreak(1);

$contentSection->addText('Significance of Study', array_merge($fontStyle, ['bold' => true]));
$contentSection->addText($significance_of_study, $fontStyle);
$contentSection->addTextBreak(1);

$contentSection->addText('System Analysis and Design', array_merge($fontStyle, ['bold' => true]));
$contentSection->addText($system_analysis_and_design, $fontStyle);
$contentSection->addTextBreak(1);

// Save DOCX
$uploadDir = '../../assets/thesisfile/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
$uniqueBase = uniqid('rev_', true);
$docxName = $uniqueBase . '.docx';
$docxPath = $uploadDir . $docxName;
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save($docxPath);

// Convert DOCX to PDF
$libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe';
$command = "\"$libreOfficePath\" --headless --convert-to pdf --outdir \"$uploadDir\" \"$docxPath\"";
exec($command, $output, $resultCode);

$pdfName = pathinfo($docxName, PATHINFO_FILENAME) . '.pdf';
$pdfPath = $uploadDir . $pdfName;

if ($resultCode !== 0 || !file_exists($pdfPath)) {
    echo json_encode(["status" => "failed", "message" => "DOCX to PDF conversion failed."]);
    exit;
}

// Update thesis record in repoTable
$stmt2 = $connect->prepare("UPDATE repoTable SET ThesisFile=?, title=?, abstract=?, introduction=?, Project_objective=?, significance_of_study=?, system_analysis_and_design=?, updated=NOW(), status='Pending' WHERE student_id=? AND title=?");
$stmt2->bind_param("sssssssss", $pdfName, $newtitle, $abstract, $introduction, $project_objective, $significance_of_study, $system_analysis_and_design, $student_id, $title);

if ($stmt2->execute()) {
    // Optionally, add to thesis_history here
    //add to thesis_history
    $stmt4 = $connect->prepare("INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt4->bind_param("iisssss", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);
    $stmt4->execute();
    $stmt4->close();
    
    echo json_encode(['status' => 'success', 'message' => 'File updated and PDF generated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database update failed.']);
}
$stmt2->close();
$connect->close();
?>
