var prices = [];

$(document).ready(function() {
	getPrices();
});

function getPrices() {
	prices = [];
	$("#prices").find("*").remove();
	fetch(API_URL+"/admin/get_credit_prices")
		.then(response => response.text())
		.then(async (response) => {
			prices = JSON.parse(response);
			for (let i=0; i<prices.length; i++) {
				let price = prices[i];
				$("#prices").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+price['product_id']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+price['credits']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>Rp"+formatMoney(parseInt(price['price']))+",-	</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit("+i+")'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function edit(index) {
	$.redirect(API_URL+"/credit/edit", {
		'id': prices[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus harga berikut?")) {
		let fd = new FormData();
		fd.append("id", prices[index]['id']);
		fetch(API_URL+"/admin/delete_credit_price", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}
