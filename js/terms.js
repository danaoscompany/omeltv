var termsInEditor;
var termsEnEditor;
var termsZhEditor;

$(document).ready(function () {
	var toolbarOptions = [
		[{ 'header': [1, 2, 3, 4, 5, false] }],
		['bold', 'italic', 'underline', 'strike'],        // toggled buttons
		['blockquote', 'code-block'],
		[{ 'header': 1 }, { 'header': 2 }],               // custom button values
		[{ 'list': 'ordered'}, { 'list': 'bullet' }],
		[{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
		[{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent                                       // remove formatting button
	];
	termsInEditor = new Quill('#terms-in', {
		modules: {
			toolbar: toolbarOptions
		},
		placeholder: 'Words can be like x-rays if you use them properly...',
		theme: 'snow'
	});
	termsEnEditor = new Quill('#terms-en', {
		modules: {
			toolbar: toolbarOptions
		},
		placeholder: 'Words can be like x-rays if you use them properly...',
		theme: 'snow'
	});
	termsZhEditor = new Quill('#terms-zh', {
		modules: {
			toolbar: toolbarOptions
		},
		placeholder: 'Words can be like x-rays if you use them properly...',
		theme: 'snow'
	});
	fetch(API_URL+"/admin/get_settings")
		.then(response => response.text())
		.then(async (response) => {
			let settings = JSON.parse(response);
			termsInEditor.clipboard.dangerouslyPasteHTML(settings['terms_in']);
			termsEnEditor.clipboard.dangerouslyPasteHTML(settings['terms_en']);
			termsZhEditor.clipboard.dangerouslyPasteHTML(settings['terms_zh']);
		});
});

function cancel() {
	window.location.reload();
}

function save() {
	let termsIn = termsInEditor.root.innerHTML;
	let termsEn = termsEnEditor.root.innerHTML;
	let termsZh = termsZhEditor.root.innerHTML;
	let fd = new FormData();
	fd.append("terms_in", termsIn);
	fd.append("terms_en", termsEn);
	fd.append("terms_zh", termsZh);
	fetch(API_URL+"/admin/update_terms", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.reload();
		});
}
