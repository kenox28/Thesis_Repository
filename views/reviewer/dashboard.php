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
    <style>
      .sidebar {
        background: linear-gradient(135deg, #1976a5 0%, #2893c7 100%);
        min-height: 100vh;
        width: 260px;
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
        position: relative;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        background: #e9f0ff;
        box-shadow: 0 2px 8px #cadcfc33;
        margin-bottom: 12px;
      }
      .sidebar-profile-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
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
        transition: background 0.18s;
      }
      .sidebar-logout:hover {
        background: #c0392b;
      }
      .dashboard-main {
        margin-left: 260px;
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
        .sidebar { width: 100vw; min-height: 0; flex-direction: row; padding: 12px 0; position: static; box-shadow: none; }
        .dashboard-main { margin-left: 0; padding: 24px 2vw 18px 2vw; }
        .dashboard-cards { flex-direction: column; gap: 18px; }
        .dashboard-welcome { flex-direction: column; align-items: flex-start; padding: 18px 10px; }
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
          <svg width="28" height="28" fill="#fff" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#1976a5"/><path d="M12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm-4.5 3a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0zm10.5-3.5V7a2 2 0 0 0-2-2h-1.17a2 2 0 0 1-1.66-.89l-.34-.51A2 2 0 0 0 9.17 3H8a2 2 0 0 0-2 2v1.5" stroke="#fff" stroke-width="1.5" fill="none"/></svg>
        </label>
      </form>
      <form id="reviewerProfileImgDeleteForm" action="../../php/reviewer/profile_img_delete.php" method="POST" style="display:inline;">
        <button type="submit" class="sidebar-profile-trash" title="Remove Photo">
          <svg width="24" height="24" fill="#fff" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#e74c3c"/><path d="M15 9l-6 6M9 9l6 6" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
        </button>
      </form>
    </div>
    <div class="sidebar-profile-name"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></div>
    <div class="sidebar-profile-role">REVIEWER</div>
    <nav class="sidebar-nav">
      <a href="#" class="active">Dashboard</a>
      <a href="View_thesis.php">Review Requests</a>
      <a href="thesis_approved.php">Approved</a>
      <a href="thesis_rejected.php">Rejected</a>
    </nav>
    <form action="../../php/logout.php" method="POST" style="width:100%;"><button type="submit" class="sidebar-logout">Logout</button></form>
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
        <div class="dashboard-card-title">Pending Reviews</div>
        <div class="dashboard-card-value">2</div>
      </div>
      <div class="dashboard-card">
        <div class="dashboard-card-title">Total Approved</div>
        <div class="dashboard-card-value">5</div>
      </div>
      <div class="dashboard-card">
        <div class="dashboard-card-title">Total Rejected</div>
        <div class="dashboard-card-value">1</div>
      </div>
      <div class="dashboard-card">
        <div class="dashboard-card-title">Total Reviewed</div>
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