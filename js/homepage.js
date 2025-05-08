window.addEventListener("DOMContentLoaded", () => {
	showupload();
	showdroptdown();
});

document.getElementById("thesisForm").addEventListener("submit", uploadfun);

async function uploadfun(e) {
	e.preventDefault();

	const form = document.getElementById("thesisForm");
	const formdata = new FormData(form);

	const res = await fetch("../../php/student/upload_thesis.php", {
		method: "POST",
		body: formdata,
	});

	const result = await res.json();

	if (result.status === "success") {
		alert(result.message);
		// window.location.href = "../views/home.html";
		showupload();
	} else {
		alert(result.message);
	}
}
async function showupload() {
	try {
		const res = await fetch("../../php/student/showupload.php");
		const data = await res.json();
		console.log("runnnnnnnnnnnnnnn");

		let rows = "";
		for (const u of data) {
			const filePath = "../../assets/thesisfile/" + u.ThesisFile;
			// Add an entry for each uploaded PDF
			rows += `
                <div class="upload-item">
                    <h3>${u.title}</h3>
                    <p>${u.abstract}</p>
                    <embed src="${filePath}" width="600" height="400" type="application/pdf">
                </div>
            `;
		}

		document.getElementById("PDFFILE").innerHTML = rows;
	} catch (error) {
		console.error("Error fetching uploads:", error);
	}
}
async function showdroptdown() {
	const res = await fetch("../../php/student/showreviewer.php");
	const data = await res.json();

	let options = `<option value="">Select Reviewer</option>`;
	for (const u of data) {
		options += `<option value="${u.reviewer_id}">${u.reviewer_name}</option>`;
	}

	document.getElementById("reviewerDropdown").innerHTML = options;
}
const logout = document.querySelector("#logout");
logout.onclick = function (e) {
	console.log("run");
	e.preventDefault();
	window.location.href = "../../php/logout.php";
};
