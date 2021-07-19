var users = [];

$(document).ready(function() {
	$('#search-field').keypress(function (e) {
		if (e.which == 13) {
			let keyword = $("#search-field").val().trim();
			if (keyword == "") {
				getUsers();
			} else {
				users = [];
				$("#users").find("*").remove();
				let fd = new FormData();
				fd.append("keyword", keyword);
				fetch(API_URL + "/admin/search_users", {
					method: 'POST',
					body: fd
				})
					.then(response => response.text())
					.then(async (response) => {
						users = JSON.parse(response);
						for (let i = 0; i < users.length; i++) {
							let user = users[i];
							let profilePicture = user['profile_picture'];
							if (profilePicture != null && profilePicture.trim() != "") {
								profilePicture = USERDATA_URL + profilePicture;
							} else {
								profilePicture = 'http://localhost/omeltv/assets/images/profile_picture_placeholder.png';
							}
							$("#users").append("<tr>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>" + (i + 1) + "</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td><img src='" + profilePicture + "' width='40px' height='40px' style='border-radius: 20px;'>" + "</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>" + user['name'] + "</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>" + user['email'] + "</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>" + user['password'] + "</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit(" + i + ")'>Ubah</button></td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete(" + i + ")'>Hapus</button></td>\n" +
								"\t\t\t\t\t\t\t\t\t</tr>");
						}
					});
			}
			return false;
		}
	});
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
					profilePicture = 'http://localhost/omeltv/assets/images/profile_picture_placeholder.png';
				}
				$("#users").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><img src='"+profilePicture+"' width='40px' height='40px' style='border-radius: 20px;'>"+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+user['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+user['email']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+user['password']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit("+i+")'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function edit(index) {
	$.redirect(API_URL+"/user/edit", {
		'id': users[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus penggguna berikut?")) {
		let fd = new FormData();
		fd.append("id", users[index]['id']);
		fetch(API_URL+"/admin/delete_user", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}
