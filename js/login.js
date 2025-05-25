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
    window.location.href = "../views/student/homepage.php";
  } else if (result.status === "admin") {
    window.location.href = "../views/admin/admin_dashboard.php";
  } else if (result.status === "reviewer") {
    window.location.href = "../views/reviewer/dashboard.php";
  } else {
    alert(result.message);
  }
}
