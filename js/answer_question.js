var questionID = 0;

$(document).ready(function() {
	questionID = parseInt($("#question-id").val().trim());
	let fd = new FormData();
	fd.append("id", questionID);
	fetch(API_URL+"/admin/get_question_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let question = JSON.parse(response);
			$("#question").val(question['question']);
			$("#answer").val(question['answer']);
		});
});

function cancel() {
	window.history.back();
}

function answer() {
	let answer = $("#answer").val();
	if (answer.trim() == "") {
		alert("Mohon masukkan jawaban");
		return;
	}
	let fd = new FormData();
	fd.append("id", questionID);
	fd.append("answer", answer);
	fetch(API_URL+"/admin/answer_question", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
