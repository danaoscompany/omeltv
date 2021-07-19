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
	fd.append("product_code", productCode);
	fd.append("name_en", nameEn);
	fd.append("name_id", nameId);
	fd.append("desc_en", descEn);
	fd.append("desc_id", descId);
	fd.append("days", days);
	fd.append("price", price);
	fetch(API_URL+"/admin/add_premium", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
