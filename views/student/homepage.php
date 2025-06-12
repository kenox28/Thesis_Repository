<?php
session_start();

// Check if user is logged in as student or super admin in student view
if (!isset($_SESSION['student_id']) && (!isset($_SESSION['super_admin_id']) || !isset($_SESSION['super_admin_student_view']))) {
    header("Location: ../student_login.php");
    exit();
}

// Set user information based on who is logged in
if (isset($_SESSION['super_admin_id'])) {
    $fname = 'Super';
    $lname = 'Admin';
    $profileImg = 'noprofile.png';
    $email = $_SESSION['email'] ?? 'superadmin@example.com';
} else {
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
    $email = $_SESSION['email'];
}

// Check if viewing as super admin
$isAdminView = isset($_SESSION['super_admin_id']) && isset($_SESSION['super_admin_student_view']);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php echo $isAdminView ? 'Student View - Super Admin' : 'Pending Thesis'; ?></title>
		<link rel="stylesheet" href="../../assets/css/homepage.css?v=1.0.6" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	</head>
	<style>
        
        .profile-image {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2.5px solid #1976a5;
            box-shadow: 0 2px 8px #1976a533;
            margin-right: 10px;
            background: #f4f8ff;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .profile-image:hover {
            box-shadow: 0 4px 16px #1976a555;
            border-color: #2893c7;
        }
		#PDFFILE{
			display: flex;
			justify-content: center;
			align-items: center;
		}
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

        /* Modal Overlay */
        .modal {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,36,107,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3000;
            overflow-y: auto;
        }

        /* Modal Content */
        .modal-content.enhanced-modal {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 40px #1976a522, 0 1.5px 0 #cadcfc;
            padding: 0;
            max-width: 700px;
            width: 95vw;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 2px solid #1976a5;
            position: relative;
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 18px;
            background: linear-gradient(90deg, #1976a5 60%, #2893c7 100%);
            padding: 18px 28px 14px 28px;
            border-bottom: 1.5px solid #e9f0ff;
        }

        .modal-header h2 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 4px 0;
            letter-spacing: 0.5px;
        }

        .modal-icon {
            background: #fff;
            color: #1976a5;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px #cadcfc33;
        }

        .modal-body {
            padding: 18px 28px 24px 28px;
            overflow-y: auto;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .modal-abstract {
            font-size: 1.05rem;
            color: #1976a5;
            background: #f4f8ff;
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 8px;
            font-style: italic;
            box-shadow: 0 1px 4px #cadcfc33;
            border-left: 4px solid #1976a5;
            word-break: break-word;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #1a3a8f;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        #modalPDF {
            width: 100%;
            height: 55vh;
            border-radius: 10px;
            box-shadow: 0 2px 12px #1976a522;
            margin-top: 8px;
            border: 1.5px solid #e9f0ff;
            background: #f7faff;
        }

        .close-button {
            position: absolute;
            top: 12px;
            right: 18px;
            font-size: 2rem;
            color: #fff;
            cursor: pointer;
            font-weight: 700;
            transition: color 0.18s;
            z-index: 10;
            text-shadow: 0 2px 8px #1976a5cc;
        }
        .close-button:hover {
            color: #e74c3c;
        }

        @media (max-width: 900px) {
            .modal-content.enhanced-modal {
                width: 99vw !important;
                max-width: 99vw !important;
                height: 99vh !important;
                max-height: 99vh !important;
                padding: 0;
            }
            .modal-header, .modal-body {
                padding: 10px 6px 10px 6px;
            }
            .modal-header h2 {
                font-size: 1.1rem;
            }
            .modal-icon {
                width: 32px;
                height: 32px;
                font-size: 1.1rem;
            }
            #modalPDF {
                height: 35vh;
            }
        }
</style>
	<body>
		<?php if ($isAdminView): ?>
		<div class="admin-view-banner">
			<span>You are viewing the student dashboard as a Super Admin</span>
			<button onclick="window.location.href='../super_admin/super_admin_dashboard.php'">
				Return to Admin Dashboard
			</button>
		</div>
		<?php endif; ?>
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
                    <a href="approve_title.php">Approved Title</a>
					<a href="rejectpage.php">Rejected</a>
					<a href="revisepage.php">Revised</a>
					
				</div>
				<div class="nav-avatar dropdown">
					<?php if (!$isAdminView): ?>
						<?php $hasProfileImg = isset($profileImg) && $profileImg !== 'noprofile.png' && !empty($profileImg); ?>
						<?php if ($hasProfileImg): ?>
							<img class="avatar-img" src="../../assets/ImageProfile/<?php echo htmlspecialchars($profileImg); ?>" alt="Profile" onerror="this.style.display='none'">
						<?php else: ?>
							<span class="avatar-initials"><?php echo strtoupper($fname[0] . $lname[0]); ?></span>
						<?php endif; ?>
					<?php else: ?>
						<span class="avatar-initials" style="background: #1976a5;">SA</span>
					<?php endif; ?>
					<span class="avatar-name"><?php echo $fname[0]; ?><?php echo $lname[0]; ?></span>
					<div class="dropdown-content">
						<?php if (!$isAdminView): ?>
							<a href="#" id="profile-link">Profile</a>
						<?php endif; ?>
						<a href="#" id="logout-link">Logout</a>
					</div>
				</div>
			</nav>
			<!-- <main class="main-content">
				<section class="upload-card">
					<header>
						<h1 class="section-title">Upload Thesis</h1>
						<h3 class="section-subtitle"><?php echo $_SESSION['fname']; ?> <?php echo $_SESSION['lname']; ?></h3>
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
				</section> -->
				<section>
					<div id="PDFFILE">
					</div>
				</section>
			</main>
		</div>
		<div id="profile-modal" class="profile-modal" <?php if ($isAdminView) echo 'style="display:none;"'; ?>>
			<div class="profile-modal-content">
				<span class="close-modal" id="closeProfileModal">&times;</span>
				<div class="profile-modal-header">
					<?php if (!$isAdminView): ?>
						<?php if ($hasProfileImg): ?>
							<img class="profile-modal-img" src="../../assets/ImageProfile/<?php echo htmlspecialchars($profileImg); ?>" alt="Profile" onerror="this.style.display='none'">
						<?php else: ?>
							<span class="profile-modal-initials"><?php echo strtoupper($fname[0] . $lname[0]); ?></span>
						<?php endif; ?>
						<div class="profile-modal-name"><?php echo $fname . ' ' . $lname; ?></div>
						<div class="profile-modal-email"><?php echo $email; ?></div>
					<?php endif; ?>
				</div>
				<?php if (!$isAdminView): ?>
				<form id="profileImgFormModal" action="../../php/student/profile_img_upload.php" method="POST" enctype="multipart/form-data" style="margin-bottom: 10px;">
					<label class="profile-modal-upload-label">
						<input type="file" name="profileImg" accept="image/*" onchange="this.form.submit()" style="display:none;">
						<span class="profile-modal-upload-btn">Change Photo</span>
					</label>
				</form>
				<form id="profileImgDeleteFormModal" action="../../php/student/profile_img_delete.php" method="POST">
					<button type="submit" class="profile-modal-delete-btn">Remove Photo</button>
				</form>
				<?php endif; ?>
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
		<!-- Thesis Info Modal -->
		<div id="thesisModal" class="modal" style="display:none;">
			<div class="modal-content enhanced-modal">
				<span class="close-button" id="closeThesisModal">&times;</span>
				<div class="modal-header">
					<div class="modal-icon"><i class="fas fa-book-open"></i></div>
					<div>
						<h2 id="modalTitle"></h2>
						<div class="thesis-card-status" id="modalStatus"></div>
					</div>
				</div>
				<div class="modal-body">
					<p id="modalAbstract" class="modal-abstract"></p>
					<div class="author-info" id="modalOwner"></div>
					<a id="modalDownload" href="#" download style="display:none;" class="custom-download-btn">Download PDF</a>
					<iframe id="modalPDF" src="" width="100%" height="55vh" style="border-radius:12px;box-shadow:0 2px 12px #1976a522;margin-top:18px;border:2px solid #e9f0ff;"></iframe>
				</div>
			</div>
		</div>
		<script src="../../js/homepage.js?v=1.0.12"></script>
		<script>
			
		</script>
	</body>
</html>
