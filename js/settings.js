var loginHelpEn;
var loginHelpId;
var signupHelpEn;
var signupHelpId;
var aboutEn;
var aboutId;

$(document).ready(function() {
	loginHelpEn = new Quill('#login-help-en', {
		theme: 'snow'
	});
	loginHelpId = new Quill('#login-help-id', {
		theme: 'snow'
	});
	signupHelpEn = new Quill('#signup-help-en', {
		theme: 'snow'
	});
	signupHelpId = new Quill('#signup-help-id', {
		theme: 'snow'
	});
	aboutEn = new Quill('#about-en', {
		theme: 'snow'
	});
	aboutId = new Quill('#about-id', {
		theme: 'snow'
	});
	fetch(API_URL+"/admin/get_settings")
		.then(response => response.text())
		.then(async (response) => {
			let settings = JSON.parse(response);
			loginHelpEn.root.innerHTML = settings['login_help_en'];
			loginHelpId.root.innerHTML = settings['login_help_id'];
			signupHelpEn.root.innerHTML = settings['signup_help_en'];
			signupHelpId.root.innerHTML = settings['signup_help_id'];
			$("#premium-desc-en").val(settings['premium_desc_en']);
			$("#premium-desc-id").val(settings['premium_desc_id']);
			aboutEn.root.innerHTML = settings['about_en'];
			aboutId.root.innerHTML = settings['about_id'];
			$("#welcome-premium-en").val(settings['welcome_premium_en']);
			$("#welcome-premium-id").val(settings['welcome_premium_id']);
			$("#max-male-uses").val(settings['max_male_uses']);
			$("#max-female-uses").val(settings['max_female_uses']);
			$("#max-free-direct-calls").val(settings['max_free_direct_call']);
		});
});

function saveSettings() {
	let loginHelpEnText = loginHelpEn.root.innerHTML;
	let loginHelpIdText = loginHelpId.root.innerHTML;
	let signupHelpEnText = signupHelpEn.root.innerHTML;
	let signupHelpIdText = signupHelpEn.root.innerHTML;
	let premiumDescEnText = $("#premium-desc-en").val().trim();
	let premiumDescIdText = $("#premium-desc-id").val().trim();
	let aboutEnText = aboutEn.root.innerHTML;
	let aboutIdText = aboutId.root.innerHTML;
	let welcomePremiumEnText = $("#welcome-premium-en").val().trim();
	let welcomePremiumIdText = $("#welcome-premium-id").val().trim();
	let maxMaleUses = $("#max-male-uses").val().trim();
	let maxFemaleUses = $("#max-female-uses").val().trim();
	let maxFreeDirectCalls = $("#max-free-direct-calls").val().trim();
	let fd = new FormData();
	fd.append("login_help_en", loginHelpEnText);
	fd.append("login_help_id", loginHelpIdText);
	fd.append("signup_help_en", signupHelpEnText);
	fd.append("signup_help_id", signupHelpIdText);
	fd.append("premium_desc_en", premiumDescEnText);
	fd.append("premium_desc_id", premiumDescIdText);
	fd.append("about_en", aboutEnText);
	fd.append("about_id", aboutIdText);
	fd.append("welcome_premium_en", welcomePremiumEnText);
	fd.append("welcome_premium_id", welcomePremiumIdText);
	fd.append("max_male_uses", maxMaleUses);
	fd.append("max_female_uses", maxFemaleUses);
	fd.append("max_free_direct_call", maxFreeDirectCalls);
	fetch(API_URL+"/admin/update_settings", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.reload();
		});
}
