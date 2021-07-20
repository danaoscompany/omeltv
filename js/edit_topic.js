var id = 0;

$(document).ready(function() {
	id = parseInt($("#edited-topic-id").val().trim());
	let fd = new FormData();
	fd.append("id", id);
	fetch(API_URL+"/admin/get_topic_by_id", {
		method: 'POST',
		body: fd
	})
		.then(resp => resp.text())
		.then(async (response) => {
			let topic = JSON.parse(response);
			$("#topic").val(topic['topic']);
		});
});

function save() {
	let topic = $("#topic").val().trim();
	if (topic == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("id", id);
	fd.append("topic", topic);
	fd.append("date", moment(new Date()).format('YYYY-MM-DD HH:mm:ss'));
	fetch(API_URL+"/admin/update_topic", {
		method: 'POST',
		body: fd
	})
		.then(resp => resp.text())
		.then(async (response) => {
			window.location.href = "http://116.193.190.184/omeltv/topic";
		});
}
