$(document).ready(function() {
});

function login() {
	let email = $("#email").val().trim();
	let password = $("#password").val();
	if (email == "" || password.trim() == "") {
		alert("Mohon masukkan email dan kata sandi");
		return;
	}
	let fd = new FormData();
	fd.append("email", email);
	fd.append("password", password);
	fetch(API_URL+"/admin/login", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			localStorage.setItem("user_id", parseInt(obj['user_id']));
			let responseCode = parseInt(obj['response_code']);
			if (responseCode == 1) {
				window.location.href = API_URL+"/notification";
			} else if (responseCode == -1) {
				alert("Kombinasi email dan kata sandi salah");
			}
		});
}
