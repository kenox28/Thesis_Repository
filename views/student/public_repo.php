<?php
session_start();

// Check if user is logged in as a student or super admin in student view
if (!isset($_SESSION['student_id']) && (!isset($_SESSION['super_admin_id']) || !isset($_SESSION['super_admin_student_view']))) {
    header("Location: ../student_login.php");
    exit();
}

require_once '../../php/Database.php';
require_once '../../php/Logger.php';

// Log the page visit if it's a super admin
if (isset($_SESSION['super_admin_id'])) {
    $logger = new Logger($connect);
    $logger->logActivity(
        $_SESSION['super_admin_id'],
        'VIEW',
        'Viewed student repository'
    );
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
		<title>Public Repository</title>
		<link rel="stylesheet" href="../../assets/css/homepage.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	</head>
	<style>
	body {
		background: #f7faff;
		min-height: 100vh;
		font-family: 'Segoe UI', Arial, sans-serif;
	}
	.header-archive {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		padding: 2.2rem 0 1.2rem 0;
		background: none;
		border-bottom: none;
		margin-bottom: 1.5rem;
	}
	.header-archive h1 {
		color: #1976a5;
		font-size: 2rem;
		font-weight: 800;
		letter-spacing: 0.5px;
		margin-bottom: 0.7rem;
            display: flex;
            align-items: center;
		gap: 10px;
	}
	.archive-search {
		width: 520px;
		max-width: 98vw;
		position: relative;
	}
	.archive-search .input-icon {
		position: absolute;
		left: 14px;
		top: 50%;
		transform: translateY(-50%);
		color: #1976a5;
		font-size: 1.1rem;
		z-index: 2;
	}
	.archive-search input {
		width: 100%;
		padding: 9px 12px 9px 2.1rem;
		border-radius: 7px;
		border: 1.2px solid #b5c7d3;
            font-size: 1rem;
		outline: none;
		background: #fff;
		box-shadow: none;
		transition: border 0.2s;
	}
	.archive-search input:focus {
		border: 1.5px solid #1976a5;
	}
	.thesis-cards {
            display: flex;
		flex-wrap: wrap;
		gap: 1.5rem;
            justify-content: center;
		margin-top: 1.2rem;
	}
	.upload-item {
		background: #fff;
		border-radius: 12px;
		border: 1px solid #e3eafc;
            box-shadow: none;
		padding: 1.3rem 1.1rem 1.1rem 1.1rem;
		width: 320px;
            max-width: 98vw;
            display: flex;
            flex-direction: column;
		gap: 0.7rem;
		align-items: flex-start;
		transition: box-shadow 0.18s, border 0.18s;
	}
	.upload-item:hover {
		box-shadow: 0 4px 16px #1976a522;
		border: 1.5px solid #b5c7d3;
	}
	.upload-item .profile-image {
		width: 28px;
		height: 28px;
		border-radius: 50%;
		object-fit: cover;
		border: 1.2px solid #b5c7d3;
		background: #f4f8ff;
		margin-right: 8px;
	}
	.upload-item .author-info {
		display: flex;
		align-items: center;
		gap: 0.4rem;
		color: #1976a5;
		font-weight: 600;
		font-size: 0.97rem;
		margin-bottom: 0.1rem;
	}
	.upload-item .status-badge {
		display: inline-block;
		background: #f1f5fa;
		color: #1976a5;
            border-radius: 12px;
		font-size: 0.85rem;
		font-weight: 600;
		padding: 2px 14px;
		margin: 0.2rem 0 0.2rem 0.2rem;
		box-shadow: none;
		border: 1px solid #e3eafc;
	}
	.upload-item .thesis-title {
		color: #0d47a1;
		font-size: 1.08rem;
		font-weight: 700;
		margin: 0.2rem 0 0.2rem 0;
		display: block;
	}
	.upload-item .thesis-abstract {
		color: #444;
		line-height: 1.5;
		margin: 0.2rem 0 0.1rem 0;
		font-size: 0.97rem;
		font-style: italic;
		display: block;
	}
	.upload-item .view-btn {
		margin-top: 0.7rem;
		background: none;
		color: #1976a5;
		border: 1px solid #b5c7d3;
		border-radius: 6px;
		padding: 0.4rem 1.1rem;
		font-size: 0.97rem;
		font-weight: 600;
		cursor: pointer;
		transition: background 0.18s, color 0.18s, border 0.18s;
		align-self: flex-start;
	}
	.upload-item .view-btn:hover {
		background: #1976a5;
		color: #fff;
		border: 1px solid #1976a5;
	}
        .profile-image {
		width: 38px;
		height: 38px;
            border-radius: 50%;
            object-fit: cover;
		border: 2px solid #b5c7d3;
            background: #f4f8ff;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
	@media (max-width: 600px) {
		.header-archive {
			padding: 1rem 0 0.7rem 0;
			border-radius: 0 0 10px 10px;
		}
		.header-archive h1 {
			font-size: 1.1rem;
			gap: 6px;
		}
		.archive-search {
			width: 98vw;
		}
		.thesis-cards {
			gap: 0.7rem;
		}
		.upload-item {
			width: 98vw;
			padding: 0.7rem 0.3rem 0.7rem 0.3rem;
		}
        }
	</style>
	<body>
		<div class="main-bg">
			<nav class="main-nav">
				<div class="nav-logo">
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
				<div class="header-archive">
					<h1><i class="fa-solid fa-book-open"></i> Student Thesis Archive</h1>
					<div class="archive-search">
						<span class="input-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
						<input type="text" id="searchInput" placeholder="Search by title, author, or abstract...">
					</div>
				</div>
				<section>
					<div id="PDFFILE"></div>
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
		<div id="thesisModal" class="modal" style="display:none;">
			<div class="modal-content enhanced-modal">
				<span class="close-button" id="closeThesisModal">&times;</span>
				<div class="modal-body" style="padding:0;display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;">
					<iframe id="modalPDF" src="" style="width:90vw;height:90vh;border-radius:12px;border:none;box-shadow:0 2px 12px #0008;background:#222;"></iframe>
				</div>
			</div>
		</div>
		<script>
		// Store all theses for filtering
		let allPublicTheses = [];

		async function showPublicRepo() {
			const res = await fetch("../../php/student/get_public_repo.php");
			const data = await res.json();
			allPublicTheses = data;
			renderPublicRepo(data);
		}

		function capitalize(str) {
			if (!str) return '';
			return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
		}

		function renderPublicRepo(data) {
			let rows = "<div class='thesis-cards'>";
			for (const u of data) {
				const filePath = "../../assets/thesisfile/" + u.ThesisFile;
				const profileImg = "../../assets/ImageProfile/" + u.profileImg;
				rows += `
					<div class="upload-item">
						<div class="author-info">
							<a href="profile_timeline.php?id=${u.student_id}" class="profile-link" onclick="event.stopPropagation();">
								<img src="${profileImg}" alt="Profile Image" class="profile-image">
							</a>
							<span>${capitalize(u.lname)}, ${capitalize(u.fname)}</span>
						</div>
						<span class="status-badge">${u.Privacy || 'Public'}</span>
						<div class="thesis-title">${u.title}</div>
						<div class="thesis-abstract">${u.abstract}</div>
						<button class="view-btn" onclick="event.stopPropagation(); window.open('${filePath}', '_blank');">View PDF</button>
					</div>
				`;
			}
			rows += "</div>";
			document.getElementById("PDFFILE").innerHTML = rows;

			// Add modal open logic for .upload-item
			document.querySelectorAll('.upload-item').forEach(item => {
				item.addEventListener('click', function (e) {
					const filePath = item.getAttribute('data-file');
					document.getElementById('modalPDF').src = filePath + "#toolbar=0";
					document.getElementById('thesisModal').style.display = "flex";
				});
			});
		}

		// Search functionality
		const searchInput = document.getElementById('searchInput');
		if (searchInput) {
			searchInput.addEventListener('input', function() {
				const query = this.value.toLowerCase();
				const filtered = (allPublicTheses || []).filter(u =>
					(u.title && u.title.toLowerCase().includes(query)) ||
					(u.abstract && u.abstract.toLowerCase().includes(query)) ||
					((u.lname + ', ' + u.fname).toLowerCase().includes(query))
				);
				renderPublicRepo(filtered);
			});
		}

		// Dropdown toggle for avatar
		const avatar = document.querySelector('.nav-avatar');
		if (avatar) {
			avatar.addEventListener('click', function(e) {
				e.stopPropagation();
				this.classList.toggle('open');
			});
			document.addEventListener('click', function() {
				avatar.classList.remove('open');
			});
		}
		// Profile modal logic
		const profileLink = document.getElementById('profile-link');
		const profileModal = document.getElementById('profile-modal');
		const closeProfileModal = document.getElementById('closeProfileModal');
		if (profileLink && profileModal && closeProfileModal) {
			profileLink.addEventListener('click', function(e) {
				e.preventDefault();
				profileModal.style.display = 'flex';
				avatar.classList.remove('open');
			});
			closeProfileModal.addEventListener('click', function() {
				profileModal.style.display = 'none';
			});
			window.addEventListener('click', function(event) {
				if (event.target === profileModal) {
					profileModal.style.display = 'none';
				}
			});
		}
		// Logout confirmation modal logic
		const logoutLink = document.getElementById('logout-link');
		const logoutModal = document.getElementById('logout-modal');
		const closeLogoutModal = document.getElementById('closeLogoutModal');
		const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
		const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');
		if (logoutLink && logoutModal && closeLogoutModal && confirmLogoutBtn && cancelLogoutBtn) {
			logoutLink.addEventListener('click', function(e) {
				e.preventDefault();
				logoutModal.style.display = 'flex';
				avatar.classList.remove('open');
			});
			closeLogoutModal.addEventListener('click', function() {
				logoutModal.style.display = 'none';
			});
			cancelLogoutBtn.addEventListener('click', function(e) {
				e.preventDefault();
				logoutModal.style.display = 'none';
			});
			confirmLogoutBtn.addEventListener('click', function() {
				window.location.href = '../../php/logout.php';
			});
			window.addEventListener('click', function(event) {
				if (event.target === logoutModal) {
					logoutModal.style.display = 'none';
				}
			});
		}
		// Modal close logic
		document.addEventListener('DOMContentLoaded', function() {
			const closeBtn = document.getElementById('closeThesisModal');
			const modal = document.getElementById('thesisModal');
			const modalPDF = document.getElementById('modalPDF');
			if (closeBtn && modal && modalPDF) {
				closeBtn.onclick = function () {
					modal.style.display = "none";
					modalPDF.src = "";
				};
				modal.onclick = function(e) {
					if (e.target === modal) {
						modal.style.display = "none";
						modalPDF.src = "";
					}
				};
			}
		});
		showPublicRepo();
		</script>
	</body>
</html>
