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
				// Password strength validation
				const requirements = [
					password.length >= 8 && password.length <= 12,
					/[A-Z]/.test(password),
					/[a-z]/.test(password),
					/[0-9]/.test(password),
					/[^A-Za-z0-9]/.test(password)
				];
				if (requirements.includes(false)) {
					forceResetMsg.style.color = '#e74c3c';
					forceResetMsg.textContent = 'Password must be 8-12 chars, include uppercase, lowercase, number, and symbol.';
					return;
				}
				if (password !== confirm) {
					forceResetMsg.style.color = '#e74c3c';
					forceResetMsg.textContent = 'Passwords do not match.';
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

document.addEventListener('DOMContentLoaded', function() {
	const forceResetPassword = document.getElementById('forceResetPassword');
	const passwordStrengthBar = document.getElementById('passwordStrengthBar');
	const forceResetMsg = document.getElementById('forceResetMsg');
	const passwordStrengthText = document.getElementById('passwordStrengthText');

	function updateStrengthMeter(password) {
		let score = 0;
		let text = '';
		let color = '#e74c3c'; // red
		if (password.length < 8) {
			text = 'Too short';
			color = '#e74c3c';
		} else {
			if (/[A-Z]/.test(password)) score++;
			if (/[a-z]/.test(password)) score++;
			if (/[0-9]/.test(password)) score++;
			if (/[^A-Za-z0-9]/.test(password)) score++;
			if (score <= 1) {
				text = 'Weak';
				color = '#e74c3c';
			} else if (score === 2 || score === 3) {
				text = 'Medium';
				color = '#f1c40f';
			} else if (score === 4) {
				text = 'Strong';
				color = '#27ae60';
			}
		}
		let percent = password.length < 8 ? 10 : (score / 4) * 100;
		if (passwordStrengthBar) {
			passwordStrengthBar.style.width = percent + '%';
			passwordStrengthBar.style.background = color;
		}
		if (passwordStrengthText) {
			passwordStrengthText.textContent = password.length === 0 ? '' : text;
			passwordStrengthText.style.color = color;
		}
	}

	function updateChecklist(password) {
		const reqLength = document.getElementById('req-length');
		const reqUpper = document.getElementById('req-upper');
		const reqLower = document.getElementById('req-lower');
		const reqNumber = document.getElementById('req-number');
		const reqSymbol = document.getElementById('req-symbol');
		// Length
		if (reqLength) reqLength.style.color = (password.length >= 8 && password.length <= 12) ? '#27ae60' : '#888';
		// Uppercase
		if (reqUpper) reqUpper.style.color = /[A-Z]/.test(password) ? '#27ae60' : '#888';
		// Lowercase
		if (reqLower) reqLower.style.color = /[a-z]/.test(password) ? '#27ae60' : '#888';
		// Number
		if (reqNumber) reqNumber.style.color = /[0-9]/.test(password) ? '#27ae60' : '#888';
		// Symbol
		if (reqSymbol) reqSymbol.style.color = /[^A-Za-z0-9]/.test(password) ? '#27ae60' : '#888';
	}

	if (forceResetPassword) {
		forceResetPassword.addEventListener('input', function() {
			updateStrengthMeter(this.value);
			updateChecklist(this.value);
		});
		// On page load, show strength if field is pre-filled
		updateStrengthMeter(forceResetPassword.value);
		updateChecklist(forceResetPassword.value);
	}
});
