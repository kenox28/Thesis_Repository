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
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00246B;
            --secondary-color: #1a3a8f;
            --accent-color: #CADCFC;
            --background-color: #CADCFC;
            --text-color: #00246B;
            --card-bg: #ffffff;
            --success-color: #00246B;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e9f0ff 0%, #f7faff 100%);
            margin: 0;
            padding: 0;
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
            background: rgba(255,255,255,0.85);
            border-radius: 18px;
            box-shadow: 0 2px 12px #1976a522;
            padding: 32px 32px 24px 32px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dashboard-welcome h2 {
            color: #1976a5;
            font-size: 2.2rem;
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
            gap: 100px;
            margin-bottom: 32px;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px #1976a522;
            padding: 88px 56px;
            min-width: 220px;
            flex: 1 1 220px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            transition: transform 0.18s, box-shadow 0.18s;
            position: relative;
        }
        .dashboard-card:hover {
            transform: translateY(-6px) scale(1.04);
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
        }
        .dashboard-card-title {
            font-size: 1.1em;
            color: #888;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dashboard-card-value {
            font-size: 2.5em;
            font-weight: 700;
            color: #0a2342;
            margin-top: 8px;
        }
        .dashboard-card:nth-child(1) .dashboard-card-value { color: #1976a5; }
        .dashboard-card:nth-child(2) .dashboard-card-value { color: #4fd1c5; }
        .dashboard-card:nth-child(3) .dashboard-card-value { color: #f7b731; }
        .dashboard-card:nth-child(4) .dashboard-card-value { color: #e74c3c; }
        @media (max-width: 900px) {
            .dashboard-main { padding: 24px 2vw 18px 2vw; }
            .dashboard-cards { flex-direction: column; gap: 18px; }
            .dashboard-welcome { flex-direction: column; align-items: flex-start; padding: 18px 10px; }
        }
        .sidebar {
            background: var(--primary-color);
            min-height: 100vh;
            width: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 32px 0 0 0;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            box-shadow: 2px 0 16px #1976a522;
            border-right: 1.5px solid #cadcfc55;
        }
        .sidebar-logo {
            width: 60px;
            height: 60px;
            margin-bottom: 18px;
            border-radius: 16px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px #cadcfc33;
        }
        .sidebar-logo i {
            font-size: 2.2em;
            color: #1976a5;
        }
        .sidebar-profile-img-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 10px;
            border: 3px solid #fff;
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
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 2px;
            text-align: center;
        }
        .sidebar-profile-role {
            color: #e9f0ff;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 20px;
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
            transition: background 0.18s, color 0.18s, transform 0.18s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-nav a.active, .sidebar-nav a:hover {
            background: rgba(255,255,255,0.18);
            color: #4fd1c5;
            transform: scale(1.05);
        }
        .sidebar-logout {
            margin-top: 0;
            margin-bottom: 18px;
            width: 90%;
            /* background: #e74c3c; */
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
            /* background: #c0392b; */
        }
        .sidebar-profile-img-wrapper form {
            display: flex;
            gap: 4px;
        }
        .profile-action { display: none; }
        .sidebar-profile-img-wrapper:hover .profile-action { display: flex; }
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
        <div class="sidebar-profile-img-wrapper" style="position:relative;">
            <img class="sidebar-profile-img" id="profileImg" src="../../assets/ImageProfile/<?php echo htmlspecialchars($profileImg); ?>" alt="Profile">
            <form id="profileImgForm" enctype="multipart/form-data" style="position:absolute; bottom:0; right:0; display:flex; gap:4px;">
                <label for="profileImgInput" class="profile-action" style="cursor:pointer; background:#fff; border-radius:50%; padding:6px; box-shadow:0 2px 8px #cadcfc33;">
                    <i class="fas fa-camera" style="color:#1976a5;"></i>
                    <input type="file" id="profileImgInput" name="profileImg" accept="image/*" style="display:none;">
                </label>
                <button type="button" id="removeProfileImgBtn" class="profile-action" style="background:#fff; border:none; border-radius:50%; padding:6px; cursor:pointer; box-shadow:0 2px 8px #cadcfc33; margin-left:2px;">
                    <i class="fas fa-trash" style="color:#e74c3c;"></i>
                </button>
            </form>
        </div>
        <div class="sidebar-profile-name"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></div>
        <div class="sidebar-profile-role" >REVIEWER</div>
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
            <a href="public_repo.php"><i class="fas fa-file-alt"></i>Public Repository</a>
            <a href="proposal_title.php"><i class="fas fa-file-alt"></i>Title Proposal</a>
            
            <a href="View_thesis.php"><i class="fas fa-file-alt"></i> Review</a>
            <a href="revice.php"><i class="fas fa-file-alt"></i> Revised</a>
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
                <div class="dashboard-card-value" id="pendingCount">0</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-title"><i class="fas fa-check-circle"></i> Total Approved</div>
                <div class="dashboard-card-value" id="approvedCount">0</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-title"><i class="fas fa-file-alt"></i> Public Repo</div>
                <div class="dashboard-card-value" id="publicCount">0</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-title"><i class="fas fa-times-circle"></i> Total Rejected</div>
                <div class="dashboard-card-value" id="rejectedCount">0</div>
            </div>
        </div>
        <main>
            <div id="userTableBody"></div>
        </main>
    </div>
</body>
<script>
function animateCount(id, end) {
    let start = 0;
    const duration = 900;
    const step = Math.ceil(end / (duration / 16));
    const el = document.getElementById(id);
    function update() {
        start += step;
        if (start >= end) {
            el.textContent = end;
        } else {
            el.textContent = start;
            requestAnimationFrame(update);
        }
    }
    update();
}
async function loadDashboardStats() {
    const res = await fetch("../../php/reviewer/reviewer_dashboard_stats.php");
    const stats = await res.json();
    if (stats.error) {
        alert(stats.error);
        return;
    }
    animateCount("pendingCount", stats.pending);
    animateCount("approvedCount", stats.approved);
    animateCount("rejectedCount", stats.rejected);
    animateCount("publicCount", stats.public);
}
window.addEventListener("DOMContentLoaded", loadDashboardStats);

document.getElementById('profileImgInput').addEventListener('change', async function() {
    const formData = new FormData();
    formData.append('profileImg', this.files[0]);
    const res = await fetch('../../php/reviewer/upload_profile.php', {
        method: 'POST',
        body: formData
    });
    const data = await res.json();
    if (data.success && data.newImg) {
        document.getElementById('profileImg').src = '../../assets/ImageProfile/' + data.newImg + '?t=' + Date.now();
    } else {
        alert(data.error || 'Upload failed.');
    }
});
</script>
</html>