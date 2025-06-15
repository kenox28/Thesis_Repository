<?php
session_start();
header('Content-Type: application/json');
require_once '../../vendor/autoload.php';
include_once '../Database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

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
$old_title = isset($_POST['old_title']) ? trim($_POST['old_title']) : '';
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
    $stmt = $connect->prepare("SELECT members_id,reviewer_id FROM repoTable WHERE student_id=? AND title=?");
    $stmt->bind_param("ss", $student_id, $title);
    $stmt->execute();
    $stmt->bind_result($members_id, $reviewer_id);
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

$reviewerNames = [];
if (!empty($reviewer_id)) {
    $ids = json_decode($reviewer_id, true);
    if (is_array($ids)) {
        foreach ($ids as $rid) {
            $rid = $connect->real_escape_string($rid);
            $reviewerQuery = mysqli_query($connect, "SELECT fname, lname FROM reviewer WHERE reviewer_id = '$rid' LIMIT 1");
            if ($reviewerQuery && $row = mysqli_fetch_assoc($reviewerQuery)) {
                $reviewerNames[] = $row['fname'] . ' ' . $row['lname'];
            }
        }
    }
}

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

// APA paragraph style: justified, indented, double-spaced
$apaParagraphStyle = [
    'align' => 'both', // 'both' means justify
    'spaceAfter' => 240, // double spacing
    'indentation' => ['firstLine' => 720], // 720 twips = 0.5 inch
];

// Helper to process HTML into plain paragraphs
function htmlToParagraphs($html) {
    // Replace <br> with newlines
    $html = preg_replace('/<br\\s*\\/?>/i', "\n", $html);
    // Split by <p> or newlines
    $paras = preg_split('/<p[^>]*>|<\\/p>|\\n+/i', $html);
    $out = [];
    foreach ($paras as $p) {
        $p = trim(strip_tags($p));
        if ($p !== '') $out[] = $p;
    }
    return $out;
}

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
// Title (centered, not bold, not all caps capitalize first letter)
$titleSection->addText(ucwords($newtitle), array_merge($fontStyle, ['size' => 14]), $center);
$titleSection->addTextBreak(2);
// University name (bold, all caps, centered, multi-line)
$titleSection->addText('EASTERN VISAYAS STATE UNIVERSITY ORMOC CITY CAMPUS', array_merge($fontStyle, ['bold' => true, 'size' => 13]), $center);
$titleSection->addTextBreak(2);
$titleSection->addText('Computer Studies', $fontStyle, $center);
$titleSection->addTextBreak(1);


$titleSection->addText('Bachelor of Science in Information Technology', $fontStyle, $center);
$titleSection->addTextBreak(1);

$titleSection->addText('Reviewer:', $fontStyle, $center);
$titleSection->addTextBreak(1);
if (!empty($reviewerNames)) {
    foreach ($reviewerNames as $reviewer) {
        $titleSection->addText($reviewer, $fontStyle, $center);
    }
}
$titleSection->addTextBreak(1);
$titleSection->addText(date('Y-m-d'), $fontStyle, $center);
$titleSection->addTextBreak(2);
// Members
$titleSection->addText('With members:', $fontStyle, $center);
if (!empty($memberNames)) {
    foreach ($memberNames as $member) {
        $titleSection->addText($member, $fontStyle, $center);
    }
}
$titleSection->addTextBreak(2);

// 2. Content Section (all content flows naturally)
$contentSection = $phpWord->addSection([
    'marginTop' => 1440,
    'marginBottom' => 1440,
    'marginLeft' => 1440,
    'marginRight' => 1440
]);

// Introduction
$contentSection->addText('Introduction', array_merge($fontStyle, ['bold' => true]));
\PhpOffice\PhpWord\Shared\Html::addHtml($contentSection, $introduction, false, false);
$contentSection->addTextBreak(1);

// Project Objectives
$contentSection->addText('Project Objectives', array_merge($fontStyle, ['bold' => true]));
\PhpOffice\PhpWord\Shared\Html::addHtml($contentSection, $project_objective, false, false);
$contentSection->addTextBreak(1);

// Significance of the Study
$contentSection->addText('Significance of the Study', array_merge($fontStyle, ['bold' => true]));
\PhpOffice\PhpWord\Shared\Html::addHtml($contentSection, $significance_of_study, false, false);
$contentSection->addTextBreak(1);

// System Analysis and Design
$contentSection->addText('System Analysis and Design', array_merge($fontStyle, ['bold' => true]));
\PhpOffice\PhpWord\Shared\Html::addHtml($contentSection, $system_analysis_and_design, false, false);
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

if (!$stmt2) {
    echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $connect->error]);
    exit;
}
if (!$stmt2->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'Execute failed: ' . $stmt2->error]);
    exit;
}

if ($stmt2->affected_rows > 0) {
    // Fetch thesis_id from repoTable for thesis_history
    $stmt3 = $connect->prepare("SELECT id FROM repoTable WHERE student_id=? AND title=?");
    $stmt3->bind_param("ss", $student_id, $title);
    $stmt3->execute();
    $stmt3->bind_result($thesis_id);
    $stmt3->fetch();
    $stmt3->close();

    $next_revision = 1; // You may want to increment this based on history
    $newFileName = $pdfName;
    $revised_by = $studentFullName;
    $status = 'Pending';
    $notes = '';



    echo json_encode(['status' => 'success', 'message' => 'File updated and PDF generated successfully.']);
} else {
    // Debug: check if a row exists with student_id and old_title
    $debug_select = $connect->prepare("SELECT * FROM repoTable WHERE student_id=? AND title=?");
    $debug_select->bind_param("ss", $student_id, $old_title);
    $debug_select->execute();
    $debug_result = $debug_select->get_result();
    $row_exists = $debug_result && $debug_result->num_rows > 0;
    $debug_row = $row_exists ? $debug_result->fetch_assoc() : null;
    $debug_select->close();

    echo json_encode([
        'status' => 'error',
        'message' => 'No rows updated.',
        'student_id' => $student_id,
        'old_title' => $old_title,
        'title' => $title,
        'row_exists' => $row_exists,
        'row_data' => $debug_row,
        'mysql_error' => $stmt2->error
    ]);
}
$stmt2->close();
$connect->close();
?>
