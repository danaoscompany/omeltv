var contacts = [];

$(document).ready(function() {
	getContacts();
});

function getContacts() {
	fetch(API_URL+"/admin/get_contacts")
		.then(response => response.text())
		.then(async (response) => {
			contacts = JSON.parse(response);
			for (let i=0; i<contacts.length; i++) {
				let contact = contacts[i];
				$("#contacts").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+contact['type']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+contact['number']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit("+i+")'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function add() {
	window.location.href = "http://116.193.190.184/omeltv/contact/add";
}

function edit(index) {
	$.redirect(API_URL+"/contact/edit", {
		'id': contacts[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus kontak berikut?")) {
		let fd = new FormData();
		fd.append("id", contacts[index]['id']);
		fetch(API_URL+"/admin/delete_contact", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}
