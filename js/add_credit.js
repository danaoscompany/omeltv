function cancel() {
	window.history.back();
}

function save() {
	let productID = $("#product-id").val().trim();
	let credits = $("#credits").val().trim();
	let price = $("#price").val().trim();
	if (productID == "" || credits == "" || price == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("product_id", productID);
	fd.append("credits", credits);
	fd.append("price", price);
	fetch(API_URL+"/admin/add_credit_price", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
