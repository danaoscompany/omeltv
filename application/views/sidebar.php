<?php
?>
<div class="nav-wrapper">
	<ul class="nav flex-column">
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'activity')?'nav-link active':'nav-link' ?>" href="http://localhost/omeltv/activity">
				<i class="material-icons">history</i>
				<span>Aktivitas</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'admin')?'nav-link active':'nav-link' ?>" href="http://localhost/omeltv/admin">
				<i class="material-icons">admin_panel_settings</i>
				<span>Admin</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'logout')?'nav-link active':'nav-link' ?>" href="http://localhost/omeltv/logout">
				<i class="material-icons">logout</i>
				<span>Keluar</span>
			</a>
		</li>
	</ul>
</div>
