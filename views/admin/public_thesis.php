<?php
session_start();

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="../../assets/css/Admin_Page.css?v=1.0.2" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .profile-image {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2.5px solid #1976a5;    
            box-shadow: 0 2px 8px #cadcfc33;
            margin-right: 10px;
            background: #f4f8ff;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .profile-image:hover {
            box-shadow: 0 4px 16px #1976a555;
            border-color: #2893c7;
        }

        body {
	        background-color: var(--off-white);
            
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            color: #222;
        }
        header {
            background: var(--primary);
            color: #fff;
            padding: 1.2rem 0 1rem 0;
            box-shadow: 0 2px 8px rgba(0,36,107,0.07);
        }
        header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2vw;
        }
        header h1 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 1.5rem;
            font-weight: 500;
            transition: color 0.2s;
            font-size: 1rem;
        }
        nav a:hover, nav a.active {
            color: #cadcfc;
        }
        nav .btn-danger {
            background: #e74c3c;
            color: #fff;
            padding: 0.4rem 1.1rem;
            border-radius: 6px;
            margin-left: 2rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        nav .btn-danger:hover {
            background: #c0392b;
        }
        .container {
            max-width: 1200px;
            margin: 2.5rem auto 0 auto;
            padding: 0 2vw;
        }
        h1 {
            color: #00246b;
            font-size: 1.4rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .upload-item {
            background:  #95a3e7;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,36,107,0.08);
            padding: 1.2rem 1rem 1rem 1rem;
            width: 320px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            transition: box-shadow 0.2s, transform 0.2s;
            cursor: pointer;
            position: relative;
        }
        .upload-item:hover {
            box-shadow: 0 8px 32px rgba(0,36,107,0.16);
            transform: translateY(-4px) scale(1.02);
        }
        .upload-item h3 {
            color: #00246b;
            font-size: 1.1rem;
            margin: 0 0 0.5rem 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .upload-item p {
            color: #444;
            font-size: 0.98rem;
            margin: 0 0 0.7rem 0;
            min-height: 48px;
        }
        .author-info {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: #1a3a8f;
            font-size: 0.97rem;
            margin-bottom: 0.7rem;
        }
        .upload-item embed {
            border-radius: 8px;
            border: 1px solid #cadcfc;
            margin-bottom: 0.7rem;
            width: 100%;
            height: 180px;
            background: #f4f8fb;
        }
        .status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #cadcfc;
            color: #00246b;
            font-size: 0.92rem;
            font-weight: 600;
            padding: 0.25rem 0.7rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            box-shadow: 0 2px 8px rgba(0,36,107,0.07);
        }
        @media (max-width: 900px) {
            .thesis-cards {
                gap: 1.2rem;
            }
            .upload-item {
                width: 95vw;
                max-width: 370px;
            }
        }
        @media (max-width: 600px) {
            header .container, .container {
                padding: 0 2vw;
            }
            .thesis-cards {
                flex-direction: column;
                gap: 1.2rem;
            }
            .upload-item {
                width: 98vw;
                max-width: 99vw;
            }
        }
        /* Unique Modal Styles for Public Thesis */
        .public-modal {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,36,107,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3000;
        }
        .public-modal-content {
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
        .public-modal-header {
            display: flex;
            align-items: center;
            gap: 18px;
            background: #00246b;
            padding: 18px 28px 14px 28px;
            border-bottom: 1.5px solid #e9f0ff;
        }
        .public-modal-header h2 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 4px 0;
            letter-spacing: 0.5px;
        }
        .public-modal-icon {
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
        .public-modal-body {
            padding: 18px 28px 24px 28px;
            overflow-y: auto;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 60vh;
        }
        .public-modal-abstract {
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
        .public-modal-author {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #1a3a8f;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 1rem;
        }
        .public-modal-status {
            background: #ffe082;
            color: #333;
            border-radius: 6px;
            padding: 2px 12px;
            font-size: 1rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 2px;
        }
        #publicModalPDF {
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
        .public-modal-close {
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
        .public-modal-close:hover {
            color: #e74c3c;
        }
        @media (max-width: 900px) {
            .public-modal-content {
                width: 99vw;
                max-width: 99vw;
                max-height: 99vh;
            }
            .public-modal-body {
                max-height: 35vh;
            }
            #publicModalPDF {
                height: 15vh;
                max-height: 20vh;
            }
        }
        #allPublicTheses {
            /* border: 1px solid #00246b; */
            height: 700px;
            overflow-y: auto;
            width: 100%;
        }
        .thesis-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.2rem;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Admin Dashboard</h1>
            <nav>
                <a href="admin_dashboard.php">Home</a>
                <a href="Display_Reviewer.php">Manage Reviewers</a>
                <a href="public_thesis.php">Publication thesis</a>
                <a href="#" class="btn btn-danger" id="logoutBtn">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">
        
        <h1>All Public Thesis</h1>
        <div id="allPublicTheses">
            <!-- Student tiles will be dynamically added here -->
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../js/admin_dashboard.js?v=1.0.2"></script>
<script >

    

    function capitalize(str) {
        if (!str) return "";
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    }
    async function showPublicRepo() {
			const res = await fetch("../../php/student/get_public_repo.php");
			const data = await res.json();
			allPublicTheses = data;
			renderPublicRepo(data);
		}

		function renderPublicRepo(data) {
			let rows = "<div class='thesis-cards'>";
			for (const u of data) {
				const filePath = "../../assets/thesisfile/" + u.ThesisFile;
				const profileImg = "../../assets/ImageProfile/" + u.profileImg;
				rows += `

					<div class="upload-item" onclick="openModal('${filePath}', '${u.title}', '${u.abstract}', '${u.lname}, ${u.fname}', '${u.Privacy}')">
                        <div class="author-info">
                            <img src="${profileImg}" alt="Profile Image" class="profile-image">
                            <span style="font-size: 1.2rem; font-weight: 600; letter-spacing: 0.5px;">
                                ${capitalize(u.lname)}, ${capitalize(u.fname)}
                            </span>
                        </div>
						<h3><i class='fas fa-book'></i> ${u.title}</h3>
						<p><i class='fas fa-quote-left'></i> ${u.abstract}</p>

						<embed src="${filePath}" type="application/pdf" width="300" height="250">
						<div class="status-badge">
							<i class="fas fa-check"></i> ${u.Privacy || 'Public'}
						</div>
					</div>
				`;
			}
			rows += "</div>";
			document.getElementById("allPublicTheses").innerHTML = rows;
		}
        showPublicRepo()    
</script>

<!-- Public Thesis Modal -->
<div id="publicModal" class="public-modal" style="display:none;">
  <div class="public-modal-content">
    <span class="public-modal-close" id="closePublicModal">&times;</span>
    <div class="public-modal-header">
      <div class="public-modal-icon"><i class="fas fa-book-open"></i></div>
      <div>
        <h2 id="publicModalTitle"></h2>
        <div class="public-modal-status" id="publicModalStatus"></div>
      </div>
    </div>
    <div class="public-modal-body">
      <p id="publicModalAbstract" class="public-modal-abstract"></p>
      <div class="public-modal-author" id="publicModalOwner"></div>
      <iframe id="publicModalPDF" src="" width="100%" style="border-radius:12px;box-shadow:0 2px 12px #1976a522;margin-top:18px;border:2px solid #e9f0ff;"></iframe>
    </div>
  </div>
</div>

<script>
    // Modal open function
    function openModal(filePath, title, abstract, owner, status) {
        document.getElementById('publicModalTitle').textContent = title;
        document.getElementById('publicModalStatus').textContent = status || "Public";
        document.getElementById('publicModalAbstract').innerHTML = `<i class="fas fa-quote-left"></i> ${abstract}`;
        document.getElementById('publicModalOwner').innerHTML = `<i class="fas fa-user-graduate"></i> <span>${owner}</span>`;
        document.getElementById('publicModalPDF').src = filePath + "#toolbar=0";
        document.getElementById('publicModal').style.display = "flex";
    }

    // Modal close logic
    document.addEventListener('DOMContentLoaded', function() {
        const closeBtn = document.getElementById('closePublicModal');
        const modal = document.getElementById('publicModal');
        const modalPDF = document.getElementById('publicModalPDF');
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
</script>
</body>
</html>