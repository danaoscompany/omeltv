var contactID = 0;

$(document).ready(function() {
	contactID = parseInt($("#contact-id").val().trim());
	let fd = new FormData();
	fd.append("id", contactID);
	fetch(API_URL+"/admin/get_contact", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			$("#type").val(obj['type']);
			$("#number").val(obj['number']);
		});
});

function save() {
	let type = $("#type").val().trim();
	let number = $("#number").val().trim();
	if (type == "" || number == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("id", contactID);
	fd.append("type", type);
	fd.append("number", number);
	fetch(API_URL+"/admin/update_contact", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.href = "http://116.193.190.184/omeltv/contact";
		});
}

function cancel() {
	window.history.back();
}
