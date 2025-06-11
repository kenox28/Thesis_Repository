const createForm = document.getElementById("CreateForm");

createForm.addEventListener("submit", CreateFun);

async function CreateFun(e) {
	e.preventDefault(); // Prevent form submission initially

	const formdata = new FormData(createForm);

	const res = await fetch("../php/CreateAccount.php", {
		method: "POST",
		body: formdata,
	});

	const text = await res.text();
	let data;
	try {
		data = JSON.parse(text);
	} catch (e) {
		console.log("Server error:\n" + text);
		return;
	}

	if (data.status === "success") {
		Swal.fire({
			icon: "success",
			title: "Success!",
			text: data.message,
		}).then(() => {
			window.location.href = "../views/student/public_repo.php";
		});
	} else {
		Swal.fire({
			icon: "error",
			title: "Error!",
			text: data.message,
		});
	}
}
