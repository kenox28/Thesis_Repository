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
