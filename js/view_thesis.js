async function showupload() {
	try {
		const res = await fetch("../php/reView_thesis.php");
		const data = await res.json();

		if (data.error) {
			document.getElementById(
				"userTableBody"
			).innerHTML = `<p>${data.error}</p>`;
			return;
		}

		let rows = "";
		for (const u of data) {
			const filePath = "../assets/thesisfile/" + u.ThesisFile;

			rows += `
                <div class="upload-item" style="margin-bottom: 20px;">
                    <h3>${u.title}</h3>
                    <p>${u.abstract}</p>
                    <embed src="${filePath}" width="600" height="400" type="application/pdf">
                    <button onclick="updateStatus(${u.id}, 'rejected')">Reject</button>
                    <button onclick="updateStatus(${u.id}, 'revised')">Revise</button>
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

async function updateStatus(thesisId, status) {
	try {
		// Create a FormData object to send the data
		const formData = new FormData();
		formData.append("thesis_id", thesisId);
		formData.append("status", status);

		const res = await fetch("../php/updatethesis_status.php", {
			method: "POST",
			body: formData,
		});

		const result = await res.json();
		alert(result.message);
		if (result.status === "success") {
			showupload(); // Refresh the list
		}
	} catch (error) {
		console.error("Error updating status:", error);
	}
}

const logout = document.querySelector("#logout");
logout.onclick = function (e) {
	console.log("run");
	e.preventDefault();
	window.location.href = "../php/logout.php";
};
