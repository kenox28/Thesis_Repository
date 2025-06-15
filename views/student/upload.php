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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
		<style>
			body {
				background: #f4f8ff;
			}
			.main-content {
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
				min-height: 90vh;
			}
			.upload-card {
				background: #fff;
				border-radius: 18px;
				box-shadow: 0 8px 32px #1976a522, 0 1.5px 0 #cadcfc;
				padding: 1.2rem 1.5rem 1.2rem 1.5rem;
				max-width: 680px;
				width: 100%;
				margin: 2rem auto 1rem auto;
				display: flex;
				flex-direction: column;
				align-items: center;
			}
			.section-title {
				font-size: 2.2rem;
				font-weight: 800;
				color: #0d47a1;
				margin-bottom: 0.7rem;
				letter-spacing: 0.5px;
				text-align: center;
			}
			.modern-label {
				font-weight: 600;
				color: #1976a5;
				margin-bottom: 0.1rem;
				font-size: 1.08rem;
				display: block;
			}
			.modern-helper {
				color: #789;
				font-size: 0.98rem;
				margin-bottom: 0.2rem;
				margin-top: -0.1rem;
				display: block;
			}
			.modern-search {
				width: 100%;
				padding: 0.6rem 1.1rem;
				border-radius: 24px;
				border: 1.5px solid #1976a5;
				font-size: 1.08rem;
				background: #f7faff;
				outline: none;
				box-shadow: 0 2px 8px #cadcfc22;
				margin-bottom: 0.3rem;
				transition: border 0.2s;
			}
			.modern-search:focus {
				border: 2px solid #2893c7;
			}
			.checkbox-list {
				border: 1px solid #e3eafc;
				border-radius: 10px;
				padding: 6px 8px;
				background: #f7faff;
				margin-bottom: 0.3em;
				width: 100%;
				box-shadow: 0 1px 4px #1976a511;
				transition: box-shadow 0.2s;
			}
			.checkbox-list label {
				display: flex;
				align-items: center;
				gap: 10px;
				font-size: 1.04rem;
				padding: 6px 0;
				border-radius: 6px;
				transition: background 0.2s;
				position: relative;
			}
			.checkbox-list label .fa-user, .checkbox-list label .fa-user-tie {
				color: #1976a5;
				margin-right: 6px;
				font-size: 1.1rem;
			}
			.checkbox-list label .fa-check-circle {
				color: #2893c7;
				margin-left: auto;
				font-size: 1.1rem;
				display: none;
			}
			.checkbox-list input[type="checkbox"]:checked + .fa-check-circle {
				display: inline-block;
			}
			.selected-container {
				display: flex;
				flex-wrap: wrap;
				gap: 8px;
				margin-top: 4px;
				margin-bottom: 0.2rem;
				width: 100%;
			}
			.selected-item .avatar-chip {
				margin-right: 7px;
			}
			.selected-item .fa-user, .selected-item .fa-user-tie {
				color: #1976a5;
				margin-right: 7px;
				font-size: 1.1rem;
			}
			.selected-item .remove-btn {
				margin-left: 8px;
			}
			.btn {
				background: #1976a5;
				color: #fff;
				border: none;
				border-radius: 8px;
				padding: 0.7rem 1.5rem;
				font-size: 1.08rem;
				font-weight: 700;
				margin-top: 0.7rem;
				box-shadow: 0 2px 8px #1976a522;
				cursor: pointer;
				transition: background 0.2s, box-shadow 0.2s;
			}
			.btn:hover {
				background: #2893c7;
				box-shadow: 0 4px 16px #1976a555;
			}
			@media (max-width: 900px) {
				.upload-card {
					max-width: 98vw;
					padding: 0.7rem 0.3rem;
				}
				.section-title {
					font-size: 1.3rem;
				}
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
					<a href="upload.php">Upload Documents</a>
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
						<a href="homepage.php">Pending</a>
						<a href="approve_title.php">Thesis Progress</a>
						<a href="approve_thesis.php">Approved</a>
						<a href="rejectpage.php">Rejected</a>
						<a href="#" id="logout-link">Logout</a>
					</div>
				</div>
			</nav>
			<main class="main-content">
				<div class="upload-card">
					<header>
						<h1 class="section-title"><i class="fa-solid fa-upload"></i> Upload Documents</h1>
					</header>
					<form action="#" id="thesisForm" enctype="multipart/form-data" style="width:100%;">
						<input type="hidden" name="student_id" value="<?php echo $_SESSION['student_id']; ?>">
						<input type="hidden" name="fname" value="<?php echo $_SESSION['fname']; ?>">
						<input type="hidden" name="lname" value="<?php echo $_SESSION['lname']; ?>">
						<div class="input-group">
							<!-- <span class="input-icon"><i class="fa-solid fa-heading"></i></span> -->
							<input type="text" name="title" placeholder="Enter Thesis Title" required class="modern-search" style="margin-bottom:1.2rem;">
						</div>
						<div style="margin-bottom:1.5em; width:100%;">
							<label for="reviewerSearch" class="modern-label"><i class="fa-solid fa-users-viewfinder"></i> Search Reviewer:</label>
							<span class="modern-helper">You can select up to 3 reviewers.</span>
							<div class="input-group">
								<span class="input-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
								<input type="text" id="reviewerSearch" placeholder="Type to search reviewer..." autocomplete="off" class="modern-search">
							</div>
							<div id="reviewerList" class="checkbox-list"></div>
							<div id="selectedReviewersContainer" class="selected-container"></div>
						</div>
						<div style="margin-bottom:1.5em; width:100%;">
							<label for="memberSearch" class="modern-label"><i class="fa-solid fa-user-group"></i> Search Collaborators:</label>
							<span class="modern-helper">You can select up to 3 collaborators.</span>
							<div class="input-group">
								<span class="input-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
								<input type="text" id="memberSearch" placeholder="Type to search members..." autocomplete="off" class="modern-search">
							</div>
							<div id="memberList" class="checkbox-list"></div>
							<div id="selectedCollaboratorsContainer" class="selected-container"></div>
						</div>
						<button type="submit" id="captbtn" class="btn"><i class="fa-solid fa-paper-plane"></i> Submit Proposal</button>
					</form>
				</div>
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
		<script src="../../js/upload.js?v=1.0.18"></script>

	</body>
</html>
