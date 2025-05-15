<?php
session_start();
$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revision History</title>
    <link rel="stylesheet" href="../../assets/css/homepage.css" />
    <style>
        .history-container {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px #1976a522;
            padding: 32px 28px 24px 28px;
            position: relative;
        }
        .history-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 18px;
            color: #1976a5;
            text-align: center;
        }
        .revision-timeline {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 32px;
            overflow-x: auto;
            padding-bottom: 16px;
            margin-top: 30px;
            position: relative;
        }
        .revision-item {
            position: relative;
            background: #f5f7fa;
            border-radius: 8px;
            padding: 18px 20px 18px 20px;
            min-width: 220px;
            max-width: 260px;
            box-shadow: 0 1px 6px #1976a511;
            border-top: 4px solid #1976a5;
            flex-shrink: 0;
            text-align: left;
            margin-bottom: 0;
        }
        .revision-item .dot {
            position: absolute;
            top: -18px;
            left: 50%;
            transform: translateX(-50%);
            width: 16px;
            height: 16px;
            background: #1976a5;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #e3eaf2;
            z-index: 2;
        }
        .revision-item .connector {
            position: absolute;
            top: -10px;
            left: 100%;
            width: 32px;
            height: 4px;
            background: #e3eaf2;
            z-index: 1;
        }
        .revision-item:last-child .connector {
            display: none;
        }
        .revision-item b {
            color: #1976a5;
            font-size: 1.1rem;
        }
        .revision-item a {
            color: #1976a5;
            text-decoration: underline;
            font-weight: 500;
        }
        .revision-item .notes {
            display: block;
            margin-top: 8px;
            color: #444;
            font-style: italic;
        }
        .no-revisions {
            text-align: center;
            color: #888;
            margin-top: 40px;
            font-size: 1.1rem;
        }
        @media (max-width: 700px) {
            .history-container {
                padding: 12px 2vw;
            }
            .revision-item {
                min-width: 180px;
                max-width: 220px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-bg">
        <nav class="main-nav">
            <div class="nav-logo">
                <img src="../../assets/icons/logo.png" alt="Logo" class="logo-img" onerror="this.style.display='none'">
            </div>
            <div class="nav-links">
                <a href="public_repo.php">Home</a>
                <a href="upload.php">Upload Thesis</a>
                <a href="homepage.php">Pending</a>
                <a href="approve_thesis.php">Approve</a>
                <a href="rejectpage.php">Rejected</a>
                <a href="request.php">Request</a>
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
            <div class="history-container">
                <div class="history-title">Revision History</div>
                <div id="modalforhistory" class="revision-timeline"></div>
            </div>
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
const urlParams = new URLSearchParams(window.location.search);
const title = urlParams.get('title');

async function modalfuntion() {
    try {
        const res = await fetch(`../../php/student/get_thesis_history.php?title=${encodeURIComponent(title)}`);
        const data = await res.json();

        let rows = "";
        if (data.error || !Array.isArray(data) || data.length === 0) {
            rows = `<div class="no-revisions">No revision history found for this thesis.</div>`;
        } else {
            data.forEach((u, idx) => {
                const filePath = "../../assets/revised/" + u.file_name;
                rows += `
                    <div class="revision-item">
                        <div class="dot"></div>
                        ${idx < data.length - 1 ? '<div class="connector"></div>' : ''}
                        <b>Revision #${u.revision_num}</b> <span style="color:#888;">(${u.status})</span><br>
                        <span>by ${u.revised_by} at ${u.revised_at}</span><br>
                        <a href="${filePath}" target="_blank">View PDF</a>
                        ${u.notes ? `<span class="notes">Notes: ${u.notes}</span>` : ""}
                    </div>
                `;
            });
        }
        document.getElementById("modalforhistory").innerHTML = rows;
    } catch (error) {
        document.getElementById("modalforhistory").innerHTML = `<div class="no-revisions">Something went wrong.</div>`;
    }
}
modalfuntion();
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
    </script>
</body>
</html> 