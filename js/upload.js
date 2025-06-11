window.addEventListener("DOMContentLoaded", () => {
	showdroptdown();
<<<<<<< HEAD
});
document.getElementById("thesisForm").addEventListener("submit", uploadfun);

async function uploadfun(e) {
	e.preventDefault();

	const fileInput = document.getElementById("docfile");
	const file = fileInput.files[0];
	if (!file || file.type !== "application/pdf") {
		Swal.fire({
			icon: "error",
			title: "Invalid File",
			text: "Please upload a PDF file only.",
			confirmButtonColor: "#1976a5",
		});
		return;
	}

=======
	showdorpdownmember();
});
document
	.getElementById("thesisForm")
	.addEventListener("submit", generateAPAReference);

async function generateAPAReference(e) {
	e.preventDefault();

>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
	const form = document.getElementById("thesisForm");
	const formdata = new FormData(form);

	const res = await fetch("../../php/student/upload_thesis.php", {
		method: "POST",
		body: formdata,
	});

	const result = await res.json();

	if (result.status === "success") {
		Swal.fire({
			icon: "success",
<<<<<<< HEAD
			title: "Success!",
			text: result.message,
			confirmButtonColor: "#1976a5",
		}).then(() => {
			form.reset(); // Clear all input fields
			showupload();
=======
			title: "Successfully Uploaded!",
			text: result.message,
			confirmButtonColor: "#1976a5",
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
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

async function showdroptdown() {
	const res = await fetch("../../php/student/showreviewer.php");
	const data = await res.json();

	let options = `<option value="">Select Reviewer</option>`;
	for (const u of data) {
		options += `<option value="${u.reviewer_id}">${u.reviewer_name}</option>`;
	}

	document.getElementById("reviewerDropdown").innerHTML = options;
}

<<<<<<< HEAD
=======
async function showdorpdownmember() {
	const res = await fetch("../../php/student/showmember.php");
	const data = await res.json();

	let options = "";

	for (const u of data) {
		options += `<option value="${u.student_id}">${u.student_name}</option>`;
	}

	document.getElementById("memberDropdown").innerHTML = options;
}

>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
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
