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
	} else if (result.status === "reviewer") {
		window.location.href = "../views/View_thesis.php";
	} else {
		alert(result.message);
	}
}
