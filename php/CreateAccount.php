<?php
include "Database.php";
require_once __DIR__ . '/../vendor/autoload.php'; // For PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$role = mysqli_real_escape_string($connect, $_POST['Role']);
$fname = mysqli_real_escape_string($connect, $_POST['fname']);
$lname = mysqli_real_escape_string($connect, $_POST['lname']);
$email = mysqli_real_escape_string($connect, $_POST['email']);

// 1. Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "status" => "failed",
        "message" => "Invalid email format."
    ]);
    exit();
}

// 2. Check if domain has MX records
$domain = substr(strrchr($email, "@"), 1);
if (!checkdnsrr($domain, "MX")) {
    echo json_encode([
        "status" => "failed",
        "message" => "Email domain does not exist or cannot receive email."
    ]);
    exit();
}

// 3. Use MailboxLayer API for advanced validation
$access_key = '077ad33104db39bfa9b71cd938ea2c00'; // <-- Replace with your key
$validate_url = "http://apilayer.net/api/check?access_key=$access_key&email=" . urlencode($email) . "&smtp=1&format=1";
$api_response = file_get_contents($validate_url);
$api_result = json_decode($api_response, true);

if (!$api_result['format_valid'] || !$api_result['mx_found'] || $api_result['disposable'] || !$api_result['smtp_check']) {
    echo json_encode([
        "status" => "failed",
        "message" => "Email address is invalid, disposable, or undeliverable."
    ]);
    exit();
}

// 4. Check if email exists in both tables
$check_student = mysqli_query($connect, "SELECT * FROM Student WHERE email = '{$email}'");
$check_reviewer = mysqli_query($connect, "SELECT * FROM reviewer WHERE email = '{$email}'");
if (mysqli_num_rows($check_student) > 0 || mysqli_num_rows($check_reviewer) > 0) {
    echo json_encode(array(
        'status' => 'failed',
        'message' => 'Email already exists'
    ));
    exit();
}

// 5. Try to send a test email
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
    $mail->Subject = 'Welcome to Thesis Repository';
    $mail->Body    = "Hello $fname $lname,<br><br>Welcome to the Thesis Repository!";
    $mail->send();
} catch (Exception $e) {
    echo json_encode([
        "status" => "failed",
        "message" => "Failed to send email. Please use a real email address."
    ]);
    exit();
}

// 6. If email sent, create the account
$img = 'noprofile.png';
$userid = rand(time(), 1000);
if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
    $img = $_FILES['img']['name'];
    $tempimage = $_FILES['img']['tmp_name'];
    $folder = '../assets/ImageProfile/' . $img;
    move_uploaded_file($tempimage, $folder);
}

if ($role === 'Reviewer') {
    $sql1 = "INSERT INTO reviewer (reviewer_id, fname, lname, email, pass, profileImg, gender, bdate) 
            VALUES ('$userid', '$fname', '$lname', '$email', '$password', '$img', '$gender', '$dateb')";
    $result = mysqli_query($connect, $sql1);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Successfully created account"]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Failed to create account"]);
    }
} else {
    $sql1 = "INSERT INTO Student (student_id, fname, lname, email, passw, profileImg, gender, bdate) 
            VALUES ('$userid', '$fname', '$lname', '$email', '$password', '$img', '$gender', '$dateb')";
    $result = mysqli_query($connect, $sql1);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Successfully created account"]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Failed to create account"]);
    }
}
?>