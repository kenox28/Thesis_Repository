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
            // Prepare data for Supabase
            $admin_id = $row['admin_id'];
            $email = $row['email'];
            $status = 'failed'; // Always failed initially
            $login_time = date('c'); // ISO8601

            $data = [
                'admin_id' => $admin_id,
                'email' => $email,
                'login_time' => $login_time,
                'status' => $status
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

            $maxWait = 60; // 5 minutes in seconds
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

            // If not approved after 5 minutes
            echo json_encode([
                "status" => "failed",
                "message" => "Approval timed out. Please try again or contact the admin."
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
