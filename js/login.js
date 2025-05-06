document.getElementById("loginForm").addEventListener("submit", loginfun);

async function loginfun(e) {
	e.preventDefault();
	const form = document.getElementById("loginForm");
	const formdata = new FormData(form);

	const res = await fetch("../php/login.php", {
		method: "POST",
		body: formdata,
	});
	const result = await res.json();

	if (result.status === "success") {
		window.location.href = "../views/homepage.php";
	} else {
		alert(result.message);
	}
}
