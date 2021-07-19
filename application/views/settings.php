<?php
?>
<!doctype html>
<html class="no-js h-100" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Premium</title>
	<meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="assets/css/all.css" rel="stylesheet">
	<link href="assets/css/icon.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="assets/css/shards-dashboards.1.1.0.min.css">
	<link rel="stylesheet" href="assets/css/extras.1.1.0.min.css">
	<link href="assets/css/quill.snow.css" rel="stylesheet">
	<script async defer src="assets/js/buttons.js"></script>
</head>
<body class="h-100">
<div class="container-fluid">
	<div class="row">
		<!-- Main Sidebar -->
		<aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
			<div class="main-navbar">
				<nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
					<a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
						<div class="d-table m-auto">
							<img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="assets/images/shards-dashboards-logo.svg" alt="Shards Dashboard">
							<span class="d-none d-md-inline ml-1">OmelTV</span>
						</div>
					</a>
					<a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
						<i class="material-icons">&#xE5C4;</i>
					</a>
				</nav>
			</div>
			<form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
				<div class="input-group input-group-seamless ml-3">
					<div class="input-group-prepend">
						<div class="input-group-text">
							<i class="fas fa-search"></i>
						</div>
					</div>
					<input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search"> </div>
			</form>
			<?php $this->load->view('sidebar', array('current_menu' => 'settings')); ?>
		</aside>
		<!-- End Main Sidebar -->
		<main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
			<div class="main-navbar sticky-top bg-white">
				<!-- Main Navbar -->
				<?php $this->load->view('top-bar'); ?>
			</div>
			<!-- / .main-navbar -->
			<div class="main-content-container container-fluid px-4">
				<!-- Page Header -->
				<div class="page-header row no-gutters py-4">
					<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
						<span class="text-uppercase page-subtitle">Premium</span>
						<h3 class="page-title">Premium</h3>

					</div>
				</div>
				<!-- End Page Header -->
				<div class="row">
					<div class="col">
						<div style="width: 100%; display: flex; flex-direction: row; align-items: center; justify-content: flex-end;">
						</div>
						<div class="card card-small mb-4" style="margin-top: 8px;">
							<div class="card-header border-bottom">
								<h6 class="m-0">Pengaturan</h6>
							</div>
							<div class="card-body">
								<span>Bantuan login (English):</span>
								<div id="login-help-en" style="height: 200px;"></div>
								<span>Bantuan login (Bahasa Indonesia):</span>
								<div id="login-help-id" style="height: 200px;"></div>
								<span>Bantuan daftar (English):</span>
								<div id="signup-help-en" style="height: 200px;"></div>
								<span>Bantuan daftar (Bahasa Indonesia):</span>
								<div id="signup-help-id" style="height: 200px;"></div>
								<span>Deskripsi Premium (English):</span>
								<div id="premium-desc-en" style="height: 200px;"></div>
								<span>Deskripsi Premium (Bahasa Indonesia):</span>
								<div id="premium-desc-id" style="height: 200px;"></div>
								<span>Tentang (English):</span>
								<div id="about-en" style="height: 200px;"></div>
								<span>Tentang (Bahasa Indonesia):</span>
								<div id="about-id" style="height: 200px;"></div>
								<span>Pengantar Premium (English):</span>
								<div id="welcome-premium-en" style="height: 200px;"></div>
								<span>Pengantar Premium (Bahasa Indonesia):</span>
								<div id="welcome-premium-id" style="height: 200px;"></div>
								<span>Maksimum pilih gender laki-laki:</span>
								<input type="number" class="form-control" id="max-male-uses"
									   placeholder="Maksimum penggunaan gender laki-laki">
								<span>Maksimum pilih gender perempuan:</span>
								<input type="number" class="form-control" id="max-female-uses"
									   placeholder="Maksimum penggunaan gender perempuan">
								<span>Maksimum telepon direct gratis:</span>
								<input type="number" class="form-control" id="max-free-direct-calls"
									   placeholder="Maksimum telepon direct gratis">
								<button type="button" class="mb-2 btn btn-sm btn-primary mr-1" onclick='saveSettings()' style="width: 100%; margin-top: 16px;">Simpan</button>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
</div>
<script src="assets/js/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="assets/js/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="assets/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="assets/js/Chart.min.js"></script>
<script src="assets/js/shards.min.js"></script>
<script src="assets/js/jquery.sharrre.min.js"></script>
<script src="assets/js/jquery.redirect.js"></script>
<script src="assets/js/extras.1.1.0.min.js"></script>
<script src="assets/js/shards-dashboards.1.1.0.min.js"></script>
<script src="assets/js/app/app-blog-overview.1.1.0.js"></script>
<script src="assets/js/moment.js"></script>
<script src="js/global.js"></script>
<script src="js/quill.js"></script>
<script src="js/settings.js"></script>
</body>
</html>
