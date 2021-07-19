var notifications = [];

$(document).ready(function() {
	Notification.requestPermission().then(function(permission) { console.log('permission', permission)});
	getNotifications();
});

function getNotifications() {
	notifications = [];
	$("#notifications").find("*").remove();
	fetch(API_URL+"/notification/get")
		.then(response => response.text())
		.then(async (response) => {
			notifications = JSON.parse(response);
			for (let i=0; i<notifications.length; i++) {
				let notification = notifications[i];
				let content = notification['content'];
				if (content.length > 30) {
					content = content.substr(0, 30)+"...";
				}
				$("#notifications").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+notification['admin']['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+content+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='editNotification("+i+")'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDeleteNotification("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function editNotification(index) {
	$.redirect("http://116.193.190.184/omeltv/notification/edit", {
		'id': notifications[index]['id']
	});
}

function confirmDeleteNotification(index) {
	if (confirm("Apakah Anda yakin ingin menghapus notifikasi berikut?")) {
		let fd = new FormData();
		fd.append("id", notifications[index]['id']);
		fetch(API_URL+"/admin/delete_notification", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}

function addNotification() {
	window.location.href = "http://116.193.190.184/omeltv/notification/add";
}
