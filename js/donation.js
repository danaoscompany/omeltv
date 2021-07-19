var donations = [];

$(document).ready(function() {
	fetch(API_URL+"/admin/get_donations")
		.then(response => response.text())
		.then(async (response) => {
			donations = JSON.parse(response);
			for (let i=0; i<donations.length; i++) {
				let donation = donations[i];
				$("#donations").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+donation['bank'].toUpperCase()+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+donation['account_number']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+donation['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit("+i+")'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
});

function add() {
	window.location.href = "http://localhost/omeltv/donation/add";
}

function edit(index) {
	$.redirect(API_URL+"/donation/edit", {
		'id': donations[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus rekening donasi berikut?")) {
		let fd = new FormData();
		fd.append("id", donations[index]['id']);
		fetch(API_URL+"/admin/delete_donation", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}
