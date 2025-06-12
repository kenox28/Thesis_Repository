document.getElementById("superAdminLoginForm").addEventListener("submit", async function (e) {
    e.preventDefault();
    const form = document.getElementById("superAdminLoginForm");
    const formdata = new FormData(form);

    const res = await fetch("../../php/super_admin_login.php", {
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
        window.location.href = "super_admin_dashboard.php";
    } else {
        if (window.Swal) {
            Swal.fire({
                icon: "error",
                title: "Login Failed",
                html: result.message,
                confirmButtonColor: "#1976a5",
            });
        } else {
            alert(result.message);
        }
    }
}); 