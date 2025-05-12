<?php
session_start();
include "Database.php";



error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get and sanitize form data
$fname = mysqli_real_escape_string($connect, $_POST['first_name']);
$lname = mysqli_real_escape_string($connect, $_POST['last_name']);
$email = mysqli_real_escape_string($connect, $_POST['email']);
$password_raw = $_POST['password'];
$password = md5($password_raw); 


if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    // // Set default image
    // $img = 'noprofile.jpg';
    $userid = rand(time(), 1000);
    
    // if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
    //     $img = $_FILES['img']['name'];
    //     $tempimage = $_FILES['img']['tmp_name'];
    //     $folder = '../assets/ImageProfile' . $img;
    //     move_uploaded_file($tempimage, $folder);
    // }

    // Check if email already exists
    $sql2 = mysqli_query($connect, "SELECT * FROM reviewer WHERE email = '{$email}'");
    if (mysqli_num_rows($sql2) > 0) {
        echo json_encode(array(
            'status' => 'failed',
            'message' => 'Email already exists'
        ));
        exit();
    }

    // Insert new account
    $sql1 = "INSERT INTO reviewer (reviewer_id, fname, lname, email, pass) 
            VALUES ('$userid', '$fname', '$lname', '$email', '$password')";
    
    $result = mysqli_query($connect, $sql1);



    echo json_encode(["status" => "success", "message"=>"succesfuly Create account"]);
};
?>
