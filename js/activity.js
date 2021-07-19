var activities = [];

$(document).ready(function() {
	getActivities();
});

function getActivities() {
	activities = [];
	$("#activities").find("*").remove();
	fetch(API_URL+"/admin/get_activities")
		.then(resp => resp.text())
		.then(async (response) => {
			activities = JSON.parse(response);
			for (let i=0; i<activities.length; i++) {
				let activity = activities[i];
				let type = "";
				if (activity['type'] == 'audio_call') {
					type = "Panggilan Audio";
				} else if (activity['type'] == 'video_call') {
					type = "Panggilan Video";
				} else if (activity['type'] == 'chat') {
					type = "Obrolan";
				}
				$("#activities").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+activity['user']['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+activity['opponent']['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+type+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+moment(activity['date'], 'YYYY-MM-DD HH:mm:ss').format('d MMMM yyyy HH:mm:ss')+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete(" + i + ")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus aktivitas berikut?")) {
		let fd = new FormData();
		fd.append("id", activities[index]['id']);
		fetch(API_URL+"/admin/delete_activity", {
			method: 'POST',
			body: fd
		})
			.then(resp => resp.text())
			.then(async (response) => {
				getActivities();
			});
	}
}
