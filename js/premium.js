var premiums = [];

$(document).ready(function() {
	getPremiums();
});

function getPremiums() {
	premiums = [];
	$("#premiums").find("*").remove();
	fetch(API_URL+"/admin/get_premium_prices")
		.then(response => response.text())
		.then(async (response) => {
			premiums = JSON.parse(response);
			for (let i=0; i<premiums.length; i++) {
				let premium = premiums[i];
				$("#premiums").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+premium['product_id']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+premium['name_id']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+premium['desc_id']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+premium['days']+" Hari</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>Rp"+premium['price']+",-</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit("+i+")'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function edit(index) {
	$.redirect(API_URL+"/premium/edit", {
		'id': premiums[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus harga premium berikut?")) {
		let fd = new FormData();
		fd.append("id", premiums[index]['id']);
		fetch(API_URL+"/admin/delete_premium", {
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
	window.location.href = 'http://116.193.190.184/omeltv/premium/add';
}
