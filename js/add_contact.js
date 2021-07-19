function save() {
	let type = $("#type").val().trim();
	let number = $("#number").val().trim();
	if (type == "" || number == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("type", type);
	fd.append("number", number);
	fetch(API_URL+"/admin/add_contact", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.href = "http://localhost/omeltv/contact";
		});
}
