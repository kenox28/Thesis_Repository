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
    <link rel="stylesheet" href="../../assets/css/homepage.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --background-color: #f5f6fa;
            --text-color: #2c3e50;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }
        .header {
            background-color: var(--primary-color);
            padding: 1rem;
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .nav-links {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .nav-links a {
            text-decoration: none;
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        .nav-links a:hover, .nav-links a.active {
            background-color: var(--secondary-color);
            color: white;
        }
        .dashboard-main {
            padding: 40px 5vw 32px 5vw;
            min-height: 100vh;
            background: linear-gradient(135deg, #e9f0ff 0%, #f7faff 100%);
        }
        .dashboard-welcome {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px #1976a522;
            padding: 32px 32px 24px 32px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dashboard-welcome h2 {
            color: #1976a5;
            font-size: 2.1rem;
            font-weight: 800;
            margin-bottom: 6px;
        }
        .dashboard-welcome p {
            color: #6a7ba2;
            font-size: 1.1rem;
            margin: 0;
        }
        .dashboard-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 28px;
            margin-bottom: 32px;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px #1976a522;
            padding: 28px 36px;
            min-width: 220px;
            flex: 1 1 220px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .dashboard-card-title {
            color: #1976a5;
            font-size: 1.08rem;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dashboard-card-value {
            color: #00246B;
            font-size: 2.2rem;
            font-weight: 800;
        }
        @media (max-width: 900px) {
            .dashboard-main { padding: 24px 2vw 18px 2vw; }
            .dashboard-cards { flex-direction: column; gap: 18px; }
            .dashboard-welcome { flex-direction: column; align-items: flex-start; padding: 18px 10px; }
        }
        .sidebar {
            background: linear-gradient(135deg, #1976a5 0%, #2893c7 100%);
            min-height: 100vh;
            width: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 32px 0 24px 0;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            box-shadow: 2px 0 16px #1976a522;
        }
        .sidebar-profile-img-wrapper {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 12px;
            border: 4px solid #fff;
            background: #e9f0ff;
            box-shadow: 0 2px 8px #cadcfc33;
        }
        .sidebar-profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .sidebar-profile-name {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 2px;
            text-align: center;
        }
        .sidebar-profile-role {
            color: #e9f0ff;
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 24px;
            text-align: center;
            letter-spacing: 1px;
        }
        .sidebar-nav {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: auto;
        }
        .sidebar-nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.08rem;
            padding: 12px 32px;
            border-radius: 8px 0 0 8px;
            transition: background 0.18s, color 0.18s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-nav a.active, .sidebar-nav a:hover {
            background: rgba(255,255,255,0.18);
            color: #fff;
        }
        .sidebar-logout {
            margin-top: 32px;
            width: 90%;
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 0;
            font-size: 1.08rem;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            transition: background 0.18s;
            display: block;
            text-decoration: none;
        }
        .sidebar-logout:hover {
            background: #c0392b;
        }
        .dashboard-main {
            margin-left: 250px;
            padding: 40px 5vw 32px 5vw;
            min-height: 100vh;
            background: linear-gradient(135deg, #e9f0ff 0%, #f7faff 100%);
        }
        .header {
            background-color: var(--primary-color);
            padding: 1rem;
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 0 0 12px 12px;
            margin-bottom: 24px;
        }
        @media (max-width: 900px) {
            .sidebar { width: 100vw; min-height: 0; flex-direction: row; padding: 12px 0; position: static; box-shadow: none; }
            .dashboard-main { margin-left: 0; padding: 24px 2vw 18px 2vw; }
            .dashboard-cards { flex-direction: column; gap: 18px; }
            .dashboard-welcome { flex-direction: column; align-items: flex-start; padding: 18px 10px; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-profile-img-wrapper">
            <img class="sidebar-profile-img" src="../../assets/ImageProfile/<?php echo htmlspecialchars($profileImg); ?>" alt="Profile">
        </div>
        <div class="sidebar-profile-name"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></div>
        <div class="sidebar-profile-role">REVIEWER</div>
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
            <a href="View_thesis.php"><i class="fas fa-file-alt"></i> Review</a>
            <a href="thesis_approved.php"><i class="fas fa-check-circle"></i> Approved</a>
            <a href="thesis_rejected.php"><i class="fas fa-times-circle"></i> Rejected</a>
        </nav>
        <a href="../../php/logout.php" class="sidebar-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </aside>
    <div class="dashboard-main">

        <div class="dashboard-welcome">
            <div>
                <h2>Welcome, <?php echo $_SESSION['fname']; ?>!</h2>
                <p>Here's your reviewer dashboard overview.</p>
            </div>
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="dashboard-card-title"><i class="fas fa-hourglass-half"></i> Pending Reviews</div>
                <div class="dashboard-card-value">2</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-title"><i class="fas fa-check-circle"></i> Total Approved</div>
                <div class="dashboard-card-value">5</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-title"><i class="fas fa-times-circle"></i> Total Rejected</div>
                <div class="dashboard-card-value">1</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-title"><i class="fas fa-clipboard-list"></i> Total Reviewed</div>
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