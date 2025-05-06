<?php
session_start();
include_once "Database.php";

$email = mysqli_real_escape_string($connect, $_POST['email']);
$pass = $_POST['passw'];

if (!empty($email) && !empty($pass)) {
    $sql = "SELECT * FROM student WHERE email ='{$email}'";
    $result = mysqli_query($connect, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (md5($pass) === $row['passw']) { 

            echo json_encode(["status" => "success", "message" => "log success"]);

            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['profileImg'] = $row['profileImg'];

            exit();
        }
    }

    echo json_encode(["status" => "failed", "message" => "wrong password or email"]);
} else {
    echo json_encode(["status" => "failed", "message" => "enter both email and password"]);
}
?>
