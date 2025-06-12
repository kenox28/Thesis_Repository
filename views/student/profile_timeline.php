<?php
    session_start();
    include_once '../../php/Database.php';
    // echo $_SESSION['user_id'];
    $id = $_GET['id'];
    $sql = "SELECT * FROM student WHERE student_id = '$id'";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    $profileImg = $row['profileImg'];
    $name = $row['lname'] . ' ' . $row['fname'];
    $email = $row['email'];
    $profileImgs = $_SESSION['profileImg'];




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body{
        font-family: 'Poppins', sans-serif;
        display: flex;
        height: 100vh;
        width: 100%;
        background-color: #f0f0f0;
    }
    header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #1976a5;
        color: #fff;
        padding: 10px;
        width: 100%;
        height: 100px;
        position: fixed;
    }
    .nav-logo{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 100px;
    }
    .nav-logo {
	display: flex;
	align-items: center;
	height: 60px;
    }
    .logo-img {
        height: 48px;
        width: 48px;
        border-radius: 50%;
        background: #fff;
        object-fit: contain;
        margin-right: 18px;
        box-shadow: 0 2px 8px #cadcfc33;
    }
    .nav-links {
        display: flex;
        gap: 1.8rem;
        align-items: center;
    }
    .nav-links a {
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.08rem;
        padding: 8px 18px;
        border-radius: 22px;
        transition: background 0.18s, color 0.18s;
        position: relative;
    }
    .nav-links a:hover,
    .nav-links a.active {
        background: rgba(255, 255, 255, 0.18);
        color: #fff;
    }
    .nav-avatar {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: 18px;
        background: rgba(255, 255, 255, 0.13);
        border-radius: 22px;
        padding: 4px 16px 4px 8px;
        position: relative;
        cursor: pointer;
        user-select: none;
    }
    .avatar-img {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 2.5px solid #fff;
        background: #e9f0ff;
        box-shadow: 0 2px 8px #cadcfc33;
        display: block;
    }
    .avatar-initials {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #1976a5;
        color: #fff;
        font-weight: 700;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2.5px solid #fff;
        box-shadow: 0 2px 8px #cadcfc33;
        text-shadow: 0 1px 4px #1976a5cc;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        top: 54px;
        right: 0;
        min-width: 160px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 36, 107, 0.13);
        z-index: 100;
        flex-direction: column;
        padding: 10px 0;
        animation: fadeInUp 0.25s cubic-bezier(0.23, 1.01, 0.32, 1);
    }
    main{
        display: flex;
        width: 100%;
        height: 100%;
        background-color: #f0f0f0;
        
    }
    aside{
        display: flex;
        width: 100%;
        max-width: 350px;
        min-width: 220px;
        height: calc(100vh - 100px);
        margin-top: 100px;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        box-shadow: 0 4px 24px #1976a522, 0 1.5px 0 #cadcfc;

    }
    .profile-info{
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 320px;
        margin: 32px auto 0 auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px #1976a522, 0 1.5px 0 #cadcfc;
        padding: 32px 18px 28px 18px;
        border: none;
    }
    .profile-img{
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #1976a5;
        box-shadow: 0 4px 18px #1976a533, 0 1.5px 0 #cadcfc;
        margin-bottom: 18px;
        background: #f7faff;
    }
    .profile-name{
        font-size: 1.6rem;
        font-weight: 700;
        color: #1976a5;
        margin-bottom: 8px;
        text-align: center;
    }
    .profile-email{
        font-size: 1.08rem;
        color: #555;
        margin-top: 0;
        text-align: center;
        font-weight: 500;
        background: #f4f8ff;
        border-radius: 8px;
        padding: 8px 0;
        width: 100%;
        box-shadow: 0 1px 4px #cadcfc33;
    }
    @media (max-width: 900px) {
        aside {
            max-width: 100vw;
            min-width: 0;
            width: 100vw;
        }
        .profile-info {
            max-width: 98vw;
            padding: 18px 4vw 18px 4vw;
        }
        .profile-img {
            width: 100px;
            height: 100px;
        }
    }
    .profile-status {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f7faff;
        border-radius: 14px;
        box-shadow: 0 2px 12px #1976a522;
        width: 90%;
        max-width: 320px;
        padding: 18px 16px 14px 16px;
        margin-top: 18px;
        margin-bottom: 18px;

        margin-left: 15px;
        text-align: center;
    }

    .profile-status h2 {
        color: #1976a5;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    .profile-status-count {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: stretch;
        margin-top: 10px;
        width: 100%;
        max-width: 320px;
        margin-left: 15px;
        margin-right: 15px;
        margin-bottom: 15px;
        padding: 10px 0 10px 14px;
    }

    .status-badge {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.08rem;
        font-weight: 600;
        border-radius: 8px;
        width: 100%;
        padding: 10px 0 10px 14px;

        box-shadow: 0 1px 4px #cadcfc33;
        background: #fff;
        border-left: 6px solid #1976a5;
        color: #1976a5;
        transition: background 0.18s, color 0.18s;
    }

    .status-badge.pending {
        border-left-color: #ffc107;
        color: #b28704;
        background: #fffbe6;
    }
    .status-badge.approved {
        border-left-color: #4caf50;
        color: #256029;
        background: #e8f5e9;
    }
    .status-badge.rejected {
        border-left-color: #e74c3c;
        color: #a93226;
        background: #fff0ee;
    }
    .status-badge.public {
        border-left-color: #1976a5;
        color: #1976a5;
        background: #e3f2fd;
    }

    .status-badge i {
        font-size: 1.2rem;
        margin-right: 8px;
    }
    .profile-modal {
	display: none;
	position: fixed;
	z-index: 2000;
	left: 0;
	top: 0;
	width: 100vw;
	height: 100vh;
	background: rgba(0, 36, 107, 0.13);
	align-items: center;
	justify-content: center;
    }
    .profile-modal-content {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(0, 36, 107, 0.18);
        padding: 32px 32px 24px 32px;
        min-width: 320px;
        max-width: 95vw;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        animation: fadeInUp 0.3s cubic-bezier(0.23, 1.01, 0.32, 1);
    }
    .close-modal {
        position: absolute;
        top: 16px;
        right: 22px;
        font-size: 2rem;
        color: #1976a5;
        cursor: pointer;
        font-weight: 700;
        transition: color 0.18s;
    }
    .close-modal:hover {
        color: #e74c3c;
    }
    .profile-modal-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 18px;
    }
    .profile-modal-img,
    .profile-modal-initials {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        background: #1976a5;
        color: #fff;
        font-size: 2.2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #e9f0ff;
        margin-bottom: 10px;
        box-shadow: 0 2px 8px #cadcfc33;
    }
    .profile-modal-name {
        font-weight: 700;
        color: #1976a5;
        font-size: 1.2rem;
        margin-bottom: 2px;
        text-align: center;
    }
    .profile-modal-email {
        color: #6a7ba2;
        font-size: 1.05rem;
        margin-bottom: 10px;
        text-align: center;
    }
    .profile-modal-upload-label {
        cursor: pointer;
        display: inline-block;
    }
    .profile-modal-upload-btn {
        background: #1976a5;
        color: #fff;
        border-radius: 6px;
        padding: 7px 22px;
        font-size: 1rem;
        font-weight: 600;
        margin-top: 2px;
        display: inline-block;
        transition: background 0.18s;
        box-shadow: 0 2px 8px #cadcfc33;
    }
    .profile-modal-upload-btn:hover {
        background: #2893c7;
    }
    .profile-modal-delete-btn {
        background: #e74c3c;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 7px 22px;
        font-size: 1rem;
        font-weight: 600;
        margin-top: 10px;
        cursor: pointer;
        transition: background 0.18s;
        box-shadow: 0 2px 8px #e74c3c33;
    }
    .profile-modal-delete-btn:hover {
        background: #c0392b;
    }
    @media (max-width: 600px) {
        .profile-modal-content {
            min-width: 0;
            padding: 16px 2vw 12px 2vw;
        }
    }
    .sidebar-profile-img-wrapper {
        position: relative;
        width: 90px;
        height: 90px;
        margin-bottom: 12px;
    }
    .sidebar-profile-camera,
    .sidebar-profile-trash {
        position: absolute;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.18s, transform 0.18s;
        z-index: 2;
    }
    .sidebar-profile-camera {
        left: 8px;
        bottom: 8px;
        background: #1976a5;
        border-radius: 50%;
        padding: 4px;
        box-shadow: 0 2px 8px #1976a522;
        cursor: pointer;
        border: 2px solid #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sidebar-profile-trash {
        right: 8px;
        bottom: 8px;
        background: #e74c3c;
        border-radius: 50%;
        padding: 4px;
        box-shadow: 0 2px 8px #e74c3c22;
        border: 2px solid #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sidebar-profile-img-wrapper:hover .sidebar-profile-camera,
    .sidebar-profile-img-wrapper:hover .sidebar-profile-trash {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }
    .sidebar-profile-camera:active,
    .sidebar-profile-trash:active {
        transform: scale(0.95);
    }
    .dropdown-content {
	display: none;
	position: absolute;
	top: 54px;
	right: 0;
	min-width: 160px;
	background: #fff;
	border-radius: 12px;
	box-shadow: 0 8px 32px rgba(0, 36, 107, 0.13);
	z-index: 100;
	flex-direction: column;
	padding: 10px 0;
	animation: fadeInUp 0.25s cubic-bezier(0.23, 1.01, 0.32, 1);
    }
    .nav-avatar.open .dropdown-content {
        display: flex;
    }
    .dropdown-content a {
        color: #1976a5;
        padding: 10px 22px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.05rem;
        border-radius: 6px;
        transition: background 0.15s, color 0.15s;
        white-space: nowrap;
    }
    .dropdown-content a:hover {
        background: #e9f0ff;
        color: #00246b;
    }
    .nav-avatar:hover,
    .nav-avatar.open {
        background: rgba(255, 255, 255, 0.22);
        box-shadow: 0 2px 12px #1976a522;
    }
    .avatar-name {
        color: #fff;
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 1px;
        text-shadow: 0 1px 4px #1976a5cc;
    }
    section {
        display: flex;
        width: 80%;
        margin-top: 100px;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
    .thesis-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 32px;
        justify-content: center;
        height: 600px;
        overflow-y: auto;

        /* margin-top: 24px; */
    }
    #abstract {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
	.thesis-card,
	.upload-item {
		min-width: 0;
		max-width: 98vw;
		padding: 10px 2vw 8px 2vw;
	}
    
    .upload-item {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-sizing: border-box;
        border: 1px solid #ccc;
        padding: 10px;
        min-width: 300px;
        background: white;
        width: 340px;
    }
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
    .thesis-card-public-private{
        background-color: var(--secondary-color);
        color: #fff;
        border: none;
        height: 30px;
        width: 300px;
        border-radius: 4px;
        cursor: pointer;
    }
    .thesis-card-public-private:hover{
        background-color: var(--secondary-color);
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
    .thesis-card-public-private{
        background-color: var(--secondary-color);
        color: #fff;
        border: none;
        height: 30px;
        width: 300px;
        border-radius: 4px;
        cursor: pointer;
    }
    .thesis-card-public-private:hover{
        background-color: var(--secondary-color);
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
    .author-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--secondary-color);
        font-weight: 500;
    }
    #downloads {
        display: none;
    }
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
        font-size: uppercase;
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
    <header>
        <div class="nav-logo">
            <img src="../../assets/icons/logo.png" alt="Logo" class="logo-img">
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
                <?php $hasProfileImg = isset($profileImgs) && $profileImgs !== 'noprofile.png' && !empty($profileImgs); ?>
                <?php if ($hasProfileImg): ?>
                    <img class="avatar-img" src="../../assets/ImageProfile/<?php echo htmlspecialchars($profileImgs); ?>" alt="Profile" onerror="this.style.display='none'">
                <?php else: ?>
                    <span class="avatar-initials"><?php echo strtoupper($_SESSION['fname'][0] . $_SESSION['lname'][0]); ?></span>
                <?php endif; ?>
                <span class="avatar-name"><?php echo $_SESSION['fname'][0]; ?><?php echo $_SESSION['lname'][0]; ?></span>
                <div class="dropdown-content">
                    <a href="#" id="profile-link">Profile</a>
                    <a href="#" id="logout-link">Logout</a>
                </div>
            </div>
    </header>
    <main>

        <aside>
            <div class="profile-info">
                <img src="../../assets/ImageProfile/<?php echo $profileImg; ?>" alt="Profile Image" class="profile-img">
                <h2 class="profile-name"><?php echo $name; ?></h2>       
                <p class="profile-email"><?php echo $email; ?></p>
            </div>
            <div class="profile-status">
                <h2>Status</h2>
                <?php
                // Get counts for each status
                $sql2 = "SELECT COUNT(*) as cnt FROM repoTable WHERE student_id = '$id' AND status = 'approved'";
                $sql3 = "SELECT COUNT(*) as cnt FROM repoTable WHERE student_id = '$id' AND status = 'rejected'";
                $sql4 = "SELECT COUNT(*) as cnt FROM publicRepo WHERE student_id = '$id' AND Privacy = 'public'";
                $sql5 = "SELECT COUNT(*) as cnt FROM repoTable WHERE student_id = '$id' AND status = 'pending'";

                $approved = mysqli_fetch_assoc(mysqli_query($connect, $sql2))['cnt'];
                $rejected = mysqli_fetch_assoc(mysqli_query($connect, $sql3))['cnt'];
                $public = mysqli_fetch_assoc(mysqli_query($connect, $sql4))['cnt'];
                $pending = mysqli_fetch_assoc(mysqli_query($connect, $sql5))['cnt'];
                ?>
                <div class="profile-status-count">
                    <div class="status-badge pending">
                        <i class="fas fa-clock"></i> Pending: <?php echo $pending; ?>
                    </div>
                    <div class="status-badge approved">
                        <i class="fas fa-check-circle"></i> Approved: <?php echo $approved; ?>
                    </div>
                    <div class="status-badge rejected">
                        <i class="fas fa-times-circle"></i> Rejected: <?php echo $rejected; ?>
                    </div>
                    <div class="status-badge public">
                        <i class="fas fa-globe"></i> Public: <?php echo $public; ?>
                    </div>
                </div>
            </div>  

        </aside>


        <section>
            <div class="profile-timeline" id="profile-timeline">
            </div>
        </section>
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
					<iframe id="modalPDF" src="" width="100%" height="55vh" style="border-radius:12px;box-shadow:0 2px 12px #1976a522;margin-top:18px;border:2px solid #e9f0ff;"></iframe>
				</div>
			</div>
		</div>
    </body>
</html>
<script>
    function capitalize(str) {
		if (!str) return "";
		return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    }




    async function showupload() {
        const formData = new FormData();
        const id = <?php echo json_encode($id); ?>;
        formData.append("id", id);

        const res = await fetch("../../php/student/timeline.php", {
            method: "POST",
            body: formData
        });
        const data = await res.json();
        if (data.error) {
            document.getElementById("PDFFILE").innerHTML = `<p>${data.error}</p>`;
            return;
        }
        let rows = "<div class='thesis-cards'>";
        for (const u of data) {
            // Only show approved theses
            if (u.status && u.status.toLowerCase() === "approved") {
                const filePath = "../../assets/thesisfile/" + u.ThesisFile;
                const profileImg = "../../assets/ImageProfile/" + u.profileImg;
                    rows += `
                        <div class="upload-item"
                            data-file="${filePath}"
                            data-title="${encodeURIComponent(u.title)}"
                            data-abstract="${encodeURIComponent(u.abstract)}"
                            data-owner="${encodeURIComponent(u.lname + ', ' + u.fname)}"
                            data-privacy="${encodeURIComponent(u.Privacy)}"
                            style="cursor:pointer;"
                        >
                            <div class="author-info">
                                <a href="profile_timeline.php?id=${u.student_id}" class="profile-link" onclick="event.stopPropagation();">  
                                    <img src="${profileImg}" alt="Profile Image" class="profile-image">
                                </a>
                                <span style="font-size: 1.2rem; font-weight: 600; letter-spacing: 0.5px;">
                                    ${capitalize(u.lname)}, ${capitalize(u.fname)}
                                </span>
                            </div>
                            <h3 class="thesis-title" style="cursor:pointer;">
                                <i class='fas fa-book'></i> ${u.title}
                            </h3>
                            <p id="abstract"><i class='fas fa-quote-left'></i> ${u.abstract}</p>

                            <iframe src="${filePath}#toolbar=0&navpanes=0&scrollbar=0" width="300" height="250" style="border-radius:8px;border:1.5px solid #e9f0ff;"></iframe>
                            <div style="margin-top:12px;display:flex;gap:10px;">
                                <button class="thesis-card-public-private" onclick="event.stopPropagation(); privacyfunction(${u.id}, '${u.title.replace(/'/g, "\\'")}', 'public')">Public</button>
                                <button class="thesis-card-public-private" onclick="event.stopPropagation(); privacyfunction(${u.id}, '${u.title.replace(/'/g, "\\'")}', 'private')">Private</button>
                            </div>
                        </div>
                    `;
            }
        }
        rows += "</div>";
        document.getElementById("profile-timeline").innerHTML = rows;

        // Add modal open logic for .upload-item
        document.querySelectorAll('.upload-item').forEach(item => {
            item.addEventListener('click', function (e) {
                // Prevent modal if the button was clicked
                if (e.target.tagName === 'BUTTON') return;
                const filePath = item.getAttribute('data-file');
                const title = decodeURIComponent(item.getAttribute('data-title'));
                const abstract = decodeURIComponent(item.getAttribute('data-abstract'));
                const owner = decodeURIComponent(item.getAttribute('data-owner'));
                const status = decodeURIComponent(item.getAttribute('data-status'));

                document.getElementById('modalTitle').textContent = title;
                document.getElementById('modalStatus').textContent = status || "Approved";
                document.getElementById('modalAbstract').innerHTML = `<i class="fas fa-quote-left"></i> ${abstract}`;
                document.getElementById('modalOwner').innerHTML = `<i class="fas fa-user-graduate"></i> <span>${owner}</span>`;
                document.getElementById('modalPDF').src = filePath + "#toolbar=0";
                document.getElementById('thesisModal').style.display = "flex";
            });
        });
    }
    showupload()
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
    
</script>
</html>