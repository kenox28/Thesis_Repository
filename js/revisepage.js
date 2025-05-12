const student_id = "<?php echo $_SESSION['student_id']; ?>";
const urlParams = new URLSearchParams(window.location.search);
const thesis_id = urlParams.get("thesis_id");
document.getElementById("thesis_id").value = thesis_id;

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

async function showHistory() {
	const res = await fetch(
		`../../php/student/get_thesis_history.php?thesis_id=${thesis_id}`
	);
	const data = await res.json();
	if (data.error) {
		document.getElementById("historyTable").innerHTML = `<p>${data.error}</p>`;
		return;
	}
	let html = "<ul>";
	data.forEach((u) => {
		html += `<li>
			<b>Revision #${u.revision_num}</b> (${u.status}) at ${u.revised_at}
			<br>
			<a href="../../assets/revised/${u.file_name}" target="_blank">View PDF</a>
			${u.notes ? `<br>Notes: ${u.notes}` : ""}
		</li>`;
	});
	html += "</ul>";
	document.getElementById("historyTable").innerHTML = html;
}
showHistory();

// Handle revision upload
document.getElementById("revisionForm").onsubmit = async function (e) {
	e.preventDefault();
	const formData = new FormData(this);
	const res = await fetch("../../php/student/upload_revision.php", {
		method: "POST",
		body: formData,
	});
	const result = await res.json();
	alert(result.message);
	if (result.status === "success") {
		showHistory();
	}
};
