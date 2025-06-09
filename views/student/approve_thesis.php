<?php
session_start();
$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Theses</title>
    <link rel="stylesheet" href="../../assets/css/homepage.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
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
                    <h1 class="section-title">Approved Theses</h1>
                    <!-- <h3 class="section-subtitle"><?php echo $_SESSION['fname']; ?> <?php echo $_SESSION['lname']; ?></h3> -->
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
async function showupload() {
    const res = await fetch("../../php/student/approve_thesis.php");
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
            rows += `
                <div class="upload-item"
                    data-file="${filePath}"
                    data-title="${encodeURIComponent(u.title)}"
                    data-abstract="${encodeURIComponent(u.abstract)}"
                    data-owner="${encodeURIComponent(u.lname + ', ' + u.fname)}"
                    data-status="${encodeURIComponent(u.status)}"
                    style="cursor:pointer;"
                >
                    <h3><i class='fas fa-book'></i> ${u.title}</h3>
                    <p><i class='fas fa-quote-left'></i> ${u.abstract}</p>
                    <div class="author-info">
                        <i class="fas fa-user-graduate"></i>
                        <span>${u.lname}, ${u.fname}</span>
                    </div>
                    <embed src="${filePath}" type="application/pdf">
                    <div class="status-badge">
                        <i class="fas fa-check"></i> ${u.status || "Approved"}
                    </div>
                    <div style="margin-top:12px;display:flex;gap:10px;">
                        <button class="thesis-card-public-private" onclick="event.stopPropagation(); privacyfunction(${u.id}, '${u.title.replace(/'/g, "\\'")}', 'public')">Public</button>
                        <button class="thesis-card-public-private" onclick="event.stopPropagation(); privacyfunction(${u.id}, '${u.title.replace(/'/g, "\\'")}', 'private')">Private</button>
                    </div>
                </div>
            `;
        }
    }
    rows += "</div>";
    document.getElementById("PDFFILE").innerHTML = rows;

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

showupload();

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
    async function privacyfunction(thesisId, title, privacy) {
        try {
            const res = await fetch("../../php/student/update_privacy.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: thesisId, title: title, privacy: privacy })
            });
            const text = await res.text();
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                // alert("Server error:\n" + text);
                console.log(text)
                return;
            }
            if (data.status === "success") {
                Swal.fire({     
                    icon: "success",
                    title: "Success",
                    text: "Privacy updated to " + privacy + "!",
                    confirmButtonColor: "#1976a5",
                });
                showupload(); // Refresh the list if you want
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message || "Failed to update privacy.",
                    confirmButtonColor: "#1976a5",
                });
                }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error updating privacy: " + error,
            });
        }
    }
</script>
</body>
</html>