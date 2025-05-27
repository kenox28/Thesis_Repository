<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once "Database.php";
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;


$email = mysqli_real_escape_string($connect, $_POST['email']);
$pass = $_POST['passw'];

if (!empty($email) && !empty($pass)) {
    // Check if the user is an admin
    $sql_admin = "SELECT * FROM admin WHERE email = '{$email}'";
    $result_admin = mysqli_query($connect, $sql_admin);
    
    // if ($result_admin && mysqli_num_rows($result_admin) > 0) {
    //     $row = mysqli_fetch_assoc($result_admin);
    //     if (md5($pass) === $row['pass']) {
    //         $_SESSION['admin_id'] = $row['admin_id'];
    //         $_SESSION['fname'] = $row['fname'];
    //         $_SESSION['lname'] = $row['lname'];
    //         $_SESSION['email'] = $row['email'];

    //         // Redirect to admin dashboard
    //         echo json_encode([
    //             "status" => "admin",
    //             "message" => "Admin login successful",
    //         ]);
    //         exit();
    //     }
    // }

    if ($result_admin && mysqli_num_rows($result_admin) > 0) {
        $row = mysqli_fetch_assoc($result_admin);
        if (md5($pass) === $row['pass']) {
            // Prepare data for Supabase
            $admin_id = $row['admin_id'];
            $email = $row['email'];
            $status = 'failed'; // Always failed initially
            $login_time = date('c'); // ISO8601
            $qrCode = bin2hex(random_bytes(8));

            // --- QR CODE GENERATION AND EMAIL SENDING ---

            // 1. Prepare the payload as admin_id only
            $qrPayload = $qrCode;

            // 2. Generate the QR code image using goqr.me API
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrPayload);

            // 3. Download the QR code image
            $qrImageData = file_get_contents($qrUrl);
            if ($qrImageData === false) {
                echo json_encode(["status" => "failed", "message" => "Failed to download QR code image."]);
                exit;
            }
            $qrFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
            file_put_contents($qrFile, $qrImageData);

            // 4. Send QR code to email (embedded)
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'iquenxzx@gmail.com';
                $mail->Password   = 'lews hdga hdvb glym';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                $mail->setFrom('iquenxzx@gmail.com', 'Thesis Repository');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Admin Login QR Code';
                $mail->addEmbeddedImage($qrFile, 'qrimg', 'qrcode.png');
                $mail->Body    = "<p>Scan this QR code with the mobile app to complete your login:</p><img src='cid:qrimg' alt='QR Code'>";
                $mail->send();
                unlink($qrFile);
            } catch (Exception $e) {
                echo json_encode(["status" => "failed", "message" => "Email sending failed: " . $mail->ErrorInfo]);
                exit;
            }
            // --- END QR CODE GENERATION AND EMAIL SENDING ---

            $data = [
                'admin_id' => $admin_id,
                'email' => $email,
                'login_time' => $login_time,
                'status' => $status,    
                'qrcode' => $qrCode

            ];

            $supabaseUrl = 'https://dvxvnqfumnlpbekizzmj.supabase.co/rest/v1/admin_login_attempts';
            $supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImR2eHZucWZ1bW5scGJla2l6em1qIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDc5Mjg4MzgsImV4cCI6MjA2MzUwNDgzOH0.DzyJcNi2_nfpeclkdo2WfcA58iCPZmElEnPeAC-iMks';

            $ch = curl_init($supabaseUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'apikey: ' . $supabaseKey,
                'Authorization: Bearer ' . $supabaseKey
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $maxWait = 10; // 5 minutes in seconds
            $interval = 3; // poll every 3 seconds
            $waited = 0;

            while ($waited < $maxWait) {
                $queryUrl = $supabaseUrl . "?admin_id=eq.$admin_id&email=eq." . urlencode($email) . "&order=login_time.desc&limit=1";
                $ch = curl_init($queryUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'apikey: ' . $supabaseKey,
                    'Authorization: Bearer ' . $supabaseKey
                ]);
                $response = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($response, true);
                if (is_array($data) && count($data) > 0 && $data[0]['status'] === 'success') {
                    // Set session and return success
                    $_SESSION['admin_id'] = $row['admin_id'];
                    $_SESSION['fname'] = $row['fname'];
                    $_SESSION['lname'] = $row['lname'];
                    $_SESSION['email'] = $row['email'];
                    echo json_encode([
                        "status" => "admin",
                        "message" => "Admin login successful"
                    ]);
                    exit();
                }
                sleep($interval);
                $waited += $interval;
            }
            // If we reach here, QR was not scanned in time
            echo json_encode([
                "status" => "failed",
                "message" => "QR code was not scanned in time. Please try logging in again."
            ]);
            exit();
        }
    }

    // Check if the user is a student
    $sql = "SELECT * FROM student WHERE email ='{$email}'";
    $result = mysqli_query($connect, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (md5($pass) === $row['passw']) {
            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['profileImg'] = $row['profileImg'];

           echo json_encode([
            "status" => "success", 
            "message" => "log success"]);
            
            exit();
        }
    } else {
        // Check if the user is a reviewer
        $sql1 = "SELECT * FROM reviewer WHERE email ='{$email}'";
        $result1 = mysqli_query($connect, $sql1);
        if ($result1 && mysqli_num_rows($result1) > 0) {
            $row = mysqli_fetch_assoc($result1);
            if (md5($pass) === $row['pass']) {
               
                $_SESSION['reviewer_id'] = $row['reviewer_id'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['lname'] = $row['lname'];
                $_SESSION['email'] = $row['email'];

                echo json_encode([
                    "status" => "reviewer",
                    "message" => "Reviewer login successful",
                   
                ]);
                exit();}
            
        }
    }

    echo json_encode(["status" => "failed", "message" => "Wrong password or email"]);
} else {
    echo json_encode(["status" => "failed", "message" => "Enter both email and password"]);
}
?>