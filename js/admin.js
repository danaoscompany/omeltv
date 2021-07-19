var admins = [];

$(document).ready(function() {
	getAdmins();
});

function getAdmins() {
	admins = [];
	$("#admins").find("*").remove();
	fetch(API_URL+"/admin/get_admins")
		.then(response => response.text())
		.then(async (response) => {
			admins = JSON.parse(response);
			for (let i=0; i<admins.length; i++) {
				let admin = admins[i];
				let profilePicture = admin['profile_picture'];
				if (profilePicture != null && profilePicture.trim() != "") {
					profilePicture = USERDATA_URL+profilePicture;
				} else {
					profilePicture = 'http://localhost/omeltv/assets/images/profile_picture_placeholder.png';
				}
				$("#admins").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><img src='"+profilePicture+"' width='40px' height='40px' style='border-radius: 20px;'>"+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+admin['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+admin['email']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+admin['password']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit("+i+")'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function edit(index) {
	$.redirect(API_URL+"/admin/edit", {
		'id': admins[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus admin berikut?")) {
		if (admins.length <= 1) {
			alert("Mohon sisakan minimal 1 admin saja");
		} else {
			let fd = new FormData();
			fd.append("id", admins[index]['id']);
			fetch(API_URL + "/admin/delete_admin", {
				method: 'POST',
				body: fd
			})
				.then(response => response.text())
				.then(async (response) => {
					window.location.reload();
				});
		}
	}
}

function add() {
	window.location.href = "http://localhost/omeltv/admin/add";
}
