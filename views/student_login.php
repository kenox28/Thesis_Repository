<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Student Login - Thesis Repository System">
    <meta name="theme-color" content="#174D38">
    <title>Student Login - Thesis Repository</title>
    <link rel="stylesheet" href="../assets/css/Landing_Page.css">
    <link rel="stylesheet" href="../assets/css/Login_Form.css">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/icons/favicon.ico">
</head>
<body>
    <!-- <header>
        <a href="landingpage.php" aria-label="Return to Home">
            <img src="../assets/icons/home.png" alt="Home Icon">
        </a>
    </header> -->

    <main>
        <form action="#" id="loginForm" method="POST" autocomplete="off">
            <h1>Student Login</h1>
            <div class="form-group">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email"
                    required
                    autocomplete="email"
                    aria-label="Email address"
                >
            </div>
            <div class="form-group">
                <input 
                    type="password" 
                    name="passw" 
                    placeholder="Password"
                    required
                    autocomplete="current-password"
                    aria-label="Password"
                    minlength="8"
                >
            </div>
            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
                <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
            </div>
            <button type="submit">Login</button>
            <div class="form-footer">
                <p>Don't have an account? <a href="Create_form.php">Create Account</a></p>
            </div>
            <a href="landingpage.php">Back to home</a>
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Thesis Repository</p>
    </footer>

    <script src="../js/login.js?v=1.0.5"></script>
</body>
</html>