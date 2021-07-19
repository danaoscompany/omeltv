$(document).ready(function() {
});

function cancel() {
	if (confirm("Apakah Anda yakin ingin membuang konten yang Anda buat?")) {
		window.location.href = "http://localhost/omeltv/notification";
	}
}

function save() {
	let content = $("#content").val();
	if (content.trim() == "") {
		alert("Mohon masukkan isi konten");
		return;
	}
	let fd = new FormData();
	fd.append("user_id", localStorage.getItem("user_id"));
	fd.append("content", content);
	fd.append("date", moment(new Date()).format('YYYY-MM-DD HH:mm:ss'));
	fetch(API_URL+"/admin/add_notification", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.href = "http://localhost/omeltv/notification";
		});
}
