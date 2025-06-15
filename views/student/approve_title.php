<?php
session_start();

// Check if user is logged in as student or super admin in student view
if (!isset($_SESSION['student_id']) && (!isset($_SESSION['super_admin_id']) || !isset($_SESSION['super_admin_student_view']))) {
    header("Location: ../student_login.php");
    exit();
}

// Include the admin banner
include 'includes/admin_banner.php';

$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Progress</title>
    <link rel="stylesheet" href="../../assets/css/homepage.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tiny.cloud/1/kvjcz6i0b3m6d4rkdbdgkmondvsygi1hal3vp3zqy3sl3i8q/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        .profile-image {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2.5px solid #1976a5;
            box-shadow: 0 2px 8px #1976a533;
            margin-right: 10px;
            background: #f4f8ff;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .profile-image:hover {
            box-shadow: 0 4px 16px #1976a555;
            border-color: #2893c7;
        }
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
            background: rgba(0,36,107,0.10);
            display: flex;
            align-items: stretch;
            justify-content: center;
            z-index: 3000;
            width: 100vw;
            height: 100vh;
            padding: 0;
            box-sizing: border-box;
        }
        .revise-modal-unique-content {
            background: #f8fbff;
            border-radius: 0;
            box-shadow: none;
            width: 100vw !important;
            height: 100vh !important;
            max-width: 100vw !important;
            max-height: 100vh !important;
            display: flex;
            flex-direction: column;
            border: none;
            position: relative;
            overflow: hidden;
        }
        .revise-modal-unique-header {
            flex-shrink: 0;
            width: 100%;
            z-index: 2;
            background: linear-gradient(90deg, #1976a5 60%, #2893c7 100%);
            padding: 24px 40px 18px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1.5px solid #e9f0ff;
        }
        .revise-modal-unique-header h2 {
            color: #fff;
            font-size: 2.2rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .revise-modal-unique-close {
            position: static;
            font-size: 2.2rem;
            color: #fff;
            cursor: pointer;
            font-weight: 700;
            transition: color 0.18s;
            z-index: 10;
            text-shadow: 0 2px 8px #1976a5cc;
            margin-left: 18px;
        }
        .revise-modal-unique-close:hover {
            color: #e74c3c;
        }
        .revise-modal-unique-body.side-by-side {
            flex: 1 1 auto;
            display: flex;
            flex-direction: row;
            gap: 0;
            width: 100%;
            height: 100%;
            min-width: 0;
            min-height: 0;
            padding: 0;
            box-sizing: border-box;
            background: none;
        }
        .editor-pane, .preview-pane {
            height: 100%;
            min-height: 0;
            min-width: 0;
            overflow-y: auto;
            padding: 40px 32px 32px 32px;
            box-sizing: border-box;
            background: #fff;
            border-radius: 0;
            box-shadow: none;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        .editor-pane {
            flex: 1 1 0;
            border-right: 1.5px solid #e9f0ff;
            margin-right: 0;
        }
        .preview-pane {
            flex: 2 1 0;
            background: #f7faff;
            border-radius: 0;
            box-shadow: none;
            margin-left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .apa-preview {
            background: #fff;
            border: 1.5px solid #e3eafc;
            border-radius: 18px;
            margin: 0 auto;
            padding: 60px 80px 40px 80px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 22px;
            color: #222;
            width: 100%;
            max-width: 1100px;
            max-height: 80vh;
            min-height: 60vh;
            box-shadow: 0 2px 24px #1976a522;
            line-height: 2.2;
            margin-top: 0;
            height: auto;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            overflow-y: auto;
        }
        .apa-cover {
            text-align: center;
            margin-bottom: 3em;
        }
        .apa-title-top {
            font-size: 1.3em;
            margin-bottom: 1.2em;
        }
        .apa-university {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 1.1em;
            margin-bottom: 0.7em;
        }
        .apa-dept, .apa-degree, .apa-instructor, .apa-date, .apa-author, .apa-members {
            margin-bottom: 0.5em;
            font-size: 1em;
        }
        .apa-author, .apa-members {
            margin-top: 1.2em;
        }
        /* Form field spacing */
        .editor-pane label {
            font-weight: 600;
            margin-bottom: 0.3em;
            margin-top: 1.2em;
            color: #1976a5;
            font-size: 1.15em;
        }
        .editor-pane textarea {
            margin-bottom: 0.8em;
            border-radius: 8px;
            border: 1.5px solid #e9f0ff;
            background: #f7faff;
            font-size: 1.15em;
            padding: 16px 18px;
            transition: border 0.2s;
            resize: vertical;
            min-height: 120px;
        }
        .editor-pane textarea:focus {
            border: 2px solid #1976a5;
            outline: none;
        }
        .revise-modal-unique-upload-btn {
            background: #1976a5;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 16px 0;
            font-size: 1.2em;
            font-weight: 700;
            cursor: pointer;
            margin-top: 2em;
            box-shadow: 0 2px 8px #1976a522;
            transition: background 0.18s;
        }
        .revise-modal-unique-upload-btn:hover {
            background: #12507b;
        }
        .thesis-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px #1976a522, 0 1.5px 0 #cadcfc;
            padding: 1.5rem 1.2rem 1.2rem 1.2rem;
            margin: 18px 0;
            max-width: 420px;
            min-width: 320px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            border: 2px solid #e9f0ff;
            transition: box-shadow 0.2s, border-color 0.2s;
            position: relative;
        }
        .thesis-card:hover {
            background: #f4f8ff;
            box-shadow: 0 8px 32px #1976a544;
            border-color: #1976a5;
        }
        .thesis-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1976a5;
            margin-bottom: 0.5rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: color 0.18s;
        }
        .thesis-card-title:hover {
            color: #12507b;
            text-decoration: underline;
        }
        .thesis-card-abstract {
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
        .thesis-card-owner {
            color: #1a3a8f;
            font-weight: 500;
            font-size: 1rem;
            margin-bottom: 8px;
        }
        .thesis-card-status {
            background: #ffe082;
            color: #333;
            border-radius: 6px;
            padding: 2px 12px;
            font-size: 1rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 2px;
        }
        .thesis-card embed[type='application/pdf'] {
            min-height: 220px;
            max-height: 350px;
            width: 100%;
            background: #f7faff;
            border-radius: 10px;
            border: 1.5px solid #e9f0ff;
            box-shadow: 0 2px 12px #1976a522;
            margin-top: 8px;
        }
        .thesis-card .not-found-message {
            background: #fff3f3;
            color: #c0392b;
            border: 1.5px solid #e57373;
            border-radius: 8px;
            padding: 18px 16px;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 12px 0;
            text-align: center;
            box-shadow: 0 2px 8px #e5737333;
        }
        .thesis-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: center;
        }
        .thesis-card button,
        .thesis-card .status-badge {
            margin-top: 10px;
        }
        #reviseModalUniqueUpdateForm input[type="text"],
        #reviseModalUniqueUpdateForm textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #e9f0ff;
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 8px;
            background: #f7faff;
            transition: border-color 0.2s;
        }
        #reviseModalUniqueUpdateForm input[type="text"]:focus,
        #reviseModalUniqueUpdateForm textarea:focus {
            border-color: #1976a5;
            outline: none;
        }
        #reviseModalUniqueUpdateForm input[type="file"] {
            margin-bottom: 8px;
        }
        /* Hide the default file input */
        input[type="file"].custom-file-input {
            display: none;
        }
        /* Custom file label/button */
        .custom-file-label {
            display: inline-block;
            background: #1976a5;
            color: #fff;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 8px;
            cursor: pointer;
            margin-right: 16px;
            transition: background 0.18s;
            font-size: 1rem;
            border: none;
            box-shadow: 0 2px 8px #1976a522;
        }
        .custom-file-label:hover {
            background: #12507b;
        }
        /* Show selected file name */
        #selectedFileName {
            font-size: 1rem;
            color: #1976a5;
            margin-right: 18px;
            vertical-align: middle;
        }
        .side-by-side {
            display: flex;
            flex-direction: row;
            gap: 32px;
            min-width: 800px;
            min-height: 400px;
            max-width: 1200px;
        }
        .editor-pane {
            flex: 1 1 0;
            padding-right: 16px;
            border-right: 1.5px solid #e9f0ff;
            min-width: 340px;
        }
        .preview-pane {
            flex: 1 1 0;
            padding-left: 16px;
            min-width: 340px;
            background: #f7faff;
            border-radius: 8px;
            box-shadow: 0 1px 4px #cadcfc33;
            overflow-y: auto;
            max-height: 70vh;
        }
        .apa-preview {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 0 auto;
            padding: 48px 60px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #222;
            max-width: 700px;
            min-height: 600px;
            box-shadow: 0 2px 12px #1976a522;
            line-height: 2;
            margin-top: 24px;
        }
        .apa-preview .apa-title {
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 2em;
            letter-spacing: 0.5px;
        }
        .apa-preview .apa-section {
            margin-bottom: 2em;
        }
        .apa-preview .apa-section-title {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 0.5em;
            text-align: left;
        }
        .apa-preview .apa-paragraph {
            text-indent: 2em;
            margin-bottom: 1em;
            text-align: justify;
            white-space: pre-wrap;
        }
        .revise-modal-unique-content {
            max-width: 1200px !important;
            width: 95vw !important;
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
                    <a href="homepage.php">Pending</a>
                    <a href="approve_title.php">Thesis Progress</a>
                    <a href="approve_thesis.php">Approved</a>
                    <a href="rejectpage.php">Rejected</a>
                    <a href="#" id="logout-link">Logout</a>
                </div>
            </div>
        </nav>
        <main class="main-content">
            <header>
                <h1 class="section-title">Thesis Progress</h1>
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
                    <input type="hidden" name="old_title" value="...">
                    <input type="hidden" name="title" value="...">
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
            <div class="revise-modal-unique-header">
                <h2 id="reviseModalUniqueTitle"></h2>
                <span class="revise-modal-unique-close" id="closeReviseModalUnique">&times;</span>
            </div>
            <div class="revise-modal-unique-body side-by-side">
                <div class="editor-pane">
                    <form id="reviseModalUniqueUpdateForm" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 18px; align-items: stretch;">
                        <input type="hidden" name="old_title" value="...">
                        <input type="hidden" name="title" value="...">
                        <input type="hidden" name="title" id="reviseModalUniqueTitleInput">
                        <input type="text" name="newtitle" id="reviseModalUniqueNewTitleInput" placeholder="Title">
                        <label for="reviseModalUniqueIntroductionInput">Introduction</label>
                        <textarea name="introduction" id="reviseModalUniqueIntroductionInput" rows="3" placeholder="Write the introduction..."></textarea>
                        <label for="reviseModalUniqueProjectObjectiveInput">Project Objectives</label>
                        <textarea name="project_objective" id="reviseModalUniqueProjectObjectiveInput" rows="3" placeholder="Write the project objectives..."></textarea>
                        <label for="reviseModalUniqueSignificanceOfStudyInput">Significance of the Study</label>
                        <textarea name="significance_of_study" id="reviseModalUniqueSignificanceOfStudyInput" rows="3" placeholder="Write the significance of the study..."></textarea>
                        <label for="reviseModalUniqueSystemAnalysisAndDesignInput">System Analysis and Design</label>
                        <textarea name="system_analysis_and_design" id="reviseModalUniqueSystemAnalysisAndDesignInput" rows="3" placeholder="Write the system analysis and design..."></textarea>
                        <button type="submit" class="revise-modal-unique-upload-btn" style="width:100%;">Save / Continue</button>
                    </form>
                </div>
                <div class="preview-pane">
                    <div class="apa-preview">
                        <div class="apa-cover">
                            <div class="apa-title-top" id="previewTitle">New</div>
                            <div class="apa-university">EASTERN VISAYAS STATE UNIVERSITY ORMO CITY CAMPUS</div>
                            <div class="apa-dept">Computer Studies</div>
                            <div class="apa-degree">Bachelor of Science in Information Technology</div>
                            <div class="apa-instructor" id="previewInstructor">Instructor: <?php echo isset($_SESSION['instructor']) ? htmlspecialchars($_SESSION['instructor']) : 'Aki chan'; ?></div>
                            <div class="apa-date" id="previewDate"><?php echo date('Y-m-d'); ?></div>
                            <div class="apa-members" id="previewMembers">
                                <?php
                                    $members = isset($_SESSION['members']) ? htmlspecialchars($_SESSION['members']) : 'chan paul, kaye bot, chauny cha';
                                    $membersArr = array_map('trim', explode(',', $members));
                                    echo "With members:";
                                    echo "<br>";
                                    foreach ($membersArr as $member) {
                                        echo $member . "<br>";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="apa-section">
                            <div class="apa-section-title">Introduction</div>
                            <div class="apa-paragraph" id="previewIntroduction"></div>
                        </div>
                        <div class="apa-section">
                            <div class="apa-section-title">Project Objectives</div>
                            <div class="apa-paragraph" id="previewProjectObjective"></div>
                        </div>
                        <div class="apa-section">
                            <div class="apa-section-title">Significance of the Study</div>
                            <div class="apa-paragraph" id="previewSignificanceOfStudy"></div>
                        </div>
                        <div class="apa-section">
                            <div class="apa-section-title">System Analysis and Design</div>
                            <div class="apa-paragraph" id="previewSystemAnalysisAndDesign"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function capitalize(str) {
        if (!str) return "";
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    }

    async function showupload() {
        const res = await fetch("../../php/student/approve_title.php");
        const data = await res.json();
        if (data.error) {
            document.getElementById("PDFFILE").innerHTML = `<p>${data.error}</p>`;
            return;
        }
        let rows = "<div class='thesis-cards'>";
        for (const u of data) {
            if (u.status && (u.status.toLowerCase() === "continue" || u.status.toLowerCase() === "revised")) {
                const filePath = "../../assets/thesisfile/" + u.ThesisFile;
                const profileImg = "../../assets/ImageProfile/" + u.profileImg;
                rows += `
                    <div class="thesis-card"
                        data-file="${filePath}"
                        data-title="${encodeURIComponent(u.title)}"
                        data-chapter="${u.Chapter}"
                        data-message="${encodeURIComponent(u.message)}"
                        data-owner="${encodeURIComponent(u.lname + ', ' + u.fname)}"
                        data-status="${encodeURIComponent(u.status)}"
                        data-id="${u.id}"
                        data-introduction="${encodeURIComponent(u.introduction || '')}"
                        data-project_objective="${encodeURIComponent(u.Project_objective || '')}"
                        data-significance_of_study="${encodeURIComponent(u.significance_of_study || '')}"
                        data-system_analysis_and_design="${encodeURIComponent(u.system_analysis_and_design || '')}"
                        data-chapter="${u.chapter}"
                        
                        style="cursor:pointer;"
                    >
                        <div class="author-info">
                        
                            <a href="profile_timeline.php?id=${u.student_id}" class="profile-link" onclick="event.stopPropagation();">
                                <img src="${profileImg}" alt="Profile Image" class="profile-image">
                            </a>
                            <span style="font-size: 1.2rem; font-weight: 600; letter-spacing: 0.5px;">
                                ${capitalize(u.lname)}, ${capitalize(u.fname)}
                            </span>
                        </div>
                        <h3 class="thesis-title thesis-card-title" style="cursor:pointer;">
                            <i class='fas fa-book'></i> ${u.title}
                        </h3>
                        <p>Chapter ${u.Chapter}</p>
                        <div class="thesis-card-abstract">${u.message || "No message"}</div>
                        <embed src="${filePath}" type="application/pdf" width="300" height="250">
                        <div class="thesis-card-owner">${capitalize(u.lname)}, ${capitalize(u.fname)}</div>
                        <div class="thesis-card-status">${u.status || "Revised"}</div>
                    </div>
                `;
            }
            const chapter = u.chapter;

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
                const introduction = decodeURIComponent(item.getAttribute('data-introduction'));
                const projectObjective = decodeURIComponent(item.getAttribute('data-project_objective'));
                const significanceOfStudy = decodeURIComponent(item.getAttribute('data-significance_of_study'));
                const systemAnalysisAndDesign = decodeURIComponent(item.getAttribute('data-system_analysis_and_design'));
                const chapter = item.getAttribute('data-chapter');

                document.getElementById('reviseModalUniqueTitle').textContent = title;
                document.getElementById('reviseModalUnique').style.display = "flex";
                document.getElementById('reviseModalUniqueTitleInput').value = title;
                document.getElementById('reviseModalUniqueNewTitleInput').value = title;
                document.getElementById('reviseModalUniqueIntroductionInput').value = introduction;
                document.getElementById('reviseModalUniqueProjectObjectiveInput').value = projectObjective;
                document.getElementById('reviseModalUniqueSignificanceOfStudyInput').value = significanceOfStudy;
                document.getElementById('reviseModalUniqueSystemAnalysisAndDesignInput').value = systemAnalysisAndDesign;

                // Disable/enable fields based on chapter
                const introField = document.getElementById('reviseModalUniqueIntroductionInput');
                const projObjField = document.getElementById('reviseModalUniqueProjectObjectiveInput');
                const signifField = document.getElementById('reviseModalUniqueSignificanceOfStudyInput');
                const sysAnField = document.getElementById('reviseModalUniqueSystemAnalysisAndDesignInput');
                introField.disabled = false;
                projObjField.disabled = false;
                signifField.disabled = false;
                sysAnField.disabled = false;

                    if (window.tinymce) {
                        tinymce.remove('#reviseModalUniqueIntroductionInput');
                        tinymce.remove('#reviseModalUniqueProjectObjectiveInput');
                        tinymce.remove('#reviseModalUniqueSignificanceOfStudyInput');
                        tinymce.remove('#reviseModalUniqueSystemAnalysisAndDesignInput');
                    }
                    tinymce.init({
                        selector: '#reviseModalUniqueIntroductionInput',
                        menubar: false,
                        plugins: 'lists link',
                        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect fontselect',
                        font_size_formats: '12px 14px 16px 18px 24px 36px',
                        font_family_formats: 'Times New Roman=times new roman,times;Arial=arial,helvetica,sans-serif;Aptos=aptos,sans-serif',
                        height: 200,
                        setup: function(editor) {
                        editor.on('init', function() {
                            // Always editable
                        });
                            editor.on('input change keyup', function() {
                                document.getElementById('previewIntroduction').innerHTML = editor.getContent();
                            });
                        }
                    });
                    tinymce.init({
                        selector: '#reviseModalUniqueProjectObjectiveInput',
                        menubar: false,
                        plugins: 'lists link',
                        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect fontselect',
                        font_size_formats: '12px 14px 16px 18px 24px 36px',
                        font_family_formats: 'Times New Roman=times new roman,times;Arial=arial,helvetica,sans-serif;Aptos=aptos,sans-serif',
                        height: 200,
                        setup: function(editor) {
                        editor.on('init', function() {
                            // Always editable
                        });
                            editor.on('input change keyup', function() {
                                document.getElementById('previewProjectObjective').innerHTML = editor.getContent();
                            });
                        }
                    });
                    tinymce.init({
                        selector: '#reviseModalUniqueSignificanceOfStudyInput',
                        menubar: false,
                        plugins: 'lists link',
                        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect fontselect',
                        font_size_formats: '12px 14px 16px 18px 24px 36px',
                        font_family_formats: 'Times New Roman=times new roman,times;Arial=arial,helvetica,sans-serif;Aptos=aptos,sans-serif',
                        height: 200,
                        setup: function(editor) {
                        editor.on('init', function() {
                            // Always editable
                        });
                            editor.on('input change keyup', function() {
                                document.getElementById('previewSignificanceOfStudy').innerHTML = editor.getContent();
                            });
                        }
                    });
                    tinymce.init({
                        selector: '#reviseModalUniqueSystemAnalysisAndDesignInput',
                        menubar: false,
                        plugins: 'lists link',
                        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect fontselect',
                        font_size_formats: '12px 14px 16px 18px 24px 36px',
                        font_family_formats: 'Times New Roman=times new roman,times;Arial=arial,helvetica,sans-serif;Aptos=aptos,sans-serif',
                        height: 200,
                        setup: function(editor) {
                        editor.on('init', function() {
                            // Always editable
                        });
                            editor.on('input change keyup', function() {
                                document.getElementById('previewSystemAnalysisAndDesign').innerHTML = editor.getContent();
                            });
                        }
                    });
            });
        });
    }
    showupload();

    // Modal close logic
    document.addEventListener('DOMContentLoaded', function() {
        const closeBtn = document.getElementById('closeReviseModalUnique');
        const modal = document.getElementById('reviseModalUnique');
        if (closeBtn && modal) {
            closeBtn.onclick = function () {
                modal.style.display = "none";
            };
            modal.onclick = function(e) {
                if (e.target === modal) {
                    modal.style.display = "none";
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
            // Ensure TinyMCE content is saved to the textareas
            if (window.tinymce) tinymce.triggerSave();

            const form = e.target;
            const formData = new FormData(form);
            try {
                const res = await fetch('../../php/student/document_thesis.php', {
                    method: 'POST',
                    body: formData
                });
                const text = await res.text();
                let result;
                try {
                    result = JSON.parse(text);
                } catch (err) {
                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        html: `<div style='text-align:left;max-height:200px;overflow:auto;'><b>Invalid JSON from server.</b><br><pre style='font-size:0.9em;background:#f8f8f8;padding:8px;border-radius:6px;'>${text.replace(/</g, '&lt;')}</pre></div>`,
                        confirmButtonColor: "#1976a5",
                    });
                    return;
                }
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
            } catch (err) {
                Swal.fire({
                    icon: "error",
                    title: "Network Error",
                    text: err.message || 'Failed to connect to server.',
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

    // When opening the modal
    document.getElementById('reviseModalUnique').setAttribute('aria-hidden', 'false');
    // When closing the modal
    document.getElementById('reviseModalUnique').setAttribute('aria-hidden', 'true');

    console.log(document.getElementById('reviseModalUniqueIntroductionInput').value);
</script>
</body>
</html>