<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Super Admin Login - Thesis Repository System">
    <meta name="theme-color" content="#174D38">
    <title>Super Admin Login - Thesis Repository</title>
    <link rel="stylesheet" href="../../assets/css/Login_Form.css?v=1.0.1">
    <link rel="icon" type="image/x-icon" href="../../assets/icons/favicon.ico">
</head>
<body>
    <main id="main">
        <form action="#" id="superAdminLoginForm" method="POST" autocomplete="off">
            <div class="form-group">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Super Admin Email"
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
                >
            </div>
            <button type="submit">Login</button>
            <div class="form-footer">
                <a href="../landingpage.php">Back to home</a>
            </div>
        </form>
    </main>
    <script src="../../js/super_admin_login.js"></script>
</body>
</html> 