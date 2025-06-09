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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .modal {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,36,107,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3000;
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
            border: 2px solid #1976a5;
            position: relative;
            overflow: hidden;
        }
        .modal-header {
            display: flex;
            align-items: center;
            gap: 18px;
            background: linear-gradient(90deg, #1976a5 60%, #2893c7 100%);
            padding: 18px 28px 14px 28px;
            border-bottom: 1.5px solid #e9f0ff;
            flex-shrink: 0;
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
            overflow-y: auto !important;
            max-height: 55vh !important;
            flex: 1 1 auto;
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
            height: 30vh !important;
            min-height: 120px !important;
            max-height: 35vh !important;
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
                max-height: 99vh !important;
            }
            .modal-body {
                max-height: 35vh !important;
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
                height: 15vh !important;
                max-height: 20vh !important;
            }
        }
        /* Unique Modal Styles for Revise Page */
        .revise-modal-unique {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,36,107,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3000;
        }
        .revise-modal-unique-content {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 40px #1976a522, 0 1.5px 0 #cadcfc;
            padding: 0;
            max-width: 700px;
            width: 95vw;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            border: 2px solid #1976a5;
            position: relative;
            overflow: hidden;
        }
        .revise-modal-unique-header {
            display: flex;
            align-items: center;
            gap: 18px;
            background: linear-gradient(90deg, #1976a5 60%, #2893c7 100%);
            padding: 18px 28px 14px 28px;
            border-bottom: 1.5px solid #e9f0ff;
        }
        .revise-modal-unique-header h2 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 4px 0;
            letter-spacing: 0.5px;
        }
        .revise-modal-unique-icon {
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
        .revise-modal-unique-body {
            padding: 18px 28px 24px 28px;
            overflow-y: auto;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 60vh;
        }
        .revise-modal-unique-abstract {
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
        .revise-modal-unique-author {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #1a3a8f;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 1rem;
        }
        .revise-modal-unique-status {
            background: #ffe082;
            color: #333;
            border-radius: 6px;
            padding: 2px 12px;
            font-size: 1rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 2px;
        }
        .revise-modal-unique-history-btn {
            background: #1976a5;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 18px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 10px;
            transition: background 0.2s;
        }
        .revise-modal-unique-history-btn:hover {
            background: #12507b;
        }
        .revise-modal-unique-file-btn {
            margin-bottom: 8px;
        }
        .revise-modal-unique-upload-btn {
            background: #1976a5;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 18px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-left: 8px;
            transition: background 0.2s;
        }
        .revise-modal-unique-upload-btn:hover {
            background: #12507b;
        }
        #reviseModalUniquePDF {
            width: 100%;
            height: 30vh;
            min-height: 120px;
            max-height: 35vh;
            border-radius: 10px;
            box-shadow: 0 2px 12px #1976a522;
            margin-top: 8px;
            border: 1.5px solid #e9f0ff;
            background: #f7faff;
        }
        .revise-modal-unique-close {
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
        .revise-modal-unique-close:hover {
            color: #e74c3c;
        }
        @media (max-width: 900px) {
            .revise-modal-unique-content {
                width: 99vw;
                max-width: 99vw;
                max-height: 99vh;
            }
            .revise-modal-unique-body {
                max-height: 35vh;
            }
            #reviseModalUniquePDF {
                height: 15vh;
                max-height: 20vh;
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
                <button id="modalHistoryBtn" class="custom-download-btn" style="margin-bottom:10px;">Revision History</button>
                <form id="updateForm" enctype="multipart/form-data" style="margin: 16px 0;">
                    <input type="hidden" name="title" id="modalTitleInput">
                    <input class="custom-file-btn" type="file" name="revised_file" accept="application/pdf" required style="margin-bottom:8px;">
                    <button type="submit" class="custom-upload-btn">Update File</button>
                </form>
                <iframe id="modalPDF" src="" width="100%" height="55vh" style="border-radius:12px;box-shadow:0 2px 12px #1976a522;margin-top:18px;border:2px solid #e9f0ff;"></iframe>
            </div>
        </div>
    </div>
    <!-- Revise Modal (unique classes/IDs) -->
    <div id="reviseModalUnique" class="revise-modal-unique" style="display:none;">
        <div class="revise-modal-unique-content">
            <span class="revise-modal-unique-close" id="closeReviseModalUnique">&times;</span>
            <div class="revise-modal-unique-header">
                <div class="revise-modal-unique-icon"><i class="fas fa-book-open"></i></div>
                <div>
                    <h2 id="reviseModalUniqueTitle"></h2>
                    <div class="revise-modal-unique-status" id="reviseModalUniqueStatus"></div>
                </div>
            </div>
            <div class="revise-modal-unique-body">
                <p id="reviseModalUniqueAbstract" class="revise-modal-unique-abstract"></p>
                <div class="revise-modal-unique-author" id="reviseModalUniqueOwner"></div>
                <button id="reviseModalUniqueHistoryBtn" class="revise-modal-unique-history-btn">Revision History</button>
                <form id="reviseModalUniqueUpdateForm" enctype="multipart/form-data" style="margin: 16px 0;">
                    <input type="hidden" name="title" id="reviseModalUniqueTitleInput">
                    <input class="revise-modal-unique-file-btn" type="file" name="revised_file" accept="application/pdf" required style="margin-bottom:8px;">
                    <button type="submit" class="revise-modal-unique-upload-btn">Update File</button>
                </form>
                <iframe id="reviseModalUniquePDF" src="" width="100%" style="border-radius:12px;box-shadow:0 2px 12px #1976a522;margin-top:18px;border:2px solid #e9f0ff;"></iframe>
            </div>
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
        if (u.status && u.status.toLowerCase() === "revised") {
            const filePath = "../../assets/thesisfile/" + u.ThesisFile;
            rows += `
                <div class="thesis-card"
                    data-file="${filePath}"
                    data-title="${encodeURIComponent(u.title)}"
                    data-abstract="${encodeURIComponent(u.abstract)}"
                    data-owner="${encodeURIComponent(u.lname + ', ' + u.fname)}"
                    data-status="${encodeURIComponent(u.status)}"
                    style="cursor:pointer;"
                >
                    <div class="thesis-card-title">${u.title}</div>
                    <div class="thesis-card-abstract">${u.abstract}</div>
                    <embed src="${filePath}" type="application/pdf" width="300" height="250">
                    <div class="thesis-card-owner">${u.lname}, ${u.fname}</div>
                    <div class="thesis-card-status">${u.status || "Revised"}</div>
                </div>
            `;
        }
    }
    rows += "</div>";
    document.getElementById("PDFFILE").innerHTML = rows;

    // Modal open logic for .thesis-card
    document.querySelectorAll('.thesis-card').forEach(item => {
        item.addEventListener('click', function (e) {
            const filePath = item.getAttribute('data-file');
            const title = decodeURIComponent(item.getAttribute('data-title'));
            const abstract = decodeURIComponent(item.getAttribute('data-abstract'));
            const owner = decodeURIComponent(item.getAttribute('data-owner'));
            const status = decodeURIComponent(item.getAttribute('data-status'));

            document.getElementById('reviseModalUniqueTitle').textContent = title;
            document.getElementById('reviseModalUniqueStatus').textContent = status || "Revised";
            document.getElementById('reviseModalUniqueAbstract').innerHTML = `<i class="fas fa-quote-left"></i> ${abstract}`;
            document.getElementById('reviseModalUniqueOwner').innerHTML = `<i class="fas fa-user-graduate"></i> <span>${owner}</span>`;
            document.getElementById('reviseModalUniquePDF').src = filePath + "#toolbar=0";
            document.getElementById('reviseModalUniqueTitleInput').value = title;
            document.getElementById('reviseModalUnique').style.display = "flex";
        });
    });
}
showupload();

// Modal close logic
document.addEventListener('DOMContentLoaded', function() {
    const closeBtn = document.getElementById('closeReviseModalUnique');
    const modal = document.getElementById('reviseModalUnique');
    const modalPDF = document.getElementById('reviseModalUniquePDF');
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
    // Revision History button
    const historyBtn = document.getElementById('reviseModalUniqueHistoryBtn');
    if (historyBtn) {
        historyBtn.onclick = function() {
            const title = document.getElementById('reviseModalUniqueTitle').textContent;
            window.location.href = 'revise_history.php?title=' + encodeURIComponent(title);
        };
    }
});

// Handle update form submit (no backend change needed)
document.addEventListener('submit', async function(e) {
    if (e.target && e.target.id === 'reviseModalUniqueUpdateForm') {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const res = await fetch('../../php/student/updated_revised_file.php', {
            method: 'POST',
            body: formData
        });
        const result = await res.json();
        if (result.status === 'success') {
            Swal.fire({
                icon: "success",
                title: "Success",
                text: result.message,
                confirmButtonColor: "#1976a5",
            });
            document.getElementById('closeReviseModalUnique').click();
            showupload(); // Refresh the list
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: result.message || 'Failed to update file.',
                confirmButtonColor: "#1976a5",
            });
        }
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