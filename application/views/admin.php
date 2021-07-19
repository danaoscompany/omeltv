<?php
?>
<!doctype html>
<html class="no-js h-100" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Admin</title>
	<meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="assets/css/all.css" rel="stylesheet">
	<link href="assets/css/icon.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="assets/css/shards-dashboards.1.1.0.min.css">
	<link rel="stylesheet" href="assets/css/extras.1.1.0.min.css">
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
							<span class="d-none d-md-inline ml-1">Terawang</span>
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
			<?php $this->load->view('sidebar', array('current_menu' => 'admin')); ?>
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
						<span class="text-uppercase page-subtitle">Admin</span>
						<h3 class="page-title">Admin</h3>

					</div>
				</div>
				<!-- End Page Header -->
				<div class="row">
					<div class="col">
						<div style="width: 100%; display: flex; flex-direction: row; align-items: center; justify-content: flex-end;">
							<button type="button" class="mb-2 btn btn-sm btn-primary mr-1" style=""
									onclick="add()">Tambah</button>
						</div>
						<div class="card card-small mb-4" style="margin-top: 8px;">
							<div class="card-header border-bottom">
								<h6 class="m-0">Admin</h6>
							</div>
							<div class="card-body p-0 pb-3 text-center">
								<table class="table mb-0">
									<thead class="bg-light">
									<tr>
										<th scope="col" class="border-0">#</th>
										<th scope="col" class="border-0">Foto</th>
										<th scope="col" class="border-0">Nama</th>
										<th scope="col" class="border-0">Email</th>
										<th scope="col" class="border-0">Password</th>
										<th scope="col" class="border-0">Ubah</th>
										<th scope="col" class="border-0">Hapus</th>
									</tr>
									</thead>
									<tbody id="admins">
									<!--<tr>
										<td>1</td>
										<td>Ali</td>
										<td>Kerry</td>
										<td>Edit</td>
										<td>Hapus</td>
									</tr>-->
									</tbody>
								</table>
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
<script src="js/admin.js"></script>
</body>
</html>
