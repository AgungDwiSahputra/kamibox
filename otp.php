<?php
error_reporting(0);
//cek login
if ($_SESSION['login'] == true && $_SESSION['level_user'] == '1' || $_SESSION['login'] == true && $_SESSION['level_user'] == '2' || $_SESSION['login'] == true && $_SESSION['level_user'] == '3') {
	header("location:index.php");
} else {

?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Kirim OTP</title>
		<meta charset="utf-8">
		<meta name="description" contents="KAMIBOX.ID">
		<link rel="shortcut icon" type="image/png" href="assets/icon.png">
		<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
		<link rel="stylesheet" type="text/css" href="assets/css/auth_style3.css">
		<style type="text/css">
			.kodeotp-error {
				margin-left: 10px;
				margin-right: 10px;
				width: 40px;
				height: 40px;
				text-align: center;
				border: 1px solid red;
			}

			.nav-wrapper .menu-wrapper {
				display: none;
				opacity: 0;
			}

			.nav-wrapper .menu-wrapper .menu {
				display: none;
				opacity: 0;
			}

			.menu-wrapper .menu .menu-link {
				display: none;
				opacity: 0;
			}



			@media (max-width: 1000px) {
				.menu-toggle {
					display: none !important;
				}
			}

			@media screen and (max-width: 749px) {
				.btn-otp {
					display: none;
				}

				.btn-otp-viaemail {
					display: none;
				}
			}

			@media screen and (max-width: 450px) {
				.otp-wrapper {
					width: 100%;
					margin: 0;
				}

				.otp-card {
					border-radius: 0px;
				}
			}
		</style>
	</head>

	<body>
		<header>
			<?php include "navbar.php"; ?>
		</header>

		<section class="otp">
			<div class="otp-wrapper">
				<div class="otp-card">
					<h3 class="heading-otp">Verifikasi OTP</h3>
					<div class="btn-otp">
						<input type="submit" name="otp-via-email" class="btn-otp-viaemail" value="Kami telah Mengirim Kode OTP ke Email Anda">
					</div>
					<div class="heading-validasi-otp">
						<span>Masukkan kode yang kami kirim ke <span style="color:red;">Email </span> anda</span>
						<?php
						if (isset($_COOKIE['gagal'])) {
							echo '<span class="subheading-error-otp">' . $_COOKIE['gagal'] . '</span>';
						} elseif (isset($_COOKIE['sukses'])) {
							echo '<span class="subheading-sukses-otp">' . $_COOKIE['sukses'] . '</span>';
						}
						?>
					</div>

					<div class="heading-error-otp">
						<?php
						session_start();
						if (isset($_GET['pesan'])) {
							if ($_GET['pesan'] == "validasi") {
								$validasi = $_SESSION['validasi'];
								foreach ($validasi as $value) {
									echo "<p class='subheading-error-otp'>$value</p>";
								}
							}
						}
						?>
					</div>

					<form action="cek_otp.php" method="post">
						<div class="input-otp">
							<?php //Kondisi untuk login
							if (isset($_GET['akses'])) {
							?>
								<input type="text" name="akses" value="<?= $_GET['akses'] ?>" hidden>
							<?php
							}
							?>
							<input type="text" class="kodeotp <?php if (!empty($validasi['otp1'])) {
																	echo "kodeotp-error";
																} ?>" name="otp1" value="" maxlength="1" autofocus style="font-size:large;font-weight:bold;">
							<input type="text" class="kodeotp <?php if (!empty($validasi['otp2'])) {
																	echo "kodeotp-error";
																} ?>" name="otp2" value="" maxlength="1" autofocus style="font-size:large;font-weight:bold;">
							<input type="text" class="kodeotp <?php if (!empty($validasi['otp3'])) {
																	echo "kodeotp-error";
																} ?>" name="otp3" value="" maxlength="1" autofocus style="font-size:large;font-weight:bold;">
							<input type="text" class="kodeotp <?php if (!empty($validasi['otp4'])) {
																	echo "kodeotp-error";
																} ?>" name="otp4" value="" maxlength="1" autofocus style="font-size:large;font-weight:bold;">
						</div>
						<div class="btn-kirim-otp">
							<input type="submit" name="btn-submit-otp" class="btn-submit-otp" value="Kirim">
						</div>
					</form>
					<div style="font-size:0.9rem;margin-top: 20px;padding: 10px;">
						<span>Kamu belum memperoleh OTP Kamibox?</span>
						<?php
						if (isset($_GET['akses'])) {
						?>
							<p>Jika masih terkendala, coba login kembali <a href="login.php" style="color:blue;font-weight: 600;">klik disini</a></p>
						<?php
						} else {
						?>
							<p>Jika masih terkendala <a href="aktifkan_akun_via_otp.php" style="color:blue;font-weight: 600;">klik disini</a> untuk memperoleh bantuan dari kami.</p>
						<?php
						}
						?>
					</div>

				</div>

			</div><br /><br />
		</section>



		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="assets/js/main.js"></script>

	</body>

	</html>

<?php } ?>