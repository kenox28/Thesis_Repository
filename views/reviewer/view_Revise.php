<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="userTableBody">

</div>
</body>
<script src="../../js/revise_upload.js"></script>
<script>
    
async function showupload() {
	try {
		const res = await fetch("../../php/reviewer/showUploaded_revise.php");
		const data = await res.json();

		if (data.error) {
			document.getElementById(
				"userTableBody"
			).innerHTML = `<p>${data.error}</p>`;
			return;
		}

		let rows = "";
		for (const u of data) {
			const filePath = "../../assets/revised/" + u.ThesisFile;

			rows += `
                <div class="upload-item" style="margin-bottom: 20px;">
                    <h3>${u.title}</h3>
                    <p>${u.abstract}</p>
                    <embed src="${filePath}" width="600" height="400" type="application/pdf">
                    <button onclick="updateStatus(${u.id}, 'rejected')">Reject</button>
                    <button onclick="openReviseModal('${u.id}', '${u.ThesisFile}')">Revise</button>
                    <button onclick="updateStatus(${u.id}, 'approved')">Approve</button>
                </div>
            `;
		}

		document.getElementById("userTableBody").innerHTML = rows;
	} catch (error) {
		console.error("Error fetching uploads:", error);
		document.getElementById(
			"userTableBody"
		).innerHTML = `<p>Something went wrong.</p>`;
	}
}
showupload();
</script>
</html>