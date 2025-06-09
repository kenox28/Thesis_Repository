<?php
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
        // Update student role
        $stmt_update = $connect->prepare("UPDATE student SET role = ? WHERE student_id = ?");
        $stmt_update->bind_param("si", $newRole, $id);
        $stmt_update->execute();

        echo json_encode(["status" => "success", "message" => "Moved from student to reviewer"]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Failed to insert into reviewer"]);
    }

    if ($stmt->num_rows > 0) {
        // Student found, move to reviewer
        $stmt->bind_result($fname, $lname, $email, $pass, $img, $role);
        $stmt->fetch();

        // Insert into reviewer
        $Approve = 0;
        $last_active = null;
        $stmt_insert = $connect->prepare("INSERT INTO reviewer (reviewer_id, fname, lname, email, pass, profileImg, Approve, last_active, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("isssssiss", $id, $fname, $lname, $email, $pass, $img, $Approve, $last_active, $role);
        $result_insert = $stmt_insert->execute();


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
        $role = 'student';
        $stmt_insert = $connect->prepare("INSERT INTO student (student_id, fname, lname, email, passw, profileImg, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("issssss", $id, $fname, $lname, $email, $pass, $img, $role);
        $result_insert = $stmt_insert->execute();

        if ($result_insert) {
            // Optionally, delete from reviewer
            $stmt_delete = $connect->prepare("DELETE FROM reviewer WHERE reviewer_id = ?");
            $stmt_delete->bind_param("i", $id);
            $stmt_delete->execute();

            echo json_encode(["status" => "success", "message" => "Moved from reviewer to student"]);
        } else {
            echo json_encode(["status" => "failed", "message" => "Failed to insert into student"]);
        }
        exit;
    }

    // Not found in either table
    echo json_encode(["status" => "failed", "message" => "ID not found in student or reviewer"]);
?>