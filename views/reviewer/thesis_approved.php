<?php
session_start();
$profileImg = (isset($_SESSION['profileImg']) && !empty($_SESSION['profileImg'])) ? $_SESSION['profileImg'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>
<body>
    <h1>approved</h1>
    <a href="view_thesis.php">View Thesis</a>
    <a href="thesis_rejected.php">Rejected</a>
    <a href="../../php/logout.php">logout</a>
    <h3><?php echo $_SESSION['fname'] ?></h3>
    <h3><?php echo $_SESSION['lname'] ?></h3>
    <h3><?php echo $_SESSION['email'] ?></h3>
    <h3><?php echo $_SESSION['reviewer_id'] ?></h3>
    <img src="../../assets/imageProfile/<?php echo htmlspecialchars($profileImg); ?>" alt="">
    <main>
        <div id="PDFFILE">

        </div>
    </main>
</body>
<script>
async function showupload() {
    const res = await fetch("../../php/reviewer/approve_thesis.php");
    const data = await res.json();
    console.log("runnnnnnnnnnnnnnn");

    if (data.error) {
        document.getElementById("PDFFILE").innerHTML = `<p>${data.error}</p>`;
        return;
    }

    let rows = "";
    for (const u of data) {
        const filePath = "../../assets/thesisfile/" + u.ThesisFile;
        rows += `
            <div class="upload-item">
                <h3>${u.title}</h3>
                <p>${u.abstract}</p>
                <p>${u.lname}, ${u.fname}</p>
                <embed src="${filePath}" width="450" height="300" type="application/pdf">
            </div>
        `;
    }

    document.getElementById("PDFFILE").innerHTML = rows;
}
showupload();
</script>
</html>