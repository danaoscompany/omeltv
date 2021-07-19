<?php
?>
<nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
	<form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
		<div class="input-group input-group-seamless ml-3">
			<div class="input-group-prepend">
				<div class="input-group-text">
					<i class="fas fa-search"></i>
				</div>
			</div>
			<input id="search-field" class="navbar-search form-control" type="text" placeholder="Cari..." aria-label="Search"> </div>
	</form>
	<ul class="navbar-nav border-left flex-row ">
		<li class="nav-item border-right dropdown notifications">
			<a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<div class="nav-link-icon__wrapper">
					<i class="material-icons">&#xE7F4;</i>
					<span id="tray-notification-count" class="badge badge-pill badge-danger">0</span>
				</div>
			</a>
			<div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
				<div id="tray-notifications"></div>
				<!--<a class="dropdown-item" href="#">
					<div class="notification__icon-wrapper">
						<div class="notification__icon">
							<i class="material-icons">help</i>
						</div>
					</div>
					<div class="notification__content">
						<span class="notification__category">Sales</span>
						<p>Last week your store’s sales count decreased by
							<span class="text-danger text-semibold">5.52%</span>. It could have been worse!</p>
					</div>
				</a>-->
				<a class="dropdown-item notification__all text-center" href="#"> Lihat semua Notifikasi </a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				<img class="user-avatar rounded-circle mr-2" src="assets/images/profile_picture_placeholder.png" alt="User Avatar">
				<span class="d-none d-md-inline-block"><?php echo $this->session->name; ?></span>
			</a>
			<div class="dropdown-menu dropdown-menu-small">
				<a class="dropdown-item" href="user-profile-lite.html">
					<i class="material-icons">&#xE7FD;</i> Profil</a>
				<a class="dropdown-item" href="components-blog-posts.html">
					<i class="material-icons">settings</i> Pengaturan</a>
				<a class="dropdown-item text-danger" href="javascript:logout()">
					<i class="material-icons text-danger">&#xE879;</i> Logout </a>
			</div>
		</li>
	</ul>
	<nav class="nav">
		<a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
			<i class="material-icons">&#xE5D2;</i>
		</a>
	</nav>
</nav>
