<?php
session_start();
$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revised Theses</title>
    <link rel="stylesheet" href="../../assets/css/homepage.css" />
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
                <h1 class="section-title">Revised Theses</h1>
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
    async function showupload() {
        const res = await fetch("../../php/student/revisepage.php");
        const data = await res.json();
        if (data.error) {
            document.getElementById("PDFFILE").innerHTML = `<p>${data.error}</p>`;
            return;
        }
        let rows = "<div class='thesis-cards'>";
        for (const u of data) {
            // Only show revised theses
            if (u.status && u.status.toLowerCase() === "revised") {
                const filePath = "../../assets/thesisfile/" + u.ThesisFile;
                rows += `
                    <div class="thesis-card" onclick="openModal('${filePath}', '${u.title}', '${u.abstract}', '${u.lname}, ${u.fname}', '${u.status}')">
                        <div class="thesis-card-title">${u.title}</div>
                        <div class="thesis-card-abstract">${u.abstract}</div>
                        <div class="thesis-card-owner">${u.lname}, ${u.fname}</div>
                        <div class="thesis-card-status">${u.status || "Revised"}</div>
                    </div>
                `;
            }
        }
        rows += "</div>";
        document.getElementById("PDFFILE").innerHTML = rows;
    }
    showupload();

    function openModal(filePath, title, abstract, owner, status) {
        const modal = document.createElement("div");
        modal.className = "modal";
        modal.innerHTML = `
            <div class="modal-content large-modal">
                <span class="close-button">&times;</span>
                <h2>${title}</h2>
                <div class="thesis-card-status" style="margin-bottom:12px;">${status || "Revised"}</div>
                <p>${abstract}</p>
                <p>Owner: ${owner}</p>
                <button onclick="window.location.href='revise_history.php?title=${title}'" class='custom-download-btn'>Revision History</button>
                <form id="updateForm" enctype="multipart/form-data" style="margin: 16px 0;">
                    <input type="hidden" name="title" value="${title}">
                    <input type="file" name="revised_file" accept="application/pdf" required style="margin-bottom:8px;">
                    <button type="submit" class="custom-upload-btn">Update File</button>
                </form>
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
    document.addEventListener('submit', async function(e) {
        if (e.target && e.target.id === 'updateForm') {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const res = await fetch('../../php/student/updated_revised_file.php', {
                method: 'POST',
                body: formData
            });
            const result = await res.json();
            if (result.status === 'success') {
                alert('File updated successfully!');
                document.body.querySelector('.modal .close-button').click();
                showupload(); // Refresh the list
            } else {
                alert(result.message || 'Failed to update file.');
            }
        }
    });
    </script>
</body>
</html>