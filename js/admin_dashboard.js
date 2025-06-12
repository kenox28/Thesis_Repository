document.addEventListener("DOMContentLoaded", () => {
	fetchStudents();
	fetchReviewers();
	setupLogoutHandler();
});

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

async function fetchStudents() {
	const studentContainer = document.getElementById("studentContainer");
	studentContainer.innerHTML = '<div class="loading">Loading students...</div>';

	try {
		const response = await fetch("../../php/admin/get_students.php");
		const data = await response.json();

		if (data.status === "success") {
			if (!data.students || data.students.length === 0) {
				studentContainer.innerHTML =
					'<div class="no-students">No students registered yet.</div>';
				return;
			}

			const studentGrid = document.createElement("div");
			studentGrid.className = "student-grid";

			data.students.forEach((student) => {
				const studentCard = createStudentCard(student);
				studentGrid.appendChild(studentCard);
			});

			studentContainer.innerHTML = "";
			studentContainer.appendChild(studentGrid);
		} else {
			throw new Error(data.message || "Failed to fetch students");
		}
	} catch (error) {
		console.error("Error:", error);
		studentContainer.innerHTML = `
			<div class="error-message">
				<i class="fas fa-exclamation-circle"></i>
				Failed to load students. Please try again later.
			</div>`;
	}
}

function createStudentCard(student) {
	const card = document.createElement("div");
	card.className = "student-card";

	console.log(student.profileImg);
	const profileImg2 = "../../assets/ImageProfile/" + student.profileImg;

	card.innerHTML = `
		<div class="student-header">
			<img src="${profileImg2}" alt="${student.fname} ${student.lname}" class="student-avatar">
			<div class="student-info">
				<h3>${student.fname} ${student.lname}</h3>
				<p class="student-id">${student.student_id}</p>
				<p class="student-email">${student.email}</p>
				<button class="btn-role" onclick="setRole('${student.student_id}', 'reviewer')">Set Role to Reviewer</button>
			</div>
		</div>
		<div class="student-actions">
			<button onclick="viewStudent('${student.student_id}')" class="btn btn-primary">
				<i class="fas fa-eye"></i> View Details
			</button>
			<button onclick="editStudent('${student.student_id}')" class="btn btn-secondary">
				<i class="fas fa-edit"></i> Edit
			</button>
			<button onclick="deleteStudent('${student.student_id}')" class="btn btn-danger">
				<i class="fas fa-trash"></i> Delete
			</button>
		</div>
	`;

	return card;
}

async function fetchReviewers() {
	const result = await fetchData("../../php/admin/get_reviewers.php");
	if (!result) return;

	if (result.status === "success") {
		const reviewers = result.data;

		// Separate reviewers into approved and pending groups
		const approvedReviewers = reviewers.filter(
			(reviewer) => reviewer.approve == 1
		);
		const pendingReviewers = reviewers.filter(
			(reviewer) => reviewer.approve == 0
		);

		// Get containers for approved and pending reviewers
		const approvedContainer = document.getElementById("approvedReviewers");
		const pendingContainer = document.getElementById("pendingReviewers");

		// Clear the containers before adding new tiles
		approvedContainer.innerHTML = "";
		pendingContainer.innerHTML = "";

		// Render approved reviewers
		approvedReviewers.forEach((reviewer) => {
			const lastSeenText = reviewer.last_active
				? `Last seen: ${new Date(reviewer.last_active).toLocaleString()}`
				: "Never logged in";
			const tile = `
                <div class="reviewer-tile">
                    <h3>${reviewer.fname} ${reviewer.lname}</h3>
                    <p><strong>Email:</strong> ${reviewer.email}</p>
                    <p><strong>ID:</strong> ${reviewer.reviewer_id}</p>
                    <p>${lastSeenText}</p>
                    <p><strong>Approved:</strong> Yes</p>
                    <button class="btn-remove" onclick="removeReviewer('${reviewer.reviewer_id}')">Remove</button>
					<button class="btn-inactive" onclick="inactiveReviewer('${reviewer.reviewer_id}')">Inactive</button>
                </div>
            `;
			approvedContainer.innerHTML += tile;
		});

		// Render pending reviewers
		pendingReviewers.forEach((reviewer) => {
			const statusText = isReviewerActive(reviewer.last_active)
				? "Active"
				: "Inactive";
			const lastSeenText = reviewer.last_active
				? `Last seen: ${new Date(reviewer.last_active).toLocaleString()}`
				: "Never logged in";
			const tile = `
                <div class="reviewer-tile">
                    <h3>${reviewer.fname} ${reviewer.lname}</h3>
                    <p><strong>Email:</strong> ${reviewer.email}</p>
                    <p><strong>ID:</strong> ${reviewer.reviewer_id}</p>
                    <p><strong>Status:</strong> ${statusText}</p>
                    <p>${lastSeenText}</p>
                    <p><strong>Approved:</strong> No</p>
                    <button class="btn-approve" onclick="approveReviewer('${reviewer.reviewer_id}')">Approve</button>
                    <button class="btn-remove" onclick="removeReviewer('${reviewer.reviewer_id}')">Remove</button>
					<button class="btn-role" onclick="setRole('${reviewer.reviewer_id}', 'student')">Set Role to Student</button>
                </div>
            `;
			pendingContainer.innerHTML += tile;
		});
	} else {
		alert(result.message);
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

		alert(result.message);
		if (result.status === "success") fetchReviewers();
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
	if (result.status === "success") fetchReviewers();
}

function setupLogoutHandler() {
	const logoutButton = document.querySelector(".btn-danger");
	if (!logoutButton) return;

	logoutButton.addEventListener("click", async (e) => {
		e.preventDefault();
		const result = await fetchData("../../php/admin/admin_logout.php", "POST");
		if (!result) return;

		alert(result.message);
		if (result.status === "success")
			window.location.href = "../landingpage.php";
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
			`../../php/get_student_details.php?id=${studentId}`
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
			`../../php/get_student_details.php?id=${studentId}`
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
				const updateResponse = await fetch("../../php/update_student.php", {
					method: "POST",
					headers: {
						"Content-Type": "application/json",
					},
					body: JSON.stringify({
						student_id: studentId,
						...formValues,
					}),
				});

				const updateData = await updateResponse.json();

				if (updateData.status === "success") {
					Swal.fire({
						icon: "success",
						title: "Success",
						text: "Student information updated successfully",
						confirmButtonColor: "#1976a5",
					}).then(() => {
						fetchStudents(); // Refresh the student list
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
			const response = await fetch("../../php/delete_student.php", {
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
					fetchStudents(); // Refresh the student list
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
	console.log(id, role);
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
		fetchStudents();
		fetchReviewers();
	}
}

async function inactiveReviewer(reviewerId) {
	try {
		const result = await fetchData(
			"../../php/admin/inactive_reviewer.php",
			"POST",
			{ reviewer_id: reviewerId }
		);
		if (!result) return;

		alert(result.message);
		if (result.status === "success") fetchReviewers();
	} catch (error) {
		console.error("Error approving reviewer:", error);
		alert("An error occurred while approving the reviewer.");
	}
}
