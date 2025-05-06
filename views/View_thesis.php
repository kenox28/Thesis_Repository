<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>reviewer</h1>
    <h3><?php echo $_SESSION['fname'] ?></h3>
    <a href="#" id="logout">logout</a>

    <main>
        <div id="userTableBody">

        </div>
    </main>
</body>
<script src="../js/view_thesis.js"></script>

</html>