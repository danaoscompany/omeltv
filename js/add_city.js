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
	fd.append("name", name);
	fetch(API_URL+"/admin/add_city", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
