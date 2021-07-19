var quoteID;

$(document).ready(function() {
	quoteID = parseInt($("#edited-quote-id").val().trim());
	let fd = new FormData();
	fd.append("id", quoteID);
	fetch(API_URL+"/admin/get_quote_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			$("#name").val(obj['name']);
			$("#quote-id").val(obj['quote_in']);
			$("#quote-en").val(obj['quote_en']);
			$("#quote-zh").val(obj['quote_zh']);
		});
});

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
	fd.append("id", quoteID);
	fd.append("name", name);
	fd.append("quote_in", quoteId);
	fd.append("quote_en", quoteEn);
	fd.append("quote_zh", quoteZh);
	fd.append("date", moment(new Date()).format('YYYY-MM-DD HH:mm:ss'));
	fetch(API_URL+"/admin/edit_quote", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
