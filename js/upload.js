window.addEventListener("DOMContentLoaded", () => {
	loadReviewers();
	loadMembers();
});
document
	.getElementById("thesisForm")
	.addEventListener("submit", generateAPAReference);

async function generateAPAReference(e) {
	e.preventDefault();

	// Remove any previous hidden inputs
	document.querySelectorAll(".dynamic-hidden").forEach((el) => el.remove());

	// Ensure checked reviewer is included
	const reviewer = document.querySelector('input[name="reviewer"]:checked');
	if (reviewer) {
		const hiddenReviewer = document.createElement("input");
		hiddenReviewer.type = "hidden";
		hiddenReviewer.name = "reviewer_id";
		hiddenReviewer.value = reviewer.value;
		hiddenReviewer.className = "dynamic-hidden";
		document.getElementById("thesisForm").appendChild(hiddenReviewer);
	}

	// Ensure all checked members are included
	window.checkedMembers.forEach((memberId) => {
		const hiddenMember = document.createElement("input");
		hiddenMember.type = "hidden";
		hiddenMember.name = "member_ids[]";
		hiddenMember.value = memberId;
		hiddenMember.className = "dynamic-hidden";
		document.getElementById("thesisForm").appendChild(hiddenMember);
	});

	const form = document.getElementById("thesisForm");
	const formdata = new FormData(form);

	// --- Frontend validation ---
	const title = formdata.get("title");
	const reviewerVal = formdata.get("reviewer_id");
	const members = formdata.getAll("member_ids[]");

	if (!title || !reviewerVal || !members.length) {
		Swal.fire({
			icon: "error",
			title: "Error!",
			text: "Please fill in all the required inputs.",
			confirmButtonColor: "#1976a5",
		});
		return;
	}
	// --- End validation ---

	const res = await fetch("../../php/student/upload_thesis.php", {
		method: "POST",
		body: formdata,
	});

	const result = await res.json();

	if (result.status === "success") {
		Swal.fire({
			icon: "success",
			title: "Successfully Uploaded!",
			text: result.message,
			confirmButtonColor: "#1976a5",
		});
	} else {
		Swal.fire({
			icon: "error",
			title: "Error!",
			text: result.message,
			confirmButtonColor: "#1976a5",
		});
	}
}

async function loadReviewers() {
	const res = await fetch("../../php/student/showreviewer.php");
	const data = await res.json();
	window.allReviewers = data;
	document
		.getElementById("reviewerSearch")
		.addEventListener("input", function () {
			const val = this.value.trim().toLowerCase();
			if (!val) {
				document.getElementById("reviewerList").innerHTML = "";
				return;
			}
			const filtered = window.allReviewers.filter((u) =>
				u.reviewer_name.toLowerCase().includes(val)
			);
			document.getElementById("reviewerList").innerHTML = filtered
				.map(
					(u) =>
						`<label><input type="radio" name="reviewer" value="${u.reviewer_id}"> ${u.reviewer_name}</label>`
				)
				.join("");
		});
}

window.checkedMembers = new Set();

async function loadMembers() {
	const res = await fetch("../../php/student/showmember.php");
	const data = await res.json();
	window.allMembers = data;

	// Listen for search input
	document
		.getElementById("memberSearch")
		.addEventListener("input", function () {
			renderMemberList(this.value.trim().toLowerCase());
		});

	// Initial render (empty search)
	renderMemberList("");
}

function renderMemberList(searchVal) {
	const container = document.getElementById("memberList");
	let checked = Array.from(window.checkedMembers);
	let checkedMembers = window.allMembers.filter((u) =>
		checked.includes(u.student_id)
	);
	let searchResults = [];

	if (searchVal) {
		searchResults = window.allMembers.filter(
			(u) =>
				u.student_name.toLowerCase().includes(searchVal) &&
				!window.checkedMembers.has(u.student_id)
		);
	}

	// Render checked members at the top, then search results
	let html = "";
	checkedMembers.forEach((u) => {
		html += `<label><input type="checkbox" name="members[]" value="${u.student_id}" checked> ${u.student_name}</label>`;
	});
	searchResults.forEach((u) => {
		html += `<label><input type="checkbox" name="members[]" value="${u.student_id}"> ${u.student_name}</label>`;
	});
	container.innerHTML = html;

	// Add event listeners to checkboxes
	container.querySelectorAll('input[type="checkbox"]').forEach((cb) => {
		cb.addEventListener("change", function () {
			if (this.checked) {
				window.checkedMembers.add(this.value);
			} else {
				window.checkedMembers.delete(this.value);
				// Optionally, re-render to remove from top if not in search
				renderMemberList(
					document.getElementById("memberSearch").value.trim().toLowerCase()
				);
			}
		});
	});
}

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
// Profile modal logic
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
