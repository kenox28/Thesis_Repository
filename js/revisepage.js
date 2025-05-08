const student_id = "<?php echo $_SESSION['student_id']; ?>";
async function showupload() {
	try {
		const res = await fetch("../../php/student/revisepage.php");
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
