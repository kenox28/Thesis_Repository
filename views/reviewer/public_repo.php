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
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            background: linear-gradient(135deg, var(--primary-color), #34495e);
            padding: 1.5rem;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
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
        }

        .user-info h3 {
            margin: 0;
            font-size: 1.1rem;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--primary-color);
            padding: 0.7rem 1.2rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links a:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
        }

        .nav-links a.active {
            background-color: var(--secondary-color);
            color: white;
        }

        #PDFFILE {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
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

            .profile-section {
                flex-direction: column;
                text-align: center;
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
        <h1><i class="fas fa-check-circle"></i> Approved Theses</h1>
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
        <a href="public_repo.php" class="active"><i class="fas fa-file-alt"></i>Public Repository</a>
        <a href="View_thesis.php" ><i class="fas fa-file-alt"></i> Review</a>
        <a href="revice.php"><i class="fas fa-file-alt"></i> Revised</a>

        <a href="thesis_approved.php"><i class="fas fa-check-circle"></i> Approved</a>
        <a href="thesis_rejected.php"><i class="fas fa-times-circle"></i> Rejected</a>
        <a href="../../php/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <main>
        <div id="PDFFILE"></div>
    </main>
</body>
<script>
async function showupload() {
    const res = await fetch("../../php/student/get_public_repo.php");
    const data = await res.json();

    if (data.error) {
        document.getElementById("PDFFILE").innerHTML = `
            <div class="upload-item">
                <p><i class="fas fa-exclamation-circle"></i> ${data.error}</p>
            </div>`;
        return;
    }

    let rows = "";
    for (const u of data) {
        const filePath = "../../assets/thesisfile/" + u.ThesisFile;
        rows += `
            <div class="upload-item">
                <h3><i class="fas fa-book"></i> ${u.title}</h3>
                <p><i class="fas fa-quote-left"></i> ${u.abstract}</p>
                <div class="author-info">
                    <i class="fas fa-user-graduate"></i>
                    <span>${u.lname}, ${u.fname}</span>
                </div>
                <embed src="${filePath}" type="application/pdf">
                <div class="status-badge">
                    <i class="fas fa-check"></i> ${u.Privacy}
                </div>
            </div>
        `;
    }

    document.getElementById("PDFFILE").innerHTML = rows;
}
showupload();
</script>
</html>