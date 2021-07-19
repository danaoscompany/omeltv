<?php
?>
<div class="nav-wrapper">
	<ul class="nav flex-column">
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'activity')?'nav-link active':'nav-link' ?>" href="http://116.193.190.184/omeltv/activity">
				<i class="material-icons">history</i>
				<span>Aktivitas</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'admin')?'nav-link active':'nav-link' ?>" href="http://116.193.190.184/omeltv/admin">
				<i class="material-icons">admin_panel_settings</i>
				<span>Admin</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'user')?'nav-link active':'nav-link' ?>" href="http://116.193.190.184/omeltv/user">
				<i class="material-icons">person</i>
				<span>Pengguna</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'blocked_user')?'nav-link active':'nav-link' ?>" href="http://116.193.190.184/omeltv/blockeduser">
				<i class="material-icons">person_off</i>
				<span>Pengguna Diblokir</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'friend')?'nav-link active':'nav-link' ?>" href="http://116.193.190.184/omeltv/friend">
				<i class="material-icons">group</i>
				<span>Teman</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'friend_request')?'nav-link active':'nav-link' ?>" href="http://116.193.190.184/omeltv/friendrequest">
				<i class="material-icons">group</i>
				<span>Permintaan Pertemanan</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'premium')?'nav-link active':'nav-link' ?>" href="http://116.193.190.184/omeltv/premium">
				<i class="material-icons">local_offer</i>
				<span>Premium</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'reported_user')?'nav-link active':'nav-link' ?>" href="http://116.193.190.184/omeltv/reporteduser">
				<i class="material-icons">flag</i>
				<span>Pengguna Dilaporkan</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'settings')?'nav-link active':'nav-link' ?>" href="http://116.193.190.184/omeltv/settings">
				<i class="material-icons">settings</i>
				<span>Pengaturan</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="<?php echo ($current_menu == 'logout')?'nav-link active':'nav-link' ?>" href="http://116.193.190.184/omeltv/logout">
				<i class="material-icons">logout</i>
				<span>Keluar</span>
			</a>
		</li>
	</ul>
</div>
