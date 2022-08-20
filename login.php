	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login Kamibox | 2022</title>
		<link rel="shortcut icon" type="image/png" href="assets/icon.png">
		<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
		<link rel="stylesheet" type="text/css" href="assets/css/auth_style3.css">
		<style type="text/css">

		</style>
	</head>

	<body>
		<header>
			<?php include "navbar.php"; ?>
		</header>

		<section class="login">
			<div class="container login-wrapper">
				<div class="content-left">
					<div class="img-login">
						<img src="assets/images/design-5.png">
					</div>
				</div>
				<div class="content-right">
					<div class="card-login">
						<div class="heading-login">
							<h2 class="heading-welcome">Selamat Datang</h2>
							<p class="subheading-welcome">Masuk ke dalam akunmu</p>
						</div>

						<div class="heading-error">
							<?php
							// PESAN TRIGGER
							if (isset($_COOKIE['gagal'])) {
								echo '<p class="subheading-error-otp">' . $_COOKIE['gagal'] . '</p>';
							} elseif (isset($_COOKIE['sukses'])) {
								echo '<p class="subheading-sukses-otp">' . $_COOKIE['sukses'] . '</p>';
							}
							// ==============================

							if (isset($_GET['email'])) {
								if ($_GET['email'] == "kosong") {
									echo "<p class='subheading-error-login'>Kolom email harus diisi.</p>";
								} elseif ($_GET['email'] == "tidak_tersedia") {
									echo "<p class='subheading-error-login'>Maaf email tidak tersedia di database.</p>";
								} elseif ($_GET['email'] == "tidak_aktif") {
									echo "<p class='subheading-error-login'>Maaf status akun Anda sedang tidak aktif. Silahkan <a href='aktifkan_akun_via_otp.php'>klik disini</a> untuk mendapat bantuan.</p>";
								}
							}
							?>

						</div>

						<form action="cek_login.php" method="post">
							<div class="form-login">
								<div class="input-form">
									<i class='bx bxs-envelope icon' style="font-size: 1.5rem;"></i>
									<input class="input-field <?php if ($_GET['email'] == "kosong" || $_GET['email'] == "tidak_tersedia" || $_GET['email'] == "tidak_aktif") {
																	echo "input-field-error";
																} ?>" type="email" placeholder="isi dengan email anda" name="email" value=" <?php if ($_GET['email'] == "kosong" || $_GET['email'] == "tidak_tersedia" || $_GET['email'] == "tidak_aktif") {
																																				echo $_SESSION['set_email'];
																																			} ?> " />

								</div>
							</div>

							<div class="btn-login">
								<div class="btn">
									<div class="btn-left">
										<i class="icon-btn"></i>
										<input name="submit" class="btn-submit" type="submit" value="Masuk" />
									</div>

									<div class="btn-right">
										<i class="icon-btn"></i>
										<input class="btn-submit" name="submit" type="submit" style="text-align: center;margin-left: 20px;" value="Daftar" />
									</div>
								</div>
							</div>

						</form>

					</div>
				</div>
			</div>
		</section><br />

		<!-- lisensi decreativeart-->


		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="assets/js/main.js"></script>
	</body>

	</html>