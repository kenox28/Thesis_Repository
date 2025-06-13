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
$chapter = isset($_POST['chapter']) ? trim($_POST['chapter']) : '';

// Only keep allowed fields based on chapter
if ($chapter === "1") {
    $project_objective = '';
    $significance_of_study = '';
    $system_analysis_and_design = '';
} elseif ($chapter === "2") {
    $significance_of_study = '';
    $system_analysis_and_design = '';
} elseif ($chapter === "3") {
    $system_analysis_and_design = '';
}
// For chapter 4, keep all fields

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
$date = date('F Y'); // e.g., June 2025

$phpWord = new PhpWord();
$fontStyle = ['name' => 'Times New Roman', 'size' => 12];
$center = ['alignment' => 'center'];
$paragraphStyle = [
    'spaceAfter' => 240, // double spacing
    'lineHeight' => 2.0
];

// 1. Title Page (APA)
$titleSection = $phpWord->addSection([
    'marginTop' => 1440,
    'marginBottom' => 1440,
    'marginLeft' => 1440,
    'marginRight' => 1440
]);

$header = $titleSection->addHeader();
$table = $header->addTable(['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'width' => 100 * 50]);
$row = $table->addRow();
$row->addCell(9000); // left cell (empty or for running head)
$row->addCell(1000)->addPreserveText('{PAGE}', array_merge($fontStyle, ['align' => 'right']));

for ($i = 0; $i < 7; $i++) $titleSection->addTextBreak(1);

$titleSection->addText(strtoupper($newtitle), array_merge($fontStyle, ['bold' => true]), $center);
$titleSection->addTextBreak(2);
$titleSection->addText('EASTERN VISAYAS STATE UNIVERSITY ORMOC CITY CAMPUS', $fontStyle, array_merge($center, $paragraphStyle));
$titleSection->addText('Computer Studies', $fontStyle, array_merge($center, $paragraphStyle));
$titleSection->addText('Bachelor of Science in Information Technology', $fontStyle, array_merge($center, $paragraphStyle));
$titleSection->addTextBreak(1);
$titleSection->addText($date, $fontStyle, $center);
$titleSection->addTextBreak(2);
$titleSection->addText($studentFullName, $fontStyle, $center);
$titleSection->addTextBreak(2);
$titleSection->addText($membersText, $fontStyle, $center);
$titleSection->addTextBreak(2);

function toTitleCase($str) {
    return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
}

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
