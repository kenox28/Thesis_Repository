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
    
    if ($result_admin && mysqli_num_rows($result_admin) > 0) {
        $row = mysqli_fetch_assoc($result_admin);
        if (md5($pass) === $row['pass']) {
            
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['email'] = $row['email'];

            // Redirect to admin dashboard
            echo json_encode([
                "status" => "admin",
                "message" => "Admin login successful",
            ]);
            exit();
        }
    }

    // if ($result_admin && mysqli_num_rows($result_admin) > 0) {
    //     $row = mysqli_fetch_assoc($result_admin);
    //     if (md5($pass) === $row['pass']) {
    //         // Prepare data for Supabase
    //         $admin_id = $row['admin_id'];
    //         $email = $row['email'];
    //         $status = 'failed'; // Always failed initially
    //         $login_time = date('c'); // ISO8601
    //         $qrCode = bin2hex(random_bytes(8));

    //         // --- QR CODE GENERATION AND EMAIL SENDING ---

    //         // 1. Prepare the payload as admin_id only
    //         $qrPayload = $qrCode;

    //         // 2. Generate the QR code image using goqr.me API
    //         $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrPayload);

    //         // 3. Download the QR code image
    //         $qrImageData = file_get_contents($qrUrl);
    //         if ($qrImageData === false) {
    //             echo json_encode(["status" => "failed", "message" => "Failed to download QR code image."]);
    //             exit;
    //         }
    //         $qrFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
    //         file_put_contents($qrFile, $qrImageData);

    //         // 4. Send QR code to email (embedded)
    //         $mail = new PHPMailer(true);
    //         try {
    //             $mail->isSMTP();
    //             $mail->Host       = 'smtp.gmail.com';
    //             $mail->SMTPAuth   = true;
    //             $mail->Username   = 'iquenxzx@gmail.com';
    //             $mail->Password   = 'lews hdga hdvb glym';
    //             $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    //             $mail->Port       = 465;
    //             $mail->setFrom('iquenxzx@gmail.com', 'Thesis Repository');
    //             $mail->addAddress($email);
    //             $mail->isHTML(true);
    //             $mail->Subject = 'Admin Login QR Code';
    //             $mail->addEmbeddedImage($qrFile, 'qrimg', 'qrcode.png');
    //             $mail->Body = "
    //                 <div style='background: linear-gradient(135deg, #e9f0ff 0%, #f7faff 100%); padding: 32px 0; min-height: 100vh;'>
    //                   <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 480px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(25, 118, 165, 0.10);'>
    //                     <tr>
    //                       <td style='padding: 32px 32px 24px 32px; text-align: center;'>
    //                         <h2 style='color: #1976a5; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; font-size: 2rem; font-weight: 800; margin-bottom: 0.5em;'>Complete Your Login</h2>
    //                         <p style='color: #00246b; font-size: 1.1rem; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin-bottom: 1.2em;'>
    //                           Scan this QR code with the mobile app to complete your login:
    //                         </p>
    //                         <div style='margin: 24px 0;'>
    //                           <img src='cid:qrimg' alt='QR Code' style='width:180px;height:180px; border-radius: 12px; box-shadow: 0 2px 8px #cadcfc33;'>
    //                         </div>
    //                         <p style='color: #6a7ba2; font-size: 0.98rem; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif;'>
    //                           This code will expire soon for your security.
    //                         </p>
    //                       </td>
    //                     </tr>
    //                   </table>
    //                   <p style='text-align: center; color: #6a7ba2; font-size: 0.95rem; margin-top: 24px; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif;'>
    //                     If you did not request this, you can safely ignore this email.
    //                   </p>
    //                 </div>
    //             ";
    //             $mail->send();
    //             unlink($qrFile);
    //         } catch (Exception $e) {
    //             echo json_encode(["status" => "failed", "message" => "Email sending failed: " . $mail->ErrorInfo]);
    //             exit;
    //         }
    //         // --- END QR CODE GENERATION AND EMAIL SENDING ---

    //         $data = [
    //             'admin_id' => $admin_id,
    //             'email' => $email,
    //             'login_time' => $login_time,
    //             'status' => $status,    
    //             'qrcode' => $qrCode

    //         ];

    //         $supabaseUrl = 'https://dvxvnqfumnlpbekizzmj.supabase.co/rest/v1/admin_login_attempts';
    //         $supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImR2eHZucWZ1bW5scGJla2l6em1qIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDc5Mjg4MzgsImV4cCI6MjA2MzUwNDgzOH0.DzyJcNi2_nfpeclkdo2WfcA58iCPZmElEnPeAC-iMks';

    //         $ch = curl_init($supabaseUrl);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_POST, true);
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //             'Content-Type: application/json',
    //             'apikey: ' . $supabaseKey,
    //             'Authorization: Bearer ' . $supabaseKey
    //         ]);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    //         $response = curl_exec($ch);
    //         $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //         curl_close($ch);

    //         $maxWait = 60; // 5 minutes in seconds
    //         $interval = 3; // poll every 3 seconds
    //         $waited = 0;

    //         while ($waited < $maxWait) {
    //             $queryUrl = $supabaseUrl . "?admin_id=eq.$admin_id&email=eq." . urlencode($email) . "&order=login_time.desc&limit=1";
    //             $ch = curl_init($queryUrl);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //                 'apikey: ' . $supabaseKey,
    //                 'Authorization: Bearer ' . $supabaseKey
    //             ]);
    //             $response = curl_exec($ch);
    //             curl_close($ch);

    //             $data = json_decode($response, true);
    //             if (is_array($data) && count($data) > 0 && $data[0]['status'] === 'success') {
    //                 // Set session and return success
    //                 $_SESSION['admin_id'] = $row['admin_id'];
    //                 $_SESSION['fname'] = $row['fname'];
    //                 $_SESSION['lname'] = $row['lname'];
    //                 $_SESSION['email'] = $row['email'];
    //                 echo json_encode([
    //                     "status" => "admin",
    //                     "message" => "Admin login successful"
    //                 ]);
    //                 exit();
    //             }
    //             sleep($interval);
    //             $waited += $interval;
    //         }
    //         // If we reach here, QR was not scanned in time
    //         echo json_encode([
    //             "status" => "failed",
    //             "message" => "QR code was not scanned in time. Please try logging in again."
    //         ]);
    //         exit();
    //     }
    // }

    // Check if the user is a student
    $sql = "SELECT * FROM student WHERE email ='{$email}'";
    $result = mysqli_query($connect, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Check if account is locked
        if ($row['lockout_time'] && strtotime($row['lockout_time']) > time()) {
            $remaining = strtotime($row['lockout_time']) - time();
            $minutes = ceil($remaining / 60);
            echo json_encode([
                "status" => "failed",
                "message" => "Account locked due to multiple failed login attempts. Try again in $minutes minute(s)."
            ]);
            exit();
        }

        // Check password
        if (md5($pass) === $row['passw']) {
            // Check if password is still the default (first name)
            if ($row['passw'] === md5($row['fname'])) {
                // Set session for password reset
                $_SESSION['student_id'] = $row['student_id'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['lname'] = $row['lname'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['profileImg'] = $row['profileImg'];
                echo json_encode([
                    "status" => "reset_required",
                    "message" => "You must change your password on first login.",
                    "student_id" => $row['student_id']
                ]);
                exit();
            }
            // Reset failed_attempts and lockout_time
            $reset_sql = "UPDATE student SET failed_attempts = 0, lockout_time = NULL WHERE student_id = '{$row['student_id']}'";
            mysqli_query($connect, $reset_sql);

            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['profileImg'] = $row['profileImg'];

            echo json_encode([
                "status" => "success", 
                "message" => "log success"
            ]);
            exit();
        } else {
            // Increment failed_attempts
            $failed_attempts = $row['failed_attempts'] + 1;
            $lockout = false;
            $lockout_time = null;

            if ($failed_attempts >= 3) {
                // Lock account for 30 minutes
                $lockout_time = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                $lockout = true;
                $update_sql = "UPDATE student SET failed_attempts = $failed_attempts, lockout_time = '$lockout_time' WHERE student_id = '{$row['student_id']}'";
            } else {
                $update_sql = "UPDATE student SET failed_attempts = $failed_attempts WHERE student_id = '{$row['student_id']}'";
            }
            mysqli_query($connect, $update_sql);

            // Send security alert email if locked
            if ($lockout) {
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
                    $mail->addAddress($row['email']);
                    $mail->isHTML(true);
                    $mail->Subject = 'Security Alert: Multiple Failed Login Attempts';
                    $mail->Body    = "
                        <div style='background: linear-gradient(135deg, #e9f0ff 0%, #f7faff 100%); padding: 32px 0; min-height: 100vh;'>
                          <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 480px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(25, 118, 165, 0.10);'>
                            <tr>
                              <td style='padding: 32px 32px 24px 32px; text-align: center;'>
                                <div style='margin-bottom: 18px;'>
                                  <span style='display: inline-block; background: #ffe082; color: #b28704; border-radius: 50%; width: 54px; height: 54px; line-height: 54px; font-size: 2rem; box-shadow: 0 2px 8px #ffe08255;'>
                                    &#9888;
                                  </span>
                                </div>
                                <h2 style='color: #d84315; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; font-size: 2rem; font-weight: 800; margin-bottom: 0.5em;'>Security Alert</h2>
                                <p style='color: #00246b; font-size: 1.1rem; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin-bottom: 1.2em;'>
                                  Dear {$row['fname']},
                                </p>
                                <p style='color: #333; font-size: 1.05rem; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin-bottom: 1.2em;'>
                                  There have been <b>multiple failed login attempts</b> to your account.<br>
                                  <span style='color: #d84315; font-weight: 600;'>Your account has been temporarily locked for 30 minutes for your security.</span>
                                </p>
                                <br>
                                <p style='color: #6a7ba2; font-size: 0.98rem; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif;'>
                                  Best regards,<br>EVSU OCC Administration
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
                } catch (Exception $e) {
                    // Optionally log email error
                }
                echo json_encode([
                    "status" => "failed",
                    "message" => "Account locked due to multiple failed login attempts. Security alert sent to your email."
                ]);
                exit();
            } else {
                echo json_encode([
                    "status" => "failed",
                    "message" => "Wrong password or email"
                ]);
                exit();
            }
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

                // Update last_active timestamp
                $now = date('Y-m-d H:i:s');
                $updateLastActive = "UPDATE reviewer SET last_active='$now' WHERE reviewer_id='{$row['reviewer_id']}'";
                mysqli_query($connect, $updateLastActive);

                echo json_encode([
                    "status" => "reviewer",
                    "message" => "Reviewer login successful",
                ]);
                exit();
            }
        }
    }

    echo json_encode(["status" => "failed", "message" => "Wrong password or email"]);
} else {
    echo json_encode(["status" => "failed", "message" => "Enter both email and password"]);
}
?>