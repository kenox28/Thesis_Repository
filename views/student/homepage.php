<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Thesis Repository</title>
		
		<link rel="stylesheet" href="../../assets/css/homepage.css?v=1.0.1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	</head>
	<body>
		<aside>
			<div class="profile-section">
				<img src="../../assets/ImageProfile/<?php echo $_SESSION['profileImg']; ?>" alt="Profile" class="profile-image">
				<div class="profile-info">
					<h3><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></h3>
					<p>Student</p>
				</div>
			</div>
			<a href="homepage.php"><i class="fas fa-home"></i> Home</a>
			<a href="public_repo.php"><i class="fas fa-globe"></i> Public Repositories</a>
			<a href="/views/student/revisepage.php"><i class="fas fa-edit"></i> Revises</a>
			<a href="approve.php?id=<?php echo $_SESSION['student_id']; ?>"><i class="fas fa-check-circle"></i> Approved</a>
			<a href="/views/student/rejectpage.php"><i class="fas fa-times-circle"></i> Rejected</a>
			<a href="#" id="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
		</aside>
		<div class="main-content">
			<header>
				<h1>Upload Thesis</h1>
				<form action="#" id="thesisForm" enctype="multipart/form-data" class="header-upload-form">
					<input type="text" name="title" placeholder="Enter a title" required>
					<textarea required name="abstract" class="input" id="captadd" rows="1" placeholder="Abstract"></textarea>
					<input required type="file" name="docfile" id="docfile" class="input" accept=".doc,.docx,.pdf" />
					<select id="reviewerDropdown" name="reviewer_id" required>
						<option value="">Select Reviewer</option>
					</select>
					<input type="hidden" name="student_id" value="<?php echo $_SESSION['student_id']; ?>" />
					<input type="hidden" name="fname" value="<?php echo $_SESSION['fname']; ?>" />
					<input type="hidden" name="lname" value="<?php echo $_SESSION['lname']; ?>" />
					<input type="hidden" name="profileImg" value="<?php echo $_SESSION['profileImg'];?>"/>
					<button type="submit" id="captbtn" class="btn">UPLOAD</button>
				</form>
			</header>

			<main>
				<div id="PDFFILE"></div>
			</main>
		</div>
	</body>

	<script src="../../js/homepage.js?v=1.0.4"></script>
</html>
