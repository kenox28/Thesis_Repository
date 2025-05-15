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
<h1>Revise</h1>
<aside>
    <a href="homepage.php">Home</a>
    <a href="public_repo.php">Public</a>
    <a href="/views/student/revisepage.php">Revise</a>
    <a href="approve.php?id=<?php echo $_SESSION['student_id']; ?>">Approve</a>
    <a href="/views/student/rejectpage.php">Rejected</a>
    <a href="#" id="logout">Logout</a>
</aside>
<h3><?php echo $_SESSION['fname']; ?></h3>


<div id="userTableBody">

</div>
</body>
<script src="../../js/revisepage.js"></script>

</html>