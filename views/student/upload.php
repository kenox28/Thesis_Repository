<?php
session_start();
$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Upload Thesis</title>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<link rel="stylesheet" href="../../assets/css/homepage.css" />
	</head>
	<body>
		<div class="main-bg">
			<nav class="main-nav">
				<div class="nav-logo">
					<!-- Replace with your logo image if available -->
					<img src="../../assets/icons/logo.png" alt="Logo" class="logo-img" onerror="this.style.display='none'">
				</div>
				<div class="nav-links">
				<a href="public_repo.php">Home</a>
                    <a href="upload.php">Upload Thesis</a>
					<a href="homepage.php">Pending</a>
                    <a href="approve_thesis.php">Approved</a>
					<a href="rejectpage.php">Rejected</a>
					<a href="revisepage.php">Revised</a>
				</div>
				<div class="nav-avatar dropdown">
					<?php $hasProfileImg = isset($profileImg) && $profileImg !== 'noprofile.png' && !empty($profileImg); ?>
					<?php if ($hasProfileImg): ?>
						<img class="avatar-img" src="../../assets/ImageProfile/<?php echo htmlspecialchars($profileImg); ?>" alt="Profile" onerror="this.style.display='none'">
					<?php else: ?>
						<span class="avatar-initials"><?php echo strtoupper($_SESSION['fname'][0] . $_SESSION['lname'][0]); ?></span>
					<?php endif; ?>
					<span class="avatar-name"><?php echo $_SESSION['fname'][0]; ?><?php echo $_SESSION['lname'][0]; ?></span>
					<div class="dropdown-content">
						<a href="#" id="profile-link">Profile</a>
						<a href="#" id="logout-link">Logout</a>
					</div>
				</div>
			</nav>
			<main class="main-content">
				<section class="upload-card">
					<header>
						<h1 class="section-title">Upload Thesis</h1>
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
							accept="application/pdf" />
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
				</section>
			</main>
		</div>
		<div id="profile-modal" class="profile-modal">
			<div class="profile-modal-content">
				<span class="close-modal" id="closeProfileModal">&times;</span>
				<div class="profile-modal-header">
					<?php if ($hasProfileImg): ?>
						<img class="profile-modal-img" src="../../assets/ImageProfile/<?php echo htmlspecialchars($profileImg); ?>" alt="Profile" onerror="this.style.display='none'">
					<?php else: ?>
						<span class="profile-modal-initials"><?php echo strtoupper($_SESSION['fname'][0] . $_SESSION['lname'][0]); ?></span>
					<?php endif; ?>
					<div class="profile-modal-name"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></div>
					<div class="profile-modal-email"><?php echo $_SESSION['email']; ?></div>
				</div>
				<form id="profileImgFormModal" action="../../php/student/profile_img_upload.php" method="POST" enctype="multipart/form-data" style="margin-bottom: 10px;">
					<label class="profile-modal-upload-label">
						<input type="file" name="profileImg" accept="image/*" onchange="this.form.submit()" style="display:none;">
						<span class="profile-modal-upload-btn">Change Photo</span>
					</label>
				</form>
				<form id="profileImgDeleteFormModal" action="../../php/student/profile_img_delete.php" method="POST">
					<button type="submit" class="profile-modal-delete-btn">Remove Photo</button>
				</form>
			</div>
		</div>
		<div id="logout-modal" class="profile-modal">
			<div class="profile-modal-content" style="max-width:340px;text-align:center;">
				<span class="close-modal" id="closeLogoutModal">&times;</span>
				<div style="font-size:1.2rem;font-weight:600;margin-bottom:18px;">Are you sure you want to logout?</div>
				<button id="confirmLogoutBtn" class="profile-modal-delete-btn" style="margin-right:10px;">Yes, Logout</button>
				<button id="cancelLogoutBtn" class="profile-modal-upload-btn">Cancel</button>
			</div>
		</div>
		<script src="../../js/upload.js?v=1.0.6"></script>
	</body>
</html>
