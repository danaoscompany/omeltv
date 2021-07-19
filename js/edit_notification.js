var notificationID = 0;

$(document).ready(function() {
	notificationID = parseInt($("#notification-id").val().trim());
	let fd = new FormData();
	fd.append("id", notificationID);
	fetch(API_URL+"/admin/get_notification_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let notification = JSON.parse(response);
			$("#content").val(notification['content']);
		});
});

function save() {
	let content = $("#content").val();
	if (content.trim() == "") {
		alert("Mohon masukkan isi konten");
		return;
	}
	let fd = new FormData();
	fd.append("id", notificationID);
	fd.append("content", content);
	fd.append("date", moment(new Date()).format('YYYY-MM-DD HH:mm:ss'));
	fetch(API_URL+"/admin/update_notification", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.href = "http://116.193.190.184/omeltv/notification";
		});
}

function cancel() {
	window.history.back();
}
