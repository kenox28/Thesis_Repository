<!-- filepath: c:\xampp\htdocs\Thesis_Repository\views\Create_form.php -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Create Account</title>
        <link rel="stylesheet" href="../assets/css/Create_Form.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
	<!-- <header>
        <a href="landingpage.php" >
        <img src="../assets/icons/home.png" alt="Home Icon">
        </a>
    </header> -->

        <form action="#" method="POST" id="CreateForm" enctype="multipart/form-data">
            <h1>Create Account</h1>
           
            <input type="hidden" name="Role" value="Student" />

            <label class="label" for="firstname">First Name</label>
            <input required type="text" name="fname" class="input" id="firstname" />
            

            <label class="label" for="lastname">Last Name</label>
            <input required type="text" name="lname" class="input" id="lastname" />
            

            <label class="label" for="email">Email</label>
            <input required type="email" name="email" class="input" id="email" />
            <p style="font-size: 12px; color: blue; margin-top: 5px;">Password is the First Name in your first login in the system!</p>
            
            <button class="btn" id="login" type="submit">Sign Up</button>

            <div>
            <a href="student_login.php">Already have an account?</a>
            </div>
            <a href="landingpage.php">Back to home</a>
        </form>
    </body>
    <script src="../js/CreateAccount.js?v=1.0.2"></script>
</html>