<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Document</title>
	</head>
	<body>
		<header>
			<a href="#">Home</a>
			<a href="#">Request</a>
			<a href="#">Views</a>
			<a href="#">Settings</a>
		</header>

		<form action="#" id="thesisForm" enctype="multipart/form-data">
			<input type="text" name="title" placeholder="Enter a title">
			<textarea
				required=""
				name="abstract"
				class="input"
				id="captadd"
				rows="4"
				placeholder="Enter the abstract"></textarea>

			<label for="docfile" class="label">UPLOADED THESIS</label>
			<input
				required
				type="file"
				name="docfile"
				id="docfile"
				class="input"
				accept=".doc,.docx,.pdf" />
			<!-- Hidden Inputs for session data -->
			<input
				type="hidden"
				name="student_id"
				value="<?php echo $_SESSION['student_id']; ?>" />
			<input
				type="hidden"
				name="fname"
				value="<?php echo $_SESSION['fname']; ?>" />
			<input
				type="hidden"
				name="lname"
				value="<?php echo $_SESSION['lname']; ?>" />
			<input
				type="hidden"
				name="profileImg"
				value="<?php echo $_SESSION['profileImg']; ?>" />

			<button type="submit" id="captbtn" class="btn">UPLOAD</button>
		</form>

		<main>
			<!-- All thesis and approved thesis will appear here -->
			<div id="userTableBody">
				<!-- Uploaded PDFs will be displayed here -->
			</div>
		</main>
	</body>

	<script src="../js/homepage.js"></script>
</html>
