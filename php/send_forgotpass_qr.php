<?php
header('Content-Type: application/json');
require __DIR__ . '/../vendor/autoload.php';
require_once 'Database.php'; // adjust path if needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data['email']) || !isset($data['qrDataUrl'])) {
    echo json_encode(['status'=>'error', 'message'=>'Missing parameters.']);
    exit;
}

$email = $data['email'];
$qrDataUrl = $data['qrDataUrl'];

// 1. Check Student table
$stmt = $connect->prepare("SELECT student_id, fname, lname, 'student' as role FROM Student WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $fname, $lname, $role);
    $stmt->fetch();
    $stmt->close();
} else {
    $stmt->close();
    // 2. Check Reviewer table
    $stmt = $connect->prepare("SELECT reviewer_id, fname, lname, 'reviewer' as role FROM reviewer WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $fname, $lname, $role);
        $stmt->fetch();
        $stmt->close();
    } else {
        $stmt->close();
        echo json_encode(['status'=>'error', 'message'=>'Email not found.']);
        exit;
    }
}

// 3. Generate reset link with id and role
$resetUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/thesis_Repository/views/scan_qr_reset.php';

// 4. Save QR code image
if (preg_match('/^data:image\\/\\w+;base64,/', $qrDataUrl)) {
    $qrData = substr($qrDataUrl, strpos($qrDataUrl, ',') + 1);
    $qrData = base64_decode($qrData);
    $qrFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
    file_put_contents($qrFile, $qrData);
} else {
    echo json_encode(['status'=>'error', 'message'=>'Invalid QR code data.']);
    exit;
}

$mail = new PHPMailer(true);
try {
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'iquenxzx@gmail.com';
    $mail->Password   = 'lews hdga hdvb glym';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('iquenxzx@gmail.com', 'Thesis Repository');
    $mail->addAddress($email);

    $mail->addEmbeddedImage($qrFile, 'qrimg', 'qrcode.png');
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Request';
    $mail->Body    = "
        <p>Hello $fname $lname,</p>
        <p>Scan the QR code below to reset your password, or <a href='$resetUrl?id=$id&role=$role'>click here</a>:</p>
        <img src='cid:qrimg' alt='Reset QR Code' style='width:180px;height:180px;'><br>
        <p>This link will expire in 15 minutes.</p>
    ";

    $mail->send();
    unlink($qrFile);
    echo json_encode(['status'=>'success']);
} catch (Exception $e) {
    echo json_encode(['status'=>'error', 'message'=>'Mailer Error: ' . $mail->ErrorInfo]);
}
?>