<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Document</title>
	</head>
	<body>
		<form action="#" id="CreateForm" enctype="multipart/form-data">
			<h1>CREATE ACCOUNT</h1>

			<input
				required=""
				type="text"
				name="fname"
				class="input"
				id="firstname" />
			<label class="label">First name</label>

			<input required="" type="text" name="lname" class="input" id="lastname" />
			<label class="label">Last name</label>

			<input required="" type="email" name="email" class="input" id="email" />
			<label class="label">Email</label>

			<input
				required=""
				type="password"
				name="passw"
				class="input"
				id="password" />
			<label class="label">Password</label>

			<input required="" type="date" name="bday" class="input" id="dateb" />

			<input type="radio" id="radio1" name="gender" value="Male" required />
			<label for="radio1">MALE</label>

			<input type="radio" id="radio2" name="gender" value="Female" />
			<label for="radio2">FEMALE</label>

			<input type="file" id="idimage" name="img" class="input" hidden />

			<button class="btn" id="login" type="submit">Create new account</button>
		</form>
		<a href="student_login.php">login</a>
	</body>
	<script src="../js/CreateAccount.js"></script>
</html>
