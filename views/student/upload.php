<?php
session_start();

// Check if user is logged in as student or super admin in student view
if (!isset($_SESSION['student_id']) && (!isset($_SESSION['super_admin_id']) || !isset($_SESSION['super_admin_student_view']))) {
    header("Location: ../student_login.php");
    exit();
}

// Include the admin banner
include 'includes/admin_banner.php';

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
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<style>
			.checkbox-list {
				max-height: 200px;
				overflow-y: auto;
				border: 1px solid #cadcfc;
				border-radius: 8px;
				padding: 8px;
				background: #f7faff;
				margin-bottom: 1em;
			}
			.checkbox-list label {
				display: block;
				margin-bottom: 4px;
				cursor: pointer;
			}
		</style>
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
					<a href="approve_title.php">Thesis Progress</a>
                    <a href="approve_thesis.php">Approved</a>
					<a href="rejectpage.php">Rejected</a>
					<!-- <a href="revisepage.php">Revised</a> -->
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
						<input type="text" name="title" placeholder="Enter the reference title" required>
						<!-- <textarea
							required
							name="description"
							class="input"
							id="description"
							rows="4"
							placeholder="Enter the reference description (e.g., author, year, source, etc.)"></textarea> -->
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
						<div style="margin-bottom:1.2em;">
							<label for="reviewerSearch">Search Reviewer:</label>
							<input type="text" id="reviewerSearch" placeholder="Type to search reviewer..." autocomplete="off" style="width:100%;padding:0.7rem 1.2rem;border-radius:24px;border:1.5px solid #1976a5;font-size:1.08rem;background:#f7faff;outline:none;box-shadow:0 2px 8px #cadcfc22;">
							<div id="reviewerList" class="checkbox-list"></div>
						</div>
						<div style="margin-bottom:1.2em;">
							<label for="memberSearch">Search Members:</label>
							<input type="text" id="memberSearch" placeholder="Type to search members..." autocomplete="off" style="width:100%;padding:0.7rem 1.2rem;border-radius:24px;border:1.5px solid #1976a5;font-size:1.08rem;background:#f7faff;outline:none;box-shadow:0 2px 8px #cadcfc22;">
							<div id="memberList" class="checkbox-list"></div>
						</div>
						<button type="submit" id="captbtn" class="btn">Submit Proposal</button>
					</form>
				</section>
				<div id="apaResult" style="margin-top: 2em;"></div>
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
		<script src="../../js/upload.js?v=1.0.15"></script>

	</body>
</html>
