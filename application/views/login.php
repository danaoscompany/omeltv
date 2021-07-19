<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Masuk</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="http://localhost/omeltv/assets/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="http://localhost/omeltv/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="http://localhost/omeltv/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="http://localhost/omeltv/assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="http://localhost/omeltv/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="http://localhost/omeltv/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="http://localhost/omeltv/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="http://localhost/omeltv/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="http://localhost/omeltv/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="http://localhost/omeltv/assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="http://localhost/omeltv/assets/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">

					<span class="login100-form-title p-b-32">
						Masuk Akun
					</span>

					<span class="txt1 p-b-11">
						Nama Pengguna
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Email is required">
						<input id="email" class="input100" type="email" name="email" >
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Kata Sandi
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<input id="password" class="input100" type="password" name="pass" >
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-b-48">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Ingat saya
							</label>
						</div>

						<div>
							<a href="#" class="txt3">
								Lupa Kata Sandi?
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" onclick="login()">
							Masuk
						</button>
					</div>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="http://localhost/omeltv/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="http://localhost/omeltv/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="http://localhost/omeltv/vendor/bootstrap/js/popper.js"></script>
	<script src="http://localhost/omeltv/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="http://localhost/omeltv/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="http://localhost/omeltv/vendor/daterangepicker/moment.min.js"></script>
	<script src="http://localhost/omeltv/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="http://localhost/omeltv/vendor/countdowntime/countdowntime.js"></script>
	<script src="http://localhost/omeltv/js/global.js"></script>
	<script src="http://localhost/omeltv/js/login.js"></script>
<!--===============================================================================================-->
	<script src="http://localhost/omeltv/assets/js/main.js"></script>

</body>
</html>
