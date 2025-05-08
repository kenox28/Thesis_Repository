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
<h1>Rejected</h1>
<h3><?php echo $_SESSION['fname']; ?></h3>
<a href="logout.php">logout</a>


<div id="userTableBody">

</div>
</body>
<script src="../../js/rejectedpage.js"></script>

</html>