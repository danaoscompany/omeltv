var users = [];

$(document).ready(function() {
	getUsers();
});

function getUsers() {
	users = [];
	$("#users").find("*").remove();
	fetch(API_URL+"/admin/get_users")
		.then(response => response.text())
		.then(async (response) => {
			users = JSON.parse(response);
			for (let i=0; i<users.length; i++) {
				let user = users[i];
				let profilePicture = user['profile_picture'];
				if (profilePicture != null && profilePicture.trim() != "") {
					profilePicture = USERDATA_URL+profilePicture;
				} else {
					profilePicture = 'http://116.193.190.184/omeltv/assets/images/profile_picture_placeholder.png';
				}
				$("#users").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><img src='"+profilePicture+"' width='40px' height='40px' style='border-radius: 20px;'>"+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+user['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+user['email']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function edit(index) {
	$.redirect(API_URL+"/admin/edit", {
		'id': users[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus pengguna berikut?")) {
		let fd = new FormData();
		fd.append("id", users[index]['id']);
		fetch(API_URL + "/admin/delete_user", {
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
