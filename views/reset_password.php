<?php
session_start();
require_once '../php/Database.php'; // adjust path as needed

$user_id = $_GET['id'] ?? '';
$showForm = false;
$error = '';
$success = '';
$userType = ''; // 'student' or 'reviewer'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $password_raw = $_POST['password'] ?? '';
    $confirm_raw = $_POST['confirm'] ?? '';
    $password = md5($password_raw);
    $confirm = md5($confirm_raw);

    if (!$user_id || !$password_raw || !$confirm_raw) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($password_raw) < 8) {
        $error = "Password must be at least 8 characters.";
    } else {
        // Try Student first
        $stmt = $connect->prepare("SELECT email FROM Student WHERE student_id=?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt2 = $connect->prepare("UPDATE Student SET passw=? WHERE student_id=?");
            $stmt2->bind_param("ss", $password, $user_id);
            if ($stmt2->execute()) {
                $success = "window.location.href = 'student_login.php';";
            } else {
                $error = "Failed to update password.";
            }
            $stmt2->close();
            $userType = 'student';
        } else {
            // Try Reviewer
            $stmt2 = $connect->prepare("SELECT email FROM reviewer WHERE reviewer_id=?");
            $stmt2->bind_param("s", $user_id);
            $stmt2->execute();
            $stmt2->store_result();
            if ($stmt2->num_rows > 0) {
                $stmt3 = $connect->prepare("UPDATE reviewer SET pass=? WHERE reviewer_id=?");
                $stmt3->bind_param("ss", $password, $user_id);
                if ($stmt3->execute()) {
                    $success = "window.location.href = 'student_login.php';";
                } else {
                    $error = "Failed to update password.";
                }
                $stmt3->close();
                $userType = 'reviewer';
            } else {
                $error = "Invalid user ID.";
            }
            $stmt2->close();
        }
        $stmt->close();
    }
} else {
    // On GET: check if user_id is valid
    if ($user_id) {
        // Try Student first
        $stmt = $connect->prepare("SELECT fname, lname FROM Student WHERE student_id=?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $showForm = true;
            $userType = 'student';
        } else {
            // Try Reviewer
            $stmt2 = $connect->prepare("SELECT fname, lname FROM reviewer WHERE reviewer_id=?");
            $stmt2->bind_param("s", $user_id);
            $stmt2->execute();
            $stmt2->store_result();
            if ($stmt2->num_rows > 0) {
                $showForm = true;
                $userType = 'reviewer';
            } else {
                $error = "Invalid user ID.";
            }
            $stmt2->close();
        }
        $stmt->close();
    } else {
        $error = "No user ID provided.";
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
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password</h2>
        <form method="POST">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
            <input type="password" name="password" placeholder="New Password" required minlength="8">
            <input type="password" name="confirm" placeholder="Confirm Password" required minlength="8">
            <button type="submit">Change Password</button>
        </form>
    </div>
    <?php if ($success): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Password Changed!',
            text: 'Your password has been updated successfully.',
            confirmButtonColor: '#1976a5'
        }).then(() => {
            window.location.href = 'student_login.php';
        });
    </script>
    <?php elseif ($error): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: <?= json_encode($error) ?>,
            confirmButtonColor: '#1976a5'
        });
    </script>
    <?php endif; ?>
</body>
</html>
