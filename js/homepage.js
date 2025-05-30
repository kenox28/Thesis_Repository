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

			<div class="upload-item" onclick="openModal('${filePath}', '${u.title}', '${
			u.abstract
		}', '${u.lname}, ${u.fname}', '${u.status}')">
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
// const logout = document.querySelector("#logout");
// logout.onclick = function (e) {
// 	console.log("run");
// 	e.preventDefault();
// 	window.location.href = "../../php/logout.php";
// };

function openModal(filePath, title, abstract, owner, status) {
	const modal = document.createElement("div");
	modal.className = "modal";
	modal.innerHTML = `
		<div class="modal-content large-modal">
			<span class="close-button">&times;</span>
			<h2>${title}</h2>
			<div class="thesis-card-status" style="margin-bottom:12px;">${
				status || "Pending"
			}</div>
			<p>${abstract}</p>
			<p>Owner: ${owner}</p>
			${
				status && status.toLowerCase() !== "pending"
					? `<a href="${filePath}" download class="custom-download-btn">Download PDF</a>`
					: ""
			}
			<iframe src="${filePath}#toolbar=0" width="100%" height="85vh" style="border-radius:8px;box-shadow:0 2px 12px #1976a522;margin-top:12px;"></iframe>
		</div>
	`;

	const closeButton = modal.querySelector(".close-button");
	closeButton.onclick = function () {
		document.body.removeChild(modal);
	};

	document.body.appendChild(modal);
}

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
