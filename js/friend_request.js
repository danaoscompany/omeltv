var friends = [];

$(document).ready(function() {
	getFriends();
});

function getFriends() {
	friends = [];
	$("#friends").find("*").remove();
	fetch(API_URL+"/admin/get_friend_requests")
		.then(response => response.text())
		.then(async (response) => {
			friends = JSON.parse(response);
			for (let i=0; i<friends.length; i++) {
				let friend = friends[i];
				$("#friends").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(friend['user']==null?'':friend['user']['name'])+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(friend['added_user']==null?'':friend['added_user']['name'])+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus pertemanan berikut?")) {
		let fd = new FormData();
		fd.append("id", friends[index]['id']);
		fetch(API_URL + "/admin/delete_friend_request", {
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
	window.location.href = "http://116.193.190.184/omeltv/admin/add";
}
