<?php
$thesis_id = isset($_GET['thesis_id']) ? $_GET['thesis_id'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revision History</title>
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
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), #34495e);
            padding: 1.5rem;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        header a {
            color: white;
            text-decoration: none;
            padding: 0.7rem 1.2rem;
            border-radius: 6px;
            background-color: var(--secondary-color);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        header a:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
        }

        #userTableBody {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .upload-item {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-color);
        }

        .upload-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .revision-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent-color);
        }

        .revision-number {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .revision-status {
            padding: 0.3rem 0.8rem;
            background-color: var(--primary-color);
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .revision-info {
            color: #666;
            margin-bottom: 1rem;
        }

        .revision-notes {
            background-color: var(--accent-color);
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            font-style: italic;
        }

        .view-pdf-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.2rem;
            background-color: var(--secondary-color);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .view-pdf-btn:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            #userTableBody {
                padding: 1rem;
            }

            .revision-header {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1><i class="fas fa-history"></i> Revision History</h1>
        <a href="view_thesis.php"><i class="fas fa-arrow-left"></i> Back to Thesis</a>
    </header>

    <div id="userTableBody">
        <p>Loading...</p>
    </div>
</body>
<script src="../../js/revise_upload.js"></script>
<script>
const urlParams = new URLSearchParams(window.location.search);
const thesis_id = urlParams.get('thesis_id');

async function showupload() {
    try {
        const res = await fetch(`../../php/reviewer/get_thesis_history.php?thesis_id=${thesis_id}`);
        const data = await res.json();

        if (data.error) {
            document.getElementById("userTableBody").innerHTML = `
                <div class="upload-item">
                    <p><i class="fas fa-exclamation-circle"></i> ${data.error}</p>
                </div>`;
            return;
        }

        let rows = "";
        data.forEach(u => {
            const filePath = "../../assets/revised/" + u.file_name;
            rows += `
                <div class="upload-item">
                    <div class="revision-header">
                        <span class="revision-number">Revision #${u.revision_num}</span>
                        <span class="revision-status">${u.status}</span>
                    </div>
                    <div class="revision-info">
                        <i class="fas fa-user"></i> ${u.reviewer_name || u.revised_by}<br>
                        <i class="fas fa-clock"></i> ${u.revised_at}
                    </div>
                    ${u.notes ? `
                        <div class="revision-notes">
                            <i class="fas fa-comment-alt"></i> ${u.notes}
                        </div>
                    ` : ''}
                    <a href="${filePath}" target="_blank" class="view-pdf-btn">
                        <i class="fas fa-file-pdf"></i> View PDF
                    </a>
                </div>
            `;
        });

        document.getElementById("userTableBody").innerHTML = rows;
    } catch (error) {
        console.error("Error fetching uploads:", error);
        document.getElementById("userTableBody").innerHTML = `
            <div class="upload-item">
                <p><i class="fas fa-exclamation-circle"></i> Something went wrong.</p>
            </div>`;
    }
}
showupload();
</script>
</html>