var cityID = 0;

$(document).ready(function() {
	cityID = parseInt($("#city-id").val().trim());
	let fd = new FormData();
	fd.append("id", cityID);
	fetch(API_URL+"/admin/get_city_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			$("#name").val(obj['name']);
		});
});

function cancel() {
	window.history.back();
}

function save() {
	let name = $("#name").val().trim();
	if (name == "") {
		alert("Mohon masukkan nama kota");
		return;
	}
	let fd = new FormData();
	fd.append("id", cityID);
	fd.append("name", name);
	fetch(API_URL+"/admin/edit_city", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
