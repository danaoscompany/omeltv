function cancel() {
	window.history.back();
}

function save() {
	let productID = $("#product-id").val().trim();
	let month = $("#month").val().trim();
	let price = $("#price").val().trim();
	let benefitsId = $("#benefits-id").val().trim();
	let benefitsEn = $("#benefits-en").val().trim();
	let benefitsZh = $("#benefits-zh").val().trim();
	if (productID == "" || month == "" || price == "" || benefitsId == "" || benefitsEn == "" || benefitsZh == "") {
		alert("Mohon lengkapi data");
		return;
	}
	{
		let benefitsJSON = [];
		let benefitsTexts = benefitsId.split(",");
		for (let i=0; i<benefitsTexts.length; i++) {
			benefitsJSON.push(benefitsTexts[i].trim());
		}
		benefitsId = JSON.stringify(benefitsJSON);
	}
	{
		let benefitsJSON = [];
		let benefitsTexts = benefitsEn.split(",");
		for (let i=0; i<benefitsTexts.length; i++) {
			benefitsJSON.push(benefitsTexts[i].trim());
		}
		benefitsEn = JSON.stringify(benefitsJSON);
	}
	{
		let benefitsJSON = [];
		let benefitsTexts = benefitsZh.split(",");
		for (let i=0; i<benefitsTexts.length; i++) {
			benefitsJSON.push(benefitsTexts[i].trim());
		}
		benefitsZh = JSON.stringify(benefitsJSON);
	}
	let fd = new FormData();
	fd.append("product_id", productID);
	fd.append("month", month);
	fd.append("price", price);
	fd.append("benefits_id", benefitsId);
	fd.append("benefits_en", benefitsEn);
	fd.append("benefits_zh", benefitsZh);
	fetch(API_URL+"/admin/add_premium_price", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
