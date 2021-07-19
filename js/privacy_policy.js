var privacyPolicyInEditor;
var privacyPolicyEnEditor;
var privacyPolicyZhEditor;

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
	privacyPolicyInEditor = new Quill('#privacy-policy-in', {
		modules: {
			toolbar: toolbarOptions
		},
		placeholder: 'Words can be like x-rays if you use them properly...',
		theme: 'snow'
	});
	privacyPolicyEnEditor = new Quill('#privacy-policy-en', {
		modules: {
			toolbar: toolbarOptions
		},
		placeholder: 'Words can be like x-rays if you use them properly...',
		theme: 'snow'
	});
	privacyPolicyZhEditor = new Quill('#privacy-policy-zh', {
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
			privacyPolicyInEditor.clipboard.dangerouslyPasteHTML(settings['privacy_policy_in']);
			privacyPolicyEnEditor.clipboard.dangerouslyPasteHTML(settings['privacy_policy_en']);
			privacyPolicyZhEditor.clipboard.dangerouslyPasteHTML(settings['privacy_policy_zh']);
		});
});

function cancel() {
	window.location.reload();
}

function save() {
	let privacyPolicyIn = privacyPolicyInEditor.root.innerHTML;
	let privacyPolicyEn = privacyPolicyEnEditor.root.innerHTML;
	let privacyPolicyZh = privacyPolicyZhEditor.root.innerHTML;
	let fd = new FormData();
	fd.append("privacy_policy_in", privacyPolicyIn);
	fd.append("privacy_policy_en", privacyPolicyEn);
	fd.append("privacy_policy_zh", privacyPolicyZh);
	fetch(API_URL+"/admin/update_privacy_policy", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.reload();
		});
}
