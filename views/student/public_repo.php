<?php
session_start();
$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Public Repository</title>
		<link rel="stylesheet" href="../../assets/css/homepage.css" />
	</head>
	<style>
            .upload-item {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .upload-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .upload-item h3 {
            color: var(--primary-color);
            margin-top: 0;
            font-size: 1.4rem;
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 0.5rem;
        }

        .upload-item p {
            color: #666;
            line-height: 1.6;
            margin: 1rem 0;
        }

        .upload-item embed {
            width: 100%;
            height: 300px;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--secondary-color);
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background-color: var(--success-color);
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-top: 1rem;
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
					<a href="homepage.php">Pending</a>
					<a href="upload.php">Upload Thesis</a>
					<a href="approve_thesis.php">Approve</a>
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
				<header style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; flex-direction: column;">
					<h1 class="section-title" style="margin-bottom: 0;">Public Theses Repository</h1>
					<input type="text" id="searchInput" placeholder="Search by title, author, or abstract..." 
						style="padding: 8px 14px; border-radius: 6px; border: 1.5px solid #1976a5; width: 320px; max-width: 90%; font-size: 1rem; margin-top: 12px;">
				</header>
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
		<script>
		// Store all theses for filtering
		let allPublicTheses = [];

		async function showPublicRepo() {
			const res = await fetch("../../php/student/get_public_repo.php");
			const data = await res.json();
			allPublicTheses = data;
			renderPublicRepo(data);
		}

		function renderPublicRepo(data) {
			let rows = "<div class='thesis-cards'>";
			for (const u of data) {
				const filePath = "../../assets/thesisfile/" + u.ThesisFile;
				rows += `
					<div class="upload-item" onclick="openModal('${filePath}', '${u.title}', '${u.abstract}', '${u.lname}, ${u.fname}', '${u.Privacy}')">
						<h3><i class='fas fa-book'></i> ${u.title}</h3>
						<p><i class='fas fa-quote-left'></i> ${u.abstract}</p>
						<div class="author-info">
							<i class="fas fa-user-graduate"></i>
							<span>${u.lname}, ${u.fname}</span>
						</div>
						<embed src="${filePath}" type="application/pdf" width="300" height="250">
						<div class="status-badge">
							<i class="fas fa-check"></i> ${u.Privacy || 'Public'}
						</div>
					</div>
				`;
			}
			rows += "</div>";
			document.getElementById("PDFFILE").innerHTML = rows;
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

		function openModal(filePath, title, abstract, owner, privacy) {
			const modal = document.createElement("div");
			modal.className = "modal";
			modal.innerHTML = `
				<div class="modal-content large-modal">
					<span class="close-button">&times;</span>
					<h2>${title}</h2>
					<div class="thesis-card-status" style="margin-bottom:12px;">${privacy || "Public"}</div>
					<p>${abstract}</p>
					<p>Owner: ${owner}</p>
					<iframe src="${filePath}#toolbar=0" width="100%" height="85vh" style="border-radius:8px;box-shadow:0 2px 12px #1976a522;margin-top:12px;"></iframe>
				</div>
			`;
			const closeButton = modal.querySelector(".close-button");
			closeButton.onclick = function () {
				document.body.removeChild(modal);
			};
			document.body.appendChild(modal);
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
		showPublicRepo();
		</script>
	</body>
</html>
