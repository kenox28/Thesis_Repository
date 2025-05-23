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
    const result = await fetchData("../../php/admin/get_students.php");
    if (!result) return;

    if (result.status === "success") {
        const students = result.data;
        const container = document.getElementById("studentContainer");

        // Clear the container before adding new tiles
        container.innerHTML = "";

        // Render student tiles
        students.forEach(student => {
            const tile = `
                <div class="student-tile">
                    <h3>${student.fname} ${student.lname}</h3>
                    <p><strong>ID:</strong> ${student.student_id}</p>
                    <p><strong>Email:</strong> ${student.email}</p>
                </div>
            `;
            container.innerHTML += tile;
        });
    } else {
        alert(result.message);
    }
}

async function fetchReviewers() {
    const result = await fetchData("../../php/admin/get_reviewers.php");
    if (!result) return;

    if (result.status === "success") {
        const reviewers = result.data;

        // Separate reviewers into approved and pending groups
        const approvedReviewers = reviewers.filter(reviewer => reviewer.approve == 1);
        const pendingReviewers = reviewers.filter(reviewer => reviewer.approve == 0);

        // Get containers for approved and pending reviewers
        const approvedContainer = document.getElementById("approvedReviewers");
        const pendingContainer = document.getElementById("pendingReviewers");

        // Clear the containers before adding new tiles
        approvedContainer.innerHTML = "";
        pendingContainer.innerHTML = "";

        // Render approved reviewers
        approvedReviewers.forEach(reviewer => {
            const tile = `
                <div class="reviewer-tile">
                    <h3>${reviewer.fname} ${reviewer.lname}</h3>
                    <p><strong>Email:</strong> ${reviewer.email}</p>
                    <p><strong>ID:</strong> ${reviewer.reviewer_id}</p>
                    <p><strong>Approved:</strong> Yes</p>
                    <button class="btn-remove" onclick="removeReviewer('${reviewer.reviewer_id}')">Remove</button>
                </div>
            `;
            approvedContainer.innerHTML += tile;
        });

        // Render pending reviewers
        pendingReviewers.forEach(reviewer => {
            const tile = `
                <div class="reviewer-tile">
                    <h3>${reviewer.fname} ${reviewer.lname}</h3>
                    <p><strong>Email:</strong> ${reviewer.email}</p>
                    <p><strong>ID:</strong> ${reviewer.reviewer_id}</p>
                    <p><strong>Approved:</strong> No</p>
                    <button class="btn-approve" onclick="approveReviewer('${reviewer.reviewer_id}')">Approve</button>
                    <button class="btn-remove" onclick="removeReviewer('${reviewer.reviewer_id}')">Remove</button>
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
        const result = await fetchData("../../php/admin/approve_reviewer.php", "POST", { reviewer_id: reviewerId });
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

    const result = await fetchData("../../php/admin/remove_reviewer.php", "POST", { reviewer_id: reviewerId });
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
        if (result.status === "success") window.location.href = "../landingpage.php";
    });
}
