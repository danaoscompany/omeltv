var questions = [];

$(document).ready(function() {
	$('#search-field').keypress(function (e) {
		if (e.which == 13) {
			let keyword = $("#search-field").val().trim();
			if (keyword == "") {
				getQuestions();
			} else {
				questions = [];
				$("#questions").find("*").remove();
				let fd = new FormData();
				fd.append("keyword", keyword);
				fetch(API_URL+"/admin/search_questions", {
					method: 'POST',
					body: fd
				})
					.then(response => response.text())
					.then(async (response) => {
						questions = JSON.parse(response);
						for (let i=0; i<questions.length; i++) {
							let question = questions[i];
							let answered = parseInt(question['answered']);
							$("#questions").append("<tr>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>"+question['user']['name']+"</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>"+question['question']+"</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td><span style='color: "+(answered==0?"#e74c3c":"#2ecc71")+"; font-weight: bold;'>"+(answered==0?"Belum":"Dijawab")+"</span></td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>"+question['rating']+"</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>"+moment(question['date'], 'YYYY-MM-DD HH:mm:ss').format('D MMMM YYYY HH:mm:ss')+"</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='answer("+i+")'>Jawab</button></td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
								"\t\t\t\t\t\t\t\t\t</tr>");
						}
					});
			}
			return false;
		}
	});
	getQuestions();
});

function getQuestions() {
	questions = [];
	$("#questions").find("*").remove();
	fetch(API_URL+"/admin/get_questions")
		.then(response => response.text())
		.then(async (response) => {
			questions = JSON.parse(response);
			for (let i=0; i<questions.length; i++) {
				let question = questions[i];
				let answered = parseInt(question['answered']);
				$("#questions").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+question['user']['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+question['question']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><span style='color: "+(answered==0?"#e74c3c":"#2ecc71")+"; font-weight: bold;'>"+(answered==0?"Belum":"Dijawab")+"</span></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+question['rating']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+moment(question['date'], 'YYYY-MM-DD HH:mm:ss').format('D MMMM YYYY HH:mm:ss')+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='answer("+i+")'>Jawab</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function answer(index) {
	$.redirect(API_URL+"/question/answer", {
		'id': questions[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus pertanyaan berikut?")) {
		let fd = new FormData();
		fd.append("id", questions[index]['id']);
		fetch(API_URL+"/admin/delete_question", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}
