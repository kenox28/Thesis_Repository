<?php
session_start();

// Check if user is logged in as student or super admin in student view
if (!isset($_SESSION['student_id']) && (!isset($_SESSION['super_admin_id']) || !isset($_SESSION['super_admin_student_view']))) {
    header("Location: ../student_login.php");
    exit();
}

// Include the admin banner
include 'includes/admin_banner.php';

$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejected Theses</title>
    <link rel="stylesheet" href="../../assets/css/homepage.css" />
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
                <a href="approve_thesis.php">Approved</a>
                <a href="approve_title.php">Approved Title</a>
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
            <header>
                <h1 class="section-title">Rejected Theses</h1>
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
    <script>
    function capitalize(str) {
        if (!str) return "";
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    }
    async function showupload() {
        const res = await fetch("../../php/student/rejectpage.php");
        const data = await res.json();
        if (data.error) {
            document.getElementById("PDFFILE").innerHTML = `<p>${data.error}</p>`;
            return;
        }
        let rows = "<div class='thesis-cards'>";
        for (const u of data) {
            // Only show rejected theses
            if (u.status && u.status.toLowerCase() === "rejected") {
                const filePath = "../../assets/thesisfile/" + u.ThesisFile;
                const profileImg = "../../assets/ImageProfile/" + u.profileImg;
                rows += `
                    <div class="thesis-card"
                        data-file="${filePath}"
                        data-title="${encodeURIComponent(u.title)}"
                        data-abstract="${encodeURIComponent(u.abstract)}"
                        data-owner="${encodeURIComponent(u.lname + ', ' + u.fname)}"
                        data-status="${encodeURIComponent(u.status)}"
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
                        <h3 class="thesis-title thesis-card-title" style="cursor:pointer;">
							<i class='fas fa-book'></i> ${u.title}
						</h3>
                        <div class="thesis-card-abstract">${u.abstract}</div>
                        <embed src="${filePath}" type="application/pdf" width="300" height="250">
                        <div class="thesis-card-owner">${u.lname}, ${u.fname}</div>
                        <div class="thesis-card-status">${u.status || "Rejected"}</div>
                    </div>
                `;
            }
        }
        rows += "</div>";
        document.getElementById("PDFFILE").innerHTML = rows;

        // Add modal open logic for .thesis-card
        document.querySelectorAll('.thesis-card').forEach(item => {
            item.addEventListener('click', function (e) {
                const filePath = item.getAttribute('data-file');
                const title = decodeURIComponent(item.getAttribute('data-title'));
                const abstract = decodeURIComponent(item.getAttribute('data-abstract'));
                const owner = decodeURIComponent(item.getAttribute('data-owner'));
                const status = decodeURIComponent(item.getAttribute('data-status'));

                document.getElementById('modalTitle').textContent = title;
                document.getElementById('modalStatus').textContent = status || "Rejected";
                document.getElementById('modalAbstract').innerHTML = `<i class="fas fa-quote-left"></i> ${abstract}`;
                document.getElementById('modalOwner').innerHTML = `<i class="fas fa-user-graduate"></i> <span>${owner}</span>`;
                document.getElementById('modalPDF').src = filePath + "#toolbar=0";
                document.getElementById('thesisModal').style.display = "flex";
            });
        });
    }
    showupload();

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