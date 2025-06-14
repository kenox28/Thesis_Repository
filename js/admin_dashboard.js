console.log("admin_dashboard.js loaded");

document.addEventListener("DOMContentLoaded", () => {
	setupSidebarNavigation();
	updateDashboardWidgets();
	showSection("dashboard");
	setupLogoutHandler();
});

function setupSidebarNavigation() {
	const navLinks = {
		dashboard: document.getElementById("nav-dashboard"),
		students: document.getElementById("nav-students"),
		reviewers: document.getElementById("nav-reviewers"),
		publication: document.getElementById("nav-publication"),
	};
	Object.entries(navLinks).forEach(([section, link]) => {
		if (link) {
			link.addEventListener("click", () => {
				document
					.querySelectorAll(".sidebar-link")
					.forEach((l) => l.classList.remove("active"));
				link.classList.add("active");
				showSection(section);
			});
		}
	});
}

let currentSection = "dashboard";

function showSection(section) {
	console.log("showSection called with:", section);
	currentSection = section;
	const dashboardMain = document.getElementById("dashboardMain");
	const dashboardContent = document.getElementById("dashboardContent");
	if (section === "dashboard") {
		dashboardMain.style.display = "flex";
		dashboardContent.innerHTML = "";
		updateDashboardWidgets();
	} else {
		dashboardMain.style.display = "none";
		if (section === "students") {
			renderStudentsSection();
		} else if (section === "reviewers") {
			renderReviewersSection();
		} else if (section === "publication") {
			loadPublicationThesisSection();
		}
	}
}

function updateDashboardWidgets() {
	console.log("updateDashboardWidgets called");
	Promise.all([
		fetch("../../php/admin/get_students.php").then((r) => r.json()),
		fetch("../../php/admin/get_reviewers.php").then((r) => r.json()),
		fetch("../../php/student/get_public_repo.php").then((r) => r.json()),
	])
		.then(([studentsData, reviewersData, thesisData]) => {
			console.log("Dashboard widgets data:", {
				studentsData,
				reviewersData,
				thesisData,
			});
			const widgetStudents = document.getElementById("widgetStudents");
			if (widgetStudents)
				widgetStudents.textContent = studentsData.students
					? studentsData.students.length
					: 0;
			if (reviewersData.data) {
				document.getElementById("widgetReviewers").textContent =
					reviewersData.data.length;
			} else {
				document.getElementById("widgetReviewers").textContent = 0;
			}
			document.getElementById("widgetThesis").textContent =
				thesisData && Array.isArray(thesisData) ? thesisData.length : 0;
		})
		.catch((err) => {
			console.error("Failed to load dashboard widgets:", err);
		});
}

// STUDENTS SECTION
function renderStudentsSection() {
	console.log("renderStudentsSection called");
	const dashboardContent = document.getElementById("dashboardContent");
	dashboardContent.innerHTML = `
		<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin-bottom:1.2rem;margin-top:0.5rem;position:relative;">
			<div style="position:absolute;top:-30px;right:-30px;width:90px;height:90px;background:linear-gradient(135deg,#1976a5 0%,#cadcfc 100%);opacity:0.10;border-radius:50%;z-index:0;"></div>
			<div style="position:absolute;bottom:-30px;left:-30px;width:90px;height:90px;background:linear-gradient(135deg,#cadcfc 0%,#1976a5 100%);opacity:0.10;border-radius:50%;z-index:0;"></div>
			<div style="position:relative;z-index:1;background:rgba(255,255,255,0.22);backdrop-filter:blur(10px);border-radius:22px;box-shadow:0 8px 32px 0 rgba(31,38,135,0.10);padding:1.2rem 2.2rem;min-width:320px;max-width:480px;width:100%;display:flex;align-items:center;gap:0.7rem;">
				<i class='fas fa-users' style='font-size:1.5rem;color:#1976a5;'></i>
				<span style="font-size:1.35rem;font-weight:700;color:#1976a5;letter-spacing:1px;">REGISTERED STUDENTS</span>
			</div>
		</div>
		<div class="students-search-bar" style="position:sticky;top:0;z-index:20;background:rgba(255,255,255,0.18);backdrop-filter:blur(8px);padding:1.2rem 0 1.2rem 0;margin-bottom:2.2rem;display:flex;justify-content:center;align-items:center;gap:1rem;box-shadow:0 2px 12px #cadcfc22;">
			<input id="studentsSearchInput" type="text" placeholder="Search students by name, ID, or email..." style="width:340px;padding:0.8rem 1.2rem;border-radius:24px;border:none;font-size:1.08rem;background:rgba(255,255,255,0.7);box-shadow:0 2px 8px #cadcfc22;outline:none;">
			<button id="studentsSearchClear" style="background:none;border:none;color:#1976a5;font-size:1.2rem;cursor:pointer;display:none;"><i class="fas fa-times-circle"></i></button>
		</div>
		<div id="studentsGrid" class="students-grid" style="display:flex;flex-direction:column;align-items:center;gap:2.2rem;width:100%;"></div>
	`;
	fetch("../../php/admin/get_students.php")
		.then((r) => r.json())
		.then((data) => {
			console.log("get_students.php response:", data);
			if (
				data.status === "success" &&
				data.students &&
				data.students.length > 0
			) {
				renderStudentCards(data.students);
				setupStudentsSearch(data.students);
			} else {
				document.getElementById("studentsGrid").innerHTML =
					'<div class="no-students">No students registered yet.</div>';
			}
		})
		.catch((err) => {
			console.error("Failed to load students:", err);
			document.getElementById("studentsGrid").innerHTML =
				'<div class="error-message">Failed to load students. Please try again later.</div>';
		});
}

function renderStudentCards(students) {
	const grid = document.getElementById("studentsGrid");
	grid.innerHTML = "";
	if (!students.length) {
		grid.innerHTML =
			'<div class="no-students">No students registered yet.</div>';
		return;
	}
	let table = `<div style=\"overflow-x:auto;width:100%;margin-left:0.5rem;\">
		<table class=\"students-table\" style=\"width:100%;border-collapse:separate;border-spacing:0;background:#fff;border-radius:12px;box-shadow:0 2px 8px #cadcfc22;font-size:1rem;\">
			<thead>
				<tr style=\"background:#f7faff;\">
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">ID</th>
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">Name</th>
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">Email</th>
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">Role</th>
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">Actions</th>
				</tr>
			</thead>
			<tbody>`;
	students.forEach((student) => {
		table += `<tr style=\"border-bottom:1px solid #e3eafc;transition:background 0.15s;\" onmouseover=\"this.style.background='#f3f8fd'\" onmouseout=\"this.style.background=''\">
			<td style=\"padding:6px 6px;vertical-align:middle;color:#555;text-align:left;\">${
				student.student_id
			}</td>
			<td style=\"padding:6px 6px;vertical-align:middle;font-weight:600;color:#1976a5;text-align:left;\">${
				student.fname
			} ${student.lname}</td>
			<td style=\"padding:6px 6px;vertical-align:middle;color:#555;text-align:left;\">${
				student.email
			}</td>
			<td style=\"padding:6px 6px;vertical-align:middle;text-align:left;\">
				<select style=\"padding:0.25rem 0.7rem;border-radius:8px;border:1px solid #b5c7d3;background:#f7faff;font-size:0.98rem;\" onchange=\"setRole('${
					student.student_id
				}', this.value)\">
					<option value=\"student\" ${
						student.role === "student" ? "selected" : ""
					}>Student</option>
					<option value=\"reviewer\" ${
						student.role === "reviewer" ? "selected" : ""
					}>Reviewer</option>
				</select>
			</td>
			<td style=\"padding:6px 6px;vertical-align:middle;text-align:left;\">
				<div style=\"display:flex;gap:0.3rem;align-items:center;flex-wrap:wrap;\">
					<button onclick=\"viewStudent('${
						student.student_id
					}')\" class=\"pill-btn pill-btn-blue\" title=\"View\" style=\"padding:0.35rem 0.6rem;font-size:1rem;min-width:32px;\"><i class=\"fas fa-eye\"></i></button>
					<button onclick=\"deleteStudent('${
						student.student_id
					}')\" class=\"pill-btn pill-btn-red\" title=\"Delete\" style=\"padding:0.35rem 0.6rem;font-size:1rem;min-width:32px;\"><i class=\"fas fa-trash\"></i></button>
				</div>
			</td>
		</tr>`;
	});
	table += `</tbody></table></div>`;
	grid.innerHTML = table;
}

function setupStudentsSearch(students) {
	const input = document.getElementById("studentsSearchInput");
	const clearBtn = document.getElementById("studentsSearchClear");
	input.addEventListener("input", function () {
		const val = input.value.trim().toLowerCase();
		clearBtn.style.display = val ? "inline" : "none";
		const filtered = students.filter(
			(s) =>
				(s.fname + " " + s.lname).toLowerCase().includes(val) ||
				s.student_id.toLowerCase().includes(val) ||
				s.email.toLowerCase().includes(val)
		);
		renderStudentCards(filtered);
	});
	clearBtn.addEventListener("click", function () {
		input.value = "";
		clearBtn.style.display = "none";
		renderStudentCards(students);
		input.focus();
	});
}

// Add pill button styles
const style = document.createElement("style");
style.innerHTML = `
.pill-btn { border:none; border-radius:18px; padding:0.6rem 1.3rem; font-size:1.01rem; font-weight:600; cursor:pointer; transition:background 0.2s,color 0.2s,box-shadow 0.2s; box-shadow:0 2px 8px #cadcfc22; display:flex;align-items:center;gap:7px; }
.pill-btn-blue { background:#1976a5; color:#fff; }
.pill-btn-blue:hover { background:#155d84; }
.pill-btn-gray { background:#f0f0f0; color:#333; }
.pill-btn-gray:hover { background:#e0e0e0; }
.pill-btn-red { background:#e74c3c; color:#fff; }
.pill-btn-red:hover { background:#c0392b; }
.btn-role-glass:hover { background:#1976a5 !important; color:#fff !important; }
`;
document.head.appendChild(style);

// REVIEWERS SECTION
function renderReviewersSection() {
	const dashboardContent = document.getElementById("dashboardContent");
	dashboardContent.innerHTML = `
		<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin-bottom:1.2rem;margin-top:0.5rem;position:relative;">
			<div style="position:absolute;top:-30px;right:-30px;width:90px;height:90px;background:linear-gradient(135deg,#1976a5 0%,#cadcfc 100%);opacity:0.10;border-radius:50%;z-index:0;"></div>
			<div style="position:absolute;bottom:-30px;left:-30px;width:90px;height:90px;background:linear-gradient(135deg,#cadcfc 0%,#1976a5 100%);opacity:0.10;border-radius:50%;z-index:0;"></div>
			<div style="position:relative;z-index:1;background:rgba(255,255,255,0.22);backdrop-filter:blur(10px);border-radius:22px;box-shadow:0 8px 32px 0 rgba(31,38,135,0.10);padding:1.2rem 2.2rem;min-width:320px;max-width:480px;width:100%;display:flex;align-items:center;gap:0.7rem;">
				<i class='fas fa-user-check' style='font-size:1.5rem;color:#1976a5;'></i>
				<span style="font-size:1.35rem;font-weight:700;color:#1976a5;letter-spacing:1px;">REVIEWERS</span>
			</div>
		</div>
		<div class="reviewers-search-bar" style="position:sticky;top:0;z-index:20;background:rgba(255,255,255,0.18);backdrop-filter:blur(8px);padding:1.2rem 0 1.2rem 0;margin-bottom:2.2rem;display:flex;justify-content:center;align-items:center;gap:1rem;box-shadow:0 2px 12px #cadcfc22;">
			<input id="reviewersSearchInput" type="text" placeholder="Search reviewers by name, ID, or email..." style="width:340px;padding:0.8rem 1.2rem;border-radius:24px;border:none;font-size:1.08rem;background:rgba(255,255,255,0.7);box-shadow:0 2px 8px #cadcfc22;outline:none;">
			<button id="reviewersSearchClear" style="background:none;border:none;color:#1976a5;font-size:1.2rem;cursor:pointer;display:none;"><i class="fas fa-times-circle"></i></button>
		</div>
		<div id="reviewersGrid" class="reviewers-grid" style="width:100%;"></div>
	`;
	fetch("../../php/admin/get_reviewers.php")
		.then((r) => r.json())
		.then((data) => {
			if (data.status === "success" && data.data) {
				const reviewers = data.data;
				if (reviewers.length === 0) {
					document.getElementById(
						"reviewersGrid"
					).innerHTML = `<div class="no-students">No reviewers found.</div>`;
					return;
				}
				renderReviewerTable(reviewers);
				setupReviewersSearchTable(reviewers);
			} else {
				document.getElementById("reviewersGrid").innerHTML =
					'<div class="error-message">Failed to load reviewers. Please try again later.</div>';
			}
		})
		.catch(() => {
			document.getElementById("reviewersGrid").innerHTML =
				'<div class="error-message">Failed to load reviewers. Please try again later.</div>';
		});
}

function renderReviewerTable(reviewers) {
	const grid = document.getElementById("reviewersGrid");
	grid.innerHTML = "";
	if (!reviewers.length) {
		grid.innerHTML = '<div class="no-students">No reviewers found.</div>';
		return;
	}
	let table = `<div style=\"overflow-x:auto;width:100%;margin-left:0.5rem;\">
		<table class=\"reviewers-table\" style=\"width:100%;border-collapse:separate;border-spacing:0;background:#fff;border-radius:12px;box-shadow:0 2px 8px #cadcfc22;font-size:1rem;\">
			<thead>
				<tr style=\"background:#f7faff;\">
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">ID</th>
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">Name</th>
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">Email</th>
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">Last Active</th>
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">Role</th>
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">Permissions</th>
					<th style=\"padding:8px 6px;text-align:left;font-weight:700;color:#1976a5;vertical-align:middle;\">Actions</th>
				</tr>
			</thead>
			<tbody>`;
	reviewers.forEach((reviewer) => {
		table += `<tr style=\"border-bottom:1px solid #e3eafc;transition:background 0.15s;\" onmouseover=\"this.style.background='#f3f8fd'\" onmouseout=\"this.style.background=''\">
			<td style=\"padding:6px 6px;vertical-align:middle;color:#555;text-align:left;\">${
				reviewer.reviewer_id
			}</td>
			<td style=\"padding:6px 6px;vertical-align:middle;font-weight:600;color:#1976a5;text-align:left;\">${
				reviewer.fname
			} ${reviewer.lname}</td>
			<td style=\"padding:6px 6px;vertical-align:middle;color:#555;text-align:left;\">${
				reviewer.email
			}</td>
			<td style=\"padding:6px 6px;vertical-align:middle;color:#555;text-align:left;\">${
				reviewer.last_active
					? new Date(reviewer.last_active).toLocaleString()
					: "Never logged in"
			}</td>
			<td style=\"padding:6px 6px;vertical-align:middle;text-align:left;\">
				<select style=\"padding:0.25rem 0.7rem;border-radius:8px;border:1px solid #b5c7d3;background:#f7faff;font-size:0.98rem;\" onchange=\"setRole('${
					reviewer.reviewer_id
				}', this.value)\">
					<option value=\"reviewer\" ${
						reviewer.role === "reviewer" ? "selected" : ""
					}>Reviewer</option>
					<option value=\"student\" ${
						reviewer.role === "student" ? "selected" : ""
					}>Student</option>
				</select>
			</td>
			<td style=\"padding:6px 6px;vertical-align:middle;text-align:left;\">
				<button onclick=\"openPermissionsModal('${reviewer.reviewer_id}', '${
			reviewer.permissions || "view"
		}')\">Set</button>
			</td>
			<td style=\"padding:6px 6px;vertical-align:middle;text-align:left;\">
				<div style=\"display:flex;gap:0.3rem;align-items:center;flex-wrap:wrap;\">
					<button onclick=\"removeReviewer('${
						reviewer.reviewer_id
					}')\" class=\"pill-btn pill-btn-red\">Remove</button>
					${
						reviewer.Approve == 1
							? `<button onclick=\"inactiveReviewer('${reviewer.reviewer_id}')\" class=\"pill-btn pill-btn-gray\">Inactive</button>`
							: `<button onclick=\"approveReviewer('${reviewer.reviewer_id}')\" class=\"pill-btn pill-btn-blue\">Approve</button>`
					}
				</div>
			</td>
		</tr>`;
	});
	table += `</tbody></table></div>`;
	grid.innerHTML = table;
}

function setupReviewersSearchTable(reviewers) {
	const input = document.getElementById("reviewersSearchInput");
	const clearBtn = document.getElementById("reviewersSearchClear");
	input.addEventListener("input", function () {
		const val = input.value.trim().toLowerCase();
		clearBtn.style.display = val ? "inline" : "none";
		const filtered = reviewers.filter(
			(r) =>
				(r.fname + " " + r.lname).toLowerCase().includes(val) ||
				r.reviewer_id.toLowerCase().includes(val) ||
				r.email.toLowerCase().includes(val)
		);
		renderReviewerTable(filtered);
	});
	clearBtn.addEventListener("click", function () {
		input.value = "";
		clearBtn.style.display = "none";
		renderReviewerTable(reviewers);
		input.focus();
	});
}

async function fetchData(url, method = "GET", body = null) {
	try {
		const options = {
			method,
			headers: { "Content-Type": "application/json" },
		};
		if (body) options.body = JSON.stringify(body);

		const response = await fetch(url, options);

		// Log the raw response for debugging
		const text = await response.text();

		return JSON.parse(text);
	} catch (error) {
		console.error(`Error fetching from ${url}:`, error);
		alert("An error occurred while processing your request.");
		return null;
	}
}

async function approveReviewer(reviewerId) {
	try {
		const result = await fetchData(
			"../../php/admin/approve_reviewer.php",
			"POST",
			{ reviewer_id: reviewerId }
		);
		if (!result) return;
		Swal.fire({
			icon: "success",
			title: "Success",
			text: result.message,
			confirmButtonColor: "#1976a5",
		});
		if (result.status === "success") {
			showSection(currentSection);
			updateDashboardWidgets();
		}
	} catch (error) {
		console.error("Error approving reviewer:", error);
		alert("An error occurred while approving the reviewer.");
	}
}

async function removeReviewer(reviewerId) {
	if (!confirm("Are you sure you want to remove this reviewer?")) return;
	const result = await fetchData(
		"../../php/admin/remove_reviewer.php",
		"POST",
		{ reviewer_id: reviewerId }
	);
	if (!result) return;
	alert(result.message);
	if (result.status === "success") {
		showSection(currentSection);
		updateDashboardWidgets();
	}
}

function setupLogoutHandler() {
	const logoutButton = document.getElementById("logoutBtn");
	if (!logoutButton) return;

	logoutButton.addEventListener("click", async (e) => {
		e.preventDefault();
		if (window.Swal) {
			Swal.fire({
				title: "Logout",
				text: "Are you sure you want to logout?",
				icon: "question",
				showCancelButton: true,
				confirmButtonColor: "#e74c3c",
				cancelButtonColor: "#3085d6",
				confirmButtonText: "Yes, logout",
				cancelButtonText: "Cancel",
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = "../student_login.php";
				}
			});
		} else {
			if (confirm("Are you sure you want to logout?")) {
				window.location.href = "../student_login.php";
			}
		}
	});
}

// Helper to determine if reviewer is active (seen in last 7 days)
function isReviewerActive(lastActive) {
	if (!lastActive) return false;
	const now = new Date();
	const last = new Date(lastActive);
	const diffDays = (now - last) / (1000 * 60 * 60 * 24);
	return diffDays <= 7; // active if seen in last 7 days
}

async function viewStudent(studentId) {
	try {
		const response = await fetch(
			`../../php/admin/get_student_details.php?id=${studentId}`
		);
		const data = await response.json();

		if (data.status === "success") {
			Swal.fire({
				title: "Student Details",
				html: `
					<div class="student-details">
						<p><strong>ID:</strong> ${data.student.student_id}</p>
						<p><strong>Name:</strong> ${data.student.fname} ${data.student.lname}</p>
						<p><strong>Email:</strong> ${data.student.email}</p>
						<p><strong>Created:</strong> ${new Date(
							data.student.created_at
						).toLocaleDateString()}</p>
					</div>
				`,
				confirmButtonColor: "#1976a5",
			});
		} else {
			throw new Error(data.message || "Failed to fetch student details");
		}
	} catch (error) {
		console.error("Error:", error);
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "Failed to load student details",
			confirmButtonColor: "#1976a5",
		});
	}
}

async function editStudent(studentId) {
	try {
		const response = await fetch(
			`../../php/admin/get_student_details.php?id=${studentId}`
		);
		const data = await response.json();
		if (data.status === "success") {
			const { value: formValues } = await Swal.fire({
				title: "Edit Student",
				html: `
					<input id="fname" class="swal2-input" placeholder="First Name" value="${data.student.fname}">
					<input id="lname" class="swal2-input" placeholder="Last Name" value="${data.student.lname}">
					<input id="email" class="swal2-input" placeholder="Email" value="${data.student.email}">
				`,
				focusConfirm: false,
				showCancelButton: true,
				confirmButtonText: "Save Changes",
				confirmButtonColor: "#1976a5",
				preConfirm: () => {
					return {
						fname: document.getElementById("fname").value,
						lname: document.getElementById("lname").value,
						email: document.getElementById("email").value,
					};
				},
			});
			if (formValues) {
				const updateResponse = await fetch(
					"../../php/admin/update_student.php",
					{
						method: "POST",
						headers: {
							"Content-Type": "application/json",
						},
						body: JSON.stringify({
							student_id: studentId,
							...formValues,
						}),
					}
				);
				const updateData = await updateResponse.json();
				if (updateData.status === "success") {
					Swal.fire({
						icon: "success",
						title: "Success",
						text: "Student information updated successfully",
						confirmButtonColor: "#1976a5",
					}).then(() => {
						showSection(currentSection);
						updateDashboardWidgets();
					});
				} else {
					throw new Error(updateData.message || "Failed to update student");
				}
			}
		} else {
			throw new Error(data.message || "Failed to fetch student details");
		}
	} catch (error) {
		console.error("Error:", error);
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "Failed to update student information",
			confirmButtonColor: "#1976a5",
		});
	}
}

async function deleteStudent(studentId) {
	try {
		const result = await Swal.fire({
			title: "Delete Student",
			text: "Are you sure you want to delete this student?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#e74c3c",
			cancelButtonColor: "#3085d6",
			confirmButtonText: "Yes, delete",
		});
		if (result.isConfirmed) {
			const response = await fetch("../../php/admin/delete_student.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
				body: JSON.stringify({
					student_id: studentId,
				}),
			});
			const data = await response.json();
			if (data.status === "success") {
				Swal.fire({
					icon: "success",
					title: "Success",
					text: "Student deleted successfully",
					confirmButtonColor: "#1976a5",
				}).then(() => {
					showSection(currentSection);
					updateDashboardWidgets();
				});
			} else {
				throw new Error(data.message || "Failed to delete student");
			}
		}
	} catch (error) {
		console.error("Error:", error);
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "Failed to delete student",
			confirmButtonColor: "#1976a5",
		});
	}
}

async function setRole(id, role) {
	const result = await fetchData("../../php/admin/set_role.php", "POST", {
		id,
		role,
	});
	if (!result) return;
	if (result.status === "success") {
		Swal.fire({
			title: "Success",
			text: result.message,
			icon: "success",
		});
		showSection(currentSection);
		updateDashboardWidgets();
	}
}

// Dynamically load the publication thesis section
function loadPublicationThesisSection() {
	const dashboardContent = document.getElementById("dashboardContent");
	dashboardContent.innerHTML = `
		<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin-bottom:1.2rem;margin-top:0.5rem;position:relative;">
			<div style="position:absolute;top:-30px;right:-30px;width:90px;height:90px;background:linear-gradient(135deg,#1976a5 0%,#cadcfc 100%);opacity:0.10;border-radius:50%;z-index:0;"></div>
			<div style="position:absolute;bottom:-30px;left:-30px;width:90px;height:90px;background:linear-gradient(135deg,#cadcfc 0%,#1976a5 100%);opacity:0.10;border-radius:50%;z-index:0;"></div>
			<div style="position:relative;z-index:1;background:rgba(255,255,255,0.22);backdrop-filter:blur(10px);border-radius:22px;box-shadow:0 8px 32px 0 rgba(31,38,135,0.10);padding:1.2rem 2.2rem;min-width:320px;max-width:480px;width:100%;display:flex;align-items:center;gap:0.7rem;">
				<i class='fas fa-book' style='font-size:1.5rem;color:#1976a5;'></i>
				<span style="font-size:1.35rem;font-weight:700;color:#1976a5;letter-spacing:1px;">PUBLICATION THESES</span>
			</div>
		</div>
		<div class="thesis-search-bar" style="position:sticky;top:0;z-index:20;background:rgba(255,255,255,0.18);backdrop-filter:blur(8px);padding:1.2rem 0 1.2rem 0;margin-bottom:2.2rem;display:flex;justify-content:center;align-items:center;gap:1rem;box-shadow:0 2px 12px #cadcfc22;">
			<input id="thesisSearchInput" type="text" placeholder="Search theses by title, author, or abstract..." style="width:340px;padding:0.8rem 1.2rem;border-radius:24px;border:none;font-size:1.08rem;background:rgba(255,255,255,0.7);box-shadow:0 2px 8px #cadcfc22;outline:none;">
			<button id="thesisSearchClear" style="background:none;border:none;color:#1976a5;font-size:1.2rem;cursor:pointer;display:none;"><i class="fas fa-times-circle"></i></button>
		</div>
		<div id="allPublicTheses" style="display:flex;flex-direction:column;align-items:center;gap:2.2rem;width:100%;background:rgba(202,220,252,0.18);padding:2rem 0 4rem 0;min-height:60vh;"></div>
		<div id="publicModal" class="public-modal" style="display:none;"></div>
	`;
	fetch("../../php/student/get_public_repo.php")
		.then((res) => res.json())
		.then((data) => {
			renderPublicRepo(data);
			setupThesisSearch(data);
		});
}

function renderPublicRepo(data) {
	let rows = "";
	for (const u of data) {
		const filePath = "../../assets/thesisfile/" + u.ThesisFile;
		const profileImg = "../../assets/ImageProfile/" + u.profileImg;
		rows += `
			<div class="upload-item" style="width:100%;max-width:540px;background:rgba(255,255,255,0.22);backdrop-filter:blur(10px);border-radius:18px;box-shadow:0 8px 32px 0 rgba(31,38,135,0.10);padding:1.2rem 1rem 1.5rem 1rem;transition:box-shadow 0.2s,transform 0.2s;cursor:pointer;display:flex;flex-direction:column;align-items:flex-start;animation:fadeInUp 0.5s;gap:0.7rem;position:relative;border:2px solid #1976a5;overflow:hidden;margin:0 auto;">
				<div style='position:absolute;top:-30px;right:-30px;width:70px;height:70px;background:linear-gradient(135deg,#1976a5 0%,#cadcfc 100%);opacity:0.10;border-radius:50%;z-index:0;'></div>
				<div style='position:absolute;bottom:-30px;left:-30px;width:70px;height:70px;background:linear-gradient(135deg,#cadcfc 0%,#1976a5 100%);opacity:0.10;border-radius:50%;z-index:0;'></div>
				<div class="author-info" style="display:flex;align-items:center;gap:0.7rem;z-index:1;">
					<img src="${profileImg}" alt="Profile Image" class="profile-image" style="width:44px;height:44px;object-fit:cover;border-radius:50%;border:2px solid #1976a5;box-shadow:0 2px 8px #cadcfc33;background:#f4f8ff;">
					<span style="font-size:1.08rem;font-weight:600;letter-spacing:0.5px;color:#1a3a8f;">${capitalize(
						u.lname
					)}, ${capitalize(u.fname)}</span>
				</div>
				<h3 style="font-size:1.15rem;color:#00246b;font-weight:700;margin:0 0 0.3rem 0;display:flex;align-items:center;gap:0.5rem;z-index:1;"><i class='fas fa-book'></i> ${
					u.title
				}</h3>
				<p style="color:#444;font-size:0.98rem;margin:0 0 0.7rem 0;min-height:48px;z-index:1;">${
					u.abstract
				}</p>
				<embed src="${filePath}" type="application/pdf" width="100%" height="160" style="border-radius:8px;border:1px solid #cadcfc;background:#f4f8fb;z-index:1;">
				<div class="status-badge" style="position:absolute;top:1rem;right:1rem;background:#cadcfc;color:#00246b;font-size:0.92rem;font-weight:600;padding:0.25rem 0.7rem;border-radius:12px;box-shadow:0 2px 8px rgba(0,36,107,0.07);display:flex;align-items:center;gap:0.4rem;z-index:2;"><i class="fas fa-check"></i> ${
					u.Privacy || "Public"
				}</div>
			</div>
		`;
	}
	document.getElementById("allPublicTheses").innerHTML = rows;
	// Modal HTML
	document.getElementById("publicModal").outerHTML = `
	<div id="publicModal" class="public-modal" style="display:none;align-items:center;justify-content:center;">
	  <div class="public-modal-content" style="max-width:700px;width:95vw;max-height:90vh;border-radius:18px;box-shadow:0 8px 40px #1976a522,0 1.5px 0 #cadcfc;padding:0;display:flex;flex-direction:column;">
		<span class="public-modal-close" id="closePublicModal" style="position:absolute;top:12px;right:18px;font-size:2rem;color:#fff;cursor:pointer;font-weight:700;transition:color 0.18s;z-index:10;text-shadow:0 2px 8px #1976a5cc;">&times;</span>
		<div class="public-modal-header" style="display:flex;align-items:center;gap:18px;background:#00246b;padding:18px 28px 14px 28px;border-bottom:1.5px solid #e9f0ff;">
		  <div class="public-modal-icon" style="background:#fff;color:#1976a5;border-radius:50%;width:44px;height:44px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;box-shadow:0 2px 8px #cadcfc33;"><i class="fas fa-book-open"></i></div>
		  <div>
			<h2 id="publicModalTitle" style="color:#fff;font-size:1.5rem;font-weight:700;margin:0 0 4px 0;letter-spacing:0.5px;"></h2>
			<div class="public-modal-status" id="publicModalStatus" style="background:#ffe082;color:#333;border-radius:6px;padding:2px 12px;font-size:1rem;font-weight:600;display:inline-block;margin-top:2px;"></div>
		  </div>
		</div>
		<div class="public-modal-body" style="padding:18px 28px 24px 28px;overflow-y:auto;flex:1;display:flex;flex-direction:column;gap:12px;max-height:60vh;">
		  <p id="publicModalAbstract" class="public-modal-abstract" style="font-size:1.05rem;color:#1976a5;background:#f4f8ff;border-radius:8px;padding:10px 16px;margin-bottom:8px;font-style:italic;box-shadow:0 1px 4px #cadcfc33;border-left:4px solid #1976a5;word-break:break-word;"></p>
		  <div class="public-modal-author" id="publicModalOwner" style="display:flex;align-items:center;gap:0.5rem;color:#1a3a8f;font-weight:500;margin-bottom:8px;font-size:1rem;"></div>
		  <iframe id="publicModalPDF" src="" width="100%" style="border-radius:12px;box-shadow:0 2px 12px #1976a522;margin-top:18px;border:2px solid #e9f0ff;"></iframe>
		</div>
	  </div>
	</div>`;
	setupPublicModal();
}

function capitalize(str) {
	if (!str) return "";
	return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
}

// Modal open function
window.openModal = function (filePath, title, abstract, owner, status) {
	document.getElementById("publicModalTitle").textContent = title;
	document.getElementById("publicModalStatus").textContent = status || "Public";
	document.getElementById(
		"publicModalAbstract"
	).innerHTML = `<i class="fas fa-quote-left"></i> ${abstract}`;
	document.getElementById(
		"publicModalOwner"
	).innerHTML = `<i class="fas fa-user-graduate"></i> <span>${owner}</span>`;
	document.getElementById("publicModalPDF").src = filePath + "#toolbar=0";
	document.getElementById("publicModal").style.display = "flex";
};

function setupPublicModal() {
	const closeBtn = document.getElementById("closePublicModal");
	const modal = document.getElementById("publicModal");
	const modalPDF = document.getElementById("publicModalPDF");
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
}

// Add fadeInUp animation
const fadeStyle = document.createElement("style");
fadeStyle.innerHTML = `
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}`;
document.head.appendChild(fadeStyle);

function setupThesisSearch(theses) {
	const input = document.getElementById("thesisSearchInput");
	const clearBtn = document.getElementById("thesisSearchClear");
	input.addEventListener("input", function () {
		const val = input.value.trim().toLowerCase();
		clearBtn.style.display = val ? "inline" : "none";
		const filtered = theses.filter(
			(t) =>
				(t.title && t.title.toLowerCase().includes(val)) ||
				(t.lname + ", " + t.fname).toLowerCase().includes(val) ||
				(t.abstract && t.abstract.toLowerCase().includes(val))
		);
		renderPublicRepo(filtered);
	});
	clearBtn.addEventListener("click", function () {
		input.value = "";
		clearBtn.style.display = "none";
		renderPublicRepo(theses);
		input.focus();
	});
}

async function inactiveReviewer(reviewerId) {
	try {
		const result = await fetchData(
			"../../php/admin/inactive_reviewer.php",
			"POST",
			{ reviewer_id: reviewerId }
		);
		if (!result) return;
		Swal.fire({
			icon: "success",
			title: "Success",
			text: result.message,
			confirmButtonColor: "#1976a5",
		});
		if (result.status === "success") {
			showSection(currentSection);
			updateDashboardWidgets();
		}
	} catch (error) {
		console.error("Error setting reviewer inactive:", error);
		alert("An error occurred while setting the reviewer inactive.");
	}
}

// Add modal HTML to the page (if not present)
if (!document.getElementById("permissionsModal")) {
	const modal = document.createElement("div");
	modal.id = "permissionsModal";
	modal.style.display = "none";
	modal.innerHTML = `
		<div style='position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);z-index:9999;display:flex;align-items:center;justify-content:center;'>
			<form id='permissionsForm' style='background:#fff;padding:2rem 2.5rem;border-radius:16px;box-shadow:0 2px 16px #0002;display:flex;flex-direction:column;gap:1.2rem;min-width:260px;'>
				<h3 style='margin:0 0 1rem 0;font-size:1.2rem;color:#1976a5;'>Set Reviewer Permissions</h3>
				<label><input type='checkbox' name='perm' value='view'> View</label>
				<label><input type='checkbox' name='perm' value='approve'> Approve</label>
				<label><input type='checkbox' name='perm' value='revise'> Revise</label>
				<label><input type='checkbox' name='perm' value='reject'> Reject</label>
				<input type='hidden' id='permReviewerId'>
				<div style='display:flex;gap:1rem;justify-content:flex-end;'>
					<button type='button' onclick='document.getElementById("permissionsModal").style.display="none"'>Cancel</button>
					<button type='submit'>Save</button>
				</div>
			</form>
		</div>
	`;
	document.body.appendChild(modal);
}

// Make the function global so inline onclick works
window.openPermissionsModal = function (reviewerId, permissions) {
	document.getElementById("permissionsModal").style.display = "block";
	document.getElementById("permReviewerId").value = reviewerId;
	const perms = (permissions || "view").split(",");
	document
		.querySelectorAll("#permissionsForm input[type=checkbox]")
		.forEach((cb) => {
			cb.checked = perms.includes(cb.value);
		});
};

document.getElementById("permissionsForm").onsubmit = async function (e) {
	e.preventDefault();
	const reviewerId = document.getElementById("permReviewerId").value;
	const perms = Array.from(
		document.querySelectorAll("#permissionsForm input[type=checkbox]:checked")
	).map((cb) => cb.value);
	await fetch("../../php/admin/set_reviewer_permissions.php", {
		method: "POST",
		headers: { "Content-Type": "application/json" },
		body: JSON.stringify({
			reviewer_id: reviewerId,
			permissions: perms.join(","),
		}),
	});
	document.getElementById("permissionsModal").style.display = "none";
	showSection("reviewers");
};
