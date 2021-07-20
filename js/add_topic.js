function save() {
	let topic = $("#topic").val().trim();
	if (topic == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("topic", topic);
	fd.append("date", moment(new Date()).format('YYYY-MM-DD HH:mm:ss'));
	fetch(API_URL+"/admin/add_topic", {
		method: 'POST',
		body: fd
	})
		.then(resp => resp.text())
		.then(async (response) => {
			window.location.href = "http://116.193.190.184/omeltv/topic";
		});
}
