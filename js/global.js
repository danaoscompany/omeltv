const PROTOCOL = "http";
const HOST = "localhost/omeltv";
const API_URL = PROTOCOL+"://"+HOST;
const USERDATA_URL = PROTOCOL+"://"+HOST+"/userdata/";

$(document).ready(function() {
	getTrayNotifications();
});

function getTrayNotifications() {
	console.log("GETTING TRAY NOTIFICATIONS...");
	$("#tray-notifications").find("*").remove();
	fetch(API_URL+"/admin/get_notifications")
		.then(response => response.text())
		.then(async (response) => {
			let notifications = JSON.parse(response);
			$("#tray-notification-count").html(""+notifications.length);
			for (let i=0; i<notifications.length; i++) {
				let notification = notifications[i];
				let icon = "";
				let title = "";
				if (notification['type'] == 'question') {
					icon = 'help';
					title = "Pertanyaan";
				}
				$("#tray-notifications").append("<a class=\"dropdown-item\" href=\"#\">\n" +
					"\t\t\t\t\t\t\t\t\t<div class=\"notification__icon-wrapper\">\n" +
					"\t\t\t\t\t\t\t\t\t\t<div class=\"notification__icon\">\n" +
					"\t\t\t\t\t\t\t\t\t\t\t<i class=\"material-icons\">"+icon+"</i>\n" +
					"\t\t\t\t\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t\t\t\t<div class=\"notification__content\">\n" +
					"\t\t\t\t\t\t\t\t\t\t<span class=\"notification__category\">"+title+"</span>\n" +
					"\t\t\t\t\t\t\t\t\t\t<p>"+notification['content']+"</p>\n" +
					"\t\t\t\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t\t\t</a>");
			}
		});
}

function logout() {
	$.redirect('http://localhost/omeltv/logout');
}

function formatMoney(amount) {
	return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}
