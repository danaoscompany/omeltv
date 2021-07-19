var cities = [];
var start = 0;
var waitTimerID = 0;

$(document).ready(function() {
	Notification.requestPermission().then(function(permission) { console.log('permission', permission)});
	$("#search-field").on('input', function() {
		clearTimeout(waitTimerID);
		waitTimerID = setTimeout(function() {
			let query = $("#search-field").val().trim();
			if (query != "") {
				let fd = new FormData();
				fd.append("city", query);
				fetch(API_URL+"/user/search_city", {
					method: 'POST',
					body: fd
				})
					.then(response => response.text())
					.then(async (response) => {
						cities = [];
						$("#cities").find("*").remove();
						cities = JSON.parse(response);
						for (let i=0; i<cities.length; i++) {
							let city = cities[i];
							$("#cities").append("<tr>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td>"+city['name']+"</td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit("+i+")'>Ubah</button></td>\n" +
								"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
								"\t\t\t\t\t\t\t\t\t</tr>");
						}
					});
			} else {
				getCities();
			}
		}, 1000);
	});
	getCities();
});

function add() {
	window.location.href = API_URL+"/city/add";
}

function getCities() {
	cities = [];
	$("#cities").find("*").remove();
	let fd = new FormData();
	fd.append("start", start);
	fd.append("length", 10);
	fetch(API_URL+"/admin/get_cities", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			cities = JSON.parse(response);
			for (let i=0; i<cities.length; i++) {
				let city = cities[i];
				$("#cities").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(start+i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+city['name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-primary mr-1\" onclick='edit("+i+")'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button type=\"button\" class=\"mb-2 btn btn-sm btn-danger mr-1\" onclick='confirmDelete("+i+")'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function goToPrevPage() {
	if (start >= 10) {
		start -= 10;
	} else if (start > 0) {
		start = 0;
	}
	getCities();
}

function goToNextPage() {
	start += 10;
	getCities();
}

function edit(index) {
	$.redirect("http://localhost/omeltv/city/edit", {
		'id': cities[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Apakah Anda yakin ingin menghapus notifikasi berikut?")) {
		let fd = new FormData();
		fd.append("id", cities[index]['id']);
		fetch(API_URL+"/admin/delete_notification", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				window.location.reload();
			});
	}
}

function addNotification() {
	window.location.href = "http://localhost/omeltv/notification/add";
}
