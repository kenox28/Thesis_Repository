document.getElementById("loginForm").addEventListener("submit", loginfun);

async function loginfun(e) {
	e.preventDefault();
	const form = document.getElementById("loginForm");
	const formdata = new FormData(form);

	const res = await fetch("../php/login.php", {
		method: "POST",
		body: formdata,
	});
	const text = await res.text();
	let result;
	try {
		result = JSON.parse(text);
	} catch (e) {
		alert("Server error:\n" + text);
		return;
	}

	if (result.status === "success") {
		window.location.href = "../views/student/public_repo.php";
	} else if (result.status === "admin") {
		window.location.href = "../views/admin/admin_dashboard.php";
	} else if (result.status === "reviewer") {
		window.location.href = "../views/reviewer/dashboard.php";
	} else if (result.status === "reset_required") {
		// Show force reset modal
		document.getElementById('forceResetModal').style.display = 'flex';
		// Block login form
		document.getElementById('loginForm').style.pointerEvents = 'none';
		document.getElementById('loginForm').style.opacity = '0.5';
		// Block navigation
		window.onbeforeunload = function() {
			return 'You must change your password before leaving this page.';
		};
		// Handle force reset form
		const forceResetForm = document.getElementById('forceResetForm');
		if (forceResetForm) {
			forceResetForm.onsubmit = async function(e) {
				e.preventDefault();
				const password = forceResetForm.password.value;
				const confirm = forceResetForm.confirm.value;
				if (password.length < 8) {
					document.getElementById('forceResetMsg').textContent = 'Password must be at least 8 characters.';
					return;
				}
				if (password !== confirm) {
					document.getElementById('forceResetMsg').textContent = 'Passwords do not match.';
					return;
				}
				// Send AJAX to reset password
				const res = await fetch('../php/reset_password_api.php', {
					method: 'POST',
					headers: { 'Content-Type': 'application/json' },
					body: JSON.stringify({
						user_id: result.student_id,
						password,
						confirm
					})
				});
				const apiResult = await res.json();
				if (apiResult.status === 'success') {
					document.getElementById('forceResetMsg').style.color = '#1976a5';
					document.getElementById('forceResetMsg').textContent = 'Password changed successfully! You can now use the system.';
					document.getElementById('forceResetClose').style.display = 'block';
					window.onbeforeunload = null;
					// Optionally, redirect to public_repo.php after a short delay
					setTimeout(() => {
						window.location.href = '../views/student/public_repo.php';
					}, 1200);
				} else {
					document.getElementById('forceResetMsg').style.color = '#e74c3c';
					document.getElementById('forceResetMsg').textContent = apiResult.message || 'Failed to change password.';
				}
			};
			document.getElementById('forceResetClose').onclick = function() {
				document.getElementById('forceResetModal').style.display = 'none';
			};
		}
	} else if (
		result.status === "failed" &&
		result.message &&
		result.message.includes("QR code was not scanned in time")
	) {
		if (window.Swal) {
			Swal.fire({
				icon: "error",
				title: "Login Failed",
				html: result.message,
				confirmButtonColor: "#1976a5",
			});
		} else {
			swal.fire({
				icon: "error",
				title: "Login Failed",
				html: result.message,
				confirmButtonColor: "#1976a5",
			});
		}
	} else {
		swal.fire({
			icon: "error",
			title: "Login Failed",
			html: result.message,
			confirmButtonColor: "#1976a5",
		});
	}
}
