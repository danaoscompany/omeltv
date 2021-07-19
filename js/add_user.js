var selectedProfilePicture = null;

$(document).ready(function() {
	/* FOR TEST ONLY */
	$("#name").val("User 2");
	$("#email").val("user2@gmail.com");
	$("#phone").val("081123456781");
	$("#password").val("abc");
	$("#birth_place").val("Surabaya");
	$("#birthday").val("1995-08-18");
	$("#gender").prop('selectedIndex', 1);
	$("#job").prop('selectedIndex', 1);
	$("#relationship-status").prop('selectedIndex', 1);
	$("#email-verified").prop('selectedIndex', 1);
	$("#phone-verified").prop('selectedIndex', 1);
	$("#profile-completed").prop('selectedIndex', 1);
	$("#credits").val(100);
	$("#premium").prop('selectedIndex', 1);
	$("#month-premium").val(12);
	/* */
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
	if (confirm("Apakah Anda yakin ingin membatalkan perubahan yang Anda buat?")) {
		window.history.back();
	}
}

function save() {
	let name = $("#name").val().trim();
	let email = $("#email").val().trim();
	let phone = $("#phone").val().trim();
	let password = $("#password").val().trim();
	let birthPlace = $("#birth_place").val().trim();
	let birthday = $("#birthday").val().trim();
	let gender = $("#gender").prop('selectedIndex');
	let job = $("#job").val().trim();
	let relationshipStatus = $("#relationship-status").val().trim();
	let emailVerified = $("#email-verified").prop('selectedIndex');
	let phoneVerified = $("#phone-verified").prop('selectedIndex');
	let profileCompleted = $("#profile-completed").prop('selectedIndex');
	let credits = $("#credits").val().trim();
	let premium = $("#premium").prop('selectedIndex');
	let monthPremium = $("#month-premium").val().trim();
	if (email == "" || phone == "" || password == "" || birthPlace == "" || birthday == "" || gender == ""
		|| job == "" || relationshipStatus == "" || emailVerified == "" || phoneVerified == ""
		|| profileCompleted == "" || credits == "" || premium == "" || monthPremium == "") {
		alert("Mohon lengkapi data");
		return;
	}
	if (!phone.startsWith("+")) {
		if (phone.startsWith("0")) {
			phone = phone.substring(1, phone.length);
		}
		if (!phone.startsWith("+62")) {
			phone = "+62"+phone;
		}
	}
	if (gender == 1) {
		gender = "male";
	} else if (gender == 2) {
		gender = "female";
	}
	let fd = new FormData();
	fd.append("name", name);
	fd.append("email", email);
	fd.append("phone", phone);
	fd.append("password", password);
	fd.append("birth_place", birthPlace);
	fd.append("birthday", birthday);
	fd.append("gender", gender);
	fd.append("job", job);
	fd.append("relationship_status", relationshipStatus);
	fd.append("email_verified", emailVerified-1);
	fd.append("phone_verified", phoneVerified-1);
	fd.append("profile_completed", profileCompleted-1);
	fd.append("credits", credits);
	fd.append("premium", premium-1);
	fd.append("month_premium", monthPremium);
	fd.append("profile_picture_changed", selectedProfilePicture==null?"0":"1");
	if (selectedProfilePicture != null) {
		fd.append("file", selectedProfilePicture);
	}
	fetch(API_URL+"/admin/add_user", {
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
				alert("Email sudah digunakan oleh pengguna lain");
			} else if (responseCode == -2) {
				alert("Nomor HP sudah digunakan oleh pengguna lain");
			}
		});
}
