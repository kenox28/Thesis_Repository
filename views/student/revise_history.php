
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revision History</title>
</head>
<body>
<div id="userTableBody">

</div>
</body>
<script>
const urlParams = new URLSearchParams(window.location.search);
const title = urlParams.get('title');

async function showupload() {
    try {
        const res = await fetch(`../../php/student/get_thesis_history.php?title=${encodeURIComponent(title)}`);
        const data = await res.json();

        if (data.error) {
            document.getElementById("userTableBody").innerHTML = `<p>${data.error}</p>`;
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

        document.getElementById("userTableBody").innerHTML = rows;
    } catch (error) {
        console.error("Error fetching uploads:", error);
        document.getElementById("userTableBody").innerHTML = `<p>Something went wrong.</p>`;
    }
}
showupload();
</script>
</html> 