$(document).ready(function() {
	fetch(API_URL+"/admin/get_settings")
		.then(response => response.text())
		.then(async (response) => {
			let settings = JSON.parse(response);
			$("#free-questions-per-month").val(settings['free_questions_per_month']);
			$("#address").val(settings['address']);
			$("#ig-link").val(settings['ig_link']);
			$("#fb-link").val(settings['fb_link']);
			$("#twitter-link").val(settings['twitter_link']);
			$("#copyright").val(settings['copyright']);
			$("#youtube-video-id").val(settings['promo_video']);
		});
});

function cancel() {
	window.history.back();
}

function save() {
	let freeQuestionsPerMonth = $("#free-questions-per-month").val().trim();
	let address = $("#address").val().trim();
	let igLink = $("#ig-link").val().trim();
	let fbLink = $("#fb-link").val().trim();
	let twitterLink = $("#twitter-link").val().trim();
	let copyright = $("#copyright").val().trim();
	let youtubeVideoID = $("#youtube-video-id").val().trim();
	if (freeQuestionsPerMonth == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("free_questions_per_month", freeQuestionsPerMonth);
	fd.append("address", address);
	fd.append("ig_link", igLink);
	fd.append("fb_link", fbLink);
	fd.append("twitter_link", twitterLink);
	fd.append("copyright", copyright);
	fd.append("promo_video", youtubeVideoID);
	fetch(API_URL+"/admin/update_settings", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.reload();
		});
}
