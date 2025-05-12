document.getElementById("CreateForm").addEventListener("submit", CreateFun);

async function CreateFun(e) {
	const form = document.getElementById("CreateForm");
	const formdata = new FormData(form);

	const res = await fetch("../php/CreateAccount.php", {
		method: "POST",
		body: formdata,
	});

	const result = await res.json();

	if (result.status === "success") {
		console.log("success", result.message);
		swal("Success!", result.message, "success");
	} else {
		console.log("failed", result.message);
		swal("Error!", result.message, "error");
	}
}
