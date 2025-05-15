window.addEventListener("DOMContentLoaded", () => {
	showupload();
	showdroptdown();
});

document.getElementById("thesisForm").addEventListener("submit", uploadfun);

async function uploadfun(e) {
	e.preventDefault();

	const fileInput = document.getElementById("docfile");
	const file = fileInput.files[0];
	if (!file || file.type !== "application/pdf") {
		alert("Please upload a PDF file only.");
		return;
	}

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
	const res = await fetch("../../php/student/showupload.php");
	const data = await res.json();
	console.log("runnnnnnnnnnnnnnn");

	let rows = "<div class='thesis-cards'>";
	for (const u of data) {
		const filePath = "../../assets/thesisfile/" + u.ThesisFile;
		rows += `
			<div class="thesis-card" onclick="openModal('${filePath}', '${u.title}', '${u.abstract}', '${u.lname}, ${u.fname}', '${u.status}')">
				<div class="thesis-card-title">${u.title}</div>
				<div class="thesis-card-abstract">${u.abstract}</div>
				<div class="thesis-card-owner">${u.lname}, ${u.fname}</div>
				<div class="thesis-card-status">${u.status || 'Pending'}</div>
			</div>
		`;
	}
	rows += "</div>";

	document.getElementById("PDFFILE").innerHTML = rows;
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

function openModal(filePath, title, abstract, owner, status) {
	const modal = document.createElement("div");
	modal.className = "modal";
	modal.innerHTML = `
		<div class="modal-content large-modal">
			<span class="close-button">&times;</span>
			<h2>${title}</h2>
			<div class="thesis-card-status" style="margin-bottom:12px;">${status || 'Pending'}</div>
			<p>${abstract}</p>
			<p>Owner: ${owner}</p>
			${status && status.toLowerCase() !== 'pending' ? `<a href="${filePath}" download class="custom-download-btn">Download PDF</a>` : ''}
			<iframe src="${filePath}#toolbar=0" width="100%" height="85vh" style="border-radius:8px;box-shadow:0 2px 12px #1976a522;margin-top:12px;"></iframe>
		</div>
	`;

	const closeButton = modal.querySelector(".close-button");
	closeButton.onclick = function() {
		document.body.removeChild(modal);
	};

	document.body.appendChild(modal);
}
