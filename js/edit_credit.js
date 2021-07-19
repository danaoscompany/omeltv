var creditID;

$(document).ready(function() {
	creditID = parseInt($("#credit-id").val().trim());
	let fd = new FormData();
	fd.append("id", creditID);
	fetch(API_URL+"/admin/get_credit_price_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			$("#product-id").val(obj['product_id']);
			$("#credits").val(obj['credits']);
			$("#price").val(obj['price']);
		});
});

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
	fd.append("id", creditID);
	fd.append("product_id", productID);
	fd.append("credits", credits);
	fd.append("price", price);
	fetch(API_URL+"/admin/edit_credit_price", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
