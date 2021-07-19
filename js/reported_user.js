var reportedUsers = [];

$(document).ready(function() {
	getReportedUsers();
});

function getReportedUsers() {
	reportedUsers = [];
	$("#premiums").find("*").remove();
	fetch(API_URL+"/admin/get_reported_users")
		.then(response => response.text())
		.then(async (response) => {
			reportedUsers = JSON.parse(response);
			for (let i=0; i<reportedUsers.length; i++) {
				let reportedUser = reportedUsers[i];
				$("#reported-users").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+reportedUser['user']['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+reportedUser['blocked_user']['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+getReasons(reportedUser['reason'])+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+moment(reportedUser['date'], 'YYYY-MM-DD HH:mm:ss').format('D MMMM YYYY HH:mm:ss')+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmBlockUser("+i+")'>Blokir</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function getReasons(reasonIDs) {
	let reasonText = "";
	for (let i=0; i<reasonIDs.length; i++) {
		if (reasonIDs[i] == 1) {
			reasonText += "Ketelanjangan, ";
		} else if (reasonIDs[i] == 2) {
			reasonText += "Perilaku Tidak Pantas, ";
		} else if (reasonIDs[i] == 3) {
			reasonText += "Gender Tidak Sama, ";
		} else if (reasonIDs[i] == 4) {
			reasonText += "Blokir Pengguna Ini, ";
		}
	}
	if (reasonText.length > 0) {
		reasonText = reasonText.substring(0, reasonText.length-2);
	}
	return reasonText;
}

function confirmBlockUser(index) {
	if (confirm("Apakah Anda yakin ingin memblokir pengguna berikut?")) {
		let fd = new FormData();
		fd.append("user_id", reportedUsers[index]['user_id']);
		fd.append("blocked_user_id", reportedUsers[index]['blocked_user_id']);
		fd.append("date", moment(new Date()).format('YYYY-MM-DD HH:mm:ss'));
		fetch(API_URL+"/admin/block_user", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus harga premium berikut?")) {
		let fd = new FormData();
		fd.append("id", reportedUsers[index]['id']);
		fetch(API_URL+"/admin/delete_reported_user", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}

function add() {
	window.location.href = 'http://localhost/omeltv/premium/add';
}
