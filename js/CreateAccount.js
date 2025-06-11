<<<<<<< HEAD
const passwordInput = document.getElementById("password");
const passwordStrengthBar = document.getElementById("password-strength-bar");
const passwordStrengthLabel = document.getElementById(
	"password-strength-label"
);
const createForm = document.getElementById("CreateForm");

createForm.addEventListener("submit", CreateFun);
passwordInput.addEventListener("input", handlePasswordInput);

function handlePasswordInput() {
	const password = passwordInput.value;
	checkPasswordStrength(password);
}

function checkPasswordStrength(password) {
	// Requirements
	const minLength = 8;
	const hasUpperCase = /[A-Z]/.test(password);
	const hasLowerCase = /[a-z]/.test(password);
	const hasNumbers = /[0-9]/.test(password);
	const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(password);

	let strength = 0;
	if (password.length >= minLength) strength++;
	if (hasUpperCase) strength++;
	if (hasNumbers) strength++;
	if (hasSpecialChars) strength++;

	// Bar and label logic
	let barWidth = "0%";
	let barColor = "#e0e0e0";
	let label = "";
	let allowSubmit = false;

	if (password.length === 0) {
		barWidth = "0%";
		barColor = "#e0e0e0";
		label = "";
	} else if (strength <= 2) {
		barWidth = "33%";
		barColor = "#e53935";
		label = "Weak";
	} else if (strength === 3) {
		barWidth = "66%";
		barColor = "#fbc02d";
		label = "Medium";
	} else if (strength === 4) {
		barWidth = "100%";
		barColor = "#43a047";
		label = "Strong";
		// Only allow if all requirements are met
		if (
			password.length >= minLength &&
			hasUpperCase &&
			hasNumbers &&
			hasSpecialChars
		) {
			allowSubmit = true;
		}
	}

	passwordStrengthBar.style.width = barWidth;
	passwordStrengthBar.style.background = barColor;
	passwordStrengthLabel.textContent = label;

	// Return if password is strong and meets all requirements
	if (allowSubmit) return "strong";
	if (password.length === 0) return "empty";
	if (strength === 3) return "medium";
	return "weak";
}
=======
const createForm = document.getElementById("CreateForm");

createForm.addEventListener("submit", CreateFun);
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639

async function CreateFun(e) {
	e.preventDefault(); // Prevent form submission initially

<<<<<<< HEAD
	const password = passwordInput.value;
	const strength = checkPasswordStrength(password);

	if (strength !== "strong") {
		Swal.fire({
			icon: "error",
			title: "Password Requirements",
			html: 'Password must be at least 8 characters and include:<ul style="text-align:left;"><li>One uppercase letter</li><li>One number</li><li>One symbol</li></ul>',
		});
		return;
	}

=======
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
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
<<<<<<< HEAD
		alert("Server error:\n" + text);
=======
		console.log("Server error:\n" + text);
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
		return;
	}

	if (data.status === "success") {
		Swal.fire({
			icon: "success",
			title: "Success!",
			text: data.message,
		}).then(() => {
<<<<<<< HEAD
			createForm.reset();
			passwordStrengthBar.style.width = "0%";
			passwordStrengthLabel.textContent = "";
=======
			window.location.href = "../views/student/public_repo.php";
>>>>>>> 5c1e57b9ffdeb14cbc469ca190ff7089f52b1639
		});
	} else {
		Swal.fire({
			icon: "error",
			title: "Error!",
			text: data.message,
		});
	}
}
