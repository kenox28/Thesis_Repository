<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- PDF.js (3.11.174 for compatibility) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <!-- Local pdf-annotate.js -->
    <script src="../../js/pdf-annotate.min.js"></script>
    <!-- PDF-lib -->
    <script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>
</head>
<body>
    <h1>reviewer</h1>
    <a href="view_Revise.php">view revised</a>
    <h3><?php echo $_SESSION['fname'] ?></h3>
    <a href="../../php/logout.php">logout</a>
    <main>
        <div id="userTableBody">

        </div>
    </main>

    <!-- Modal Structure -->
    <div id="reviseModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); z-index:1000; align-items:center; justify-content:center;">
      <div style="background:#fff; padding:20px; border-radius:8px; width:850px; max-width:95vw; max-height:95vh; overflow:auto; position:relative;">
        <button onclick="closeReviseModal()" style="position:absolute; top:10px; right:10px;">&times;</button>
        <h2>Revise Thesis</h2>
        <div id="toolbar">
          <button onclick="enableHighlightMode()">Highlight</button>
          <button onclick="enableTextMode()">Text</button>
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
<script src="../../js/view_thesis.js?v=1.0.3"></script>

</html>