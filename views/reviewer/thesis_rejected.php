<?php
session_start();
$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejected Theses</title>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            --reject-color: #00246B;
            --reject-light: #CADCFC;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e9f0ff 0%, #f7faff 100%);
            margin: 0;
            padding: 0;
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
            gap: 12px;
        }

        #PDFFILE {
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
            border-left: 4px solid #e74c3c;
        }

        .upload-item:hover {
            transform: translateY(-6px) scale(1.04);
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
        }

        .upload-item h3 {
            color: #1976a5;
            margin-top: 0;
            font-size: 1.3rem;
            border-bottom: 2px solid #e74c3c;
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
            border: 1px solid #cadcfc;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #e74c3c;
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background-color: #e74c3c;
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .rejection-reason {
            background-color: #cadcfc;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            border-left: 3px solid #e74c3c;
        }

        .rejection-reason p {
            margin: 0;
            color: #e74c3c;
            font-style: italic;
        }

        @media (max-width: 900px) {
            .sidebar { width: 100vw; min-height: 0; flex-direction: row; padding: 12px 0; position: static; box-shadow: none; }
            .main-content { margin-left: 0; padding: 24px 2vw 18px 2vw; }
            .header { margin-left: 0; padding: 1.2rem 1rem; }
            #PDFFILE { grid-template-columns: 1fr; padding: 1rem 0; }
            .upload-item { margin-bottom: 1rem; }
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
            <a href="revice.php"><i class="fas fa-file-alt"></i> Revised</a>
            <a href="thesis_approved.php"><i class="fas fa-check-circle"></i> Approved</a>
            <a href="thesis_rejected.php" class="active"><i class="fas fa-times-circle"></i> Rejected</a>
        </nav>
        <a href="../../php/logout.php" class="sidebar-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </aside>
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-times-circle"></i> Rejected Theses</h1>
        </div>
        <main>
            <div id="PDFFILE"></div>
        </main>
    </div>
</body>
<script>
async function showupload() {
    const res = await fetch("../../php/reviewer/reject_thesis.php");
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
                    <i class="fas fa-times"></i> Rejected
                </div>
                ${u.rejection_reason ? `
                    <div class="rejection-reason">
                        <p><i class="fas fa-comment-alt"></i> ${u.rejection_reason}</p>
                    </div>
                ` : ''}
            </div>
        `;
    }

    document.getElementById("PDFFILE").innerHTML = rows;
}
showupload();

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