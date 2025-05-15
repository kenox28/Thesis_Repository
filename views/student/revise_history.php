<?php
session_start();
$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revision History</title>
</head>
<body>
    <a href="homepage.php">Home</a>
    <a href="public_repo.php">Public</a>
    <a href="approve_thesis.php">Approve</a>
    <a href="rejectpage.php">Rejected</a>
    <a href="request.php">Request</a>
    <a href="revisepage.php">Revised</a>
    <a href="profilemanage.php">Profile Management</a>
    <a href="../../php/logout.php">logout</a>
    <h3><?php echo $_SESSION['fname'] ?></h3>
    <h3><?php echo $_SESSION['lname'] ?></h3>
    <h3><?php echo $_SESSION['email'] ?></h3>
    <h3><?php echo $_SESSION['student_id'] ?></h3>
    <img src="../../assets/imageProfile/<?php echo htmlspecialchars($profileImg); ?>" alt="">
<div id="modalforhistory">

</div>
</body>
<script>
const urlParams = new URLSearchParams(window.location.search);
const title = urlParams.get('title');

async function modalfuntion() {
    try {
        const res = await fetch(`../../php/student/get_thesis_history.php?title=${encodeURIComponent(title)}`);
        const data = await res.json();

        if (data.error) {
            document.getElementById("modalforhistory").innerHTML = `<p>${data.error}</p>`;
            return;
        }

        let rows = "";
        data.forEach(u => {
            const filePath = "../../assets/revised/" + u.file_name;
            rows += `
                <div class="upload-item" style="margin-bottom: 20px;">
                    <b>Revision #${u.revision_num}</b> (${u.status}) by ${u.revised_by} at ${u.revised_at}<br>
                    <a href="${filePath}" target="_blank">View PDF</a>
                    ${u.notes ? `<br>Notes: ${u.notes}` : ""}
                </div>
            `;
        });

        document.getElementById("modalforhistory").innerHTML = rows;
    } catch (error) {
        console.error("Error fetching uploads:", error);
        document.getElementById("modalforhistory").innerHTML = `<p>Something went wrong.</p>`;
    }
}
modalfuntion();
</script>
</html> 