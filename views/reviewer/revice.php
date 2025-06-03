<?php
session_start();
$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviewer</title>
    <!-- PDF.js (3.11.174 for compatibility) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <!-- Local pdf-annotate.js -->
    <script src="../../js/pdf-annotate.min.js"></script>
    <!-- PDF-lib -->
    <script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add Google Fonts in <head> -->
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
        .sidebar {
            background: rgba(10, 35, 66, 0.85);
            backdrop-filter: blur(8px);
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
        .main-content {
            margin-left: 250px;
            padding: 40px 5vw 32px 5vw;
            min-height: 100vh;
            background: linear-gradient(135deg, #e9f0ff 0%, #f7faff 100%);
        }
        .header {
            background: linear-gradient(135deg, var(--primary-color), #34495e);
            padding: 1.5rem 2rem 1.5rem 2rem;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 0 0 18px 18px;
            margin-bottom: 32px;
            margin-left: 0;
        }
        .header h1 {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-size: 2.1rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        #userTableBody {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }
        .upload-item {
            background: linear-gradient(135deg, #fff 60%, #e9f0ff 100%);
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 1.5rem;
            transition: transform 0.18s, box-shadow 0.18s;
            position: relative;
        }
        .upload-item:hover {
            transform: translateY(-6px) scale(1.04);
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
        }
        .upload-item h3 {
            color: #1976a5;
            margin-top: 0;
            font-size: 1.3rem;
            border-bottom: 2px solid #1a3a8f;
            padding-bottom: 0.5rem;
        }
        .upload-item p {
            color: #666;
            line-height: 1.6;
            margin: 1rem 0;
        }
        .upload-item button{
            border: solid 2px green;
            padding: 5px;
            background: #00246B;
            color: #fff;
            border: none;
            border-radius: 7px;
            padding: 8px 15px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.18s, box-shadow 0.18s;
            box-shadow: 0 2px 8px #cadcfc33;
            margin-top: 0.5rem;
        }

        .upload-item button:hover {
            background:rgba(1, 5, 252, 0.7);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
            color: #1a3a8f;
            font-weight: 500;
        }
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background-color: #4fd1c5;
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-top: 1rem;
        }
        @media (max-width: 900px) {
            .sidebar { width: 100vw; min-height: 0; flex-direction: row; padding: 12px 0; position: static; box-shadow: none; }
            .main-content { margin-left: 0; padding: 24px 2vw 18px 2vw; }
            .header { margin-left: 0; padding: 1.2rem 1rem; }
            #userTableBody { grid-template-columns: 1fr; padding: 1rem 0; }
            .upload-item { margin-bottom: 1rem; }
        }
        /* Modal Overlay */
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

        /* Modal Content */
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

        /* Modal Header */
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

        /* Modal Body */
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
            <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="public_repo.php"><i class="fas fa-file-alt"></i>Public Repository</a>
            <a href="View_thesis.php"><i class="fas fa-file-alt"></i> Review</a>
            <a href="revice.php" class="active"><i class="fas fa-file-alt"></i> Revised</a>
        <a href="thesis_approved.php"><i class="fas fa-check-circle"></i> Approved</a>
        <a href="thesis_rejected.php"><i class="fas fa-times-circle"></i> Rejected</a>
        </nav>
        <a href="../../php/logout.php" class="sidebar-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </aside>
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-check-circle"></i> Revise</h1>
    </div>
    <main>
        <div id="userTableBody"></div>
    </main>
    </div>
    <!-- Info Modal for thesis details (view only) -->
    <div id="thesisModal" class="modal" style="display:none;">
        <div class="modal-content enhanced-modal">
            <span class="close-button" id="closeThesisModal">&times;</span>
            <div class="modal-header">
                <div class="modal-icon"><i class="fas fa-book-open"></i></div>
                <div>
                    <h2 id="modalTitle"></h2>
                </div>
            </div>
            <div class="modal-body">
                <p id="modalAbstract" class="modal-abstract"></p>
                <div class="author-info" id="modalOwner"></div>
                <iframe id="modalPDF" src="" width="100%" height="55vh" style="border-radius:12px;box-shadow:0 2px 12px #1976a522;margin-top:18px;border:2px solid #e9f0ff;"></iframe>
            </div>
        </div>
    </div>
    <!-- Modal Structure -->
<div id="reviseModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); z-index:1000; align-items:center; justify-content:center;">
      <div style="background:#fff; padding:20px; border-radius:8px; width:850px; max-width:95vw; max-height:95vh; overflow:auto; position:relative;">
        <button onclick="closeReviseModal()" style="position:absolute; top:10px; right:10px;">&times;</button>
        <h2>Revise Thesis</h2>
        <div id="toolbar">
          <button onclick="enableHighlightMode()">Highlight</button>
          <button onclick="enableTextMode()">Text</button>
          <button onclick="prevPage()">Previous</button>
          <span id="pageIndicator"></span>
          <button onclick="nextPage()">Next</button>
        </div>
        <div id="pdf-container" style="position: relative; width: 800px; height: 800px; border: 1px solid #ccc;">
          <canvas id="highlight-canvas" style="position: absolute; left: 0; top: 0; z-index: 10; pointer-events: none;"></canvas>
        </div>
        <form id="reviseForm">
            <input type="hidden" name="thesis_id" id="modal_thesis_id">
            <button type="button" onclick="saveHighlightedPDF()">Save & Upload Highlighted PDF</button>
        </form>
      </div>
</div>
</body>
<script>
async function showupload() {
	try {
		const res = await fetch("../../php/reviewer/revthesis.php");
		const data = await res.json();
		if (data.error) {
            document.getElementById("userTableBody").innerHTML = `<p>${data.error}</p>`;
			return;
		}
		let rows = "";
		for (const u of data) {
			const filePath = "../../assets/thesisfile/" + u.ThesisFile;
			rows += `
                <div class="upload-item" 
                    data-file="${filePath}"
                    data-title="${encodeURIComponent(u.title)}"
                    data-abstract="${encodeURIComponent(u.abstract)}"
                    data-owner="${encodeURIComponent(u.lname + ', ' + u.fname)}"
                    style="margin-bottom: 20px; cursor:pointer;">
                    <h3>${u.title}</h3>
                    <p>${u.abstract}</p>
                    <embed src="${filePath}" width="600" height="400" type="application/pdf">
                    <button onclick="window.location.href='view_Revise.php?thesis_id=${u.id}'; event.stopPropagation();">Revision History</button>
                </div>
            `;
		}
		document.getElementById("userTableBody").innerHTML = rows;

        // Add click event to each upload-item (except the button)
        document.querySelectorAll('.upload-item').forEach(item => {
            item.addEventListener('click', function (e) {
                // Prevent modal if the button was clicked
                if (e.target.tagName === 'BUTTON') return;
                const filePath = item.getAttribute('data-file');
                const title = decodeURIComponent(item.getAttribute('data-title'));
                const abstract = decodeURIComponent(item.getAttribute('data-abstract'));
                const owner = decodeURIComponent(item.getAttribute('data-owner'));

                document.getElementById('modalTitle').textContent = title;
                document.getElementById('modalAbstract').innerHTML = `<i class="fas fa-quote-left"></i> ${abstract}`;
                document.getElementById('modalOwner').innerHTML = `<i class="fas fa-user-graduate"></i> <span>${owner}</span>`;
                document.getElementById('modalPDF').src = filePath + "#toolbar=0";

                document.getElementById('thesisModal').style.display = "flex";
            });
        });
	} catch (error) {
		console.error("Error fetching uploads:", error);
        document.getElementById("userTableBody").innerHTML = `<p>Something went wrong.</p>`;
	}
}
showupload();

// Modal close logic
document.getElementById('closeThesisModal').onclick = function () {
    document.getElementById('thesisModal').style.display = "none";
    document.getElementById('modalPDF').src = ""; // Stop PDF loading
};
// Optional: close modal when clicking outside content
document.getElementById('thesisModal').onclick = function(e) {
    if (e.target === this) {
        this.style.display = "none";
        document.getElementById('modalPDF').src = "";
    }
};

document.getElementById('profileImgInput').addEventListener('change', async function() {
    const formData = new FormData();
    formData.append('profileImg', this.files[0]);
    const res = await fetch('../../php/reviewer/profile_img_upload.php', {
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
document.getElementById('removeProfileImgBtn').addEventListener('click', async function(e) {
    e.preventDefault();
    const res = await fetch('../../php/reviewer/profile_img_delete.php', { method: 'POST' });
    const data = await res.json();
    if (data.success && data.defaultImg) {
        document.getElementById('profileImg').src = '../../assets/ImageProfile/' + data.defaultImg + '?t=' + Date.now();
    } else {
        alert(data.error || 'Remove failed.');
    }
});
</script>
</html>