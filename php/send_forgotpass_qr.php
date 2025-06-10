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
$resetUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/Thesis_Repository/views/scan_qr_reset.php';

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
    $mail->Body = "
        <div style='background: linear-gradient(135deg, #e9f0ff 0%, #f7faff 100%); padding: 32px 0; min-height: 100vh;'>
          <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 480px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(25, 118, 165, 0.10);'>
            <tr>
              <td style='padding: 32px 32px 24px 32px; text-align: center;'>
                <h2 style='color: #1976a5; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; font-size: 2rem; font-weight: 800; margin-bottom: 0.5em;'>Password Reset Request</h2>
                <p style='color: #00246b; font-size: 1.1rem; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin-bottom: 1.2em;'>
                  Hello <b>$fname $lname</b>,
                </p>
                <p style='color: #1976a5; font-size: 1rem; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin-bottom: 1.2em;'>
                  Scan the QR code below to reset your password,<br>
                </p>
                <div style='margin: 24px 0;'>
                  <img src='cid:qrimg' alt='Reset QR Code' style='width:180px;height:180px; border-radius: 12px; box-shadow: 0 2px 8px #cadcfc33;'>
                </div>
                <p style='color: #6a7ba2; font-size: 0.98rem; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif;'>
                  This link will expire in <b>15 minutes</b>.
                </p>

              </td>
            </tr>
          </table>
          <p style='text-align: center; color: #6a7ba2; font-size: 0.95rem; margin-top: 24px; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif;'>
            If you did not request this, you can safely ignore this email.
          </p>
        </div>
    ";

    $mail->send();
    unlink($qrFile);
    echo json_encode(['status'=>'success']);
} catch (Exception $e) {
    echo json_encode(['status'=>'error', 'message'=>'Mailer Error: ' . $mail->ErrorInfo]);
}
?>