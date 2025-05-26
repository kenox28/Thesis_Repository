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
           
            <input type="radio" id="radio1" name="role" value="Reviewer" required />
            <label for="radio1">Reviewer</label>
            
            <input type="radio" id="radio2" name="role" value="Student" required />
            <label for="radio2">Student</label>

            <label class="label" for="firstname">First Name</label>
            <input required type="text" name="fname" class="input" id="firstname" />
            

            <label class="label" for="lastname">Last Name</label>
            <input required type="text" name="lname" class="input" id="lastname" />
            

            <label class="label" for="email">Email</label>
            <input required type="email" name="email" class="input" id="email" />
            

            <label class="label" for="password">Password</label>
            <input required type="password" name="passw" class="input" id="password" />
            <div id="password-strength-bar-container">
              <div id="password-strength-bar"></div>
              <span id="password-strength-label"></span>
            </div>
            
			<label class="label" for="dateb">Birthdate</label>
            <input required type="date" name="bday" class="input" id="dateb" />
            

            <input type="radio" id="radio3" name="gender" value="Male" required />
            <label for="radio3">Male</label>

            <input type="radio" id="radio4" name="gender" value="Female" />
            <label for="radio4">Female</label>
            
            <button class="btn" id="login" type="submit">Sign Up</button>

            <div>
            <a href="student_login.php">Already have an account?</a>
            </div>
            <a href="landingpage.php">Back to home</a>
        </form>
    </body>
    <script src="../js/CreateAccount.js"></script>
</html>