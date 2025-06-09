<?php
    session_start();

    include '../Database.php';

    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $newRole = $data['role'];
    
    // First, try to find the student
    $stmt = $connect->prepare("SELECT fname, lname, email, passw, profileImg, role FROM student WHERE student_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Student found, move to reviewer
        $stmt->bind_result($fname, $lname, $email, $pass, $img, $role);
        $stmt->fetch();

        // Insert into reviewer
        $Approve = 0;
        $last_active = null;
        $stmt_insert = $connect->prepare("INSERT INTO reviewer (reviewer_id, fname, lname, email, pass, profileImg, Approve, last_active, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("isssssiss", $id, $fname, $lname, $email, $pass, $img, $Approve, $last_active, $newRole);
        $result_insert = $stmt_insert->execute();

        if ($result_insert) {
            // Delete from student
            $stmt_delete = $connect->prepare("DELETE FROM student WHERE student_id = ?");
            $stmt_delete->bind_param("i", $id);
            $stmt_delete->execute();


            // Log activity
            $admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;
            $stmt_log = $connect->prepare("INSERT INTO activity_log_admin (admin_id, activity, date) VALUES (?, ?, ?)");
            $activity = "Moved from student to reviewer";
            $date = date("Y-m-d H:i:s");
            $stmt_log->bind_param("sss", $admin_id, $activity, $date);
            $stmt_log->execute();

            echo json_encode(["status" => "success", "message" => "Moved from student to reviewer"]);
        } else {
            echo json_encode(["status" => "failed", "message" => "Failed to insert into reviewer"]);
        }
        exit;
    }

    // If not found in student, try to find in reviewer
    $stmt = $connect->prepare("SELECT fname, lname, email, pass, profileImg, role FROM reviewer WHERE reviewer_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Reviewer found, move to student
        $stmt->bind_result($fname, $lname, $email, $pass, $img, $role);
        $stmt->fetch();

        // Insert into student, set role to 'student'
        $stmt_insert = $connect->prepare("INSERT INTO student (student_id, fname, lname, email, passw, profileImg, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("issssss", $id, $fname, $lname, $email, $pass, $img, $newRole);
        $result_insert = $stmt_insert->execute();

        if ($result_insert) {
            // Delete from reviewer
            $stmt_delete = $connect->prepare("DELETE FROM reviewer WHERE reviewer_id = ?");
            $stmt_delete->bind_param("i", $id);
            $stmt_delete->execute();

            // Log activity
            $admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;
            $stmt_log = $connect->prepare("INSERT INTO activity_log_admin (admin_id, activity, date) VALUES (?, ?, ?)");
            $activity = "Moved from reviewer to student";
            $date = date("Y-m-d H:i:s");
            $stmt_log->bind_param("sss", $admin_id, $activity, $date);
            $stmt_log->execute();

            echo json_encode(["status" => "success", "message" => "Moved from reviewer to student"]);
        } else {
            echo json_encode(["status" => "failed", "message" => "Failed to insert into student"]);
        }
        exit;
    }

    // Not found in either table
    echo json_encode(["status" => "failed", "message" => "ID not found in student or reviewer"]);
?>