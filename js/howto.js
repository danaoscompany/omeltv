$(document).ready(function() {
	fetch(API_URL+"/admin/get_settings")
		.then(response => response.text())
		.then(async (response) => {
			let settings = JSON.parse(response);
			$("#howto-id").val(settings['howto_in']);
			$("#howto-en").val(settings['howto_en']);
			$("#howto-zh").val(settings['howto_zh']);
		});
});

function cancel() {
	window.history.back();
}

function save() {
	let howtoId = $("#howto-id").val().trim();
	let howtoEn = $("#howto-en").val().trim();
	let howtoZh = $("#howto-zh").val().trim();
	if (howtoId == "" || howtoEn == "" || howtoZh == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("howto_id", howtoId);
	fd.append("howto_en", howtoEn);
	fd.append("howto_zh", howtoZh);
	fetch(API_URL+"/admin/update_howto", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.reload();
		});
}
