<?php
session_start();
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
    <style>
        :root {
            --primary-color: #00246B;
            --secondary-color: #1a3a8f;
            --accent-color: #CADCFC;
            --background-color: #CADCFC;
            --text-color: #00246B;
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
        }

        .nav-links {
            display: flex;
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
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-user-tie"></i> Reviewer Dashboard</h1>
        <h3>Welcome, <?php echo $_SESSION['fname']?>!</h3>
    </div>

    <div class="nav-links">
        <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
        <a href="View_thesis.php"><i class="fas fa-file-alt"></i> Review</a>
        <a href="thesis_approved.php"><i class="fas fa-check-circle"></i> Approved</a>
        <a href="thesis_rejected.php"><i class="fas fa-times-circle"></i> Rejected</a>
        <a href="view_Revise.php"><i class="fas fa-edit"></i> View Revised</a>
        <a href="../../php/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <main>
        <div id="userTableBody"></div>
    </main>

    <!-- Modal Structure -->
    <div id="reviseModal">
        <div class="modal-content">
            <button class="close-button" onclick="closeReviseModal()"><i class="fas fa-times"></i></button>
            <h2><i class="fas fa-edit"></i> Revise Thesis</h2>
            <div id="toolbar">
                <button onclick="enableHighlightMode()"><i class="fas fa-highlighter"></i> Highlight</button>
                <button onclick="enableTextMode()"><i class="fas fa-font"></i> Text</button>
                <button onclick="prevPage()"><i class="fas fa-chevron-left"></i> Previous</button>
                <span id="pageIndicator"></span>
                <button onclick="nextPage()">Next <i class="fas fa-chevron-right"></i></button>
            </div>
            <div id="pdf-container">
                <canvas id="highlight-canvas"></canvas>
            </div>
            <form id="reviseForm">
                <input type="hidden" name="thesis_id" id="modal_thesis_id">
                <button type="button" onclick="saveHighlightedPDF()">
                    <i class="fas fa-save"></i> Save & Upload Highlighted PDF
                </button>
            </form>
        </div>
    </div>
</body>
<script src="../../js/view_thesis.js?v=1.0.4"></script>
</html>