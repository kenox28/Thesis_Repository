<?php
session_start();
include_once "Database.php";

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