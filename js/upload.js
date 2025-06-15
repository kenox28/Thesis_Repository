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

	// Ensure all checked reviewers are included
	window.checkedReviewers.forEach((reviewerId) => {
		const hiddenReviewer = document.createElement("input");
		hiddenReviewer.type = "hidden";
		hiddenReviewer.name = "reviewer_ids[]";
		hiddenReviewer.value = reviewerId;
		hiddenReviewer.className = "dynamic-hidden";
		document.getElementById("thesisForm").appendChild(hiddenReviewer);
	});

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
	const reviewerVals = formdata.getAll("reviewer_ids[]");
	const members = formdata.getAll("member_ids[]");

	// Allow 1, 2, or 3 reviewers (but not 0)
	if (
		!title ||
		reviewerVals.length < 1 ||
		reviewerVals.length > 3 ||
		!members.length
	) {
		console.log("title", title);
		console.log("reviewerVals", reviewerVals);
		console.log("members", members);
		Swal.fire({
			icon: "warning",
			title: "Incomplete Submission",
			text: "Please select at least 1 and at most 3 reviewers, and at least 1 member.",
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
	window.checkedReviewers = new Set();
	document
		.getElementById("reviewerSearch")
		.addEventListener("input", function () {
			const val = this.value.trim().toLowerCase();
			if (!val) {
				document.getElementById("reviewerList").innerHTML = "";
				updateSelectedReviewersContainer();
				return;
			}
			const filtered = window.allReviewers.filter((u) =>
				u.reviewer_name.toLowerCase().includes(val)
			);
			document.getElementById("reviewerList").innerHTML = filtered
				.map(
					(u) =>
						`<label><input type="checkbox" name="reviewers[]" value="${
							u.reviewer_id
						}" ${
							window.checkedReviewers.has(u.reviewer_id) ? "checked" : ""
						}> <span class="fa-solid fa-user"></span> ${
							u.reviewer_name
						} <span class="fa-solid fa-check-circle"></span></label>`
				)
				.join("");

			// Add event listeners to reviewer checkboxes
			document
				.querySelectorAll('#reviewerList input[type="checkbox"]')
				.forEach((cb) => {
					cb.addEventListener("change", function () {
						if (this.checked) {
							if (window.checkedReviewers.size >= 3) {
								this.checked = false;
								Swal.fire({
									icon: "warning",
									title: "Limit reached!",
									text: "You can only select up to 3 reviewers.",
									confirmButtonColor: "#1976a5",
								});
								return;
							}
							window.checkedReviewers.add(this.value);
						} else {
							window.checkedReviewers.delete(this.value);
						}
						updateSelectedReviewersContainer();
					});
				});
			updateSelectedReviewersContainer();
		});
	// Initial render (empty search)
	document.getElementById("reviewerSearch").dispatchEvent(new Event("input"));
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
		html += `<label><input type="checkbox" name="members[]" value="${u.student_id}" checked> <span class="fa-solid fa-user"></span> ${u.student_name} <span class="fa-solid fa-check-circle"></span></label>`;
	});
	searchResults.forEach((u) => {
		html += `<label><input type="checkbox" name="members[]" value="${u.student_id}"> <span class="fa-solid fa-user"></span> ${u.student_name} <span class="fa-solid fa-check-circle"></span></label>`;
	});
	container.innerHTML = html;

	// Add event listeners to checkboxes
	container.querySelectorAll('input[type="checkbox"]').forEach((cb) => {
		cb.addEventListener("change", function () {
			if (this.checked) {
				if (window.checkedMembers.size >= 3) {
					this.checked = false;
					Swal.fire({
						icon: "warning",
						title: "Limit reached!",
						text: "You can only select up to 3 collaborators.",
						confirmButtonColor: "#1976a5",
					});
					return;
				}
				window.checkedMembers.add(this.value);
			} else {
				window.checkedMembers.delete(this.value);
				// Optionally, re-render to remove from top if not in search
				renderMemberList(
					document.getElementById("memberSearch").value.trim().toLowerCase()
				);
			}
			updateSelectedCollaboratorsContainer();
		});
	});
	updateSelectedCollaboratorsContainer();
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

function getAvatarOrInitials(name, imgUrl) {
	if (imgUrl && imgUrl !== "noprofile.png") {
		return `<img src="../../assets/ImageProfile/${imgUrl}" class="avatar-chip" alt="avatar" onerror="this.style.display='none'">`;
	} else if (name) {
		const initials = name
			.split(" ")
			.map((n) => n[0])
			.join("")
			.substring(0, 2)
			.toUpperCase();
		return `<span class="avatar-chip"><i class="fa-solid fa-user"></i></span>`;
	}
	return `<span class="avatar-chip"><i class="fa-solid fa-user"></i></span>`;
}

function updateSelectedReviewersContainer() {
	const container = document.getElementById("selectedReviewersContainer");
	const searchBox = document.getElementById("reviewerSearch");
	const listBox = document.getElementById("reviewerList");
	const limit = 3;
	container.innerHTML = "";
	const selected = Array.from(window.checkedReviewers);
	selected.forEach((id) => {
		const reviewer = window.allReviewers.find((r) => r.reviewer_id == id);
		if (reviewer) {
			const item = document.createElement("div");
			item.className = "selected-item";
			item.innerHTML =
				getAvatarOrInitials(reviewer.reviewer_name, reviewer.profileImg) +
				reviewer.reviewer_name;
			const btn = document.createElement("button");
			btn.className = "remove-btn";
			btn.innerHTML = "&times;";
			btn.onclick = function () {
				window.checkedReviewers.delete(id);
				updateSelectedReviewersContainer();
				// Uncheck in the list
				document
					.querySelectorAll('#reviewerList input[type="checkbox"]')
					.forEach((cb) => {
						if (cb.value == id) cb.checked = false;
					});
				// Show search/list if less than limit
				if (window.checkedReviewers.size < limit) {
					searchBox.style.display = "";
					listBox.style.display = "";
				}
			};
			item.appendChild(btn);
			container.appendChild(item);
		}
	});
	if (window.checkedReviewers.size >= limit) {
		searchBox.style.display = "none";
		listBox.style.display = "none";
	} else {
		searchBox.style.display = "";
		listBox.style.display = "";
	}
}

function updateSelectedCollaboratorsContainer() {
	const container = document.getElementById("selectedCollaboratorsContainer");
	const searchBox = document.getElementById("memberSearch");
	const listBox = document.getElementById("memberList");
	const limit = 3;
	container.innerHTML = "";
	const selected = Array.from(window.checkedMembers);
	selected.forEach((id) => {
		const member = window.allMembers.find((m) => m.student_id == id);
		if (member) {
			const item = document.createElement("div");
			item.className = "selected-item";
			item.innerHTML =
				getAvatarOrInitials(member.student_name, member.profileImg) +
				member.student_name;
			const btn = document.createElement("button");
			btn.className = "remove-btn";
			btn.innerHTML = "&times;";
			btn.onclick = function () {
				window.checkedMembers.delete(id);
				updateSelectedCollaboratorsContainer();
				// Uncheck in the list
				document
					.querySelectorAll('#memberList input[type="checkbox"]')
					.forEach((cb) => {
						if (cb.value == id) cb.checked = false;
					});
				// Optionally, re-render to remove from top if not in search
				renderMemberList(
					document.getElementById("memberSearch").value.trim().toLowerCase()
				);
				// Show search/list if less than limit
				if (window.checkedMembers.size < limit) {
					searchBox.style.display = "";
					listBox.style.display = "";
				}
			};
			item.appendChild(btn);
			container.appendChild(item);
		}
	});
	if (window.checkedMembers.size >= limit) {
		searchBox.style.display = "none";
		listBox.style.display = "none";
	} else {
		searchBox.style.display = "";
		listBox.style.display = "";
	}
}
