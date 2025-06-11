<?php
session_start();
<<<<<<< HEAD
include_once "../Database.php"; 

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

        $allowedTypes = ['application/pdf'];

        if (in_array($fileType, $allowedTypes)) {
            // Set upload directory
            $uploadDir = '../../assets/thesisfile/';
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
            echo json_encode(["status" => "failed", "message" => "Only PDF files are allowed."]);
        }
    } else {
        echo json_encode(["status" => "failed", "message" => "Please fill in all the  input."]);
    }
} else {
    echo json_encode(["status" => "failed", "message" => "Invalid."]);
}
?>
=======
require_once '../../vendor/autoload.php';
include_once '../Database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
// use Mpdf\Mpdf;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    // $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : '';
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $reviewer_id = isset($_POST['reviewer_id']) ? $_POST['reviewer_id'] : '';
    $member_ids = isset($_POST['member_ids']) ? $_POST['member_ids'] : [];
    $date = date('Y-m-d');
    if (!is_array($member_ids)) {
        $member_ids = [$member_ids];
    }

    if (empty($title) || empty($student_id) || empty($fname) || empty($lname) || empty($reviewer_id)) {
        echo json_encode(["status" => "failed", "message" => "Please fill in all the input."]);
        exit;
    }

    // Example: fetch reviewer name
    $reviewerName = '';
    $reviewerQuery = mysqli_query($connect, "SELECT fname, lname FROM Reviewer WHERE reviewer_id = '$reviewer_id'");
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
    $center = ['alignment' => 'center'];

    // APA Title (bold, title case)
    $section->addText(strtoupper($title), array_merge($fontStyle, ['bold' => true]), $center);
    $section->addTextBreak(2);

    // Student Name (First M. Last)


    // Affiliation, Department, and Course (all centered, APA style)
    $affiliation = 'EASTERN VISAYAS STATE UNIVERSITY ORMOC CITY CAMPUS';
    $department = 'Computer Studies';
    $course = 'Bachelor of Science in Information Technology';
    $section->addText($affiliation, $fontStyle, $center);
    $section->addTextBreak(1);
    $section->addText($department, $fontStyle, $center);
    $section->addTextBreak(1);
    $section->addText($course, $fontStyle, $center);
    $section->addTextBreak(1);


    // Instructor (e.g., Dr. John Smith)
    $instructor = $reviewerName ? $reviewerName : 'Instructor Name';
    $section->addText($instructor, $fontStyle, $center);
    $section->addTextBreak(1);

    // Due Date
    $section->addText($date, $fontStyle, $center);
    $section->addTextBreak(2);

    $section->addText($studentFullName, $fontStyle, $center);
    $section->addTextBreak(1);

    // Members (if any)
    if ($membersText) {
        $section->addText($membersText, $fontStyle, $center);
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

    // Path to LibreOffice executable
    $libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe';

    // Command to convert DOCX to PDF
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
    $chapter = '1';
    $status = 'pending';
    $message = '';
    $member_ids = implode(',', $member_ids);
    mysqli_stmt_bind_param($stmt, 'sssssssssssssss', $student_id, $fname, $lname, $title, $abstract, $introduction, $project_objective, $significance_of_study, $system_analysis_and_design, $chapter, $message, $member_ids, $pdfName, $reviewer_id, $status);
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
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
