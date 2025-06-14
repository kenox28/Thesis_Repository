<?php
session_start();
require_once '../../vendor/autoload.php';
// require_once '../../vendor/autoload.php';
include_once '../Database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
// use Mpdf\Mpdf;

header('Content-Type: application/json');

if (!class_exists('\PhpOffice\PhpWord\PhpWord')) {
    die('PhpWord is not installed or autoloaded!');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    // $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : '';
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $reviewer_ids = isset($_POST['reviewer_ids']) ? $_POST['reviewer_ids'] : [];
    if (!is_array($reviewer_ids)) {
        $reviewer_ids = [$reviewer_ids];
    }
    $member_ids = isset($_POST['member_ids']) ? $_POST['member_ids'] : [];
    $date = date('Y-m-d');
    if (!is_array($member_ids)) {
        $member_ids = [$member_ids];
    }

    if (empty($title) || empty($student_id) || empty($fname) || empty($lname) || empty($reviewer_ids)) {
        echo json_encode(["status" => "failed", "message" => "Please fill in all the input."]);
        exit;
    }

    // Example: fetch reviewer name
    $reviewerName = '';
    $reviewerQuery = mysqli_query($connect, "SELECT fname, lname FROM Reviewer WHERE reviewer_id = '$reviewer_ids[0]'");
    if ($reviewerQuery && $row = mysqli_fetch_assoc($reviewerQuery)) {
        $reviewerName = $row['fname'] . ' ' . $row['lname'];
    }

    $studentFullName = $fname . ' ' . $lname;

    // Fetch member names
    $memberNames = [];
    if (!empty($member_ids)) {
        $ids = array_map('intval', $member_ids);
        $idsList = implode(',', $ids);
        $memberQuery = mysqli_query($connect, "SELECT fname, lname FROM student WHERE student_id IN ($idsList)");
        while ($row = mysqli_fetch_assoc($memberQuery)) {
            $memberNames[] = $row['fname'] . ' ' . $row['lname'];
        }
    }
    $membersText = !empty($memberNames) ? ("With members: " . implode(', ', $memberNames)) : '';

    // Generate APA-style Title Proposal Page with PHPWord
    $phpWord = new PhpWord();
    $section = $phpWord->addSection([
        'marginTop' => 1440, // 1 inch
        'marginBottom' => 1440,
        'marginLeft' => 1440,
        'marginRight' => 1440
    ]);
    $fontStyle = [
        'name' => 'Times New Roman',
        'size' => 12,
    ];
    $paragraphStyle = [
        'spaceAfter' => 0,
        'lineHeight' => 2.0 // double spacing
    ];
    $center = ['alignment' => 'center'];

    // Remove running head and author note. Only add page number in header.
    $header = $section->addHeader();
    $headerTable = $header->addTable(['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'width' => 100 * 50]);
    $tableRow = $headerTable->addRow();
    $tableRow->addCell(9000); // empty cell for left
    // Add page number (right-aligned)
    $tableRow->addCell(1000)->addPreserveText('{PAGE}', array_merge($fontStyle, ['align' => 'right']));

    for ($i = 0; $i < 7; $i++) $section->addTextBreak(1);
    // Title (centered, not bold, not all caps, capitalize first letter)
    $section->addText(ucwords($title), array_merge($fontStyle, ['size' => 14]), $center);
    $section->addTextBreak(2);
    // University name (bold, all caps, centered)
    $section->addText('EASTERN VISAYAS STATE UNIVERSITY ORMOC CITY CAMPUS', array_merge($fontStyle, ['bold' => true, 'size' => 13]), $center);
    $section->addTextBreak(2);
    $section->addText('Computer Studies', $fontStyle, $center);
    $section->addTextBreak(1);
    $section->addText('Bachelor of Science in Information Technology', $fontStyle, $center);
    $section->addTextBreak(1);
    // Reviewer(s)
    $section->addText('Reviewer:', $fontStyle, $center);
    $section->addTextBreak(1);
    if (!empty($reviewer_ids)) {
        foreach ($reviewer_ids as $rid) {
            $rid = $connect->real_escape_string($rid);
            $reviewerQuery = mysqli_query($connect, "SELECT fname, lname FROM reviewer WHERE reviewer_id = '$rid' LIMIT 1");
            if ($reviewerQuery && $row = mysqli_fetch_assoc($reviewerQuery)) {
                $section->addText($row['fname'] . ' ' . $row['lname'], $fontStyle, $center);
            }
        }
    }
    $section->addTextBreak(1);
    $section->addText($date, $fontStyle, $center);
    $section->addTextBreak(2);
    $section->addText($studentFullName, $fontStyle, $center);
    $section->addTextBreak(1);
    // Members (if any)
    if (!empty($memberNames)) {
        $section->addText('With members:', $fontStyle, $center);
        foreach ($memberNames as $member) {
            $section->addText($member, $fontStyle, $center);
        }
        $section->addTextBreak(2);
    }

    $uploadDir = '../../assets/thesisfile/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uniqueBase = uniqid('apa_', true);
    $docxName = $uniqueBase . '.docx';
    $docxPath = $uploadDir . $docxName;
    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($docxPath);

    $libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe';

    $command = "\"$libreOfficePath\" --headless --convert-to pdf --outdir \"$uploadDir\" \"$docxPath\"";
    exec($command, $output, $resultCode);

    $pdfName = pathinfo($docxName, PATHINFO_FILENAME) . '.pdf';
    $pdfPath = $uploadDir . $pdfName;

    if ($resultCode !== 0 || !file_exists($pdfPath)) {
        echo json_encode(["status" => "failed", "message" => "DOCX to PDF conversion failed."]);
        exit;
    }

    // Save to database (save PDF file name)
    $sql = "INSERT INTO repoTable (student_id, fname, lname, title, abstract, introduction, Project_objective, significance_of_study, system_analysis_and_design, Chapter, message,members_id, ThesisFile, reviewer_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $sql);
    $abstract = '';
    $introduction = '';
    $project_objective = '';
    $significance_of_study = '';
    $system_analysis_and_design = '';
    $chapter = '0';
    $status = 'pending';
    $message = '';
    $member_ids = implode(',', $member_ids);
    $reviewer_ids_json = json_encode($reviewer_ids);
    mysqli_stmt_bind_param($stmt, 'sssssssssssssss', $student_id, $fname, $lname, $title, $abstract, $introduction, $project_objective, $significance_of_study, $system_analysis_and_design, $chapter, $message, $member_ids, $pdfName, $reviewer_ids_json, $status);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        echo json_encode([
            "status" => "success",
            "message" => "Proposal Title has been submitted successfully!",
            "file_docx" => $docxName,
            "file_pdf" => $pdfName
        ]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Database insertion failed."]);
    }
    exit;
} else {
    echo json_encode(["status" => "failed", "message" => "Invalid request method."]);
    exit;
}