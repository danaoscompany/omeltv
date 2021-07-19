var donationID = 0;

$(document).ready(function() {
	donationID = parseInt($("#donation-id").val().trim());
	let fd = new FormData();
	fd.append("id", donationID);
	fetch(API_URL+"/admin/get_donation", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			$("#name").val(obj['name']);
			$("#bank").val(obj['bank']);
			$("#account-number").val(obj['account_number']);
		});
});

function save() {
	let name = $("#name").val().trim();
	let bank = $("#bank").prop('selectedIndex');
	let accountNumber = $("#account-number").val().trim();
	if (name == "" || bank == 0 || accountNumber == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("id", donationID);
	fd.append("name", name);
	fd.append("bank", $("#bank").val().toLowerCase());
	fd.append("account_number", accountNumber);
	fetch(API_URL+"/admin/update_donation", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.href = "http://116.193.190.184/omeltv/donation";
		});
}

function cancel() {
	window.history.back();
}
