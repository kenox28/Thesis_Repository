document.getElementById("add_panel").addEventListener("submit", CreateFun);

async function CreateFun(e) {
	const form = document.getElementById("add_panel");
	const formdata = new FormData(form);

	const res = await fetch("../php/panelist.php", {
		method: "POST",
		body: formdata,
	});

	const result = await res.json();

	if (result.status === "success") {
		console.log("success", result.message);
		swal("Success!", result.message, "success");
		showpost();
	} else {
		console.log("failed", result.message);
		swal("Error!", result.message, "error");
	}
}
