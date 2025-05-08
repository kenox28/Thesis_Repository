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
			<a href="homepage.php">Home</a>
			<a href="public_repo.php">Public</a>
			<a href="view_Revise.php">Revise</a>
			<a href="view_thesis.php">Approve</a>
			<a href="view_thesis.php">Rejected</a>
			<a href="#" id="logout">logout</a>
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
				value="<?php echo $_SESSION['profileImg'];?>"/>
				
				<select id="reviewerDropdown" name="reviewer_id">
					<option value="">Select Reviewer</option>
				</select>


			<button type="submit" id="captbtn" class="btn">UPLOAD</button>
		</form>

		<main>
			<div id="PDFFILE">
			</div>
		</main>
	</body>

	<script src="../js/homepage.js"></script>
</html>
