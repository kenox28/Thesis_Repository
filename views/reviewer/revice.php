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
            height: 80px;
            display: flex;
            justify-content: space-evenly;
        }

        .header h1 {
            margin: 0;
            display: flex;
            align-items: center;
            /* border: solid 2px white; */
            width: 50%;
            padding: 2.5rem;
        }

        .profile-section {
            display: flex;
            justify-content: end;
            align-items: center;
            gap: 2rem;
            margin-top: 1rem;
            /* border: solid 2px green; */
            width: 50%;
        }

        .profile-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--success-color);
        }
        .user-info {
            display: flex;
            flex-direction: column;
            margin-right: 4rem;
        }

        .user-info h3 {
            margin: 0;
            font-size: 1.1rem;
        }
        .nav-links {
            display: flex;
            justify-content: center;
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

        .nav-links a:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        .nav-links a.active {
            background-color: var(--secondary-color);
            color: white;
        }

        #reviseModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 1000px;
            max-height: 90vh;
            overflow: auto;
            position: relative;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .close-button {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-color);
            transition: color 0.3s ease;
        }

        .close-button:hover {
            color: var(--accent-color);
        }

        #toolbar {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        #toolbar button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            background-color: var(--secondary-color);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        #toolbar button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        #pdf-container {
            position: relative;
            width: 100%;
            height: 70vh;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: white;
        }

        #reviseForm {
            margin-top: 1rem;
            display: flex;
            justify-content: center;
        }

        #reviseForm button {
            padding: 0.8rem 1.5rem;
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        #reviseForm button:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }
        #userTableBody {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }

        
        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                align-items: center;
            }

            .modal-content {
                width: 95%;
                padding: 1rem;
            }

            #toolbar {
                justify-content: center;
            }

            #pdf-container {
                height: 50vh;
            }
        }
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

        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                align-items: center;
            }


        #PDFFILE {
            grid-template-columns: 1fr;
            padding: 1rem;
        }

        .upload-item {
            margin-bottom: 1rem;
        }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-check-circle"></i> Revice </h1>
        <div class="profile-section">
            <img src="../../assets/imageProfile/<?php echo htmlspecialchars($profileImg); ?>" alt="Profile" class="profile-image">
            <div class="user-info">
                <h3><i class="fas fa-user"></i> <?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname'] ?></h3>
                <h3><i class="fas fa-envelope"></i> <?php echo $_SESSION['email'] ?></h3>
            </div>
        </div>
    </div>

    <div class="nav-links">
        <a href="dashboard.php" ><i class="fas fa-home"></i> Dashboard</a>
        <a href="public_repo.php"><i class="fas fa-file-alt"></i>Public Repository</a>
        <a href="View_thesis.php" class="active"><i class="fas fa-file-alt"></i> Review</a>
        <a href="revice.php"><i class="fas fa-file-alt"></i> Revised</a>

        <a href="thesis_approved.php"><i class="fas fa-check-circle"></i> Approved</a>
        <a href="thesis_rejected.php"><i class="fas fa-times-circle"></i> Rejected</a>
        <a href="../../php/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <main>
        <div id="userTableBody"></div>
    </main>

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
<!-- <script src="../../js/view_thesis.js?v=1.0.5"></script> -->
<script>
    
async function showupload() {
	try {
		const res = await fetch("../../php/reviewer/revthesis.php");
		const data = await res.json();

		if (data.error) {
			document.getElementById(
				"userTableBody"
			).innerHTML = `<p>${data.error}</p>`;
			return;
		}

		let rows = "";
		for (const u of data) {
			const filePath = "../../assets/thesisfile/" + u.ThesisFile;

			rows += `
                <div class="upload-item" style="margin-bottom: 20px;">
                    <h3>${u.title}</h3>
                    <p>${u.abstract}</p>
                    <embed src="${filePath}" width="600" height="400" type="application/pdf">
                    <button onclick="window.location.href='view_Revise.php?thesis_id=${u.id}'">Revision History</button>
                </div>
				
            `;
		}

		document.getElementById("userTableBody").innerHTML = rows;
	} catch (error) {
		console.error("Error fetching uploads:", error);
		document.getElementById(
			"userTableBody"
		).innerHTML = `<p>Something went wrong.</p>`;
	}
}
showupload();
</script>
</html>