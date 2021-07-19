var adminID = 0;
var prevEmail = "";
var selectedProfilePicture = null;

$(document).ready(function() {
	adminID = parseInt($("#edited-admin-id").val().trim());
	let fd = new FormData();
	fd.append("id", adminID);
	fetch(API_URL+"/admin/get_admin_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			prevEmail = obj['email'];
			let profilePicture = obj['profile_picture'];
			if (profilePicture != null && profilePicture.trim() != "") {
				$("#profile-picture").attr("src", USERDATA_URL+profilePicture);
			}
			$("#name").val(obj['name']);
			$("#email").val(obj['email']);
			$("#password").val(obj['password']);
		});
	$("#select-profile-picture").on('change', function() {
		selectedProfilePicture = this.files[0];
		var fr = new FileReader();
		fr.onload = function(e) {
			$("#profile-picture").attr("src", e.target.result);
		};
		fr.readAsDataURL(selectedProfilePicture);
	});
});

function changeProfilePicture() {
	$("#select-profile-picture").click();
}

function cancel() {
	window.history.back();
}

function save() {
	let name = $("#name").val().trim();
	let email = $("#email").val().trim();
	let password = $("#password").val();
	if (name == "" || email == "" || password == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("id", adminID);
	fd.append("name", name);
	fd.append("email", email);
	fd.append("password", password);
	fd.append("email_changed", prevEmail.trim()==email?"0":"1");
	fd.append("profile_picture_changed", selectedProfilePicture==null?"0":"1");
	if (selectedProfilePicture != null) {
		fd.append("file", selectedProfilePicture);
	}
	fetch(API_URL+"/admin/edit_admin", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			let responseCode = parseInt(obj['response_code']);
			if (responseCode == 1) {
				window.history.back();
			} else if (responseCode == -1) {
				alert("Email sudah digunakan oleh admin lain");
			}
		});
}
