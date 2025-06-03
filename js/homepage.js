window.addEventListener("DOMContentLoaded", () => {
	showupload();
	showdroptdown();
});

async function showupload() {
	const res = await fetch("../../php/student/showupload.php");
	const data = await res.json();
	console.log("runnnnnnnnnnnnnnn");

	let rows = "<div class='thesis-cards'>";
	for (const u of data) {
		const filePath = "../../assets/thesisfile/" + u.ThesisFile;
		rows += `
			<div class="upload-item"
				data-file="${filePath}"
				data-title="${encodeURIComponent(u.title)}"
				data-abstract="${encodeURIComponent(u.abstract)}"
				data-owner="${encodeURIComponent(u.lname + ", " + u.fname)}"
				data-status="${encodeURIComponent(u.status)}"
				style="cursor:pointer;"
			>
				<h3><i class='fas fa-book'></i> ${u.title}</h3>
				<p><i class='fas fa-quote-left'></i> ${u.abstract}</p>
				<div class="author-info">
					<i class="fas fa-user-graduate"></i>
					<span>${u.lname}, ${u.fname}</span>
				</div>
				<embed src="${filePath}" type="application/pdf">

				<button style="background-color: red; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;" onclick="event.stopPropagation(); deleteThesis(${
					u.id
				}, '${u.title}')">
					<i class="fas fa-trash"></i> Cancel
				</button>

				<div 
					class="status-badge" 
					style="
						background-color: #003B9A;
						color: white;
						padding: 8px 16px;
						border-radius: 8px;
						font-weight: bold;
						font-size: 14px;
					"
				>
					<i class="fas fa-clock"></i> ${u.status || "Pending"}
				</div>
			</div>
		`;
	}
	rows += "</div>";

	document.getElementById("PDFFILE").innerHTML = rows;

	// Add modal open logic for .upload-item
	document.querySelectorAll(".upload-item").forEach((item) => {
		item.addEventListener("click", function (e) {
			// Prevent modal if the button was clicked
			if (e.target.tagName === "BUTTON") return;
			const filePath = item.getAttribute("data-file");
			const title = decodeURIComponent(item.getAttribute("data-title"));
			const abstract = decodeURIComponent(item.getAttribute("data-abstract"));
			const owner = decodeURIComponent(item.getAttribute("data-owner"));
			const status = decodeURIComponent(item.getAttribute("data-status"));

			document.getElementById("modalTitle").textContent = title;
			document.getElementById("modalStatus").textContent = status || "Pending";
			document.getElementById(
				"modalAbstract"
			).innerHTML = `<i class="fas fa-quote-left"></i> ${abstract}`;
			document.getElementById(
				"modalOwner"
			).innerHTML = `<i class="fas fa-user-graduate"></i> <span>${owner}</span>`;
			document.getElementById("modalPDF").src = filePath + "#toolbar=0";
			const downloadBtn = document.getElementById("modalDownload");
			if (status && status.toLowerCase() !== "pending") {
				downloadBtn.style.display = "inline-block";
				downloadBtn.href = filePath;
			} else {
				downloadBtn.style.display = "none";
			}
			document.getElementById("thesisModal").style.display = "flex";
		});
	});
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
// const logout = document.querySelector("#logout");
// logout.onclick = function (e) {
// 	console.log("run");
// 	e.preventDefault();
// 	window.location.href = "../../php/logout.php";
// };

// Modal close logic
document.addEventListener("DOMContentLoaded", function () {
	const closeBtn = document.getElementById("closeThesisModal");
	const modal = document.getElementById("thesisModal");
	const modalPDF = document.getElementById("modalPDF");
	if (closeBtn && modal && modalPDF) {
		closeBtn.onclick = function () {
			modal.style.display = "none";
			modalPDF.src = "";
		};
		modal.onclick = function (e) {
			if (e.target === modal) {
				modal.style.display = "none";
				modalPDF.src = "";
			}
		};
	}
});

////////////////////////////////////////////////////

// Dropdown toggle for avatar
const avatar = document.querySelector(".nav-avatar");
if (avatar) {
	avatar.addEventListener("click", function (e) {
		e.stopPropagation();
		this.classList.toggle("open");
	});
	document.addEventListener("click", function () {
		avatar.classList.remove("open");
	});
}

const profileLink = document.getElementById("profile-link");
const profileModal = document.getElementById("profile-modal");
const closeProfileModal = document.getElementById("closeProfileModal");
if (profileLink && profileModal && closeProfileModal) {
	profileLink.addEventListener("click", function (e) {
		e.preventDefault();
		profileModal.style.display = "flex";
		avatar.classList.remove("open");
	});
	closeProfileModal.addEventListener("click", function () {
		profileModal.style.display = "none";
	});
	window.addEventListener("click", function (event) {
		if (event.target === profileModal) {
			profileModal.style.display = "none";
		}
	});
}
// Logout confirmation modal logic
const logoutLink = document.getElementById("logout-link");
const logoutModal = document.getElementById("logout-modal");
const closeLogoutModal = document.getElementById("closeLogoutModal");
const confirmLogoutBtn = document.getElementById("confirmLogoutBtn");
const cancelLogoutBtn = document.getElementById("cancelLogoutBtn");
if (
	logoutLink &&
	logoutModal &&
	closeLogoutModal &&
	confirmLogoutBtn &&
	cancelLogoutBtn
) {
	logoutLink.addEventListener("click", function (e) {
		e.preventDefault();
		logoutModal.style.display = "flex";
		avatar.classList.remove("open");
	});
	closeLogoutModal.addEventListener("click", function () {
		logoutModal.style.display = "none";
	});
	cancelLogoutBtn.addEventListener("click", function (e) {
		e.preventDefault();
		logoutModal.style.display = "none";
	});
	confirmLogoutBtn.addEventListener("click", function () {
		window.location.href = "../../php/logout.php";
	});
	window.addEventListener("click", function (event) {
		if (event.target === logoutModal) {
			logoutModal.style.display = "none";
		}
	});
}

async function deleteThesis(thesisId, title) {
	if (
		!confirm(
			`Are you sure you want to delete "${title}"? This action cannot be undone.`
		)
	)
		return;
	const res = await fetch("../../php/student/delete_thesis.php", {
		method: "POST",
		headers: { "Content-Type": "application/json" },
		body: JSON.stringify({ id: thesisId }),
	});
	const result = await res.json();
	alert(result.message);
	if (result.status === "success") {
		showupload(); // Refresh the list
	}
}
