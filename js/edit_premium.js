var premiumID;

$(document).ready(function() {
	premiumID = parseInt($("#premium-id").val().trim());
	let fd = new FormData();
	fd.append("id", premiumID);
	fetch(API_URL+"/admin/get_premium_price_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			$("#product-id").val(obj['product_id']);
			$("#month").val(obj['month']);
			$("#price").val(obj['price']);
			{
				let benefitsEn = JSON.parse(obj['benefits_en']);
				let benefitsEnText = "";
				for (let i = 0; i < benefitsEn.length; i++) {
					benefitsEnText += benefitsEn[i];
					benefitsEnText += ", ";
				}
				if (benefitsEn.length > 0) {
					benefitsEnText = benefitsEnText.substring(0, benefitsEnText.length - 2);
				}
				$("#benefits-en").val(benefitsEnText);
			}
			{
				let benefitsId = JSON.parse(obj['benefits_id']);
				let benefitsIdText = "";
				for (let i = 0; i < benefitsId.length; i++) {
					benefitsIdText += benefitsId[i];
					benefitsIdText += ", ";
				}
				if (benefitsId.length > 0) {
					benefitsIdText = benefitsIdText.substring(0, benefitsIdText.length - 2);
				}
				$("#benefits-id").val(benefitsIdText);
			}
			{
				let benefitsZh = JSON.parse(obj['benefits_zh']);
				let benefitsZhText = "";
				for (let i = 0; i < benefitsZh.length; i++) {
					benefitsZhText += benefitsZh[i];
					benefitsZhText += ", ";
				}
				if (benefitsZh.length > 0) {
					benefitsZhText = benefitsZhText.substring(0, benefitsZhText.length - 2);
				}
				$("#benefits-zh").val(benefitsZhText);
			}
		});
});

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
	fd.append("id", premiumID);
	fd.append("product_id", productID);
	fd.append("month", month);
	fd.append("price", price);
	fd.append("benefits_id", benefitsId);
	fd.append("benefits_en", benefitsEn);
	fd.append("benefits_zh", benefitsZh);
	fetch(API_URL+"/admin/edit_premium_price", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
