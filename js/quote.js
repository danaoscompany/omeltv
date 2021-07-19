var quotes = [];

$(document).ready(function() {
	getQuotes();
});

function getQuotes() {
	quotes = [];
	$("#prices").find("*").remove();
	fetch(API_URL+"/admin/get_quotes")
		.then(response => response.text())
		.then(async (response) => {
			quotes = JSON.parse(response);
			for (let i=0; i<quotes.length; i++) {
				let quote = quotes[i];
				let quoteText = quote['quote_in'];
				if (quoteText != null && quoteText.length > 80) {
					quoteText = quoteText.substring(0, 80)+"...";
				}
				$("#quotes").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+quote['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+quoteText+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit("+i+")'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function edit(index) {
	$.redirect(API_URL+"/quote/edit", {
		'id': quotes[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus harga berikut?")) {
		let fd = new FormData();
		fd.append("id", quotes[index]['id']);
		fetch(API_URL+"/admin/delete_quote", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}
