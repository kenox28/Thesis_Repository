<?php
header('Content-Type: application/json');
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data['email']) || !isset($data['token']) || !isset($data['qrDataUrl']) || !isset($data['resetUrl'])) {
    echo json_encode(['status'=>'error', 'message'=>'Missing parameters.']);
    exit;
}

$email = $data['email'];
$token = $data['token'];
$qrDataUrl = $data['qrDataUrl'];
$resetUrl = $data['resetUrl'];

// Save the token to your database for this email (implement this as needed)
// Example: store in password_resets table with expiry

// Extract base64 data from DataURL
if (preg_match('/^data:image\/(\w+);base64,/', $qrDataUrl, $type)) {
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
    //Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'iquenxzx@gmail.com';      // SMTP username
    $mail->Password   = 'lews hdga hdvb glym';     // SMTP password (App Password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom('iquenxzx@gmail.com', 'Thesis Repository');
    $mail->addAddress($email);

    // Attach QR code as inline image
    $mail->addEmbeddedImage($qrFile, 'qrimg', 'qrcode.png');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Request';
    $mail->Body    = "
        <p>Scan the QR code below to reset your password, or <a href='$resetUrl'>click here</a>:</p>
        <img src='cid:qrimg' alt='Reset QR Code' style='width:180px;height:180px;'><br>
        <p>This link will expire in 15 minutes.</p>
    ";

    $mail->send();
    unlink($qrFile); // Clean up temp file
    echo json_encode(['status'=>'success']);
} catch (Exception $e) {
    echo json_encode(['status'=>'error', 'message'=>'Mailer Error: ' . $mail->ErrorInfo]);
}
?>