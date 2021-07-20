var topics = [];

$(document).ready(function() {
	getTopics();
});

function getTopics() {
	topics = [];
	$("#premiums").find("*").remove();
	fetch(API_URL+"/admin/get_topics")
		.then(response => response.text())
		.then(async (response) => {
			topics = JSON.parse(response);
			for (let i=0; i<topics.length; i++) {
				let topic = topics[i];
				$("#topics").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+topic['topic']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+moment(topic['date'], 'YYYY-MM-DD HH:mm:ss').format('D MMMM YYYY HH:mm:ss')+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit("+i+")'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function getReasons(reasonIDs) {
	let reasonText = "";
	for (let i=0; i<reasonIDs.length; i++) {
		if (reasonIDs[i] == 1) {
			reasonText += "Ketelanjangan, ";
		} else if (reasonIDs[i] == 2) {
			reasonText += "Perilaku Tidak Pantas, ";
		} else if (reasonIDs[i] == 3) {
			reasonText += "Gender Tidak Sama, ";
		} else if (reasonIDs[i] == 4) {
			reasonText += "Blokir Pengguna Ini, ";
		}
	}
	if (reasonText.length > 0) {
		reasonText = reasonText.substring(0, reasonText.length-2);
	}
	return reasonText;
}

function edit(index) {
	$.redirect(API_URL+"/topic/edit", {
		'id': topics[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus topik berikut?")) {
		let fd = new FormData();
		fd.append("id", topics[index]['id']);
		fetch(API_URL+"/admin/delete_topic", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}

function add() {
	window.location.href = 'http://116.193.190.184/omeltv/topic/add';
}
