<?php
session_start();
$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviewer Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #00246B;
            --secondary-color: #1a3a8f;
            --accent-color: #CADCFC;
            --background-color: #CADCFC;
            --text-color: #00246B;
            --card-bg: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 120vh;
            width: 280px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 32px 0 24px 0;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            box-shadow: 2px 0 16px rgba(0, 36, 107, 0.15);
        }

        .sidebar-profile-img-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--accent-color);
            background: var(--accent-color);
            box-shadow: 0 4px 12px rgba(0, 36, 107, 0.2);
            margin-bottom: 16px;
            transition: transform 0.3s ease;
        }

        .sidebar-profile-img-wrapper:hover {
            transform: scale(1.05);
        }

        .sidebar-profile-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .sidebar-profile-name {
            color: #fff;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 4px;
            text-align: center;
        }

        .sidebar-profile-role {
            color: var(--accent-color);
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 32px;
            text-align: center;
            letter-spacing: 1px;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
        }

        .sidebar-nav {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1 1 auto;
            margin-bottom: 0;
            padding: 0 16px;
        }

        .sidebar-nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 14px 24px;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-nav a i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-nav a.active, .sidebar-nav a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar-logout {
            margin-bottom: 16px;
            width: 50%;
            background: var(--accent-color);
            color: var(--primary-color);
            border: none;
            border-radius: 12px;
            padding: 10px 0;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-logout:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 36, 107, 0.15);
        }

        .sidebar-logout i {
            font-size: 1.2rem;
        }

        .sidebar-logout span {
            font-weight: 600;
        }

        .dashboard-main {
            margin-left: 280px;
            padding: 40px 5vw 32px 5vw;
            min-height: 100vh;
            background: var(--background-color);
        }

        .dashboard-welcome {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 36, 107, 0.1);
            padding: 36px 40px;
            margin-bottom: 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-left: 5px solid var(--primary-color);
        }

        .dashboard-welcome h2 {
            color: var(--primary-color);
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .dashboard-welcome p {
            color: var(--secondary-color);
            font-size: 1.2rem;
            margin: 0;
            opacity: 0.8;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 36px;
        }

        .dashboard-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 36, 107, 0.1);
            padding: 32px;
            transition: all 0.3s ease;
            border-top: 4px solid var(--primary-color);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 36, 107, 0.15);
        }

        .dashboard-card-title {
            color: var(--primary-color);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dashboard-card-value {
            color: var(--primary-color);
            font-size: 2.4rem;
            font-weight: 800;
            margin-top: 8px;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                flex-direction: row;
                padding: 16px;
                position: relative;
                box-shadow: 0 2px 10px rgba(0, 36, 107, 0.1);
            }

            .sidebar-profile-img-wrapper {
                width: 60px;
                height: 60px;
                margin-bottom: 0;
            }

            .sidebar-profile-name, .sidebar-profile-role {
                display: none;
            }

            .sidebar-nav {
                flex-direction: row;
                padding: 0;
                margin: 0;
            }

            .sidebar-nav a {
                padding: 10px;
                font-size: 1rem;
            }

            .sidebar-nav a span {
                display: none;
            }

            .sidebar-logout {
                width: auto;
                padding: 10px 15px;
                margin: 0;
                border-radius: 8px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .dashboard-main {
                margin-left: 0;
                padding: 24px 20px;
            }

            .dashboard-welcome {
                padding: 24px;
            }

            .dashboard-welcome h2 {
                font-size: 1.8rem;
            }

            .dashboard-cards {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-profile-img-wrapper">
            <img class="sidebar-profile-img" src="../../assets/ImageProfile/<?php echo htmlspecialchars($profileImg); ?>" alt="Profile">
            <form id="reviewerProfileImgForm" action="../../php/reviewer/profile_img_upload.php" method="POST" enctype="multipart/form-data" style="display:inline;">
                <label class="sidebar-profile-camera" title="Change Photo">
                    <input type="file" name="profileImg" accept="image/*" onchange="this.form.submit()" style="display:none;">
                    <i class="fas fa-camera"></i>
                </label>
            </form>
            <form id="reviewerProfileImgDeleteForm" action="../../php/reviewer/profile_img_delete.php" method="POST" style="display:inline;">
                <button type="submit" class="sidebar-profile-trash" title="Remove Photo">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
        <div class="sidebar-profile-name"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></div>
        <div class="sidebar-profile-role">REVIEWER</div>
        <form action="../../php/logout.php" method="POST" style="width:85%; display:flex; justify-content:center; margin: 16px 0;">
            <button type="submit" class="sidebar-logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="active"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <a href="View_thesis.php"><i class="fas fa-file-alt"></i><span>Review</span></a>
            <a href="thesis_approved.php"><i class="fas fa-check-circle"></i><span>Approved</span></a>
            <a href="thesis_rejected.php"><i class="fas fa-times-circle"></i><span>Rejected</span></a>
        </nav>
    </div>
    <div class="dashboard-main">
        <div class="dashboard-welcome">
            <div>
                <h2>Welcome, <?php echo $_SESSION['fname']; ?>!</h2>
                <p>Here's your reviewer dashboard overview.</p>
            </div>
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="dashboard-card-title">
                    <i class="fas fa-clock"></i>
                    Pending Reviews
                </div>
                <div class="dashboard-card-value">2</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-title">
                    <i class="fas fa-check-circle"></i>
                    Total Approved
                </div>
                <div class="dashboard-card-value">5</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-title">
                    <i class="fas fa-times-circle"></i>
                    Total Rejected
                </div>
                <div class="dashboard-card-value">1</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-title">
                    <i class="fas fa-file-alt"></i>
                    Total Reviewed
                </div>
                <div class="dashboard-card-value">8</div>
            </div>
        </div>
        <main>
            <div id="userTableBody"></div>
        </main>
    </div>
</body>
<script src="dashboard.js"></script>
</html>