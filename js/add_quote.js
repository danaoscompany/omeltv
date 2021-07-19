function cancel() {
	window.history.back();
}

function save() {
	let name = $("#name").val().trim();
	let quoteId = $("#quote-id").val().trim();
	let quoteEn = $("#quote-en").val().trim();
	let quoteZh = $("#quote-zh").val().trim();
	if (name == "" || quoteId == "" || quoteEn == "" || quoteZh == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("name", name);
	fd.append("quote_in", quoteId);
	fd.append("quote_en", quoteEn);
	fd.append("quote_zh", quoteZh);
	fd.append("date", moment(new Date()).format('YYYY-MM-DD HH:mm:ss'));
	fetch(API_URL+"/admin/add_quote", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
