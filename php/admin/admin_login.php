
<?php
session_start();

// Load admin credentials from JSON file
$configPath = "../config/config.json";
if (!file_exists($configPath)) {
    die("Configuration file not found.");
}
$config = json_decode(file_get_contents($configPath), true);

$admin_email = $config['admin']['email'];
$admin_password = $config['admin']['password'];

// Get form data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Check credentials
if ($email === $admin_email && $password === $admin_password) {
    // Set session for admin
    $_SESSION['admin_logged_in'] = true;
    header("Location: ../views/admin_dashboard.php");
    exit();
} else {
    // Redirect back to login with error
    header("Location: ../views/admin_login.php?error=invalid_credentials");
    exit();
}
?>