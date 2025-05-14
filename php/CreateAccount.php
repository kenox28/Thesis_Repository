<?php
session_start();
include "Database.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$role = mysqli_real_escape_string($connect, $_POST['role']);
$fname = mysqli_real_escape_string($connect, $_POST['fname']);
$lname = mysqli_real_escape_string($connect, $_POST['lname']);
$email = mysqli_real_escape_string($connect, $_POST['email']);
$password_raw = $_POST['passw'];
$password = md5($password_raw); 
$gender = mysqli_real_escape_string($connect, $_POST['gender']);
$dateb = mysqli_real_escape_string($connect, $_POST['bday']);

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password) && !empty($gender) && !empty($dateb)) {
    // Set default image
    $img = 'noprofile.png';
    $userid = rand(time(), 1000);
    
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $img = $_FILES['img']['name'];
        $tempimage = $_FILES['img']['tmp_name'];
        $folder = '../assets/ImageProfile/' . $img;
        move_uploaded_file($tempimage, $folder);
    }

    // Check if email already exists in the appropriate table
    $table = ($role === 'Reviewer') ? 'reviewer' : 'Student';
    $sql2 = mysqli_query($connect, "SELECT * FROM $table WHERE email = '{$email}'");
    if (mysqli_num_rows($sql2) > 0) {
        echo json_encode(array(
            'status' => 'failed',
            'message' => 'Email already exists'
        ));
        exit();
    }

    // Insert new account into the appropriate table
    if ($role === 'Reviewer') {
        $sql1 = "INSERT INTO reviewer (reviewer_id, fname, lname, email, pass, profileImg, gender, bdate) 
                VALUES ('$userid', '$fname', '$lname', '$email', '$password', '$img', '$gender', '$dateb')";
    } else {
        $sql1 = "INSERT INTO Student (student_id, fname, lname, email, passw, profileImg, gender, bdate) 
                VALUES ('$userid', '$fname', '$lname', '$email', '$password', '$img', '$gender', '$dateb')";
    }

    $result = mysqli_query($connect, $sql1);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Successfully created account"]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Failed to create account"]);
    }
}
?>