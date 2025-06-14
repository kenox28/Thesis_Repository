<?php
session_start();

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}

// Log the page visit
require_once '../../php/Database.php';
require_once '../../php/Logger.php';

$logger = new Logger($connect);
$logger->logActivity(
    $_SESSION['admin_id'],
    'VIEW',
    'Accessed admin dashboard'
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="../../assets/css/Admin_Page.css?v=1.0.2" rel="stylesheet">
    <style>

        body {
            font-family: 'Inter', 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #cadcfc 0%, #e3eaff 100%);
            margin: 0;
            padding: 0;
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
        }
        /* Floating SVG blobs for background */
        body::before, body::after {
            content: '';
            position: fixed;
            z-index: 0;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.18;
            pointer-events: none;
        }
        body::before {
            width: 340px; height: 340px;
            background: linear-gradient(135deg, #1976a5 0%, #cadcfc 100%);
            top: -120px; left: -120px;
        }
        body::after {
            width: 260px; height: 260px;
            background: linear-gradient(135deg, #cadcfc 0%, #1976a5 100%);
            bottom: -100px; right: -100px;
        }
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #1a3a8f 0%, #1976a5 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            height: 100vh;
            box-shadow: 2px 0 16px rgba(0,36,107,0.10);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            backdrop-filter: blur(12px);
            border-right: 1.5px solid rgba(255,255,255,0.08);
        }
        .sidebar-header {
            text-align: center;
            padding: 1.6rem 1rem 1rem 1rem;
            background: transparent;
        }
        .profile-img-wrapper {
            position: relative;
            display: inline-block;
            width: 68px;
            height: 68px;
            margin-bottom: 0.6rem;
        }
        .profile-img-wrapper img {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            object-fit: cover;
            border: 2.5px solid #fff;
            box-shadow: 0 0 0 3px #1976a5, 0 6px 20px #1976a555;
            transition: box-shadow 0.2s;
            display: block;
            background: #cadcfc;
        }
        .profile-img-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.45);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            z-index: 2;
            transition: opacity 0.2s;
            pointer-events: none;
        }
        .profile-img-wrapper:hover .profile-img-overlay {
            opacity: 1;
            pointer-events: auto;
        }
        .profile-img-camera {
            color: #fff;
            font-size: 2rem;
            background: rgba(0,0,0,0.55);
            padding: 10px;
            border-radius: 50%;
            z-index: 3;
            pointer-events: auto;
        }
        .profile-img-delete {
            position: absolute;
            bottom: -8px; right: -8px;
            opacity: 0;
            z-index: 4;
            transition: opacity 0.2s;
        }
        .profile-img-wrapper:hover .profile-img-delete {
            opacity: 1;
        }
        .profile-img-delete button {
            background: none; border: none; cursor: pointer; padding: 0;
        }
        .profile-img-delete i {
            font-size: 1.3rem;
            color: #e74c3c;
            background: #fff;
            padding: 6px;
            border-radius: 50%;
            box-shadow: 0 2px 8px #cadcfc33;
        }
        .sidebar-header .admin-name {
            font-size: 1.13rem;
            font-weight: 700;
            margin-top: 0.6rem;
            letter-spacing: 0.5px;
            color: #fff;
            text-shadow: 0 2px 8px #1976a555;
        }
        .sidebar-nav {
            flex: 1 1 auto;
            overflow-y: auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
            gap: 0.38rem;
            margin-top: 1.4rem;
        }
        .sidebar-link {
            color: #fff;
            text-decoration: none;
            padding: 0.85rem 1.5rem 0.85rem 1.5rem;
            font-size: 1.04rem;
            border-left: 3px solid transparent;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 0 20px 20px 0;
            position: relative;
            font-weight: 500;
        }
        .sidebar-link i {
            font-size: 1.2rem;
        }
        .sidebar-link.active, .sidebar-link:hover {
            background: rgba(202,220,252,0.18);
            border-left: 4px solid #fff;
            color: #cadcfc;
        }
        .sidebar-logout {
            flex-shrink: 0;
            padding: 1.2rem 1.3rem 1.6rem 1.3rem;
            width: 85%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sidebar-logout-btn {
            width: 100%;
            background: linear-gradient(90deg, #e74c3c 60%, #c0392b 100%);
            color: white;
            border: none;
            border-radius: 22px;
            padding: 0.7 rem 0;
            font-size: 1.18rem;
            font-weight: 00;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            /* gap: 14px; */
            /* box-shadow: 0 4px 16px #e74c3c33, 0 1.5px 0 #fff2; */
            position: relative;
            overflow: hidden;
        }
        .sidebar-logout-btn::after {
            content: '';
            position: absolute;
            left: -75%;
            top: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.05) 100%);
            transform: skewX(-20deg);
            transition: left 0.4s cubic-bezier(.4,2,.3,.7);
            pointer-events: none;
        }
        .sidebar-logout-btn:hover::after {
            left: 120%;
        }
        .sidebar-logout-btn i {
            font-size: 1.35em;
        }
        .main-content {
            flex: 1;
            padding: 2.5rem 2rem 2rem 2rem;
            background: transparent;
            min-height: 100vh;
            margin-left: 260px;
            transition: margin-left 0.2s;
        }
        .dashboard-widgets {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 2.5rem;
            margin-bottom: 2.5rem;
            margin-top: 0;
            justify-content: center;
            align-items: stretch;
            position: relative;
            z-index: 1;
            max-width: 700px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }
        .widget-card {
            background: rgba(255,255,255,0.22);
            backdrop-filter: blur(8px);
            border-radius: 22px;
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
            padding: 2.2rem 2.8rem;
            min-width: 0;
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
            box-sizing: border-box;
            border: 1.5px solid rgba(25,118,165,0.10);
            transition: box-shadow 0.2s, transform 0.2s, border 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .widget-card:hover {
            box-shadow: 0 12px 32px 0 rgba(25,118,165,0.22);
            border: 1.5px solid #1976a5;
            transform: translateY(-4px) scale(1.04);
        }
        .widget-card .widget-icon {
            font-size: 2.2rem;
            margin-bottom: 0.7rem;
            color: #1976a5;
            background: rgba(202,220,252,0.45);
            border-radius: 50%;
            padding: 0.7rem;
            box-shadow: 0 2px 8px #cadcfc33;
        }
        .widget-card:nth-child(1) .widget-icon { color: #1976a5; background: rgba(202,220,252,0.45); }
        .widget-card:nth-child(2) .widget-icon { color: #27ae60; background: rgba(39,174,96,0.12); }
        .widget-card:nth-child(3) .widget-icon { color: #f7b731; background: rgba(247,183,49,0.12); }
        .widget-card:nth-child(4) .widget-icon { color: #8e44ad; background: rgba(142,68,173,0.12); }
        .widget-title {
            font-size: 1.1rem;
            color: #1976a5;
            margin-bottom: 0.5rem;
            font-weight: 600;
            letter-spacing: 0.2px;
        }
        .widget-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1a3a8f;
            text-shadow: 0 2px 8px #cadcfc33;
        }
        .student-card, .reviewer-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,36,107,0.08);
            padding: 24px 20px 18px 20px;
            margin-bottom: 18px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-width: 270px;
            max-width: 350px;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .student-card:hover, .reviewer-card:hover {
            box-shadow: 0 6px 24px rgba(0,36,107,0.16);
            transform: translateY(-2px) scale(1.01);
        }
        .student-header, .reviewer-header {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 12px;
        }
        .student-avatar, .reviewer-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 2.5px solid #1976a5;
            background: #f4f8ff;
        }
        .student-info h3, .reviewer-info h3 {
            margin: 0;
            color: #1976a5;
            font-size: 1.18rem;
            font-weight: 600;
        }
        .student-id, .student-email, .reviewer-id, .reviewer-email {
            margin: 3px 0;
            color: #666;
            font-size: 0.97rem;
        }
        .student-actions, .reviewer-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .student-actions button, .reviewer-actions button {
            flex: 1;
            padding: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: background-color 0.2s;
        }
        .btn-primary {
            background: #1976a5;
            color: white;
        }
        .btn-primary:hover {
            background: #155d84;
        }
        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }
        .btn-secondary:hover {
            background: #e0e0e0;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-role {
            background: #cadcfc;
            color: #1976a5;
            border: 1px solid #1976a5;
            font-weight: 500;
            margin-top: 6px;
        }
        .btn-role:hover {
            background: #1976a5;
            color: #fff;
        }
        .no-students, .error-message {
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px dashed #ccc;
            padding: 32px;
            color: #666;
            font-style: italic;
            text-align: center;
            margin: 24px 0;
        }
        .main-content > *:not(.dashboard-widgets) {
            margin-top: 6.5rem;
        }
        @media (max-width: 900px) {
            .sidebar {
                min-width: 60px;
                width: 60px;
                padding: 0;
            }
            .main-content {
                margin-left: 60px;
            }
            .dashboard-widgets {
                left: 60px;
            }
        }
        @media (max-width: 700px) {
            .dashboard-widgets {
                grid-template-columns: 1fr;
                grid-template-rows: none;
            }
        }
        #dashboardWelcome {
            display:flex;flex-direction:column;align-items:center;justify-content:center;
            background:rgba(255,255,255,0.28);backdrop-filter:blur(14px);
            border-radius:28px;box-shadow:0 8px 40px 0 rgba(31,38,135,0.13);
            padding:2.5rem 3.2rem 1.5rem 3.2rem;margin-top:2.5rem;margin-bottom:1.2rem;
            min-width:320px;max-width:540px;width:100%;position:relative;overflow:hidden;
            z-index: 1;
        }
        #dashboardWelcome .welcome-blur {
            position:absolute;top:-30px;right:-30px;width:120px;height:120px;
            background:linear-gradient(135deg,#1976a5 0%,#cadcfc 100%);opacity:0.13;border-radius:50%;z-index:0;
        }
        #dashboardWelcome .welcome-blur2 {
            position:absolute;bottom:-30px;left:-30px;width:120px;height:120px;
            background:linear-gradient(135deg,#cadcfc 0%,#1976a5 100%);opacity:0.13;border-radius:50%;z-index:0;
        }
        #dashboardWelcome .welcome-title {
            font-size:2rem;font-weight:800;color:#1976a5;letter-spacing:0.5px;display:flex;align-items:center;gap:0.7rem;z-index:1;
        }
        #dashboardWelcome .welcome-title i {
            color:#1976a5;font-size:2.2rem;background:rgba(202,220,252,0.5);border-radius:50%;padding:0.5rem;box-shadow:0 2px 8px #cadcfc33;
        }
        #dashboardWelcome .welcome-role {
            font-size:1.1rem;font-weight:600;color:#1976a5bb;margin-top:0.3rem;letter-spacing:0.2px;display:flex;align-items:center;gap:0.4rem;z-index:1;
        }
        #dashboardWelcome .welcome-role i {
            color:#f7b731;font-size:1.2rem;
        }
        .btn-role-glass {
            background: rgba(202,220,252,0.45);
            color: #1976a5;
            border: 1.5px solid #1976a5;
            font-weight: 600;
            border-radius: 18px;
            padding: 0.5rem 1.2rem;
            margin: 0 0.2rem 0.2rem 0;
            font-size: 1rem;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            cursor: pointer;
            outline: none;
            box-shadow: 0 2px 8px #cadcfc22;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-role-glass:hover, .btn-role-glass:focus {
            background: #1976a5;
            color: #fff;
            box-shadow: 0 4px 16px #1976a555;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="profile-img-wrapper">
                <img id="adminProfileImg" src="../../assets/ImageProfile/<?php echo htmlspecialchars($_SESSION['profileImg'] ?? 'noprofile.png'); ?>" alt="Profile">
                <form action="../../php/admin/profile_img_upload.php" method="POST" enctype="multipart/form-data" class="profile-img-overlay" style="justify-content:center;align-items:center;">
                    <input type="file" name="profileImg" accept="image/*" onchange="this.form.submit()" style="display:none;" id="adminProfileImgInput">
                    <label for="adminProfileImgInput" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;cursor:pointer;">
                        <i class="fas fa-camera profile-img-camera"></i>
                    </label>
                </form>
                <form action="../../php/admin/profile_img_delete.php" method="POST" class="profile-img-delete">
                    <button type="submit"><i class="fas fa-trash"></i></button>
                </form>
            </div>
            <div class="admin-name">
                <?php echo htmlspecialchars($_SESSION['fname'] . ' ' . $_SESSION['lname']); ?>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a class="sidebar-link active" id="nav-dashboard"><i class="fas fa-home"></i> Dashboard</a>
            <a class="sidebar-link" id="nav-students"><i class="fas fa-user-graduate"></i> Students</a>
            <a class="sidebar-link" id="nav-reviewers"><i class="fas fa-user-check"></i> Reviewers</a>
            <a class="sidebar-link" id="nav-publication"><i class="fas fa-book"></i> Publication Thesis</a>
            <a class="sidebar-link" id="nav-faculty"><i class="fas fa-chalkboard-teacher"></i> Faculty</a>
        </nav>
        <div class="sidebar-logout">
            <button class="sidebar-logout-btn" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </aside>
    <main class="main-content">
        <!-- Dashboard Main Area (hidden by default, shown only on dashboard) -->
        <div id="dashboardMain" style="display:none;flex-direction:column;align-items:center;justify-content:center;width:100%;">
            <div id="dashboardWelcome">
                <div class="welcome-blur"></div>
                <div class="welcome-blur2"></div>
                <span class="welcome-title">
                    <i class='fas fa-user-shield'></i>
                    Welcome, <?php echo htmlspecialchars($_SESSION['fname'] . ' ' . $_SESSION['lname']); ?>!
                </span>
                <div class="welcome-role"><i class='fas fa-crown'></i> Administrator</div>
            </div>
            <div class="dashboard-widgets" id="dashboardWidgets" style="display:flex;">
                <div class="widget-card">
                    <div class="widget-icon"><i class="fas fa-user-graduate"></i></div>
                    <div class="widget-title">Total Students</div>
                    <div class="widget-value"><span id="widgetStudents"></span></div>
                </div>
                <div class="widget-card">
                    <div class="widget-icon"><i class="fas fa-user-check"></i></div>
                    <div class="widget-title">Total Reviewers</div>
                    <div class="widget-value" id="widgetReviewers"><span id="widgetReviewers"></span></div>
                </div>
                <div class="widget-card">
                    <div class="widget-icon"><i class="fas fa-book"></i></div>
                    <div class="widget-title">Total Thesis</div>
                    <div class="widget-value" id="widgetThesis"><span id="widgetThesis"></span></div>
                </div>
            </div>
        </div>
        <!-- Dynamic Content Area -->
        <div id="dashboardContent">
            <!-- Content will be loaded here based on sidebar selection -->
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../js/admin_dashboard.js?v=1.0.14"></script>
    <script>
    // Show camera/trash icons on hover
    const wrapper = document.querySelector('.profile-img-wrapper');
    if (wrapper) {
        wrapper.addEventListener('mouseenter', function() {
            document.getElementById('adminProfileImgForm').style.opacity = 1;
            document.getElementById('adminProfileImgDeleteForm').style.opacity = 1;
            document.getElementById('adminProfileImg').style.boxShadow = '0 4px 24px #1976a555';
        });
        wrapper.addEventListener('mouseleave', function() {
            document.getElementById('adminProfileImgForm').style.opacity = 0;
            document.getElementById('adminProfileImgDeleteForm').style.opacity = 0;
            document.getElementById('adminProfileImg').style.boxShadow = '0 2px 8px #cadcfc33';
        });
    }
    </script>
</body>
</html>