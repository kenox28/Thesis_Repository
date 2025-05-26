<?php
session_start();
require_once '../php/Database.php'; // adjust path as needed

$student_id = $_GET['id'] ?? '';
$showForm = false;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (!$student_id || !$password || !$confirm) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    } else {
        // Check if student exists
        $stmt = $connect->prepare("SELECT email FROM Student WHERE student_id=?");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $error = "Invalid student ID.";
        } else {
            // Update password
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $connect->prepare("UPDATE Student SET passw=? WHERE student_id=?");
            $stmt2->bind_param("ss", $hashed, $student_id);
            if ($stmt2->execute()) {
                $success = "Password updated successfully! You can now <a href='student_login.php'>login</a>.";
            } else {
                $error = "Failed to update password.";
            }
            $stmt2->close();
        }
        $stmt->close();
    }
} else {
    // On GET: check if student_id is valid
    if ($student_id) {
        $stmt = $connect->prepare("SELECT fname, lname FROM Student WHERE student_id=?");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $error = "Invalid student ID.";
        } else {
            $showForm = true;
        }
        $stmt->close();
    } else {
        $error = "No student ID provided.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/Login_Form.css">
    <style>
        .reset-container { max-width: 400px; margin: 60px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 16px #1976a522; padding: 32px 24px; }
        .reset-container h2 { color: #1976a5; text-align: center; }
        .reset-container input { width: 100%; padding: 10px; margin: 10px 0 18px 0; border-radius: 6px; border: 1.5px solid #1976a5; }
        .reset-container button { width: 100%; background: #1976a5; color: #fff; padding: 10px; border: none; border-radius: 6px; font-weight: 600; }
        .reset-container .msg { text-align: center; margin-bottom: 12px; color: #e74c3c; }
        .reset-container .success { color: #1976a5; }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password</h2>
        <?php if ($error): ?>
            <div class="msg"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="msg success"><?= $success ?></div>
        <?php elseif ($showForm): ?>
        <form method="POST">
            <input type="hidden" name="student_id" value="<?= htmlspecialchars($student_id) ?>">
            <input type="password" name="password" placeholder="New Password" required minlength="8">
            <input type="password" name="confirm" placeholder="Confirm Password" required minlength="8">
            <button type="submit">Change Password</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
