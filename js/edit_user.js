var editedUserID;
var selectedProfilePicture = null;
var prevEmail = "";
var prevPhone = "";

$(document).ready(function() {
	editedUserID = parseInt($("#edited-user-id").val().trim());
	let fd = new FormData();
	fd.append("id", editedUserID);
	fetch(API_URL+"/admin/get_user_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			prevEmail = obj['email'];
			prevPhone = obj['phone'];
			$("#name").val(obj['name']);
			$("#email").val(prevEmail);
			$("#phone").val(prevPhone);
			$("#username").val(obj['username']);
			if (obj['gender'] == 'male') {
				$("#gender").prop('selectedIndex', 1);
			} else if (obj['gender'] == 'female') {
				$("#gender").prop('selectedIndex', 2);
			}
			$("#android-id").val(obj['android_id']);
			if (obj['looking_for'] == 'male') {
				$("#looking-for").prop('selectedIndex', 1);
			} else if (obj['looking_for'] == 'female') {
				$("#looking-for").prop('selectedIndex', 2);
			}
			$("#bio").val(obj['bio']);
			if (parseInt(obj['premium']) == 0) {
				$("#premium").prop('selectedIndex', 2);
			} else if (parseInt(obj['premium']) == 1) {
				$("#premium").prop('selectedIndex', 1);
			}
			$("#subscribed-product-id").val(obj['subscribed_product_id']);
			$("#premium-start").val(moment(obj['premium_start'], 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD'));
			$("#country-code").val(obj['country_code']);
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
	if (confirm("Apakah Anda yakin ingin membatalkan perubahan yang Anda buat?")) {
		window.history.back();
	}
}

function save() {
	let name = $("#name").val().trim();
	let email = $("#email").val().trim();
	let phone = $("#phone").val().trim();
	let username = $("#username").val().trim();
	let gender = $("#gender").prop('selectedIndex');
	let lookingFor = $("#looking-for").prop('selectedIndex');
	let androidID = $("#android-id").val().trim();
	let bio = $("#bio").val().trim();
	let premium = $("#premium").prop('selectedIndex');
	let subscribedProductID = $("#subscribed-product-id").val().trim();
	let premiumStart = $("#premium-start").val().trim();
	let countryCode = $("#country-code").val().trim();
	if (name == "" || email == "" || phone == "" || username == "" || androidID == "" || bio == ""
		|| subscribedProductID == "" || premiumStart == "" || countryCode == "") {
		alert("Mohon lengkapi data");
		return;
	}
	if (gender == 0 || lookingFor == 0 || premium == 0) {
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
	if (lookingFor == 1) {
		lookingFor = "male";
	} else if (lookingFor == 2) {
		lookingFor = "female";
	}
	if (premium == 1) {
		premium = 1;
	} else if (premium == 2) {
		premium = 0;
	}
	let fd = new FormData();
	fd.append("id", editedUserID);
	fd.append("name", name);
	fd.append("email", email);
	fd.append("email_changed", (email==prevEmail)?"0":"1");
	fd.append("phone", phone);
	fd.append("phone_changed", (phone==prevPhone)?"0":"1");
	fd.append("username", username);
	fd.append("gender", gender);
	fd.append("looking_for", lookingFor);
	fd.append("android_id", androidID);
	fd.append("bio", bio);
	fd.append("premium", premium);
	fd.append("subscribed_product_id", subscribedProductID);
	fd.append("premium_start", premiumStart);
	fd.append("country_code", countryCode);
	fetch(API_URL+"/admin/update_user", {
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
