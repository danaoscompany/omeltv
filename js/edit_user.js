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
			$("#password").val(obj['password']);
			$("#birth_place").val(obj['birth_place']);
			$("#birthday").val(obj['birthday']);
			$("#gender").prop('selectedIndex', obj['gender']=='male'?1:2);
			let job = obj['job'];
			if (job == "Ibu Rumah Tangga") {
				$("#job").prop('selectedIndex', 1);
			} else if (job == "Tidak Bekerja") {
				$("#job").prop('selectedIndex', 2);
			} else if (job == "Sedang Mencari Pekerjaan") {
				$("#job").prop('selectedIndex', 3);
			} else if (job == "Pelajar") {
				$("#job").prop('selectedIndex', 4);
			} else if (job == "Akademisi") {
				$("#job").prop('selectedIndex', 5);
			} else if (job == "Wiraswasta") {
				$("#job").prop('selectedIndex', 6);
			} else if (job == "Sektor Publik") {
				$("#job").prop('selectedIndex', 7);
			} else if (job == "Swasta") {
				$("#job").prop('selectedIndex', 8);
			} else if (job == "Pensiun") {
				$("#job").prop('selectedIndex', 9);
			}
			let relationshipStatus = obj['relationship_status'];
			if (relationshipStatus == "Platonis") {
				$("#relationship-status").prop('selectedIndex', 1);
			} else if (relationshipStatus == "Rumit") {
				$("#relationship-status").prop('selectedIndex', 2);
			} else if (relationshipStatus == "Menggoda") {
				$("#relationship-status").prop('selectedIndex', 3);
			} else if (relationshipStatus == "Dalam Sebuah Hubungan") {
				$("#relationship-status").prop('selectedIndex', 4);
			} else if (relationshipStatus == "Baru Saja Putus") {
				$("#relationship-status").prop('selectedIndex', 5);
			} else if (relationshipStatus == "Bertunangan") {
				$("#relationship-status").prop('selectedIndex', 6);
			} else if (relationshipStatus == "Sudah Menikah") {
				$("#relationship-status").prop('selectedIndex', 7);
			} else if (relationshipStatus == "Janda") {
				$("#relationship-status").prop('selectedIndex', 8);
			} else if (relationshipStatus == "Bercerai") {
				$("#relationship-status").prop('selectedIndex', 9);
			} else if (relationshipStatus == "Hidup Terpisah") {
				$("#relationship-status").prop('selectedIndex', 10);
			}
			$("#email-verified").prop('selectedIndex', parseInt(obj['email_verified'])+1);
			$("#phone-verified").prop('selectedIndex', parseInt(obj['phone_verified'])+1);
			$("#profile-completed").prop('selectedIndex', parseInt(obj['profile_completed'])+1);
			$("#credits").val(parseInt(obj['credits']));
			$("#premium").prop('selectedIndex', parseInt(obj['premium'])+1);
			$("#month-premium").val(parseInt(obj['premium_months']));
			$("#last-premium-date").val(obj['last_premium_date']);
			let profilePicture = obj['profile_picture'];
			if (profilePicture != null && profilePicture.trim() != "") {
				$("#profile-picture").attr("src", USERDATA_URL+profilePicture);
			}
			/* FOR TEST ONLY */
			/*$("#name").val(obj['name']+"2");
			$("#email").val(obj['email']+"2");
			$("#phone").val(obj['phone']+"2");
			$("#password").val(obj['password']+"2");
			$("#birth_place").val(obj['birth_place']+"2");
			$("#birthday").val(obj['birthday']);
			$("#gender").prop('selectedIndex', obj['gender']=='male'?1:2);
			job = obj['job'];
			if (job == "Ibu Rumah Tangga") {
				$("#job").prop('selectedIndex', 1);
			} else if (job == "Tidak Bekerja") {
				$("#job").prop('selectedIndex', 2);
			} else if (job == "Sedang Mencari Pekerjaan") {
				$("#job").prop('selectedIndex', 3);
			} else if (job == "Pelajar") {
				$("#job").prop('selectedIndex', 4);
			} else if (job == "Akademisi") {
				$("#job").prop('selectedIndex', 5);
			} else if (job == "Wiraswasta") {
				$("#job").prop('selectedIndex', 6);
			} else if (job == "Sektor Publik") {
				$("#job").prop('selectedIndex', 7);
			} else if (job == "Swasta") {
				$("#job").prop('selectedIndex', 8);
			} else if (job == "Pensiun") {
				$("#job").prop('selectedIndex', 9);
			}
			relationshipStatus = obj['relationship_status'];
			if (relationshipStatus == "Single") {
				$("#relationship-status").prop('selectedIndex', 1);
			} else if (relationshipStatus == "Platonis") {
				$("#relationship-status").prop('selectedIndex', 2);
			} else if (relationshipStatus == "Rumit") {
				$("#relationship-status").prop('selectedIndex', 3);
			} else if (relationshipStatus == "Menggoda") {
				$("#relationship-status").prop('selectedIndex', 4);
			} else if (relationshipStatus == "Dalam Sebuah Hubungan") {
				$("#relationship-status").prop('selectedIndex', 5);
			} else if (relationshipStatus == "Baru Saja Putus") {
				$("#relationship-status").prop('selectedIndex', 6);
			} else if (relationshipStatus == "Bertunangan") {
				$("#relationship-status").prop('selectedIndex', 7);
			} else if (relationshipStatus == "Sudah Menikah") {
				$("#relationship-status").prop('selectedIndex', 8);
			} else if (relationshipStatus == "Janda") {
				$("#relationship-status").prop('selectedIndex', 9);
			} else if (relationshipStatus == "Bercerai") {
				$("#relationship-status").prop('selectedIndex', 10);
			} else if (relationshipStatus == "Hidup Terpisah") {
				$("#relationship-status").prop('selectedIndex', 11);
			}
			$("#email-verified").prop('selectedIndex', parseInt(obj['email_verified'])+1);
			$("#phone-verified").prop('selectedIndex', parseInt(obj['phone_verified'])+1);
			$("#profile-completed").prop('selectedIndex', parseInt(obj['profile_completed'])+1);
			$("#credits").val(parseInt(obj['credits']));
			$("#premium").prop('selectedIndex', parseInt(obj['premium'])+1);
			$("#month-premium").val(parseInt(obj['premium_months']));
			$("#last-premium-date").val(moment(obj['last_premium_purchase'], 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD'));*/
			/* */
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
	fd.append("id", editedUserID);
	fd.append("name", name);
	fd.append("email", email);
	fd.append("email_changed", (email==prevEmail)?"0":"1");
	fd.append("phone", phone);
	fd.append("phone_changed", (phone==prevPhone)?"0":"1");
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
