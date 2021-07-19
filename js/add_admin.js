var selectedProfilePicture = null;

$(document).ready(function() {
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
	let password = $("#email").val().trim();
	if (name == "" || email == "" || password == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("name", name);
	fd.append("email", email);
	fd.append("password", password);
	fd.append("profile_picture_changed", selectedProfilePicture==null?"0":"1");
	if (selectedProfilePicture != null) {
		fd.append("file", selectedProfilePicture);
	}
	fetch(API_URL+"/admin/add_admin", {
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
