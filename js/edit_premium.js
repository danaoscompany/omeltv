var id = 0;

$(document).ready(function() {
	id = parseInt($("#edited-premium-id").val().trim());
	let fd = new FormData();
	fd.append("id", id);
	fetch(API_URL+"/admin/get_premium_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			$("#product-code").val(obj['product_id']);
			$("#name-en").val(obj['name_en']);
			$("#name-id").val(obj['name_id']);
			$("#desc-en").val(obj['desc_en']);
			$("#desc-id").val(obj['desc_id']);
			$("#days").val(obj['days']);
			$("#price").val(obj['price']);
		});
});

function cancel() {
	window.history.back();
}

function save() {
	let productCode = $("#product-code").val().trim();
	let nameEn = $("#name-en").val().trim();
	let nameId = $("#name-id").val().trim();
	let descEn = $("#desc-en").val().trim();
	let descId = $("#desc-id").val().trim();
	let days = $("#days").val().trim();
	let price = $("#price").val().trim();
	if (productCode == "" || nameEn == "" || nameId == "" || descEn == "" || descId == "" || days == ""
		|| price == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("id", id);
	fd.append("product_code", productCode);
	fd.append("name_en", nameEn);
	fd.append("name_id", nameId);
	fd.append("desc_en", descEn);
	fd.append("desc_id", descId);
	fd.append("days", days);
	fd.append("price", price);
	fetch(API_URL+"/admin/update_premium", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
