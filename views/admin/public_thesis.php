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
        .thesis-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: flex-start;
        }
        .upload-item {
            background: #fff;
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
                <a href="view_reports.php">Publication thesis</a>
                <a href="#" class="btn btn-danger" id="logoutBtn">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">
        
        <h1>All Public Thesis</h1>
        <div class="student-container" id="allPublicTheses">
            <!-- Student tiles will be dynamically added here -->
        </div>
    </div>
<script >
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
				rows += `
					<div class="upload-item" onclick="openModal('${filePath}', '${u.title}', '${u.abstract}', '${u.lname}, ${u.fname}', '${u.Privacy}')">
						<h3><i class='fas fa-book'></i> ${u.title}</h3>
						<p><i class='fas fa-quote-left'></i> ${u.abstract}</p>
						<div class="author-info">
							<i class="fas fa-user-graduate"></i>
							<span>${u.lname}, ${u.fname}</span>
						</div>
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
</body>
</html>